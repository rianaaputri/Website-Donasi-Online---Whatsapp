<?php

namespace App\Http\Controllers;

use App\Models\Admin; 
use App\Models\User;  
use App\Models\Otp;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;

use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\ValidationException; // Pastikan ini diimport
use Illuminate\Support\Facades\Log; // Pastikan ini diimport

class AuthController extends Controller
{
    // --- Metode untuk Menampilkan Halaman Login (Universal) ---
    public function showLogin()
    {
        return view('auth.login'); 
    }

    // --- Metode untuk Menangani Proses Login (Universal) ---
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        Log::info('--- LOGIN ATTEMPT START ---');
        Log::info('Request IP: ' . $request->ip());
        Log::info('User-Agent: ' . $request->header('User-Agent'));
        Log::info('Attempting login for email: ' . $request->email);
        Log::info('Remember me: ' . ($request->filled('remember') ? 'Yes' : 'No'));

        // ===============================================================
        // DEBUGGING STEP 1: Coba login sebagai ADMIN
        // ===============================================================
        $adminAttempt = Auth::guard('admin')->attempt($credentials, $request->filled('remember'));
        
        if ($adminAttempt) {
            $request->session()->regenerate();
            Log::info('Admin login SUCCESS for email: ' . $request->email);
            Log::info('Admin current user after login: ' . json_encode(Auth::guard('admin')->user()));
            Log::info('Redirecting admin to: ' . session()->get('url.intended', route('admin.dashboard')));
            return redirect()->intended(route('admin.dashboard')); 
        }
        
        Log::warning('Admin login FAILED for email: ' . $request->email);
        Log::warning('Reasons for admin login failure (check credentials, password hash, config/auth.php, and admin table):');
        // Anda bisa menambahkan debug lebih lanjut di sini jika perlu, misal:
        // dump(Auth::guard('admin')->validate($credentials)); // ini akan return boolean true/false
        // dump($credentials); 

        // ===============================================================
        // DEBUGGING STEP 2: Coba login sebagai USER BIASA (jika admin gagal)
        // ===============================================================
        $userAttempt = Auth::guard('web')->attempt($credentials, $request->filled('remember'));

        if ($userAttempt) {
            $request->session()->regenerate();
            Log::info('User login SUCCESS for email: ' . $request->email);
            Log::info('User current user after login: ' . json_encode(Auth::guard('web')->user()));
            Log::info('Redirecting user to: ' . session()->get('url.intended', route('home')));
            return redirect()->intended(route('home')); 
        }

        // ===============================================================
        // DEBUGGING STEP 3: Kedua login gagal
        // ===============================================================
        Log::error('Both admin and user login FAILED for email: ' . $request->email);
        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    // --- Metode untuk Menangani Proses Logout (Universal) ---
    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('admin.login')->with('success', 'Admin berhasil logout.');
        } 
        elseif (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('success', 'Anda berhasil logout.');
        }

        return redirect('/'); 
    }

    public function create(): View
    {
        return view('auth.register');
    }
 private function kirimOtp($phone, $nama)
{
    $otp = rand(100000, 999999);

    // Simpan ke DB
    Otp::create([
        'user_id'   => Auth::id(),
        'phone'     => $phone,
        'code'      => $otp,
        'expired_at'=> Carbon::now()->addMinutes(1),
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
    public function store(Request $request): RedirectResponse
    {
      $validate = $request->validate([
    'name' => ['required', 'string', 'max:255'],
    'phone' => ['required', 'string', 'min:10', 'unique:' . User::class],
    'role' => ['required', 'string', 'in:admin,user,campaign_creator'],
    'password' => ['required', 'confirmed', Password::defaults()],
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

    return redirect()->route('home.index')->with('sukses', 'Registrasi berhasil!');
}
}
