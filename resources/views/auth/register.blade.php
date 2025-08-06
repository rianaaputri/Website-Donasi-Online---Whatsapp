<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
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
    .floating-label input.has-value ~ label {
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
    input[type="text"],
    input[type="email"],
    input[type="password"] {
      border: 2px solid var(--border-color);
      border-radius: 16px;
      padding: 1rem 1.25rem;
      font-size: 0.95rem;
      background-color: rgba(248, 250, 252, 0.5);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      width: 100%;
      min-height: 3.5rem;
      outline: none;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus {
      border-color: var(--accent-blue);
      box-shadow: 0 0 0 4px rgba(100, 181, 246, 0.1);
      background-color: white;
    }

    /* Remove default placeholder visibility */
    input::placeholder {
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    input:focus::placeholder {
      opacity: 0.6;
    }

    /* Password field with icon */
    .password-wrapper {
      position: relative;
    }

    .password-wrapper input {
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
      content: '💡';
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

    /* Button Styling */
    .btn-register {
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

    /* Login Link */
    .login-link {
      text-align: center;
      margin-top: 1.5rem;
      padding-top: 1.5rem;
      border-top: 1px solid var(--border-color);
    }

    .login-link a {
      color: var(--dark-blue);
      text-decoration: none;
      font-weight: 600;
      font-size: 0.9rem;
      transition: color 0.2s ease;
    }

    .login-link a:hover {
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

    .form-actions .flex {
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 1rem;
    }

    @media (max-width: 480px) {
      .register-container {
        padding: 2rem 1.5rem;
        border-radius: 20px;
      }
      
      .register-header h3 {
        font-size: 1.5rem;
      }

      .form-actions .flex {
        flex-direction: column;
        align-items: stretch;
      }

      .btn-register {
        width: 100%;
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
  </style>
</head>
<body>

<div class="register-wrapper">
  <div class="register-container">
    <div class="register-header">
      <h3>Sign Up</h3>
      <p>Lengkapi data di bawah untuk membuat akun!</p>
    </div>

    <form method="POST" action="{{ route('register') }}" id="registerForm">
      @csrf

      <!-- Name -->
      <div class="form-group">
        <div class="floating-label">
          <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder=" " onblur="validateName()" onkeyup="validateName()" />
          <label for="name">
            <i class="bi bi-person"></i>
            Name
          </label>
        </div>
        @if($errors->get('name'))
          <div class="error-message bounce-in">
            <ul>
              @foreach($errors->get('name') as $message)
                <li>{{ $message }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        <div id="nameMessage"></div>
      </div>

      <!-- Email Address -->
      <div class="form-group mt-4">
        <div class="floating-label">
          <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" onblur="validateEmail()" onkeyup="validateEmail()" placeholder=" " />
          <label for="email">
            <i class="bi bi-envelope"></i>
            Email (Gmail)
          </label>
        </div>
        @if($errors->get('email'))
          <div class="error-message bounce-in">
            <ul>
              @foreach($errors->get('email') as $message)
                <li>{{ $message }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        <div id="emailMessage"></div>
      </div>

      <!-- Password -->
      <div class="form-group mt-4">
        <div class="floating-label password-wrapper">
          <input id="password" type="password" name="password" required autocomplete="new-password" onblur="validatePassword()" onkeyup="validatePassword()" placeholder=" " />
          <label for="password">
            <i class="bi bi-lock"></i>
            Password
          </label>
          <span class="toggle-password" onclick="togglePassword('password')" tabindex="0" role="button" aria-label="Toggle password visibility">
            <i class="bi bi-eye-slash" id="passwordEyeIcon"></i>
          </span>
        </div>
        @if($errors->get('password'))
          <div class="error-message bounce-in">
            <ul>
              @foreach($errors->get('password') as $message)
                <li>{{ $message }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        <div id="passwordMessage"></div>
      </div>

      <!-- Confirm Password -->
      <div class="form-group mt-4">
        <div class="floating-label password-wrapper">
          <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" onblur="validatePasswordConfirmation()" onkeyup="validatePasswordConfirmation()" placeholder=" " />
          <label for="password_confirmation">
            <i class="bi bi-shield-lock"></i>
            Confirm Password
          </label>
          <span class="toggle-password" onclick="togglePassword('password_confirmation')" tabindex="0" role="button" aria-label="Toggle password confirmation visibility">
            <i class="bi bi-eye-slash" id="confirmPasswordEyeIcon"></i>
          </span>
        </div>
        @if($errors->get('password_confirmation'))
          <div class="error-message bounce-in">
            <ul>
              @foreach($errors->get('password_confirmation') as $message)
                <li>{{ $message }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        <div id="confirmPasswordMessage"></div>
      </div>

      <div class="form-actions">
        <div class="flex">
          <a href="{{ route('login') }}">
            Already registered?
          </a>
          <button type="submit" class="btn-register" id="submitBtn">
            <i class="bi bi-person-plus me-2"></i>
            Register
          </button>
        </div>
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
    password: {
      tooShort: "Password minimal 6 karakter ya biar aman!",
    },
    confirmPassword: {
      tooShort: "Password ga sama nih! Coba cek lagi ya!",
      noMatch: "Password ga sama nih! Coba cek lagi ya!",
      valid: "Password cocok!"
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

  function validateName() {
    const name = document.getElementById('name').value.trim();
    const field = document.getElementById('name');
    
    if (name === '') {
      field.className = '';
      showMessage('nameMessage', '');
      return true; 
    }
    
    if (name.length < 2) {
      field.className = 'needs-attention';
      showMessage('nameMessage', 'Nama minimal 2 karakter ya!', 'helper');
      return false;
    }
    
    field.className = 'looks-good';
    showMessage('nameMessage', '');
    return true;
  }

  function validateEmail() {
    const email = document.getElementById('email').value.trim().toLowerCase();
    const field = document.getElementById('email');
    
    if (email === '') {
      field.className = '';
      showMessage('emailMessage', '');
      return true; 
    }
    
    if (!email.includes('@')) {
      field.className = 'needs-attention';
      showMessage('emailMessage', friendlyMessages.email.noAt, 'helper');
      return false;
    }
    
    if (!email.endsWith('@gmail.com')) {
      field.className = 'needs-attention';
      showMessage('emailMessage', friendlyMessages.email.invalid, 'helper');
      return false;
    }
    
    const username = email.split('@')[0];
    if (username.length === 0) {
      field.className = 'needs-attention';
      showMessage('emailMessage', friendlyMessages.email.invalid, 'helper');
      return false;
    }
    
    field.className = 'looks-good';
    showMessage('emailMessage', '');
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

  function validatePasswordConfirmation() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;
    const field = document.getElementById('password_confirmation');
    
    if (confirmPassword === '') {
      field.className = '';
      showMessage('confirmPasswordMessage', '');
      return true;
    }
    
    if (confirmPassword.length < 6) {
      field.className = 'needs-attention';
      showMessage('confirmPasswordMessage', friendlyMessages.confirmPassword.tooShort, 'helper');
      return false;
    }
    
    if (password !== '' && confirmPassword !== password) {
      field.className = 'needs-attention';
      showMessage('confirmPasswordMessage', friendlyMessages.confirmPassword.noMatch, 'helper');
      return false;
    }
    
    field.className = 'looks-good';
    showMessage('confirmPasswordMessage', '');
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

  document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registerForm');
    const inputs = form.querySelectorAll('input');
    
    // Handle floating labels for inputs with values (like from old() helper)
    inputs.forEach(input => {
      // Check if input has value on page load
      if (input.value && input.value.trim() !== '') {
        input.classList.add('has-value');
      }
      
      input.addEventListener('input', function() {
        if (this.value && this.value.trim() !== '') {
          this.classList.add('has-value');
        } else {
          this.classList.remove('has-value');
        }
      });
      
      input.addEventListener('focus', function() {
        this.parentElement.classList.add('focused');
      });
      
      input.addEventListener('blur', function() {
        this.parentElement.classList.remove('focused');
        // Keep has-value class if input still has content
        if (!this.value || this.value.trim() === '') {
          this.classList.remove('has-value');
        }
      });
    });
    
    // Enhanced toggle password accessibility
    document.querySelectorAll('.toggle-password').forEach(toggle => {
      toggle.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          this.click();
        }
      });
    });

    // Form submission validation
    form.addEventListener('submit', function(e) {
      const isNameValid = validateName();
      const isEmailValid = validateEmail();
      const isPasswordValid = validatePassword();
      const isPasswordConfirmValid = validatePasswordConfirmation();
      
      if (!isNameValid || !isEmailValid || !isPasswordValid || !isPasswordConfirmValid) {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
        return false;
      }
    });
  });
</script>

</body>
</html>