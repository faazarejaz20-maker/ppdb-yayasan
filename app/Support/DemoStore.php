<?php

namespace App\Support;

class DemoStore
{
    private const STATUS_KEY = 'pendaftar_status';
    private const BERKAS_KEY = 'berkas_status';
    private const PENGUMUMAN_KEY = 'pengumuman_terkirim';
    private const RIWAYAT_KEY = 'riwayat_pendaftar';

    public static function statusLabels(): array
    {
        return [
            'terdaftar' => 'Terdaftar',
            'berkas_diverifikasi' => 'Berkas Diverifikasi',
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
        ];
    }

    public static function pendaftar(?string $schoolCode = null): array
    {
        $overrides = session(self::STATUS_KEY, []);
        $sent = session(self::PENGUMUMAN_KEY, []);

        $items = array_map(function (array $pendaftar) use ($overrides, $sent) {
            $nomor = $pendaftar['nomor_peserta'];

            $pendaftar = array_merge(self::seedDefaults($pendaftar), $pendaftar);
            $pendaftar['whatsapp'] = $pendaftar['whatsapp'] ?? self::defaultWhatsapp($pendaftar['school_code']);

            if (isset($overrides[$nomor])) {
                $pendaftar['status'] = $overrides[$nomor];
            }

            if (isset($sent[$nomor])) {
                $pendaftar['pengumuman_terkirim'] = (bool) $sent[$nomor];
            }

            return $pendaftar;
        }, DemoData::allPendaftar());

        if ($schoolCode !== null) {
            $items = array_values(array_filter(
                $items,
                fn (array $pendaftar) => $pendaftar['school_code'] === $schoolCode
            ));
        }

        usort($items, function (array $a, array $b) {
            return [$b['tanggal_daftar'], $b['nomor_peserta']] <=> [$a['tanggal_daftar'], $a['nomor_peserta']];
        });

        return $items;
    }

    public static function find(string $nomorPeserta): ?array
    {
        foreach (self::pendaftar() as $pendaftar) {
            if ($pendaftar['nomor_peserta'] === $nomorPeserta) {
                return $pendaftar;
            }
        }

        return null;
    }

    /**
     * Data pelengkap untuk pendaftar contoh yang di seed tanpa detail orang tua.
     */
    private static function seedDefaults(array $pendaftar): array
    {
        $profiles = [
            ['ayah' => 'Sutrisno Hadi', 'ibu' => 'Sri Wahyuni', 'kerja' => 'Karyawan Swasta', 'alamat' => 'Jl. Diponegoro No. 12, Wonosobo'],
            ['ayah' => 'Bambang Setiawan', 'ibu' => 'Siti Aminah', 'kerja' => 'Wiraswasta', 'alamat' => 'Jl. Ahmad Yani No. 45, Wonosobo'],
            ['ayah' => 'Agus Prasetyo', 'ibu' => 'Nur Hidayah', 'kerja' => 'Guru', 'alamat' => 'Jl. Kartini No. 8, Wonosobo'],
            ['ayah' => 'Hendro Wibowo', 'ibu' => 'Dewi Sartika', 'kerja' => 'Petani', 'alamat' => 'Desa Kertek, Wonosobo'],
            ['ayah' => 'Fajar Nugroho', 'ibu' => 'Umi Latifah', 'kerja' => 'Pedagang', 'alamat' => 'Jl. Pasar Induk No. 3, Wonosobo'],
            ['ayah' => 'Imam Syafii', 'ibu' => 'Lestari Handayani', 'kerja' => 'PNS', 'alamat' => 'Jl. Soekarno No. 21, Wonosobo'],
            ['ayah' => 'Wahyu Saputra', 'ibu' => 'Rina Wulandari', 'kerja' => 'Karyawan Swasta', 'alamat' => 'Jl. Merdeka No. 17, Wonosobo'],
            ['ayah' => 'Slamet Riyadi', 'ibu' => 'Yuni Astuti', 'kerja' => 'Buruh', 'alamat' => 'Jl. Pemuda No. 9, Wonosobo'],
        ];

        $hash = crc32($pendaftar['nomor_peserta']);
        $profile = $profiles[$hash % count($profiles)];
        $jenjang = DemoData::getSchoolByCode($pendaftar['school_code'])['jenjang'] ?? 'SD';

        return [
            'agama' => 'Islam',
            'anak_ke' => 1 + ($hash % 3),
            'nisn' => $jenjang === 'TK' ? null : '00' . str_pad((string) ($hash % 10000000), 8, '0', STR_PAD_LEFT),
            'nama_ayah' => $profile['ayah'],
            'nama_ibu' => $profile['ibu'],
            'pekerjaan' => $profile['kerja'],
            'email' => strtolower(explode(' ', $profile['ayah'])[0]) . ($hash % 90 + 10) . '@contoh.id',
            'alamat' => $profile['alamat'],
            'asal_sekolah' => $jenjang === 'TK'
                ? null
                : ($jenjang === 'SMP' ? 'SDIT Insan Mulia Wonosobo' : 'TK Pertiwi Wonosobo'),
        ];
    }

