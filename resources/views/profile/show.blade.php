<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap 5.3 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Poppins Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* ===== CSS VARIABLES ===== */
        :root {
            --primary: #007AFF;
            --primary-light: #E3F2FD;
            --primary-dark: #0056CC;
            --secondary: #8E8E93;
            --success: #34C759;
            --danger: #FF3B30;
            --warning: #FF9500;
            --info: #5AC8FA;
            --light: #F2F2F7;
            --dark: #1C1C1E;
            --white: #ffffff;
            --gradient-primary: linear-gradient(135deg, #007AFF 0%, #5AC8FA 50%, #AF52DE 100%);
            --gradient-bg: linear-gradient(135deg, #F2F2F7 0%, #ffffff 100%);
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.12);
            --shadow: 0 2px 8px rgba(0, 0, 0, 0.10);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.15);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.15);
            --shadow-xl: 0 16px 40px rgba(0, 0, 0, 0.20);
            --border-radius: 12px;
            --border-radius-lg: 16px;
            --border-radius-xl: 20px;
            --transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            --transition-fast: all 0.15s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        /* ===== GLOBAL STYLES WITH POPPINS FONT ===== */
        * {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, "SF Pro Display", "SF Pro Text", "Helvetica Neue", Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        body {
            background: var(--gradient-bg);
            color: var(--dark);
            line-height: 1.47059;
            font-weight: 400;
            letter-spacing: -0.022em;
            overflow-x: hidden;
        }
        .container-fluid {
            max-width: 1400px;
        }
        /* ===== ANIMATIONS ===== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 40px, 0);
            }
            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translate3d(0, -30px, 0);
            }
            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translate3d(30px, 0, 0);
            }
            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94) both;
        }
        .animate-fade-in-down {
            animation: fadeInDown 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94) both;
        }
        .animate-fade-in {
            animation: fadeIn 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94) both;
        }
        .animate-slide-in-right {
            animation: slideInRight 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94) both;
        }
        /* ===== STAGGER ANIMATIONS ===== */
        .stagger > *:nth-child(1) { animation-delay: 0.1s; }
        .stagger > *:nth-child(2) { animation-delay: 0.2s; }
        .stagger > *:nth-child(3) { animation-delay: 0.3s; }
        .stagger > *:nth-child(4) { animation-delay: 0.4s; }
        .stagger > *:nth-child(5) { animation-delay: 0.5s; }
        /* ===== HEADER STYLES ===== */
        .page-header {
            text-align: center;
            padding: 3rem 0 2rem;
        }
        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
            letter-spacing: -0.04em;
        }
        .page-subtitle {
            font-size: 1.125rem;
            color: var(--secondary);
            font-weight: 400;
            max-width: 600px;
            margin: 0 auto;
        }
        /* ===== PROFILE CARD ===== */
        .profile-card {
            background: var(--white);
            border-radius: var(--border-radius-xl);
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(0, 0, 0, 0.04);
            overflow: hidden;
            transition: var(--transition);
        }
        .profile-header {
            background: var(--gradient-primary);
            padding: 3rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .profile-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="25" cy="75" r="1" fill="%23ffffff" opacity="0.05"/><circle cx="75" cy="25" r="1" fill="%23ffffff" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        }
        .avatar {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 255, 255, 0.25);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: var(--white);
            margin: 0 auto 1.5rem;
            position: relative;
            z-index: 1;
            transition: var(--transition);
        }
        .avatar:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }
        .profile-name {
            color: var(--white);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
            letter-spacing: -0.025em;
        }
        .profile-role {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.125rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 1;
        }
        /* ===== BADGES ===== */
        .badge-custom {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.25rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.875rem;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 1;
            transition: var(--transition);
        }
        .badge-verified {
            background: rgba(52, 199, 89, 0.2);
            color: var(--white);
            border-color: rgba(255, 255, 255, 0.3);
        }
        .badge-unverified {
            background: rgba(255, 149, 0, 0.2);
            color: var(--white);
            border-color: rgba(255, 255, 255, 0.3);
        }
        /* ===== BUTTONS ===== */
        .btn {
            border-radius: var(--border-radius);
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: var(--transition);
            border: 1px solid transparent;
            position: relative;
            overflow: hidden;
            min-width: 120px;
            letter-spacing: -0.01em;
        }
        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transition: var(--transition);
            transform: translate(-50%, -50%);
            z-index: 0;
        }
        .btn:hover::before {
            width: 300px;
            height: 300px;
        }
        .btn > * {
            position: relative;
            z-index: 1;
        }
        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
            color: var(--white);
        }
        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
            background: transparent;
        }
        .btn-outline-primary:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: var(--white);
            transform: translateY(-2px);
        }
        .btn-light {
            background: rgba(255, 255, 255, 0.9);
            color: var(--dark);
            border-color: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(20px);
        }
        .btn-light:hover {
            background: var(--white);
            color: var(--primary);
            transform: translateY(-2px);
        }
        .btn-success {
            background: var(--success);
            border-color: var(--success);
            color: var(--white);
        }
        .btn-success:hover {
            background: #28a745;
            border-color: #28a745;
            color: var(--white);
            transform: translateY(-2px);
        }
        /* ===== LOADING STATE ===== */
        .btn-loading {
            color: transparent;
            pointer-events: none;
        }
        .btn-loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid currentColor;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s linear infinite;
        }
        /* ===== CONTENT SECTIONS ===== */
        .content-section {
            padding: 2.5rem;
        }
        .info-card {
            background: var(--white);
            border: 1px solid rgba(0, 0, 0, 0.04);
            border-radius: var(--border-radius-lg);
            padding: 2rem;
            box-shadow: var(--shadow);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }
        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--gradient-primary);
            transition: var(--transition);
        }
        .info-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }
        .info-card:hover::before {
            width: 6px;
        }
        .card-title {
            color: var(--dark);
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--light);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            letter-spacing: -0.025em;
        }
        .info-item {
            margin-bottom: 1.5rem;
        }
        .info-item:last-child {
            margin-bottom: 0;
        }
        .info-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--secondary);
            margin-bottom: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .info-value {
            font-size: 1rem;
            font-weight: 500;
            color: var(--dark);
            padding: 1rem;
            background: var(--light);
            border-radius: var(--border-radius);
            border: 2px solid transparent;
            min-height: 3rem;
            display: flex;
            align-items: center;
            transition: var(--transition);
        }
        /* ===== FORM STYLES ===== */
        .form-control {
            border: 2px solid rgba(0, 0, 0, 0.08);
            border-radius: var(--border-radius);
            padding: 1rem;
            font-size: 1rem;
            transition: var(--transition);
            background: var(--white);
            font-weight: 500;
            letter-spacing: -0.01em;
        }
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(0, 122, 255, 0.1);
            background: var(--white);
            outline: none;
        }
        .form-control::placeholder {
            color: var(--secondary);
            font-weight: 400;
        }
        /* ===== PASSWORD POPUP MODAL ===== */
        .password-modal .modal-content {
            border: none;
            border-radius: var(--border-radius-xl);
            box-shadow: var(--shadow-xl);
            backdrop-filter: blur(20px);
        }
        .password-modal .modal-header {
            background: var(--gradient-primary);
            color: var(--white);
            border: none;
            border-radius: var(--border-radius-xl) var(--border-radius-xl) 0 0;
            padding: 2rem;
        }
        .password-modal .modal-title {
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: -0.025em;
        }
        .password-modal .btn-close {
            filter: invert(1);
            opacity: 0.8;
        }
        .password-modal .modal-body {
            padding: 2rem;
        }
        .password-modal .modal-footer {
            border: none;
            padding: 1rem 2rem 2rem;
            justify-content: center;
            gap: 1rem;
        }
        .password-modal .form-group {
            margin-bottom: 1.5rem;
        }
        .password-modal .form-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.75rem;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .password-modal .input-group {
            position: relative;
        }
        .password-modal .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--secondary);
            font-size: 1.1rem;
            cursor: pointer;
            z-index: 3;
            padding: 0.5rem;
            border-radius: 50%;
            transition: var(--transition);
        }
        .password-modal .toggle-password:hover {
            color: var(--primary);
            background: rgba(0, 122, 255, 0.1);
        }
        .password-modal .form-control {
            padding-right: 3.5rem;
        }
        /* ===== ALERTS ===== */
        .alert {
            border: none;
            border-radius: var(--border-radius);
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
            border-left: 4px solid;
            backdrop-filter: blur(20px);
        }
        .alert-success {
            background: rgba(52, 199, 89, 0.1);
            color: var(--success);
            border-left-color: var(--success);
        }
        .alert-danger {
            background: rgba(255, 59, 48, 0.1);
            color: var(--danger);
            border-left-color: var(--danger);
        }
        .alert-info {
            background: rgba(90, 200, 250, 0.1);
            color: var(--info);
            border-left-color: var(--info);
        }
        /* ===== DROPDOWN ===== */
        .dropdown-menu {
            border: 1px solid rgba(0, 0, 0, 0.04);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            background: var(--white);
            padding: 0.5rem;
            backdrop-filter: blur(20px);
        }
        .dropdown-item {
            border-radius: var(--border-radius);
            padding: 0.75rem 1rem;
            margin-bottom: 0.25rem;
            transition: var(--transition);
            color: var(--dark);
            font-weight: 500;
        }
        .dropdown-item:hover {
            background: var(--primary-light);
            color: var(--primary);
            transform: translateX(4px);
        }
        .dropdown-item.text-danger {
            color: var(--danger) !important;
        }
        .dropdown-item.text-danger:hover {
            background: rgba(255, 59, 48, 0.1);
            color: var(--danger) !important;
        }
        /* ===== MODE TRANSITIONS ===== */
        .mode-transition {
            transition: var(--transition);
        }
        .edit-mode-enter {
            opacity: 0;
            transform: translateY(-10px);
        }
        .edit-mode-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition: var(--transition);
        }
        .view-mode-enter {
            opacity: 0;
            transform: translateY(10px);
        }
        .view-mode-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition: var(--transition);
        }
        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 991.98px) {
            .page-title {
                font-size: 2rem;
            }
            .profile-header {
                padding: 2rem 1.5rem;
            }
            .content-section {
                padding: 2rem 1.5rem;
            }
            .info-card {
                padding: 1.5rem;
                margin-bottom: 1.5rem;
            }
        }
        @media (max-width: 575.98px) {
            .page-title {
                font-size: 1.75rem;
            }
            .avatar {
                width: 100px;
                height: 100px;
                font-size: 2.5rem;
            }
            .profile-name {
                font-size: 1.75rem;
            }
            .profile-role {
                font-size: 1rem;
            }
            .btn {
                width: 100%;
                justify-content: center;
            }
            .info-card {
                padding: 1.25rem;
            }
            .password-modal .modal-body {
                padding: 1.5rem;
            }
        }
        /* ===== UTILITY CLASSES ===== */
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .text-gradient {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hover-scale:hover {
            transform: scale(1.02);
        }
        .hover-lift:hover {
            transform: translateY(-2px);
        }
        /* ===== CUSTOM SCROLLBAR ===== */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--light);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb {
            background: var(--primary-light);
            border-radius: 4px;
            transition: var(--transition);
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }
    </style>
