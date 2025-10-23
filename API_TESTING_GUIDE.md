# LUXUS INTERIOR DESIGN - API TESTING GUIDE

## 🔑 Prerequisites

1. Server running: `php artisan serve`
2. Admin token from login (replace `{token}` below)

## 📝 Test Order

### 1. AUTHENTICATION ✅

#### Login

```bash
POST http://127.0.0.1:8000/api/v1/admin/login
Content-Type: application/json

{
  "email": "admin@luxus.com",
  "password": "Admin@123"
}

# Expected: 200 OK with token
# Copy the token for next requests
```

#### Get Admin Info

```bash
GET http://127.0.0.1:8000/api/v1/admin/me
Authorization: Bearer {token}
```

---

### 2. CATEGORIES (Public)

#### Get All Categories

```bash
GET http://127.0.0.1:8000/api/v1/categories

# Expected: List of 3 categories (Housing, Commercial, Office)
```

#### Get Category by Slug

```bash
GET http://127.0.0.1:8000/api/v1/categories/housing
GET http://127.0.0.1:8000/api/v1/categories/commercial
GET http://127.0.0.1:8000/api/v1/categories/office
```

---

### 3. PROJECTS (Public)

#### Get All Projects

```bash
GET http://127.0.0.1:8000/api/v1/projects

# Expected: List of 3 projects
```

#### Get Projects by Category

```bash
GET http://127.0.0.1:8000/api/v1/projects?category_id=1
```

#### Get Featured Projects

```bash
GET http://127.0.0.1:8000/api/v1/projects/featured

# Expected: 2 featured projects
```

#### Get Project by Slug

```bash
GET http://127.0.0.1:8000/api/v1/projects/vinhomes-central-park-luxury-apartment

# Expected: Full project details with images
```

---

### 4. SETTINGS (Public)

#### Get All Settings

```bash
GET http://127.0.0.1:8000/api/v1/settings

# Expected: 8 settings
```

#### Get Settings by Group

```bash
GET http://127.0.0.1:8000/api/v1/settings?group=home
GET http://127.0.0.1:8000/api/v1/settings?group=contact
```

#### Get Specific Setting

```bash
GET http://127.0.0.1:8000/api/v1/settings/home_hero_title?locale=vi
```

---

### 5. LEAD GENERATION (Public)

#### Create Booking Request

```bash
POST http://127.0.0.1:8000/api/v1/bookings
Content-Type: application/json

{
  "client_name": "Nguyen Van Test",
  "client_email": "test@example.com",
  "client_phone": "0123456789",
  "booking_time": "2025-11-01 10:00:00",
  "message": "Tôi muốn tư vấn thiết kế phòng khách"
}

# Expected: 200 with booking data
```

#### Create Quote Request

```bash
POST http://127.0.0.1:8000/api/v1/quotes
Content-Type: application/json

{
  "client_name": "Tran Thi Test",
  "client_email": "quote@example.com",
  "client_phone": "0987654321",
  "project_type": "housing",
  "budget": 500000000,
  "area": 150,
  "request_details": "Cần thiết kế căn hộ 3 phòng ngủ"
}

# Expected: 200 with quote data
```

---

### 6. ADMIN - DASHBOARD

#### Get Dashboard Stats

```bash
GET http://127.0.0.1:8000/api/v1/admin/dashboard/stats
Authorization: Bearer {token}

# Expected: Counts and recent items
```

---

### 7. ADMIN - CATEGORIES CRUD

#### Get All (Admin)

```bash
GET http://127.0.0.1:8000/api/v1/admin/categories
Authorization: Bearer {token}
```

#### Create Category

```bash
POST http://127.0.0.1:8000/api/v1/admin/categories
Authorization: Bearer {token}
Content-Type: application/json

{
  "name_vi": "Khách sạn",
  "name_en": "Hotel",
  "description_vi": "Thiết kế khách sạn và resort",
  "description_en": "Hotel and resort design",
  "display_order": 4,
  "is_active": true
}

# Expected: 201 Created
```

#### Update Category

```bash
PUT http://127.0.0.1:8000/api/v1/admin/categories/4
Authorization: Bearer {token}
Content-Type: application/json

{
  "name_vi": "Khách sạn & Resort",
  "is_active": true
}
```

#### Delete Category

```bash
DELETE http://127.0.0.1:8000/api/v1/admin/categories/4
Authorization: Bearer {token}
```

---

### 8. ADMIN - PROJECTS CRUD

#### Create Project

```bash
POST http://127.0.0.1:8000/api/v1/admin/projects
Authorization: Bearer {token}
Content-Type: application/json

{
  "category_id": 1,
  "title_vi": "Villa Phú Mỹ Hưng",
  "title_en": "Phu My Hung Villa",
  "description_vi": "Biệt thự hiện đại",
  "description_en": "Modern villa",
  "content_vi": "Nội dung chi tiết...",
  "content_en": "Detailed content...",
  "client_name": "Mr. Tran",
  "location": "District 7, HCMC",
  "area": 300,
  "year": 2025,
  "status": "ongoing",
  "is_featured": false,
  "is_active": true
}

# Expected: 201 with project data
```

#### Update Project

```bash
PUT http://127.0.0.1:8000/api/v1/admin/projects/4
Authorization: Bearer {token}
Content-Type: application/json

{
  "status": "completed",
  "is_featured": true
}
```

---

### 9. ADMIN - PROJECT IMAGES ⭐

#### Upload Image to Project 1 (Housing)