    public static function updateStatus(string $nomorPeserta, string $status): void
    {
        $overrides = session(self::STATUS_KEY, []);
        $overrides[$nomorPeserta] = $status;
        session([self::STATUS_KEY => $overrides]);
    }

    public static function markAnnouncement(string $nomorPeserta): void
    {
        $sent = session(self::PENGUMUMAN_KEY, []);
        $sent[$nomorPeserta] = true;
        session([self::PENGUMUMAN_KEY => $sent]);
    }

    /**
     * Berkas per pendaftar, digabung dengan status verifikasi dari session.
     */
    public static function berkas(array $pendaftar): array
    {
        $school = DemoData::getSchoolByCode($pendaftar['school_code']);
        $requirements = DemoData::requirements()[$school['jenjang']] ?? [];
        $saved = session(self::BERKAS_KEY, [])[$pendaftar['nomor_peserta']] ?? [];

        $items = [];

        foreach ($requirements as $index => $requirement) {
            $state = $saved[$index] ?? [];

            $items[] = [
                'index' => $index,
                'label' => $requirement['label'],
                'keterangan' => $requirement['keterangan'],
                'status' => $state['status'] ?? 'menunggu',
                'catatan' => $state['catatan'] ?? null,
            ];
        }

        return $items;
    }

    public static function setBerkas(string $nomorPeserta, int $index, string $status, ?string $catatan = null): void
    {
        $saved = session(self::BERKAS_KEY, []);
        $saved[$nomorPeserta][$index] = [
            'status' => $status,
            'catatan' => $catatan,
        ];
        session([self::BERKAS_KEY => $saved]);
    }

    public static function riwayat(string $nomorPeserta): array
    {
        $pendaftar = self::find($nomorPeserta);
        $items = [];

        if ($pendaftar) {
            $items[] = [
                'waktu' => $pendaftar['tanggal_daftar'],
                'aksi' => 'Pendaftaran dibuat',
                'catatan' => 'Jenis ' . $pendaftar['jenis'],
            ];
        }

        foreach (session(self::RIWAYAT_KEY, [])[$nomorPeserta] ?? [] as $entry) {
            $items[] = $entry;
        }

        return $items;
    }

    public static function addRiwayat(string $nomorPeserta, string $aksi, ?string $catatan = null): void
    {
        $riwayat = session(self::RIWAYAT_KEY, []);
        $riwayat[$nomorPeserta][] = [
            'waktu' => now()->toDateTimeString(),
            'aksi' => $aksi,
            'catatan' => $catatan,
        ];
        session([self::RIWAYAT_KEY => $riwayat]);
    }

    public static function defaultWhatsapp(string $schoolCode): string
    {
        return match ($schoolCode) {
            'TKK' => '6281234567890',
            'TKI' => '6281234567891',
            'SD' => '6281234567892',
            'SMP' => '6281234567893',
            default => '6281234567890',
        };
    }

