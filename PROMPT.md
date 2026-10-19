# PROMPT OPENCODE: Prototipe TAMPILAN SAJA (tanpa database) - PPDB Yayasan Al-Ishlah Insan Mulia

> Cara pakai: kirim bagian 1 sampai 9 sebagai konteks, lalu perintahkan "Kerjakan FASE 1".
> Kirim satu fase per pesan. Setelah selesai tiap fase, jalankan dan cek dulu sebelum lanjut.
> Tujuan: bahan demo ke sekolah. Semua data fiktif. Nanti versi database memakai prompt Laravel yang terpisah.

---

## 1. KONTEKS

Buat **prototipe tampilan yang bisa diklik** untuk sistem PPDB online **Yayasan Al-Ishlah Insan Mulia, Wonosobo**. Tidak ada database. Semua data berasal dari file data contoh dan session. Prototipe dipakai untuk menunjukkan tampilan dan alur ke pihak sekolah, jadi harus rapi, mulus, dan nyaman di HP.

Satu sistem untuk 4 sekolah:

| Kode | Slug | Nama | Jenjang |
|---|---|---|---|
| TKK | `tkit-alishlah-kertek` | TKIT Al Ishlah Kertek | TK |
| TKI | `tkit-insanmulia` | TKIT Insan Mulia Wonosobo | TK |
| SD | `sdit-insanmulia` | SDIT Insan Mulia Wonosobo | SD |
| SMP | `smpit-insanmulia` | SMPIT Insan Mulia Wonosobo | SMP |

## 2. TEKNOLOGI DAN ATURAN TEKNIS

- **Laravel 12 + Blade + Tailwind CSS (Vite bawaan) + Alpine.js**. Tanpa starter kit.
- **TANPA DATABASE.** Jangan buat migration, model Eloquent, atau seeder. Jangan membutuhkan MySQL/SQLite.
- Penting untuk Laravel 12: di `.env` dan `.env.example` set `SESSION_DRIVER=file`, `CACHE_STORE=file`, `QUEUE_CONNECTION=sync`, dan hapus atau kosongkan pengaturan `DB_*`, supaya aplikasi tidak mencoba terhubung ke database.
- Data contoh disimpan di satu tempat: `app/Support/DemoData.php` (atau `config/demo.php`) berisi sekolah, alumni, dan pendaftar contoh dalam bentuk array PHP. Pisahkan dari view agar mudah diganti.
- Perubahan saat demo (pendaftar baru, tombol Terima/Tolak, penanda "sudah dikirim") disimpan di **session** supaya terasa hidup. Tambahkan tombol kecil "Reset data demo" di footer dashboard.
- Tanpa test, tanpa paket tambahan. Kode rapi dengan komentar singkat.
- Seluruh teks tampilan **Bahasa Indonesia**.
- Perintah menjalankan (tuliskan di README): `composer install`, `npm install`, `cp .env.example .env`, `php artisan key:generate`, `npm run dev`, `php artisan serve`. Tidak ada `migrate`.

## 3. ATURAN UMUM

- **Mobile-first**, uji di lebar 360px sampai desktop.
- Semua data **fiktif**. Footer semua halaman memuat label kecil **"Prototipe: data contoh"**.
- Jangan meminta atau menampilkan NIK dan penghasilan orang tua.
- **Jangan tampilkan biaya sekolah dan kuota/sisa kursi di halaman publik mana pun.** Tidak ada tab Biaya dan tidak ada angka kuota.
- Jangan meniru logo, foto, nama, atau warna lembaga lain. Logo placeholder: inisial sekolah dalam lingkaran berwarna. Foto banner placeholder berupa gradasi atau pola sederhana.
- Warna dan nama dikumpulkan di satu tempat (CSS variable atau konfigurasi) agar mudah diganti dengan identitas resmi.
- Login palsu: tidak ada password sungguhan (lihat bagian 6).

