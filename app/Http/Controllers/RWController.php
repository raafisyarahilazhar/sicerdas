<?php

namespace App\Http\Controllers;

use App\Models\RW;
use Illuminate\Http\Request;

class RWController extends Controller
{
    public function index()
    {
        $rws = RW::all();
        return view('rw.index', compact('rws'));
    }

    public function create()
    {
        return view('rw.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_rw' => 'required|string|max:10',
            'nama_ketua' => 'nullable|string|max:255',
        ]);

        RW::create($request->all());
        return redirect()->route('rw.index')->with('success', 'Data RW berhasil ditambahkan.');
    }

    public function edit(RW $rw)
    {
        return view('rw.edit', compact('rw'));
    }

    public function update(Request $request, RW $rw)
    {
        $request->validate([
            'nomor_rw' => 'required|string|max:10',
            'nama_ketua' => 'nullable|string|max:255',
        ]);

        $rw->update($request->all());
        return redirect()->route('rw.index')->with('success', 'Data RW berhasil diperbarui.');
    }

    public function destroy(RW $rw)
    {
        $rw->delete();
        return redirect()->route('rw.index')->with('success', 'Data RW berhasil dihapus.');
    }
}