    /**
     * 628456789012 -> 0812-3456-7890 (hanya untuk tampilan).
     */
    public static function localWhatsapp(?string $number): string
    {
        if (!$number) {
            return '-';
        }

        $digits = preg_replace('/[^0-9]/', '', $number);

        if (str_starts_with($digits, '62')) {
            $digits = '0' . substr($digits, 2);
        }

        if (strlen($digits) < 10) {
            return $digits;
        }

        return substr($digits, 0, 4) . '-' . substr($digits, 4, 4) . '-' . substr($digits, 8);
    }

    public static function schools(): array
    {
        $active = session('demo_school_active', []);
        $schools = DemoData::schools();

        return array_map(function (array $school) use ($active) {
            $school['aktif'] = $active[$school['code']] ?? true;
            $school['admin'] = self::schoolAdminName($school['code']);

            return $school;
        }, $schools);
    }

    public static function toggleSchool(string $code): void
    {
        $active = session('demo_school_active', []);
        $current = $active[$code] ?? true;
        $active[$code] = !$current;
        session(['demo_school_active' => $active]);
    }

    public static function schoolAdminName(string $code): string
    {
        foreach (DemoData::accountsFor($code) as $account) {
            if ($account['aktif']) {
                return $account['nama'];
            }
        }

        return '-';
    }

    /**
     * Akun demo. Scope: "admin" (admin sekolah) atau "yayasan".
     */
    public static function accounts(string $scope): array
    {
        $key = 'demo_accounts_' . $scope;

        if (!session()->has($key)) {
            $base = $scope === 'admin' ? self::baseAdminAccounts() : DemoData::yayasanAccounts();
            session([$key => $base]);
        }

        return session($key, []);
    }

    public static function addAccount(string $scope, array $data): void
    {
        $accounts = self::accounts($scope);
        $accounts[] = [
            'nama' => $data['nama'],
            'email' => $data['email'],
            'sekolah' => $data['sekolah'] ?? null,
            'nama_sekolah' => $data['nama_sekolah'] ?? null,
            'aktif' => true,
        ];
        session(['demo_accounts_' . $scope => $accounts]);
    }

    public static function toggleAccount(string $scope, string $email): void
    {
        $accounts = self::accounts($scope);

        foreach ($accounts as $index => $account) {
            if ($account['email'] === $email) {
                $accounts[$index]['aktif'] = !$account['aktif'];
            }
        }

        session(['demo_accounts_' . $scope => $accounts]);
    }

    public static function resetPassword(string $scope, string $email): string
    {
        $password = 'Demo' . random_int(1000, 9999);
        $passwords = session('demo_temp_password', []);
        $passwords[$scope . ':' . $email] = $password;
        session(['demo_temp_password' => $passwords]);

        return $password;
    }

    public static function tempPassword(string $scope, string $email): ?string
    {
        return session('demo_temp_password', [])[$scope . ':' . $email] ?? null;
    }

    private static function baseAdminAccounts(): array
    {
        $accounts = [];

        foreach (DemoData::accounts() as $code => $items) {
            $school = DemoData::getSchoolByCode($code);

            foreach ($items as $item) {
                $accounts[] = [
                    'nama' => $item['nama'],
                    'email' => $item['email'],
                    'sekolah' => $code,
                    'nama_sekolah' => $school['name'] ?? $code,
                    'aktif' => $item['aktif'],
                ];
            }
        }

        return $accounts;
    }

    public static function reset(): void
    {
        session()->forget([
            'new_pendaftar',
            self::STATUS_KEY,
            self::BERKAS_KEY,
            self::PENGUMUMAN_KEY,
            self::RIWAYAT_KEY,
            'demo_school_active',
            'demo_accounts_admin',
            'demo_accounts_yayasan',
            'demo_temp_password',
        ]);
    }
}
