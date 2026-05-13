<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rt;
use App\Models\Rw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user dengan pagination.
     */
    public function index()
    {
        // Menggunakan paginate(10) untuk membatasi 10 data per halaman
        $users = User::with(['rt', 'rw'])->latest()->paginate(10);
        return view('user.index', compact('users'));
    }

    public function create()
    {
        $rts = Rt::all();
        $rws = Rw::all();
        return view('user.create', compact('rts', 'rws'));
    }

    /**
     * Simpan user baru dan otomatis buat data resident jika rolenya warga.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'nik'      => 'required|string|max:16|unique:users,nik',
            'email'    => 'nullable|email|unique:users,email',
            'phone'    => 'nullable|string|max:15',
            'alamat'   => 'nullable|string',
            'rt_id'    => 'nullable|exists:rts,id',
            'rw_id'    => 'nullable|exists:rws,id',
            'role'     => 'required|in:admin,kades,operator,rt,rw,warga',
            'password' => 'required|min:6',
        ]);

        // Simpan user ke variabel agar bisa diakses rolenya
        $user = User::create([
            'name'     => $request->name,
            'nik'      => $request->nik,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'alamat'   => $request->alamat,
            'rt_id'    => $request->rt_id,
            'rw_id'    => $request->rw_id,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        // Logika otomatis pembuatan data resident (Warga)
        if ($user->role === 'warga') {
            $user->resident()->create([
                'name'    => $user->name,
                'nik'     => $user->nik,
                'rw_id'   => $user->rw_id,
                'rt_id'   => $user->rt_id,
                'phone'   => $user->phone,
                'address' => $user->alamat,
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    public function edit(User $user)
    {
        $rts = Rt::all();
        $rws = Rw::all();
        return view('user.edit', compact('user', 'rts', 'rws'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'nik'    => 'required|string|max:16|unique:users,nik,' . $user->id,
            'email'  => 'nullable|email|unique:users,email,' . $user->id,
            'phone'  => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'rt_id'  => 'nullable|exists:rts,id',
            'rw_id'  => 'nullable|exists:rws,id',
            'role'   => 'required|in:admin,kades,operator,rt,rw,warga',
        ]);

        $data = $request->only(['name', 'nik', 'email', 'phone', 'alamat', 'rt_id', 'rw_id', 'role']);
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}