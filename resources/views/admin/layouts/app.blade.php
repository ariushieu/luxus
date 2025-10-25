<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Trang chủ Admin') - LUXUS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #8B6B47;
            --secondary-color: #D4AF37;
            --accent-gold: #C9A961;
            --dark-bg: #3E2C1F;
            --light-beige: #F5F1E8;
            --sidebar-width: 280px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--dark-bg) 0%, var(--primary-color) 100%);
            color: white;
            overflow-y: auto;
            transition: var(--transition);
            z-index: 1000;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
        }

        .sidebar-header {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(212, 175, 55, 0.2);
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.1) 0%, transparent 100%);
        }

        .sidebar-header h2 {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: 4px;
            margin-bottom: 8px;
            background: linear-gradient(135deg, #D4AF37 0%, #F5E6C8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 2px 10px rgba(212, 175, 55, 0.3);
        }

        .sidebar-header p {
            margin: 0;
            opacity: 0.85;
            font-size: 0.9rem;
            color: var(--accent-gold);
            font-weight: 500;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-section-title {
            padding: 20px 20px 10px;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            opacity: 0.5;
            font-weight: 700;
            color: var(--accent-gold);
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: var(--transition);
            border-left: 3px solid transparent;
            position: relative;
            font-weight: 500;
        }

        .sidebar-menu a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 0;
            background: linear-gradient(90deg, rgba(212, 175, 55, 0.15) 0%, transparent 100%);
            transition: var(--transition);
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: rgba(212, 175, 55, 0.12);
            border-left-color: var(--secondary-color);
            color: white;
        }

        .sidebar-menu a:hover::before,
        .sidebar-menu a.active::before {
            width: 100%;
        }

        .sidebar-menu a i {
            width: 28px;
            margin-right: 15px;
            font-size: 1.15rem;
            color: var(--accent-gold);
            transition: var(--transition);
        }

        .sidebar-menu a:hover i,
        .sidebar-menu a.active i {
            color: var(--secondary-color);
            transform: scale(1.1);
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        /* Top Navbar */
        .top-navbar {
            background: linear-gradient(135deg, #ffffff 0%, var(--light-beige) 100%);
            border-bottom: 2px solid var(--accent-gold);
            padding: 18px 35px;
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: 0 4px 20px rgba(139, 107, 71, 0.1);
        }

        .top-navbar .navbar-brand {
            font-weight: 700;
            color: var(--dark-bg);
            font-size: 1.1rem;
        }

        .admin-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: 0 4px 12px rgba(139, 107, 71, 0.3);
            border: 3px solid white;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .admin-avatar::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, transparent 100%);
        }

        .admin-avatar:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 18px rgba(139, 107, 71, 0.5);
        }

        .admin-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .dropdown-toggle::after {
            margin-left: 8px;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 8px 24px rgba(139, 107, 71, 0.15);
            border-radius: 12px;
            padding: 8px;
            min-width: 220px;
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 10px 16px;
            transition: var(--transition);
            font-weight: 500;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, rgba(139, 107, 71, 0.1) 0%, rgba(212, 175, 55, 0.05) 100%);
            color: var(--primary-color);
        }

        .dropdown-item i {
            width: 20px;
        }

        .user-info-dropdown {
            padding: 12px 16px;
            border-bottom: 1px solid #e9ecef;
            margin-bottom: 8px;
        }

        .user-info-dropdown .user-name {
            font-weight: 700;
            color: var(--dark-bg);
            margin-bottom: 4px;
        }

        .user-info-dropdown .user-email {
            font-size: 0.85rem;
            color: #6c757d;
        }

        /* Content Area */
        .content-area {
            padding: 30px;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-bg);
            margin-bottom: 10px;
        }

        .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
        }

        /* Cards */
        .stat-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(139, 107, 71, 0.12);
            transition: var(--transition);
            background: white;
            overflow: hidden;
            position: relative;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, var(--secondary-color) 0%, transparent 70%);
            opacity: 0.08;
            border-radius: 0 16px 0 100%;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 35px rgba(139, 107, 71, 0.2);
        }

        .stat-card .card-body {
            padding: 28px;
            position: relative;
            z-index: 1;
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 18px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
        }

        .stat-icon::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.3) 0%, transparent 100%);
        }

        .stat-value {
            font-size: 2.4rem;
            font-weight: 800;
            color: var(--dark-bg);
            margin-bottom: 8px;
            line-height: 1;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.95rem;
            font-weight: 500;
        }

        /* Table */
        .data-table {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(139, 107, 71, 0.1);
            overflow: hidden;
        }

        .table thead {
            background: linear-gradient(135deg, var(--light-beige) 0%, #ffffff 100%);
            border-bottom: 2px solid var(--accent-gold);
        }

        .table th {
            font-weight: 700;
            color: var(--dark-bg);
            border: none;
            padding: 18px 15px;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table td {
            padding: 16px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
        }

        .table tbody tr {
            transition: var(--transition);
        }

        .table tbody tr:hover {
            background-color: rgba(245, 241, 232, 0.4);
            transform: scale(1.01);
        }

        /* Buttons */
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            color: white;
            padding: 12px 28px;
            border-radius: 10px;
            font-weight: 700;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(139, 107, 71, 0.3);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(139, 107, 71, 0.4);
            color: white;
        }

        .btn-primary-custom:active {
            transform: translateY(-1px);
        }

        /* Badge Styles */
        .badge {
            padding: 6px 14px;
            font-weight: 600;
            border-radius: 6px;
            font-size: 0.8rem;
            letter-spacing: 0.3px;
        }

        .badge.bg-warning {
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%) !important;
            color: #000;
        }

        .badge.bg-info {
            background: linear-gradient(135deg, #17a2b8 0%, #0d8fa8 100%) !important;
        }

        .badge.bg-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%) !important;
        }

        .badge.bg-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
        }

        .badge.bg-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
        }

        .badge.bg-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%) !important;
        }

        /* Mobile Sidebar Toggle */
        .sidebar-toggle {
            display: none;
            position: fixed;
            bottom: 25px;
            right: 25px;
            width: 65px;
            height: 65px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border: none;
            box-shadow: 0 8px 25px rgba(139, 107, 71, 0.4);
            z-index: 1001;
            font-size: 1.6rem;
            transition: var(--transition);
        }

        .sidebar-toggle:hover {
            transform: scale(1.1) rotate(90deg);
            box-shadow: 0 10px 30px rgba(139, 107, 71, 0.5);
        }

        .sidebar-toggle:active {
            transform: scale(1.05) rotate(90deg);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .content-area {
                padding: 20px;
            }
        }

        @media (max-width: 576px) {
            .top-navbar {
                padding: 15px;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .stat-card .card-body {
                padding: 20px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2>LUXUS</h2>
            <p>Admin Panel</p>
        </div>

        <div class="sidebar-menu">
            <div class="menu-section-title">Trang chính</div>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Trang chủ Admin</span>
            </a>

            <div class="menu-section-title">Quản lý Nội dung</div>
            <a href="{{ route('admin.sliders.index') }}" class="{{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                <i class="fas fa-images"></i>
                <span>Slider Trang chủ</span>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-folder"></i>
                <span>Danh mục</span>
            </a>
            <a href="{{ route('admin.projects.index') }}" class="{{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                <i class="fas fa-briefcase"></i>
                <span>Dự án</span>
            </a>

            <div class="menu-section-title">Quản lý Khách hàng</div>
            <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-check"></i>
                <span>Lịch Hẹn</span>
            </a>
            <a href="{{ route('admin.quotes.index') }}" class="{{ request()->routeIs('admin.quotes.*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice"></i>
                <span>Yêu cầu Báo giá</span>
            </a>

            <div class="menu-section-title">Cài đặt</div>
            <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i>
                <span>Cấu hình Website</span>
            </a>

            <div class="menu-section-title">Website</div>
            <a href="{{ route('home') }}" target="_blank">
                <i class="fas fa-external-link-alt"></i>
                <span>Xem Website</span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <nav class="top-navbar">
            <div class="d-flex justify-content-between align-items-center">
                <div class="navbar-brand">
                    <i class="fas fa-bars d-lg-none me-3" style="cursor: pointer;" onclick="toggleSidebar()"></i>
                    @yield('page-title', 'Trang chủ Admin')
                </div>

                <div class="dropdown">
                    <button class="btn btn-link text-decoration-none dropdown-toggle d-flex align-items-center"
                        type="button"
                        data-bs-toggle="dropdown"
                        style="color: var(--dark-bg);">
                        <div class="admin-avatar me-2">
                            @if(Auth::guard('admin')->user()->avatar)
                            <img src="{{ Auth::guard('admin')->user()->avatar }}" alt="Admin Avatar">
                            @else
                            <i class="fas fa-user-shield" style="font-size: 1.3rem;"></i>
                            @endif
                        </div>
                        <span class="d-none d-md-inline fw-semibold">{{ Auth::guard('admin')->user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li class="user-info-dropdown">
                            <div class="user-name">{{ Auth::guard('admin')->user()->name }}</div>
                            <div class="user-email">{{ Auth::guard('admin')->user()->email }}</div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('home') }}" target="_blank">
                                <i class="fas fa-globe"></i> Xem Website
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Content Area -->
        <div class="content-area">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-times-circle me-2"></i>
                <strong>Có lỗi xảy ra:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Mobile Sidebar Toggle -->
    <button class="sidebar-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.sidebar-toggle');
            const menuIcon = document.querySelector('.fa-bars');

            if (window.innerWidth <= 992) {
                if (!sidebar.contains(event.target) &&
                    event.target !== toggle &&
                    !toggle.contains(event.target) &&
                    event.target !== menuIcon) {
                    sidebar.classList.remove('show');
                }
            }
        });

        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>

    @stack('scripts')
</body>

</html>