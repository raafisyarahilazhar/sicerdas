<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use App\Models\Resident;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'warga':
                $applications = Application::where('resident_id', $user->resident_id)->get();
                return view('applications.index', compact('applications'));

            case 'rt':
                $applications = Application::whereHas('resident', function($q) use ($user) {
                        $q->where('rt_id', $user->rt_id)
                        ->where('rw_id', $user->rw_id);
                    })
                    ->where('status', 'pending_rt')
                    ->get();

                $residents = Resident::where('rt_id', $user->rt_id)
                    ->where('rw_id', $user->rw_id)
                    ->get();

                // 🔥 Ambil history 10 permohonan terakhir
                $history = Application::whereHas('resident', function($q) use ($user) {
                        $q->where('rt_id', $user->rt_id)
                        ->where('rw_id', $user->rw_id);
                    })
                    ->latest()
                    ->take(10)
                    ->get();

                return view('dashboard.index', compact('applications', 'residents', 'history'));

            case 'rw':
                $applications = Application::whereHas('resident', function($q) use ($user) {
                        $q->where('rw_id', $user->rw_id);
                    })
                    ->where('status', 'pending_rw')
                    ->get();

                $residents = Resident::where('rw_id', $user->rw_id)->get();

                $history = Application::whereHas('resident', function($q) use ($user) {
                        $q->where('rw_id', $user->rw_id);
                    })
                    ->latest()
                    ->take(10)
                    ->get();

                return view('dashboard.index', compact('applications', 'residents', 'history'));

            case 'kades':
                $applications = Application::where('status', 'pending_kades')->get();
                $residents = Resident::all();
                $history = Application::latest()->take(10)->get();

                return view('dashboard.index', compact('applications', 'residents', 'history'));

            case 'operator':
                $applications = Application::all();
                $residents = Resident::all();
                $history = Application::latest()->take(10)->get();

                return view('dashboard.index', compact('applications', 'residents', 'history'));

            case 'admin':
                $applications = Application::all();
                $residents = Resident::all();
                $history = Application::latest()->take(10)->get();

                return view('dashboard.index', compact('applications', 'residents', 'history'));

            default:
                return view('dashboard.default');
        }
    }

    public function dataWarga()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'warga':
                $applications = Application::where('resident_id', $user->resident_id)->get();
                return view('applications.index', compact('applications'));

            case 'rt':
                $applications = Application::whereHas('resident', function($q) use ($user) {
                        $q->where('rt_id', $user->rt_id)
                        ->where('rw_id', $user->rw_id);
                    })
                    ->where('status', 'pending_rt')
                    ->get();

                $residents = Resident::where('rt_id', $user->rt_id)
                    ->where('rw_id', $user->rw_id)
                    ->get();

                // 🔥 Ambil history 10 permohonan terakhir
                $history = Application::whereHas('resident', function($q) use ($user) {
                        $q->where('rt_id', $user->rt_id)
                        ->where('rw_id', $user->rw_id);
                    })
                    ->latest()
                    ->take(10)
                    ->get();

                return view('dashboard.manajemen-warga', compact('applications', 'residents', 'history'));

            case 'rw':
                $applications = Application::whereHas('resident', function($q) use ($user) {
                        $q->where('rw_id', $user->rw_id);
                    })
                    ->where('status', 'pending_rw')
                    ->get();

                $residents = Resident::where('rw_id', $user->rw_id)->get();

                $history = Application::whereHas('resident', function($q) use ($user) {
                        $q->where('rw_id', $user->rw_id);
                    })
                    ->latest()
                    ->take(10)
                    ->get();

                return view('dashboard.manajemen-warga', compact('applications', 'residents', 'history'));

            case 'kades':
                $applications = Application::where('status', 'pending_kades')->get();
                $residents = Resident::all();
                $history = Application::latest()->take(10)->get();

                return view('dashboard.manajemen-warga', compact('applications', 'residents', 'history'));

            case 'operator':
                $applications = Application::all();
                $residents = Resident::all();
                $history = Application::latest()->take(10)->get();

                return view('dashboard.manajemen-warga', compact('applications', 'residents', 'history'));

            case 'admin':
                $applications = Application::all();
                $residents = Resident::all();
                $history = Application::latest()->take(10)->get();

                return view('dashboard.manajemen-warga', compact('applications', 'residents', 'history'));

            default:
                return view('dashboard.default');
        }
    }

    public function dataPermohonan()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'warga':
                $applications = Application::where('resident_id', $user->resident_id)->get();
                return view('/', compact('applications'));

            case 'rt':
                $applications = Application::whereHas('resident', function($q) use ($user) {
                        $q->where('rt_id', $user->rt_id)
                        ->where('rw_id', $user->rw_id);
                    })
                    ->where('status', 'pending_rt')
                    ->get();

                $residents = Resident::where('rt_id', $user->rt_id)
                    ->where('rw_id', $user->rw_id)
                    ->get();

                // 🔥 Ambil history 10 permohonan terakhir
                $history = Application::whereHas('resident', function($q) use ($user) {
                        $q->where('rt_id', $user->rt_id)
                        ->where('rw_id', $user->rw_id);
                    })
                    ->latest()
                    ->take(10)
                    ->get();

                return view('dashboard.manajemen-permohonan', compact('applications', 'residents', 'history'));

            case 'rw':
                $applications = Application::whereHas('resident', function($q) use ($user) {
                        $q->where('rw_id', $user->rw_id);
                    })
                    ->where('status', 'pending_rw')
                    ->get();

                $residents = Resident::where('rw_id', $user->rw_id)->get();

                $history = Application::whereHas('resident', function($q) use ($user) {
                        $q->where('rw_id', $user->rw_id);
                    })
                    ->latest()
                    ->take(10)
                    ->get();

                return view('dashboard.manajemen-permohonan', compact('applications', 'residents', 'history'));

            case 'kades':
                $applications = Application::where('status', 'pending_kades')->get();
                $residents = Resident::all();
                $history = Application::latest()->take(10)->get();

                return view('dashboard.manajemen-permohonan', compact('applications', 'residents', 'history'));

            case 'operator':
                $applications = Application::all();
                $residents = Resident::all();
                $history = Application::latest()->take(10)->get();

                return view('dashboard.manajemen-permohonan', compact('applications', 'residents', 'history'));

            case 'admin':
                $applications = Application::all();
                $residents = Resident::all();
                $history = Application::latest()->take(10)->get();

                return view('dashboard.manajemen-permohonan', compact('applications', 'residents', 'history'));

            default:
                return view('dashboard.default');
        }
    }

    public function dataSurat()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'warga':
                $applications = Application::where('resident_id', $user->resident_id)->get();
                return view('/', compact('applications'));

            case 'rt':
                $applications = Application::whereHas('resident', function($q) use ($user) {
                        $q->where('rt_id', $user->rt_id)
                        ->where('rw_id', $user->rw_id);
                    })
                    ->where('status', 'pending_rt')
                    ->get();

                $residents = Resident::where('rt_id', $user->rt_id)
                    ->where('rw_id', $user->rw_id)
                    ->get();

                // 🔥 Ambil history 10 permohonan terakhir
                $history = Application::whereHas('resident', function($q) use ($user) {
                        $q->where('rt_id', $user->rt_id)
                        ->where('rw_id', $user->rw_id);
                    })
                    ->latest()
                    ->take(10)
                    ->get();

                return view('dashboard.manajemen-surat', compact('applications', 'residents', 'history'));

            case 'rw':
                $applications = Application::whereHas('resident', function($q) use ($user) {
                        $q->where('rw_id', $user->rw_id);
                    })
                    ->where('status', 'pending_rw')
                    ->get();

                $residents = Resident::where('rw_id', $user->rw_id)->get();

                $history = Application::whereHas('resident', function($q) use ($user) {
                        $q->where('rw_id', $user->rw_id);
                    })
                    ->latest()
                    ->take(10)
                    ->get();

                return view('dashboard.manajemen-surat', compact('applications', 'residents', 'history'));

            case 'kades':
                $applications = Application::where('status', 'pending_kades')->get();
                $residents = Resident::all();
                $history = Application::latest()->take(10)->get();

                return view('dashboard.manajemen-surat', compact('applications', 'residents', 'history'));

            case 'operator':
                $applications = Application::all();
                $residents = Resident::all();
                $history = Application::latest()->take(10)->get();

                return view('dashboard.manajemen-surat', compact('applications', 'residents', 'history'));

            case 'admin':
                $applications = Application::all();
                $residents = Resident::all();
                $history = Application::latest()->take(10)->get();

                return view('dashboard.manajemen-surat', compact('applications', 'residents', 'history'));

            default:
                return view('dashboard.default');
        }
    }
}