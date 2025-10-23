# Luxus Interior Design API - Testing Documentation

## Base URL

```
http://127.0.0.1:8000/api/v1
```

---

## 🔐 Authentication

### Login (Admin)

**Endpoint:** `POST /admin/login`

**Request:**

```json
{
    "email": "admin@luxus.com",
    "password": "Admin@123"
}
```

**Response (Success):**

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
        "token": "1|sP2lUFBxJgJMrzJxppkQUrQdl5vh36ohdD33Dq3S6a619e78"
    }
}
```

**Use Token:** Add to header for all Admin API requests

```
Authorization: Bearer 1|sP2lUFBxJgJMrzJxppkQUrQdl5vh36ohdD33Dq3S6a619e78
```

---

### Get Admin Info

**Endpoint:** `GET /admin/me`

**Headers:**

```
Authorization: Bearer {token}
Accept: application/json
```

**Response:**

```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Admin",
        "email": "admin@luxus.com",
        "created_at": "2024-10-23T12:00:00.000000Z",
        "updated_at": "2024-10-23T12:00:00.000000Z"
    }
}
```

---

### Logout

**Endpoint:** `POST /admin/logout`

**Headers:**

```
Authorization: Bearer {token}
```

**Response:**

```json
{
    "success": true,
    "message": "Logged out successfully"
}
```

---

## 📁 Categories (Public)

### Get All Active Categories

**Endpoint:** `GET /categories`

**Response:**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name_vi": "Nhà Ở",
            "name_en": "Housing",
            "slug": "housing",
            "description_vi": "Thiết kế nội thất cho nhà ở, căn hộ, biệt thự",
            "description_en": "Interior design for houses, apartments, villas",
            "display_order": 1,
            "is_active": true,
            "created_at": "2024-10-23T12:00:00.000000Z",
            "updated_at": "2024-10-23T12:00:00.000000Z"
        },
        {
            "id": 2,
            "name_vi": "Thương Mại",
            "name_en": "Commercial",
            "slug": "commercial",
            "description_vi": "Thiết kế nội thất cho cửa hàng, showroom, nhà hàng",
            "description_en": "Interior design for shops, showrooms, restaurants",
            "display_order": 2,
            "is_active": true,
            "created_at": "2024-10-23T12:00:00.000000Z",
            "updated_at": "2024-10-23T12:00:00.000000Z"
        },
        {
            "id": 3,
            "name_vi": "Văn Phòng",
            "name_en": "Office",
            "slug": "office",
            "description_vi": "Thiết kế nội thất cho văn phòng làm việc",
            "description_en": "Interior design for office spaces",
            "display_order": 3,
            "is_active": true,
            "created_at": "2024-10-23T12:00:00.000000Z",
            "updated_at": "2024-10-23T12:00:00.000000Z"
        }
    ]
}
```

---

### Get Category by Slug

**Endpoint:** `GET /categories/{slug}`

**Example:** `GET /categories/housing`

**Response:**

```json
{
    "success": true,
    "data": {
        "id": 1,
        "name_vi": "Nhà Ở",
        "name_en": "Housing",
        "slug": "housing",
        "description_vi": "Thiết kế nội thất cho nhà ở, căn hộ, biệt thự",
        "description_en": "Interior design for houses, apartments, villas",
        "display_order": 1,
        "is_active": true,
        "created_at": "2024-10-23T12:00:00.000000Z",
        "updated_at": "2024-10-23T12:00:00.000000Z"
    }
}
```

---

## 🏢 Projects (Public)

### Get All Active Projects

**Endpoint:** `GET /projects`

**Query Parameters:**

-   `category_id` (optional) - Filter by category
-   `status` (optional) - Filter by status (completed, ongoing, planned)

**Example:** `GET /projects?category_id=1&status=completed`

