<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Carbon\Carbon;
use App\Models\Otp;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil.
     */
    public function show(Request $request): View
    {
        return view('profile.show', ['user' => $request->user()]);
    }

    /**
     * Tampilkan form edit profil.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', ['user' => $request->user()]);
    }

    /**
     * Kirim OTP ke nomor WhatsApp.
     */
    private function kirimOtp($phone, $nama)
    {
        $otp = rand(100000, 999999);

        Otp::create([
            'user_id'    => null,
            'phone'      => $phone,
            'code'       => $otp,
            'expired_at' => Carbon::now()->addMinutes(1),
        ]);

        $pesan = "Halo $nama, kode OTP verifikasi nomor WhatsApp Anda adalah: $otp (berlaku 1 menit).";
        kirimWa($phone, $pesan); // fungsi helper kamu
    }

    /**
     * Update profil user.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|numeric',
            'address' => 'required|string|max:255',
            'avatar'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Jika nomor tidak berubah → update langsung
        if ($request->phone === $user->phone) {
            $user->name = $request->name;
            $user->address = $request->address;

            if ($request->hasFile('avatar')) {
                if ($user->avatar) Storage::delete($user->avatar);
                $user->avatar = $request->file('avatar')->store('avatar');
            }

            $user->save();
            return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');
        }

        // Jika nomor berubah → simpan ke session
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('temp/avatar');
        }

        session(['pending_update' => [
            'step'    => 'verify_old',
            'name'    => $request->name,
            'phone'   => $request->phone,
            'avatar'  => $avatarPath,
            'address' => $request->address,
        ]]);

        $this->kirimOtp($user->phone, $request->name);

        return redirect()->route('profile.otp')->with('info', 'OTP sudah dikirim ke nomor lama Anda.');
    }

    /**
     * Form input OTP.
     */
    public function formOtp(): View
    {
        return view('profile.otp');
    }

    /**
     * Kirim ulang OTP.
     */
    public function resendOtp()
    {
        $data = session('pending_update');
        if (!$data) {
            return redirect()->route('profile.edit')->with('gagal', 'Session habis, silakan coba lagi.');
        }

        $user = Auth::user();

        if ($data['step'] === 'verify_old') {
            $this->kirimOtp($user->phone, $data['name']);
            return back()->with('success', 'OTP baru sudah dikirim ke nomor lama Anda.');
        }

        if ($data['step'] === 'verify_new') {
            $this->kirimOtp($data['phone'], $data['name']);
            return back()->with('success', 'OTP baru sudah dikirim ke nomor baru Anda.');
        }
    }

    /**
     * Submit OTP.
     */
    public function submitOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $data = session('pending_update');
        if (!$data) {
            return redirect()->route('profile.edit')->with('gagal', 'Session habis, silakan coba lagi.');
        }

        $user = Auth::user();

        $phoneCheck = $data['step'] === 'verify_old' ? $user->phone : $data['phone'];

        $otpRecord = Otp::where('phone', $phoneCheck)
            ->where('code', $request->otp)
            ->latest()
            ->first();

        if (!$otpRecord) {
            return back()->with('gagal', 'Kode OTP salah.');
        }

        if (Carbon::now()->greaterThan($otpRecord->expired_at)) {
            return back()->with('gagal', 'Kode OTP sudah kedaluwarsa, silakan kirim ulang.');
        }

        // Step 1 → verifikasi nomor lama
        if ($data['step'] === 'verify_old') {
            session(['pending_update' => array_merge($data, ['step' => 'verify_new'])]);
            $this->kirimOtp($data['phone'], $data['name']);
            return redirect()->route('profile.otp')->with('success', 'OTP sudah dikirim ke nomor baru, silakan verifikasi.');
        }

        // Step 2 → verifikasi nomor baru
        if ($data['step'] === 'verify_new') {
            $user->name = $data['name'];
            $user->phone = $data['phone'];
            $user->address = $data['address'];

            if ($data['avatar']) {
                if ($user->avatar) Storage::delete($user->avatar);
                $user->avatar = Storage::move($data['avatar'], str_replace('temp/', '', $data['avatar']));
            }

            $user->phone_verified_at = Carbon::now();
            $user->save();

            session()->forget('pending_update');

            return redirect()->route('profile.index')->with('success', 'Nomor berhasil diverifikasi dan profil diperbarui.');
        }
    }

    /**
     * Ubah password.
     */
    public function updatePassword(Request $request): JsonResponse
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
                'different:current_password',
            ],
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['errors' => [
                'current_password' => ['Password saat ini salah.']
            ]], 422);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Password berhasil diubah!'], 200);
    }

    /**
     * Hapus akun.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('success', 'Akun Anda telah dihapus.');
    }
}
