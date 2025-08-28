<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\WhatsappService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan form registrasi
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Proses registrasi user baru
     */
    public function store(Request $request, WhatsappService $wa): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            // Email tidak wajib lagi
            'email'    => ['nullable', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone'    => ['required', 'string', 'regex:/^62[0-9]{9,13}$/', 'unique:users,phone'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'phone.regex' => 'Nomor WhatsApp harus diawali dengan 62 dan hanya angka.'
        ]);

        // ✅ Generate OTP (6 digit)
        $otp = random_int(100000, 999999);

        // ✅ Buat user baru (belum verified)
        $user = User::create([
            'name'           => $request->name,
            'email'          => $request->email, // bisa null
            'phone'          => $request->phone,
            'password'       => Hash::make($request->password),
            'role'           => 'user',
            'is_active'      => true,
            'otp'            => $otp,
            'otp_expires_at' => now()->addMinutes(5),
            'is_verified'    => false,
        ]);

        // ✅ Kirim OTP via WhatsApp Japati
        try {
            $wa->sendMessage(
                $user->phone,
                "Halo {$user->name}, kode OTP Anda adalah *{$otp}*.\n\n⚠️ Berlaku 5 menit. Jangan bagikan ke siapa pun."
            );
        } catch (\Exception $e) {
            // kalau gagal kirim OTP, hapus user agar tidak ada akun 'nyangkut'
            $user->delete();

            return redirect()->route('register')
                ->with('error', 'Gagal mengirim OTP ke WhatsApp. Silakan coba lagi.');
        }

        // ✅ Login otomatis (sementara, status belum verified)
        Auth::login($user);

        return redirect()->route('verify.otp.form')
            ->with('success', 'Registrasi berhasil! Kode OTP telah dikirim ke WhatsApp Anda.');
    }
}
