<?php

use Illuminate\Support\Facades\Route;

/*
|---------------------------------------------------------------------------
| Controller imports
|---------------------------------------------------------------------------
|
| Pastikan semua controller di bawah benar-benar ada di app/Http/Controllers.
| Jika beberapa controller berada di subfolder, sesuaikan namespace import.
|
*/
use App\Http\Controllers\{
    HomeController,
    AdminController,
    MidtransController,
    ProfileController,
    DonationController,
    SupportController,
    AdminDashboardController,
    CampaignController
};

use App\Http\Controllers\Auth\{
    LoginController,
    RegisteredUserController,
    PasswordResetLinkController,
    NewPasswordController,
    VerificationController, // optional
    OtpController,          // OTP controller (verify & resend)
    CampaignCreatorRegisterController
};

use App\Http\Controllers\Admin\{
    DonationController as AdminDonationController,
    CampaignController as AdminCampaignController,
    UserController as AdminUserController
};

use App\Http\Controllers\User\CampaignController as UserCampaignController;
use App\Http\Controllers\Creator\CreatorDashboardController;

/*
|---------------------------------------------------------------------------
| Public Routes
|---------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/campaign/{id}', [HomeController::class, 'showCampaign'])->name('campaign.show');
Route::get('/campaign-detail/{id}', [CampaignController::class, 'detail'])->name('campaign.detail');

/*
|---------------------------------------------------------------------------
| Auth (Guest Only)
|---------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Register (gunakan RegisteredUserController yang sudah kita perbaiki)
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    // Password Reset
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

// Logout (method POST)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|---------------------------------------------------------------------------
| Campaign Creator Registration (Public)
|---------------------------------------------------------------------------
*/
Route::get('/register/campaign-creator', [CampaignCreatorRegisterController::class, 'showRegistrationForm'])
    ->name('campaign.creator.register.form');
Route::post('/register/campaign-creator', [CampaignCreatorRegisterController::class, 'register'])
    ->name('campaign.creator.register');

/*
|---------------------------------------------------------------------------
| OTP Verification Routes (WhatsApp)
|---------------------------------------------------------------------------
| These routes require the user to be authenticated (we store user session after
| register, then user sees the OTP form). OtpController handles show, verify, resend.
*/
Route::middleware('auth')->group(function () {
    Route::get('/otp/verify', [OtpController::class, 'showVerifyForm'])->name('verify.otp.form');
    Route::post('/otp/verify', [OtpController::class, 'verifyOtp'])->name('verify.otp');
    Route::post('/otp/resend', [OtpController::class, 'resendOtp'])->name('resend.otp');
});

/*
|---------------------------------------------------------------------------
| Email Verification Routes (Optional)
|---------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', [VerificationController::class, 'notice'])->name('verification.notice');
    Route::post('/email/verification-notification', [VerificationController::class, 'resend'])
        ->middleware('throttle:6,1')->name('verification.send');
});
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['auth', 'signed', 'throttle:6,1'])->name('verification.verify');

/*
|---------------------------------------------------------------------------
| Creator Dashboard
|---------------------------------------------------------------------------
| Protect creator/dashboard with custom otp.verified middleware (ensure OTP done)
*/
Route::get('/creator/dashboard', [CreatorDashboardController::class, 'index'])
    ->name('creator.dashboard')
    ->middleware(['auth', 'otp.verified']);

/*
|---------------------------------------------------------------------------
| Dashboard Redirect
|---------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $user = auth()->user();
    return $user && $user->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('home');
})->middleware(['auth', 'otp.verified'])->name('dashboard');

/*
|---------------------------------------------------------------------------
| Profile Routes (User)
|---------------------------------------------------------------------------
*/
Route::middleware(['auth', 'otp.verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/password/update', [PasswordController::class, 'update'])->name('profile.password.update');
});