**Response:**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "category_id": 1,
            "title_vi": "Căn hộ cao cấp Vinhomes",
            "title_en": "Vinhomes Luxury Apartment",
            "slug": "vinhomes-luxury-apartment",
            "description_vi": "Thiết kế hiện đại, sang trọng",
            "description_en": "Modern and luxury design",
            "client_name": "Mr. Nguyen",
            "location": "Ho Chi Minh City",
            "area": "120.50",
            "year": 2024,
            "status": "completed",
            "is_featured": true,
            "is_active": true,
            "display_order": 0,
            "created_at": "2024-10-23T12:00:00.000000Z",
            "updated_at": "2024-10-23T12:00:00.000000Z",
            "category": {
                "id": 1,
                "name_vi": "Nhà Ở",
                "name_en": "Housing",
                "slug": "housing"
            },
            "primary_image": {
                "id": 1,
                "cloudinary_url": "https://res.cloudinary.com/dg2iqmelk/image/upload/v1234567890/Luxus/projects/sample.jpg",
                "alt_text_vi": "Phòng khách căn hộ Vinhomes",
                "alt_text_en": "Vinhomes apartment living room"
            }
        }
    ]
}
```

---

### Get Featured Projects

**Endpoint:** `GET /projects/featured`

**Response:**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "title_vi": "Căn hộ cao cấp Vinhomes",
            "title_en": "Vinhomes Luxury Apartment",
            "slug": "vinhomes-luxury-apartment",
            "description_vi": "Thiết kế hiện đại, sang trọng",
            "description_en": "Modern and luxury design",
            "is_featured": true,
            "primary_image": {
                "cloudinary_url": "https://res.cloudinary.com/dg2iqmelk/image/upload/v1234567890/Luxus/projects/sample.jpg"
            }
        }
    ]
}
```

---

### Get Project by Slug

**Endpoint:** `GET /projects/{slug}`

**Example:** `GET /projects/vinhomes-luxury-apartment`

**Response:**

```json
{
    "success": true,
    "data": {
        "id": 1,
        "category_id": 1,
        "title_vi": "Căn hộ cao cấp Vinhomes",
        "title_en": "Vinhomes Luxury Apartment",
        "slug": "vinhomes-luxury-apartment",
        "description_vi": "Thiết kế hiện đại, sang trọng",
        "description_en": "Modern and luxury design",
        "content_vi": "Nội dung chi tiết dự án...",
        "content_en": "Detailed project content...",
        "client_name": "Mr. Nguyen",
        "location": "Ho Chi Minh City",
        "area": "120.50",
        "year": 2024,
        "status": "completed",
        "category": {
            "id": 1,
            "name_vi": "Nhà Ở",
            "name_en": "Housing"
        },
        "images": [
            {
                "id": 1,
                "cloudinary_url": "https://res.cloudinary.com/dg2iqmelk/image/upload/v1234567890/Luxus/projects/sample1.jpg",
                "cloudinary_public_id": "Luxus/projects/sample1",
                "alt_text_vi": "Phòng khách",
                "alt_text_en": "Living room",
                "is_primary": true,
                "display_order": 0
            },
            {
                "id": 2,
                "cloudinary_url": "https://res.cloudinary.com/dg2iqmelk/image/upload/v1234567890/Luxus/projects/sample2.jpg",
                "cloudinary_public_id": "Luxus/projects/sample2",
                "alt_text_vi": "Phòng ngủ",
                "alt_text_en": "Bedroom",
                "is_primary": false,
                "display_order": 1
            }
        ]
    }
}
```

---

## ⚙️ Settings (Public)

### Get Settings by Group

**Endpoint:** `GET /settings`

**Query Parameters:**

-   `group` (optional) - Filter by group (general, home, about, contact)
-   `locale` (optional) - Language (vi, en) - Default: vi

**Example:** `GET /settings?group=home&locale=vi`

**Response:**

