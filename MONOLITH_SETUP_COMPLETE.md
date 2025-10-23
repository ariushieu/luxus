# LUXUS - MONOLITH WEB APPLICATION

## ✅ Đã hoàn thành

### 1. 🎨 **Hero Carousel Homepage** (Auto-slide mỗi 3 giây)

-   ✅ Carousel tự động lướt ảnh từ featured projects
-   ✅ Hiển thị thông tin dự án trên mỗi slide
-   ✅ Indicators và controls để điều khiển
-   ✅ Responsive trên mobile

**Cách hoạt động:**

```blade
@foreach($featuredProjects as $project)
    <div class="carousel-item" style="background-image: url('{{ $project->primary_image->cloudinary_url }}')">
        <h1>{{ $project->title_vi }}</h1>
        <badge>{{ $project->category->name_vi }}</badge>
    </div>
@endforeach
```

**Bootstrap config:** `data-bs-interval="3000"` (3 giây)

---

### 2. 🖼️ **Tất cả ảnh lấy từ Database**

#### Homepage:

-   ✅ **Hero Carousel**: Ảnh từ featured projects
-   ✅ **Category Cards**: Ảnh từ project đầu tiên của mỗi category
-   ✅ **Featured Projects**: Ảnh primary_image từ DB

```php
// Category images
$categoryProject = Project::where('category_id', $category->id)
    ->whereHas('images')
    ->with('images')
    ->first();
```

#### About Page:

-   ✅ **Section Images**: Random ảnh từ ProjectImage
-   ✅ **Gallery**: 6 ảnh random từ tất cả dự án active

```php
$galleryImages = ProjectImage::whereHas('project', function($q) {
    $q->where('is_active', true);
})->inRandomOrder()->limit(6)->get();
```

#### Projects Pages:

-   ✅ **Listing**: Ảnh từ primary_image của mỗi project
-   ✅ **Detail**: Full gallery từ project->images
-   ✅ **Related Projects**: Ảnh từ cùng category

---

### 3. 🎭 **Social Icons - UI Update**

#### Design mới:

```css
✅ Gradient background cho mỗi icon
✅ Hover effects với scale + translateY
✅ Pulse animation cho icon Phone
✅ Tooltip hiển thị khi hover
✅ Shadow effects 3D
```

#### Icons:

1. **Facebook** (`#3b5998`)

    - Gradient: `#3b5998 → #2d4373`
    - Icon: `fa-facebook-f`
    - Tooltip: "Facebook"

2. **WeChat** (`#09b83e`)

    - Gradient: `#09b83e → #078a2f`
    - Icon: `fa-weixin`
    - Tooltip: "WeChat"

3. **Phone** (`#00bcd4`)
    - Gradient: `#00bcd4 → #0097a7`
    - Icon: `fa-phone-alt`
    - Tooltip: "Gọi ngay: +84 123 456 789"
    - **Special**: Pulse animation 2s infinite

#### CSS Animations:

```css
@keyframes pulse-ring {
    0%,
    100% {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3), 0 0 0 0 rgba(0, 188, 212, 0.5);
    }
    50% {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3), 0 0 0 10px rgba(0, 188, 212, 0);
    }
}
```

---

## 📂 Cấu trúc Routes

### Public Routes (Web):

```php
GET  /                              → HomeController@index
GET  /about                         → AboutController@index
GET  /contact                       → ContactController@index
GET  /projects                      → ProjectController@index
GET  /projects/category/{slug}      → ProjectController@byCategory
GET  /projects/{slug}               → ProjectController@show
POST /booking                       → ContactController@storeBooking
POST /quote                         → ContactController@storeQuote
```

### API Routes (Giữ nguyên):

```php
GET  /api/v1/projects              → API endpoints vẫn hoạt động
GET  /api/v1/categories
POST /api/v1/admin/login
...
```

---

## 🎨 Views Structure

```
resources/views/
├── layouts/
│   └── app.blade.php              ✅ Main layout với navbar, footer, social icons
├── home.blade.php                 ✅ Homepage với carousel
├── about.blade.php                ✅ About page với gallery từ DB
├── contact.blade.php              ✅ Contact với forms
└── projects/
    ├── index.blade.php            ✅ Projects listing
    └── show.blade.php             ✅ Project detail với gallery
```

---

## 🎯 Features Highlights

### 1. Homepage Carousel

-   **Auto-play**: 3 giây/slide
-   **Smooth transitions**: Bootstrap 5 carousel
-   **Dynamic content**: Tên dự án, category, CTA button
-   **Responsive**: Full height trên desktop, 70vh trên mobile

### 2. Image Management

-   **Centralized**: Tất cả ảnh từ `project_images` table
-   **Cloudinary**: URLs từ cloud storage
-   **Fallback**: Default image nếu không có ảnh
-   **Performance**: Lazy loading + optimized queries

### 3. Social Icons

-   **Fixed position**: Luôn hiển thị bên phải màn hình
-   **Interactive**: Hover effects + tooltips
-   **Attention**: Phone icon có pulse animation
-   **Mobile optimized**: Smaller size + hidden tooltips

