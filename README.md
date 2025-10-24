# Luxus - Luxury Interior Design Platform

A modern web platform for managing and showcasing luxury interior design projects with booking, quotation, and image management capabilities.

## Tech Stack

-   Laravel 12.x (PHP 8.2+)
-   MySQL
-   TailwindCSS 3.x + Alpine.js
-   Cloudinary (Image Management)
-   Laravel Queue (Background Jobs)

## Requirements

-   PHP >= 8.2
-   Composer
-   Node.js >= 18.x
-   MySQL >= 8.0

## Quick Setup

```bash
# Clone repository
git clone https://github.com/ariushieu/luxus.git
cd luxus

# Install dependencies
composer install
npm install

# Environment setup
copy .env.example .env
php artisan key:generate

# Database setup (update .env first with your DB credentials)
php artisan migrate --seed

# Run development server
composer dev
```

## Configuration

Update `.env` file with your credentials:

```env
DB_DATABASE=luxus_db
DB_USERNAME=root
DB_PASSWORD=your_password

CLOUDINARY_CLOUD_NAME=your_cloud_name
CLOUDINARY_API_KEY=your_api_key
CLOUDINARY_API_SECRET=your_api_secret

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
```

## Development

Run all services at once:

```bash
composer dev
```

Or run individually:

```bash
php artisan serve          # Laravel server
php artisan queue:work     # Queue worker
npm run dev                # Vite dev server
```

Access: http://localhost:8000

## Production Build

```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Useful Commands

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Storage link
php artisan storage:link

# Database
php artisan migrate
php artisan migrate:fresh --seed

# Testing
php artisan test
```

## License

MIT License

---

Built with ❤️ using Laravel