```json
{
    "success": true,
    "data": {
        "home_hero_title": "Thiết kế Nội thất Sang trọng",
        "home_hero_subtitle": "Tạo không gian sống đẳng cấp cho bạn"
    }
}
```

---

### Get Specific Setting

**Endpoint:** `GET /settings/{key}`

**Query Parameters:**

-   `locale` (optional) - Language (vi, en)

**Example:** `GET /settings/home_hero_title?locale=en`

**Response:**

```json
{
    "success": true,
    "data": {
        "key": "home_hero_title",
        "value": "Luxury Interior Design"
    }
}
```

---

## 📅 Bookings (Lead Generation)

### Create Booking Request

**Endpoint:** `POST /bookings`

**Request:**

```json
{
    "client_name": "Nguyen Van A",
    "client_email": "test@example.com",
    "client_phone": "0123456789",
    "booking_time": "2025-10-25 10:00:00",
    "message": "Tôi muốn tư vấn thiết kế phòng khách"
}
```

**Response (Success):**

```json
{
    "success": true,
    "message": "Booking request submitted successfully. You will receive a confirmation email shortly.",
    "data": {
        "id": 1,
        "client_name": "Nguyen Van A",
        "client_email": "test@example.com",
        "client_phone": "0123456789",
        "booking_time": "2025-10-25 10:00:00",
        "message": "Tôi muốn tư vấn thiết kế phòng khách",
        "status": "pending",
        "created_at": "2024-10-23T12:00:00.000000Z",
        "updated_at": "2024-10-23T12:00:00.000000Z"
    }
}
```

**Response (Validation Error):**

```json
{
    "message": "The booking time field must be a date after now.",
    "errors": {
        "booking_time": ["The booking time field must be a date after now."]
    }
}
```

---

## 💰 Quotes (Lead Generation)

### Create Quote Request

**Endpoint:** `POST /quotes`

**Request:**

```json
{
    "client_name": "Tran Thi B",
    "client_email": "client@example.com",
    "client_phone": "0987654321",
    "project_type": "housing",
    "budget": 500000000,
    "area": 150.5,
    "request_details": "Cần thiết kế căn hộ 3 phòng ngủ với phong cách hiện đại"
}
```

**Response (Success):**

```json
{
    "success": true,
    "message": "Quote request submitted successfully. Our team will contact you shortly.",
    "data": {
        "id": 1,
        "client_name": "Tran Thi B",
        "client_email": "client@example.com",
        "client_phone": "0987654321",
        "project_type": "housing",
        "budget": "500000000.00",
        "area": "150.50",
        "request_details": "Cần thiết kế căn hộ 3 phòng ngủ với phong cách hiện đại",
        "status": "pending",
        "created_at": "2024-10-23T12:00:00.000000Z",
        "updated_at": "2024-10-23T12:00:00.000000Z"
    }
}
```

---

## 🔧 Admin - Categories

### Get All Categories (Admin)

**Endpoint:** `GET /admin/categories`

**Headers:**

```
Authorization: Bearer {token}
Accept: application/json
```

**Response:**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name_vi": "Nhà Ở",
            "name_en": "Housing",
            "slug": "housing",
            "description_vi": "Thiết kế nội thất cho nhà ở, căn hộ, biệt thự",
            "description_en": "Interior design for houses, apartments, villas",
            "display_order": 1,
            "is_active": true,
            "created_at": "2024-10-23T12:00:00.000000Z",
            "updated_at": "2024-10-23T12:00:00.000000Z"
        }
    ]
}
```

---

### Create Category

**Endpoint:** `POST /admin/categories`

**Headers:**

```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request:**

```json
{
    "name_vi": "Khách sạn",
    "name_en": "Hotel",
    "description_vi": "Thiết kế nội thất khách sạn",
    "description_en": "Hotel interior design",
    "display_order": 4,
    "is_active": true
}
```

**Response:**

