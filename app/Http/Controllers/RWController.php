<?php

namespace App\Http\Controllers;

use App\Models\RW;
use Illuminate\Http\Request;

class RWController extends Controller
{
    public function index()
    {
        $rws = RW::all();
        return view('dashboard.rw.index', compact('rws'));
    }

    public function create()
    {
        return view('dashboard.rw.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'nomor_rw' => 'required|integer|max:10',
        ]);

        RW::create($request->all());
        return redirect()->route('rws.index')->with('success', 'Data RW berhasil ditambahkan.');
    }

    public function edit(RW $rw)
    {
        return view('dashboard.rw.edit', compact('rw'));
    }

    public function update(Request $request, RW $rw)
    {
        $request->validate([
            'name' => 'required|string|max:10',
            'nomor_rw' => 'required|integer|max:10',
        ]);

        $rw->update($request->all());
        return redirect()->route('rws.index')->with('success', 'Data RW berhasil diperbarui.');
    }

    public function destroy(RW $rw)
    {
        $rw->delete();
        return redirect()->route('rws.index')->with('success', 'Data RW berhasil dihapus.');
    }
}
