<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root {
      --primary-blue: #E3F2FD;
      --secondary-blue: #BBDEFB;
      --accent-blue: #64B5F6;
      --dark-blue: #2196F3;
      --text-primary: #1E3A8A;
      --text-secondary: #64748B;
      --border-color: #E1E7EF;
      --shadow-light: rgba(33, 150, 243, 0.08);
      --shadow-medium: rgba(33, 150, 243, 0.15);
      --warning-color: #F59E0B;
      --warning-bg: #FEF3C7;
      --success-color: #10B981;
      --success-bg: #D1FAE5;
      --danger-color: #EF4444;
      --danger-bg: #FEE2E2;
    }

    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #E3F2FD 0%, #F8FAFC 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1rem;
      position: relative;
      overflow-x: hidden;
    }

    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: radial-gradient(circle at 25% 25%, rgba(33, 150, 243, 0.05) 0%, transparent 50%),
                        radial-gradient(circle at 75% 75%, rgba(33, 150, 243, 0.03) 0%, transparent 50%);
      pointer-events: none;
      z-index: -1;
    }

    .login-wrapper {
      width: 100%;
      max-width: 450px;
      position: relative;
    }

    .login-container {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border: 1px solid var(--border-color);
      border-radius: 24px;
      padding: 3rem 2.5rem;
      box-shadow: 0 8px 32px var(--shadow-light),
                  0 2px 16px rgba(0, 0, 0, 0.02);
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
    }

    .login-container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--accent-blue), var(--dark-blue));
      border-radius: 24px 24px 0 0;
    }

    .login-container:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 48px var(--shadow-medium),
                  0 4px 24px rgba(0, 0, 0, 0.04);
    }

    .login-header {
      text-align: center;
      margin-bottom: 2.5rem;
    }

    .login-header h3 {
      color: var(--text-primary);
      font-weight: 600;
      font-size: 1.75rem;
      margin-bottom: 0.5rem;
    }

    .login-header p {
      color: var(--text-secondary);
      font-size: 0.95rem;
      margin: 0;
      font-weight: 400;
    }

    /* Form Group Styling */
    .form-group {
      margin-bottom: 1.5rem;
      position: relative;
    }

    .form-group.mt-4 {
      margin-top: 1.5rem;
    }

    /* Floating Label Container */
    .floating-label {
      position: relative;
    }

    /* Input Label Styling - Floating */
    .floating-label label {
      position: absolute;
      left: 1.25rem;
      top: 1rem;
      color: var(--text-secondary);
      font-weight: 500;
      font-size: 0.95rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      pointer-events: none;
      z-index: 2;
      background: transparent;
      padding: 0 0.25rem;
      transform-origin: left center;
    }

    /* Label animation when focused or filled */
    .floating-label input:focus ~ label,
    .floating-label input:not(:placeholder-shown) ~ label,
    .floating-label input.has-value ~ label,
    .floating-label input[type="text"] ~ label {
      top: -0.5rem;
      left: 1rem;
      font-size: 0.8rem;
      font-weight: 600;
      color: var(--dark-blue);
      background: rgba(255, 255, 255, 0.95);
      padding: 0 0.5rem;
      transform: scale(0.9);
    }

    /* Input Field Styling */
    input[type="email"],
    input[type="password"],
    input[type="text"] {
      border: 2px solid var(--border-color) !important;
      border-radius: 16px !important;
      padding: 1rem 1.25rem !important;
      font-size: 0.95rem !important;
      background-color: rgba(248, 250, 252, 0.5) !important;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
      width: 100% !important;
      min-height: 3.5rem !important;
      max-height: 3.5rem !important;
      height: 3.5rem !important;
      outline: none !important;
      box-sizing: border-box !important;
      font-family: 'Poppins', sans-serif !important;
      font-weight: 400 !important;
      line-height: 1.5 !important;
    }

    input[type="email"]:focus,
    input[type="password"]:focus,
    input[type="text"]:focus {
      border-color: var(--accent-blue) !important;
      box-shadow: 0 0 0 4px rgba(100, 181, 246, 0.1) !important;
      background-color: white !important;
    }

    /* Remove default placeholder visibility */
    input::placeholder {
      color: transparent;
    }

    input:focus::placeholder {
      color: var(--text-secondary);
      opacity: 0.6;
    }

    /* Password field with icon */
    .password-wrapper {
      position: relative;
    }

    .password-wrapper input {
      padding-right: 3.5rem !important;
    }

    /* Ensure consistent styling for password fields */
    .password-wrapper input[type="password"],
    .password-wrapper input[type="text"] {
      border: 2px solid var(--border-color) !important;
      border-radius: 16px !important;
      padding: 1rem 3.5rem 1rem 1.25rem !important;
      font-size: 0.95rem !important;
      background-color: rgba(248, 250, 252, 0.5) !important;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
      width: 100% !important;
      min-height: 3.5rem !important;
      max-height: 3.5rem !important;
      height: 3.5rem !important;
      outline: none !important;
      box-sizing: border-box !important;
      font-family: 'Poppins', sans-serif !important;
      font-weight: 400 !important;
      line-height: 1.5 !important;
    }

    .toggle-password {
      position: absolute;
      right: 1rem;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      z-index: 10;
      color: var(--text-secondary);
      font-size: 1.25rem;
      transition: color 0.2s ease;
      padding: 0.5rem;
      border-radius: 8px;
      line-height: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 2rem;
      height: 2rem;
    }

    .toggle-password:hover {
      color: var(--dark-blue);
      background-color: rgba(33, 150, 243, 0.1);
    }

    /* Error Styling */
    .error-message {
      color: var(--danger-color);
      font-size: 0.85rem;
      margin-top: 0.5rem;
      padding: 0.5rem 0.75rem;
      background: var(--danger-bg);
      border-radius: 8px;
      border: 1px solid #FECACA;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .error-message::before {
      content: '⚠️';
      font-size: 0.9rem;
    }

    .error-message ul {
      margin: 0;
      padding: 0;
      list-style: none;
    }

    .error-message li {
      margin: 0;
    }

    /* Alert Styling */
    .alert {
      border-radius: 12px;
      border: none;
      padding: 1rem 1.25rem;
      margin-bottom: 1.5rem;
      font-size: 0.9rem;
    }

    .alert-danger {
      background: var(--danger-bg);
      color: var(--danger-color);
      border: 1px solid #FECACA;
    }

    /* Forgot Password Link */
    .forgot-password-container {
      text-align: right;
      margin-bottom: 1.5rem;
    }

    .forgot-password {
      display: inline-block;
      color: var(--dark-blue);
      text-decoration: none;
      font-size: 0.9rem;
      font-weight: 500;
      padding: 0.5rem 0.75rem;
      border-radius: 8px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
    }

    .forgot-password::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(33, 150, 243, 0.1), transparent);
      transition: left 0.5s ease;
    }

    .forgot-password:hover {
      color: var(--accent-blue);
      background-color: rgba(33, 150, 243, 0.05);
      transform: translateY(-1px);
      text-decoration: none;
    }

    .forgot-password:hover::before {
      left: 100%;
    }

    .forgot-password:active {
      transform: translateY(0);
    }

    /* Button Styling */
    .btn-login {
      background: linear-gradient(135deg, var(--accent-blue) 0%, var(--dark-blue) 100%);
      border: none;
      border-radius: 16px;
      padding: 1rem 1.5rem;
      font-weight: 600;
      font-size: 1rem;
      color: white;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 4px 16px rgba(33, 150, 243, 0.3);
      cursor: pointer;
      width: 100%;
      font-family: 'Poppins', sans-serif;
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 24px rgba(33, 150, 243, 0.4);
      background: linear-gradient(135deg, var(--dark-blue) 0%, #1976D2 100%);
    }

    .btn-login:active {
      transform: translateY(0);
      box-shadow: 0 2px 8px rgba(33, 150, 243, 0.2);
    }

    /* Register Link */
    .register-link {
      text-align: center;
      margin-top: 1.5rem;
      padding-top: 1.5rem;
      border-top: 1px solid var(--border-color);
    }

    .register-link a {
      color: var(--dark-blue);
      text-decoration: none;
      font-weight: 600;
      font-size: 0.9rem;
      transition: color 0.2s ease;
    }

    .register-link a:hover {
      color: var(--accent-blue);
      text-decoration: underline;
    }

    /* Form Actions */
    .form-actions {
      display: flex;
      flex-direction: column;
      gap: 1rem;
      margin-top: 2rem;
    }

    @media (max-width: 480px) {
      .login-container {
        padding: 2rem 1.5rem;
        border-radius: 20px;
      }
      
      .login-header h3 {
        font-size: 1.5rem;
      }
    }

    .bounce-in {
      animation: bounceIn 0.5s ease-out;
    }

    @keyframes bounceIn {
      0% { opacity: 0; transform: scale(0.3); }
      50% { opacity: 1; transform: scale(1.05); }
      70% { transform: scale(0.9); }
      100% { opacity: 1; transform: scale(1); }
    }

    /* Client-side validation styling */
    input.needs-attention {
      border-color: var(--warning-color) !important;
      background-color: var(--warning-bg) !important;
    }

    input.looks-good {
      border-color: var(--success-color) !important;
      background-color: var(--success-bg) !important;
    }

    .friendly-message {
      font-size: 0.85rem;
      margin-top: 0.5rem;
      padding: 0.75rem 1rem;
      border-radius: 8px;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      transition: all 0.3s ease;
    }

    .friendly-message.helper {
      background: var(--warning-bg);
      color: #92400E;
      border: 1px solid #FDE68A;
    }

    .friendly-message.success {
      background: var(--success-bg);
      color: #065F46;
      border: 1px solid #A7F3D0;
    }

    /* Shimmer animation for forgot password */
    @keyframes shimmer {
      0% { background-position: -200px 0; }
      100% { background-position: calc(200px + 100%) 0; }
    }

    .forgot-password:hover {
      background-image: linear-gradient(90deg, transparent 0%, rgba(33, 150, 243, 0.1) 50%, transparent 100%);
      background-size: 200px 100%;
      animation: shimmer 1.5s ease-in-out infinite;
    }
    /* Hilangkan spinner pada number/tel input */
input[type="number"]::-webkit-inner-spin-button, 
input[type="number"]::-webkit-outer-spin-button, 
input[type="tel"]::-webkit-inner-spin-button, 
input[type="tel"]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

input[type="tel"] {
  border: 2px solid var(--border-color) !important;
  border-radius: 16px !important;
  padding: 1rem 1.25rem !important;
  font-size: 0.95rem !important;
  background-color: rgba(248, 250, 252, 0.5) !important;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
  width: 100% !important;
  min-height: 3.5rem !important;
  height: 3.5rem !important;
  font-family: 'Poppins', sans-serif !important;
}

  </style>
</head>
<body>
<!-- Toast Container -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
  @if(session('success'))
    <div class="toast align-items-center text-bg-success border-0 show" role="alert">
      <div class="d-flex">
        <div class="toast-body">
          {!! session('success') !!}
          @if(str_contains(session('success'), 'verifikasi'))
            <br>
            <a href="{{ route('verification.notice') }}" class="text-white fw-bold">Klik di sini untuk verifikasi</a>
          @endif
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>
  @endif

  @if(session('error'))
    <div class="toast align-items-center text-bg-danger border-0 show" role="alert">
      <div class="d-flex">
        <div class="toast-body">
          {!! session('error') !!}
          @if(str_contains(session('error'), 'verifikasi'))
            <br>
            <a href="{{ route('verification.notice') }}" class="text-white fw-bold">Klik di sini untuk verifikasi</a>
          @endif
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>
  @endif

  @if(session('warning'))
    <div class="toast align-items-center text-bg-warning border-0 show" role="alert">
      <div class="d-flex">
        <div class="toast-body">
          {!! session('warning') !!}
          @if(str_contains(session('warning'), 'verifikasi'))
            <br>
            <a href="{{ route('verification.notice') }}" class="fw-bold">Klik di sini untuk verifikasi</a>
          @endif
        </div>
        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>
  @endif
</div>

<div class="login-wrapper">
  <div class="login-container">
    <div class="login-header">
      <h3>Sign In</h3>
    </div>
<form method="POST" action="{{ route('login') }}" id="loginForm">
      @csrf

      <!-- Phone -->
      <div class="form-group">
        <div class="floating-label">
         <input id="phone" type="tel" name="phone" 
       pattern="[0-9]*" inputmode="numeric"
       value="{{ old('phone') }}" required autofocus
       autocomplete="username" placeholder=" "
       onblur="validatePhone()" onkeyup="validatePhone()" />

          <label for="phone"><i class="bi bi-telephone-fill"></i> Nomor HP</label>
        </div>
        @error('phone')
          <div class="error-message bounce-in"><ul><li>{{ $message }}</li></ul></div>
        @enderror
        <div id="phoneMessage"></div>
      </div>

      <!-- Password -->
      <div class="form-group mt-4">
        <div class="floating-label password-wrapper">
          <input id="password" type="password" name="password" required autocomplete="current-password" onblur="validatePassword()" onkeyup="validatePassword()" placeholder=" " />
          <label for="password"><i class="bi bi-lock"></i> Password</label>
          <span class="toggle-password" onclick="togglePassword('password')" tabindex="0" role="button">
            <i class="bi bi-eye-slash" id="passwordEyeIcon"></i>
          </span>
        </div>
        @error('password')
          <div class="error-message bounce-in"><ul><li>{{ $message }}</li></ul></div>
        @enderror
        <div id="passwordMessage"></div>
      </div>

      <!-- Forgot Password -->
      <div class="forgot-password-container">
        <a href="{{ route('password.request') }}" class="forgot-password">
          <i class="bi bi-key me-1"></i> Lupa password?
        </a>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn-login">
          <i class="bi bi-box-arrow-in-right me-2"></i> Login
        </button>
        <div class="register-link">
          <p class="mb-0">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  const friendlyMessages = {
    phone: {
      tooShort: "Nomor HP minimal 10 digit!",
      tooLong: "Nomor HP maksimal 15 digit!",
      invalid: "Nomor HP hanya boleh angka!"
    },
    password: {
      tooShort: "Password minimal 6 karakter ya biar aman!"
    }
  };

  function showMessage(elementId, message, type = 'helper') {
    const element = document.getElementById(elementId);
    if (!message) {
      element.innerHTML = '';
      return;
    }
    
    const iconMap = {
      helper: 'bi-lightbulb',
      success: 'bi-check-circle'
    };
    
    element.innerHTML = `
      <div class="friendly-message ${type} bounce-in">
        <i class="bi ${iconMap[type]}"></i>
        ${message}
      </div>
    `;
  }

  function validatePhone() {
    const phone = document.getElementById('phone').value.trim();
    const field = document.getElementById('phone');

    if (phone === '') {
      field.className = '';
      showMessage('phoneMessage', '');
      return true;
    }

    if (!/^[0-9]+$/.test(phone)) {
      field.className = 'needs-attention';
      showMessage('phoneMessage', friendlyMessages.phone.invalid, 'helper');
      return false;
    }

    if (phone.length < 10) {
      field.className = 'needs-attention';
      showMessage('phoneMessage', friendlyMessages.phone.tooShort, 'helper');
      return false;
    }

    if (phone.length > 15) {
      field.className = 'needs-attention';
      showMessage('phoneMessage', friendlyMessages.phone.tooLong, 'helper');
      return false;
    }

    field.className = 'looks-good';
    showMessage('phoneMessage', '');
    return true;
  }

  function validatePassword() {
    const password = document.getElementById('password').value;
    const field = document.getElementById('password');
    
    if (password === '') {
      field.className = '';
      showMessage('passwordMessage', '');
      return true;
    }
    
    if (password.length < 6) {
      field.className = 'needs-attention';
      showMessage('passwordMessage', friendlyMessages.password.tooShort, 'helper');
      return false;
    }
    
    field.className = 'looks-good';
    showMessage('passwordMessage', '');
    return true;
  }

  function togglePassword(fieldId) {
    const passwordField = document.getElementById(fieldId);
    const eyeIcon = document.getElementById(fieldId + 'EyeIcon');
    
    if (passwordField.type === 'password') {
      passwordField.type = 'text';
      eyeIcon.className = 'bi bi-eye';
    } else {
      passwordField.type = 'password';
      eyeIcon.className = 'bi bi-eye-slash';
    }
    
    if (passwordField.value.trim() !== '') {
      passwordField.classList.add('has-value');
    } else {
      passwordField.classList.remove('has-value');
    }
  }

  document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    const inputs = form.querySelectorAll('input');

    // Floating label init
    inputs.forEach(input => {
      if (input.value.trim() !== '') input.classList.add('has-value');
      input.addEventListener('input', function() {
        this.value.trim() !== '' ? this.classList.add('has-value') : this.classList.remove('has-value');
      });
    });

    // Toggle password accessibility
    document.querySelectorAll('.toggle-password').forEach(toggle => {
      toggle.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          this.click();
        }
      });
    });

    // Form validation
    form.addEventListener('submit', function(e) {
      const isPhoneValid = validatePhone();
      const isPasswordValid = validatePassword();
      if (!isPhoneValid || !isPasswordValid) {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }
    });

    // Auto-hide bootstrap toast
    const toastElList = [].slice.call(document.querySelectorAll('.toast'))
    toastElList.map(toastEl => {
      new bootstrap.Toast(toastEl, { delay: 5000 }).show()
    });
  });
</script>
</body>
</html>