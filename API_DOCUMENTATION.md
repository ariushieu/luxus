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

## �️ Web Admin Panel

Ngoài RESTful API, hệ thống còn có **Web-based Admin Panel** đầy đủ với giao diện responsive.

### Truy cập Admin Panel

URL: `http://your-domain.com/admin/login`

**Login Credentials:**

-   Email: `admin@luxus.com`
-   Password: `Admin@123`

### Admin Panel Features

**1. Dashboard** (`/admin/dashboard`)

-   Thống kê tổng quan: Total Projects, Active Projects, Pending Bookings, Pending Quotes
-   Bảng Recent Bookings (5 latest)
-   Bảng Recent Quotes (5 latest)
-   Bảng Recent Projects (5 latest)

**2. Categories Management** (`/admin/categories`)

-   Listing: Table với project count, status badges
-   Create: Form bilingual (VI/EN), auto-generate slug
-   Edit: Pre-filled form
-   Delete: Prevent deletion if category has projects
-   Business Rule: Slug must be unique

**3. Projects Management** (`/admin/projects`)

-   Listing: Table with thumbnail, name, category, image count, status
-   Create:
    -   Multi-file image upload with preview
    -   First image automatically set as primary
    -   Images upload to `Cloudinary/{category_slug}/` folder
    -   Bilingual content (VI/EN)
-   Edit:
    -   Update project info
    -   View existing images gallery
    -   Upload additional images via modal
    -   Delete individual images (with validation)
-   Business Rules:
    -   Cannot delete the only image
    -   Cannot delete primary image without setting another as primary
    -   Deleting project cascade deletes all images from Cloudinary

**4. Bookings Management** (`/admin/bookings`)

-   Listing: Table with filter tabs (All/Pending/Confirmed/Completed/Cancelled)
-   Status count badges on tabs
-   View Details: Full booking info (name, email, phone, date, time, message)
-   Update Status: Dropdown with admin notes textarea
-   Status Flow: `pending → confirmed → completed | cancelled`

**5. Quotes Management** (`/admin/quotes`)

-   Listing: Table with filter tabs (All/Pending/Reviewing/Quoted/Accepted/Rejected)
-   Display quoted amount if available
-   View Details: Full quote info (name, contact, project type, budget, message)
-   Update Status:
    -   Dropdown selection
    -   Conditional `quoted_amount` field (required when status = "quoted")
    -   Admin notes textarea
-   Status Flow: `pending → reviewing → quoted → accepted | rejected`
-   Validation: Must enter amount when status = "quoted"

**6. Settings Management** (`/admin/settings`)

-   Grouped tabs: Home Settings / Contact Settings / General Settings
-   Bilingual inputs (VI/EN) for each setting
-   Bulk update all settings at once
-   Special validation for email and phone fields

### Admin Routes

```
GET     /admin/login                        → Login form
POST    /admin/login                        → Authenticate
POST    /admin/logout                       → Logout
GET     /admin/dashboard                    → Dashboard

// Categories CRUD
GET     /admin/categories                   → List all
GET     /admin/categories/create            → Create form
POST    /admin/categories                   → Store
GET     /admin/categories/{id}/edit         → Edit form
PUT     /admin/categories/{id}              → Update
DELETE  /admin/categories/{id}              → Delete

// Projects CRUD + Images
GET     /admin/projects                     → List all
GET     /admin/projects/create              → Create form
POST    /admin/projects                     → Store (with images)
GET     /admin/projects/{id}/edit           → Edit form
PUT     /admin/projects/{id}                → Update
DELETE  /admin/projects/{id}                → Delete (cascade images)
POST    /admin/projects/{id}/images         → Upload additional image
DELETE  /admin/project-images/{id}          → Delete single image

// Bookings Management
GET     /admin/bookings?status=pending      → List with filter
GET     /admin/bookings/{id}                → View details
PATCH   /admin/bookings/{id}/status         → Update status

// Quotes Management
GET     /admin/quotes?status=pending        → List with filter
GET     /admin/quotes/{id}                  → View details
PATCH   /admin/quotes/{id}/status           → Update status + amount

// Settings Management
GET     /admin/settings                     → List grouped
POST    /admin/settings                     → Bulk update
```

### Admin Panel UI/UX

**Design:**

-   Color Scheme: Brown gradient (#2C1810 → #8B4513)
-   Typography: Playfair Display (headings) + Poppins (body)
-   Components: Bootstrap 5 + Font Awesome 6
-   Layout: Fixed sidebar (280px) + top navbar

**Responsive:**

-   Desktop: Fixed sidebar navigation
-   Mobile (< 992px): Collapsible sidebar with floating toggle button
-   Touch-friendly: Sidebar closes on outside click

**User Feedback:**

-   Success/error alerts with auto-dismiss
-   Confirmation dialogs for delete actions
-   Inline validation errors
-   Color-coded status badges

**JavaScript Features:**

-   Image preview before upload
-   Auto-generate slug from Vietnamese name (Categories)
-   Conditional field display (Quotes quoted_amount)
-   Responsive sidebar toggle

### Authentication

**Guards:**

-   `web` - Regular users (Breeze default)
-   `admin` - Admin panel (custom, session-based)
-   `sanctum` - API authentication (token-based)

**Middleware:**

-   `guest:admin` - Admin login page (unauthenticated only)
-   `auth:admin` - All admin routes (authenticated only)

**Redirect Logic:**

-   Unauthenticated admin accessing `/admin/*` → redirect to `/admin/login`
-   Unauthenticated user accessing other routes → redirect to `/` (home)

### Cloudinary Integration

**Image Upload Flow:**

1. Admin creates/edits project
2. Selects category (e.g., "housing")
3. Uploads images
4. System uploads to `Luxus/{category_slug}/` folder on Cloudinary
5. Stores `cloudinary_public_id` and `cloudinary_url` in database

**Image Management:**

-   Multiple images per project
-   First uploaded image = primary image
-   Can upload more images after project creation
-   Delete individual images (with business rule validation)
-   Cascade delete all images when deleting project

**Validation:**

-   Max 5MB per image
-   Allowed formats: jpg, jpeg, png, webp

## �📄 License

MIT License
