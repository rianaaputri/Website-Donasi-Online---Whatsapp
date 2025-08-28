<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\WhatsappService;

class OtpController extends Controller
{
    /**
     * Tampilkan form verifikasi OTP
     */
    public function showVerifyForm()
    {
        return view('auth.verify-otp');
    }

    /**
     * Verifikasi OTP yang dimasukkan user
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek expired
        if (now()->gt($user->otp_expires_at)) {
            return back()->with('error', 'Kode OTP sudah kedaluwarsa. Silakan kirim ulang.');
        }

        // Cek kode OTP
        if ($request->otp != $user->otp) {
            return back()->with('error', 'Kode OTP salah.');
        }

        // ✅ Berhasil verifikasi
        $user->update([
            'otp'         => null,
            'otp_expires_at' => null,
            'is_verified' => true,
        ]);

        return redirect()->route('dashboard')->with('success', 'Nomor WhatsApp berhasil diverifikasi!');
    }

    /**
     * Kirim ulang OTP
     */
    public function resendOtp(WhatsappService $wa)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Generate OTP baru
        $otp = random_int(100000, 999999);

        $user->update([
            'otp'           => $otp,
            'otp_expires_at'=> now()->addMinutes(5),
        ]);

        try {
            $wa->sendMessage(
                $user->phone,
                "Halo {$user->name}, kode OTP baru Anda adalah *{$otp}*.\n\n⚠️ Berlaku 5 menit."
            );
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim OTP. Silakan coba lagi.');
        }

        return back()->with('success', 'Kode OTP baru sudah dikirim ke WhatsApp Anda.');
    }
}
