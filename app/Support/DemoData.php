<?php

namespace App\Support;

class DemoData
{
    public static function schools(): array
    {
        return [
            [
                'code' => 'TKK',
                'slug' => 'tkit-alishlah-kertek',
                'name' => 'TKIT Al Ishlah Kertek',
                'jenjang' => 'TK',
                'address' => 'Jl. Raya Kertek No. 123, Kertek, Wonosobo',
                'phone' => '0286-123456',
                'whatsapp' => '6281234567890',
                'email' => 'tkit.kertek@alishlah.sch.id',
                'color' => '#10b981', // green-500
                'tagline' => 'Membangun Generasi Qur\'ani Sejak Dini',
                'about' => 'TKIT Al Ishlah Kertek adalah lembaga pendidikan anak usia dini berbasis Islam yang mengintegrasikan nilai-nilai Qur\'ani dalam setiap kegiatan pembelajaran.',
                'highlights' => [
                    'Kurikulum berbasis tahfidz dan akhlaq',
                    'Pembelajaran sentra dan bermain sambil belajar',
                    'Pendampingan psikolog dan konselor anak',
                    'Lingkungan yang aman dan nyaman'
                ],
                'steps' => [
                    'Pilih jenis pendaftaran (baru/lanjutan)',
                    'Isi data calon siswa dan orang tua',
                    'Lengkapi alamat dan asal sekolah',
                    'Unggah berkas persyaratan',
                    'Tinjau data dan kirim pendaftaran',
                    'Simpan bukti pendaftaran dan nomor peserta'
                ],
                'schedule' => [
                    ['kegiatan' => 'Pendaftaran dibuka', 'tanggal' => '1 Januari 2026'],
                    ['kegiatan' => 'Pendaftaran ditutup', 'tanggal' => '28 Februari 2026'],
                    ['kegiatan' => 'Observasi', 'tanggal' => '1-15 Maret 2026'],
                    ['kegiatan' => 'Pengumuman', 'tanggal' => '20 Maret 2026'],
                    ['kegiatan' => 'Daftar ulang', 'tanggal' => '21-31 Maret 2026']
                ],
                'requirements' => 'Usia minimal 4 tahun pada 1 Juli 2026. Berkas yang diunggah harus jelas dan dapat dibaca.',
                'opens_at' => '2026-01-01',
                'closes_at' => '2026-12-31'
            ],
            [
                'code' => 'TKI',
                'slug' => 'tkit-insanmulia',
                'name' => 'TKIT Insan Mulia Wonosobo',
                'jenjang' => 'TK',
                'address' => 'Jl. Bhayangkara No. 45, Wonosobo',
                'phone' => '0286-234567',
                'whatsapp' => '6281234567891',
                'email' => 'tkit@insanmulia.sch.id',
                'color' => '#3b82f6', // blue-500
                'tagline' => 'Tumbuh Cerdas Berakhlak Mulia',
                'about' => 'TKIT Insan Mulia Wonosobo mengedepankan pendidikan karakter dan tahfidz Qur\'an sejak usia dini dengan metode pembelajaran yang menyenangkan.',
                'highlights' => [
                    'Metode sentra dan montessori',
                    'Program tahfidz juz 30',
                    'Kegiatan outbound dan fieldtrip rutin',
                    'Guru berpengalaman dan bersertifikat'
                ],
                'steps' => [
                    'Pilih jenis pendaftaran (baru)',
                    'Isi data calon siswa dan orang tua',
                    'Lengkapi alamat',
                    'Unggah berkas persyaratan',
                    'Tinjau data dan kirim pendaftaran',
                    'Simpan bukti pendaftaran dan nomor peserta'
                ],
                'schedule' => [
                    ['kegiatan' => 'Pendaftaran dibuka', 'tanggal' => '1 Januari 2026'],
                    ['kegiatan' => 'Pendaftaran ditutup', 'tanggal' => '28 Februari 2026'],
                    ['kegiatan' => 'Observasi', 'tanggal' => '1-15 Maret 2026'],
                    ['kegiatan' => 'Pengumuman', 'tanggal' => '20 Maret 2026'],
                    ['kegiatan' => 'Daftar ulang', 'tanggal' => '21-31 Maret 2026']
                ],
                'requirements' => 'Usia minimal 4 tahun pada 1 Juli 2026. Berkas yang diunggah harus jelas dan dapat dibaca.',
                'opens_at' => '2026-01-01',
                'closes_at' => '2026-12-31'
            ],
            [
                'code' => 'SD',
                'slug' => 'sdit-insanmulia',
                'name' => 'SDIT Insan Mulia Wonosobo',
                'jenjang' => 'SD',
                'address' => 'Jl. Diponegoro No. 78, Wonosobo',
                'phone' => '0286-345678',
                'whatsapp' => '6281234567892',
                'email' => 'sdit@insanmulia.sch.id',
                'color' => '#8b5cf6', // violet-500
                'tagline' => 'Mencerdaskan Generasi Qur\'ani',
                'about' => 'SDIT Insan Mulia Wonosobo adalah sekolah dasar Islam terpadu yang mengintegrasikan kurikulum nasional dengan pendidikan agama Islam.',
                'highlights' => [
                    'Kurikulum nasional plus tahfidz',
                    'Pembelajaran aktif dan menyenangkan',
                    'Fasilitas lengkap dan modern',
                    'Ekstrakurikuler beragam'
                ],
                'steps' => [
                    'Pilih jenis pendaftaran (baru/lanjutan)',
                    'Isi data calon siswa dan orang tua',
                    'Lengkapi alamat dan asal sekolah',
                    'Unggah berkas persyaratan',
                    'Tinjau data dan kirim pendaftaran',
                    'Simpan bukti pendaftaran dan nomor peserta'
                ],
                'schedule' => [
                    ['kegiatan' => 'Pendaftaran dibuka', 'tanggal' => '1 Januari 2026'],
                    ['kegiatan' => 'Pendaftaran ditutup', 'tanggal' => '15 Maret 2026'],
                    ['kegiatan' => 'Tes tulis dan wawancara', 'tanggal' => '20-25 Maret 2026'],
                    ['kegiatan' => 'Pengumuman', 'tanggal' => '1 April 2026'],
                    ['kegiatan' => 'Daftar ulang', 'tanggal' => '2-10 April 2026']
                ],
                'requirements' => 'Usia minimal 6 tahun pada 1 Juli 2026. Berkas yang diunggah harus jelas dan dapat dibaca.',
                'opens_at' => '2026-01-01',
                'closes_at' => '2026-12-31'
            ],
            [
                'code' => 'SMP',
                'slug' => 'smpit-insanmulia',
                'name' => 'SMPIT Insan Mulia Wonosobo',
                'jenjang' => 'SMP',
                'address' => 'Jl. Pemuda No. 90, Wonosobo',
                'phone' => '0286-456789',
                'whatsapp' => '6281234567893',
                'email' => 'smpit@insanmulia.sch.id',
                'color' => '#f59e0b', // amber-500
                'tagline' => 'Membangun Pemimpin Berakhlak Mulia',
                'about' => 'SMPIT Insan Mulia Wonosobo mempersiapkan siswa menjadi pemimpin masa depan dengan karakter Islami yang kuat dan prestasi akademik yang unggul.',
                'highlights' => [
                    'Kurikulum merdeka belajar',
                    'Program tahfidz dan bahasa Arab',
                    'Pengembangan leadership dan soft skills',
                    'Prestasi akademik dan non-akademik'
                ],
                'steps' => [
                    'Pilih jenis pendaftaran (baru/lanjutan)',
                    'Isi data calon siswa dan orang tua',
                    'Lengkapi alamat dan asal sekolah',
                    'Unggah berkas persyaratan',
                    'Tinjau data dan kirim pendaftaran',
                    'Simpan bukti pendaftaran dan nomor peserta'
                ],
                'schedule' => [
                    ['kegiatan' => 'Pendaftaran dibuka', 'tanggal' => '1 Januari 2026'],
                    ['kegiatan' => 'Pendaftaran ditutup', 'tanggal' => '31 Maret 2026'],
                    ['kegiatan' => 'Tes tertulis dan wawancara', 'tanggal' => '5-10 April 2026'],
                    ['kegiatan' => 'Pengumuman', 'tanggal' => '15 April 2026'],
                    ['kegiatan' => 'Daftar ulang', 'tanggal' => '16-25 April 2026']
                ],
                'requirements' => 'Lulusan SD/MI. Berkas yang diunggah harus jelas dan dapat dibaca.',
                'opens_at' => '2026-01-01',
                'closes_at' => '2026-12-31'
            ]
        ];
    }