```json
{
    "success": true,
    "data": {
        "id": 4,
        "name_vi": "Khách sạn",
        "name_en": "Hotel",
        "slug": "hotel",
        "description_vi": "Thiết kế nội thất khách sạn",
        "description_en": "Hotel interior design",
        "display_order": 4,
        "is_active": true,
        "created_at": "2024-10-23T13:00:00.000000Z",
        "updated_at": "2024-10-23T13:00:00.000000Z"
    }
}
```

---

### Update Category

**Endpoint:** `PUT /admin/categories/{id}`

**Headers:**

```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request:**

```json
{
    "name_vi": "Khách sạn & Resort",
    "name_en": "Hotel & Resort",
    "is_active": true
}
```

**Response:**

```json
{
    "success": true,
    "data": {
        "id": 4,
        "name_vi": "Khách sạn & Resort",
        "name_en": "Hotel & Resort",
        "slug": "hotel-resort",
        "updated_at": "2024-10-23T14:00:00.000000Z"
    }
}
```

---

### Delete Category

**Endpoint:** `DELETE /admin/categories/{id}`

**Headers:**

```
Authorization: Bearer {token}
```

**Response:**

```json
{
    "success": true,
    "message": "Category deleted successfully"
}
```

---

## 🏗️ Admin - Projects

### Create Project

**Endpoint:** `POST /admin/projects`

**Headers:**

```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request:**

```json
{
    "category_id": 1,
    "title_vi": "Căn hộ cao cấp Vinhomes",
    "title_en": "Vinhomes Luxury Apartment",
    "description_vi": "Thiết kế hiện đại, sang trọng",
    "description_en": "Modern and luxury design",
    "content_vi": "Nội dung chi tiết dự án...",
    "content_en": "Detailed project content...",
    "client_name": "Mr. Nguyen",
    "location": "Ho Chi Minh City",
    "area": 120.5,
    "year": 2024,
    "status": "completed",
    "is_featured": true,
    "is_active": true,
    "display_order": 1
}
```

**Response:**

```json
{
    "success": true,
    "data": {
        "id": 1,
        "category_id": 1,
        "title_vi": "Căn hộ cao cấp Vinhomes",
        "title_en": "Vinhomes Luxury Apartment",
        "slug": "vinhomes-luxury-apartment",
        "status": "completed",
        "is_featured": true,
        "is_active": true,
        "created_at": "2024-10-23T12:00:00.000000Z"
    }
}
```

---

### Upload Project Image

**Endpoint:** `POST /admin/projects/{projectId}/images`

**Headers:**

```
Authorization: Bearer {token}
Content-Type: multipart/form-data
```

**Request (Form Data):**

```
image: [Select actual image file from your computer]
alt_text_vi: "Phòng khách sang trọng"
alt_text_en: "Luxury living room"
is_primary: true
display_order: 0
```

**Response (Example - Real URL will be generated by Cloudinary):**

```json
{
    "success": true,
    "data": {
        "id": 1,
        "project_id": 1,
        "cloudinary_public_id": "Luxus/projects/xyz789_unique_id",
        "cloudinary_url": "https://res.cloudinary.com/dg2iqmelk/image/upload/v1729684800/Luxus/projects/xyz789_unique_id.jpg",
        "alt_text_vi": "Phòng khách sang trọng",
        "alt_text_en": "Luxury living room",
        "is_primary": true,
        "display_order": 0,
        "created_at": "2024-10-23T13:00:00.000000Z"
    }
}
```

**Note:** The actual `cloudinary_public_id` and `cloudinary_url` will be dynamically generated by Cloudinary when you upload a real image file. The URL will be accessible and the image will be stored in your Cloudinary account under folder `Luxus/projects/`.

---

### Delete Project Image

**Endpoint:** `DELETE /admin/project-images/{imageId}`

**Headers:**

```
Authorization: Bearer {token}
```

**Response:**

```json
{
    "success": true,
    "message": "Image deleted successfully"
}
```

