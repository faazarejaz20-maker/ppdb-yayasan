# PPDB Online Yayasan Al-Ishlah Insan Mulia Wonosobo

Prototipe tampilan sistem Penerimaan Peserta Didik Baru (PPDB) untuk 4 unit pendidikan:

| Kode | Slug | Nama | Jenjang |
|---|---|---|---|
| TKK | `tkit-alishlah-kertek` | TKIT Al Ishlah Kertek | TK |
| TKI | `tkit-insanmulia` | TKIT Insan Mulia Wonosobo | TK |
| SD | `sdit-insanmulia` | SDIT Insan Mulia Wonosobo | SD |
| SMP | `smpit-insanmulia` | SMPIT Insan Mulia Wonosobo | SMP |

> **Prototipe: data contoh.** Tidak ada database. Semua data berasal dari
> `app/Support/DemoData.php` dan session. Semua nama, nomor, dan tanggal bersifat fiktif.

## Cara Menjalankan

Prasyarat: PHP 8.2+, Composer, Node.js 18+.

```bash
composer install
npm install
php artisan key:generate
php artisan serve
```

Di terminal terpisah:

```bash
npm run dev
```

Buka `http://127.0.0.1:8000`.

Catatan:
- **Tidak ada `php artisan migrate`.** Aplikasi tidak membutuhkan MySQL/SQLite.
- `.env` sudah disiapkan di repo. Jangan menyalin ulang `.env.example`.
- Pengaturan penting: `SESSION_DRIVER=file`, `CACHE_STORE=file`, `QUEUE_CONNECTION=sync`.

Untuk build aset produksi: `npm run build`.

## Login Contoh

Buka `/login`. Tidak ada password — cukup pilih peran (dan sekolah untuk peran yang terkunci).

| Peran | Cakupan | Bisa apa |
|---|---|---|
| Super Admin | Semua sekolah | Kelola sekolah, akun admin sekolah, akun yayasan, pengaturan |
| Admin Sekolah | 1 sekolah | Semua tugas panitia + akun panitia & periode pendaftaran |
| Panitia | 1 sekolah | Lihat/ubah pendaftar sekolahnya, verifikasi berkas, Terima/Tolak, kirim WhatsApp |
| Yayasan | 4 sekolah | Hanya melihat rekap, tanpa tombol aksi |

## Halaman

### Publik
- `/` — profil yayasan, visi-misi, 4 kartu unit pendidikan, alur PPDB, kontak
- `/{slug}` — halaman sekolah dengan tab **Tentang, Alur, Jadwal, Kontak**
- `/{slug}/daftar` — wizard pendaftaran 6 langkah
- `/cek-pendaftaran` — cek status dengan nomor peserta + tanggal lahir
- `/pendaftaran/sukses/{nomor}` — halaman sukses + cetak bukti
- `/pendaftaran/cetak/{nomor}` — bukti pendaftaran ramah cetak

### Dashboard
- `/dashboard` — daftar pendaftar, filter, paginasi, statistik
- `/dashboard/{nomor}` — detail, verifikasi berkas, Terima/Tolak, WhatsApp, riwayat
- `/dashboard/tambah` — entry data offline
- `/dashboard/akun`, `/dashboard/periode` — khusus admin sekolah
- `/yayasan` — rekap 4 sekolah (read-only)
- `/super-admin` — sekolah, akun admin, akun yayasan, pengaturan

## Data Demo untuk Skenario

### Jalur lanjutan (alumni)
Untuk mendemokan data terisi otomatis:

| Jalur | Nomor Induk | Tanggal Lahir | Nama |
|---|---|---|---|
| SDIT → SMPIT | `2019001` | `2013-05-14` | Ahmad Fadhil Ramadhan |
| SDIT → SMPIT | `2019002` | `2013-08-02` | Siti Nur Aisyah |
| SDIT → SMPIT | `2019003` | `2013-11-21` | Muhammad Rizky Pratama |
| TKIT → SDIT | `2021001` | `2019-03-09` | Aisyah Zahra Putri |
| TKIT → SDIT | `2021002` | `2019-06-17` | Muhammad Fatih Alfarizi |
| TKIT → SDIT | `2021003` | `2019-10-30` | Nabila Khairunnisa |

Data alumni lengkap ada di `DemoData::alumni()` (10 per jalur).

### Nomor peserta contoh
Format `KODE-2026-0001`, urutan terpisah per sekolah. Contoh yang sudah ada:
`TKK-2026-0001`, `TKI-2026-0001`, `SD-2026-0001`, `SMP-2026-0001`.

