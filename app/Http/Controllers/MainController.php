<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;  
use App\Models\Announcement;

class MainController extends Controller
{
   public function index()
   {
    $berita = Berita::whereNotNull('published_at')
                        ->latest('published_at')
                        ->paginate(3);
    $pengumuman = Announcement::whereNotNull('created_at')
                        ->latest('created_at')
                        ->paginate(3);
       return view('welcome', compact('berita', 'pengumuman'));
   }

   public function berita()
   {
    $berita = Berita::whereNotNull('published_at')
                        ->latest('published_at')
                        ->paginate(3);
       return view('berita.index', compact('berita'));
   }

   public function announcement()
   {
    $pengumuman = Announcement::whereNotNull('created_at')
                        ->latest('created_at')
                        ->paginate(3);
       return view('pengumuman.index', compact('pengumuman'));
   }
}
