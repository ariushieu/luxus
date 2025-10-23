# LUXUS Admin Panel - Testing Workflow

## 🎯 Overview

Admin panel đã được implement đầy đủ với 5 modules chính và responsive UI. Tài liệu này hướng dẫn test toàn bộ workflows.

---

## ✅ Pre-requisites

**Server đang chạy:**

```bash
php artisan serve
# Server: http://127.0.0.1:8000
```

**Admin Credentials:**

-   Email: `admin@luxus.com`
-   Password: `Admin@123`

**Database đã seed:**

-   2 admins
-   3 categories (housing, commercial, office)
-   3 projects with images
-   8 settings

---

## 📋 Testing Checklist

### 1. Authentication & Access Control

**Test Login/Logout:**

1. Navigate to `http://127.0.0.1:8000/admin/login`
2. Enter credentials and login
3. Should redirect to `/admin/dashboard`
4. Click avatar dropdown → Logout
5. Should redirect back to login page

**Test Protected Routes:**

1. Logout from admin
2. Try accessing `http://127.0.0.1:8000/admin/projects`
3. Should redirect to `/admin/login` (not home page)

---

### 2. Dashboard

**URL:** `/admin/dashboard`

**Test Statistics Cards:**

-   [ ] Total Projects count displays correctly
-   [ ] Active Projects count displays correctly
-   [ ] Pending Bookings count displays correctly
-   [ ] Pending Quotes count displays correctly

**Test Recent Tables:**

-   [ ] Recent Bookings table shows latest 5
-   [ ] Recent Quotes table shows latest 5
-   [ ] Recent Projects table shows latest 5
-   [ ] All links navigate correctly

---

### 3. Categories Management

**URL:** `/admin/categories`

#### Test: Create Category

1. Click "Thêm Danh mục"
2. Fill form:
    - Tên (VI): `Biệt thự`
    - Tên (EN): `Villa`
    - Slug: `villa` (auto-generated)
    - Description (VI): `Thiết kế biệt thự cao cấp`
    - Description (EN): `Luxury villa design`
    - Status: ✅ Active
3. Click "Lưu Danh mục"
4. **Expected:** Success message, redirected to index page
5. **Verify:** New category appears in table

**Auto-slug generation test:**

-   Type "Nhà phố" → Slug should auto-fill as "nha-pho"

#### Test: Edit Category

1. Click edit icon (pencil) on existing category
2. Change name to "Nhà ở Cao cấp"
3. **Expected:** Slug updates to "nha-o-cao-cap-{id}"
4. Click "Cập nhật Danh mục"
5. **Verify:** Changes saved

#### Test: Delete Category (with validation)

**Scenario A - Category có projects:**

1. Try deleting "housing" category (có projects)
2. **Expected:** Error message "Không thể xóa danh mục đang có dự án!"

**Scenario B - Category trống:**

1. Delete "Villa" category (just created, no projects)
2. Confirm deletion
3. **Expected:** Success message, category removed

---

### 4. Projects Management

**URL:** `/admin/projects`

#### Test: Create Project with Multiple Images

1. Click "Thêm Dự án Mới"
2. Fill form:
    - **Left Panel:**
        - Tên (VI): `Căn hộ Vinhomes Central Park`
        - Tên (EN): `Vinhomes Central Park Apartment`
        - Mô tả (VI): `Thiết kế nội thất căn hộ 3 phòng ngủ phong cách hiện đại`
        - Mô tả (EN): `Modern interior design for 3-bedroom apartment`
        - Tên Khách hàng: `Mr. Nguyen Van A`
        - Địa điểm: `Vinhomes Central Park, TP.HCM`
        - Diện tích: `120`
        - Ngày Hoàn thành: `2024-10-01`
    - **Images:** Select 3 images from your computer
    - **Right Panel:**
        - Danh mục: `Nhà ở` (housing)
        - Status: ✅ Active
3. Click "Lưu Dự án"

**Expected Results:**

-   Success message appears
-   Redirected to projects list
-   New project shows in table with thumbnail
-   Image count badge shows "3"

**Verify Cloudinary:**

1. Go to Cloudinary dashboard
2. Navigate to `Luxus/housing/` folder
3. **Verify:** 3 images uploaded with correct naming

#### Test: Image Preview (Before Upload)

1. In create form, select multiple images
2. **Expected:** Preview thumbnails appear below file input
3. **Verify:** First image has "Ảnh chính" badge

#### Test: Edit Project & Manage Images

1. Click edit icon on newly created project
2. **Verify existing images:**
    - Gallery shows all 3 images
    - Primary image has "Ảnh chính" badge
    - Each image has "Xóa" button

**Test: Upload Additional Image**

