# PPDB Yayasan Al-Ishlah Insan Mulia

PPDB online prototype for 4 schools. No database - all data from `app/Support/DemoData.php` and session.

## Setup

```bash
composer install
npm install
php artisan key:generate
php artisan serve
npm run dev
```

`.env` sudah disiapkan di repo; **jangan** menyalin ulang `.env.example`. Tidak ada `migrate` - proyek berjalan tanpa MySQL/SQLite.


## Aturan kerja (WAJIB)
- Kerjakan SATU FASE per permintaan, lalu berhenti dan tunggu persetujuan.
- Jangan membuat test dan jangan menambah paket di luar Alpine.js.
- Jangan membuat proyek baru dan jangan mengubah struktur dasar Laravel.
- Jangan menjalankan `cp .env.example .env` karena .env sudah diatur.
- Jalankan dengan `php artisan serve` dan `npm run dev` (jangan `composer dev`).

## Tampilan
- Tab halaman sekolah hanya: Tentang, Alur, Jadwal, Kontak (TANPA tab Biaya).
- Persyaratan berkas ada di tab Alur dan memakai data yang sama dengan langkah 5 wizard.
- Footer semua halaman: label "Prototipe: data contoh".
- Super admin dipegang orang yayasan, jadi tampilannya harus sederhana dan jelas.


## Environment

`.env` dan `.env.example` sudah diset untuk tanpa database. Jangan ubah kembali ke driver database:

```
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
APP_LOCALE=id
```

`DB_CONNECTION=sqlite` masih ada di `.env.example` tetapi tidak dipakai aplikasi. Jangan menambah migration/model/seeder.

## Tech Stack

- Laravel 12
- Blade + Tailwind CSS (via Vite)
- Alpine.js
- No database, no starter kit

## Commands

- `php artisan serve` - Laravel dev server (wajib; jangan `composer dev`)
- `npm run dev` - Vite dev server (wajib, jalankan terpisah)
- `composer test` - Clear config and run PHPUnit tests
- `npm run build` - Production build

## Architecture

### Schools (4 units)

| Code | Slug | Name | Level |
|------|------|------|-------|
| TKK | `tkit-alishlah-kertek` | TKIT Al Ishlah Kertek | TK |
| TKI | `tkit-insanmulia` | TKIT Insan Mulia Wonosobo | TK |
| SD | `sdit-insanmulia` | SDIT Insan Mulia Wonosobo | SD |
| SMP | `smpit-insanmulia` | SMPIT Insan Mulia Wonosobo | SMP |

### Roles

| Role | Scope | Permissions |
|------|-------|-------------|
| Super admin | All system | Manage schools, admin accounts; no pendaftar access |
| Admin sekolah | 1 school | Panitia duties + manage panitia accounts, periods |
| Panitia | 1 school | CRUD pendaftar, verify docs, Terima/Tolak, send WhatsApp |
| Yayasan | 4 schools | Read-only, no action buttons |
| Orang tua | No account | Register, check status |

### Key Routes

- `/` - Foundation homepage
- `/{slug}` - School page (4 schools) — **registered last** so it does not shadow `/login`, `/cek-pendaftaran`, etc.
- `/pendaftaran/sukses/{nomorPeserta}` - Registration success page
- `/pendaftaran/cetak/{nomorPeserta}` - Print-friendly proof (no navbar/footer)
- `/{slug}/daftar` - Registration wizard (6 steps, GET + POST)
- `/cek-pendaftaran` - Check registration status
- `/login` - Demo login (role selection, no password)
- `/dashboard` - Panitia/Admin sekolah dashboard (list, filters, pagination)
- `/dashboard/{nomorPeserta}` - Detail: verifikasi berkas, Terima/Tolak, WhatsApp, riwayat
- `/dashboard/tambah` - Offline entry, reuses the same wizard partial
- `/dashboard/akun`, `/dashboard/periode` - Admin sekolah only (display-only tables)
- `/yayasan` - Yayasan recap dashboard, read-only (all 4 schools, filter by school, no action buttons)
- `/super-admin` - Super admin: school list + activate/deactivate
- `/super-admin/akun/{scope}` - `scope` is `admin` or `yayasan`; add/toggle/reset-password
- `/super-admin/pengaturan` - System name + active school year (display only)

Wizard state lives in `resources/js/registration.js` (Alpine `registrationWizard` component, registered in `app.js`). Server-side validation in `RegistrationController@store` is authoritative; failures redirect back with `old()` input and `initialStep` set to the earliest failing step.

