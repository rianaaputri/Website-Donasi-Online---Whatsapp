<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Services\WhatsappService;

class UserController extends Controller
{
    /**
     * ✅ Tampilkan halaman registrasi user.
     */
    public function showRegister()
    {
        return view('auth.user-register');
    }

    /**
     * ✅ Proses registrasi user baru (OTP WhatsApp).
     */
    public function register(Request $request, WhatsappService $wa)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|min:2|max:255',
            'email'    => [
                'required', 'email', 'unique:users,email',
                'regex:/^.+@gmail\.com$/i'
            ],
            'phone'    => 'required|string|min:10|max:15|unique:users,phone',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required'      => 'Nama wajib diisi ya!',
            'name.min'           => 'Nama minimal 2 karakter ya!',
            'email.required'     => 'Email wajib diisi ya!',
            'email.email'        => 'Format email tidak valid!',
            'email.unique'       => 'Email ini sudah terdaftar, coba email lain ya!',
            'email.regex'        => 'Email harus menggunakan @gmail.com ya!',
            'phone.required'     => 'Nomor WhatsApp wajib diisi!',
            'phone.unique'       => 'Nomor WhatsApp ini sudah digunakan!',
            'password.required'  => 'Password wajib diisi ya!',
            'password.min'       => 'Password minimal 6 karakter ya!',
            'password.confirmed' => 'Konfirmasi password tidak cocok!',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // ✅ Generate OTP (6 digit)
        $otp = rand(100000, 999999);

        $user = User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'password'       => Hash::make($request->password),
            'role'           => 'user',
            'is_active'      => 1,
            'otp'            => $otp,
            'otp_expires_at' => now()->addMinutes(5),
            'is_verified'    => false,
        ]);

        // ✅ Kirim OTP via WhatsApp
        $wa->sendMessage($user->phone, "Halo {$user->name}, kode OTP Anda adalah *{$otp}*. Berlaku 5 menit. Jangan bagikan ke siapa pun.");

        // ✅ Auto login sementara (belum verified)
        Auth::login($user);

        return redirect()->route('verify.otp.form')
            ->with('success', 'Registrasi berhasil! Kode OTP sudah dikirim ke WhatsApp Anda.');
    }

    /**
     * ✅ Tampilkan halaman login.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * ✅ Proses login user.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials, $request->filled('remember'))) {
            $user = Auth::guard('web')->user();

            // 🚨 Kalau OTP belum diverifikasi
            if (!$user->is_verified) {
                return redirect()->route('verify.otp.form')
                    ->with('warning', 'Akun Anda belum diverifikasi. Silakan masukkan kode OTP yang dikirim ke WhatsApp.');
            }

            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->with('error', 'Email atau password salah!')->withInput();
    }

    /**
     * ✅ Proses logout user.
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Berhasil logout dari sistem');
    }
}