---

## 📋 Admin - Bookings

### Get All Bookings

**Endpoint:** `GET /admin/bookings`

**Headers:**

```
Authorization: Bearer {token}
```

**Query Parameters:**

-   `status` (optional) - Filter by status
-   `from_date` (optional) - Filter from date
-   `to_date` (optional) - Filter to date

**Response:**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "client_name": "Nguyen Van A",
            "client_email": "test@example.com",
            "client_phone": "0123456789",
            "booking_time": "2025-10-25 10:00:00",
            "message": "Tôi muốn tư vấn thiết kế phòng khách",
            "status": "pending",
            "admin_notes": null,
            "created_at": "2024-10-23T12:00:00.000000Z",
            "updated_at": "2024-10-23T12:00:00.000000Z"
        }
    ]
}
```

---

### Get Pending Bookings

**Endpoint:** `GET /admin/bookings-pending`

**Headers:**

```
Authorization: Bearer {token}
```

**Response:**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "client_name": "Nguyen Van A",
            "status": "pending",
            "booking_time": "2025-10-25 10:00:00"
        }
    ]
}
```

---

### Update Booking Status

**Endpoint:** `PATCH /admin/bookings/{id}/status`

**Headers:**

```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request:**

```json
{
    "status": "confirmed",
    "admin_notes": "Đã liên hệ và xác nhận lịch hẹn"
}
```

**Response:**

```json
{
    "success": true,
    "data": {
        "id": 1,
        "client_name": "Nguyen Van A",
        "status": "confirmed",
        "admin_notes": "Đã liên hệ và xác nhận lịch hẹn",
        "updated_at": "2024-10-23T14:00:00.000000Z"
    }
}
```

**Available Statuses:**

-   `pending` - Chờ xử lý
-   `confirmed` - Đã xác nhận
-   `completed` - Hoàn thành
-   `cancelled` - Đã hủy

---

## 💬 Admin - Quotes

### Get All Quotes

**Endpoint:** `GET /admin/quotes`

**Headers:**

```
Authorization: Bearer {token}
```

**Query Parameters:**

-   `status` (optional) - Filter by status
-   `project_type` (optional) - Filter by project type

**Response:**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "client_name": "Tran Thi B",
            "client_email": "client@example.com",
            "client_phone": "0987654321",
            "project_type": "housing",
            "budget": "500000000.00",
            "area": "150.50",
            "request_details": "Cần thiết kế căn hộ 3 phòng ngủ",
            "status": "pending",
            "admin_notes": null,
            "quoted_amount": null,
            "created_at": "2024-10-23T12:00:00.000000Z"
        }
    ]
}
```

---

### Update Quote Status

**Endpoint:** `PATCH /admin/quotes/{id}/status`

**Headers:**

```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request:**

```json
{
    "status": "quoted",
    "admin_notes": "Đã báo giá chi tiết qua email",
    "quoted_amount": 450000000
}
```

**Response:**

```json
{
    "success": true,
    "data": {
        "id": 1,
        "status": "quoted",
        "admin_notes": "Đã báo giá chi tiết qua email",
        "quoted_amount": "450000000.00",
        "updated_at": "2024-10-23T14:00:00.000000Z"
    }
}
```

**Available Statuses:**

-   `pending` - Chờ xử lý
-   `reviewing` - Đang xem xét
-   `quoted` - Đã báo giá
-   `accepted` - Khách chấp nhận
-   `rejected` - Từ chối

---

## 🎛️ Admin - Settings

### Get All Settings

**Endpoint:** `GET /admin/settings`

**Headers:**

```
Authorization: Bearer {token}
```

**Response:**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "key": "home_hero_title",
            "value_vi": "Thiết kế Nội thất Sang trọng",
            "value_en": "Luxury Interior Design",
            "type": "text",
            "group": "home",
            "created_at": "2024-10-23T12:00:00.000000Z"
        }
    ]
}
```

