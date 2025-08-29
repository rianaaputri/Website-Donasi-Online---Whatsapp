<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register User</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    .register-wrapper {
      width: 100%;
      max-width: 450px;
      position: relative;
    }

    .register-container {
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

    .register-container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--accent-blue), var(--dark-blue));
      border-radius: 24px 24px 0 0;
    }

    .register-container:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 48px var(--shadow-medium),
                  0 4px 24px rgba(0, 0, 0, 0.04);
    }

    .register-header {
      text-align: center;
      margin-bottom: 2.5rem;
    }

    .register-header h3 {
      color: var(--text-primary);
      font-weight: 600;
      font-size: 1.75rem;
      margin-bottom: 0.5rem;
    }

    .register-header p {
      color: var(--text-secondary);
      font-size: 0.95rem;
      margin: 0;
      font-weight: 400;
    }

    /* Enhanced Form Controls */
    .form-floating {
      margin-bottom: 1.5rem;
      position: relative;
    }

    .form-floating > .form-control {
      border: 2px solid var(--border-color);
      border-radius: 16px;
      padding: 1rem 1.25rem;
      font-size: 0.95rem;
      background-color: rgba(248, 250, 252, 0.5);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      height: auto;
      min-height: 3.5rem;
    }

    .form-floating > .form-control:focus {
      border-color: var(--accent-blue);
      box-shadow: 0 0 0 4px rgba(100, 181, 246, 0.1);
      background-color: white;
      outline: none;
    }

    /* Validation states */
    .form-floating > .form-control.is-invalid {
      border-color: var(--danger-color);
      background-color: var(--danger-bg);
    }

    .form-floating > .form-control.is-valid {
      border-color: var(--success-color);
      background-color: var(--success-bg);
    }

    .form-floating > .form-control.needs-attention {
      border-color: var(--warning-color);
      background-color: var(--warning-bg);
    }

    .form-floating > label {
      color: var(--text-secondary);
      font-weight: 500;
      font-size: 0.9rem;
      padding: 1rem 1.25rem;
      transition: all 0.2s ease;
    }

    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label {
      color: var(--dark-blue);
      font-weight: 600;
    }

    /* Password field with icon - Fixed positioning */
    .password-wrapper {
      position: relative;
    }

    .password-wrapper .form-control {
      padding-right: 3.5rem;
    }

    .toggle-password {
      position: absolute;
      right: 1rem;
      top: 1rem;
      cursor: pointer;
      z-index: 10;
      color: var(--text-secondary);
      font-size: 1.25rem;
      transition: color 0.2s ease;
      padding: 0.5rem;
      border-radius: 8px;
      line-height: 1;
    }

    .toggle-password:hover {
      color: var(--dark-blue);
      background-color: rgba(33, 150, 243, 0.1);
    }

    .btn-register {
      background: linear-gradient(135deg, var(--accent-blue) 0%, var(--dark-blue) 100%);
      border: none;
      border-radius: 16px;
      padding: 1rem 1.5rem;
      font-weight: 600;
      font-size: 1rem;
      color: white;
      width: 100%;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 4px 16px rgba(33, 150, 243, 0.3);
      margin-bottom: 1.5rem;
    }

    .btn-register:hover:not(:disabled) {
      transform: translateY(-2px);
      box-shadow: 0 6px 24px rgba(33, 150, 243, 0.4);
      background: linear-gradient(135deg, var(--dark-blue) 0%, #1976D2 100%);
    }

    .btn-register:active {
      transform: translateY(0);
      box-shadow: 0 2px 8px rgba(33, 150, 243, 0.2);
    }

    .btn-register:disabled {
      opacity: 0.7;
      cursor: not-allowed;
      transform: none;
    }

    /* Laravel Alert styling */
    .alert {
      border: none;
      border-radius: 12px;
      padding: 1rem 1.25rem;
      margin-bottom: 1.5rem;
      font-size: 0.9rem;
      display: flex;
      align-items: flex-start;
      gap: 0.75rem;
    }

    .alert-danger {
      background: linear-gradient(135deg, #FEE2E2 0%, #FEF2F2 100%);
      color: #991B1B;
      border-left: 4px solid var(--danger-color);
    }

    .alert-success {
      background: linear-gradient(135deg, #D1FAE5 0%, #ECFDF5 100%);
      color: #065F46;
      border-left: 4px solid var(--success-color);
    }

    .alert-danger::before {
      content: '⚠️';
      font-size: 1.1rem;
      flex-shrink: 0;
      margin-top: 0.1rem;
    }

    .alert-success::before {
      content: '✅';
      font-size: 1.1rem;
      flex-shrink: 0;
      margin-top: 0.1rem;
    }

    /* Validation message styling */
    .validation-message {
      font-size: 0.85rem;
      margin-top: 0.5rem;
      padding: 0.5rem 0.75rem;
      border-radius: 8px;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      animation: slideIn 0.3s ease-out;
    }

    .validation-message.error {
      color: var(--danger-color);
      background: var(--danger-bg);
      border: 1px solid #FECACA;
    }

    .validation-message.error::before {
      content: '❌';
      font-size: 0.9rem;
    }

    .login-link {
      text-align: center;
      margin-top: 1.5rem;
      padding-top: 1.5rem;
      border-top: 1px solid var(--border-color);
    }

    .login-link p {
      color: var(--text-secondary);
      font-size: 0.9rem;
      margin: 0;
    }

    .login-link a {
      color: var(--dark-blue);
      text-decoration: none;
      font-weight: 600;
      transition: color 0.2s ease;
    }

    .login-link a:hover {
      color: var(--accent-blue);
      text-decoration: underline;
    }

    @media (max-width: 480px) {
      .register-container {
        padding: 2rem 1.5rem;
        border-radius: 20px;
      }
      
      .register-header h3 {
        font-size: 1.5rem;
      }
    }

    .btn-register.loading {
      position: relative;
      color: transparent;
    }

    .btn-register.loading::after {
      content: '';
      position: absolute;
      width: 20px;
      height: 20px;
      top: 50%;
      left: 50%;
      margin-left: -10px;
      margin-top: -10px;
      border: 2px solid transparent;
      border-top-color: white;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    @keyframes slideIn {
      0% { opacity: 0; transform: translateY(-10px); }
      100% { opacity: 1; transform: translateY(0); }
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
  </style>
</head>
<body>

<div class="register-wrapper">
  <div class="register-container">
    <div class="register-header">
      <h3>Sign Up</h3>
      <p>Lengkapi data di bawah untuk membuat akun!</p>
    </div>

    {{-- Notifikasi Error --}}
    @if ($errors->any())
      <div class="alert alert-danger bounce-in">
        <div>
          @foreach ($errors->all() as $err)
            <div>{{ $err }}</div>
          @endforeach
        </div>
      </div>
    @endif

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
      <div class="alert alert-success bounce-in">
        <div>{{ session('success') }}</div>
      </div>
    @endif

    {{-- FIXED: Form action sekarang menggunakan user.register --}}
    <form method="POST" action="{{ route('register') }}" id="registerForm" novalidate>
      @csrf

      {{-- Name Field --}}
      <div class="form-floating">
        <input type="text" class="form-control @error('name') is-invalid @enderror" 
               id="name" name="name" placeholder="Nama Lengkap" 
               value="{{ old('name') }}" required autocomplete="name">
        <label for="name">
          <i class="bi bi-person me-2"></i>Nama Lengkap
        </label>
        @error('name')
          <div class="validation-message error">{{ $message }}</div>
        @enderror
        <div id="nameValidation" class="validation-message" style="display: none;"></div>
      </div>

      {{-- Phone Field --}}
      <div class="form-floating mb-3">
    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
           id="phone" name="phone" placeholder="phone" 
           value="{{ old('phone') }}" required autocomplete="tel">
    <label for="phone">
        <i class="bi bi-telephone me-2"></i> Phone
    </label>
    @error('phone')
        <div class="validation-message error">{{ $message }}</div>
    @enderror
    <div id="phoneValidation" class="validation-message" style="display: none;"></div>
</div>


      {{-- Password Field --}}
      <div class="form-floating password-wrapper">
        <input type="password" class="form-control @error('password') is-invalid @enderror"
               id="password" name="password" placeholder="Password" required 
               autocomplete="new-password">
        <label for="password">
          <i class="bi bi-lock me-2"></i>Kata Sandi
        </label>
        
        <span class="toggle-password" onclick="togglePassword('password')" tabindex="0" role="button" 
              aria-label="Toggle password visibility">
          <i class="bi bi-eye-slash" id="passwordEyeIcon"></i>
        </span>
        @error('password')
          <div class="validation-message error">{{ $message }}</div>
        @enderror
        <div id="passwordValidation" class="validation-message" style="display: none;"></div>
      </div>

      {{-- Confirm Password Field --}}
      <div class="form-floating password-wrapper">
        <input type="password" class="form-control" 
               id="password_confirmation" name="password_confirmation" 
               placeholder="Konfirmasi Password" required 
               autocomplete="new-password">
        <label for="password_confirmation">
          <i class="bi bi-shield-lock me-2"></i>Konfirmasi Kata Sandi
        </label>
        
        <span class="toggle-password" onclick="togglePassword('password_confirmation')" tabindex="0" role="button" 
              aria-label="Toggle password confirmation visibility">
          <i class="bi bi-eye-slash" id="confirmPasswordEyeIcon"></i>
        </span>
        <div id="confirmPasswordValidation" class="validation-message" style="display: none;"></div>
      </div>

      <button type="submit" class="btn btn-register" id="submitBtn">
        <i class="bi bi-person-plus me-2"></i>
        Daftar Sekarang!
      </button>

      <div class="login-link">
        <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  const friendlyMessages = {
    name: {
      empty: "Nama tidak boleh kosong ya!",
      tooShort: "Nama minimal 2 karakter ya!"
    },
    
    password: {
      tooShort: "Password minimal 6 karakter ya biar aman!"
    },
    confirmPassword: {
      noMatch: "Password tidak sama nih! Coba cek lagi ya!"
    }
  };

  function togglePassword(fieldId) {
    const passwordField = document.getElementById(fieldId);
    const eyeIcon = document.getElementById(fieldId === 'password' ? 'passwordEyeIcon' : 'confirmPasswordEyeIcon');
    
    if (passwordField.type === 'password') {
      passwordField.type = 'text';
      eyeIcon.className = 'bi bi-eye';
    } else {
      passwordField.type = 'password';
      eyeIcon.className = 'bi bi-eye-slash';
    }
  }

  function showValidationMessage(fieldId, message, type = 'error') {
    const validationDiv = document.getElementById(fieldId + 'Validation');
    const field = document.getElementById(fieldId);
    
    if (validationDiv) {
      validationDiv.textContent = message;
      validationDiv.className = `validation-message ${type}`;
      validationDiv.style.display = 'flex';
      
      field.classList.remove('is-invalid', 'is-valid');
      if (type === 'error') {
        field.classList.add('is-invalid');
      } else if (type === 'success') {
        field.classList.add('is-valid');
      }
    }
  }

  function hideValidationMessage(fieldId) {
    const validationDiv = document.getElementById(fieldId + 'Validation');
    const field = document.getElementById(fieldId);
    
    if (validationDiv) {
      validationDiv.style.display = 'none';
      field.classList.remove('is-invalid', 'is-valid');
    }
  }

  function validateName(name) {
    if (!name.trim()) {
      return { valid: false, message: friendlyMessages.name.empty };
    }
    if (name.trim().length < 2) {
      return { valid: false, message: friendlyMessages.name.tooShort };
    }
    return { valid: true };
  }


  function validatePassword(password) {
    if (password.length < 6) {
      return { valid: false, message: friendlyMessages.password.tooShort };
    }
    return { valid: true };
  }

  function validateConfirmPassword(password, confirmPassword) {
    if (password !== confirmPassword) {
      return { valid: false, message: friendlyMessages.confirmPassword.noMatch };
    }
    return { valid: true };
  }

  function isFormValid() {
    const name = document.getElementById('name').value;
    const phone = document.getElementById('phone').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;

    return validateName(name).valid &&
           validatePhone(phone).valid &&
           validatePassword(password).valid &&
           validateConfirmPassword(password, confirmPassword).valid;
  }

  function updateSubmitButtonVisual() {
    const submitBtn = document.getElementById('submitBtn');
    if (isFormValid()) {
      submitBtn.style.opacity = '1';
    } else {
      submitBtn.style.opacity = '0.8';
    }
  }

  document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registerForm');
    const nameField = document.getElementById('name');
    const phoneField = document.getElementById('phone');
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('password_confirmation');

    updateSubmitButtonVisual();

    nameField.addEventListener('input', function() {
      const validation = validateName(this.value);
      if (this.value.length > 0 && !validation.valid) {
        showValidationMessage('name', validation.message, 'error');
      } else {
        hideValidationMessage('name');
      }
      updateSubmitButtonVisual();
    });

    phoneField.addEventListener('input', function() {
      const validation = validatePhone(this.value);
      if (this.value.length > 0 && !validation.valid) {
        showValidationMessage('phone', validation.message, 'error');
      } else {
        hideValidationMessage('phone');
      }
      updateSubmitButtonVisual();
    });

    passwordField.addEventListener('input', function() {
      const validation = validatePassword(this.value);
      if (this.value.length > 0 && !validation.valid) {
        showValidationMessage('password', validation.message, 'error');
      } else {
        hideValidationMessage('password');
      }
      
      if (confirmPasswordField.value.length > 0) {
        const confirmValidation = validateConfirmPassword(this.value, confirmPasswordField.value);
        if (!confirmValidation.valid) {
          showValidationMessage('confirmPassword', confirmValidation.message, 'error');
        } else {
          hideValidationMessage('confirmPassword');
        }
      }
      
      updateSubmitButtonVisual();
    });

    confirmPasswordField.addEventListener('input', function() {
      const validation = validateConfirmPassword(passwordField.value, this.value);
      if (this.value.length > 0 && !validation.valid) {
        showValidationMessage('confirmPassword', validation.message, 'error');
      } else {
        hideValidationMessage('confirmPassword');
      }
      updateSubmitButtonVisual();
    });

    document.querySelectorAll('.toggle-password').forEach(toggle => {
      toggle.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          this.click();
        }
      });
    });

    form.addEventListener('submit', function(e) {
      const submitBtn = document.getElementById('submitBtn');
      submitBtn.classList.add('loading');
      submitBtn.disabled = true;
      
      setTimeout(() => {
        submitBtn.classList.remove('loading');
        submitBtn.disabled = false;
      }, 5000);
    });

    const inputs = form.querySelectorAll('.form-control');
    inputs.forEach(input => {
      input.addEventListener('focus', function() {
        this.parentElement.classList.add('focused');
      });
      
      input.addEventListener('blur', function() {
        this.parentElement.classList.remove('focused');
      });
    });
  });
</script>

</body>
</html>