New registrations are appended to `session('new_pendaftar')`. All mutations during a demo live in session through `App\Support\DemoStore` — never write to `DemoData` at runtime:
- `pendaftar_status` - status overrides by nomor peserta
- `berkas_status` - per-file verification state + catatan
- `pengumuman_terkirim` - WhatsApp sent flags
- `riwayat_pendaftar` - activity log entries
- `new_pendaftar` - registrations created during the demo
- `demo_school_active` - super admin school active/inactive overrides
- `demo_accounts_admin` / `demo_accounts_yayasan` - account lists (seeded lazily from `DemoData`)
- `demo_temp_password` - generated temporary passwords shown in the UI

`DemoStore::reset()` (POST `/dashboard/reset`, panitia/admin only) clears all of them. Use `DemoStore::pendaftar()` / `DemoStore::schools()` / `DemoStore::accounts()` rather than the `DemoData` originals when rendering, so overrides apply.

Yayasan has no mutation routes at all: every POST under `/dashboard` and `/super-admin` is guarded by `role:panitia,admin_sekolah` or `role:super_admin`, so a yayasan session receives 403 even with a valid CSRF token.

Panitia/Admin are scoped by `session('user_school_code')`; `DashboardController::resolvePendaftar()` aborts 403 for other schools' records. There is no auth guard beyond the demo `role` session key.

Route guards use the `role:` middleware alias (`bootstrap/app.php`), e.g. `middleware('role:panitia,admin_sekolah')`. School-level scoping uses `school.access`.

### Access Control

- Panitia/Admin sekolah can only see pendaftar from their school
- Yayasan has no mutation routes (403 on write attempts)
- Single login page redirects to role-appropriate dashboard

## Data Structure

### Demo Data (`app/Support/DemoData.php`)

Contains:
- 4 schools with identity (color, logo placeholder, tagline)
- Alumni data for continuation path (TK→SD, SD→SMP)
- ~30 sample pendaftar spread across schools
- Requirements per jenjang (TK, SD, SMP differ)

### Status Values

1. `terdaftar` - gray
2. `berkas_diverifikasi` - blue
3. `diterima` - green
4. `ditolak` - red

### Participant Number Format

`KODE-2026-0001` (separate sequence per school)

## Constraints

- Mobile-first (test 360px)
- Indonesian language for all UI
- No NIK or income fields
- No biaya (fees) or kuota (quota) on public pages
- "Uang gedung gratis" info only for SD→SMP continuation (step 1 form, success page, check status)
- Placeholder logos/fotos, easy to replace

## Key Files

- `PROMPT.md` - Full specification (source of truth for phases and requirements)
- `app/Support/DemoData.php` - All demo data (schools, alumni, requirements, pendaftar, accounts, periods) + helpers
- `app/Support/DemoStore.php` - Session-backed mutable state (status, berkas, pengumuman, riwayat, reset)
- `app/Support/RegistrationService.php` - Shared validation rules + create/normalize WhatsApp
- `bootstrap/app.php` - Middleware aliases (`role`, `school.access`)
- `resources/views/components/layouts/public.blade.php` - Public layout (slot-based Blade component)
- `resources/views/components/layouts/dashboard.blade.php` - Dashboard layout with role-aware sidebar
- `resources/views/components/ui/` - `status-badge`, `jenis-badge`
- `resources/views/components/public/navbar.blade.php` - Shared navbar with school dropdown
- `resources/views/public/partials/registration-form.blade.php` - Reused 6-step wizard markup (public + offline entry)
- `resources/views/yayasan/index.blade.php` - Read-only recap + filter
- `resources/views/super-admin/` - schools, accounts (admin/yayasan scope), settings
- `resources/views/public/` - home, school (tabs), register (wizard), register-success, register-print, check-registration, check-result
- `resources/js/registration.js` - Alpine wizard component (steps, validation, alumni lookup, file display)
- `lang/id/validation.php` - Indonesian validation messages (locale is `id`)
- `resources/views/auth/login.blade.php` - Demo role picker
- `vite.config.js` - Tailwind + Laravel Vite setup

## Development Notes

- Form wizard uses Alpine.js for state (data persists across steps)
- Demo login shows role buttons, no real auth
- File uploads are display-only (no actual storage)
- WhatsApp integration: opens `wa.me` URL with pre-filled message; phone numbers are stored as `62...` and displayed locally via `DemoStore::localWhatsapp()`
- Session stores all demo changes; "Reset data demo" button in the dashboard sidebar (panitia/admin)
- Because state lives in the session, new registrations are only visible in the same browser session — keep the whole demo in one browser
- List pages render a table on `md+` and stacked cards on mobile (`md:hidden`), so nothing is cut off at 360px
- Print-friendly CSS for registration proof
