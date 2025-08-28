<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'kindify.id - Platform Donasi Online')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #4a90e2;
            --light-blue: #6bb6ff;
            --dark-blue: #2c5aa0;
            --bg-light: #f8f9fa;
            --text-dark: #2c3e50;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-light);
        }

        /* Navbar Styling */
        .navbar {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--light-blue) 100%);
            box-shadow: 0 2px 15px rgba(74, 144, 226, 0.2);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: bold;
            color: white !important;
            font-size: 1.5rem;
        }

        .navbar-nav .nav-link {
            color: white !important;
            margin: 0 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #e3f2fd !important;
            transform: translateY(-1px);
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            border-radius: 10px;
        }

        .dropdown-item:hover {
            background-color: var(--primary-blue);
            color: white;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--light-blue) 100%);
            color: white;
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="1" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="1" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        }

        .hero-section .container {
            position: relative;
            z-index: 2;
        }

        .btn-light {
            background-color: white;
            color: var(--primary-blue);
            border: none;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .btn-light:hover {
            background-color: #f0f8ff;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.3);
            color: var(--primary-blue);
        }

        /* Statistics Section */
        .stats-section {
            background: white;
            padding: 60px 0;
            margin-top: -30px;
            position: relative;
            z-index: 3;
            border-radius: 20px 20px 0 0;
        }

        .stat-card {
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(74, 144, 226, 0.1);
            transition: all 0.3s ease;
            margin-bottom: 2rem;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(74, 144, 226, 0.2);
        }

        .stat-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2rem;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--primary-blue);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #6c757d;
            font-size: 1.1rem;
            font-weight: 500;
        }

        /* Campaign Cards */
        .campaign-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            overflow: hidden;
            transition: all 0.3s ease;
            border: none;
            height: 100%;
        }

        .campaign-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }

        .campaign-card .card-img-top {
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .campaign-card:hover .card-img-top {
            transform: scale(1.05);
        }

        .campaign-card .card-body {
            padding: 1.5rem;
        }

        .campaign-card .badge {
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            border: none;
            padding: 6px 12px;
            font-size: 0.8rem;
            margin-bottom: 1rem;
        }

        .campaign-card h5 {
            color: var(--text-dark);
            font-weight: bold;
            margin-bottom: 1rem;
            height: 3em;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .progress-custom {
            height: 10px;
            border-radius: 10px;
            background-color: #e9ecef;
            margin: 1rem 0;
            overflow: hidden;
        }

        .progress-bar {
            background: linear-gradient(90deg, var(--primary-blue), var(--light-blue));
            border-radius: 10px;
            transition: width 0.6s ease;
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-blue);
            color: var(--primary-blue);
            font-weight: 600;
            padding: 10px 25px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            border-color: var(--primary-blue);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(74, 144, 226, 0.3);
        }

        /* Section Titles */
        .section-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }

        .section-subtitle {
            color: #6c757d;
            font-size: 1.2rem;
            margin-bottom: 3rem;
        }

        /* Footer */
        footer {
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--primary-blue) 100%);
            color: white;
            padding: 60px 0 30px 0;
        }

        .footer-brand {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .footer-description {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: white;
            text-decoration: none;
            opacity: 0.8;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            opacity: 1;
            color: #e3f2fd;
        }

        .social-icons a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            margin-right: 15px;
            color: white;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 40px;
            padding-top: 30px;
            text-align: center;
        }

        .footer-bottom p {
            margin: 0;
            opacity: 0.8;
            font-size: 0.9rem;
        }

        /* Alert Styling */
        .alert {
            border: none;
            border-radius: 10px;
            font-weight: 500;
        }

        .alert-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .alert-danger {
            background: linear-gradient(135deg, #dc3545, #fd7e14);
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-section {
                padding: 60px 0;
            }

            .section-title {
                font-size: 2rem;
            }

            .stat-number {
                font-size: 2rem;
            }

            .footer-brand {
                font-size: 1.5rem;
            }

            .social-icons {
                text-align: center;
                margin-top: 30px;
            }
        }
    </style>
</head>
<body>
    <!-- Notifikasi Sukses -->
    @if(session('success'))
        <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
            <div class="toast show bg-success text-white" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-success text-white">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong class="me-auto">Berhasil</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    <!-- Notifikasi Error -->
    @if(session('error'))
        <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
            <div class="toast show bg-danger text-white" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-danger text-white">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong class="me-auto">Gagal</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    {{ session('error') }}
                </div>
            </div>
        </div>
    @endif
<!-- Navigation -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="fas fa-heart me-2"></i> kindify.id
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#campaigns">Program</a>
                </li>
            </ul>
            
            <ul class="navbar-nav">
@guest
    <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}">Masuk</a>
    </li>
    <li class="nav-item ms-2">
        <a class="btn btn-light btn-sm" href="{{ route('register') }}">Daftar</a>
    </li>
@else
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
            <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
        </a>
        <ul class="dropdown-menu">
            <!-- Role: Admin -->
            @if (Auth::user()->role === 'admin')
                <li>
                    <a class="dropdown-item" href="{{ route('profile.show') }}">
                        <i class="fas fa-user me-2"></i>Profil Saya
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Admin Panel
                    </a>
                </li>

            <!-- Role: campaign_creator -->
            @elseif (Auth::user()->role === 'campaign_creator')
                <li>
                    <a class="dropdown-item" href="{{ route('creator.dashboard') }}">
                        <i class="fas fa-bullhorn me-2"></i>Dashboard Creator
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('user.campaigns.create') }}">
                        <i class="fas fa-plus-circle me-2"></i>Buat Campaign Baru
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('user.campaigns.history') }}">
                        <i class="fas fa-list-alt me-2"></i>History Campaign
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('donation.history') }}">
                        <i class="fas fa-history me-2"></i>Riwayat Donasi
                    </a>
                </li>

            <!-- Role: user (donatur biasa) -->
            @elseif (Auth::user()->role === 'user')
                <li>
                    <a class="dropdown-item" href="{{ route('profile.show') }}">
                        <i class="fas fa-user me-2"></i>Profil Saya
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('donation.history') }}">
                        <i class="fas fa-history me-2"></i>Riwayat Donasi
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('user.campaigns.history') }}">
                        <i class="fas fa-list-alt me-2"></i>History Campaign
                    </a>
                </li>
            @endif

            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </li>
@endguest

            </ul>
        </div>
    </div>
</nav>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
            <div class="container">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
            <div class="container">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    @push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toasts = document.querySelectorAll('.toast');
        toasts.forEach(toastEl => {
            const toast = new bootstrap.Toast(toastEl, { delay: 5000 });
            toast.show();
        });
    });
</script>
@endpush
</body>
</html>