    public static function alumni(): array
    {
        return [
            // TKIT Kertek ke SDIT
            ['nomor_induk' => '2021001', 'tanggal_lahir' => '2019-03-09', 'nama' => 'Aisyah Zahra Putri', 'asal_sekolah' => 'TKIT Al Ishlah Kertek', 'tujuan' => 'SD'],
            ['nomor_induk' => '2021002', 'tanggal_lahir' => '2019-06-17', 'nama' => 'Muhammad Fatih Alfarizi', 'asal_sekolah' => 'TKIT Al Ishlah Kertek', 'tujuan' => 'SD'],
            ['nomor_induk' => '2021003', 'tanggal_lahir' => '2019-10-30', 'nama' => 'Nabila Khairunnisa', 'asal_sekolah' => 'TKIT Al Ishlah Kertek', 'tujuan' => 'SD'],
            ['nomor_induk' => '2021004', 'tanggal_lahir' => '2019-01-15', 'nama' => 'Ahmad Rizki Maulana', 'asal_sekolah' => 'TKIT Al Ishlah Kertek', 'tujuan' => 'SD'],
            ['nomor_induk' => '2021005', 'tanggal_lahir' => '2019-08-22', 'nama' => 'Fatimah Azzahra', 'asal_sekolah' => 'TKIT Al Ishlah Kertek', 'tujuan' => 'SD'],
            
            // TKIT Insan Mulia ke SDIT
            ['nomor_induk' => '2021101', 'tanggal_lahir' => '2019-04-12', 'nama' => 'Muhammad Farhan', 'asal_sekolah' => 'TKIT Insan Mulia Wonosobo', 'tujuan' => 'SD'],
            ['nomor_induk' => '2021102', 'tanggal_lahir' => '2019-07-25', 'nama' => 'Siti Khadijah', 'asal_sekolah' => 'TKIT Insan Mulia Wonosobo', 'tujuan' => 'SD'],
            ['nomor_induk' => '2021103', 'tanggal_lahir' => '2019-11-08', 'nama' => 'Abdullah Azzam', 'asal_sekolah' => 'TKIT Insan Mulia Wonosobo', 'tujuan' => 'SD'],
            ['nomor_induk' => '2021104', 'tanggal_lahir' => '2019-02-19', 'nama' => 'Maryam Humaira', 'asal_sekolah' => 'TKIT Insan Mulia Wonosobo', 'tujuan' => 'SD'],
            ['nomor_induk' => '2021105', 'tanggal_lahir' => '2019-09-30', 'nama' => 'Khalid Ibrahim', 'asal_sekolah' => 'TKIT Insan Mulia Wonosobo', 'tujuan' => 'SD'],
            
            // SDIT ke SMPIT
            ['nomor_induk' => '2019001', 'tanggal_lahir' => '2013-05-14', 'nama' => 'Ahmad Fadhil Ramadhan', 'asal_sekolah' => 'SDIT Insan Mulia Wonosobo', 'tujuan' => 'SMP'],
            ['nomor_induk' => '2019002', 'tanggal_lahir' => '2013-08-02', 'nama' => 'Siti Nur Aisyah', 'asal_sekolah' => 'SDIT Insan Mulia Wonosobo', 'tujuan' => 'SMP'],
            ['nomor_induk' => '2019003', 'tanggal_lahir' => '2013-11-21', 'nama' => 'Muhammad Rizky Pratama', 'asal_sekolah' => 'SDIT Insan Mulia Wonosobo', 'tujuan' => 'SMP'],
            ['nomor_induk' => '2019004', 'tanggal_lahir' => '2013-03-10', 'nama' => 'Khadijah Salsabila', 'asal_sekolah' => 'SDIT Insan Mulia Wonosobo', 'tujuan' => 'SMP'],
            ['nomor_induk' => '2019005', 'tanggal_lahir' => '2013-06-28', 'nama' => 'Umar Faruq', 'asal_sekolah' => 'SDIT Insan Mulia Wonosobo', 'tujuan' => 'SMP'],
            ['nomor_induk' => '2019006', 'tanggal_lahir' => '2013-09-15', 'nama' => 'Aisyah Kamila', 'asal_sekolah' => 'SDIT Insan Mulia Wonosobo', 'tujuan' => 'SMP'],
            ['nomor_induk' => '2019007', 'tanggal_lahir' => '2013-12-05', 'nama' => 'Hamzah Firdaus', 'asal_sekolah' => 'SDIT Insan Mulia Wonosobo', 'tujuan' => 'SMP'],
            ['nomor_induk' => '2019008', 'tanggal_lahir' => '2013-04-18', 'nama' => 'Zainab Nur Azizah', 'asal_sekolah' => 'SDIT Insan Mulia Wonosobo', 'tujuan' => 'SMP'],
            ['nomor_induk' => '2019009', 'tanggal_lahir' => '2013-07-22', 'nama' => 'Ali Mustofa', 'asal_sekolah' => 'SDIT Insan Mulia Wonosobo', 'tujuan' => 'SMP'],
            ['nomor_induk' => '2019010', 'tanggal_lahir' => '2013-10-11', 'nama' => 'Fatimah Nurhaliza', 'asal_sekolah' => 'SDIT Insan Mulia Wonosobo', 'tujuan' => 'SMP'],
        ];
    }

