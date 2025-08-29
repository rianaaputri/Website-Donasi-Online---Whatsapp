<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Exception;

class LoginController extends Controller
{
    /**
     * ✅ Tampilkan halaman login
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
     * ✅ Proses login user pakai phone + password
     */
    public function login(Request $request)
    {
        try {
            Log::info("Proses login dimulai", ['phone' => $request->phone]);

            // Validasi input
            $credentials = $request->validate([
                'phone'    => ['required', 'string', 'max:20'],
                'password' => ['required'],
            ]);

            // Attempt login
            if (Auth::attempt($credentials, $request->filled('remember'))) {
                $user = Auth::user();
                Log::info("Login berhasil", [
                    'user_id' => $user->id,
                    'phone'   => $user->phone,
                    'role'    => $user->role
                ]);

                // Regenerasi session untuk keamanan
                $request->session()->regenerate();

                // 🔀 Redirect sesuai role
                if ($user->role === 'admin') {
                    return redirect()->intended(route('admin.dashboard'))
                        ->with('success', 'Selamat datang Admin!');
                } elseif ($user->role === 'campaign_creator') {
                    return redirect()->intended(route('campaign.dashboard'))
                        ->with('success', 'Selamat datang Campaign Creator!');
                } else {
                    return redirect()->intended(RouteServiceProvider::HOME)
                        ->with('success', 'Login berhasil. Selamat datang!');
                }
            }

            // ⚠️ Jika login gagal → cek user
            $user = User::where('phone', $request->phone)->first();

            if (! $user) {
                Log::warning("Login gagal: phone tidak ditemukan", ['phone' => $request->phone]);
                return back()->withErrors([
                    'phone' => 'Nomor HP tidak ditemukan dalam sistem kami.',
                ])->withInput();
            }

            Log::warning("Login gagal: password salah", ['phone' => $request->phone]);
            return back()->withErrors([
                'password' => 'Password yang Anda masukkan salah.',
            ])->withInput();

        } catch (Exception $e) {
            Log::error("Error saat login: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('error', 'Terjadi kesalahan saat login. Silakan coba lagi.');
        }
    }

    /**
     * ✅ Proses logout user
     */
    public function logout(Request $request)
    {
        try {
            $role  = auth()->check() ? auth()->user()->role : null;
            $phone = auth()->check() ? auth()->user()->phone : null;

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            Log::info("User logout", ['phone' => $phone, 'role' => $role]);

            // Redirect sesuai role
            if ($role === 'admin') {
                return redirect()->route('login')
                    ->with('success', 'Berhasil logout dari akun Admin.');
            } elseif ($role === 'campaign_creator') {
                return redirect()->route('login')
                    ->with('success', 'Berhasil logout dari akun Campaign Creator.');
            } else {
                return redirect()->route('login')
                    ->with('success', 'Berhasil logout.');
            }
        } catch (Exception $e) {
            Log::error("Error saat logout: " . $e->getMessage());
            return redirect()->route('login')->with('error', 'Terjadi kesalahan saat logout.');
        }
    }
}
