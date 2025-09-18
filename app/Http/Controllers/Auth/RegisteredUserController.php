<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Rw; 
use App\Models\Rt;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $rws = Rw::all();
        $rts = Rt::all();
        return view('auth.register', compact('rws', 'rts'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Tambahkan validasi untuk field baru
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'digits:16', 'unique:'.User::class],
            'rw_id' => ['required', 'integer', 'exists:rws,id'],
            'rt_id' => ['required', 'integer', 'exists:rts,id'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'numeric', 'digits_between:10,15'],
            'alamat' => ['required', 'string', 'max:255'],
        ]);

        // Tambahkan field baru saat membuat user
        $user = User::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'rw_id' => $request->rw_id,
            'rt_id' => $request->rt_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'alamat' => $request->alamat,
            // 'role' akan otomatis 'warga' sesuai nilai default di migrasi Anda
        ]);

        $user->resident()->create([
            'name' => $user->name,
            'nik' => $user->nik,
            'rw_id' => $user->rw_id,
            'rt_id' => $user->rt_id,
            'phone' => $user->phone,
            'address' => $user->alamat,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
