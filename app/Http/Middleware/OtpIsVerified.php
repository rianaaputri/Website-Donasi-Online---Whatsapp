<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class OtpVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && !$user->is_verified) {
            return redirect()->route('verify.otp.form')->with('error', 'Silakan verifikasi OTP terlebih dahulu.');
        }

        return $next($request);
    }
}
