# 🧪 FrugalDev — Testing Guide

Panduan testing menyeluruh untuk memastikan semua fitur berjalan dengan lancar
di production.

> **Base URL:** `https://porto.frugaldev.biz.id` **Admin URL:**
> `https://porto.frugaldev.biz.id/admin`

---

## 1. Public Pages — Basic Navigation

Buka setiap halaman dan pastikan load tanpa error.

| #    | URL                   | Expected                                          | ☐ |
| ---- | --------------------- | ------------------------------------------------- | - |
| 1.1  | `/`                   | Homepage dengan ASCII banner, stats, recent posts | ☐ |
| 1.2  | `/about`              | About page dengan bio, skills, experience         | ☐ |
| 1.3  | `/projects`           | Project list dengan filtering                     | ☐ |
| 1.4  | `/blog`               | Blog post list dengan pagination                  | ☐ |
| 1.5  | `/guestbook`          | Guestbook entries + form                          | ☐ |
| 1.6  | `/changelog`          | Changelog list                                    | ☐ |
| 1.7  | `/badges`             | Badge collection page                             | ☐ |
| 1.8  | `/search`             | Search page                                       | ☐ |
| 1.9  | `/.plan`              | Plan page (pastikan bukan 403)                    | ☐ |
| 1.10 | `/inspect`            | Inspect/colophon page                             | ☐ |
| 1.11 | `/theme-creator`      | Custom theme builder                              | ☐ |
| 1.12 | `/newsletter/archive` | Newsletter archive                                | ☐ |
| 1.13 | `/feed`               | RSS feed (XML response)                           | ☐ |
| 1.14 | `/feed/comments`      | Comments RSS feed (XML)                           | ☐ |
| 1.15 | `/sitemap.xml`        | Sitemap (XML response)                            | ☐ |

---

## 2. Blog System

### 2.1 Blog Listing

- [ ] Buka `/blog` — post list muncul dengan excerpt, date, tags
- [ ] Pagination berfungsi (klik halaman 2 jika ada)
- [ ] Tag filter: klik tag → `/blog/tag/{tag}` → hanya post dengan tag tersebut

### 2.2 Blog Detail

- [ ] Klik judul post → `/blog/{slug}` → konten lengkap ditampilkan
- [ ] Reading time muncul
- [ ] Tag list di post detail
- [ ] Share buttons berfungsi

### 2.3 Comments

- [ ] Form komentar muncul di bawah post
- [ ] Isi nickname, email, message → submit
- [ ] Pesan sukses muncul: "Comment submitted for moderation"
- [ ] Comment yang sudah approved muncul di post

---

## 3. Guestbook

### 3.1 Posting Entry

- [ ] Buka `/guestbook`
- [ ] Isi form: nickname, message (max 500 chars), website (optional), ASCII art
      (optional)
- [ ] Submit → pesan sukses muncul
- [ ] Edit link ditampilkan setelah submit
- [ ] Entry muncul setelah admin approve

### 3.2 Reply (Threading)

- [ ] Klik tombol `↩ reply` di entry yang ada
- [ ] Form reply muncul inline (di bawah entry)
- [ ] Submit reply → pesan sukses
- [ ] Reply muncul indent di bawah parent entry (setelah approve)

### 3.3 Edit Entry

- [ ] Setelah submit entry, klik edit link yang muncul
- [ ] Halaman `/guestbook/edit/{token}` terbuka
- [ ] Edit message dan/atau ASCII art
- [ ] Submit → kembali ke guestbook dengan pesan sukses
- [ ] Tombol ✏ muncul di entry milik sendiri (cek localStorage)

### 3.4 Reactions

- [ ] Klik emoji reaction (👍 ❤️ dll) di entry
- [ ] Counter bertambah
- [ ] Refresh halaman → reaction tersimpan (localStorage)

---

## 4. Contact Form

- [ ] Buka `/about` atau halaman contact
- [ ] Isi form: name, email, message
- [ ] Submit → pesan sukses: "Message sent!"
- [ ] Coba submit spam (kosongkan field required) → validasi error
- [ ] Rate limit: submit 6x cepat → throttle error (429)

---

## 5. Newsletter

### 5.1 Subscribe

- [ ] Temukan form subscribe di footer/sidebar
- [ ] Masukkan email → submit
- [ ] Pesan sukses: "Please check your email to verify"

### 5.2 Verify

- [ ] Klik verification link dari email (atau test URL:
      `/newsletter/verify/{token}`)

### 5.3 Archive