</head>
<body>
 

    <div class="container-fluid px-3 px-md-4">
        <header class="page-header animate-fade-in-down">
            <h1 class="page-title">
                <i class="fas fa-user-circle text-gradient me-3"></i>
                Profil Saya
            </h1>
            <p class="page-subtitle">
                Kelola informasi akun dan pengaturan profil Anda dengan mudah dan aman
            </p>
        </header>

        <div class="row" id="alerts-container">
            <div class="col-12">
                <div class="alert alert-success animate-fade-in d-none" id="success-alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <span>Profil berhasil diperbarui!</span>
                    <button type="button" class="btn-close ms-auto" onclick="closeAlert('success-alert')"></button>
                </div>
                <div class="alert alert-danger animate-fade-in d-none" id="error-alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <span>Terjadi kesalahan saat memperbarui profil.</span>
                    <button type="button" class="btn-close ms-auto" onclick="closeAlert('error-alert')"></button>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="profile-card animate-fade-in-up">
                    <div class="profile-header">
                        <div class="container-fluid">
                            <div class="row align-items-center">
                                <div class="col-lg-8">
                                    <div class="avatar hover-scale">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <h2 class="profile-name" id="displayName">{{ Auth::user()->name }}</h2>
                                    <p class="profile-role">
                                        <i class="fas fa-user-tag me-2"></i>
                                        {{ ucfirst(Auth::user()->role ?? 'User') }}
                                    </p>
                                    
                                </div>
                                <div class="col-lg-4">
                                    <div class="d-flex flex-column gap-3 align-items-center mt-4 mt-lg-0">
                                        <button class="btn btn-light hover-lift" onclick="toggleEditMode()" id="editBtn">
                                            <i class="fas fa-edit me-2"></i>Edit Profil
                                        </button>
                                        <div class="dropdown">
                                            <button class="btn btn-light dropdown-toggle hover-lift" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v me-2"></i>Menu
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="/"><i class="fas fa-home me-2 text-primary"></i>Beranda</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="showPasswordModal()"><i class="fas fa-key me-2 text-warning"></i>Ubah Password</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#" onclick="logout()"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="content-section">
                        <form id="profileForm" action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="info-card hover-lift animate-fade-in-up stagger">
                                        <h4 class="card-title"><i class="fas fa-user text-primary"></i> Informasi Personal</h4>
                                        <div class="info-item mode-transition">
                                            <div class="info-label">Nama Lengkap</div>
                                            <div class="view-mode"><div class="info-value" id="displayNameValue">{{ Auth::user()->name }}</div></div>
                                            <div class="edit-mode d-none"><input type="text" class="form-control" name="name" id="nameInput" value="{{ Auth::user()->name }}" required></div>
                                        </div>
                                  
                                        <div class="info-item mode-transition">
                                            <div class="info-label">Nomor Telepon</div>
                                            <div class="view-mode"><div class="info-value" id="phoneDisplayValue">{{ Auth::user()->phone ?? 'Belum diisi' }}</div></div>
                                            <div class="edit-mode d-none"><input type="tel" class="form-control" name="phone" id="phoneInput" value="{{ Auth::user()->phone }}" placeholder="Contoh: 081234567890" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required></div>
                                        </div>
                                        <div class="info-item mode-transition">
                                            <div class="info-label">Alamat</div>
                                            <div class="view-mode"><div class="info-value" id="addressDisplayValue">{{ Auth::user()->address ?? 'Belum diisi' }}</div></div>
                                            <div class="edit-mode d-none"><textarea class="form-control" name="address" id="addressInput" rows="3" placeholder="Masukkan alamat lengkap" required>{{ Auth::user()->address }}</textarea></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="info-card hover-lift animate-fade-in-up stagger">
                                        <h4 class="card-title"><i class="fas fa-cog text-primary"></i> Informasi Akun</h4>
                                        <div class="info-item">
                                            <div class="info-label">Bergabung Sejak</div>
                                            <div class="info-value"><i class="fas fa-calendar-alt me-2 text-primary"></i>{{ Auth::user()->created_at->translatedFormat('d F Y') }}</div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-label">Update Terakhir</div>
                                            <div class="info-value"><i class="fas fa-clock me-2 text-primary"></i>{{ Auth::user()->updated_at->translatedFormat('d F Y H:i') }}</div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-label">Status Akun</div>
                                            <div class="info-value">
                                                @if(Auth::user()->is_active ?? true)
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2"><i class="fas fa-check-circle me-1"></i>Aktif</span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-2"><i class="fas fa-times-circle me-1"></i>Tidak Aktif</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-12">
                                    <div class="text-center">
                                        <div class="view-mode">
                                            <div class="d-flex flex-wrap gap-3 justify-content-center">
                                                <a href="/" class="btn btn-outline-primary hover-lift"><i class="fas fa-home me-2"></i>Kembali ke Beranda</a>
                                               
                                            </div>
                                        </div>
                                        <div class="edit-mode d-none">
                                            <div class="d-flex flex-wrap gap-3 justify-content-center">
                                                <button type="submit" class="btn btn-success hover-lift" id="saveBtn">
                                                    <i class="fas fa-save me-2"></i>
                                                    <span class="btn-text">Simpan Perubahan</span>
                                                </button>
                                                <button type="button" class="btn btn-outline-secondary hover-lift" onclick="cancelEdit()">
                                                    <i class="fas fa-times me-2"></i>Batal
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Password Modal -->
    <div class="modal fade password-modal" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordModalLabel"><i class="fas fa-key me-2"></i> Ubah Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="passwordForm" action="{{ route('profile.password.update') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="currentPassword" class="form-label">Password Saat Ini</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="currentPassword" name="current_password" required>
                                <button type="button" class="toggle-password" onclick="togglePasswordVisibility('currentPassword')"><i class="fas fa-eye"></i></button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="newPassword" class="form-label">Password Baru</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="newPassword" name="password" required minlength="6">
                                <button type="button" class="toggle-password" onclick="togglePasswordVisibility('newPassword')"><i class="fas fa-eye"></i></button>
                            </div>
                            <small class="form-text text-muted mt-1">Minimal 6 karakter</small>
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword" class="form-label">Konfirmasi Password Baru</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="confirmPassword" name="password_confirmation" required>
                                <button type="button" class="toggle-password" onclick="togglePasswordVisibility('confirmPassword')"><i class="fas fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Batal</button>
                        <button type="submit" class="btn btn-primary" id="changePasswordBtn">
                            <i class="fas fa-save me-2"></i>
                            <span class="btn-text">Ubah Password</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Toast -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 11;">
        <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert">
            <div class="d-flex"><div class="toast-body"><i class="fas fa-check-circle me-2"></i><span id="successToastMessage">Operasi berhasil!</span></div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>
        </div>
        <div id="errorToast" class="toast align-items-center text-bg-danger border-0" role="alert">
            <div class="d-flex"><div class="toast-body"><i class="fas fa-exclamation-triangle me-2"></i><span id="errorToastMessage">Terjadi kesalahan!</span></div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>
        </div>
        <div id="infoToast" class="toast align-items-center text-bg-info border-0" role="alert">
            <div class="d-flex"><div class="toast-body"><i class="fas fa-info-circle me-2"></i><span id="infoToastMessage">Informasi!</span></div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        let isEditMode = false;
        let originalFormData = {};
        let passwordModal;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        document.addEventListener('DOMContentLoaded', function() {
            initializeApp();
            setupEventListeners();
            addAnimations();
            initializeModal();
        });

        function initializeApp() {
            storeOriginalData();
            document.documentElement.style.scrollBehavior = 'smooth';
            const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltips.forEach(tooltip => new bootstrap.Tooltip(tooltip));
            document.body.classList.add('loaded');
        }

        function initializeModal() {
            passwordModal = new bootstrap.Modal(document.getElementById('passwordModal'));
        }

        function addAnimations() {
            // Add staggered animation delays
            const staggerElements = document.querySelectorAll('.stagger > *');
            staggerElements.forEach((el, index) => {
                el.style.animationDelay = `${(index + 1) * 0.1}s`;
            });
        }

        function setupEventListeners() {
            document.getElementById('profileForm').addEventListener('submit', (e) => {
                if (!checkNetworkStatus()) e.preventDefault();
                handleFormSubmit(e);
            });
            document.getElementById('passwordForm').addEventListener('submit', (e) => {
                if (!checkNetworkStatus()) e.preventDefault();
                handlePasswordFormSubmit(e);
            });
        }

        async function handleFormSubmit(e) {
            e.preventDefault();
            const saveBtn = document.getElementById('saveBtn');
            const btnText = saveBtn.querySelector('.btn-text');
            const form = e.target;

            saveBtn.disabled = true;
            saveBtn.classList.add('btn-loading');
            btnText.textContent = 'Menyimpan...';

            try {
                // Ambil data dari form
                const formData = new FormData(form);
                const data = {
                    name: formData.get('name'),
                    phone: formData.get('phone'),
                    address: formData.get('address')
                };

                // Cek apakah ada perubahan dari data asli
                const isChanged = Object.keys(data).some(key => data[key] !== originalFormData[key]);

                // Jika tidak ada perubahan, jangan kirim & jangan tampilkan toast
                if (!isChanged) {
                    exitEditMode();
                    return;
                }

                // Kirim ke server
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData,
                    credentials: 'same-origin'
                });

                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

                const result = await response.json();

                if (result.errors) {
                    handleValidationErrors(result.errors);
                    showToast('Terdapat kesalahan pada form. Silakan periksa kembali.', 'error');
                    return;
                }

                // Update UI
               function updateViewModeWithNewData(changes) {
    // Hanya update berdasarkan field yang dikembalikan server
    if (changes.name !== undefined) {
        document.getElementById('displayNameValue').textContent = changes.name;
        document.getElementById('displayName').textContent = changes.name;
    }
    
    if (changes.phone !== undefined) {
        document.getElementById('phoneDisplayValue').textContent = changes.phone || 'Belum diisi';
    }
    
    if (changes.address !== undefined) {
        document.getElementById('addressDisplayValue').textContent = changes.address || 'Belum diisi';
    }
}
                exitEditMode();

                // Tampilkan toast hanya jika ada perubahan
                showToast(result.message || 'Profil berhasil diperbarui!', 'success');
                storeOriginalData(); // update data asli

                // Redirect jika phone berubah dan perlu verifikasi
                if (result.phone_changed && result.requires_verification) {
                    setTimeout(() => {
                        window.location.href = '/phone/verify';
                    }, 1500);
                }

            } catch (error) {
                console.error('Error:', error);
                showToast('Nomor telepon ini sudah terdaftar. Gunakan nomor lain.', 'error');
            } finally {
                saveBtn.disabled = false;
                saveBtn.classList.remove('btn-loading');
                btnText.textContent = 'Simpan Perubahan';
            }
        }

        function updateViewModeWithNewData(data, phoneChanged = false) {
            if (data.name) {
                document.getElementById('displayNameValue').textContent = data.name;
                document.getElementById('displayName').textContent = data.name;
            }
            if (data.phone !== undefined) {
                document.getElementById('phoneDisplayValue').textContent = data.phone || 'Belum diisi';
            }
            if (data.address !== undefined) {
                document.getElementById('addressDisplayValue').textContent = data.address || 'Belum diisi';
            }
            if (result.changes) {
    updateViewModeWithNewData(result.changes);
}
        }

        function toggleEditMode() {
            isEditMode = !isEditMode;
            const viewModes = document.querySelectorAll('.view-mode');
            const editModes = document.querySelectorAll('.edit-mode');
            const editBtn = document.getElementById('editBtn');

            if (isEditMode) {
                viewModes.forEach((el, i) => {
                    setTimeout(() => { 
                        el.style.opacity = '0'; 
                        el.style.transform = 'translateY(-10px)'; 
                        setTimeout(() => el.classList.add('d-none'), 150); 
                    }, i * 50);
                });
                setTimeout(() => {
                    editModes.forEach((el, i) => {
                        el.classList.remove('d-none');
                        el.style.opacity = '0';
                        el.style.transform = 'translateY(10px)';
                        setTimeout(() => { 
                            el.style.opacity = '1'; 
                            el.style.transform = 'translateY(0)'; 
                        }, i * 50 + 50);
                    });
                }, 200);
                editBtn.innerHTML = '<i class="fas fa-eye me-2"></i>Lihat Profil';
                editBtn.className = 'btn btn-primary hover-lift';
                setTimeout(() => { 
                    const firstInput = document.querySelector('.edit-mode input'); 
                    if (firstInput) firstInput.focus(); 
                }, 400);
                showToast('Mode edit diaktifkan', 'info');
            } else {
                exitEditMode();
            }
        }

        function exitEditMode() {
            const viewModes = document.querySelectorAll('.view-mode');
            const editModes = document.querySelectorAll('.edit-mode');
            const editBtn = document.getElementById('editBtn');
            editModes.forEach((el, i) => {
                setTimeout(() => { 
                    el.style.opacity = '0'; 
                    el.style.transform = 'translateY(10px)'; 
                    setTimeout(() => el.classList.add('d-none'), 150); 
                }, i * 50);
            });
            setTimeout(() => {
                viewModes.forEach((el, i) => {
                    el.classList.remove('d-none');
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(-10px)';
                    setTimeout(() => { 
                        el.style.opacity = '1'; 
                        el.style.transform = 'translateY(0)'; 
                    }, i * 50 + 50);
                });
            }, 200);
            editBtn.innerHTML = '<i class="fas fa-edit me-2"></i>Edit Profil';
            editBtn.className = 'btn btn-light hover-lift';
            isEditMode = false;
        }

        function cancelEdit() {
            restoreOriginalData();
            exitEditMode();
            showToast('Perubahan dibatalkan', 'info');
        }

        function showToast(message, type = 'success') {
            const toastId = type + 'Toast';
            const toastElement = document.getElementById(toastId);
            const messageElement = document.getElementById(type + 'ToastMessage');
            if (toastElement && messageElement) {
                messageElement.textContent = message;
                const toast = new bootstrap.Toast(toastElement, { autohide: true, delay: 5000 });
                toast.show();
            }
        }

        function handleValidationErrors(errors) {
            document.querySelectorAll('.form-control').forEach(input => {
                input.classList.remove('is-invalid');
                const errorDiv = input.parentNode.querySelector('.invalid-feedback');
                if (errorDiv) errorDiv.remove();
            });
            Object.keys(errors).forEach(field => {
                const input = document.querySelector(`[name="${field}"]`);
                if (input) {
                    input.classList.add('is-invalid');
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'invalid-feedback';
                    errorDiv.textContent = errors[field][0];
                    input.parentNode.appendChild(errorDiv);
                }
            });
        }

        function storeOriginalData() {
            originalFormData = {
                name: document.getElementById('nameInput')?.value || '',
                phone: document.getElementById('phoneInput')?.value || '',
                address: document.getElementById('addressInput')?.value || ''
            };
        }

        function restoreOriginalData() {
            const fields = ['nameInput', 'phoneInput', 'addressInput'];
            fields.forEach(id => {
                const input = document.getElementById(id);
                if (input) input.value = originalFormData[id.replace('Input', '')] || '';
            });
            document.querySelectorAll('.form-control').forEach(input => {
                input.classList.remove('is-invalid', 'is-valid');
                const errorDiv = input.parentNode.querySelector('.invalid-feedback');
                if (errorDiv) errorDiv.remove();
            });
        }

        function checkNetworkStatus() {
            if (!navigator.onLine) {
                showToast('Tidak ada koneksi internet.', 'error');
                return false;
            }
            return true;
        }

        function logout() {
            if (confirm('Apakah Anda yakin ingin keluar?')) {
                showToast('Sedang logout...', 'info');
                setTimeout(() => {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/logout';
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;
                    form.appendChild(csrfInput);
                    document.body.appendChild(form);
                    form.submit();
                }, 1000);
            }
        }

        function showPasswordModal() {
            passwordModal.show();
        }

        function handlePasswordFormSubmit(e) {
            e.preventDefault();
            const changePasswordBtn = document.getElementById('changePasswordBtn');
            const btnText = changePasswordBtn.querySelector('.btn-text');

            changePasswordBtn.disabled = true;
            changePasswordBtn.classList.add('btn-loading');
            btnText.textContent = 'Mengubah...';

            const formData = new FormData(e.target);

            fetch(e.target.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if (result.errors) {
                    handleValidationErrors(result.errors);
                    showToast('Terdapat kesalahan pada form password.', 'error');
                } else {
                    showToast(result.message || 'Password berhasil diubah!', 'success');
                    passwordModal.hide();
                    e.target.reset();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Gagal mengubah password. Coba lagi.', 'error');
            })
            .finally(() => {
                changePasswordBtn.disabled = false;
                changePasswordBtn.classList.remove('btn-loading');
                btnText.textContent = 'Ubah Password';
            });
        }

        function togglePasswordVisibility(id) {
            const input = document.getElementById(id);
            const icon = event.currentTarget.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>