<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập Admin - LUXUS Interior Design</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-gold: #C9A961;
            --dark-brown: #2C2416;
            --light-gold: #E8D5B5;
            --white: #FFFFFF;
            --shadow: rgba(0, 0, 0, 0.15);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: url('https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?q=80&w=2400&auto=format&fit=crop') center/cover no-repeat fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
            padding: 20px;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg,
                    rgba(44, 36, 22, 0.92) 0%,
                    rgba(62, 44, 31, 0.88) 50%,
                    rgba(44, 36, 22, 0.92) 100%);
            z-index: 0;
        }

        body::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 10% 20%, rgba(201, 169, 97, 0.08) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(201, 169, 97, 0.08) 0%, transparent 40%);
            z-index: 0;
            animation: breathe 8s ease-in-out infinite;
        }

        @keyframes breathe {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.6;
            }
        }

        .login-wrapper {
            width: 100%;
            max-width: 1000px;
            max-height: 90vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            position: relative;
            z-index: 1;
            gap: 0;
            box-shadow: 0 30px 90px rgba(0, 0, 0, 0.6);
            border-radius: 20px;
            overflow: hidden;
        }

        .login-left {
            background: linear-gradient(135deg,
                    rgba(201, 169, 97, 0.95) 0%,
                    rgba(232, 213, 181, 0.95) 100%),
                url('https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?q=80&w=1200&auto=format&fit=crop') center/cover;
            padding: 40px 35px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: shimmer 4s infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%) translateY(-100%) rotate(45deg);
            }

            100% {
                transform: translateX(100%) translateY(100%) rotate(45deg);
            }
        }

        .logo-section {
            position: relative;
            z-index: 1;
        }

        .logo-icon {
            font-size: 60px;
            margin-bottom: 15px;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .brand-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--dark-brown);
            letter-spacing: 6px;
            margin-bottom: 12px;
            text-shadow: 2px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .brand-subtitle {
            font-size: 1rem;
            color: var(--dark-brown);
            font-weight: 500;
            letter-spacing: 2px;
            text-transform: uppercase;
            opacity: 0.9;
        }

        .decorative-line {
            width: 80px;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--dark-brown), transparent);
            margin: 20px auto;
        }

        .welcome-text {
            font-size: 0.9rem;
            color: var(--dark-brown);
            line-height: 1.6;
            max-width: 350px;
            opacity: 0.85;
            font-weight: 400;
        }

        .login-right {
            background: #FFFFFF;
            padding: 40px 35px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow-y: auto;
        }

        .login-header {
            margin-bottom: 30px;
        }

        .login-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.9rem;
            font-weight: 700;
            color: var(--dark-brown);
            margin-bottom: 8px;
        }

        .login-subtitle {
            color: #666;
            font-size: 0.88rem;
            font-weight: 400;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--dark-brown);
            margin-bottom: 6px;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-gold);
            font-size: 1.1rem;
            z-index: 2;
        }

        .form-control {
            width: 100%;
            padding: 12px 18px 12px 45px;
            border: 2px solid #E5E5E5;
            border-radius: 10px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            background: #FAFAFA;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-gold);
            background: #FFFFFF;
            box-shadow: 0 4px 12px rgba(201, 169, 97, 0.15);
        }

        .form-control::placeholder {
            color: #999;
        }

        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .form-check-input {
            width: 16px;
            height: 16px;
            margin-right: 8px;
            cursor: pointer;
            border: 2px solid #DDD;
        }

        .form-check-input:checked {
            background-color: var(--primary-gold);
            border-color: var(--primary-gold);
        }

        .form-check-label {
            font-size: 0.9rem;
            color: #666;
            cursor: pointer;
            user-select: none;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--primary-gold) 0%, #B8935A 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 0.95rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(201, 169, 97, 0.3);
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(201, 169, 97, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: #E5E5E5;
        }

        .divider-text {
            position: relative;
            display: inline-block;
            padding: 0 15px;
            background: white;
            color: #999;
            font-size: 0.85rem;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--primary-gold);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            gap: 12px;
            color: var(--dark-brown);
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            border: none;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.4s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-danger {
            background: #FEE;
            color: #C33;
        }

        .footer-text {
            text-align: center;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.8rem;
            margin-top: 20px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 1;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .login-wrapper {
                max-width: 900px;
            }
        }

        @media (max-width: 992px) {
            .login-wrapper {
                grid-template-columns: 1fr;
                max-width: 480px;
                max-height: 85vh;
            }

            .login-left {
                padding: 30px 25px;
            }

            .brand-title {
                font-size: 2.2rem;
                letter-spacing: 4px;
            }

            .logo-icon {
                font-size: 50px;
                margin-bottom: 10px;
            }

            .decorative-line {
                margin: 15px auto;
            }

            .welcome-text {
                font-size: 0.85rem;
                margin-top: 20px !important;
            }

            .login-right {
                padding: 30px 25px;
            }

            .login-title {
                font-size: 1.7rem;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 15px 10px;
            }

            .login-wrapper {
                max-width: 100%;
                max-height: 90vh;
            }

            .login-left {
                padding: 25px 20px;
            }

            .brand-title {
                font-size: 2rem;
                letter-spacing: 3px;
            }

            .logo-icon {
                font-size: 45px;
            }

            .brand-subtitle {
                font-size: 0.9rem;
            }

            .welcome-text {
                font-size: 0.82rem;
                line-height: 1.5;
            }

            .login-right {
                padding: 25px 20px;
            }

            .login-header {
                margin-bottom: 20px;
            }

            .login-title {
                font-size: 1.5rem;
            }

            .login-subtitle {
                font-size: 0.82rem;
            }

            .form-group {
                margin-bottom: 18px;
            }

            .form-control {
                padding: 11px 16px 11px 42px;
                font-size: 0.88rem;
            }

            .input-icon {
                font-size: 1rem;
                left: 15px;
            }

            .btn-login {
                padding: 13px;
                font-size: 0.9rem;
            }

            .form-check {
                margin-bottom: 20px;
            }

            .divider {
                margin: 18px 0;
            }

            .footer-text {
                font-size: 0.75rem;
                margin-top: 15px;
            }
        }

        @media (max-width: 576px) {
            body {
                padding: 10px 5px;
            }

            .login-wrapper {
                border-radius: 15px;
            }

            .login-left {
                padding: 20px 15px;
            }

            .brand-title {
                font-size: 1.8rem;
                letter-spacing: 2px;
            }

            .logo-icon {
                font-size: 40px;
            }

            .brand-subtitle {
                font-size: 0.85rem;
                letter-spacing: 1.5px;
            }

            .welcome-text {
                font-size: 0.8rem;
                max-width: 280px;
            }

            .login-right {
                padding: 20px 15px;
            }

            .login-title {
                font-size: 1.4rem;
            }

            .login-subtitle {
                font-size: 0.78rem;
            }

            .form-label {
                font-size: 0.82rem;
            }

            .form-control {
                padding: 10px 14px 10px 40px;
                font-size: 0.85rem;
            }

            .btn-login {
                padding: 12px;
                font-size: 0.88rem;
            }

            .back-link {
                font-size: 0.85rem;
            }

            .alert {
                padding: 12px 15px;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 400px) {
            .brand-title {
                font-size: 1.6rem;
            }

            .login-title {
                font-size: 1.3rem;
            }

            .form-control {
                padding: 9px 12px 9px 38px;
                font-size: 0.82rem;
            }
        }

        @media (max-height: 700px) {
            .login-wrapper {
                max-height: 95vh;
            }

            .login-left,
            .login-right {
                padding: 25px 20px;
            }

            .form-group {
                margin-bottom: 15px;
            }

            .login-header {
                margin-bottom: 20px;
            }

            .form-check {
                margin-bottom: 18px;
            }

            .divider {
                margin: 15px 0;
            }

            .footer-text {
                margin-top: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="login-wrapper">
        <!-- Left Side - Branding -->
        <div class="login-left">
            <div class="logo-section">
                <div class="logo-icon">🏛️</div>
                <h1 class="brand-title">LUXUS</h1>
                <div class="decorative-line"></div>
                <p class="brand-subtitle">Interior Design</p>
                <div style="margin-top: 40px;">
                    <p class="welcome-text">
                        Hệ thống quản trị nội dung dành cho quản trị viên.
                        Đăng nhập để truy cập vào bảng điều khiển quản lý.
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="login-right">
            <div class="login-header">
                <h2 class="login-title">Đăng Nhập Admin</h2>
                <p class="login-subtitle">Chào mừng trở lại! Vui lòng đăng nhập để tiếp tục</p>
            </div>

            @if ($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <strong>{{ $errors->first() }}</strong>
            </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}" id="loginForm">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope"></i> Địa chỉ Email
                    </label>
                    <div class="input-wrapper">
                        <i class="fas fa-user input-icon"></i>
                        <input
                            type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="admin@luxus.com"
                            required
                            autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock"></i> Mật khẩu
                    </label>
                    <div class="input-wrapper">
                        <i class="fas fa-key input-icon"></i>
                        <input
                            type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            id="password"
                            name="password"
                            placeholder="Nhập mật khẩu của bạn"
                            required>
                    </div>
                </div>

                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="remember"
                        id="remember">
                    <label class="form-check-label" for="remember">
                        Ghi nhớ đăng nhập
                    </label>
                </div>

                <button type="submit" class="btn-login" id="loginBtn">
                    <i class="fas fa-sign-in-alt"></i> Đăng Nhập
                </button>

                <div class="divider">
                    <span class="divider-text">hoặc</span>
                </div>

                <div style="text-align: center;">
                    <a href="{{ route('home') }}" class="back-link">
                        <i class="fas fa-arrow-left"></i>
                        <span>Quay lại Trang chủ</span>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="footer-text">
        &copy; {{ date('Y') }} LUXUS Interior Design. All Rights Reserved.
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form submission with loading state
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('loginBtn');
            const originalHtml = btn.innerHTML;

            btn.disabled = true;
            btn.style.opacity = '0.7';
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang đăng nhập...';

            // Re-enable after 5s in case of error
            setTimeout(function() {
                btn.disabled = false;
                btn.style.opacity = '1';
                btn.innerHTML = originalHtml;
            }, 5000);
        });

        // Add input animation
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
                this.parentElement.style.transition = 'transform 0.3s ease';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>

</html>