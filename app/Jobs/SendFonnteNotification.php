<?php

namespace App\Jobs;

use App\Models\Application;
use App\Services\FonnteService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;   // <-- tambahkan
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;      // <-- tambahkan
use Illuminate\Queue\SerializesModels;        // <-- tambahkan
use Illuminate\Support\Facades\Storage;

class SendFonnteNotification implements ShouldQueue   // <-- implement ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;  // <-- pakai traits

    public int $tries = 3;
    public int $timeout = 20;

    public function __construct(public int $applicationId) {}

    public function handle(FonnteService $f): void
    {
        $app = Application::with('applicationType','resident')->find($this->applicationId);
        if (!$app || $app->status !== 'approved') return;

        $res = $app->resident;
        if (!$res) return;

        $target = $f->normalizeTarget($res->wa_number_e164 ?: $res->phone);
        if (!$target) return;

        $caption =
            "✅ *Pengajuan Disetujui*\n".
            "*Ref:* {$app->ref_number}\n".
            "*Jenis:* {$app->applicationType?->name}\n".
            "*Status:* APPROVED\n\nSilahkan cek kembali pada lama website SICERDAS\n\nTerima kasih.";

        $mode = config('services.fonnte.send_mode', 'auto'); // auto|url|file

        if (in_array($mode, ['auto','file'], true) && $app->pdf_path && Storage::disk('public')->exists($app->pdf_path)) {
            try {
                $abs = Storage::disk('public')->path($app->pdf_path);
                $f->sendDocumentByFile($target, $abs, $caption, 'surat-'.$app->ref_number.'.pdf', [
                    'filename' => 'surat-'.$app->ref_number.'.pdf',
                ]);
                return;
            } catch (\Throwable $e) {
                // paket tidak mendukung file / error upload -> lanjut ke URL/teks
            }
        }

        if (in_array($mode, ['auto','url'], true) && $app->pdf_path && Storage::disk('public')->exists($app->pdf_path)) {
            $publicUrl = url(Storage::disk('public')->url($app->pdf_path));
            $f->sendDocumentByUrl($target, $publicUrl, $caption, 'surat-'.$app->ref_number.'.pdf');
            return;
        }

        $f->sendText($target, $caption);
    }
}
