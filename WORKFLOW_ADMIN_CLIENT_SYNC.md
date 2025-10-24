# 🔄 LUXUS - Admin-Client Workflow Synchronization

**Date:** October 24, 2025  
**Status:** 🔴 CRITICAL - Column Name Mismatches Found

---

## 🎯 OVERVIEW

### Current Issues:

1. ❌ **Admin Bookings views** use `name`, `email`, `phone` → Should be `client_name`, `client_email`, `client_phone`
2. ❌ **Admin Quotes views** use `name`, `email`, `phone` → Should be `client_name`, `client_email`, `client_phone`
3. ⚠️ **Inconsistent naming** between database schema and views
4. ⚠️ **Admin features** not clearly mapped to client actions

---

## 📊 CLIENT → ADMIN WORKFLOW MAP

### 1️⃣ **BOOKING WORKFLOW** (Đặt lịch tư vấn)

#### CLIENT SIDE:

**Where:**

-   `/contact` page → "Đặt lịch tư vấn" tab
-   Form fields: `client_name`, `client_email`, `client_phone`, `booking_time`, `message`

**Route:**

```php
POST /booking
Route::post('/booking', [ContactController::class, 'storeBooking'])
```

**Request Validation:**

```php
StoreBookingRequest:
- client_name: required|string|max:255
- client_email: required|email|max:255
- client_phone: required|string|max:20
- booking_time: required|date|after:now
- message: nullable|string|max:1000
```

**Database Schema:**

```sql
bookings table:
- id
- client_name ✅
- client_email ✅
- client_phone ✅
- booking_time
- message
- status (pending, confirmed, completed, cancelled)
- admin_notes
- created_at, updated_at
```

#### ADMIN SIDE:

**Where:**

-   `/admin/bookings` → List all bookings
-   `/admin/bookings/{id}` → View & update booking

**Current Issues:**

```php
// ❌ WRONG - admin/bookings/index.blade.php line 76:
{{ $booking->name }}      // Should be: {{ $booking->client_name }}
{{ $booking->email }}     // Should be: {{ $booking->client_email }}
{{ $booking->phone }}     // Should be: {{ $booking->client_phone }}

// ❌ WRONG - admin/bookings/show.blade.php:
Uses same wrong column names
```

**Admin Actions:**

-   View booking details
-   Update status: pending → confirmed → completed / cancelled
-   Add admin notes
-   Contact customer (mailto:, tel: links)

---

### 2️⃣ **QUOTE WORKFLOW** (Yêu cầu báo giá)

#### CLIENT SIDE:

**Where:**

-   `/contact` page → "Yêu cầu báo giá" tab
-   `/projects/{slug}` → Quote form in sidebar
-   Form fields: `client_name`, `client_email`, `client_phone`, `project_type`, `area`, `budget`, `request_details`

**Routes:**

```php
POST /quote
Route::post('/quote', [ContactController::class, 'storeQuote'])
```

**Request Validation:**

```php
StoreQuoteRequest:
- client_name: required|string|max:255
- client_email: required|email|max:255
- client_phone: required|string|max:20
- project_type: nullable|in:housing,apartment,office,commercial
- budget: nullable|numeric|min:0
- area: nullable|numeric|min:0
- request_details: required|string|max:2000
- project_id: nullable|exists:projects,id (added recently)
- reference_project: nullable|string|max:255 (added recently)
```

**Database Schema:**

```sql
quotes table:
- id
- client_name ✅
- client_email ✅
- client_phone ✅
- project_type
- project_id (FK to projects) ✅
- reference_project ✅
- budget
- area
- request_details
- status (pending, reviewing, quoted, accepted, rejected)
- admin_notes
- quoted_amount
- created_at, updated_at
```

#### ADMIN SIDE:

**Where:**

-   `/admin/quotes` → List all quotes with filters
-   `/admin/quotes/{id}` → View & update quote

**Fixed Recently:** ✅

```php
// ✅ CORRECT - admin/quotes/show.blade.php (FIXED):
{{ $quote->client_name }}
{{ $quote->client_email }}
{{ $quote->client_phone }}
{{ $quote->reference_project }}
{{ $quote->area }}
```

**Still Broken:** ❌

```php
// ❌ WRONG - admin/quotes/index.blade.php line 83:
{{ $quote->name }}      // Should be: {{ $quote->client_name }}
{{ $quote->email }}     // Should be: {{ $quote->client_email }}
{{ $quote->phone }}     // Should be: {{ $quote->client_phone }}
```

**Admin Actions:**

-   View quote details
-   Update status: pending → reviewing → quoted → accepted/rejected
-   Add quoted_amount (when status = 'quoted')
-   Add admin notes
-   Contact customer (mailto:, tel: links)

---

### 3️⃣ **PROJECT VIEWING** (Xem dự án)

#### CLIENT SIDE:

**Where:**

-   `/projects` → List all projects with filters
-   `/projects/category/{slug}` → Projects by category
-   `/projects/{slug}` → Project detail with gallery

**Features:**

-   Filter by category
-   Search
-   View project images (gallery + lightbox)
-   Copy project link
-   Request quote (inline form)

#### ADMIN SIDE:

**Where:**

-   `/admin/projects` → Manage projects
-   `/admin/projects/create` → Create new project
-   `/admin/projects/{id}/edit` → Edit project

**Admin Actions:**

