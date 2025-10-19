<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class FonnteService
{
    protected string $endpoint = 'https://api.fonnte.com/send';

    protected function auth()
    {
        return ['Authorization' => config('services.fonnte.token')];
    }

    /** Fonnte menerima 0812… (akan diubah via countryCode=62). */
    public function normalizeTarget(?string $raw): ?string
    {
        if (!$raw) return null;
        $digits = preg_replace('/\D+/', '', $raw);
        // biarkan 0 di depan; biar Fonnte yang ganti ke 62 (countryCode)
        if (Str::length($digits) < 8) return null;
        return $digits;
    }

    /** Kirim teks saja */
    public function sendText(string $target, string $message, array $extra = []): array
    {
        $payload = array_merge([
            'target'      => $target,
            'message'     => $message,
            'countryCode' => (string) config('services.fonnte.country_code', '62'),
            'connectOnly' => (bool) config('services.fonnte.connect_only', true),
        ], $extra);

        return Http::asForm()->withHeaders($this->auth())->post($this->endpoint, $payload)->json();
    }

    /** Kirim dokumen via URL publik (butuh file publik; bukan halaman) */
    public function sendDocumentByUrl(string $target, string $publicUrl, string $message = '', ?string $filename = null, array $extra = []): array
    {
        $payload = array_merge([
            'target'      => $target,
            'message'     => $message,
            'url'         => $publicUrl,
            'filename'    => $filename, // hanya berlaku utk non-image/non-video (pdf, doc, zip)
            'countryCode' => (string) config('services.fonnte.country_code', '62'),
            'connectOnly' => (bool) config('services.fonnte.connect_only', true),
        ], $extra);

        return Http::asForm()->withHeaders($this->auth())->post($this->endpoint, $payload)->json();
    }

    /** Kirim dokumen via upload binary (butuh paket super/advanced/ultra) */
    public function sendDocumentByFile(string $target, string $absolutePath, string $message = '', ?string $filename = null, array $extra = []): array
    {
        $payload = array_merge([
            ['name' => 'target',      'contents' => $target],
            ['name' => 'message',     'contents' => $message],
            ['name' => 'countryCode', 'contents' => (string) config('services.fonnte.country_code', '62')],
            ['name' => 'connectOnly', 'contents' => config('services.fonnte.connect_only', true) ? 'true' : 'false'],
            // param 'file' = binary upload
        ], $this->toMultipart($extra));

        return Http::withHeaders($this->auth())
            ->attach('file', fopen($absolutePath, 'r'), $filename ?: basename($absolutePath))
            ->post($this->endpoint, $payload)
            ->json();
    }

    /** helper: array asForm → multipart fields */
    protected function toMultipart(array $data): array
    {
        $out = [];
        foreach ($data as $k => $v) {
            if ($v === null) continue;
            $out[] = ['name' => $k, 'contents' => is_bool($v) ? ($v ? 'true':'false') : (string)$v];
        }
        return $out;
    }
}