    public static function requirements(): array
    {
        return [
            'TK' => [
                ['label' => 'Kartu Keluarga', 'keterangan' => 'Foto atau scan jelas, seluruh bagian terlihat'],
                ['label' => 'Akta Kelahiran', 'keterangan' => 'Foto atau scan jelas, dapat dibaca dengan baik'],
                ['label' => 'Pas Foto', 'keterangan' => 'Ukuran 3x4, latar belakang merah atau biru']
            ],
            'SD' => [
                ['label' => 'Kartu Keluarga', 'keterangan' => 'Foto atau scan jelas, seluruh bagian terlihat'],
                ['label' => 'Akta Kelahiran', 'keterangan' => 'Foto atau scan jelas, dapat dibaca dengan baik'],
                ['label' => 'Pas Foto', 'keterangan' => 'Ukuran 3x4, latar belakang merah atau biru']
            ],
            'SMP' => [
                ['label' => 'Kartu Keluarga', 'keterangan' => 'Foto atau scan jelas, seluruh bagian terlihat'],
                ['label' => 'Akta Kelahiran', 'keterangan' => 'Foto atau scan jelas, dapat dibaca dengan baik'],
                ['label' => 'Pas Foto', 'keterangan' => 'Ukuran 3x4, latar belakang merah atau biru'],
                ['label' => 'Surat Keterangan Lulus SD', 'keterangan' => 'Dari sekolah asal, asli atau fotokopi']
            ]
        ];
    }

