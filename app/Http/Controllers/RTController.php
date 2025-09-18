<?php

namespace App\Http\Controllers;

use App\Models\RT;
use App\Models\RW;
use Illuminate\Http\Request;

class RTController extends Controller
{
    public function index()
    {
        $rts = RT::with('rw')->get();
        return view('rts.index', compact('rts'));
    }

    public function create()
    {
        $rws = RW::all();
        return view('rts.create', compact('rws'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_rt' => 'required|string|max:10',
            'rw_id' => 'required|exists:rws,id',
        ]);

        RT::create($request->all());
        return redirect()->route('rts.index')->with('success', 'Data RT berhasil ditambahkan.');
    }

    public function edit(RT $rt)
    {
        $rws = RW::all();
        return view('rts.edit', compact('rt', 'rws'));
    }

    public function update(Request $request, RT $rt)
    {
        $request->validate([
            'nomor_rt' => 'required|string|max:10',
            'rw_id' => 'required|exists:rws,id',
        ]);

        $rt->update($request->all());
        return redirect()->route('rts.index')->with('success', 'Data RT berhasil diperbarui.');
    }

    public function destroy(RT $rt)
    {
        $rt->delete();
        return redirect()->route('rts.index')->with('success', 'Data RT berhasil dihapus.');
    }
}
