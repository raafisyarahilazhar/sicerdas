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
        return view('dashboard.rt.index', compact('rts'));
    }

    public function create(rt $rt)
    {
        $rws = RW::all();
        return view('dashboard.rt.create', compact('rt', 'rws'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rw_id' => 'required|exists:rws,id',
            'name' => 'required|string|max:10',
            'nomor_rt' => 'required|integer|max:10',
        ]);

        RT::create($request->all());
        return redirect()->route('rts.index')->with('success', 'Data RT berhasil ditambahkan.');
    }

    public function edit(RT $rt)
    {
        $rws = RW::all();
        return view('dashboard.rt.edit', compact('rt', 'rws'));
    }

    public function update(Request $request, RT $rt)
    {
        $request->validate([
            'rw_id' => 'required|exists:rws,id',
            'name' => 'required|string|max:10',
            'nomor_rt' => 'required|integer|max:10',
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
