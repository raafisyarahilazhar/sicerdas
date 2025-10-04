<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use App\Services\DocumentService;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;

class ApplicationApprovalController extends Controller
{
    protected $documentService;
    protected $notificationService;

    /**
     * Inject kedua service melalui constructor
     */
    public function __construct(DocumentService $documentService, NotificationService $notificationService)
    {
        $this->documentService = $documentService;
        $this->notificationService = $notificationService;
    }

    /**
     * Menyetujui permohonan surat dan memicu proses selanjutnya.
     */
    public function approve(Request $request, Application $application)
    {
        $user = Auth::user();
        $nextStatus = null;

        // Logika alur persetujuan berjenjang
        switch ($application->status) {
            case 'pending_rt':
                if ($user->role === 'rt' && $user->rt_id === $application->resident->rt_id) {
                    $nextStatus = 'pending_rw';
                }
                break;
            case 'pending_rw':
                if ($user->role === 'rw' && $user->rw_id === $application->resident->rw_id) {
                    $nextStatus = 'pending_kades';
                }
                break;
            case 'pending_kades':
                if ($user->role === 'kades') {
                    $nextStatus = 'approved';
                }
                break;
        }

        // Admin/Operator bisa menyetujui langsung dari status apapun
        if (in_array($user->role, ['admin'])) {
             $nextStatus = 'approved';
        }

        if ($nextStatus) {
            $application->update(['status' => $nextStatus]);

            // Jika statusnya sudah 'approved', panggil service untuk membuat surat & kirim notifikasi
            if ($nextStatus === 'approved') {
                $isGenerated = $this->documentService->generate($application);

                if ($isGenerated) {
                    // Panggil service notifikasi setelah surat berhasil dibuat
                    $this->notificationService->sendSuratSelesaiNotification($application);
                    return back()->with('success', 'Persetujuan berhasil, dokumen telah dibuat dan notifikasi WhatsApp sedang dikirim.');
                } else {
                    return back()->with('error', 'Persetujuan berhasil, namun pembuatan dokumen otomatis gagal. Cek template surat.');
                }
            }

            return back()->with('success', 'Permohonan berhasil disetujui.');
        }

        return back()->with('error', 'Anda tidak memiliki izin untuk menyetujui permohonan pada tahap ini.');
    }

    /**
     * Menolak permohonan surat.
     */
    public function reject(Request $request, Application $application)
    {
        $user = Auth::user();
        
        // Otorisasi sederhana
        if (!in_array($user->role, ['rt', 'rw', 'kades', 'operator', 'admin'])) {
             return back()->with('error', 'Anda tidak memiliki izin untuk menolak permohonan ini.');
        }

        $application->update(['status' => 'rejected']);
        
        return back()->with('success', 'Permohonan telah ditolak.');
    }
}