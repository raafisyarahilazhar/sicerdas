<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use App\Services\DocumentService;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;   // <--- tambahkan

class ApplicationApprovalController extends Controller
{
    protected $documentService;
    protected $notificationService;

    public function __construct(DocumentService $documentService, NotificationService $notificationService)
    {
        $this->documentService   = $documentService;
        $this->notificationService = $notificationService;
    }

    /**
     * Menyetujui permohonan surat dan memicu proses selanjutnya.
     */
    public function approve(Request $request, Application $application)
    {
        $user = Auth::user();
        $nextStatus = null;

        // Alur persetujuan berjenjang
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

        // Admin/Operator dapat menyetujui langsung (opsional: tambahkan 'operator')
        if (in_array($user->role, ['admin', 'operator'])) {
            $nextStatus = 'approved';
        }

        if (!$nextStatus) {
            return back()->with('error', 'Anda tidak memiliki izin untuk menyetujui permohonan pada tahap ini.');
        }

        // Update status & refresh model agar status terbaru terbaca service
        $application->update(['status' => $nextStatus]);
        $application->refresh();

        // Jika sudah approved -> coba generate PDF, tapi apapun hasilnya, tetap kirim notifikasi
        if ($nextStatus === 'approved') {
            $isGenerated = false;

            try {
                $isGenerated = (bool) $this->documentService->generate($application);
                // dokumen service bisa saja update pdf_path -> refresh supaya kebaca oleh Job
                $application->refresh();
            } catch (\Throwable $e) {
                Log::error('Document generation failed for ref '.$application->ref_number.' : '.$e->getMessage(), [
                    'app_id' => $application->id,
                    'trace'  => $e->getTraceAsString(),
                ]);
            }

            // ⚠️ SELALU kirim notifikasi (job akan memutuskan kirim PDF / link / teks)
            try {
                $this->notificationService->sendSuratSelesaiNotification($application);
            } catch (\Throwable $e) {
                Log::error('WhatsApp notification dispatch failed for ref '.$application->ref_number.' : '.$e->getMessage(), [
                    'app_id' => $application->id,
                    'trace'  => $e->getTraceAsString(),
                ]);
            }

            return back()->with(
                $isGenerated ? 'success' : 'warning',
                $isGenerated
                    ? 'Persetujuan berhasil, dokumen dibuat, dan notifikasi WhatsApp dikirim.'
                    : 'Persetujuan berhasil, namun pembuatan dokumen gagal. Notifikasi WhatsApp tetap dikirim tanpa lampiran.'
            );
        }

        return back()->with('success', 'Permohonan berhasil disetujui.');
    }

    /**
     * Menolak permohonan surat.
     */
    public function reject(Request $request, Application $application)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['rt', 'rw', 'kades', 'operator', 'admin'])) {
            return back()->with('error', 'Anda tidak memiliki izin untuk menolak permohonan ini.');
        }

        $application->update(['status' => 'rejected']);

        return back()->with('success', 'Permohonan telah ditolak.');
    }
}
