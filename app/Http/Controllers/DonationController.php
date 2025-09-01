<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Donation;
use App\Models\Campaign;
use App\Services\MidtransService;
use Midtrans\Transaction;
use Midtrans\Snap;
use Midtrans\CoreApi;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DonationController extends Controller
{
    protected $midtrans;

    public function __construct(MidtransService $midtrans)
    {
        $this->midtrans = $midtrans;

        // Proteksi hanya untuk route yang butuh login & verifikasi phone
        $this->middleware(['auth', 'verified'])->only([
            'payment', 'success'
        ]);
    }

    // =========================
    // Tampilkan halaman semua donasi (admin)
    // =========================
    public function index()
    {
        $donations = Donation::latest()->paginate(10);
        $campaigns = Campaign::all();

        $stats = [
            'total_donations' => Donation::sum('amount'),
            'success_donations' => Donation::where('payment_status', 'success')->sum('amount'),
            'pending_donations' => Donation::where('payment_status', 'pending')->sum('amount'),
            'today_donations' => Donation::whereDate('created_at', today())->sum('amount'),
        ];

        return view('admin.donation.index', compact('donations', 'campaigns', 'stats'));
    }

    // =========================
    // Halaman detail campaign + progress + donatur terbaru
    // =========================
    public function showCampaign(Campaign $campaign)
    {
        // Tidak perlu recalculateCollectedAmount, cukup ambil getter
        $formatted_collected = $campaign->formatted_collected;
        $formatted_target = $campaign->formatted_target;
        $progress_percentage = $campaign->progress_percentage;
        $days_elapsed = $campaign->days_elapsed;

        $recentDonors = $campaign->donations()
            ->where('payment_status', 'success')
            ->latest()
            ->take(6)
            ->get()
            ->map(function($donation) {
                $donation->formatted_amount = 'Rp ' . number_format((int)$donation->amount, 0, ',', '.');
                return $donation;
            });

        $isActive = $campaign->status === 'active' && 
            ($campaign->end_date ? now()->lessThanOrEqualTo($campaign->end_date) : true);

        // Kirim variabel ke view
        return view('donation.detail', [
            'campaign' => $campaign,
            'recentDonors' => $recentDonors,
            'isActive' => $isActive,
            'formatted_collected' => $formatted_collected,
            'formatted_target' => $formatted_target,
            'progress_percentage' => $progress_percentage,
            'days_elapsed' => $days_elapsed,
        ]);
    }

    // =========================
    // Form donasi untuk campaign tertentu
    // =========================
    public function create(Campaign $campaign)
    {
        if (!$campaign->is_active || $campaign->status !== 'active') {
            return redirect()->route('campaign.show', $campaign->id)
                             ->with('error', 'Campaign ini tidak aktif untuk donasi.');
        }

        return view('donation.create', compact('campaign'));
    }

    // =========================
    // Simpan donasi & redirect ke payment
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'amount' => 'required|numeric|min:10000',
            'comment' => 'nullable|string|max:500',
            'is_anonymous' => 'nullable|boolean'
        ]);

        $user = auth()->user();
        $orderId = 'DON-' . now()->format('Ymd') . '-' . strtoupper(uniqid());


        $donation = Donation::create([
            'user_id' => $user->id,
            'campaign_id' => $request->campaign_id,
            'amount' => $request->amount,
            'comment' => $request->comment,
            'is_anonymous' => $request->is_anonymous ?? false,
            'donor_name' => $user->name,
            'donor_phone' => $user->phone,
            'payment_status' => 'pending',
            'midtrans_order_id' => $orderId
        ]);

        return redirect()->route('donation.payment', $donation->id);
    }
    private function kirimQRCodeWhatsApp($qrCodeUrl, $nomorHP, $orderId, $amount)
{
    $apiToken = env('JAPATI_APIOKEN');
    $gateway  = env('JAPATI_GATEWAY_NUMBER');

    try {
        $response = Http::withBasicAuth(env('MIDTRANS_SERVER_KEY'), '')
            ->get($qrCodeUrl);

        if (!$response->successful()) {
            Log::error("Gagal ambil QR code Midtrans: " . $response->body());
            return false;
        }

        $fileName = 'qris_' . $orderId . '.png';
        $fileData = $response->getBody()->getContents();
    } catch (\Exception $e) {
        Log::error("Exception ambil QR code: " . $e->getMessage());
        return false;
    }

    $caption  = "🔄 QR Code Pembayaran\n\n";
    $caption .= "Order ID: {$orderId}\n";
    $caption .= "Nominal: Rp" . number_format($amount, 0, ',', '.') . "\n\n";
    $caption .= "Silakan scan QR ini untuk membayar.\n\n";
    $caption .= "Terima kasih! 🙏";

    // ✅ Kirim multipart dengan caption
    $res = Http::withHeaders([
        'Authorization' => 'Bearer ' . $apiToken,
    ])->asMultipart()->post('https://app.japati.id/api/send-message', [
        [
            'name'     => 'gateway',
            'contents' => $gateway,
        ],
        [
            'name'     => 'number',
            'contents' => $nomorHP,
        ],
        [
            'name'     => 'type',
            'contents' => 'media',
        ],
        [
            'name'     => 'caption',
            'contents' => $caption, // ✅ pastikan ikut dikirim
        ],
        [
            'name'     => 'media_file',
            'contents' => $fileData,
            'filename' => $fileName,
        ],
    ]);

    if ($res->successful()) {
        Log::info("✅ QR Code + caption berhasil dikirim ke WhatsApp: {$nomorHP}");
        return true;
    } else {
        Log::error('❌ Gagal kirim QR Code via WA: ' . $res->body());
        return false;
    }
}



    // =========================
    // Halaman payment Midtrans
    // =========================
  public function payment($id)
{
    $donation = Donation::findOrFail($id);

    if (empty($donation->midtrans_order_id)) {
        $donation->midtrans_order_id = 'DON-' . now()->format('Ymd') . '-' . strtoupper(uniqid());
        $donation->save();
    }

    $params = [
        'transaction_details' => [
            'order_id' => $donation->midtrans_order_id,
            'gross_amount' => (int) $donation->amount
        ],
        'customer_details' => [
            'first_name' => $donation->donor_name,
            'phone' => $donation->donor_phone
        ],
        'item_details' => [
            [
                'id' => 'DON-' . $donation->campaign_id,
                'price' => (int) $donation->amount,
                'quantity' => 1,
                'name' => 'Donasi untuk ' . $donation->campaign->title
            ]
        ],
        'enabled_payments' => [
            'credit_card', 'gopay', 'shopeepay', 
            'bank_transfer', 'echannel', 'bca_va', 
            'bni_va', 'bri_va'
        ]
    ];

    try {
        $orderId = $donation->midtrans_order_id;
        $nominal = $donation->amount;

        // ✅ Snap token untuk UI
        $snapToken = Snap::getSnapToken($params);

        // ✅ Generate QR code QRIS untuk dikirim ke WA
        $qrParams = [
            'payment_type' => 'qris',
            'transaction_details' => [
                'order_id' => $orderId . '-QR', // penting: bedakan order_id biar tidak bentrok dengan Snap
                'gross_amount' => (int) $nominal
            ],
            'item_details' => $params['item_details'],
            'customer_details' => $params['customer_details']
        ];

        $qrCodeUrl = null;
        try {
            $qrResponse = CoreApi::charge($qrParams);
            $qrCodeUrl = $qrResponse->actions[0]->url ?? null;

            if ($qrCodeUrl && Auth::user()->phone) {
                $this->kirimQRCodeWhatsApp(
                    $qrCodeUrl, 
                    Auth::user()->phone, 
                    $orderId, 
                    $nominal
                );
            }
        } catch (\Exception $qrError) {
            Log::warning('Gagal generate QR code: ' . $qrError->getMessage());
        }

        // ✅ Render view Snap UI + kirim snapToken
        return view('donation.payment', [
            'donation' => $donation,
            'snapToken' => $snapToken,
            'qrCodeUrl' => $qrCodeUrl, // kalau mau ditampilkan juga di layar
        ]);

    } catch (\Exception $e) {
        Log::error('Midtrans Error: ' . $e->getMessage());
        return back()->with('error', 'Gagal membuat token pembayaran. Silakan coba lagi.');
    }
}


    // =========================
    // Halaman sukses donasi
    // =========================
    public function success($id)
    {
        $donation = Donation::findOrFail($id);
        return view('donation.success', compact('donation'));
    }// Semua donasi pending milik user