---

### Create/Update Setting

**Endpoint:** `POST /admin/settings`

**Headers:**

```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request:**

```json
{
    "key": "home_hero_title",
    "value_vi": "Thiết kế Nội thất Cao cấp",
    "value_en": "Premium Interior Design",
    "type": "text",
    "group": "home"
}
```

**Response:**

```json
{
    "success": true,
    "data": {
        "id": 1,
        "key": "home_hero_title",
        "value_vi": "Thiết kế Nội thất Cao cấp",
        "value_en": "Premium Interior Design",
        "type": "text",
        "group": "home",
        "updated_at": "2024-10-23T14:00:00.000000Z"
    }
}
```

---

### Update Setting

**Endpoint:** `PUT /admin/settings/{key}`

**Headers:**

```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request:**

```json
{
    "value_vi": "Thiết kế Nội thất Sang trọng 2024",
    "value_en": "Luxury Interior Design 2024"
}
```

**Response:**

```json
{
    "success": true,
    "data": {
        "key": "home_hero_title",
        "value_vi": "Thiết kế Nội thất Sang trọng 2024",
        "value_en": "Luxury Interior Design 2024",
        "updated_at": "2024-10-23T15:00:00.000000Z"
    }
}
```

---

## 📊 Admin - Dashboard

### Get Dashboard Statistics

**Endpoint:** `GET /admin/dashboard/stats`

**Headers:**

```
Authorization: Bearer {token}
```

**Response:**

```json
{
    "success": true,
    "data": {
        "pending_bookings_count": 5,
        "pending_quotes_count": 3,
        "total_projects_count": 12,
        "total_categories_count": 3,
        "recent_bookings": [
            {
                "id": 1,
                "client_name": "Nguyen Van A",
                "booking_time": "2025-10-25 10:00:00",
                "status": "pending"
            }
        ],
        "recent_quotes": [
            {
                "id": 1,
                "client_name": "Tran Thi B",
                "project_type": "housing",
                "status": "pending"
            }
        ]
    }
}
```

---

## 🔴 Error Responses

### 401 Unauthorized (Missing/Invalid Token)

```json
{
    "message": "Unauthenticated."
}
```

### 404 Not Found

```json
{
    "success": false,
    "message": "Resource not found"
}
```

### 422 Validation Error

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": ["The email field is required."],
        "password": ["The password field is required."]
    }
}
```

### 500 Server Error

```json
{
    "success": false,
    "message": "An error occurred",
    "error": "Detailed error message"
}
```

---

## 📝 Notes

-   **All timestamps are in UTC format (ISO 8601)**
-   **Pagination is not implemented** (returns all results)
-   **File uploads (images)** must be max 5MB
-   **Supported image formats:** jpeg, png, jpg, webp
-   **All Admin routes require authentication** with Bearer token
-   **Tokens don't expire automatically** (revoked on logout)
-   **Email notifications are queued** and sent asynchronously
-   **⚠️ IMPORTANT:** All Cloudinary URLs in the examples above (`https://res.cloudinary.com/dg2iqmelk/image/upload/v.../Luxus/projects/...`) are **MOCK DATA** for documentation purposes only. Real image URLs will only exist after you upload actual images via the API endpoints. The URL format shown is what you will receive after a successful upload.

---

## 🧪 Testing with Postman

1. **Create Collection:** "Luxus Interior Design API"
2. **Add Environment:**
    - Variable: `base_url` = `http://127.0.0.1:8000/api/v1`
    - Variable: `admin_token` = `{your_token_here}`
3. **Set Collection Authorization:**
    - Type: Bearer Token
    - Token: `{{admin_token}}`
4. **Import all endpoints above**

---

**Default Admin Accounts:**

-   Email: `admin@luxus.com` / Password: `Admin@123`
-   Email: `demo@luxus.com` / Password: `Demo@123`
