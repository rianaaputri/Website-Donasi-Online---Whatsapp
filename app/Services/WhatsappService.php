<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    protected $url;
    protected $token;
    protected $gateway;

    public function __construct()
    {
        $this->url = config('services.japati.url');
        $this->token = config('services.japati.token');
        $this->gateway = config('services.japati.gateway');
    }

    /**
     * Kirim pesan WhatsApp
     *
     * @param string $toNumber Nomor tujuan (format 628xxxx)
     * @param string $message Pesan teks
     * @return array
     */
    public function send($toNumber, $message)
    {
        // Format nomor: ganti 08 jadi 628
        $toNumber = preg_replace('/^0/', '62', $toNumber);

        $response = Http::withToken($this->token) // Jika API butuh Bearer Token
            ->post($this->url, [
                'gateway' => $this->gateway,
                'number' => $toNumber,
                'type' => 'text',
                'message' => $message,
            ]);

        $result = $response->json();

        if ($response->successful() && data_get($result, 'success')) {
            return [
                'success' => true,
                'message' => 'Pesan terkirim!',
                'data' => $result
            ];
        }

        return [
            'success' => false,
            'message' => data_get($result, 'message', 'Gagal kirim'),
            'errors' => data_get($result, 'errors', [])
        ];
    }
}