- [ ] Buka `/newsletter/archive` → list arsip newsletter

### 5.4 Unsubscribe

- [ ] Test URL: `/newsletter/unsubscribe/{token}` → berhasil unsubscribe

---

## 6. Search

- [ ] Buka `/search`
- [ ] Ketik query di search box → hasil muncul (posts, projects)
- [ ] Autocomplete: ketik 3+ karakter → dropdown suggestion muncul
      (`/search/autocomplete`)
- [ ] Klik hasil → navigate ke halaman yang benar
- [ ] Kosongkan search → pesan "No results" atau empty state
- [ ] Command palette: tekan `Ctrl+K` → search modal muncul

---

## 7. Projects

- [ ] Buka `/projects` → project list muncul
- [ ] Filter/sort berfungsi (jika ada)
- [ ] Klik project → `/projects/{slug}` → detail dengan tech stack, links,
      deskripsi
- [ ] External links (repo URL, live URL) berfungsi

---

## 8. Theme System

### 8.1 Theme Switcher

- [ ] Cari theme switcher di footer/navbar
- [ ] Ganti ke **Paper** theme → warna berubah
- [ ] Ganti ke **Amber** theme → warna berubah
- [ ] Kembali ke **Retro** (default)
- [ ] Refresh halaman → theme tetap tersimpan (localStorage)
- [ ] **High Contrast** mode → kontras naik

### 8.2 Custom Theme Creator

- [ ] Buka `/theme-creator`
- [ ] Ubah warna background → live preview berubah
- [ ] Ubah warna text, heading, accent, link, green, border, muted
- [ ] Hex input sync dengan color picker
- [ ] Klik preset **Cyberpunk** → semua warna berubah ke preset
- [ ] Klik preset **Forest**, **Ocean**, **Sunset**, **Mono** → cek
      masing-masing
- [ ] Klik **▶ Apply to site** → seluruh halaman berubah warna
- [ ] Isi nama theme → klik **💾 Save theme** → muncul di "saved themes"
- [ ] Klik nama saved theme → load warna kembali
- [ ] Klik **▶** di saved theme → apply ke site
- [ ] Klik **✕** di saved theme → hapus (confirm dialog)
- [ ] Klik **📋 Copy CSS** → CSS di-copy ke clipboard
- [ ] Klik **↺ Reset** → kembali ke default
- [ ] Refresh halaman → saved themes masih ada (localStorage)

### 8.3 Theme Customization

- [ ] Footer color pickers (bg/text/accent) berfungsi
- [ ] Reset button mengembalikan ke default

### 8.4 Accessibility

- [ ] **Reduced Motion**: aktifkan "Reduce motion" di OS → animasi mati
- [ ] **Dark Mode Auto-Detect**: cek `prefers-color-scheme` behavior

---

## 9. Badges

- [ ] Buka `/badges` → badge collection muncul
- [ ] Badge yang earned = warna penuh, locked = greyed out
- [ ] Progress indicator: "X/Y badges"
- [ ] **First Visit** badge: kunjungi site pertama kali → badge earned (toast
      notification)
- [ ] **Explorer** badge: kunjungi 5+ halaman berbeda
- [ ] **Night Owl** badge: kunjungi site jam 10 PM - 4 AM
- [ ] **Archaeologist** badge: temukan hidden element
- [ ] **Reader** badge: baca blog post sampai selesai
- [ ] **Seasonal badges**: cek berdasarkan bulan saat ini
- [ ] Rarity display: hover badge → tooltip "Common/Rare/Legendary"
- [ ] Badge hint system: clue untuk badge yang belum earned
- [ ] Hidden Badges toggle: klik eye icon → toggle spoiler mode
- [ ] Share card: klik share → gambar badge card generated
- [ ] Refresh halaman → badges tetap tersimpan (localStorage)

---

## 10. Authentication

### 10.1 Login

- [ ] Buka `/login`
- [ ] Login dengan admin credentials (ADMIN_EMAIL/ADMIN_PASSWORD dari env)
- [ ] Redirect ke `/admin` dashboard
- [ ] Login dengan credential salah → error message

### 10.2 Logout

- [ ] Klik logout → redirect ke homepage
- [ ] Akses `/admin` → redirect ke login

### 10.3 Protected Routes

- [ ] Tanpa login, akses `/admin` → redirect ke `/login`
- [ ] Tanpa login, akses `/admin/blog` → redirect ke `/login`
- [ ] User non-admin (jika ada) → akses `/admin` → forbidden

---

## 11. Admin Dashboard

