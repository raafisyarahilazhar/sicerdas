<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rt;
use App\Models\Rw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Daftar semua user
    public function index()
    {
        $users = User::with(['rt', 'rw'])->latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    // Form tambah user
    public function create()
    {
        $rts = Rt::all();
        $rws = Rw::all();
        return view('users.create', compact('rts', 'rws'));
    }

    // Simpan user baru
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'nik'    => 'required|string|max:16|unique:users,nik',
            'email'  => 'nullable|email|unique:users,email',
            'phone'  => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'rt_id'  => 'nullable|exists:rts,id',
            'rw_id'  => 'nullable|exists:rws,id',
            'role'   => 'required|in:admin,kades,operator,rt,rw,warga',
            'password' => 'required|min:6',
        ]);

        User::create([
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

        if ($user->role === 'warga') {
            $user->resident()->create([
                'name' => $user->name,
                'nik' => $user->nik,
                'rw_id' => $user->rw_id,
                'rt_id' => $user->rt_id,
                'phone' => $user->phone,
                'address' => $user->alamat,
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    // Detail user
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    // Form edit user
    public function edit(User $user)
    {
        $rts = Rt::all();
        $rws = Rw::all();
        return view('users.edit', compact('user', 'rts', 'rws'));
    }

    // Update user
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

        $data = $request->all();
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    // Hapus user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
