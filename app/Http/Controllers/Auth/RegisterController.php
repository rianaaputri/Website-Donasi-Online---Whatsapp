<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Otp;
use Carbon\Carbon;

class RegisterController extends Controller
{
    /**
     * Display the registration view.
     */
    public function register(): View
    {
        return view('auth.register');
    }
 private function kirimOtp($phone, $nama)
{
    $otp = rand(100000, 999999);

    // Simpan ke DB
   Otp::create([
    'phone'      => $phone,
    'code'       => $otp,
    'expired_at' => Carbon::now()->addMinutes(1),
]);


    // Kirim WA
    $pesan = "Kode OTP untuk verifikasi nomor WA $nama adalah: $otp. Berlaku 1 menit.";
    kirimWa($phone, $pesan);
}
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function submitRegister(Request $request): RedirectResponse
    {

        
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'min:10', 'unique:' . User::class],
            'role' => ['required', 'string', 'in:admin,user,campaign_craetor'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $dataToStore=[
            'name'=>$validate['name'],
            'role'=>$validate['role'],
            'phone'=>$validate['phone'],
            'password'=>$validate['password']
        ];
        session()->put('pending_register', $dataToStore);
        $this->kirimOtp($validate['phone'], $validate['name']);
        return redirect()->route('otp.form')->with('sukses', 'Kode OTP telah dikirim ke WhatsApp');

       

        // Redirect ke halaman verifikasi email dengan alert
      
    }
    public function formOtp(): View
    {
        return view('auth.otp');
    }
    public function resendOtp()
{
    $data = session('pending_register');
    if (!$data) {
        return redirect()->route('register')->with('gagal', 'Session habis, silakan daftar ulang.');
    }

    $this->kirimOtp($data['phone'], $data['name']);
    return back()->with('sukses', 'Kode OTP baru sudah dikirim ke WhatsApp.');
}


public function submitOtp(Request $request)
{
    $request->validate([
        'otp' => 'required|digits:6',
    ]);

    $data = session('pending_register');
    if (!$data) {
        return redirect()->route('register')->with('gagal', 'Session habis, silakan daftar ulang.');
    }

    // Cari OTP di DB
    $otpRecord = \App\Models\Otp::where('phone', $data['phone'])
        ->where('code', $request->otp)
        ->where('expired_at', '>', now())
        ->latest()
        ->first();

    if (!$otpRecord) {
        return back()->with('gagal', 'Kode OTP salah atau sudah kedaluwarsa.');
    }

    // OTP valid → hapus biar ga dipakai lagi
    $otpRecord->delete();

    // Lanjut simpan user
    $user = new User();
    $user->name = $data['name'];
    $user->phone = $data['phone'];
    $user->role = $data['role'];
    $user->password = bcrypt($data['password']);

    $user->save();

  

    session()->forget('pending_register');
    auth()->login($user);

    return redirect()->route('home')->with('sukses', 'Registrasi berhasil!');
}
}
