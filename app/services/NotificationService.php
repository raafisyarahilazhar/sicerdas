<?php

namespace App\Services;

use App\Models\Application;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        // Ambil konfigurasi dari file .env melalui config/services.php
        $this->apiUrl = config('services.whatsapp.url');
        $this->apiKey = config('services.whatsapp.api_key');
    }

    /**
     * Mengirim notifikasi WhatsApp bahwa surat telah selesai.
     *
     * @param Application $application
     * @return void
     */
    public function sendSuratSelesaiNotification(Application $application): void
    {
        dd('NotificationService is called!');
        if (!$this->apiUrl || !$this->apiKey) {
            Log::error('WhatsApp API URL or Key is not configured in .env or config/services.php.');
            return;
        }

        $resident = $application->resident;

        if (!$resident || !$resident->phone) {
            Log::warning("Attempted to send notification, but resident or phone number is missing for application #{$application->id}.");
            return;
        }

        $downloadUrl = route('applications.downloadPdf', $application, true);

        $phoneNumber = $this->formatPhoneNumber($resident->phone);

        $message = sprintf(
            "Yth. Bapak/Ibu %s,\n\n" .
            "Permohonan surat Anda dengan nomor referensi *%s* telah selesai diproses dan disetujui.\n\n" .
            "Jenis Surat: *%s*\n\n" .
            "Anda dapat mengunduh surat tersebut melalui tautan aman di bawah ini:\n" .
            "%s\n\n" .
            "Terima kasih.\n" .
            "*Pemerintahan Desa Sicerdas*",
            $resident->name,
            $application->ref_number,
            $application->applicationType->name,
            $downloadUrl
        );
        
        // 4. Kirim request ke API Gateway WhatsApp
        try {
            Http::withHeaders([
                'Authorization' => $this->apiKey,
            ])->post($this->apiUrl, [
                'target' => $phoneNumber,
                'message' => $message,
            ]);

            Log::info("WhatsApp notification sent successfully to {$phoneNumber} for application #{$application->id}.");

        } catch (\Exception $e) {
            Log::error("Failed to send WhatsApp notification for application #{$application->id}: " . $e->getMessage());
        }
    }

    /**
     * Helper untuk memformat nomor telepon dari 08xx ke 628xx.
     */
    private function formatPhoneNumber(string $number): string
    {
        // Hapus karakter non-numerik
        $cleaned = preg_replace('/[^0-9]/', '', $number);
        
        // Ganti angka 0 di depan dengan 62
        if (Str::startsWith($cleaned, '0')) {
            return '62' . substr($cleaned, 1);
        }
        
        // Jika sudah diawali 62, kembalikan apa adanya
        if (Str::startsWith($cleaned, '62')) {
            return $cleaned;
        }
        
        // Default, tambahkan 62 di depan
        return '62' . $cleaned;
    }
}