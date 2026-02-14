# FrugalDev — Retro Portfolio Website

A minimalist, retro-styled all-in-one developer portfolio built with **Laravel
12** and **SQLite**.

> Build more. Bloat less.

## Features

### Public Frontend

- **Retro terminal aesthetic** — pixel fonts, ASCII art, `$ whoami` sections,
  `█░` skill bars
- **3 themes** — `retro` (terminal green), `paper` (newspaper), `amber` (old CRT
  monitor)
- **Command palette** — press `Ctrl+K` or `/` for keyboard-driven navigation
- **Badge system** — earn achievements (First Steps, Explorer, Reader, Night
  Owl, etc.)
- **Guest book** with ASCII art support
- **Blog** with Markdown, RSS feed, view counter
- **Hit counter** — classic Web 1.0 visitor counter
- **Easter eggs** — Konami code, secret `/inspect` page

### Admin Panel

- Full CRUD for: Projects, Skills, Experiences, Blog Posts, Testimonials,
  Changelog
- Profile editor with social links and file upload
- Contact message inbox, guest book moderation
- Site settings, cache management
- Blog post scheduling (scheduled_at)

### SEO & Performance

- JSON-LD structured data (Person + WebSite schemas)
- Dynamic XML sitemap (`/sitemap.xml`)
- RSS feed (`/feed`)
- OpenGraph meta tags
- 5-minute query caching on homepage and about page
- Rate limiting on forms (5 requests/min)
- Custom retro error pages (404, 403, 429, 500)

## Tech Stack

| Component | Technology                     |
| --------- | ------------------------------ |
| Backend   | Laravel 12 (PHP 8.5)           |
| Database  | SQLite                         |
| Frontend  | Blade + Vanilla JS (~5KB)      |
| Styling   | Tailwind v4 + Custom Retro CSS |
| Fonts     | Press Start 2P + system-ui     |
| Auth      | Laravel Breeze (Blade)         |

## Quick Start

```bash
# Clone & install
composer install
npm install && npm run build

# Configure
cp .env.example .env
php artisan key:generate

# Database
php artisan migrate
php artisan db:seed --class=DemoSeeder

# Run
php artisan serve
# Visit http://127.0.0.1:8000
```

## Default Admin Login

- **Email:** `admin@frugaldev.site`
- **Password:** `password`

## Project Structure

```
app/
├── Http/Controllers/       # 8 public + 11 admin controllers
├── Models/                 # 12 Eloquent models
└── Http/Middleware/         # AdminMiddleware
database/
├── migrations/             # 14 migrations
└── seeders/                # DemoSeeder
resources/views/
├── admin/                  # Admin panel views
├── blog/                   # Blog listing + article
├── components/             # Layout components
├── errors/                 # Custom error pages
├── projects/               # Project listing + detail
└── ...                     # Public pages
```

## License

MIT
