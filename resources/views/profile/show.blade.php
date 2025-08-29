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
            --shadow: 0 2px 8px rgba(0, 0, 0, 0.10);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.15);
            --shadow-xl: 0 16px 40px rgba(0, 0, 0, 0.20);
            --border-radius: 12px;
            --border-radius-lg: 16px;
            --border-radius-xl: 20px;
            --transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        * {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        body {
            background: var(--gradient-bg);
            color: var(--dark);
            line-height: 1.5;
            font-weight: 400;
            min-height: 100vh;
        }

        .page-header {
            text-align: center;
            padding: 3rem 0 2rem;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            font-size: 1.125rem;
            color: var(--secondary);
            font-weight: 400;
        }

        .profile-card {
            background: var(--white);
            border-radius: var(--border-radius-xl);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .profile-header {
            background: var(--gradient-primary);
            padding: 3rem 2rem;
            text-align: center;
            color: white;
        }

        .avatar {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.25);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: white;
            margin: 0 auto 1.5rem;
            transition: var(--transition);
        }

        .profile-name {
            color: white;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .profile-role {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.125rem;
            margin-bottom: 1.5rem;
        }

        .badge-custom {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.25rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.875rem;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .content-section {
            padding: 2.5rem;
        }

        .info-card {
            background: var(--white);
            border: 1px solid rgba(0, 0, 0, 0.04);
            border-radius: var(--border-radius-lg);
            padding: 2rem;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
            position: relative;
        }

        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--gradient-primary);
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
        }

        .info-item {
            margin-bottom: 1.5rem;
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
            min-height: 3rem;
            display: flex;
            align-items: center;
        }

        .btn {
            border-radius: var(--border-radius);
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: var(--transition);
            border: 1px solid transparent;
            min-width: 120px;
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            color: white;
            transform: translateY(-2px);
        }

        .btn-light {
            background: rgba(255, 255, 255, 0.9);
            color: var(--dark);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .btn-light:hover {
            background: white;
            color: var(--primary);
            transform: translateY(-2px);
        }

        .btn-success {
            background: var(--success);
            border-color: var(--success);
            color: white;
        }

        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            color: white;
        }

        .btn-outline-secondary {
            color: var(--secondary);
            border-color: var(--secondary);
            background: transparent;
        }

        .form-control {
            border: 2px solid rgba(0, 0, 0, 0.08);
            border-radius: var(--border-radius);
            padding: 1rem;
            font-size: 1rem;
            transition: var(--transition);
            background: white;
            font-weight: 500;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(0, 122, 255, 0.1);
            background: white;
            outline: none;
        }

        .dropdown-menu {
            border: 1px solid rgba(0, 0, 0, 0.04);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            padding: 0.5rem;
        }

        .dropdown-item {
            border-radius: var(--border-radius);
            padding: 0.75rem 1rem;
            margin-bottom: 0.25rem;
            transition: var(--transition);
            font-weight: 500;
        }

        .dropdown-item:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        .dropdown-item.text-danger {
            color: var(--danger) !important;
        }

        .dropdown-item.text-danger:hover {
            background: rgba(255, 59, 48, 0.1);
            color: var(--danger) !important;
        }

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

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .password-modal .modal-content {
            border: none;
            border-radius: var(--border-radius-xl);
            box-shadow: var(--shadow-xl);
        }

        .password-modal .modal-header {
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 2rem;
        }

        .password-modal .modal-body {
            padding: 2rem;
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
        }

        .password-modal .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--secondary);
            cursor: pointer;
            z-index: 3;
        }

        .password-modal .form-control {
            padding-right: 3.5rem;
        }

        @media (max-width: 768px) {
            .page-title { font-size: 2rem; }
            .profile-header { padding: 2rem 1.5rem; }
            .content-section { padding: 2rem 1.5rem; }
            .info-card { padding: 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="container-fluid px-3 px-md-4" style="max-width: 1400px;">
        <!-- Header -->
        <header class="page-header">
            <h1 class="page-title">
                <i class="fas fa-user-circle me-3" style="background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                Profil Saya
            </h1>
            <p class="page-subtitle">
                Kelola informasi akun dan pengaturan profil Anda dengan mudah dan aman
            </p>
        </header>

        <!-- Profile Card -->
        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="profile-card">
                    <!-- Profile Header -->
                    <div class="profile-header">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <div class="avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="profile-name" id="displayName">{{ Auth::user()->name }}</div>
                                <div class="profile-role">Member</div>
                                <div class="badge-custom">
                                    <i class="fas fa-check-circle"></i>Akun Terverifikasi
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="d-flex flex-column gap-3 align-items-center mt-4 mt-lg-0">
                                    <button class="btn btn-light" onclick="toggleEditMode()" id="editBtn">
                                        <i class="fas fa-edit me-2"></i>Edit Profil
                                    </button>
                                    <div class="dropdown">
                                        <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
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

                    <!-- Content Section -->
                    <div class="content-section">
                        <form id="profileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            
                            <div class="row g-4">
                                <!-- Personal Info -->
                                <div class="col-lg-6">
                                    <div class="info-card">
                                        <h4 class="card-title">
                                            <i class="fas fa-user text-primary"></i> 
                                            Informasi Personal
                                        </h4>
                                        
                                        <!-- Name -->
                                        <div class="info-item">
                                            <div class="info-label">Nama Lengkap</div>
                                            <div class="view-mode">
                                                <div class="info-value" id="displayNameValue">{{ Auth::user()->name }}</div>
                                            </div>
                                            <div class="edit-mode d-none">
                                                <input type="text" class="form-control" name="name" id="nameInput" value="{{ Auth::user()->name }}" required>
                                            </div>
                                        </div>

                                        <!-- Phone -->
                                        <div class="info-item">
                                            <div class="info-label">Nomor Telepon</div>
                                            <div class="view-mode">
                                                <div class="info-value" id="phoneDisplayValue">{{ Auth::user()->phone ?? 'Belum diisi' }}</div>
                                            </div>
                                            <div class="edit-mode d-none">
                                                <input type="tel" class="form-control" name="phone" id="phoneInput" value="{{ Auth::user()->phone }}" placeholder="628123456789" required>
                                            </div>
                                        </div>

                                        <!-- Address -->
                                        <div class="info-item">
                                            <div class="info-label">Alamat</div>
                                            <div class="view-mode">
                                                <div class="info-value" id="addressDisplayValue">{{ Auth::user()->address ?? 'Belum diisi' }}</div>
                                            </div>
                                            <div class="edit-mode d-none">
                                                <textarea class="form-control" name="address" id="addressInput" rows="3" placeholder="Masukkan alamat lengkap" required>{{ Auth::user()->address }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Account Info -->
                                <div class="col-lg-6">
                                    <div class="info-card">
                                        <h4 class="card-title">
                                            <i class="fas fa-cog text-primary"></i> 
                                            Informasi Akun
                                        </h4>
                                        
                                        <div class="info-item">
                                            <div class="info-label">Bergabung Sejak</div>
                                            <div class="info-value">
                                                <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                                {{ Auth::user()->created_at->translatedFormat('d F Y') }}
                                            </div>
                                        </div>

                                        <div class="info-item">
                                            <div class="info-label">Update Terakhir</div>
                                            <div class="info-value">
                                                <i class="fas fa-clock me-2 text-primary"></i>
                                                {{ Auth::user()->updated_at->translatedFormat('d F Y H:i') }}
                                            </div>
                                        </div>

                                        <div class="info-item">
                                            <div class="info-label">Status Akun</div>
                                            <div class="info-value">
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">
                                                    <i class="fas fa-check-circle me-1"></i>Aktif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="text-center">
                                        <div class="view-mode">
                                            <a href="/" class="btn btn-outline-primary">
                                                <i class="fas fa-home me-2"></i>Kembali ke Beranda
                                            </a>
                                        </div>
                                        <div class="edit-mode d-none">
                                            <div class="d-flex flex-wrap gap-3 justify-content-center">
                                                <button type="submit" class="btn btn-success" id="saveBtn">
                                                    <i class="fas fa-save me-2"></i>
                                                    <span class="btn-text">Simpan Perubahan</span>
                                                </button>
                                                <button type="button" class="btn btn-outline-secondary" onclick="cancelEdit()">
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
    <div class="modal fade password-modal" id="passwordModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-key me-2"></i> Ubah Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter: invert(1);"></button>
                </div>
                <form id="passwordForm" action="{{ route('profile.password.update') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="currentPassword" class="form-label">Password Saat Ini</label>
                            <div style="position: relative;">
                                <input type="password" class="form-control" id="currentPassword" name="current_password" required>
                                <button type="button" class="toggle-password" onclick="togglePasswordVisibility('currentPassword')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="newPassword" class="form-label">Password Baru</label>
                            <div style="position: relative;">
                                <input type="password" class="form-control" id="newPassword" name="password" required minlength="6">
                                <button type="button" class="toggle-password" onclick="togglePasswordVisibility('newPassword')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted">Minimal 6 karakter</small>
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword" class="form-label">Konfirmasi Password Baru</label>
                            <div style="position: relative;">
                                <input type="password" class="form-control" id="confirmPassword" name="password_confirmation" required>
                                <button type="button" class="toggle-password" onclick="togglePasswordVisibility('confirmPassword')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center gap-2">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary" id="changePasswordBtn">
                            <i class="fas fa-save me-2"></i>
                            <span class="btn-text">Ubah Password</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 11;">
        <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-check-circle me-2"></i>
                    <span id="successToastMessage">Operasi berhasil!</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        <div id="errorToast" class="toast align-items-center text-bg-danger border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <span id="errorToastMessage">Terjadi kesalahan!</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        <div id="infoToast" class="toast align-items-center text-bg-info border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-info-circle me-2"></i>
                    <span id="infoToastMessage">Informasi!</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
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
            initializeModal();
        });

        function initializeApp() {
            storeOriginalData();
            document.documentElement.style.scrollBehavior = 'smooth';
        }

        function initializeModal() {
            passwordModal = new bootstrap.Modal(document.getElementById('passwordModal'));
        }

        function setupEventListeners() {
            document.getElementById('profileForm').addEventListener('submit', handleFormSubmit);
            document.getElementById('passwordForm').addEventListener('submit', handlePasswordFormSubmit);
        }

        async function handleFormSubmit(e) {
            e.preventDefault();
            const saveBtn = document.getElementById('saveBtn');
            const btnText = saveBtn.querySelector('.btn-text');
            const form = e.target;

            clearValidationErrors();

            saveBtn.disabled = true;
            saveBtn.classList.add('btn-loading');
            btnText.textContent = 'Menyimpan...';

            try {
                const formData = new FormData(form);
                const currentData = {
                    name: formData.get('name'),
                    phone: formData.get('phone'),
                    address: formData.get('address')
                };

                const isChanged = Object.keys(currentData).some(key => 
                    currentData[key] !== originalFormData[key]
                );

                if (!isChanged) {
                    exitEditMode();
                    return;
                }

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

                const result = await response.json();

                if (!response.ok) {
                    if (result.errors) {
                        handleValidationErrors(result.errors);
                        showToast('Terdapat kesalahan pada form. Silakan periksa kembali.', 'error');
                    } else {
                        throw new Error(result.message || 'Server error');
                    }
                    return;
                }

                if (result.no_changes) {
                    exitEditMode();
                    return;
                }

                if (result.phone_changed && result.requires_verification) {
                    showToast('OTP sudah dikirim ke nomor lama Anda untuk verifikasi.', 'info');
                    setTimeout(() => {
                        window.location.href = result.redirect_url;
                    }, 500);
                    return;
                }

                if (result.changes) {
                    updateViewModeWithNewData(result.changes);
                }

                exitEditMode();
                showToast(result.message || 'Profil berhasil diperbarui!', 'success');
                storeOriginalData();

            } catch (error) {
                console.error('Error:', error);
                showToast(error.message || 'Terjadi kesalahan. Silakan coba lagi.', 'error');
            } finally {
                saveBtn.disabled = false;
                saveBtn.classList.remove('btn-loading');
                btnText.textContent = 'Simpan Perubahan';
            }
        }

        function updateViewModeWithNewData(changes) {
            if (changes.name !== undefined) {
                const nameDisplay = document.getElementById('displayNameValue');
                const headerName = document.getElementById('displayName');
                if (nameDisplay) nameDisplay.textContent = changes.name;
                if (headerName) headerName.textContent = changes.name;
            }
            
            if (changes.phone !== undefined) {
                const phoneDisplay = document.getElementById('phoneDisplayValue');
                if (phoneDisplay) phoneDisplay.textContent = changes.phone || 'Belum diisi';
            }
            
            if (changes.address !== undefined) {
                const addressDisplay = document.getElementById('addressDisplayValue');
                if (addressDisplay) addressDisplay.textContent = changes.address || 'Belum diisi';
            }
        }

        function clearValidationErrors() {
            document.querySelectorAll('.form-control').forEach(input => {
                input.classList.remove('is-invalid');
                const errorDiv = input.parentNode.querySelector('.invalid-feedback');
                if (errorDiv) errorDiv.remove();
            });
        }

        function handleValidationErrors(errors) {
            clearValidationErrors();
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

        function toggleEditMode() {
            isEditMode = !isEditMode;
            const viewModes = document.querySelectorAll('.view-mode');
            const editModes = document.querySelectorAll('.edit-mode');
            const editBtn = document.getElementById('editBtn');

            if (isEditMode) {
                viewModes.forEach(el => el.classList.add('d-none'));
                editModes.forEach(el => el.classList.remove('d-none'));
                editBtn.innerHTML = '<i class="fas fa-eye me-2"></i>Lihat Profil';
                editBtn.className = 'btn btn-primary';
                showToast('Mode edit diaktifkan', 'info');
            } else {
                exitEditMode();
            }
        }

        function exitEditMode() {
            const viewModes = document.querySelectorAll('.view-mode');
            const editModes = document.querySelectorAll('.edit-mode');
            const editBtn = document.getElementById('editBtn');
            
            editModes.forEach(el => el.classList.add('d-none'));
            viewModes.forEach(el => el.classList.remove('d-none'));
            
            editBtn.innerHTML = '<i class="fas fa-edit me-2"></i>Edit Profil';
            editBtn.className = 'btn btn-light';
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
            clearValidationErrors();
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