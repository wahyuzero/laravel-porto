# 🚀 Coolify Deployment Guide — FrugalDev

## File yang Dibuat

| File                      | Fungsi                                                |
| ------------------------- | ----------------------------------------------------- |
| `Dockerfile`              | Multi-stage build (Node → Composer → PHP-FPM + Nginx) |
| `.dockerignore`           | Exclude file yang tidak perlu dari build              |
| `docker/nginx.conf`       | Nginx config (gzip, caching, PHP-FPM proxy)           |
| `docker/php.ini`          | OPcache + production PHP settings                     |
| `docker/www.conf`         | PHP-FPM worker pool config                            |
| `docker/supervisord.conf` | Manage PHP-FPM + Nginx + Laravel Scheduler            |
| `docker/entrypoint.sh`    | Startup: migrations, cache, storage link              |
| `.env.example`            | Template environment variables                        |

---

## Setup di Coolify (Step-by-Step)

### 1. Push ke GitHub/GitLab

```bash
git add -A
git commit -m "Add Coolify deployment config"
git push origin main
```

### 2. Buka Coolify Dashboard

1. Login ke Coolify → klik **"+ New Resource"**
2. Pilih **"Application"**
3. Pilih **source**: GitHub / GitLab (connect repo kamu)
4. Pilih repo **wxsys-project** dan branch **main**

### 3. Konfigurasi Build

Di halaman konfigurasi:

| Setting                 | Value                                          |
| ----------------------- | ---------------------------------------------- |
| **Build Pack**          | `Dockerfile`                                   |
| **Dockerfile Location** | `./Dockerfile` _(default, tidak perlu diubah)_ |
| **Port**                | `80`                                           |
| **Health Check Path**   | `/`                                            |

### 4. Environment Variables

Klik tab **"Environment Variables"** dan tambahkan:

```env
APP_NAME=FrugalDev
APP_ENV=production
APP_KEY=base64:XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
APP_DEBUG=false
APP_URL=https://yourdomain.com
DB_CONNECTION=sqlite
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
MINIFY_HTML=true
```

> [!IMPORTANT]
> **Generate APP_KEY**: Jalankan `php artisan key:generate --show` di lokal,
> copy hasilnya ke `APP_KEY`.

### 5. Persistent Storage (PENTING!)

Karena pakai **SQLite**, database harus di-persist. Di Coolify:

1. Klik tab **"Storages"** / **"Persistent Storage"**
2. Tambahkan volume:

| Container Path           | Nama Volume          |
| ------------------------ | -------------------- |
| `/var/www/html/database` | `frugaldev-database` |
| `/var/www/html/storage`  | `frugaldev-storage`  |

> [!CAUTION]
> **Tanpa persistent storage, data akan hilang setiap kali deploy!** Ini wajib
> untuk SQLite.

### 6. Domain & SSL

1. Di tab **"Settings"** → masukkan domain: `yourdomain.com`
2. Coolify otomatis generate SSL via Let's Encrypt
3. Jika pakai subdomain: `app.yourdomain.com`

### 7. Deploy!

Klik tombol **"Deploy"** — Coolify akan:

1. Clone repo
2. Build Docker image (multi-stage)
3. Start container
4. Jalankan entrypoint (migrations, cache, etc.)

Tunggu sampai status **"Running"** ✅

---

## Troubleshooting

### Cek logs

Di Coolify → klik **"Logs"** tab untuk melihat output container.

### Database error

Pastikan persistent volume sudah di-map. Jika error:

```
SQLSTATE[HY000]: General error: 8 attempt to write a readonly database
```

→ Volume belum di-mount. Cek kembali step 5.

### 502 Bad Gateway

Container mungkin belum ready. Tunggu 30 detik. Jika masih error, cek logs.

### Rebuild tanpa cache

Di Coolify → klik ⚙️ → pilih **"Rebuild without cache"**.

---

## Auto-Deploy (CI/CD)

Coolify sudah support auto-deploy. Di settings:

1. Enable **"Auto Deploy"** → setiap push ke `main` otomatis deploy
2. Atau pakai **Webhook URL** dari Coolify untuk trigger manual

---

## Catatan Teknis

- **PHP 8.3** (Alpine) — ringan dan cepat
- **SQLite** — zero-config database, cukup untuk personal/portfolio site
- **Nginx** — static file serving + reverse proxy ke PHP-FPM
- **Supervisor** — mengelola semua process dalam 1 container
- **OPcache** — PHP bytecode caching untuk performance
- **Gzip** — compress HTML/CSS/JS responses
- **Multi-stage build** — image final kecil (~100MB)