---

## 🚀 Cách chạy

```bash
# Đã chạy rồi
php artisan serve

# Truy cập
http://127.0.0.1:8000
```

---

## 📸 Chi tiết từng trang

### 1. Homepage (`/`)

```
┌─────────────────────────────────┐
│  NAVBAR                         │
├─────────────────────────────────┤
│  HERO CAROUSEL (Full Height)    │
│  • Auto-slide 3s                │
│  • Featured projects images     │
│  • Project info overlay         │
├─────────────────────────────────┤
│  ABOUT SECTION                  │
│  • Company intro                │
│  • Random image from DB         │
├─────────────────────────────────┤
│  CATEGORIES (3 columns)         │
│  • Image: First project of cat │
│  • Hover effects                │
├─────────────────────────────────┤
│  FEATURED PROJECTS (Grid)       │
│  • Primary images from DB       │
│  • Project cards                │
├─────────────────────────────────┤
│  CTA SECTION                    │
├─────────────────────────────────┤
│  FOOTER                         │
└─────────────────────────────────┘

SOCIAL ICONS (Fixed right)
├─ Facebook (gradient blue)
├─ WeChat (gradient green)
└─ Phone (gradient cyan + pulse)
```

### 2. About Page (`/about`)

```
• Hero banner
• Company story with 2 random images from DB
• Core values (3 cards)
• Project gallery (6 random images from DB)
  - Click to open full size in new tab
• CTA section
```

### 3. Projects Listing (`/projects`)

```
• Hero banner
• Category filters (tabs)
• Projects grid
  - Primary image từ DB
  - Project info
  - Status badges
  - Featured tags
```

### 4. Project Detail (`/projects/{slug}`)

```
• Hero: Project primary image
• Project info card
• Full image gallery từ DB
  - Sorted by display_order
  - Click to open full size
  - Primary badge
• Quote request form (sidebar)
• Related projects
```

### 5. Contact Page (`/contact`)

```
• Hero banner
• Contact info card
• Tabs:
  1. Booking form
  2. Quote request form
• Google Maps embed
```

---

## 💾 Database Query Examples

### Featured Projects với Images:

```php
$featuredProjects = Project::where('is_featured', true)
    ->where('is_active', true)
    ->with(['category', 'images'])
    ->orderBy('display_order')
    ->limit(6)
    ->get();
```

### Category với Representative Image:

```php
$categoryProject = Project::where('category_id', $category->id)
    ->whereHas('images')
    ->with('images')
    ->first();

$image = $categoryProject->primary_image->cloudinary_url;
```

### Random Gallery Images:

```php
$galleryImages = ProjectImage::whereHas('project', function($q) {
    $q->where('is_active', true);
})->inRandomOrder()->limit(6)->get();
```

---

## 🎨 CSS Highlights

### Carousel:

```css
.hero-carousel {
    height: 100vh;
}

.carousel-item {
    background-size: cover;
    background-position: center;
    transition: transform 0.6s ease-in-out;
}
```

### Social Icons:

```css
.social-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, ...);
    transition: all 0.3s ease;
}

.social-icon:hover {
    transform: translateY(-5px) scale(1.1);
}

.social-icon.phone {
    animation: pulse-ring 2s infinite;
}
```

### Tooltips:

```css
.social-icon[data-tooltip]::after {
    content: attr(data-tooltip);
    opacity: 0;
    transition: opacity 0.3s;
}

.social-icon:hover::after {
    opacity: 1;
}
```

---

## 📱 Responsive Design

### Breakpoints:

```css
@media (max-width: 768px) {
    /* Hero carousel: 70vh */
    /* Social icons: smaller (50px) */
    /* Tooltips: hidden */
    /* Font sizes: reduced */
}
```

---

## ✨ Interactive Elements

1. **Carousel Controls**

    - Prev/Next arrows
    - Dot indicators
    - Keyboard navigation

2. **Social Icons**

    - Hover: Scale + elevation
    - Phone: Pulse animation
    - Tooltips on desktop

3. **Image Hover Effects**

    - Category cards: Image scale 1.1
    - Gallery: Image scale 1.05
    - Project cards: Card elevation

4. **Forms**
    - Real-time validation
    - Success messages
    - Error handling

---

## 🎯 Next Steps (Optional)

### Admin Panel (Laravel Breeze/Filament):

-   [ ] CRUD cho projects
-   [ ] Upload/manage images
-   [ ] Set featured projects
-   [ ] Manage bookings/quotes

### Performance:

-   [ ] Image lazy loading
-   [ ] Cache queries
-   [ ] CDN for assets
-   [ ] Database indexing

### SEO:

-   [ ] Meta tags dynamic
-   [ ] Open Graph images
-   [ ] Sitemap.xml
-   [ ] Structured data

---

**Hệ thống đã hoàn thiện và sẵn sàng sử dụng!** 🎉

Truy cập: http://127.0.0.1:8000
