<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Otp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Carbon\Carbon;

class CampaignCreatorRegisterController extends Controller
{
    /**
     * Tampilkan form registrasi campaign creator
     */
    public function showRegistrationForm(): View
    {
        return view('auth.campaign_creator_register');
    }

    public function showOtpForm()
{
    return view('auth.otp');
}

    /**
     * Proses registrasi: validasi & kirim OTP
     */
    public function register(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => [
                'required',
                'string',
                'regex:/^628[0-9]{8,13}$/',
                'unique:users,phone'
            ],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'phone.regex' => 'Format nomor WhatsApp tidak valid. Gunakan 628123456789.',
            'phone.unique' => 'Nomor WhatsApp sudah terdaftar.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Simpan data sementara di session
        $dataToStore = [
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => $request->password,
            'role' => 'campaign_creator',
        ];

        session()->put('pending_register', $dataToStore);

        // Kirim OTP
        $this->kirimOtp($request->phone, $request->name);

        return redirect()->route('verify.otp.form')
            ->with('sukses', 'Kode OTP telah dikirim ke WhatsApp Anda.');
    }

    /**
     * Kirim OTP ke WhatsApp
     */
    private function kirimOtp($phone, $nama)
    {
        $otp = rand(100000, 999999);

        // Simpan OTP ke database
        Otp::create([
            'phone' => $phone,
            'code' => $otp,
            'expired_at' => Carbon::now()->addMinutes(5),
        ]);

        // Kirim via WhatsApp
        $pesan = "Kode OTP untuk verifikasi akun Campaign Creator, $nama, adalah: $otp. Berlaku 1 menit.";
        kirimWa($phone, $pesan); // Pastikan fungsi ini tersedia
    }

    /**
     * Resend OTP
     */
    public function resendOtp()
    {
        $data = session('pending_register');
        if (!$data) {
            return redirect()->route('campaign.creator.register.form')
                ->with('gagal', 'Sesi habis, silakan daftar ulang.');
        }

        $this->kirimOtp($data['phone'], $data['name']);
        return back()->with('sukses', 'Kode OTP baru telah dikirim ke WhatsApp.');
    }

    /**
     * Verifikasi OTP dan selesaikan registrasi
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $data = session('pending_register');
        if (!$data) {
            return redirect()->route('campaign.creator.register.form')
                ->with('gagal', 'Sesi habis, silakan daftar ulang.');
        }

        // Cari OTP yang valid
        $otpRecord = Otp::where('phone', $data['phone'])
            ->where('code', $request->otp)
            ->where('expired_at', '>', now())
            ->latest()
            ->first();

        if (!$otpRecord) {
            return back()->with('gagal', 'Kode OTP salah atau sudah kedaluwarsa.');
        }

        // Hapus OTP setelah digunakan
        $otpRecord->delete();

        // Buat user
        $user = User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        // Hapus session
        session()->forget('pending_register');

        // Login otomatis
        Auth::login($user);

        // Redirect ke halaman setelah login
        return redirect()->route('home')->with('sukses', 'Registrasi Campaign Creator berhasil!');
    }
}