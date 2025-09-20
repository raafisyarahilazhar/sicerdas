<?php

namespace App\Http\Controllers;

use App\Models\ApplicationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ApplicationTypeController extends Controller
{
    public function index()
    {
        $applicationTypes = ApplicationType::latest()->get();
        return view('application_types.index', compact('applicationTypes'));
    }

    public function create()
    {
        return view('application_types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:application_types,name',
            'template_file' => 'required|file|mimes:docx',
            'requirements' => 'nullable|array',
            'requirements.*.label' => 'required_with:requirements.*.name|string|max:255',
            'requirements.*.name' => 'required_with:requirements.*.label|string|max:255|regex:/^[a-z_]+$/',
            'requirements.*.type' => 'required_with:requirements.*.name|in:text,date,file,textarea',
        ]);

        $data = [
            'name' => $validated['name'],
            'requirements' => array_values(array_filter($request->input('requirements', []))),
        ];

        if ($request->hasFile('template_file')) {
            $path = $request->file('template_file')->store('letter_templates', 'public');
            $data['template_file'] = $path;
        }

        ApplicationType::create($data);

        return redirect()->route('application-types.index')->with('success', 'Jenis surat berhasil dibuat.');
    }

    public function edit(ApplicationType $applicationType)
    {
        return view('application_types.edit', compact('applicationType'));
    }

    public function update(Request $request, ApplicationType $applicationType)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('application_types')->ignore($applicationType->id)],
            'template_file' => 'nullable|file|mimes:docx',
            'requirements' => 'nullable|array',
            'requirements.*.label' => 'required_with:requirements.*.name|string|max:255',
            'requirements.*.name' => 'required_with:requirements.*.label|string|max:255|regex:/^[a-z_]+$/',
            'requirements.*.type' => 'required_with:requirements.*.name|in:text,date,file,textarea',
        ]);

        $data = [
            'name' => $validated['name'],
            'requirements' => array_values(array_filter($request->input('requirements', []))),
        ];

        if ($request->hasFile('template_file')) {
            // Hapus file lama jika ada file baru yang diupload
            if ($applicationType->template_file) {
                Storage::disk('public')->delete($applicationType->template_file);
            }
            $path = $request->file('template_file')->store('letter_templates', 'public');
            $data['template_file'] = $path;
        }

        $applicationType->update($data);

        return redirect()->route('application-types.index')->with('success', 'Jenis surat berhasil diperbarui.');
    }

    public function destroy(ApplicationType $applicationType)
    {
        if ($applicationType->template_file) {
            Storage::disk('public')->delete($applicationType->template_file);
        }
        $applicationType->delete();
        return redirect()->route('application-types.index')->with('success', 'Jenis surat berhasil dihapus.');
    }
}