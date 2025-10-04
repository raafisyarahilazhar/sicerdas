<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /**
     * Menangani permintaan verifikasi surat berdasarkan token dari QR Code.
     *
     * @param string $token
     * @return \Illuminate\View\View
     */
    public function verify($token)
    {
        // Cari permohonan di database berdasarkan qr_token
        $application = Application::where('qr_token', $token)
                                  ->with(['resident', 'applicationType']) // Eager load untuk efisiensi
                                  ->first();

        // Jika permohonan dengan token tersebut tidak ditemukan,
        // tampilkan halaman 'tidak valid'.
        if (!$application) {
            return view('verification.invalid');
        }

        // Jika ditemukan, tampilkan halaman 'valid' dengan data permohonan.
        return view('verification.valid', compact('application'));
    }
}