<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;

class ApplicationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'warga') {
            $applications = Application::where('resident_id', $user->resident->id)
                ->with('applicationType', 'resident')->latest()->get();
        } else {
            $applications = Application::with('applicationType', 'resident')->latest()->get();
        }
        return view('applications.index', compact('applications'));
    }

    public function create()
    {
        $applicationTypes = ApplicationType::orderBy('name')->get();
        return view('applications.create', compact('applicationTypes'));
    }

    public function store(Request $request)
    {
        $type = ApplicationType::findOrFail($request->application_type_id);
        $rules = [];
        $fieldData = $request->input('fields', []);

        if ($type->requirements) {
            foreach ($type->requirements as $field) {
                $fieldName = $field['name'];
                $isRequired = $field['required'] ?? false;
                $rule = $isRequired ? 'required' : 'nullable';
                if ($field['type'] === 'file') {
                    $rule .= '|file|mimes:jpg,jpeg,png,pdf|max:2048';
                } else {
                    $rule .= '|string';
                }
                $rules['fields.' . $fieldName] = $rule;
            }
        }

        $request->validate($rules);
        $dataToStore = [];
        if ($type->requirements) {
            foreach ($type->requirements as $field) {
                $fieldName = $field['name'];
                if ($field['type'] === 'file' && $request->hasFile('fields.' . $fieldName)) {
                    $path = $request->file('fields.' . $fieldName)->store('application_documents', 'public');
                    $dataToStore[$fieldName] = $path;
                } else {
                    $dataToStore[$fieldName] = $fieldData[$fieldName] ?? null;
                }
            }
        }

        Application::create([
            'resident_id' => auth()->user()->resident->id,
            'application_type_id' => $type->id,
            'form_data' => $dataToStore,
            'status' => 'pending_rt'
        ]);

        return redirect()->route('tracking.index')->with('success', 'Pengajuan berhasil diajukan');
    }

    public function show(Application $application)
    {
        return view('applications.show', compact('application'));
    }

    /**
     * Generate surat dari template Word (.docx) dan konversi ke PDF.
     * Versi ini TIDAK menggunakan QR Code atau TTE.
     */
    public function generatePdf(Application $application)
    {
        if ($application->status !== 'approved') {
            return back()->with('error', 'Surat belum disetujui atau ditolak.');
        }

        $tempDocxPath = null; // Inisialisasi untuk pembersihan jika error

        try {
            // 1. Konfigurasi PDF Renderer
            Settings::setPdfRendererName(Settings::PDF_RENDERER_DOMPDF);
            Settings::setPdfRendererPath(base_path('vendor/dompdf/dompdf'));

            $templatePath = $application->applicationType->template_file;
            if (!$templatePath || !Storage::disk('public')->exists($templatePath)) {
                return back()->with('error', 'Template Word (.docx) untuk surat ini tidak ditemukan.');
            }
            
            // 2. Proses Template Word
            $templateProcessor = new TemplateProcessor(Storage::disk('public')->path($templatePath));
            
            $resident = $application->resident;
            $formData = $application->form_data;
            
            // Mengisi placeholder data pemohon dan isian form
            $templateProcessor->setValue('resident_name', $resident->name ?? '-');
            $templateProcessor->setValue('resident_nik', $resident->nik ?? '-');
            $templateProcessor->setValue('resident_address', $resident->address ?? '-');
            $templateProcessor->setValue('resident_phone', $resident->phone ?? '-');
            $templateProcessor->setValue('resident_place_of_birth', $resident->place_of_birth ?? '-');
            $templateProcessor->setValue('resident_date_of_birth', $resident->birth_date ? $resident->birth_date->isoFormat('D MMMM YYYY') : '-');
            $templateProcessor->setValue('resident_gender', $resident->gender == 'L' ? 'Laki-laki' : 'Perempuan');
            
            if (is_array($formData)) {
                foreach ($formData as $key => $value) {
                    $templateProcessor->setValue($key, strip_tags($value ?? '-'));
                }
            }
            
            $templateProcessor->setValue('nomor_surat', $application->ref_number);
            $templateProcessor->setValue('tanggal_surat', now()->isoFormat('D MMMM YYYY'));
            
            // 3. Proses Konversi ke PDF
            $tempDocxDir = storage_path('app/public/temp_docs');
            if (!file_exists($tempDocxDir)) mkdir($tempDocxDir, 0755, true);
            $tempDocxPath = $tempDocxDir . '/temp-' . $application->ref_number . '.docx';
            $templateProcessor->saveAs($tempDocxPath);
            
            $phpWord = IOFactory::load($tempDocxPath);
            
            $pdfFilename = 'surat-' . $application->ref_number . '.pdf';
            $pdfOutputPath = 'surat_jadi/' . $pdfFilename;
            
            $pdfWriter = IOFactory::createWriter($phpWord, 'PDF');
            $pdfWriter->save(Storage::disk('public')->path($pdfOutputPath));

            // 4. Pembersihan & Penyimpanan
            unlink($tempDocxPath); // Hapus file .docx sementara
            
            $application->update(['pdf_path' => $pdfOutputPath]);
            
            return Storage::disk('public')->download($pdfOutputPath);

        } catch (\Exception $e) {
            if($tempDocxPath && file_exists($tempDocxPath)) unlink($tempDocxPath);
            
            Log::error('PDF Generation Failed: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return back()->with('error', 'Gagal membuat file PDF: ' . $e->getMessage());
        }
    }

    /**
     * Download file surat yang sudah dibuat.
     */
    public function downloadPdf(Application $application)
    {
        if (auth()->user()->role === 'warga' && auth()->id() !== $application->resident->user_id) {
             abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
        }

        if (!$application->pdf_path || !Storage::disk('public')->exists($application->pdf_path)) {
            return back()->with('error', 'File surat tidak ditemukan. Silakan buat ulang file.');
        }

        return Storage::disk('public')->download($application->pdf_path);
    }
}