## 4. PERAN (HANYA TAMPILAN, TETAP DIJAGA DI LEVEL ROUTE)

| Peran | Cakupan | Bisa apa |
|---|---|---|
| Super admin (dipegang orang yayasan) | Semua sistem | Kelola sekolah, akun admin sekolah, dan akun yayasan; tidak mengelola pendaftar |
| Admin sekolah | 1 sekolah | Seperti panitia, plus daftar akun panitia dan daftar periode (tampilan saja) |
| Panitia | 1 sekolah | Lihat dan ubah pendaftar sekolahnya, verifikasi berkas, Terima/Tolak, kirim WhatsApp |
| Yayasan | 4 sekolah | **Hanya lihat**, tanpa tombol aksi |
| Orang tua | tanpa akun | Daftar, lalu cek status |

Aturan yang tetap harus berjalan walau tanpa database:
- Panitia dan admin sekolah hanya melihat pendaftar **sekolahnya sendiri**. Coba buka data sekolah lain, jawab 403.
- Yayasan tidak punya route untuk mengubah data. Request ubah data dijawab 403.
- Satu halaman login untuk semua peran, lalu diarahkan ke dashboard sesuai peran.

## 5. DATA CONTOH (`DemoData`)

**Sekolah** (4): `code, slug, name, jenjang, address, phone, whatsapp, email, color, tagline, about, highlights (3-4 keunggulan), steps (4-6 langkah), schedule (buka, tutup, tes/observasi, pengumuman, daftar ulang), requirements, opens_at, closes_at`. Tidak ada data biaya dan kuota. Tampilkan badge kecil **"Contoh"** di tab Jadwal karena tanggal masih fiktif.
- Info "Uang gedung gratis" untuk lanjutan SD ke SMP **bukan** bagian halaman publik. Tampilkan hanya di langkah 1 form lanjutan, halaman sukses, dan hasil Cek Pendaftaran.

**Persyaratan berkas per jenjang** (contoh sementara, simpan terpisah per jenjang agar mudah diganti):
- TK: Kartu Keluarga, Akta Kelahiran, Pas Foto.
- SD: Kartu Keluarga, Akta Kelahiran, Pas Foto.
- SMP: Kartu Keluarga, Akta Kelahiran, Pas Foto, Surat Keterangan Lulus SD.

**Aturan lanjutan** (di konfigurasi, mudah diubah): TK melanjutkan ke SD, SD melanjutkan ke SMP. Uang gedung gratis hanya untuk SD ke SMP.

**Data alumni untuk demo "melanjutkan"** (nama dan angka fiktif; buat sekitar 10 data per sekolah asal, minimal berisi yang berikut):

SDIT ke SMPIT (nomor induk, tanggal lahir):
- `2019001`, 2013-05-14, Ahmad Fadhil Ramadhan
- `2019002`, 2013-08-02, Siti Nur Aisyah
- `2019003`, 2013-11-21, Muhammad Rizky Pratama

TKIT ke SDIT (nomor induk, tanggal lahir):
- `2021001`, 2019-03-09, Aisyah Zahra Putri
- `2021002`, 2019-06-17, Muhammad Fatih Alfarizi
- `2021003`, 2019-10-30, Nabila Khairunnisa

**Pendaftar contoh**: sekitar 30 pendaftar tersebar di 4 sekolah. Variasikan jenis (Lanjutan/Baru), status (terdaftar, berkas_diverifikasi, diterima, ditolak), tanggal daftar, dan sebagian sudah bertanda "pengumuman terkirim". Nomor peserta format `KODE-2026-0001` (urutan terpisah per sekolah).

Status (hanya 4): `terdaftar` (abu-abu), `berkas_diverifikasi` (biru), `diterima` (hijau), `ditolak` (merah). Daftar ulang hanya **teks informasi** pada status Diterima: "Informasi daftar ulang akan disampaikan sekolah."

## 6. HALAMAN PUBLIK