/*
|---------------------------------------------------------------------------
| User Campaign Routes
|---------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role.check:user,campaign_creator', 'otp.verified'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/campaigns/create', [UserCampaignController::class, 'create'])->name('campaigns.create');
        Route::post('/campaigns/store', [UserCampaignController::class, 'store'])->name('campaigns.store');
        Route::get('/campaigns/history', [UserCampaignController::class, 'history'])->name('campaigns.history');

        Route::get('/campaigns/{campaign}/edit', [UserCampaignController::class, 'edit'])->name('campaigns.edit');
        Route::put('/campaigns/{campaign}', [UserCampaignController::class, 'update'])->name('campaigns.update');

        Route::get('/campaigns/{id}', [UserCampaignController::class, 'detail'])->name('campaigns.show');
        Route::get('/campaigns/{id}/donations', [UserCampaignController::class, 'donations'])->name('campaigns.donations');
    });

/*
|---------------------------------------------------------------------------
| Admin Routes
|---------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth', 'role.check:admin', 'otp.verified'])
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

        // Admin Management
        Route::get('/list-admins', [AdminController::class, 'index'])->name('list-admins');
        Route::post('/update-role', [AdminController::class, 'updateRole'])->name('update-role');
        Route::post('/update-status', [AdminController::class, 'updateStatus'])->name('update-status');
        Route::post('/verify-email', [AdminController::class, 'verifyEmail'])->name('verify-email');
        Route::post('/show-user', [AdminController::class, 'showUser'])->name('show-user');
        Route::get('/show-user/{id}', [AdminController::class, 'showUserDetail'])->name('show-user-detail');
        Route::delete('/delete-admin/{id}', [AdminController::class, 'deleteAdmin'])->name('delete-admin');

        // User Management
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [AdminUserController::class, 'index'])->name('index');
            Route::get('/create', [AdminUserController::class, 'create'])->name('create');
            Route::post('/', [AdminUserController::class, 'store'])->name('store');
            Route::get('/{user}', [AdminUserController::class, 'show'])->name('show');
            Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [AdminUserController::class, 'update'])->name('update');
            Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy');

            Route::patch('/{user}/status', [AdminUserController::class, 'updateStatus'])->name('update-status');
            Route::patch('/{user}/verify-email', [AdminUserController::class, 'verifyEmail'])->name('verify-email');
            Route::get('/{user}/campaigns', [AdminUserController::class, 'campaigns'])->name('campaigns');
            Route::get('/{user}/donations', [AdminUserController::class, 'donations'])->name('donations');
            Route::post('/bulk-action', [AdminUserController::class, 'bulkAction'])->name('bulk-action');
        });

        // Campaign Verification
        Route::get('/campaigns/verify', [AdminCampaignController::class, 'verifyIndex'])->name('campaigns.verify');
        Route::patch('/campaigns/{campaign}/verify', [AdminCampaignController::class, 'verifyApprove'])->name('campaigns.verify.approve');
        Route::patch('/campaigns/{campaign}/reject', [AdminCampaignController::class, 'verifyReject'])->name('campaigns.verify.reject');

        // CRUD Campaign
        Route::prefix('campaigns')->name('campaigns.')->group(function () {
            Route::get('/', [AdminCampaignController::class, 'index'])->name('index');
            Route::get('/create', [AdminCampaignController::class, 'create'])->name('create');
            Route::post('/', [AdminCampaignController::class, 'store'])->name('store');
            Route::get('/{campaign}', [AdminCampaignController::class, 'show'])->name('show');
            Route::get('/{campaign}/edit', [AdminCampaignController::class, 'edit'])->name('edit');
            Route::put('/{campaign}', [AdminCampaignController::class, 'update'])->name('update');
            Route::delete('/{campaign}', [AdminCampaignController::class, 'destroy'])->name('destroy');

            Route::patch('/{campaign}/status', [AdminCampaignController::class, 'updateStatus'])->name('update-status');
            Route::get('/{campaign}/donations', [AdminCampaignController::class, 'donations'])->name('donations');
            Route::post('/bulk-action', [AdminCampaignController::class, 'bulkAction'])->name('bulk-action');
        });

        // Donations
        Route::get('/donations', [AdminDonationController::class, 'index'])->name('donations.index');
        Route::get('/donations/{donation}', [AdminDonationController::class, 'show'])->name('donations.show');
        Route::patch('/donations/{donation}/status', [AdminDonationController::class, 'updateStatus'])->name('donations.update-status');
    });

/*
|---------------------------------------------------------------------------
| Donation Public Routes
|---------------------------------------------------------------------------
*/
Route::prefix('donation')->name('donation.')->group(function () {
    Route::get('/', [DonationController::class, 'index'])->name('index');
    Route::get('/create/{campaign}', [DonationController::class, 'create'])->name('create');
    Route::post('/', [DonationController::class, 'store'])->name('store');
    Route::get('/payment/{donation}', [DonationController::class, 'payment'])->name('payment');
    Route::get('/success/{donation}', [DonationController::class, 'success'])->name('success');
    Route::get('/status/{donation}', [DonationController::class, 'checkStatus'])->name('status');

    Route::middleware(['auth', 'role.check:user,campaign_creator', 'otp.verified'])->group(function () {
        Route::get('/history', [DonationController::class, 'myDonations'])->name('history');
        Route::get('/pending', [DonationController::class, 'pending'])->name('pending');
        Route::get('/{id}/edit', [DonationController::class, 'edit'])->name('edit');
        Route::put('/{id}', [DonationController::class, 'update'])->name('update');
    });
});

/*
|---------------------------------------------------------------------------
| Midtrans Callback
|---------------------------------------------------------------------------
*/
Route::post('/midtrans/callback', [MidtransController::class, 'handleCallback'])->name('midtrans.callback');

/*
|---------------------------------------------------------------------------
| Support Pages
|---------------------------------------------------------------------------
*/
Route::get('/faq', [SupportController::class, 'faq'])->name('faq');
Route::get('/cara-berdonasi', [SupportController::class, 'donationGuide'])->name('donation.guide');
Route::get('/hubungi-kami', [SupportController::class, 'contact'])->name('contact');
Route::post('/hubungi-kami', [SupportController::class, 'sendContact'])->name('contact.send');
Route::get('/pusat-bantuan', [SupportController::class, 'supportCenter'])->name('support.center');
