<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Donasi Online</title>
    
    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        /* Global Font Family */
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        /* Remove default body margin/padding */
        body {
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        /* Sidebar Base Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 0;
            z-index: 1000;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
            overflow-y: auto;
        }

        /* Sidebar Header */
        .sidebar-header {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            background: rgba(255,255,255,0.05);
        }

        .sidebar-header h3 {
            color: white;
            margin: 0;
            font-weight: 600;
            font-size: 1.5rem;
            font-family: 'Poppins', sans-serif;
        }

        .sidebar-header p {
            color: rgba(255,255,255,0.8);
            margin: 5px 0 0 0;
            font-size: 14px;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
        }

        .sidebar-header small {
            display: block;
            margin-top: 10px;
            font-size: 12px;
            color: rgba(255,255,255,0.7);
            font-family: 'Poppins', sans-serif;
        }

        /* Sidebar Menu */
        .sidebar-menu {
            padding: 20px 0 100px 0; /* Extra bottom padding for logout button */
        }

        .sidebar-menu .menu-item {
            display: block;
            padding: 15px 25px;
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            font-weight: 500;
            position: relative;
            font-family: 'Poppins', sans-serif;
        }

        .sidebar-menu .menu-item:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            padding-left: 35px;
            transform: translateX(5px);
            text-decoration: none;
        }

        .sidebar-menu .menu-item.active {
            background: rgba(255,255,255,0.2);
            border-right: 4px solid white;
            color: white;
            box-shadow: inset 0 0 20px rgba(255,255,255,0.1);
        }

        .sidebar-menu .menu-item i {
            width: 20px;
            margin-right: 15px;
            text-align: center;
            font-size: 16px;
        }

        /* External Link Styling */
        .sidebar-menu .menu-item-external {
            color: rgba(255,255,255,0.8);
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: 10px;
            padding-top: 20px;
        }

        .sidebar-menu .menu-item-external:hover {
            color: #fff;
            background: rgba(255,255,255,0.1);
            text-decoration: none;
        }

        /* Sidebar Divider */
        .sidebar-divider {
            height: 1px;
            background: linear-gradient(
                90deg, 
                transparent 10%, 
                rgba(255,255,255,0.2) 50%, 
                transparent 90%
            );
            margin: 15px 20px;
            position: relative;
        }

        .sidebar-divider::before {
            content: '';
            position: absolute;
            top: -1px;
            left: 50%;
            transform: translateX(-50%);
            width: 6px;
            height: 3px;
            background: rgba(255,255,255,0.3);
            border-radius: 2px;
        }

        /* Logout Button */
        .sidebar-logout {
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            padding: 0 20px;
        }

        .logout-btn {
            width: 100%;
            padding: 15px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: white;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: block;
            text-align: center;
            text-decoration: none;
            font-weight: 500;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
        }

        .logout-btn:hover {
            background: rgba(255,255,255,0.2);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .logout-btn:active {
            transform: translateY(0);
        }

        /* Main Content - FIXED LAYOUT */
        .main-content {
            margin-left: 280px; /* Same as sidebar width */
            padding: 30px;
            min-height: 100vh;
            background-color: #f8f9fa;
            width: calc(100% - 280px); /* Prevent overflow */
            box-sizing: border-box;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                padding: 20px;
                width: 100%;
            }
            
            /* Mobile overlay */
            .sidebar.active::after {
                content: '';
                position: fixed;
                top: 0;
                left: 280px;
                width: calc(100vw - 280px);
                height: 100vh;
                background: rgba(0,0,0,0.5);
                z-index: -1;
            }
        }

        /* Scrollbar Styling for Sidebar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.5);
        }

        /* Animation for active states */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .sidebar-menu .menu-item.active {
            animation: slideIn 0.3s ease;
        }

        /* Additional Styling */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            font-family: 'Poppins', sans-serif;
        }

        .btn-primary {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
        }

        .alert {
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
        }

        /* Breadcrumb styling */
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 1.5rem;
            font-family: 'Poppins', sans-serif;
        }

        .breadcrumb-item a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }

        .breadcrumb-item a:hover {
            color: #764ba2;
        }

        .breadcrumb-item.active {
            color: #6c757d;
            font-weight: 500;
        }

        /* Mobile Sidebar Toggle */
        .mobile-toggle {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            border-radius: 8px;
            padding: 10px 12px;
            color: white;
            font-size: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }

        .mobile-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }

        /* Page title styling */
        .page-title {
            color: #2d3748;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            margin-bottom: 1.5rem;
        }

        /* Stats cards enhancement */
        .stats-card {
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Header -->
        <div class="sidebar-header">
            <h3><i class="fas fa-heart me-2"></i>Kindify.id</h3>
            <p>Admin Panel</p>
            @auth
                <small class="text-white-50">Welcome, {{ auth()->user()->name }}</small>
            @endauth
        </div>
        
        <!-- Sidebar Menu -->
        <nav class="sidebar-menu">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" 
               class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>

            <!-- Verify Campaigns -->
            <a href="{{ route('admin.campaigns.verify') }}" 
               class="menu-item {{ request()->routeIs('admin.campaigns.verify') ? 'active' : '' }}">
                <i class="fas fa-check-double"></i>
                Verify Campaigns
            </a>

            <!-- Campaign Management -->
            <a href="{{ route('admin.campaigns.index') }}" 
               class="menu-item {{ request()->routeIs('admin.campaigns.*') && !request()->routeIs('admin.campaigns.verify') ? 'active' : '' }}">
                <i class="fas fa-bullhorn"></i>
                Campaign Management
            </a>

            <!-- Donations -->
            <a href="{{ route('admin.donations.index') }}" 
               class="menu-item {{ request()->routeIs('admin.donations.*') ? 'active' : '' }}">
                <i class="fas fa-hand-holding-heart"></i>
                Donations
            </a>

            <!-- Manage Admins -->
            <a href="{{ route('admin.list-admins') }}" 
               class="menu-item {{ request()->routeIs('admin.list-admins') ? 'active' : '' }}">
                <i class="fas fa-users-cog"></i>
                Manage Pengguna & Admins
            </a>

            <!-- Divider -->
            <div class="sidebar-divider"></div>

            <!-- View Site -->
            <a href="{{ url('/') }}" 
               target="_blank" 
               class="menu-item menu-item-external">
                <i class="fas fa-external-link-alt"></i>
                View Site
            </a>
        </nav>
        
        <!-- Logout Button -->
        <div class="sidebar-logout">
            <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin logout?')">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Mobile Sidebar Toggle -->
    <div class="d-md-none">
        <button class="mobile-toggle" type="button" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                @yield('breadcrumb')
            </ol>
        </nav>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('message') || session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-info-circle me-2"></i>{{ session('message') ?? session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Page Content -->
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar JavaScript Functions
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile sidebar toggle
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');
            
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                });
                
                // Close sidebar when clicking outside on mobile
                document.addEventListener('click', function(e) {
                    if (window.innerWidth <= 768) {
                        if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                            sidebar.classList.remove('active');
                        }
                    }
                });
            }
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar?.classList.remove('active');
                }
            });
            
            // Auto-collapse mobile sidebar when navigating
            const sidebarLinks = document.querySelectorAll('.sidebar-menu .menu-item:not(.menu-item-external)');
            
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        setTimeout(() => {
                            sidebar?.classList.remove('active');
                        }, 150);
                    }
                });
            });
            
            // Logout confirmation with better UX
            const logoutForm = document.querySelector('.sidebar-logout form');
            
            if (logoutForm) {
                logoutForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const confirmed = confirm('Apakah Anda yakin ingin logout dari admin panel?');
                    
                    if (confirmed) {
                        const logoutBtn = this.querySelector('.logout-btn');
                        const originalContent = logoutBtn.innerHTML;
                        
                        logoutBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Logging out...';
                        logoutBtn.disabled = true;
                        
                        setTimeout(() => {
                            this.submit();
                        }, 500);
                    }
                });
            }
            
            // Auto hide alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert-dismissible');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
        function changeRole(userId, currentRole){
    const newRole = prompt("Masukkan role baru:", currentRole);
    if(!newRole) return;
    
    fetch('{{ route("admin.update-role") }}', {
        method: 'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}'
        },
        body: JSON.stringify({user_id:userId, new_role:newRole})
    })
    .then(res=>res.json())
    .then(data=>{
        alert(data.message);
        if(data.success) location.reload();
    })
    .catch(err=>console.error(err));
}

    </script>
    
    @yield('scripts')
</body>
</html>