### Status
`terdaftar` (abu-abu), `berkas_diverifikasi` (biru), `diterima` (hijau), `ditolak` (merah).

## Skenario Demo

> **Penting:** semua data demo disimpan di **session browser**, bukan database.
> Jalankan seluruh skenario di **satu browser yang sama** (boleh logout–login), jangan
> berpindah browser atau memakai mode incognito, karena pendaftar baru tidak akan
> terlihat oleh session lain.

1. **Pendaftar baru** — buka `/sdit-insanmulia`, klik *Daftar Sekarang*, pilih *Pendaftar baru*,
   isi 6 langkah. Setelah kirim muncul nomor peserta dan tombol *Cetak Bukti Pendaftaran*.
2. **Jalur lanjutan** — buka `/smpit-insanmulia/daftar`, pilih *Lulusan sekolah yayasan*,
   masukkan `2019001` + `2013-05-14`, klik *Cari Data*. Nama tampil tersamar, data terisi otomatis,
   dan info **Uang gedung gratis** muncul.
3. **Panitia** — login sebagai Panitia SMPIT. Pendaftar baru muncul dengan badge *Lanjutan*.
   Klik *Terima*, lalu *Siapkan Pesan* → *Buka WhatsApp & Tandai Terkirim*.
4. **Orang tua** — buka `/cek-pendaftaran` dengan nomor peserta dan tanggal lahir tadi.
   Status berubah menjadi **Diterima**.
5. **Yayasan** — login sebagai Yayasan. Rekap 4 sekolah tampil dengan label *Hanya lihat*,
   tanpa satu pun tombol ubah.
6. **Batas akses** — login sebagai Panitia SDIT, lalu buka `/dashboard/SMP-2026-0001`.
   Hasilnya **403**.

> Data demo bisa dikembalikan ke kondisi awal lewat tombol **Reset data demo** di sidebar
> dashboard panitia/admin.

## Struktur Penting

```
app/Support/DemoData.php          # data contoh: sekolah, alumni, persyaratan, pendaftar, akun
app/Support/DemoStore.php         # state session: status, berkas, pengumuman, riwayat, akun
app/Support/RegistrationService.php # aturan validasi + pembuatan pendaftar
app/Http/Controllers/             # Public, Registration, Dashboard, Yayasan, SuperAdmin
resources/js/registration.js      # komponen Alpine wizard 6 langkah
resources/views/public/           # halaman publik + wizard + cetak
resources/views/dashboard/        # dashboard panitia & admin sekolah
resources/views/yayasan/          # rekap read-only
resources/views/super-admin/      # sekolah, akun, pengaturan
lang/id/validation.php            # pesan validasi Bahasa Indonesia
```

## Batasan Prototipe

Sengaja **tidak** termasuk (tahap berikutnya):
- Database, migration, model Eloquent
- Import Excel
- Pembayaran dan daftar ulang sungguhan
- Ranking dan nilai tes
- WhatsApp otomatis (hanya membuka `wa.me` dengan pesan siap kirim)
- Email dan notifikasi otomatis
- Editor isi halaman
- Deployment

File upload pada langkah 5 hanya tampilan — file tidak disimpan.
Semua perubahan demo hilang ketika session berakhir atau direset.

**Satu session, satu cerita.** Karena state ada di session, pendaftar yang dibuat lewat
wizard hanya terlihat oleh session itu. Untuk demo ke beberapa orang, gunakan satu
browser/laptop yang sama, atau minta panitia menambah data lewat *Tambah Pendaftar*
(entry offline) di session masing-masing.

## Asumsi yang Perlu Dikonfirmasi ke Sekolah

1. **Jadwal dan tanggal** PPDB masih contoh (badge *Contoh* di tab Jadwal).
2. **Persyaratan berkas** per jenjang masih sementara:
   TK/SD: Kartu Keluarga, Akta Kelahiran, Pas Foto.
   SMP: ditambah Surat Keterangan Lulus SD.
3. **Batas usia** calon siswa (TK minimal 4 tahun, SD minimal 6 tahun) masih contoh.
4. **Uang gedung gratis** diasumsikan hanya untuk lulusan SDIT yang melanjutkan ke SMPIT.
5. **Nama, alamat, telepon, email, dan warna** tiap sekolah masih placeholder dan perlu
   diganti dengan identitas resmi.
6. **Kebijakan kuota dan biaya** tidak ditampilkan di halaman publik; perlu dipastikan
   apakah akan diumumkan terpisah.
7. **Alur verifikasi berkas** (valid/tidak valid + catatan) perlu disesuaikan dengan SOP panitia.