    public static function pendaftar(): array
    {
        return [
            // TKK
            [
                'nomor_peserta' => 'TKK-2026-0001',
                'school_code' => 'TKK',
                'jenis' => 'Baru',
                'nama' => 'Zahra Amira Putri',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Wonosobo',
                'tanggal_lahir' => '2022-03-15',
                'status' => 'diterima',
                'tanggal_daftar' => '2026-01-05',
                'pengumuman_terkirim' => true
            ],
            [
                'nomor_peserta' => 'TKK-2026-0002',
                'school_code' => 'TKK',
                'jenis' => 'Baru',
                'nama' => 'Muhammad Akbar',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Wonosobo',
                'tanggal_lahir' => '2022-05-20',
                'status' => 'berkas_diverifikasi',
                'tanggal_daftar' => '2026-01-08',
                'pengumuman_terkirim' => false
            ],
            [
                'nomor_peserta' => 'TKK-2026-0003',
                'school_code' => 'TKK',
                'jenis' => 'Baru',
                'nama' => 'Aliyah Syifa',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Wonosobo',
                'tanggal_lahir' => '2022-07-10',
                'status' => 'terdaftar',
                'tanggal_daftar' => '2026-01-12',
                'pengumuman_terkirim' => false
            ],
            
            // TKI
            [
                'nomor_peserta' => 'TKI-2026-0001',
                'school_code' => 'TKI',
                'jenis' => 'Baru',
                'nama' => 'Fahri Hidayat',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Wonosobo',
                'tanggal_lahir' => '2022-02-18',
                'status' => 'diterima',
                'tanggal_daftar' => '2026-01-03',
                'pengumuman_terkirim' => true
            ],
            [
                'nomor_peserta' => 'TKI-2026-0002',
                'school_code' => 'TKI',
                'jenis' => 'Baru',
                'nama' => 'Salsabila Azzahra',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Wonosobo',
                'tanggal_lahir' => '2022-04-22',
                'status' => 'ditolak',
                'tanggal_daftar' => '2026-01-06',
                'pengumuman_terkirim' => true
            ],
            
            // SD
            [
                'nomor_peserta' => 'SD-2026-0001',
                'school_code' => 'SD',
                'jenis' => 'Lanjutan',
                'nama' => 'Aisyah Zahra Putri',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Wonosobo',
                'tanggal_lahir' => '2019-03-09',
                'status' => 'diterima',
                'tanggal_daftar' => '2026-01-02',
                'pengumuman_terkirim' => true
            ],
            [
                'nomor_peserta' => 'SD-2026-0002',
                'school_code' => 'SD',
                'jenis' => 'Baru',
                'nama' => 'Rafif Ramadhan',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Wonosobo',
                'tanggal_lahir' => '2019-06-25',
                'status' => 'berkas_diverifikasi',
                'tanggal_daftar' => '2026-01-10',
                'pengumuman_terkirim' => false
            ],
            [
                'nomor_peserta' => 'SD-2026-0003',
                'school_code' => 'SD',
                'jenis' => 'Lanjutan',
                'nama' => 'Muhammad Fatih Alfarizi',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Wonosobo',
                'tanggal_lahir' => '2019-06-17',
                'status' => 'terdaftar',
                'tanggal_daftar' => '2026-01-15',
                'pengumuman_terkirim' => false
            ],
            [
                'nomor_peserta' => 'SD-2026-0004',
                'school_code' => 'SD',
                'jenis' => 'Baru',
                'nama' => 'Amira Zahra',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Wonosobo',
                'tanggal_lahir' => '2019-09-12',
                'status' => 'diterima',
                'tanggal_daftar' => '2026-01-18',
                'pengumuman_terkirim' => false
            ],
            
            // SMP
            [
                'nomor_peserta' => 'SMP-2026-0001',
                'school_code' => 'SMP',
                'jenis' => 'Lanjutan',
                'nama' => 'Ahmad Fadhil Ramadhan',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Wonosobo',
                'tanggal_lahir' => '2013-05-14',
                'status' => 'diterima',
                'tanggal_daftar' => '2026-01-04',
                'pengumuman_terkirim' => true
            ],
            [
                'nomor_peserta' => 'SMP-2026-0002',
                'school_code' => 'SMP',
                'jenis' => 'Lanjutan',
                'nama' => 'Siti Nur Aisyah',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Wonosobo',
                'tanggal_lahir' => '2013-08-02',
                'status' => 'berkas_diverifikasi',
                'tanggal_daftar' => '2026-01-07',
                'pengumuman_terkirim' => false
            ],
            [
                'nomor_peserta' => 'SMP-2026-0003',
                'school_code' => 'SMP',
                'jenis' => 'Baru',
                'nama' => 'Farhan Maulana',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Wonosobo',
                'tanggal_lahir' => '2013-11-05',
                'status' => 'terdaftar',
                'tanggal_daftar' => '2026-01-11',
                'pengumuman_terkirim' => false
            ],
            [
                'nomor_peserta' => 'SMP-2026-0004',
                'school_code' => 'SMP',
                'jenis' => 'Baru',
                'nama' => 'Laila Maghfira',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Wonosobo',
                'tanggal_lahir' => '2013-02-28',
                'status' => 'ditolak',
                'tanggal_daftar' => '2026-01-14',
                'pengumuman_terkirim' => true
            ],
            [
                'nomor_peserta' => 'SMP-2026-0005',
                'school_code' => 'SMP',
                'jenis' => 'Lanjutan',
                'nama' => 'Muhammad Rizky Pratama',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Wonosobo',
                'tanggal_lahir' => '2013-11-21',
                'status' => 'berkas_diverifikasi',
                'tanggal_daftar' => '2026-01-16',
                'pengumuman_terkirim' => false
            ]
        ];
    }