1. Click "Thêm ảnh" button (opens modal)
2. Select 1 more image
3. Check "Đặt làm ảnh chính" checkbox
4. Click "Tải lên"
5. **Expected:**
    - Success message
    - New image appears in gallery
    - New image now has "Ảnh chính" badge
    - Old primary image badge removed

**Test: Delete Image (Business Rules)**

**Scenario A - Try delete only image:**

1. Create project with only 1 image
2. Try to delete that image
3. **Expected:** Error "Không thể xóa ảnh duy nhất của dự án!"

**Scenario B - Try delete primary image:**

1. Try deleting current primary image
2. **Expected:** Error "Vui lòng chọn ảnh chính khác trước khi xóa ảnh này!"

**Scenario C - Delete non-primary image:**

1. Make sure project has > 1 image
2. Delete a non-primary image
3. **Expected:** Success, image removed from gallery
4. **Verify Cloudinary:** Image deleted from cloud storage

#### Test: Update Project Info

1. Edit project form
2. Change category from "Nhà ở" to "Thương mại"
3. Update other fields
4. Click "Cập nhật Dự án"
5. **Expected:** Changes saved
6. **Note:** Images remain in old folder (housing), not moved to commercial

#### Test: Delete Project (Cascade Delete)

1. Delete a project with multiple images
2. Confirm deletion
3. **Expected:**
    - Success message
    - Project removed from list
4. **Verify Cloudinary:**
    - All project images deleted from cloud
    - Check `Luxus/{category}/` folder - images gone

---

### 5. Bookings Management

**URL:** `/admin/bookings`

#### Test: Filter Tabs

1. **Verify tab badges:**

    - All: Shows total count
    - Chờ xác nhận: Shows pending count
    - Đã xác nhận: Shows confirmed count
    - Hoàn thành: Shows completed count
    - Đã hủy: Shows cancelled count

2. Click each tab
3. **Expected:** Table filters correctly, only shows matching status

#### Test: View Booking Details

1. Click "eye" icon on any booking
2. **Verify details page shows:**
    - Customer name, email, phone
    - Booking date and time (formatted dd/mm/yyyy)
    - Message from customer
    - Current status with badge
    - Created timestamp

#### Test: Update Booking Status

1. In booking details page
2. Change status dropdown: `pending` → `confirmed`
3. Add admin notes: `Đã xác nhận lịch hẹn qua điện thoại`
4. Click "Cập nhật"
5. **Expected:**
    - Success message
    - Status badge updates
    - Notes saved

**Test Status Flow:**

-   Try: `pending` → `completed` ✅
-   Try: `confirmed` → `cancelled` ✅
-   Try: `completed` → `pending` ✅ (all transitions allowed)

---

### 6. Quotes Management

**URL:** `/admin/quotes`

#### Test: Filter Tabs

1. Click each status tab:
    - All / Chờ xử lý / Đang xem xét / Đã báo giá / Đã chấp nhận / Đã từ chối
2. **Verify:** Table filters correctly

#### Test: View Quote Details

1. Click "eye" icon on any quote
2. **Verify details:**
    - Customer info (name, email, phone)
    - Project type
    - Budget range
    - Message/requirements
    - Current quoted amount (if exists)
    - Created timestamp

#### Test: Update Status WITHOUT Amount (Validation)

1. Change status to "Đã báo giá" (quoted)
2. Leave "Số tiền báo giá" empty
3. Click "Cập nhật"
4. **Expected:** Error "Vui lòng nhập số tiền báo giá!"

#### Test: Update Status WITH Amount

1. Change status to "Đã báo giá"
2. Enter quoted amount: `150000000` (150 million VND)
3. Add notes: `Báo giá cho dự án 3 phòng ngủ, bao gồm toàn bộ nội thất`
4. Click "Cập nhật"
5. **Expected:**
    - Success message
    - Status updates to "Đã báo giá"
    - Amount displays in quotes list: "150,000,000 VNĐ"

#### Test: JavaScript Conditional Field

1. In quote details page
2. Change status dropdown (DO NOT submit)
3. **Observe:**
    - When status = "Đã báo giá" → Amount field SHOWS (required)
    - When status = other → Amount field HIDES (not required)

---

### 7. Settings Management

**URL:** `/admin/settings`

#### Test: Grouped Tabs

1. **Verify 3 tabs exist:**

    - Trang Chủ (Home)
    - Liên Hệ (Contact)
    - Chung (General)

2. Click each tab
3. **Verify:** Correct settings display for each group

#### Test: Bilingual Editing

1. Go to "Trang Chủ" tab
2. Find "hero_title" setting
3. **Verify fields:**
    - Tiếng Việt: Text on left
    - English: Text on right

#### Test: Bulk Update Settings

1. Modify multiple settings across different groups:
    - Home: Change "hero_title" (VI/EN)
    - Contact: Change "email" to valid email
    - Contact: Change "phone" to valid phone
    - General: Change "site_name"
