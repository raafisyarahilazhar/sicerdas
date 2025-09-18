<?php

namespace App\Http\Controllers;

use App\Models\ApplicationType;
use Illuminate\Http\Request;

class ApplicationTypeController extends Controller
{
    public function index()
    {
        $applicationTypes = ApplicationType::all();
        return view('application_types.index', compact('applicationTypes'));
    }

    public function create()
    {
        return view('application_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_surat' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        ApplicationType::create($request->all());
        return redirect()->route('application_types.index')->with('success', 'Template surat berhasil ditambahkan.');
    }

    public function edit(ApplicationType $ApplicationType)
    {
        return view('application_types.edit', compact('ApplicationType'));
    }

    public function update(Request $request, ApplicationType $ApplicationType)
    {
        $request->validate([
            'nama_surat' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $ApplicationType->update($request->all());
        return redirect()->route('application_types.index')->with('success', 'Template surat berhasil diperbarui.');
    }

    public function requirements($applicationTypeId)
    {
        $applicationType = ApplicationType::with('requirements')->findOrFail($applicationTypeId);

        return response()->json($applicationType->requirements);
    }


    public function destroy(ApplicationType $ApplicationType)
    {
        $ApplicationType->delete();
        return redirect()->route('application_types.index')->with('success', 'Template surat berhasil dihapus.');
    }
}