Navbar (sama di semua halaman publik): **Beranda, Sekolah (dropdown berisi 4 sekolah), Cek Pendaftaran, Login**. Di halaman sekolah, sekolah yang sedang dibuka diberi tanda aktif di dropdown. Di HP menjadi tombol hamburger.

1. **Beranda yayasan `/`** (halaman profil yayasan, pintu masuk ke sekolah): banner "Yayasan Al-Ishlah Insan Mulia Wonosobo" dengan tagline, bagian **Tentang Yayasan**, **Visi dan Misi** (teks contoh), **Unit Pendidikan** berupa 4 kartu sekolah (logo placeholder, nama, jenjang, tombol "Lihat & Daftar") sebagai jalan pintas, **Alur PPDB singkat** 5 langkah dengan ikon (Pilih sekolah, Isi data, Unggah berkas, Verifikasi, Pengumuman), lalu kontak yayasan dan footer.
2. **Halaman sekolah `/{slug}`**: satu template untuk 4 sekolah, tetapi tiap sekolah punya identitas sendiri (logo placeholder, warna aksen, banner, tagline, isi tab, persyaratan). Header: logo, nama, alamat, **badge status pendaftaran** ("Pendaftaran dibuka sampai ..." atau "Ditutup"), tombol hijau **Daftar sekarang** (nonaktif jika ditutup) yang langsung membuka form sekolah itu, dan tombol kecil Cek Pendaftaran. Tab (Alpine.js): **Tentang, Alur, Jadwal, Kontak**.
   - **Tentang**: profil singkat dan 3-4 keunggulan.
   - **Alur**: langkah pendaftaran bernomor, lalu bagian **Persyaratan Berkas** berupa daftar ber-centang per berkas dengan keterangan singkat (contoh: "Kartu Keluarga: foto atau scan jelas, seluruh bagian terlihat"), format JPG/PNG/PDF maksimal 2 MB, dan catatan syarat lain (misal batas usia, teks contoh). Daftar ini diambil dari data persyaratan jenjang yang **sama** dengan kolom unggah di langkah 5 wizard.
   - **Jadwal**: tabel kegiatan dan tanggal, dengan badge "Contoh".
   - **Kontak**: alamat, telepon/WhatsApp panitia (tombol "Hubungi via WhatsApp"), email, jam layanan, tautan peta.
   - Di bawah tab: kotak ajakan jalur lanjutan ("Lulusan TKIT? / Lulusan SDIT? Daftar lewat jalur lanjutan, data terisi otomatis") hanya untuk SD dan SMP, dan tautan kembali ke Beranda Yayasan.
   - Perbedaan jenjang: TK tanpa kotak lanjutan dan tanpa kolom asal sekolah; SMP menambah berkas Surat Keterangan Lulus SD.