### 11.1 Dashboard

- [ ] Buka `/admin` → statistics cards (posts, projects, comments, guestbook
      entries)
- [ ] Recent activity muncul
- [ ] Quick links berfungsi

### 11.2 Quick Actions Context Menu

- [ ] Right-click di area konten admin → context menu muncul
- [ ] Klik setiap item: Dashboard, New Post, New Project, Export, Settings
- [ ] Klik di luar menu → menu hilang

### 11.3 Undo/Redo

- [ ] Buka form admin (misal: edit blog post)
- [ ] Ketik di text field → `Ctrl+Z` → undo
- [ ] `Ctrl+Y` → redo

---

## 12. Admin — Blog Management

### 12.1 CRUD Blog Post

- [ ] `/admin/blog` → list semua posts
- [ ] Klik **Create** → form muncul
- [ ] Isi: title, content (markdown), excerpt, tags → **Save**
- [ ] Post muncul di list
- [ ] Klik **Edit** → edit form → ubah title → **Save**
- [ ] Klik **Delete** → confirm → post dihapus
- [ ] Klik **Preview** → preview post

### 12.2 Blog Bulk Actions

- [ ] Select multiple posts (checkbox)
- [ ] Bulk publish/unpublish/delete

### 12.3 Scheduled Posts

- [ ] Create post dengan `scheduled_at` di masa depan
- [ ] Post belum muncul di public `/blog`

---

## 13. Admin — Project Management

- [ ] `/admin/projects` → list projects
- [ ] **Create**: title, slug, description, tech stack, URLs → Save
- [ ] **Edit**: ubah data → Save → perubahan terlihat
- [ ] **Delete**: hapus project → confirm → hilang dari list
- [ ] Cek `/projects` publik → project baru muncul

---

## 14. Admin — Skills Management

- [ ] `/admin/skills` → list skills by category
- [ ] **Create**: name, category, level (1-5), sort order → Save
- [ ] **Edit** & **Delete** berfungsi
- [ ] Cek `/about` publik → skill muncul

---

## 15. Admin — Experiences Management

- [ ] `/admin/experiences` → list experiences
- [ ] **Create**: type (work/education), title, organization, dates → Save
- [ ] **Edit** & **Delete** berfungsi
- [ ] Cek `/about` publik → experience muncul

---

## 16. Admin — Testimonials

- [ ] `/admin/testimonials` → list
- [ ] **Create/Edit/Delete** berfungsi
- [ ] Testimonial muncul di homepage

---

## 17. Admin — Guestbook Moderation

- [ ] `/admin/guestbook` → list semua entries (pending + approved)
- [ ] Klik **Approve** → entry muncul di publik `/guestbook`
- [ ] Klik **Delete** → entry dihapus

---

## 18. Admin — Comments Moderation

- [ ] `/admin/comments` → list semua comments (pending + approved)
- [ ] Klik **Approve** → comment muncul di blog post
- [ ] Klik **Delete** → comment dihapus
- [ ] Bulk approve/delete berfungsi

---

## 19. Admin — Contact Messages

- [ ] `/admin/messages` → list pesan masuk
- [ ] Klik message → detail view (nama, email, pesan)
- [ ] **Delete** message berfungsi

---

## 20. Admin — Changelog

- [ ] `/admin/changelog` → list changelog entries
- [ ] **Create**: version, title, content → Save
- [ ] **Edit/Delete** berfungsi
- [ ] Cek `/changelog` publik → entry muncul

---

## 21. Admin — Site Settings

- [ ] `/admin/settings` → form settings
- [ ] Ubah site name, tagline, description, footer text, ASCII banner
- [ ] Save → perubahan terlihat di public site
- [ ] Hit counter value bisa diubah

---

## 22. Admin — Profile

- [ ] `/admin/profile` → edit profile form
- [ ] Ubah: title, bio, social links, status text, location
- [ ] "Currently reading/building/listening" fields
- [ ] Save → cek `/about` publik

---

## 23. Admin — Analytics

- [ ] `/admin/analytics` → page view statistics
- [ ] Grafik/chart muncul (jika ada data)
- [ ] Filter by date range berfungsi

---

## 24. Admin — Activity Log

- [ ] `/admin/activity-log` → list aktivitas admin
- [ ] Actions tercatat: create, update, delete

---

## 25. Admin — Export/Import

### 25.1 Export

- [ ] `/admin/export` → export page
- [ ] Klik **Download** → JSON file downloaded
- [ ] File berisi semua data (posts, projects, settings, dll)

