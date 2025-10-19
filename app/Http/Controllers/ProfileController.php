<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use App\Models\Rt;
use App\Models\Rw;
use App\Models\Resident;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'rts'  => Rt::with('rw')->orderBy('rw_id')->orderBy('id')->get(),
            'rws'  => Rw::orderBy('id')->get(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $user = $request->user();

        // --- 1) Update USERS
        $user->fill(Arr::only($validated, ['name','nik','email','phone','alamat','rt_id','rw_id']));
        if ($user->isDirty('email')) $user->email_verified_at = null;
        $user->save();

        // --- 2) Siapkan payload residents
        // Checkbox: pastikan selalu 0/1 (di form tambahkan <input type="hidden" name="disability_status" value="0">)
        $disability = array_key_exists('disability_status', $validated)
            ? (int) (bool) $validated['disability_status'] : null;

        $residentPayload = Arr::only($validated, [
            'birth_date','gender','kk_number','education_level','occupation','religion',
            'marital_status','income_bracket','blood_type','citizenship','lat','lng',
        ]);

        // kolom umum yang mencerminkan user
        $residentPayload['name']    = $user->name;
        $residentPayload['phone']   = $user->phone;
        $residentPayload['address'] = $user->alamat;
        $residentPayload['rw_id']   = $user->rw_id;
        $residentPayload['rt_id']   = $user->rt_id;

        if (!empty($validated['nik'])) {
            $residentPayload['nik'] = $validated['nik'];
        }
        if (!is_null($disability)) {
            $residentPayload['disability_status'] = $disability; // 0/1
        }

        // --- 3) Update atau buat residents (kalau belum ada)
        // Catatan: kalau tabel residents mensyaratkan nik/rt_id/rw_id NOT NULL saat CREATE,
        // pastikan nilai-nilai itu sudah ada sebelum create (umumnya user sudah punya resident).
        $resident = $user->resident;

        if ($resident) {
            // validasi unik NIK di residents (abaikan record sendiri)
            if (isset($residentPayload['nik']) && $residentPayload['nik'] !== $resident->nik) {
                $exists = Resident::where('nik', $residentPayload['nik'])
                    ->where('id', '!=', $resident->id)
                    ->exists();
                if ($exists) {
                    return back()->withErrors(['nik' => 'NIK sudah terdaftar di data penduduk.'])->withInput();
                }
            }
            $resident->fill($residentPayload);
            $resident->save();
        } else {
            // Jika perlu create, pastikan field wajib ada
            // (ubah sesuai constraint migrasi kamu: nik/rt_id/rw_id biasanya wajib)
            if (empty($residentPayload['nik']) || empty($residentPayload['rt_id']) || empty($residentPayload['rw_id'])) {
                // Tidak cukup data untuk create — lewati tanpa error, atau kembalikan pesan.
                // return back()->withErrors(['resident' => 'Lengkapi NIK, RT, dan RW untuk membuat data penduduk.'])->withInput();
            } else {
                Resident::updateOrCreate(
                    ['user_id' => $user->id],
                    $residentPayload
                );
            }
        }

        return redirect()->route('profile.edit')->with('status','profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', ['password' => ['required','current_password']]);
        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::to('/');
    }
}
