<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Exception;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLoginForm()
    {
        try {
            Log::info("Akses halaman login");
            return view('auth.login');
        } catch (Exception $e) {
            Log::error("Gagal load halaman login: " . $e->getMessage());
            abort(500, "Terjadi kesalahan pada server.");
        }
    }

    /**
     * Proses login user
     */
    public function login(Request $request)
    {
        try {
            Log::info("Proses login dimulai", ['email' => $request->email]);

            $credentials = $request->validate([
                'email'    => ['required', 'email'],
                'password' => ['required'],
            ]);

            // Coba autentikasi
            if (Auth::attempt($credentials, $request->filled('remember'))) {

                // Regenerasi session demi keamanan
                $request->session()->regenerate();

                $user = Auth::user();
                Log::info("Login berhasil", ['user_id' => $user->id, 'email' => $user->email]);

                // 1) Jika sistem menggunakan OTP (kolom is_verified) -> cek OTP
                if (isset($user->is_verified) && $user->is_verified === false) {
                    // Tetap biarkan login agar user bisa lihat form OTP/resend.
                    return redirect()->route('verify.otp.form')
                        ->with('warning', 'Akun Anda belum diverifikasi. Kode OTP sudah dikirim ke WhatsApp. Silakan masukkan kode OTP.');
                }

                // 2) Jika tidak menggunakan OTP, fallback ke email verification bila tersedia
                if (method_exists($user, 'hasVerifiedEmail') && ! $user->hasVerifiedEmail()) {
                    return redirect()->route('verification.notice')
                        ->with('warning', 'Akun Anda belum diverifikasi melalui email. Silakan cek email untuk link verifikasi.');
                }

                // 3) Semua oke -> redirect sesuai role
                if ($user->role === 'admin') {
                    return redirect()->intended(route('admin.dashboard'))->with('success', 'Selamat datang Admin!');
                }

                return redirect()->intended(RouteServiceProvider::HOME)->with('success', 'Login berhasil. Selamat datang!');
            }

            // Jika gagal autentikasi -> cari user berdasarkan email untuk pesan yang lebih informatif
            $user = User::where('email', $request->email)->first();

            if (! $user) {
                Log::warning("Login gagal: email tidak ditemukan", ['email' => $request->email]);
                return back()->withErrors([
                    'email' => 'Email tidak ditemukan dalam sistem kami.',
                ])->withInput();
            }

            // Jika user ditemukan, cek apakah password salah
            if (! Hash::check($request->password, $user->password)) {
                Log::warning("Login gagal: password salah", ['email' => $request->email, 'user_id' => $user->id]);
                return back()->withErrors([
                    'password' => 'Password yang Anda masukkan salah.',
                ])->withInput();
            }

            // Fallback umum
            Log::warning("Login gagal: alasan tidak diketahui", ['email' => $request->email]);
            return back()->withErrors([
                'email' => 'Gagal login. Silakan coba lagi.',
            ])->withInput();

        } catch (Exception $e) {
            Log::error("Error saat login: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('error', 'Terjadi kesalahan saat login. Silakan coba lagi.');
        }
    }

    /**
     * Proses logout user
     */
    public function logout(Request $request)
    {
        try {
            $role = auth()->check() ? auth()->user()->role : null;
            $email = auth()->check() ? auth()->user()->email : null;

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            Log::info("User logout", ['email' => $email, 'role' => $role]);

            return $role === 'admin'
                ? redirect()->route('login')->with('success', 'Berhasil logout dari akun Admin.')
                : redirect(RouteServiceProvider::HOME)->with('success', 'Berhasil logout.');
        } catch (Exception $e) {
            Log::error("Error saat logout: " . $e->getMessage());
            return redirect()->route('login')->with('error', 'Terjadi kesalahan saat logout.');
        }
    }
}
