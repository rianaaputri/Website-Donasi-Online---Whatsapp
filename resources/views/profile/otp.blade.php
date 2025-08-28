<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .otp-input {
            transition: all 0.2s ease;
        }
        
        .otp-input:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
        }
        
        .step-circle {
            transition: all 0.3s ease;
        }
        
        .step-connector {
            transition: all 0.5s ease;
        }
        
        .btn-primary {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
        }
        
        .btn-primary:hover {
            box-shadow: 0 6px 10px rgba(37, 99, 235, 0.3);
            transform: translateY(-1px);
        }
        
        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
        }
        
        .countdown {
            font-variant-numeric: tabular-nums;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary-50 to-blue-100 p-4">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-xl overflow-hidden">
        <!-- Header with decorative element -->
        <div class="bg-gradient-to-r from-primary-600 to-blue-500 p-5 text-center">
            <h1 class="text-xl font-bold text-white">Verifikasi Keamanan</h1>
        </div>
        
        <div class="p-8 space-y-6">
            {{-- Step Indicator --}}
            <div class="flex items-center justify-center">
                <div class="flex items-center">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center">
                        <div class="step-circle w-12 h-12 flex items-center justify-center rounded-full bg-primary-600 text-white shadow-lg">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <p class="text-xs mt-2 font-medium text-primary-600">Verifikasi Lama</p>
                    </div>
                    
                    <!-- Connector -->
                    <div class="step-connector w-16 h-1 mx-2 bg-primary-200 relative">
                        <div class="absolute inset-0 bg-primary-600 rounded-full"></div>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <div class="step-circle w-12 h-12 flex items-center justify-center rounded-full 
                            {{ session('pending_update.step') === 'verify_new' ? 'bg-primary-600 text-white shadow-lg' : 'bg-primary-100 text-primary-400' }}">
                            <i class="fas fa-sync"></i>
                        </div>
                        <p class="text-xs mt-2 font-medium 
                            {{ session('pending_update.step') === 'verify_new' ? 'text-primary-600' : 'text-gray-400' }}">
                            Verifikasi Baru
                        </p>
                    </div>
                </div>
            </div>

            {{-- Title --}}
            <h2 class="text-2xl font-bold text-center text-gray-800">
                Verifikasi OTP
            </h2>

            {{-- Subtitle --}}
            <div class="bg-blue-50 rounded-xl p-4 text-center border border-primary-100">
                <i class="fas fa-shield-alt text-primary-600 text-2xl mb-2"></i>
                <p class="text-sm text-gray-700">
                    @if(session('pending_update.step') === 'verify_old')
                        Masukkan kode OTP yang dikirim ke 
                    @elseif(session('pending_update.step') === 'verify_new')
                        Masukkan kode OTP yang dikirim ke 
                    @endif
                </p>
                <p class="font-semibold text-primary-700 mt-1">
                    @if(session('pending_update.step') === 'verify_old')
                        {{ Auth::user()->phone }}
                    @elseif(session('pending_update.step') === 'verify_new')
                        {{ session('pending_update.phone') }}
                    @endif
                </p>
            </div>

            {{-- Form --}}
            <form action="{{ route('profile.submit.otp') }}" method="POST" class="space-y-5">
                @csrf

                {{-- OTP Input Box --}}
                <div class="flex justify-center space-x-3">
                    <input type="text" name="otp" maxlength="6" inputmode="numeric" pattern="[0-9]*"
                        class="otp-input w-48 text-center text-2xl tracking-[0.5em] px-4 py-4 rounded-xl border-2 
                               border-primary-100 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 
                               focus:outline-none transition-all duration-200"
                        placeholder="------"
                        required autofocus>
                </div>

                {{-- Countdown Timer --}}
                <div class="text-center">
                    <p class="text-sm text-gray-500">
                        Kode OTP akan kadaluarsa dalam 
                        <span id="countdown" class="font-semibold text-primary-600 countdown">01:00</span>
                    </p>
                </div>

                {{-- Submit Button --}}
                <button type="submit"
                    class="btn-primary w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3.5 rounded-xl 
                           transition-all duration-200 flex items-center justify-center space-x-2">
                    <span>Verifikasi Sekarang</span>
                    <i class="fas fa-arrow-right text-sm"></i>
                </button>
            </form>

            {{-- Resend Button --}}
            <div class="text-center pt-2">
                <form action="{{ route('profile.resend.otp') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-primary-600 hover:text-primary-800 font-medium 
                                                flex items-center justify-center space-x-1 mx-auto">
                        <i class="fas fa-redo text-xs"></i>
                        <span>Kirim ulang OTP</span>
                    </button>
                </form>
            </div>

            {{-- Alert --}}
            @if (session('gagal'))
                <div class="bg-red-50 text-red-700 px-4 py-3 rounded-lg border border-red-200 flex items-start space-x-2">
                    <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                    <p>{{ session('gagal') }}</p>
                </div>
            @endif

            @if (session('sukses'))
                <div class="bg-green-50 text-green-700 px-4 py-3 rounded-lg border border-green-200 flex items-start space-x-2">
                    <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                    <p>{{ session('sukses') }}</p>
                </div>
            @endif
        </div>
        
        <!-- Footer note -->
        <div class="bg-gray-50 p-4 text-center border-t border-gray-100">
            <p class="text-xs text-gray-500">Butuh bantuan? Hubungi <a href="#" class="text-primary-600 hover:underline">customer service</a></p>
        </div>
    </div>

    <script>
        // Countdown timer functionality
        function startCountdown(duration, display) {
            let timer = duration, minutes, seconds;
            
            const countdownInterval = setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);
                
                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;
                
                display.textContent = minutes + ":" + seconds;
                
                if (--timer < 0) {
                    clearInterval(countdownInterval);
                    display.textContent = "00:00";
                    display.classList.remove('text-primary-600');
                    display.classList.add('text-red-500');
                }
            }, 1000);
        }
        
        // Start the countdown when the page loads
        window.onload = function () {
            const twoMinutes = 1 * 60; // 2 minutes in seconds
            const display = document.querySelector('#countdown');
            startCountdown(twoMinutes, display);
        };
        
        // Auto move between OTP inputs (if we had multiple inputs)
        const otpInput = document.querySelector('input[name="otp"]');
        if (otpInput) {
            otpInput.addEventListener('input', function() {
                if (this.value.length === 6) {
                    this.blur(); // Remove focus after entry is complete
                }
            });
            
            // Prevent non-numeric input
            otpInput.addEventListener('keydown', function(e) {
                if (!/^\d$/.test(e.key) && e.key !== 'Backspace' && e.key !== 'Delete' && e.key !== 'ArrowLeft' && e.key !== 'ArrowRight') {
                    e.preventDefault();
                }
            });
        }
    </script>
</body>
</html>