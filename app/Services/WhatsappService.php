<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsappService
{
    protected string $url;
    protected string $token;
    protected string $gateway;

    public function __construct()
    {
        // 🔧 Ambil dari .env (pastikan sudah ada di .env)
        $this->url     = env('WHATSAPP_URL', 'http://app.japati.id/api/send-message');
        $this->token   = env('WHATSAPP_TOKEN', 'G7JowjShQb91JopiSPvTP0E3SsLeEQtEag0I92uCMOFvs2gwgbARne');
        $this->gateway = env('WHATSAPP_GATEWAY', '62895323487102');
    }

    /**
     * Kirim pesan WhatsApp
     *
     * @param string $number  Nomor tujuan WA (format internasional, ex: 6281234567890)
     * @param string $message Pesan teks yang dikirim
     * @return array
     */
    public function sendMessage(string $number, string $message): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization'     => 'Bearer ' . $this->token,
                'X-Requested-With'  => 'XMLHttpRequest',
            ])->post($this->url, [
                'gateway' => $this->gateway,
                'number'  => $number,
                'type'    => 'text',
                'message' => $message,
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'Pesan terkirim ke ' . $number,
                    'data'    => $response->json(),
                ];
            }

            return [
                'success' => false,
                'message' => 'Gagal mengirim pesan WhatsApp',
                'data'    => $response->json(),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'data'    => [],
            ];
        }
    }
}
