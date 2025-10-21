<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Application;
use App\Models\Resident;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $r)
    {
        $user = Auth::user();

        // 1) WARGA: langsung ke daftar permohonan milik sendiri
        if ($user->role === 'warga') {
            $residentId = optional($user->resident)->id;
            $applications = $residentId
                ? Application::where('resident_id', $residentId)->latest()->get()
                : collect(); // kalau belum ada resident
            return view('applications.index', compact('applications'));
        }

        // 2) Base query demografi: dibatasi dulu oleh role
        $base = Resident::query();
        if ($user->role === 'rt') {
            $base->where('rw_id', $user->rw_id)->where('rt_id', $user->rt_id);
        } elseif ($user->role === 'rw') {
            $base->where('rw_id', $user->rw_id);
        } // kades/operator/admin: tanpa batasan

        // 3) Tambahkan filter RW/RT dari request (tidak boleh melebihi hak akses)
        if ($r->filled('rw_id')) {
            // jika RT, tidak boleh melihat RW lain
            if ($user->role === 'rt' && (int)$r->rw_id !== (int)$user->rw_id) {
                abort(403, 'Tidak diizinkan melihat RW lain.');
            }
            // jika RW, boleh mempersempit ke RT tertentu, tapi tetap pada RW-nya
            if ($user->role === 'rw' && (int)$r->rw_id !== (int)$user->rw_id) {
                abort(403, 'Tidak diizinkan melihat RW lain.');
            }
            $base->where('rw_id', $r->rw_id);
        }
        if ($r->filled('rt_id')) {
            // jika RT, tidak boleh melihat RT lain
            if ($user->role === 'rt' && (int)$r->rt_id !== (int)$user->rt_id) {
                abort(403, 'Tidak diizinkan melihat RT lain.');
            }
            $base->where('rt_id', $r->rt_id);
        }

        // 4) Hitung agregat demografi dari $base (sudah aman)
        $total = (clone $base)->count();

        $gender = (clone $base)
            ->select('gender', DB::raw('count(*) c'))
            ->groupBy('gender')->pluck('c', 'gender');

        $age = (clone $base)->selectRaw("
            SUM(CASE WHEN birth_date IS NULL THEN 0
                WHEN TIMESTAMPDIFF(YEAR,birth_date,CURDATE()) BETWEEN 0 AND 5 THEN 1 ELSE 0 END) as a_0_5,
            SUM(CASE WHEN TIMESTAMPDIFF(YEAR,birth_date,CURDATE()) BETWEEN 6 AND 12 THEN 1 ELSE 0 END) as a_6_12,
            SUM(CASE WHEN TIMESTAMPDIFF(YEAR,birth_date,CURDATE()) BETWEEN 13 AND 17 THEN 1 ELSE 0 END) as a_13_17,
            SUM(CASE WHEN TIMESTAMPDIFF(YEAR,birth_date,CURDATE()) BETWEEN 18 AND 59 THEN 1 ELSE 0 END) as a_18_59,
            SUM(CASE WHEN TIMESTAMPDIFF(YEAR,birth_date,CURDATE()) >= 60 THEN 1 ELSE 0 END) as a_60p
        ")->first();

        $edu = (clone $base)->select('education_level', DB::raw('count(*) c'))
            ->groupBy('education_level')->pluck('c', 'education_level');

        $relig = (clone $base)->select('religion', DB::raw('count(*) c'))
            ->groupBy('religion')->pluck('c', 'religion');

        $workTop = (clone $base)->select('occupation', DB::raw('count(*) c'))
            ->groupBy('occupation')->orderByDesc('c')->limit(10)->get();

        // 5) Data dashboard lain (sesuai role) + kirim agregat demografi ke view
        switch ($user->role) {
            case 'rt':
                $applications = Application::whereHas('resident', function ($q) use ($user) {
                        $q->where('rt_id', $user->rt_id)->where('rw_id', $user->rw_id);
                    })->where('status', 'pending_rt')->get();

                $residents = (clone $base)->get(); // sudah terbatas RT/RW
                $history = Application::whereHas('resident', function ($q) use ($user) {
                        $q->where('rt_id', $user->rt_id)->where('rw_id', $user->rw_id);
                    })->latest()->take(10)->get();

                return view('dashboard.index', compact(
                    'applications', 'residents', 'history',
                    'total','gender','age','edu','relig','workTop'
                ));

            case 'rw':
                $applications = Application::whereHas('resident', function ($q) use ($user) {
                        $q->where('rw_id', $user->rw_id);
                    })->where('status', 'pending_rw')->get();

                $residents = (clone $base)->get(); // terbatas RW
                $history = Application::whereHas('resident', function ($q) use ($user) {
                        $q->where('rw_id', $user->rw_id);
                    })->latest()->take(10)->get();

                return view('dashboard.index', compact(
                    'applications', 'residents', 'history',
                    'total','gender','age','edu','relig','workTop'
                ));

            case 'kades':
            case 'operator':
                $applications = Application::all();
                $residents = (clone $base)->get(); // bisa semua, atau difilter via request
                $history = Application::latest()->take(10)->get();

                return view('dashboard.index', compact(
                    'applications', 'residents', 'history',
                    'total','gender','age','edu','relig','workTop'
                ));

            case 'admin':
                $applications = Application::all();
                $residents = (clone $base)->get();
                $history = Application::latest()->take(10)->get();
                $users = User::latest()->take(10)->get();

                return view('dashboard.index', compact(
                    'applications', 'residents', 'history', 'users',
                    'total','gender','age','edu','relig','workTop'
                ));

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

    public function detailDataWarga(Resident $resident)
    {
        $user = Auth::user();

        // Batasi akses sesuai peran
        if ($user->role === 'rt') {
            if ($resident->rw_id !== $user->rw_id || $resident->rt_id !== $user->rt_id) {
                abort(403, 'Anda tidak diizinkan mengakses data warga di luar RT Anda.');
            }
        } elseif ($user->role === 'rw') {
            if ($resident->rw_id !== $user->rw_id) {
                abort(403, 'Anda tidak diizinkan mengakses data warga di luar RW Anda.');
            }
        }
        // kades/operator/admin: full access

        // Eager load relasi untuk tampilan
        $resident->load(['rt', 'rw', 'applications.applicationType']);

        return view('dashboard.manajemen-warga-detail', compact('resident'));
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