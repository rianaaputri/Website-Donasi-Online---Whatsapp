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
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        }
        
        .otp-input {
            transition: all 0.2s ease;
            letter-spacing: 8px;
            font-weight: 600;
        }
        
        .otp-input:focus {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.2);
        }
        
        .btn-verify {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.3);
        }
        
        .btn-verify:hover {
            box-shadow: 0 6px 12px rgba(37, 99, 235, 0.4);
            transform: translateY(-2px);
        }
        
        .btn-verify:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.3);
        }
        
        .countdown {
            font-variant-numeric: tabular-nums;
            font-weight: 600;
        }
        
        .progress-ring {
            transition: stroke-dashoffset 1s linear;
        }
        
        .resend-btn {
            transition: all 0.2s ease;
        }
        
        .resend-btn:hover {
            transform: translateY(-1px);
        }
        
      
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden pulse">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-500 p-5 text-center text-white">
            <div class="w-16 h-16 mx-auto bg-white/20 rounded-full flex items-center justify-center mb-3">
                <i class="fas fa-lock text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold">Verifikasi OTP</h1>
            <p class="text-blue-100 mt-1">Keamanan akun Anda adalah prioritas kami</p>
        </div>
        
        <div class="p-6 space-y-5">
            <!-- Illustration -->
            <div class="flex justify-center">
                <div class="relative">
                    <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-comment-dots text-blue-500 text-2xl"></i>
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center">
                        <i class="fas fa-key text-white text-sm"></i>
                    </div>
                </div>
            </div>

            <!-- Instructions -->
            <div class="text-center">
                <p class="text-gray-700">Masukkan 6 digit kode OTP yang dikirim ke</p>
                <p class="font-semibold text-blue-700 mt-1">WhatsApp Anda</p>
            </div>

            <!-- Form -->
            <form action="{{ route('otp.submit') }}" method="POST" class="space-y-5">
                @csrf
                
                <!-- OTP Input -->
                <div class="flex justify-center">
                    <input
                        type="text"
                        name="otp"
                        maxlength="6"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        placeholder="------"
                        required
                        autofocus
                        class="otp-input w-48 px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-center text-xl"
                    >
                </div>

                <!-- Countdown Timer -->
                <div class="flex items-center justify-center space-x-2">
                    <div class="relative">
                        <svg class="w-12 h-12 transform -rotate-90" viewBox="0 0 36 36">
                            <circle cx="18" cy="18" r="16" fill="none" class="stroke-blue-100" stroke-width="2"></circle>
                            <circle cx="18" cy="18" r="16" fill="none" class="stroke-blue-500 progress-ring" 
                                stroke-width="2" stroke-dasharray="100" stroke-dashoffset="0"></circle>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span id="countdown" class="font-semibold text-blue-600 countdown text-sm">01:00</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600">sisa waktu</p>
                </div>

                <!-- Submit Button -->
              <!-- Submit Button -->
<button
    type="submit"
    id="verifyBtn"
    disabled
    class="btn-verify w-full bg-blue-400 cursor-not-allowed text-white font-semibold py-3.5 rounded-xl transition-all duration-200 flex items-center justify-center space-x-2"
>
    <span>Verifikasi Sekarang</span>
    <i class="fas fa-arrow-right text-sm"></i>
</button>

            </form>

            <!-- Resend Button -->
            <div class="text-center pt-2">
                 <form action="{{ route('otp.resend') }}" method="POST">
                    @csrf
                 <!-- Resend Button (hidden dulu) -->
<div class="text-center pt-2">
    <form action="{{ route('otp.resend') }}" method="POST">
        @csrf
        <button 
            id="resendBtn" 
            type="submit" 
            class="hidden text-sm text-primary-600 hover:text-primary-800 font-medium 
                   flex items-center justify-center space-x-1 mx-auto">
            <i class="fas fa-redo text-xs"></i>
            <span>Kirim ulang OTP</span>
        </button>
    </form>
</div>

                </form>
            </div>

            <!-- Alert Messages -->
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
        
        <!-- Footer -->
        <div class="bg-gray-50 p-4 text-center border-t border-gray-100">
            <p class="text-xs text-gray-500">Butuh bantuan? <a href="#" class="text-blue-600 hover:underline font-medium">Hubungi kami</a></p>
        </div>
    </div>

    <script>
        // Countdown timer functionality (1 minute)
       // Countdown timer functionality (1 minute)
function startCountdown(duration, display, progressRing) {
    let timer = duration, minutes, seconds;
    const totalTime = duration;
    const circumference = 100;

    const countdownInterval = setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        // Update circular progress
        const progress = ((totalTime - timer) / totalTime) * 100;
        progressRing.style.strokeDashoffset = circumference - progress;

        if (--timer < 0) {
            clearInterval(countdownInterval);
            display.textContent = "00:00";
            display.classList.remove('text-blue-600');
            display.classList.add('text-red-500');

            // Munculin tombol resend
            document.getElementById('resendBtn').classList.remove('hidden');
        }
    }, 1000);
}

// Start countdown pas load
window.onload = function () {
    const oneMinute = 1 * 60;
    const display = document.querySelector('#countdown');
    const progressRing = document.querySelector('.progress-ring');

    progressRing.style.strokeDasharray = '100';
    progressRing.style.strokeDashoffset = '0';

    startCountdown(oneMinute, display, progressRing);
};

// Disable/enable verify button sesuai OTP
const otpInput = document.querySelector('input[name="otp"]');
const verifyBtn = document.getElementById('verifyBtn');

otpInput.addEventListener('input', function() {
    if (this.value.length === 6) {
        verifyBtn.disabled = false;
        verifyBtn.classList.remove('bg-blue-400', 'cursor-not-allowed');
        verifyBtn.classList.add('bg-blue-600', 'hover:bg-blue-700');
    } else {
        verifyBtn.disabled = true;
        verifyBtn.classList.add('bg-blue-400', 'cursor-not-allowed');
        verifyBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
    }
});

// Cegah input non-numeric
otpInput.addEventListener('keydown', function(e) {
    if (!/^\d$/.test(e.key) && e.key !== 'Backspace' && e.key !== 'Delete' && e.key !== 'ArrowLeft' && e.key !== 'ArrowRight') {
        e.preventDefault();
    }
});

        
        // Handle resend button click
        document.getElementById('resend-button').addEventListener('click', function() {
            if (this.disabled) return;
            
            // Show message
            document.getElementById('resend-message').classList.remove('hidden');
            
            // Disable button again
            this.disabled = true;
            this.classList.remove('text-blue-600', 'hover:text-blue-800', 'cursor-pointer');
            this.classList.add('text-gray-400');
            
            // Reset and restart countdown
            const display = document.querySelector('#countdown');
            const progressRing = document.querySelector('.progress-ring');
            progressRing.style.strokeDashoffset = '0';
            display.classList.remove('text-red-500');
            display.classList.add('text-blue-600');
            
            const oneMinute = 1 * 60;
            startCountdown(oneMinute, display, progressRing);
            
            // Hide message after 3 seconds
            setTimeout(() => {
                document.getElementById('resend-message').classList.add('hidden');
            }, 3000);
        });
    </script>
</body>
</html>