<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $resident = $user->resident;

        if (!$resident) {
            return back()->with('error', 'Data penduduk tidak ditemukan untuk akun ini.');
        }

        $applications = $resident->applications()->latest()->get();

        return view('tracking.index', compact('applications'));
    }

}