2. Click "Lưu Tất cả Cài đặt"
3. **Expected:** Single success message for all updates

#### Test: Email Validation

1. Go to "Liên Hệ" tab
2. Enter invalid email: `notanemail`
3. Click save
4. **Expected:** Error "Email không hợp lệ!"

#### Test: Phone Validation

1. Enter invalid phone: `abc123xyz`
2. Click save
3. **Expected:** Error "Số điện thoại không hợp lệ!"

#### Test: Verify Changes on Public Website

1. Update "hero_title" in settings
2. Open public website: `http://127.0.0.1:8000/`
3. **Verify:** Homepage displays new title
4. Update contact info
5. Go to: `http://127.0.0.1:8000/contact`
6. **Verify:** New contact details display

---

### 8. Responsive Design Testing

**Test Mobile Layout:**

1. Resize browser to mobile width (< 992px)
2. **Verify:**
    - Sidebar hidden by default
    - Floating toggle button visible (bottom-right)
    - Click toggle → sidebar slides in
    - Click outside → sidebar closes
    - All tables responsive (horizontal scroll if needed)

**Test Desktop Layout:**

1. Resize to desktop width (> 992px)
2. **Verify:**
    - Sidebar fixed and visible
    - No toggle button
    - Tables fit width properly

---

### 9. UI/UX Elements

**Test Alerts:**

-   [ ] Success alerts are green
-   [ ] Error alerts are red
-   [ ] Alerts auto-dismiss or have close button

**Test Confirmation Dialogs:**

-   [ ] Delete actions show confirm prompt
-   [ ] Cancel → No action taken
-   [ ] OK → Action executes

**Test Status Badges:**

-   [ ] Pending: Yellow/Warning color
-   [ ] Confirmed/Reviewing: Blue/Info color
-   [ ] Completed/Quoted: Green/Success color
-   [ ] Cancelled/Rejected: Red/Danger color

**Test Hover Effects:**

-   [ ] Sidebar menu items highlight on hover
-   [ ] Table action buttons show tooltip on hover
-   [ ] Cards lift on hover (dashboard stats)

---

### 10. Navigation Testing

**Test Sidebar Links:**

-   [ ] Dashboard → `/admin/dashboard`
-   [ ] Categories → `/admin/categories`
-   [ ] Projects → `/admin/projects`
-   [ ] Bookings → `/admin/bookings`
-   [ ] Quote Requests → `/admin/quotes`
-   [ ] Site Settings → `/admin/settings`
-   [ ] View Website → Opens public site in new tab

**Test Active States:**

-   [ ] Current page highlighted in sidebar
-   [ ] Active link has colored left border

**Test Breadcrumbs/Page Titles:**

-   [ ] Page titles display correctly in navbar
-   [ ] Page headings match content

---

## 🐛 Common Issues & Fixes

### Issue: Images not uploading

**Solution:** Check Cloudinary credentials in `.env`

### Issue: "Route not defined" errors

**Solution:** Run `php artisan route:clear`

### Issue: Layout broken / styles missing

**Solution:** Run `php artisan view:clear`

### Issue: Cannot delete image

**Check:** Is it the only image? Is it primary with other images existing?

### Issue: Validation errors not showing

**Check:** Network tab for 422 responses, check form field names match backend

---

## ✅ Final Verification

After all tests:

1. **Database Integrity:**

    - Check `projects` table - new projects exist
    - Check `project_images` table - image records correct
    - Check `categories` table - slug unique
    - Check `bookings` table - status updated
    - Check `quotes` table - quoted_amount saved
    - Check `settings` table - values updated

2. **Cloudinary:**

    - Login to Cloudinary dashboard
    - Navigate to `Luxus/` folder
    - Verify subfolders: `housing/`, `commercial/`, `office/`
    - Check images exist in correct folders
    - Verify deleted images are gone

3. **Public Website:**
    - Homepage displays updated settings
    - Projects page shows new projects with images
    - Category filters work correctly
    - Project detail page displays gallery
    - Contact page shows updated info

---

## 📊 Success Criteria

✅ **All admin CRUD operations working**  
✅ **Image upload to Cloudinary successful**  
✅ **Business rules enforced (delete validations)**  
✅ **Status workflows functioning**  
✅ **Settings persist and reflect on public site**  
✅ **Responsive design works on mobile**  
✅ **No console errors**  
✅ **No broken links**

---

## 📝 Notes

-   Test on different browsers (Chrome, Firefox, Edge)
-   Test with different image sizes (small, large, 5MB+)
-   Test with Vietnamese characters (diacritics)
-   Test pagination if > 20 items exist
-   Test with multiple admin users if needed

**Happy Testing! 🎉**
