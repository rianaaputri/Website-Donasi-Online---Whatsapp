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
    :root{
      --primary-blue:#E3F2FD;--secondary-blue:#BBDEFB;--accent-blue:#64B5F6;--dark-blue:#2196F3;
      --text-primary:#1E3A8A;--text-secondary:#64748B;--border-color:#E1E7EF;
      --shadow-light:rgba(33,150,243,0.08);--shadow-medium:rgba(33,150,243,0.15);
      --warning-color:#F59E0B;--warning-bg:#FEF3C7;--success-color:#10B981;--success-bg:#D1FAE5;
      --danger-color:#EF4444;--danger-bg:#FEE2E2;
    }
    body{
      font-family:'Poppins',sans-serif;
      background:linear-gradient(135deg,#E3F2FD 0%,#F8FAFC 100%);
      min-height:100vh;display:flex;align-items:center;justify-content:center;padding:1rem;
    }
    .register-wrapper{width:100%;max-width:450px;}
    .register-container{
      background:#fff;border:1px solid var(--border-color);
      border-radius:20px;padding:2rem;box-shadow:0 8px 24px rgba(0,0,0,.05);
    }
    .register-header{text-align:center;margin-bottom:2rem}
    .register-header h3{color:var(--text-primary);font-weight:600}
    .register-header p{color:var(--text-secondary);font-size:.95rem}
    .form-group{margin-bottom:1.5rem}
    .floating-label{position:relative}
    .floating-label label{
      position:absolute;left:1rem;top:1rem;color:var(--text-secondary);
      transition:all .2s;font-size:.9rem;pointer-events:none;
    }
    .floating-label input:focus ~ label,
    .floating-label input:not(:placeholder-shown) ~ label{
      top:-.6rem;left:.8rem;font-size:.8rem;color:var(--dark-blue);background:#fff;padding:0 .3rem;
    }
    input{
      border:2px solid var(--border-color);border-radius:14px;padding:1rem;font-size:.95rem;width:100%;
    }
    input:focus{border-color:var(--dark-blue);outline:none}
    .error-message{color:var(--danger-color);font-size:.85rem;margin-top:.4rem}
    .btn-register{
      background:linear-gradient(135deg,var(--accent-blue),var(--dark-blue));
      border:none;border-radius:14px;padding:.9rem 1.2rem;color:#fff;font-weight:600;width:100%;
    }
    .btn-register:hover{opacity:.9}
    .login-link{text-align:center;margin-top:1rem}
  </style>
</head>
<body>

<div class="register-wrapper">
  <div class="register-container">
    <div class="register-header">
      <h3>Daftar Akun</h3>
      <p>Isi data berikut, kode OTP akan dikirim ke WhatsApp Anda.</p>
    </div>

    <!-- ✅ Action langsung ke route("register") -->
    <form method="POST" action="{{ route('register') }}" id="registerForm">
      @csrf

      <!-- Name -->
      <div class="form-group">
        <div class="floating-label">
          <input id="name" type="text" name="name" value="{{ old('name') }}" required placeholder=" " />
          <label for="name"><i class="bi bi-person"></i> Nama Lengkap</label>
        </div>
        @error('name') <div class="error-message">{{ $message }}</div> @enderror
      </div>

      <!-- Phone -->
      <div class="form-group">
        <div class="floating-label">
          <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required placeholder=" " />
          <label for="phone"><i class="bi bi-telephone"></i> Nomor WhatsApp (628...)</label>
        </div>
        @error('phone') <div class="error-message">{{ $message }}</div> @enderror
      </div>

      <!-- Password -->
      <div class="form-group">
        <div class="floating-label">
          <input id="password" type="password" name="password" required placeholder=" " />
          <label for="password"><i class="bi bi-lock"></i> Password</label>
        </div>
        @error('password') <div class="error-message">{{ $message }}</div> @enderror
      </div>

      <!-- Confirm Password -->
      <div class="form-group">
        <div class="floating-label">
          <input id="password_confirmation" type="password" name="password_confirmation" required placeholder=" " />
          <label for="password_confirmation"><i class="bi bi-shield-lock"></i> Konfirmasi Password</label>
        </div>
      </div>

      <button type="submit" class="btn-register"><i class="bi bi-person-plus me-2"></i> Daftar</button>
    </form>

    <div class="login-link">
      <a href="{{ route('login') }}">Sudah punya akun? Login</a><br>
      <a href="{{ route('verify.otp.form') }}"><i class="bi bi-key"></i> Sudah dapat OTP? Masukkan di sini</a>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