-   Create/Edit/Delete projects
-   Upload images to Cloudinary
-   Set primary image
-   Mark as featured
-   Set status (planning, ongoing, completed)
-   Assign category
-   Add Vietnamese & English content

---

### 4️⃣ **CONTENT MANAGEMENT** (Admin Only)

#### CATEGORIES

**Where:** `/admin/categories`
**Actions:**

-   Create/Edit/Delete categories
-   Vietnamese & English names
-   Slugs auto-generated

#### SLIDERS

**Where:** `/admin/sliders`
**Actions:**

-   Create/Edit/Delete homepage sliders
-   Upload images to Cloudinary
-   Set title, subtitle, CTA
-   Order management

#### SETTINGS

**Where:** `/admin/settings`
**Actions:**

-   Update site-wide settings
-   Contact info
-   Social media links
-   About page content
-   Meta tags

---

## 🐛 CRITICAL BUGS TO FIX

### Priority 1: Admin Bookings Index

**File:** `resources/views/admin/bookings/index.blade.php`
**Lines:** ~76-85
**Fix:**

```php
// Change from:
{{ $booking->name }}
{{ $booking->email }}
{{ $booking->phone }}
{{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}

// To:
{{ $booking->client_name }}
{{ $booking->client_email }}
{{ $booking->client_phone }}
{{ \Carbon\Carbon::parse($booking->booking_time)->format('d/m/Y') }}
```

### Priority 2: Admin Bookings Show

**File:** `resources/views/admin/bookings/show.blade.php`
**Lines:** Multiple locations
**Fix:** Replace all instances of `name`, `email`, `phone`, `booking_date` with correct column names

### Priority 3: Admin Quotes Index

**File:** `resources/views/admin/quotes/index.blade.php`
**Lines:** ~83-90
**Status:** ⚠️ Already partially fixed but needs verification

---

## ✅ CORRECT DATA FLOW

### Booking Flow:

```
1. Client fills form on /contact (Booking tab)
   ↓
2. POST /booking → ContactController@storeBooking
   ↓
3. BookingService->createBooking()
   ↓
4. Save to `bookings` table (client_name, client_email, client_phone, booking_time, message)
   ↓
5. SendBookingNotificationJob dispatched
   ↓
6. Email sent to admin
   ↓
7. Admin views at /admin/bookings
   ↓
8. Admin updates status, adds notes
   ↓
9. Customer receives confirmation email
```

### Quote Flow:

```
1. Client fills form on /contact (Quote tab) OR /projects/{slug} (sidebar)
   ↓
2. POST /quote → ContactController@storeQuote
   ↓
3. QuoteService->createQuote()
   ↓
4. Save to `quotes` table (client_name, client_email, client_phone, project_type, etc.)
   ↓
5. SendQuoteNotificationJob dispatched
   ↓
6. Email sent to admin
   ↓
7. Admin views at /admin/quotes
   ↓
8. Admin changes status to 'reviewing'
   ↓
9. Admin adds quoted_amount, changes status to 'quoted'
   ↓
10. Customer receives quote email
   ↓
11. Customer accepts/rejects → Admin updates final status
```

---

## 📋 FEATURE CLARITY

### What Client Can Do:

✅ View projects (list, category filter, detail)
✅ Request booking (đặt lịch tư vấn)
✅ Request quote (yêu cầu báo giá)
✅ View project galleries (with lightbox)
✅ Share project links
✅ Contact via multiple channels (phone, email, wechat)

### What Admin Can Do:

✅ Manage Projects (CRUD + images)
✅ Manage Categories (CRUD)
✅ Manage Sliders (CRUD + images)
✅ Manage Settings (site-wide config)
✅ View & Respond to Bookings
✅ View & Respond to Quotes
✅ Update statuses
✅ Add notes
✅ Add quoted amounts

### What Admin CANNOT Do (but might want to):

❌ Send emails directly from admin panel
❌ Export bookings/quotes to CSV
❌ View analytics/statistics
❌ Auto-generate quote PDFs
❌ Calendar view for bookings
❌ Customer relationship tracking

---

## 🎯 NEXT STEPS

1. ✅ Fix admin/bookings/index.blade.php column names
2. ✅ Fix admin/bookings/show.blade.php column names
3. ✅ Verify admin/quotes/index.blade.php (already partially fixed)
4. ✅ Add loading states to all forms
5. ✅ Test complete workflow: client submit → admin receive → admin update → client notified
6. 📧 Verify email templates use correct column names
7. 📱 Test responsive design on mobile
8. 🔍 Add search functionality to admin lists
9. 📊 Consider adding dashboard statistics
10. 📄 Consider adding PDF export for quotes

---

## 📝 COLUMN NAME REFERENCE

### Bookings Table:

```
✅ client_name (NOT name)
✅ client_email (NOT email)
✅ client_phone (NOT phone)
✅ booking_time (NOT booking_date, NOT date)
✅ message (NOT notes, NOT description)
✅ status
✅ admin_notes
```

### Quotes Table:

```
✅ client_name (NOT name)
✅ client_email (NOT email)
✅ client_phone (NOT phone)
✅ project_type
✅ project_id
✅ reference_project
✅ budget
✅ area
✅ request_details (NOT message, NOT description)
✅ status
✅ admin_notes
✅ quoted_amount
```

---

**END OF DOCUMENT**
