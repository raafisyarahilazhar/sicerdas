<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\User;

class ResidentController extends Controller
{
    public function index()
    {   
        $user = auth()->user();

        $query = Resident::query();

        if ($user->role === 'warga') {
            $query->where('rw_id', $user->rw_id)
                ->where('rt_id', $user->rt_id);
        } elseif ($user->role === 'rw') {
            $query->where('rw_id', $user->rw_id);
        }
        // kalau admin -> lihat semua

        $residents = $query->get();

        return view('residents.index', compact('residents'));
    }
}