public function pending()
{
    $pendingDonations = Donation::with('campaign')
        ->where('user_id', auth()->id())
        ->where('payment_status', 'pending')
        ->get();

    return view('donation.pending', compact('pendingDonations'));
}

// Detail satu donasi pending → arahkan ke edit
public function edit($id)
{
    $donation = Donation::with(['campaign', 'user'])
        ->where('user_id', auth()->id())
        ->findOrFail($id);
if ($donation->payment_status === 'pending') {
     $donation->midtrans_order_id = 'DON-' . now()->format('Ymd') . '-' . strtoupper(uniqid());
    $donation->save();
}
    $params = [
        'transaction_details' => [
            'order_id' => $donation->midtrans_order_id,
            'gross_amount' => (int) $donation->amount
        ],
        'customer_details' => [
            'first_name' => $donation->user->name,
            'phone' => $donation->user->phone
        ],
        'item_details' => [
            [
                'id' => 'DON-' . $donation->campaign_id,
                'price' => (int) $donation->amount,
                'quantity' => 1,
                'name' => 'Donasi untuk ' . $donation->campaign->title
            ]
        ]
    ];

    $snapToken = $this->midtrans->getSnapToken($params);

    return view('donation.edit', compact('donation', 'snapToken'));
}

    // =========================
    // Cek status donasi Midtrans
    // =========================
    public function checkStatus($id)
{
    $donation = Donation::findOrFail($id);

    try {
        $status = Transaction::status($donation->midtrans_order_id);

        $oldStatus = $donation->payment_status;

        if (in_array($status->transaction_status, ['settlement', 'capture'])) {
            $donation->payment_status = 'success';
            $donation->paid_at = now();
        } elseif (in_array($status->transaction_status, ['expire', 'cancel', 'deny'])) {
            $donation->payment_status = 'failed';
        } else {
            $donation->payment_status = 'pending';
        }

        $donation->save();
// ✅ Jika status berubah ke success → kirim WA
if ($oldStatus !== 'success' && $donation->payment_status === 'success') {
    $donation->campaign->updateCollectedAmount();

    if ($donation->user && $donation->user->phone) {
        $pesan = "Halo {$donation->user->name}, terima kasih atas donasi Anda sebesar Rp"
               . number_format($donation->amount, 0, ',', '.')
               . " untuk campaign \"{$donation->campaign->title}\". Donasi Anda sudah kami terima 🙏😊";
        kirimWa($donation->user->phone, $pesan);
    }
}
        // Panggil updateCollectedAmount jika status berubah ke 'success'
        if ($oldStatus !== 'success' && $donation->payment_status === 'success') {
            $donation->campaign->updateCollectedAmount();
        }

        $campaign = $donation->campaign; 

        return response()->json([
            'status' => $donation->payment_status,
            'progress' => $campaign->progress_percentage ?? 0,
            'collected' => 'Rp ' . number_format($campaign->collected_amount ?? 0, 0, ',', '.'),
            'donors' => $campaign->donations()->where('payment_status', 'success')->count()
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => $donation->payment_status
        ]);
    }
}

public function update(Request $request, $id)
{
    $donation = Donation::where('user_id', auth()->id())->findOrFail($id);

    // Validasi
    $request->validate([
        'amount' => 'required|numeric|min:10000',
        'comment' => 'nullable|string|max:500'
    ]);

    // Update data donasi
    $donation->update([
        'amount' => $request->amount,
        'comment' => $request->comment,
        'payment_status' => 'pending', // pastikan status tetap pending
    ]);

    // Redirect langsung ke halaman payment
    return redirect()->route('donation.payment', $donation->id);
}



    // =========================
    // History donasi user
    // =========================
    public function myDonations()
    {
        $donations = Donation::with('campaign')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('donation.history', compact('donations'));
    }
}
