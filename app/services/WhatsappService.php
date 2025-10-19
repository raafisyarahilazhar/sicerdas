<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class WhatsappService
{
    protected function base(string $path): string {
        return 'https://graph.facebook.com/v20.0/'.config('services.whatsapp.phone_id').$path;
    }

    /** Normalisasi ke E.164 (Indonesia) */
    public function normalizeIdPhone(?string $raw): ?string {
        if (!$raw) return null;
        $d = preg_replace('/\D+/', '', $raw);
        if (Str::startsWith($d, '0')) $d = '62'.substr($d,1);
        return preg_match('/^[1-9]\d{7,14}$/', $d) ? $d : null;
    }

    /** Kirim pesan teks */
    public function sendText(string $toE164, string $body): array {
        return Http::withToken(config('services.whatsapp.token'))
            ->post($this->base('/messages'), [
                'messaging_product' => 'whatsapp',
                'to'   => $toE164,
                'type' => 'text',
                'text' => ['preview_url'=> true, 'body' => $body],
            ])->json();
    }

    /** Kirim template (untuk di luar 24 jam window) */
    public function sendTemplate(string $toE164, string $template, string $lang='id', array $components=[]): array {
        return Http::withToken(config('services.whatsapp.token'))
            ->post($this->base('/messages'), [
                'messaging_product' => 'whatsapp',
                'to'   => $toE164,
                'type' => 'template',
                'template' => [
                    'name' => $template,
                    'language' => ['code'=>$lang],
                    'components' => $components,
                ],
            ])->json();
    }

    /** Upload media (PDF, gambar) → dapat media.id */
    public function uploadMedia(string $absolutePath, string $mime): array {
        $resp = Http::asMultipart()
            ->withToken(config('services.whatsapp.token'))
            ->attach('file', fopen($absolutePath, 'r'), basename($absolutePath))
            ->post($this->base('/media'), [
                'messaging_product' => 'whatsapp',
                'type' => $mime, // contoh: application/pdf
            ]);
        if (!$resp->ok()) throw new \RuntimeException('Upload media gagal: '.$resp->status().' '.$resp->body());
        return $resp->json(); // ['id' => 'MEDIA_ID']
    }

    /** Kirim dokumen dengan media.id */
    public function sendDocumentByMediaId(string $toE164, string $mediaId, ?string $filename=null, ?string $caption=null): array {
        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $toE164,
            'type' => 'document',
            'document' => ['id' => $mediaId],
        ];
        if ($filename) $payload['document']['filename'] = $filename;
        if ($caption)  $payload['document']['caption']  = $caption;

        $resp = Http::withToken(config('services.whatsapp.token'))->post($this->base('/messages'), $payload);
        if (!$resp->ok()) throw new \RuntimeException('Kirim dokumen gagal: '.$resp->status().' '.$resp->body());
        return $resp->json();
    }
}
