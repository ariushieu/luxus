<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LUXUS - Thiết kế Nội thất Cao cấp')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts - Premium Typography -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Montserrat:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom Interior Design Styles -->
    <link href="{{ asset('css/interior-design.css') }}" rel="stylesheet">

    <style>
        /* Enhanced Typography */
        body {
            font-family: 'Montserrat', sans-serif;
            color: var(--text-dark);
            line-height: 1.7;
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600;
        }

        /* Enhanced Navbar with Glass Effect */
        .navbar {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.08);
            padding: 0.8rem 0;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            padding: 0.5rem 0;
            box-shadow: 0 6px 40px rgba(0, 0, 0, 0.12);
        }

        .navbar-brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color) !important;
            letter-spacing: 3px;
            text-transform: uppercase;
            position: relative;
            transition: all 0.3s ease;
        }

        .navbar-brand::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--secondary-color), transparent);
            transition: width 0.3s ease;
        }

        .navbar-brand:hover::after {
            width: 100%;
        }

        .navbar-nav .nav-link {
            color: var(--text-dark);
            font-weight: 500;
            margin: 0 1rem;
            padding: 0.4rem 0;
            position: relative;
            transition: all 0.3s ease;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.8px;
        }

        .navbar-nav .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--secondary-color);
            transition: width 0.3s ease;
        }

        .navbar-nav .nav-link:hover::before,
        .navbar-nav .nav-link.active::before {
            width: 100%;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--primary-color);
        }

        /* Enhanced Footer with Luxury Design */
        footer {
            background: linear-gradient(135deg, #2C2416 0%, #6B4423 50%, #8B6B47 100%);
            color: white;
            padding: 5rem 0 2rem;
            margin-top: 6rem;
            position: relative;
            overflow: hidden;
        }

        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--secondary-color), transparent);
        }

        footer h5 {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 700;
            font-size: 1.4rem;
            margin-bottom: 1.8rem;
            color: var(--accent-gold);
            position: relative;
            padding-bottom: 0.8rem;
        }

        footer h5::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background: var(--secondary-color);
        }

        footer a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        footer a:hover {
            color: var(--accent-gold);
            transform: translateX(5px);
        }

        footer ul li {
            margin-bottom: 0.8rem;
        }

        footer .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 3rem;
            padding-top: 2rem;
        }

        /* Scroll to Top Button */
        .scroll-to-top {
            position: fixed;
            bottom: 30px;
            left: 30px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 1.2rem;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 999;
        }

        .scroll-to-top.show {
            opacity: 1;
            visibility: visible;
        }

        .scroll-to-top:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.3);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.5rem;
                letter-spacing: 2px;
            }

            .navbar-nav .nav-link {
                margin: 0.5rem 0;
                text-align: center;
                font-size: 0.9rem;
            }

            .scroll-to-top {
                left: 15px;
                bottom: 15px;
                width: 45px;
                height: 45px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">LUXUS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">Về chúng tôi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('projects.index') }}">Dự án</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Liên hệ</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <!-- Enhanced Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5>LUXUS INTERIOR DESIGN</h5>
                    <p style="line-height: 1.8; color: rgba(255, 255, 255, 0.8);">
                        Kiến tạo không gian sống đẳng cấp, nơi nghệ thuật và công năng hòa quyện,
                        phản ánh cá tính và phong cách riêng của bạn.
                    </p>
                    <div class="social-links mt-3">
                        <a href="https://facebook.com/luxus" target="_blank"
                            class="d-inline-flex align-items-center justify-content-center me-2"
                            style="width: 40px; height: 40px; background: rgba(255, 255, 255, 0.1); 
                                  border-radius: 50%; transition: all 0.3s;">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="d-inline-flex align-items-center justify-content-center me-2"
                            style="width: 40px; height: 40px; background: rgba(255, 255, 255, 0.1); 
                                  border-radius: 50%; transition: all 0.3s;">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="d-inline-flex align-items-center justify-content-center me-2"
                            style="width: 40px; height: 40px; background: rgba(255, 255, 255, 0.1); 
                                  border-radius: 50%; transition: all 0.3s;">
                            <i class="fab fa-weixin"></i>
                        </a>
                        <a href="#" class="d-inline-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px; background: rgba(255, 255, 255, 0.1); 
                                  border-radius: 50%; transition: all 0.3s;">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>Liên kết</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}"><i class="fas fa-chevron-right me-2" style="font-size: 0.7rem;"></i>Trang chủ</a></li>
                        <li><a href="{{ route('about') }}"><i class="fas fa-chevron-right me-2" style="font-size: 0.7rem;"></i>Về chúng tôi</a></li>
                        <li><a href="{{ route('projects.index') }}"><i class="fas fa-chevron-right me-2" style="font-size: 0.7rem;"></i>Dự án</a></li>
                        <li><a href="{{ route('contact') }}"><i class="fas fa-chevron-right me-2" style="font-size: 0.7rem;"></i>Liên hệ</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Dịch vụ</h5>
                    <ul class="list-unstyled">
                        <li><a href="#"><i class="fas fa-chevron-right me-2" style="font-size: 0.7rem;"></i>Thiết kế nội thất</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right me-2" style="font-size: 0.7rem;"></i>Thi công hoàn thiện</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right me-2" style="font-size: 0.7rem;"></i>Tư vấn phong thủy</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right me-2" style="font-size: 0.7rem;"></i>Quản lý dự án</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Liên hệ</h5>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="fas fa-map-marker-alt me-3" style="color: var(--secondary-color);"></i>
                            <span>Hà Nội, Việt Nam</span>
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-phone me-3" style="color: var(--secondary-color);"></i>
                            <a href="tel:+84123456789">+84 123 456 789</a>
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-envelope me-3" style="color: var(--secondary-color);"></i>
                            <a href="mailto:contact@luxus.com">contact@luxus.com</a>
                        </li>
                        <li>
                            <i class="fas fa-clock me-3" style="color: var(--secondary-color);"></i>
                            <span style="color: rgba(255, 255, 255, 0.8); font-size: 0.9rem;">Thứ 2 - Thứ 7: 8:00 - 18:00</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <p class="mb-0" style="color: rgba(255, 255, 255, 0.7);">
                            &copy; {{ date('Y') }} LUXUS Interior Design. All rights reserved.
                        </p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <p class="mb-0" style="color: rgba(255, 255, 255, 0.7);">
                            Designed with <i class="fas fa-heart" style="color: var(--secondary-color);"></i> by LUXUS Team
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <button class="scroll-to-top" id="scrollToTop">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Scroll to top button
        const scrollToTopBtn = document.getElementById('scrollToTop');

        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                scrollToTopBtn.classList.add('show');
            } else {
                scrollToTopBtn.classList.remove('show');
            }
        });

        scrollToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Active nav link highlighting
        const currentLocation = location.pathname;
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

        navLinks.forEach(link => {
            if (link.getAttribute('href') === currentLocation) {
                link.classList.add('active');
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href !== '#' && href !== '#!') {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        });

        // Footer social links hover effect
        document.querySelectorAll('footer .social-links a').forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.style.background = 'var(--secondary-color)';
                this.style.transform = 'translateY(-5px) rotate(360deg)';
            });
            link.addEventListener('mouseleave', function() {
                this.style.background = 'rgba(255, 255, 255, 0.1)';
                this.style.transform = 'translateY(0) rotate(0deg)';
            });
        });

        // Alert auto-dismiss
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>

    @stack('scripts')
</body>

</html>