```bash
POST http://127.0.0.1:8000/api/v1/admin/projects/1/images
Authorization: Bearer {token}
Content-Type: multipart/form-data

image: [Select PNG/JPG file]
alt_text_vi: "Phòng khách căn hộ Vinhomes"
alt_text_en: "Vinhomes apartment living room"
is_primary: true
display_order: 0

# Expected: Image uploaded to Luxus/housing/ on Cloudinary
```

#### Upload Image to Project 2 (Commercial)

```bash
POST http://127.0.0.1:8000/api/v1/admin/projects/2/images
Authorization: Bearer {token}

image: [file]
alt_text_vi: "Không gian showroom"
alt_text_en: "Showroom space"
is_primary: true
display_order: 0

# Expected: Image uploaded to Luxus/commercial/
```

#### Upload Image to Project 3 (Office)

```bash
POST http://127.0.0.1:8000/api/v1/admin/projects/3/images
Authorization: Bearer {token}

image: [file]
alt_text_vi: "Văn phòng làm việc"
alt_text_en: "Office workspace"
is_primary: true
display_order: 0

# Expected: Image uploaded to Luxus/office/
```

#### Delete Project Image

```bash
DELETE http://127.0.0.1:8000/api/v1/admin/project-images/{imageId}
Authorization: Bearer {token}

# Expected: 200 and image deleted from Cloudinary
```

---

### 10. ADMIN - BOOKINGS MANAGEMENT

#### Get All Bookings

```bash
GET http://127.0.0.1:8000/api/v1/admin/bookings
Authorization: Bearer {token}
```

#### Get Pending Bookings

```bash
GET http://127.0.0.1:8000/api/v1/admin/bookings-pending
Authorization: Bearer {token}
```

#### Update Booking Status

```bash
PATCH http://127.0.0.1:8000/api/v1/admin/bookings/1/status
Authorization: Bearer {token}
Content-Type: application/json

{
  "status": "confirmed",
  "admin_notes": "Đã liên hệ khách hàng và xác nhận lịch hẹn"
}

# Available statuses: pending, confirmed, completed, cancelled
```

---

### 11. ADMIN - QUOTES MANAGEMENT

#### Get All Quotes

```bash
GET http://127.0.0.1:8000/api/v1/admin/quotes
Authorization: Bearer {token}
```

#### Get Pending Quotes

```bash
GET http://127.0.0.1:8000/api/v1/admin/quotes-pending
Authorization: Bearer {token}
```

#### Update Quote Status

```bash
PATCH http://127.0.0.1:8000/api/v1/admin/quotes/1/status
Authorization: Bearer {token}
Content-Type: application/json

{
  "status": "quoted",
  "admin_notes": "Đã gửi báo giá chi tiết qua email",
  "quoted_amount": 450000000
}

# Available statuses: pending, reviewing, quoted, accepted, rejected
```

---

### 12. ADMIN - SETTINGS MANAGEMENT

#### Create/Update Setting

```bash
POST http://127.0.0.1:8000/api/v1/admin/settings
Authorization: Bearer {token}
Content-Type: application/json

{
  "key": "home_cta_button",
  "value_vi": "Liên hệ ngay",
  "value_en": "Contact Now",
  "type": "text",
  "group": "home"
}
```

#### Update Existing Setting

```bash
PUT http://127.0.0.1:8000/api/v1/admin/settings/home_hero_title
Authorization: Bearer {token}
Content-Type: application/json

{
  "value_vi": "Thiết kế Nội thất Cao cấp 2025",
  "value_en": "Premium Interior Design 2025"
}
```

---

## ✅ Test Checklist

### Public APIs (No Auth)

-   [ ] GET Categories
-   [ ] GET Projects
-   [ ] GET Project by slug (with images)
-   [ ] GET Settings
-   [ ] POST Booking
-   [ ] POST Quote

### Admin APIs (Auth Required)

-   [ ] Login & Get Token
-   [ ] Dashboard Stats
-   [ ] Categories CRUD
-   [ ] Projects CRUD
-   [ ] Upload Images (Test all 3 categories)
-   [ ] Delete Image
-   [ ] Bookings Management
-   [ ] Quotes Management
-   [ ] Settings Management

---

## 🎯 Expected Results

### Cloudinary Folder Structure

```
Luxus/
├── housing/
│   └── [images from project 1]
├── commercial/
│   └── [images from project 2]
└── office/
    └── [images from project 3]
```

### Database Tables

-   ✅ admins (2 records)
-   ✅ categories (3 records)
-   ✅ projects (3 records)
-   ✅ project_images (uploaded via API)
-   ✅ bookings (created via API)
-   ✅ quotes (created via API)
-   ✅ settings (8 records)

---

## 🐛 Common Issues

1. **401 Unauthenticated**: Token expired or missing
2. **404 Not Found**: Wrong URL or resource doesn't exist
3. **422 Validation Error**: Check request body format
4. **500 Server Error**: Check logs in `storage/logs/laravel.log`

---

## 📞 Quick Test via CURL (PowerShell)

### Test Public Project

```powershell
Invoke-WebRequest -Uri "http://127.0.0.1:8000/api/v1/projects" -Method GET -Headers @{"Accept"="application/json"} | Select-Object -ExpandProperty Content
```

### Test Login

```powershell
$body = @{
    email = "admin@luxus.com"
    password = "Admin@123"
} | ConvertTo-Json

$response = Invoke-WebRequest -Uri "http://127.0.0.1:8000/api/v1/admin/login" -Method POST -Body $body -ContentType "application/json"
$response.Content
```

---

**Ready to test! Start with login, then test each section systematically.** 🚀