    public static function alumniForJenjang(string $jenjang): array
    {
        return array_values(array_filter(
            self::alumni(),
            fn (array $alumni) => $alumni['tujuan'] === $jenjang
        ));
    }

    public static function allPendaftar(): array
    {
        return array_merge(self::pendaftar(), session('new_pendaftar', []));
    }

    public static function findPendaftar(string $nomorPeserta): ?array
    {
        foreach (self::allPendaftar() as $pendaftar) {
            if ($pendaftar['nomor_peserta'] === $nomorPeserta) {
                return $pendaftar;
            }
        }

        return null;
    }

    public static function nextParticipantNumber(string $schoolCode): string
    {
        $max = 0;

        foreach (self::allPendaftar() as $pendaftar) {
            if ($pendaftar['school_code'] !== $schoolCode) {
                continue;
            }

            if (preg_match('/-(\d+)$/', $pendaftar['nomor_peserta'], $matches)) {
                $max = max($max, (int) $matches[1]);
            }
        }

        return sprintf('%s-2026-%04d', $schoolCode, $max + 1);
    }

    public static function accounts(): array
    {
        return [
            'TKK' => [
                ['nama' => 'Umi Latifah', 'email' => 'umi@alishlah.sch.id', 'aktif' => true],
                ['nama' => 'Nur Hidayah', 'email' => 'nur@alishlah.sch.id', 'aktif' => true],
                ['nama' => 'Siti Aminah', 'email' => 'aminah@alishlah.sch.id', 'aktif' => false],
            ],
            'TKI' => [
                ['nama' => 'Rina Wulandari', 'email' => 'rina@insanmulia.sch.id', 'aktif' => true],
                ['nama' => 'Dewi Sartika', 'email' => 'dewi@insanmulia.sch.id', 'aktif' => true],
            ],
            'SD' => [
                ['nama' => 'Agus Setiawan', 'email' => 'agus@insanmulia.sch.id', 'aktif' => true],
                ['nama' => 'Lestari Handayani', 'email' => 'lestari@insanmulia.sch.id', 'aktif' => true],
                ['nama' => 'Bambang Sutrisno', 'email' => 'bambang@insanmulia.sch.id', 'aktif' => true],
            ],
            'SMP' => [
                ['nama' => 'Hendra Wijaya', 'email' => 'hendra@insanmulia.sch.id', 'aktif' => true],
                ['nama' => 'Maya Kusuma', 'email' => 'maya@insanmulia.sch.id', 'aktif' => true],
            ],
        ];
    }

