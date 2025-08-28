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
        $this->url     = env('WHATSAPP_URL', 'http://app.japati.id/api/send-message');
        $this->token   = env('WHATSAPP_TOKEN', 'API-TOKEN-G7JowjShQb91JopiSPvTP0E3SsLeEQtEag0I92uCMOFvs2gwgbARne');
        $this->gateway = env('WHATSAPP_GATEWAY', '62895344677337');
    }

    public function sendMessage(string $number, string $message): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization'    => $this->token, // ✅ Japati biasanya tanpa "Bearer"
                'X-Requested-With' => 'XMLHttpRequest',
            ])->post($this->url, [
                'gateway' => $this->gateway,
                'target'  => $number,   // ✅ ubah number → target
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