<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BeritaController extends Controller
{
    // --- METHOD UNTUK PUBLIK / WARGA ---

    /**
     * Menampilkan daftar semua berita yang sudah dipublikasikan untuk warga.
     */
    public function index()
    {
        $berita = Berita::whereNotNull('published_at')
                        ->latest('published_at')
                        ->paginate(3);
                        
        return view('berita.index', compact('berita'));
    }

    /**
     * Menampilkan detail satu berita untuk warga.
     */
    public function show(Berita $berita)
    {
        // Pastikan warga hanya bisa melihat berita yang sudah publish
        if (!$berita->published_at) {
            abort(404);
        }
        return view('berita.show', compact('berita'));
    }

    /**
     * Menampilkan form untuk membuat berita baru.
     */
    public function create()
    {
        return view('berita.create');
    }

    /**
     * Menyimpan berita baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:beritas,title',
            'content' => 'required|string',
            'author' => 'required|string',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'publish' => 'nullable|boolean',
        ]);

        $data = [
            'title' => $validated['title'],
            'content' => $validated['content'],
            'author' => $validated['author'],
            'published_at' => isset($validated['publish']) ? now() : null,
        ];

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('berita_images', 'public');
            $data['image_path'] = $path;
        }

        Berita::create($data);

        return redirect()->route('dashboard.manajemen-konten')->with('success', 'Berita berhasil dibuat.');
    }

    /**
     * Menampilkan form untuk mengedit berita.
     */
    public function edit(Berita $berita)
    {
        return view('berita.edit', compact('berita'));
    }

    /**
     * Memperbarui data berita di database.
     */
    public function update(Request $request, Berita $berita)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255', Rule::unique('beritas')->ignore($berita->id)],
            'content' => 'required|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'publish' => 'nullable|boolean',
        ]);

        $data = [
            'title' => $validated['title'],
            'content' => $validated['content'],
            'published_at' => isset($validated['publish']) ? ($berita->published_at ?? now()) : null,
        ];

        if ($request->hasFile('image_path')) {
            // Hapus gambar lama jika ada
            if ($berita->image_path) {
                Storage::disk('public')->delete($berita->image_path);
            }
            $path = $request->file('image_path')->store('berita_images', 'public');
            $data['image_path'] = $path;
        }

        $berita->update($data);

        return redirect()->route('dashboard.manajemen-konten')->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Menghapus berita dari database.
     */
    public function destroy(Berita $berita)
    {
        if ($berita->image_path) {
            Storage::disk('public')->delete($berita->image_path);
        }
        $berita->delete();
        
        return redirect()->route('dashboard.manajemen-konten')->with('success', 'Berita berhasil dihapus.');
    }
}