3. **Form daftar `/{slug}/daftar`**: wizard 6 langkah dengan indikator "Langkah x dari 6", tombol Kembali/Lanjut, validasi per langkah, data tidak hilang saat pindah langkah (state di Alpine). 
   - **Langkah 1 Jenis pendaftaran**: dua kartu besar "Lulusan sekolah yayasan" dan "Pendaftar baru". Untuk TK, kartu lulusan yayasan disembunyikan (tidak ada sekolah asal). Untuk lanjutan: input **Nomor Induk + Tanggal Lahir**, tombol "Cari data". Jika cocok dengan data alumni: tampilkan **nama tersamar** (contoh `Ahm** Fa***`) untuk konfirmasi, lalu data otomatis terisi. Jika tidak ditemukan: pesan jelas dan saran "hubungi panitia sekolah". Tampilkan info **"Uang gedung gratis"** untuk SD ke SMP (hanya di sini, halaman sukses, dan Cek Pendaftaran, bukan di halaman publik).
   - **Langkah 2 Data calon siswa**: nama lengkap, jenis kelamin, tempat dan tanggal lahir, agama, anak ke-berapa, NISN (opsional untuk TK). Terisi otomatis untuk lanjutan dan tetap bisa diedit.
   - **Langkah 3 Data orang tua/wali**: nama ayah, nama ibu, pekerjaan, **nomor WhatsApp wajib** (validasi format, tampilkan bahwa `08xx` akan diubah ke `628xx`), email opsional.
   - **Langkah 4 Alamat dan asal sekolah**: alamat lengkap; asal sekolah (disembunyikan untuk TK, terisi otomatis untuk lanjutan).
   - **Langkah 5 Unggah berkas**: daftar berkas dinamis sesuai jenjang. **Tampilan saja**: pilih file lalu tampilkan nama file dan ikon centang, tidak ada penyimpanan sungguhan.
   - **Langkah 6 Tinjau dan kirim**: ringkasan semua data dengan tombol "Ubah" per bagian, centang pernyataan, tombol Kirim.
   - **Halaman sukses**: nomor peserta besar (dibuat dari penghitung di session, lanjutan dari nomor terakhir sekolah itu), tombol **Cetak bukti pendaftaran** (halaman ramah cetak dengan CSS print), dan tautan ke Cek Pendaftaran. Pendaftar baru ikut masuk ke daftar dashboard panitia lewat session.
4. **Cek pendaftaran `/cek-pendaftaran`**: input nomor peserta + tanggal lahir. Tampilkan data ringkas, badge status, dan keterangan uang gedung gratis bila ada. Cari di data contoh dan pendaftar dari session.
5. **Login `/login`**: karena ini prototipe, tampilkan **tombol pilihan peran** (Super admin, Admin sekolah, Panitia, Yayasan) dan pilihan sekolah untuk peran yang terkunci ke satu sekolah. Tanpa password. Beri catatan kecil "Login contoh untuk demo".

## 7. DASHBOARD

Layout dengan sidebar yang menunya menyesuaikan peran. Komponen dipakai ulang (Blade component): tabel, badge, kartu statistik, filter.

**Panitia dan Admin sekolah `/dashboard`** (terkunci ke satu sekolah)
- Kartu ringkas: total pendaftar, menunggu verifikasi, diterima, ditolak.
- Tabel pendaftar: nomor peserta, nama, badge **Lanjutan/Baru**, status, tanggal daftar, status pengumuman; pencarian; filter status, jenis, dan "belum dikirim pengumuman"; paginasi.
- Detail pendaftar: semua data, daftar berkas dengan tombol valid/tidak valid dan kolom catatan, tombol **Terima / Tolak** (mengubah status di session), tombol **Kirim via WhatsApp**, dan riwayat perubahan sederhana.
- **Kirim via WhatsApp**: buka `https://wa.me/<nomor 628xx>?text=<pesan>` di tab baru. Pesan siap kirim bisa diedit lebih dulu di kotak teks, contoh: "Assalamu'alaikum Bapak/Ibu. Pendaftaran dengan nomor peserta SD-2026-0001 atas nama [nama] telah diproses. Hasil: DITERIMA. Informasi lebih lanjut akan disampaikan oleh pihak sekolah." Saat diklik, tandai **"sudah dikirim"** di session.
- **Entry data offline**: tombol "Tambah pendaftar" memakai wizard yang sama.
- Admin sekolah tambahan: halaman **Akun panitia** dan **Periode pendaftaran** (tabel contoh, tombol tampil saja atau berfungsi ringan di session).

**Yayasan `/yayasan`** (hanya lihat)
- Rekap per sekolah: jumlah pendaftar, diterima, ditolak, lanjutan vs baru. Filter sekolah, tabel pendaftar semua sekolah **tanpa tombol aksi apa pun**. Label "Hanya lihat" di pojok atas.