    public static function periods(): array
    {
        return [
            ['nama' => 'PPDB 2026/2027 - Gelombang 1', 'dibuka' => '1 Januari 2026', 'ditutup' => '28 Februari 2026', 'status' => 'Aktif'],
            ['nama' => 'PPDB 2026/2027 - Gelombang 2', 'dibuka' => '1 Maret 2026', 'ditutup' => '31 Maret 2026', 'status' => 'Menyusul'],
            ['nama' => 'PPDB 2025/2026', 'dibuka' => '1 Januari 2025', 'ditutup' => '31 Maret 2025', 'status' => 'Selesai'],
        ];
    }

    public static function accountsFor(string $schoolCode): array
    {
        return self::accounts()[$schoolCode] ?? [];
    }

    public static function yayasanAccounts(): array
    {
        return [
            ['nama' => 'H. Muhammad Yusuf', 'email' => 'yusuf@alishlah.sch.id', 'sekolah' => null, 'nama_sekolah' => 'Yayasan', 'aktif' => true],
            ['nama' => 'Hj. Siti Maryam', 'email' => 'maryam@alishlah.sch.id', 'sekolah' => null, 'nama_sekolah' => 'Yayasan', 'aktif' => true],
            ['nama' => 'Abdul Rahman', 'email' => 'rahman@alishlah.sch.id', 'sekolah' => null, 'nama_sekolah' => 'Yayasan', 'aktif' => false],
        ];
    }

    public static function settings(): array
    {
        return [
            'nama_sistem' => 'PPDB Online Yayasan Al-Ishlah Insan Mulia',
            'tahun_ajaran' => '2026/2027',
        ];
    }

    public static function getSchoolBySlug(string $slug): ?array
    {
        $schools = self::schools();
        foreach ($schools as $school) {
            if ($school['slug'] === $slug) {
                return $school;
            }
        }
        return null;
    }

    public static function getSchoolByCode(string $code): ?array
    {
        $schools = self::schools();
        foreach ($schools as $school) {
            if ($school['code'] === $code) {
                return $school;
            }
        }
        return null;
    }

    public static function isRegistrationOpen(array $school): bool
    {
        $now = now();
        $opens = \Carbon\Carbon::parse($school['opens_at']);
        $closes = \Carbon\Carbon::parse($school['closes_at']);
        
        return $now->gte($opens) && $now->lte($closes);
    }
}
