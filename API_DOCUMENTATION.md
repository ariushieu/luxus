# Luxus Interior Design - Backend API

Hệ thống Quản lý Dịch vụ Thiết kế Nội thất - RESTful API built with Laravel

## 🏗️ Kiến trúc & Tech Stack

-   **Framework**: Laravel 12 (PHP 8.2+)
-   **Database**: MySQL
-   **Architecture**: Layered Architecture (Controller → Service → Repository)
-   **Design Pattern**: Repository Pattern with Dependency Injection
-   **Authentication**: Laravel Sanctum (for Admin)
-   **Queue**: Laravel Queue (for async tasks)
-   **Cloud Storage**: Cloudinary (for image management)

## 📋 Yêu cầu hệ thống

-   PHP >= 8.2
-   Composer
-   MySQL >= 8.0
-   Node.js & NPM (cho frontend integration)

## 🚀 Cài đặt

### 1. Clone repository và cài đặt dependencies

```bash
composer install
npm install
```

### 2. Cấu hình môi trường

```bash
# Copy file .env.example sang .env
copy .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Cấu hình Database trong file .env

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=luxus_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Cấu hình Cloudinary trong file .env

Đăng ký tài khoản tại https://cloudinary.com và lấy thông tin:

```env
CLOUDINARY_CLOUD_NAME=your_cloud_name
CLOUDINARY_API_KEY=your_api_key
CLOUDINARY_API_SECRET=your_api_secret
```

### 5. Cấu hình Email (optional)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@luxus.com
MAIL_FROM_NAME="Luxus Interior Design"
MAIL_ADMIN_EMAIL=admin@luxus.com
```

### 6. Chạy migration và seeder

```bash
# Tạo database tables
php artisan migrate

# Seed dữ liệu mẫu
php artisan db:seed
```

### 7. Cài đặt Laravel Sanctum (Authentication)

```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

### 8. Cài đặt Cloudinary SDK

```bash
composer require cloudinary-labs/cloudinary-laravel
```

### 9. Khởi động server

```bash
# Development server
php artisan serve

# Queue worker (trong terminal riêng)
php artisan queue:work
```

## 📁 Cấu trúc Project

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Api/V1/
│   │       ├── CategoryController.php          # Public API
│   │       ├── ProjectController.php
│   │       ├── BookingController.php
│   │       ├── QuoteController.php
│   │       ├── SettingController.php
│   │       └── Admin/                          # Admin API
│   │           ├── CategoryController.php
│   │           ├── ProjectController.php
│   │           ├── BookingController.php
│   │           ├── QuoteController.php
│   │           ├── SettingController.php
│   │           └── DashboardController.php
│   └── Requests/                               # Form Validation
│       ├── StoreCategoryRequest.php
│       ├── UpdateCategoryRequest.php
│       └── ...
├── Services/                                    # Business Logic Layer
│   ├── CategoryService.php
│   ├── ProjectService.php
│   ├── BookingService.php
│   ├── QuoteService.php
│   ├── SettingService.php
│   └── CloudinaryService.php
├── Repositories/                                # Data Access Layer
│   ├── CategoryRepository.php
│   ├── ProjectRepository.php
│   ├── BookingRepository.php
│   ├── QuoteRepository.php
│   ├── SettingRepository.php
│   └── ProjectImageRepository.php
├── Interfaces/                                  # Repository Interfaces
│   ├── CategoryRepositoryInterface.php
│   └── ...
├── Models/                                      # Eloquent Models
│   ├── Category.php
│   ├── Project.php
│   ├── ProjectImage.php
│   ├── Booking.php
│   ├── Quote.php
│   └── Setting.php
├── Jobs/                                        # Queue Jobs
│   ├── SendBookingNotificationJob.php
│   └── SendQuoteNotificationJob.php
└── Mail/                                        # Mailable Classes
    ├── BookingNotificationMail.php
    └── QuoteNotificationMail.php
```

## 🔌 API Endpoints

### Public API (Client Portal)

#### Categories

-   `GET /api/v1/categories` - Danh sách categories active
-   `GET /api/v1/categories/{slug}` - Chi tiết category

#### Projects

-   `GET /api/v1/projects` - Danh sách projects (có filter)
-   `GET /api/v1/projects/featured` - Projects nổi bật
-   `GET /api/v1/projects/{slug}` - Chi tiết project
-   `GET /api/v1/categories/{id}/projects` - Projects theo category

#### Settings

-   `GET /api/v1/settings?group=home&locale=vi` - Settings theo group
-   `GET /api/v1/settings/{key}?locale=vi` - Setting cụ thể

#### Lead Generation

-   `POST /api/v1/bookings` - Tạo yêu cầu đặt lịch
-   `POST /api/v1/quotes` - Tạo yêu cầu báo giá

### Admin API (Protected)

#### Authentication