### 25.2 Import

- [ ] `/admin/import` → import page
- [ ] Upload JSON file yang di-export sebelumnya
- [ ] Data berhasil diimport tanpa error

---

## 26. Admin — Newsletter Preview

- [ ] `/admin/newsletter-preview` → preview page
- [ ] Desktop preview muncul
- [ ] Mobile preview muncul
- [ ] Blog post content ditampilkan sebagai email template

---

## 27. Admin — Cache Management

- [ ] Klik **Clear Cache** (POST `/admin/cache/clear`)
- [ ] Pesan sukses: cache berhasil dibersihkan

---

## 28. RSS Feeds

- [ ] `/feed` → valid RSS XML dengan blog posts
- [ ] `/feed/comments` → valid RSS XML dengan comments
- [ ] Cek di RSS reader/validator:
      [W3C Feed Validator](https://validator.w3.org/feed/)

---

## 29. SEO & Meta Tags

Untuk setiap public page, inspect HTML source:

- [ ] `<title>` tag ada dan deskriptif
- [ ] `<meta name="description">` ada
- [ ] Open Graph tags: `og:title`, `og:description`, `og:url`, `og:image`
- [ ] Twitter card: `twitter:card`
- [ ] Canonical URL
- [ ] Proper heading hierarchy (single `<h1>`)
- [ ] Semantic HTML elements

---

## 30. Performance & Middleware

### 30.1 Security Headers

Buka DevTools → Network → ambil response header dari halaman manapun:

- [ ] `X-Content-Type-Options: nosniff`
- [ ] `X-Frame-Options: DENY` atau `SAMEORIGIN`
- [ ] `X-XSS-Protection: 1; mode=block`
- [ ] `Referrer-Policy` header ada

### 30.2 Static Asset Caching

Request file CSS/JS → cek response headers:

- [ ] `Cache-Control: public, max-age=2592000, immutable`

### 30.3 HTML Minification (jika MINIFY_HTML=true)

- [ ] View page source → HTML comments minimal, whitespace collapsed

### 30.4 Lazy Load Images

- [ ] Inspect images → `loading="lazy"` attribute ada

### 30.5 Page View Tracking

- [ ] Kunjungi beberapa halaman → cek `/admin/analytics` → page views tercatat

---

## 31. Responsive Design

Test setiap halaman public di berbagai ukuran layar:

- [ ] Desktop (1920px) — layout normal
- [ ] Tablet (768px) — layout responsif, sidebar collapse
- [ ] Mobile (375px) — single column, hamburger menu
- [ ] Navigasi tetap accessible di semua ukuran

---

## 32. Error Pages

- [ ] Kunjungi URL tidak ada: `/random-page-xyz` → custom 404 page (bukan nginx
      default)
- [ ] Error page memiliki navigasi kembali ke homepage

---

## 33. Rate Limiting

- [ ] Submit contact form 6x berturut-turut cepat → 429 Too Many Requests
- [ ] Submit guestbook entries 6x cepat → 429
- [ ] Submit blog comments 6x cepat → 429

---

## 34. Spam Detection (Guestbook)

- [ ] Submit guestbook dengan kata spam (viagra, casino, dll)
- [ ] Entry ditolak atau di-flag

---

## 35. Docker / Coolify Deployment

### 35.1 Entrypoint

Cek deploy logs di Coolify:

- [ ] `🚀 Starting deployment...` muncul
- [ ] `🔄 Running migrations...` sukses
- [ ] `👤 Creating/updating admin user...` muncul (jika ADMIN_EMAIL set)
- [ ] `⚡ Caching config, routes, and views...` sukses
- [ ] `🔗 Creating storage link...` sukses
- [ ] `✅ Ready! Starting services...` muncul
- [ ] Supervisor: nginx, php-fpm, scheduler = RUNNING

### 35.2 Health Check

- [ ] Container status: **healthy**
- [ ] `/up` endpoint returns 200

### 35.3 Persistent Storage

- [ ] Redeploy → data (SQLite) tetap ada, tidak reset
- [ ] Upload file → redeploy → file tetap ada

---

## Catatan Penting

1. **Semua fitur client-side** (badges, reactions, edit tokens, theme
   preference) menggunakan **localStorage** — clear browser data = reset
2. **Guestbook & Comments** perlu **admin approval** sebelum muncul di publik
3. **Rate limiting** berlaku untuk form submissions (5 request per menit)
4. **Admin credentials** dibuat dari env vars `ADMIN_EMAIL` + `ADMIN_PASSWORD`
