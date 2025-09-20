<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor; // <-- PENTING: Gunakan library PHPWord

class ApplicationController extends Controller
{
    public function index()
    {
        // Ambil data aplikasi sesuai peran pengguna
        $user = Auth::user();
        if ($user->role === 'warga') {
            $applications = Application::where('resident_id', $user->resident->id)
                ->with('applicationType', 'resident')
                ->latest()
                ->get();
        } else {
            // Untuk peran lain (admin, dll.), tampilkan semua
            $applications = Application::with('applicationType', 'resident')
                ->latest()
                ->get();
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
                $rule = $field['required'] ? 'required' : 'nullable';
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
     * Generate surat dari template Word (.docx).
     */
    public function generatePdf(Application $application)
    {
        if ($application->status !== 'approved') {
            return back()->with('error', 'Surat belum disetujui atau ditolak.');
        }

        try {
            // 1. Ambil path template .docx dari database
            $templatePath = $application->applicationType->template_file;

            if (!$templatePath || !Storage::disk('public')->exists($templatePath)) {
                return back()->with('error', 'Template Word (.docx) untuk jenis surat ini tidak ditemukan.');
            }

            // 2. Buat instance TemplateProcessor dari PHPWord
            $templateProcessor = new TemplateProcessor(Storage::disk('public')->path($templatePath));

            // 3. Ambil data yang dibutuhkan
            $resident = $application->resident;
            $formData = $application->form_data;

            // 4. Ganti placeholder dari data pemohon (resident)
            $templateProcessor->setValue('resident_name', $resident->name ?? '');
            $templateProcessor->setValue('resident_nik', $resident->nik ?? '');
            $templateProcessor->setValue('resident_address', $resident->address ?? '');
            $templateProcessor->setValue('resident_phone', $resident->phone ?? '');
            $templateProcessor->setValue('resident_gender', $resident->gender ?? '');
            // Tambahkan data resident lain yang Anda butuhkan (contoh: 'resident_job', dll.)

            // 5. Ganti placeholder dari data isian form
            if (is_array($formData)) {
                foreach ($formData as $key => $value) {
                    $templateProcessor->setValue($key, $value ?? '');
                }
            }
            
            // 6. Ganti placeholder sistem
            $templateProcessor->setValue('tanggal_surat', now()->isoFormat('D MMMM YYYY'));
            $templateProcessor->setValue('nomor_surat', $application->ref_number);

            // 7. Simpan hasilnya sebagai file .docx baru
            $filename = 'surat-' . $application->ref_number . '.docx'; // Ekstensi .docx
            $outputPath = 'surat_jadi/' . $filename;
            
            $templateProcessor->saveAs(storage_path('app/public/' . $outputPath));

            // 8. Update path di database
            $application->update(['pdf_path' => $outputPath]);

            return back()->with('success', 'File surat (.docx) berhasil dibuat dan disimpan!');

        } catch (\Exception $e) {
            // Tangkap error jika terjadi masalah saat memproses template
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Download file surat yang sudah dibuat (bisa .docx atau .pdf).
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