**Super admin `/super-admin`** (akan dipegang orang yayasan, jadi tampilannya harus jelas dan mudah dipakai orang awam)
- Sidebar: **Sekolah, Akun Admin Sekolah, Akun Yayasan, Pengaturan**.
- **Sekolah**: tabel 4 sekolah (nama, jenjang, status aktif/nonaktif, admin) dengan tombol Ubah dan Aktif/Nonaktifkan yang berfungsi ringan di session.
- **Akun Admin Sekolah** dan **Akun Yayasan**: tabel akun (nama, email, sekolah, status) dengan tombol **Tambah akun** (form sederhana), **Reset password** (tampilkan password sementara contoh), dan **Nonaktifkan**, semuanya berfungsi di session.
- **Pengaturan**: nama sistem dan tahun ajaran aktif (tampilan saja).
- Super admin tidak punya tombol Terima/Tolak dan tidak mengelola pendaftar.

## 8. DESAIN

- Bersih, hangat, bernuansa **hijau**; tiap sekolah punya warna aksen sendiri. Tombol besar untuk layar sentuh, kontras cukup, tipografi mudah dibaca.
- State kosong, pesan error ramah, dan indikator langkah wizard yang jelas.
- Logo dan foto placeholder, mudah diganti lewat satu folder atau satu kolom data.
- Hindari tampilan yang terlihat seperti template bawaan generik; beri sentuhan yang rapi dan konsisten.

## 9. DI LUAR LINGKUP

Database, import Excel, pembayaran dan daftar ulang sungguhan, ranking dan nilai tes, WhatsApp otomatis, email, editor isi halaman, deployment. Cukup disebut sebagai "tahap berikutnya" di README.

---

## 10. URUTAN PENGERJAAN (BERHENTI DI TIAP FASE)

Setelah tiap fase: jelaskan singkat apa yang selesai dan cara mengujinya, lalu **tunggu persetujuan**.

- **FASE 1, Fondasi dan halaman publik**: proyek Laravel 12 tanpa database (`.env` sesuai bagian 2), Tailwind, Alpine, `DemoData`, layout publik, beranda, halaman sekolah dengan tab, login pilih peran dengan route guard per peran.
- **FASE 2, Alur pendaftaran**: wizard 6 langkah, pencarian lanjutan, nomor peserta, halaman sukses dan cetak bukti, Cek Pendaftaran.
- **FASE 3, Dashboard panitia dan admin sekolah**: tabel, filter, detail, verifikasi berkas, Terima/Tolak, tombol WhatsApp, entry offline, reset data demo.
- **FASE 4, Dashboard yayasan dan super admin**: rekap hanya lihat dan daftar akun/sekolah.
- **FASE 5, Penyempurnaan**: cek tampilan 360px, perapian teks Indonesia, README (cara menjalankan, cara memakai login contoh, data contoh untuk demo, skenario demo).

## 11. SKENARIO DEMO YANG HARUS JALAN (KRITERIA SELESAI)

1. Di HP, orang tua memilih SDIT, mendaftarkan **anak baru** sampai muncul nomor peserta dan bisa membuka halaman cetak bukti.
2. Orang tua memilih SMPIT, **lulusan yayasan**, memasukkan `2019001` dan tanggal lahir `2013-05-14`, melihat nama tersamar, data terisi otomatis, dan info uang gedung gratis.
3. Panitia SMPIT login, melihat pendaftar baru tadi dengan badge **Lanjutan**, menekan Terima, lalu Kirim via WhatsApp dan muncul penanda "sudah dikirim".
4. Orang tua membuka **Cek Pendaftaran** dan melihat status **Diterima**.
5. Pengurus yayasan login dan melihat rekap 4 sekolah **tanpa satu pun tombol ubah**.
6. Panitia SDIT mencoba membuka data SMPIT, hasilnya ditolak (403).

Di akhir, tulis `README.md`: cara menjalankan, cara login contoh, data demo untuk skenario nomor 2, dan daftar asumsi yang masih harus dikonfirmasi ke sekolah.
