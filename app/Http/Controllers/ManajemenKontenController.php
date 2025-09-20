<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;

class ManajemenKontenController extends Controller
{
    public function index( )
    {
        $berita = Berita::latest()->paginate(10);
        return view('dashboard.manajemen-konten', compact('berita'));
    }

    // public function berita()
    // {
    //     $berita = Berita::whereNotNull('published_at')
    //                     ->latest('published_at')
    //                     ->paginate(9);
                        
    //     return view('berita.index', compact('berita'));
    // }

    // public function showBerita(Berita $berita)
    // {
    //     // Pastikan warga hanya bisa melihat berita yang sudah publish
    //     if (!$berita->published_at) {
    //         abort(404);
    //     }
    //     return view('berita.show', compact('berita'));
    // }
}