-   `POST /api/v1/admin/login` - Admin login (Public)
-   `POST /api/v1/admin/logout` - Admin logout (Protected)
-   `GET /api/v1/admin/me` - Get current admin info (Protected)
-   `POST /api/v1/admin/change-password` - Change password (Protected)

**Login Request:**

```json
{
    "email": "admin@luxus.com",
    "password": "Admin@123"
}
```

**Login Response:**

```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "admin": {
            "id": 1,
            "name": "Admin",
            "email": "admin@luxus.com"
        },
        "token": "1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
    }
}
```

**Sử dụng token:** Thêm header vào mọi request Admin API

```
Authorization: Bearer {token}
```

#### Dashboard

-   `GET /api/v1/admin/dashboard/stats` - Thống kê tổng quan

#### Categories Management

-   `GET /api/v1/admin/categories` - Tất cả categories
-   `POST /api/v1/admin/categories` - Tạo category
-   `GET /api/v1/admin/categories/{id}` - Chi tiết
-   `PUT /api/v1/admin/categories/{id}` - Cập nhật
-   `DELETE /api/v1/admin/categories/{id}` - Xóa

#### Projects Management

-   `GET /api/v1/admin/projects` - Tất cả projects
-   `POST /api/v1/admin/projects` - Tạo project
-   `GET /api/v1/admin/projects/{id}` - Chi tiết
-   `PUT /api/v1/admin/projects/{id}` - Cập nhật
-   `DELETE /api/v1/admin/projects/{id}` - Xóa
-   `POST /api/v1/admin/projects/{id}/images` - Upload ảnh
-   `DELETE /api/v1/admin/project-images/{id}` - Xóa ảnh

#### Bookings Management

-   `GET /api/v1/admin/bookings` - Tất cả bookings
-   `GET /api/v1/admin/bookings-pending` - Bookings chờ xử lý
-   `GET /api/v1/admin/bookings/{id}` - Chi tiết
-   `PUT /api/v1/admin/bookings/{id}` - Cập nhật
-   `PATCH /api/v1/admin/bookings/{id}/status` - Cập nhật status
-   `DELETE /api/v1/admin/bookings/{id}` - Xóa

#### Quotes Management

-   `GET /api/v1/admin/quotes` - Tất cả quotes
-   `GET /api/v1/admin/quotes-pending` - Quotes chờ xử lý
-   `GET /api/v1/admin/quotes/{id}` - Chi tiết
-   `PUT /api/v1/admin/quotes/{id}` - Cập nhật
-   `PATCH /api/v1/admin/quotes/{id}/status` - Cập nhật status
-   `DELETE /api/v1/admin/quotes/{id}` - Xóa

#### Settings Management

-   `GET /api/v1/admin/settings` - Tất cả settings
-   `POST /api/v1/admin/settings` - Tạo setting
-   `PUT /api/v1/admin/settings/{key}` - Cập nhật
-   `DELETE /api/v1/admin/settings/{key}` - Xóa

## 🗄️ Database Schema

### Tables

1. **admins** - Tài khoản quản trị viên
2. **settings** - CMS settings đa ngôn ngữ (vi/en)
3. **categories** - Danh mục dự án
4. **projects** - Chi tiết dự án
5. **project_images** - Ảnh dự án (lưu Cloudinary URL & Public ID)
6. **bookings** - Yêu cầu đặt lịch tư vấn
7. **quotes** - Yêu cầu báo giá

### Default Admin Accounts

Sau khi chạy seeder, bạn có thể đăng nhập với:

**Account 1:**

-   Email: `admin@luxus.com`
-   Password: `Admin@123`

**Account 2:**

-   Email: `demo@luxus.com`
-   Password: `Demo@123`

## 🔐 Authentication

Hệ thống sử dụng **Laravel Sanctum** với token-based authentication cho Admin:

1. Admin login qua `/api/v1/admin/login` và nhận token
2. Sử dụng token trong header `Authorization: Bearer {token}` cho các request khác
3. Token có hiệu lực vô thời hạn cho đến khi logout
4. Khi login lại, token cũ sẽ bị xóa và tạo token mới

## 📧 Email Notifications

Hệ thống tự động gửi email thông báo qua Queue:

-   **Booking Confirmation**: Khi client tạo booking
-   **Quote Confirmation**: Khi client request quote
-   **Status Updates**: Khi admin cập nhật status

## 🎯 Các tính năng chính

✅ Repository Pattern với Dependency Injection  
✅ Layered Architecture (Controller → Service → Repository)  
✅ Form Request Validation  
✅ Queue Jobs cho async tasks  
✅ Cloudinary integration cho image management  
✅ Multi-language support (vi/en)  
✅ RESTful API với versioning  
✅ Comprehensive error handling

## 📝 Testing

```bash
# Run tests
php artisan test
```

## 🛠️ Development Commands

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# View routes
php artisan route:list

# Database
php artisan migrate:fresh --seed
php artisan migrate:rollback

# Queue
php artisan queue:work
php artisan queue:failed
php artisan queue:retry all
```

## 📄 License

MIT License
