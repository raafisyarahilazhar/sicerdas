<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationType;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications  = Application::with('ApplicationType', 'resident')->get();
        return view('applications.index', compact('applications'));
    }

    public function create()
    {
        $applicationTypes = ApplicationType::all();
        // dd($applicationTypes->toArray()); 
        return view('applications.create', compact('applicationTypes'));
    }

    public function store(Request $request)
    {
        $type = ApplicationType::findOrFail($request->application_type_id);

        $rules = [];
        // Ambil semua data dari array 'fields' yang dikirim dari form
        $fieldData = $request->input('fields', []);

        // Generate rules validasi dinamis dari requirements
        foreach ($type->requirements as $field) {
            $fieldName = $field['name'];
            $rule = $field['required'] ? 'required' : 'nullable';

            if ($field['type'] === 'file') {
                $rule .= '|file|mimes:jpg,jpeg,png,pdf|max:2048';
            } else {
                $rule .= '|string';
            }
            
            // Targetkan validasi ke dalam array 'fields' (contoh: 'fields.nama_pemohon')
            $rules['fields.' . $fieldName] = $rule;
        }

        $request->validate($rules);

        $dataToStore = [];
        // Proses dan simpan file upload jika ada
        foreach ($type->requirements as $field) {
            $fieldName = $field['name'];

            if ($field['type'] === 'file' && $request->hasFile('fields.' . $fieldName)) {
                // Simpan file ke storage/app/public/application_documents
                $path = $request->file('fields.' . $fieldName)->store('application_documents', 'public');
                $dataToStore[$fieldName] = $path;
            } else {
                // Ambil data dari input teks, tanggal, dll.
                $dataToStore[$fieldName] = $fieldData[$fieldName] ?? null;
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

    // app/Http/Controllers/ApplicationController.php

    public function generatePdf(Application $application)
    {
        // 1. Pastikan hanya surat yang sudah disetujui yang bisa diproses
        if ($application->status !== 'approved') {
            return back()->with('error', 'Surat belum disetujui atau ditolak.');
        }

        // Jika PDF sudah pernah dibuat, langsung saja unduh
        if ($application->pdf_path && Storage::disk('public')->exists($application->pdf_path)) {
            return Storage::disk('public')->download($application->pdf_path);
        }

        // 2. Ambil data yang dibutuhkan
        $resident = $application->resident;
        $data = $application->form_data;
        
        // 3. Tentukan template Blade yang akan digunakan
        $templateName = '';
        switch ($application->applicationType->name) {
            case 'Surat Keterangan Domisili':
                $templateName = 'surat_templates.domisili';
                break;
            // Tambahkan case lain untuk jenis surat lainnya
            default:
                return back()->with('error', 'Template surat tidak ditemukan.');
        }
        
        // 4. Load view dan data, lalu ubah menjadi PDF
        $pdf = Pdf::loadView($templateName, compact('data', 'resident'));
        
        // 5. Simpan PDF ke server dan update path di database
        $filename = 'surat-' . $application->ref_number . '.pdf';
        // Simpan di dalam folder storage/app/public/surat_jadi
        Storage::disk('public')->put('surat_jadi/' . $filename, $pdf->output());

        $application->update(['pdf_path' => 'surat_jadi/' . $filename]);

        // 6. Kembalikan pengguna ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'PDF berhasil dibuat dan disimpan!');
    }
}
