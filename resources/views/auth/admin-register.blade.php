<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
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
    }

    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
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

    /* Enhanced Form Controls - Removed harsh red styling */
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

    /* Gentler validation styling */
    .form-floating > .form-control.needs-attention {
      border-color: var(--warning-color);
      background-color: var(--warning-bg);
    }

    .form-floating > .form-control.looks-good {
      border-color: var(--success-color);
      background-color: var(--success-bg);
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

    .btn-register:hover {
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
    }

    /* Friendly alert styling */
    .friendly-alert {
      border: none;
      border-radius: 12px;
      padding: 1rem 1.25rem;
      margin-bottom: 1.5rem;
      font-size: 0.9rem;
      display: flex;
      align-items: flex-start;
      gap: 0.75rem;
    }

    .friendly-alert.warning {
      background: linear-gradient(135deg, #FEF3C7 0%, #FEF9E7 100%);
      color: #92400E;
      border-left: 4px solid var(--warning-color);
    }

    .friendly-alert.success {
      background: linear-gradient(135deg, #D1FAE5 0%, #ECFDF5 100%);
      color: #065F46;
      border-left: 4px solid var(--success-color);
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
      <h3>Buat Akun Baru</h3>
      <p>Yuk lengkapi data di bawah buat jadi admin! 🚀</p>
    </div>

    <!-- Demo Error Messages (friendly version) -->
    <div class="friendly-alert warning" id="errorAlert" style="display: none;">
      <i class="bi bi-info-circle-fill"></i>
      <div id="errorContent"></div>
    </div>

    <!-- Success Message -->
    <div class="friendly-alert success" id="successAlert" style="display: none;">
      <i class="bi bi-check-circle-fill"></i>
      <div>Yeay! Akun berhasil dibuat! Selamat datang di tim! 🎉</div>
    </div>

    <form id="registerForm" onsubmit="return handleSubmit(event)">
      <!-- Name Field - no validation -->
      <div class="form-floating">
        <input type="text" class="form-control" 
               id="name" name="name" placeholder="Nama Lengkap" 
               required autocomplete="name">
        <label for="name">
          <i class="bi bi-person me-2"></i>Nama Lengkap
        </label>
      </div>

      <!-- Email Field - validate gmail.com only -->
         <div class="form-group mt-4">
        <div class="floating-label">
          <input id="phone" type="number" name="phone" value="{{ old('phone') }}" required placeholder="phone " />
          <label for="phone"><i class="bi bi-envelope"></i> phone</label>
        </div>
        @error('phone')
          <div class="error-message bounce-in">{{ $message }}</div>
        @enderror
        <div id="phoneMessage"></div>
      </div>

      <!-- Password Field - no validation -->
      <div class="form-floating password-wrapper">
        <input type="password" class="form-control"
               id="password" name="password" placeholder="Password" required 
               autocomplete="new-password" minlength="6">
        <label for="password">
          <i class="bi bi-lock me-2"></i>Kata Sandi
        </label>
        
        <span class="toggle-password" onclick="togglePassword('password')" tabindex="0" role="button" 
              aria-label="Toggle password visibility">
          <i class="bi bi-eye-slash" id="passwordEyeIcon"></i>
        </span>
      </div>

      <!-- Confirm Password Field - with validation -->
      <div class="form-floating password-wrapper">
        <input type="password" class="form-control" 
               id="password_confirmation" name="password_confirmation" 
               placeholder="Konfirmasi Password" required 
               autocomplete="new-password" 
               onblur="validatePasswordConfirmation()" onkeyup="validatePasswordConfirmation()">
        <label for="password_confirmation">
          <i class="bi bi-shield-lock me-2"></i>Konfirmasi Kata Sandi
        </label>
        
        <span class="toggle-password" onclick="togglePassword('password_confirmation')" tabindex="0" role="button" 
              aria-label="Toggle password confirmation visibility">
          <i class="bi bi-eye-slash" id="confirmPasswordEyeIcon"></i>
        </span>
        
        <div id="confirmPasswordMessage"></div>
      </div>

      <button type="submit" class="btn btn-register" id="submitBtn">
        <i class="bi bi-person-plus me-2"></i>
        Daftar Akun Sekarang!
      </button>

      <div class="login-link">
        <p>Udah punya akun? <a href="/admin/login">Login aja di sini</a></p>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  const friendlyMessages = {
    email: {
      invalid: "Email harus pakai format @gmail.com ya!",
      noAt: "Email harus pakai format @gmail.com ya!",
    },
    confirmPassword: {
      tooShort: "Password minimal 6 karakter ya biar aman!",
      noMatch: "Password ga sama nih! Coba cek lagi ya! ",
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

  function validateEmail() {
    const email = document.getElementById('email').value.trim().toLowerCase();
    const field = document.getElementById('email');
    
    if (email === '') {
      field.className = 'form-control';
      showMessage('emailMessage', '');
      return true; 
    }
    
    if (!email.includes('@')) {
      field.className = 'form-control needs-attention';
      showMessage('emailMessage', friendlyMessages.email.noAt, 'helper');
      return false;
    }
    
    if (!email.endsWith('@gmail.com')) {
      field.className = 'form-control needs-attention';
      showMessage('emailMessage', friendlyMessages.email.invalid, 'helper');
      return false;
    }
    
    const username = email.split('@')[0];
    if (username.length === 0) {
      field.className = 'form-control needs-attention';
      showMessage('emailMessage', friendlyMessages.email.invalid, 'helper');
      return false;
    }
    
    field.className = 'form-control looks-good';
    showMessage('emailMessage', friendlyMessages.email.valid, 'success');
    return true;
  }

  function validatePasswordConfirmation() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;
    const field = document.getElementById('password_confirmation');
    
    if (confirmPassword === '') {
      field.className = 'form-control';
      showMessage('confirmPasswordMessage', '');
    }
    
    if (confirmPassword.length < 6) {
      field.className = 'form-control needs-attention';
      showMessage('confirmPasswordMessage', friendlyMessages.confirmPassword.tooShort, 'helper');
      return false;
    }
    
    if (password !== '' && confirmPassword !== password) {
      field.className = 'form-control needs-attention';
      showMessage('confirmPasswordMessage', friendlyMessages.confirmPassword.noMatch, 'helper');
      return false;
    }
    
    field.className = 'form-control looks-good';
    showMessage('confirmPasswordMessage', friendlyMessages.confirmPassword.valid, 'success');
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
  }

  function handleSubmit(event) {
    event.preventDefault();
    
    const isEmailValid = validateEmail();
    const isPasswordConfirmValid = validatePasswordConfirmation();
    
    if (!isEmailValid || !isPasswordConfirmValid) {
      const errorAlert = document.getElementById('errorAlert');
      const errorContent = document.getElementById('errorContent');
      
      let errorMessages = [];
      if (!isEmailValid) errorMessages.push("Email belum sesuai format Gmail");
      if (!isPasswordConfirmValid) errorMessages.push("Konfirmasi password belum benar");
      
      errorContent.innerHTML = `${errorMessages.join(" dan ")}! Cek lagi ya! 😅`;
      errorAlert.style.display = 'flex';
      errorAlert.classList.add('bounce-in');
      
      window.scrollTo({ top: 0, behavior: 'smooth' });
      
      setTimeout(() => {
        errorAlert.style.display = 'none';
      }, 5000);
      
      return false;
    }
    
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.classList.add('loading');
    submitBtn.disabled = true;
    
    setTimeout(() => {
      const successAlert = document.getElementById('successAlert');
      const successContent = successAlert.querySelector('div:last-child');
      
      successContent.innerHTML = `
        📧 Email verifikasi sudah dikirim! <br>
        Cek inbox Gmail kamu dan klik link verifikasinya ya! <br>
        <small style="opacity: 0.8; margin-top: 8px; display: block;">
          Redirecting ke halaman login dalam 3 detik...
        </small>
      `;
      
      successAlert.style.display = 'flex';
      successAlert.classList.add('bounce-in');
      
      submitBtn.classList.remove('loading');
      submitBtn.disabled = false;
      
      document.getElementById('registerForm').reset();
      document.querySelectorAll('.form-control').forEach(field => {
        field.className = 'form-control';
      });
      document.querySelectorAll('[id$="Message"]').forEach(msg => {
        msg.innerHTML = '';
      });
      
      window.scrollTo({ top: 0, behavior: 'smooth' });
      
      setTimeout(() => {
        alert('Redirect ke halaman login! (Demo mode)');
      }, 3000);
    }, 2000);
    
    return false;
  }

  document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registerForm');
    const inputs = form.querySelectorAll('.form-control');
    
    inputs.forEach(input => {
      input.addEventListener('focus', function() {
        this.parentElement.classList.add('focused');
      });
      
      input.addEventListener('blur', function() {
        this.parentElement.classList.remove('focused');
      });
    });
    
    document.querySelectorAll('.toggle-password').forEach(toggle => {
      toggle.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          this.click();
        }
      });
    });
    
    document.getElementById('registerForm').addEventListener('input', function() {
      document.getElementById('errorAlert').style.display = 'none';
      document.getElementById('successAlert').style.display = 'none';
    });
  });
</script>

</body>
</html>