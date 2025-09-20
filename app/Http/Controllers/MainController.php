<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;  

class MainController extends Controller
{
   public function index()
   {
    $berita = Berita::whereNotNull('published_at')
                        ->latest('published_at')
                        ->paginate(3);
       return view('welcome', compact('berita'));
   }

   public function berita()
   {
    $berita = Berita::whereNotNull('published_at')
                        ->latest('published_at')
                        ->paginate(3);
       return view('berita.index', compact('berita'));
   }
}
