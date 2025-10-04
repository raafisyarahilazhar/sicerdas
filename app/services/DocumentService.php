<?php

namespace App\Services;

use App\Models\Application;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DocumentService
{
    public function generate(Application $application): bool
    {
        try {
            // Konfigurasi Renderer PDF
            Settings::setPdfRendererName(Settings::PDF_RENDERER_DOMPDF);
            Settings::setPdfRendererPath(base_path('vendor/dompdf/dompdf'));

            $templatePath = $application->applicationType->template_file;
            if (!$templatePath || !Storage::disk('public')->exists($templatePath)) {
                return false;
            }

            // --- LOGIKA QR CODE ---
            if (!$application->qr_token) {
                $application->qr_token = Str::uuid();
                $application->save();
            }
            $verificationUrl = route('document.verify', $application->qr_token);
            
            $tempQrDir = storage_path('app/public/temp_qrcodes');
            if (!file_exists($tempQrDir)) {
                mkdir($tempQrDir, 0755, true);
            }
            $qrCodePath = $tempQrDir . '/' . $application->qr_token . '.png';

            // --- PERBAIKAN DI SINI ---
            // Secara eksplisit menyuruh library menggunakan writer 'png' (yang memakai GD)
            QrCode::format('png')->writerByName('png')->size(90)->margin(1)->generate($verificationUrl, $qrCodePath);

            // --- LOGIKA TTE ---
            $ttePath = storage_path('app/signatures/tte_kades.png');
            if (!file_exists($ttePath)) {
                unlink($qrCodePath);
                return false;
            }

            // --- PROSES TEMPLATE WORD ---
            $templateProcessor = new TemplateProcessor(Storage::disk('public')->path($templatePath));
            
            $resident = $application->resident;
            $formData = $application->form_data;
            $templateProcessor->setValue('resident_name', $resident->name ?? '-');
            // ... (lanjutkan untuk placeholder lainnya) ...
            
            if (is_array($formData)) {
                foreach ($formData as $key => $value) {
                    $templateProcessor->setValue($key, strip_tags($value ?? '-'));
                }
            }
            
            $templateProcessor->setValue('nomor_surat', $application->ref_number);
            $templateProcessor->setValue('tanggal_surat', now()->isoFormat('D MMMM YYYY'));
            
            $templateProcessor->setImageValue('tte_kades', ['path' => $ttePath, 'width' => 120, 'height' => 120, 'ratio' => true]);
            $templateProcessor->setImageValue('qr_code', ['path' => $qrCodePath, 'width' => 90, 'height' => 90]);
            
            // --- PROSES KONVERSI KE PDF ---
            $tempDocxFilename = 'temp-' . $application->ref_number . '.docx';
            $tempDocxPath = storage_path('app/public/temp_docs/' . $tempDocxFilename);
            if (!file_exists(storage_path('app/public/temp_docs'))) {
                mkdir(storage_path('app/public/temp_docs'), 0755, true);
            }
            $templateProcessor->saveAs($tempDocxPath);

            $phpWord = IOFactory::load($tempDocxPath);

            $pdfFilename = 'surat-' . $application->ref_number . '.pdf';
            $pdfOutputPath = 'surat_jadi/' . $pdfFilename;
            
            $pdfWriter = IOFactory::createWriter($phpWord, 'PDF');
            $pdfWriter->save(Storage::disk('public')->path($pdfOutputPath));

            // Hapus file sementara
            unlink($tempDocxPath);
            unlink($qrCodePath);

            $application->update(['pdf_path' => $pdfOutputPath]);
            return true;

        } catch (\Exception $e) {
            // dd($e->getMessage());
            // Log::error('PDF Generation Error: ' . $e->getMessage());
            return false;
        }
    }
}