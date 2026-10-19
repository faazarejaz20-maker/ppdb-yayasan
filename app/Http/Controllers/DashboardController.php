<?php

namespace App\Http\Controllers;

use App\Support\DemoData;
use App\Support\DemoStore;
use App\Support\RegistrationService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $schoolCode = session('user_school_code');
        $school = DemoData::getSchoolByCode($schoolCode);

        if (!$school) {
            abort(403, 'Akun ini tidak terhubung ke sekolah.');
        }

        $all = DemoStore::pendaftar($schoolCode);

        $stats = [
            'total' => count($all),
            'menunggu' => count(array_filter($all, fn ($p) => in_array($p['status'], ['terdaftar', 'berkas_diverifikasi'], true))),
            'diterima' => count(array_filter($all, fn ($p) => $p['status'] === 'diterima')),
            'ditolak' => count(array_filter($all, fn ($p) => $p['status'] === 'ditolak')),
        ];

        $filtered = $this->applyFilters($all, $request);
        $page = max(1, (int) $request->query('page', 1));
        $perPage = 8;
        $total = count($filtered);
        $lastPage = max(1, (int) ceil($total / $perPage));
        $page = min($page, $lastPage);

        $pendaftar = array_slice($filtered, ($page - 1) * $perPage, $perPage);

        return view('dashboard.index', [
            'school' => $school,
            'stats' => $stats,
            'pendaftar' => $pendaftar,
            'filters' => $request->only(['q', 'status', 'jenis', 'belum_dikirim']),
            'pagination' => [
                'page' => $page,
                'lastPage' => $lastPage,
                'total' => $total,
                'perPage' => $perPage,
            ],
        ]);
    }

    public function show(string $nomorPeserta)
    {
        [$school, $pendaftar] = $this->resolvePendaftar($nomorPeserta);

        return view('dashboard.show', [
            'school' => $school,
            'pendaftar' => $pendaftar,
            'berkas' => DemoStore::berkas($pendaftar),
            'riwayat' => DemoStore::riwayat($nomorPeserta),
        ]);
    }

    public function updateStatus(Request $request, string $nomorPeserta)
    {
        [$school, $pendaftar] = $this->resolvePendaftar($nomorPeserta);

        $validated = $request->validate([
            'status' => 'required|in:diterima,ditolak,berkas_diverifikasi',
        ]);

        DemoStore::updateStatus($nomorPeserta, $validated['status']);
        DemoStore::addRiwayat(
            $nomorPeserta,
            'Status diubah menjadi ' . DemoStore::statusLabels()[$validated['status']],
            'Oleh ' . $this->actorLabel()
        );

        return back()->with('success', 'Status pendaftar berhasil diperbarui.');
    }

    public function verifyBerkas(Request $request, string $nomorPeserta)
    {
        [$school, $pendaftar] = $this->resolvePendaftar($nomorPeserta);

        $validated = $request->validate([
            'index' => 'required|integer|min:0',
            'status' => 'required|in:valid,tidak_valid,menunggu',
            'catatan' => 'nullable|string|max:200',
        ]);

        DemoStore::setBerkas($nomorPeserta, (int) $validated['index'], $validated['status'], $validated['catatan'] ?? null);
        DemoStore::addRiwayat(
            $nomorPeserta,
            'Berkas diverifikasi: ' . $validated['status'],
            'Oleh ' . $this->actorLabel()
        );

        return back()->with('success', 'Status berkas berhasil disimpan.');
    }

    public function markAnnouncement(string $nomorPeserta)
    {
        [$school, $pendaftar] = $this->resolvePendaftar($nomorPeserta);

        DemoStore::markAnnouncement($nomorPeserta);
        DemoStore::addRiwayat($nomorPeserta, 'Pengumuman ditandai terkirim', 'Oleh ' . $this->actorLabel());

        return back()->with('success', 'Pendaftar ditandai sudah dikirim pengumuman.');
    }

    public function create()
    {
        $schoolCode = session('user_school_code');
        $school = DemoData::getSchoolByCode($schoolCode);

        if (!$school) {
            abort(403, 'Akun ini tidak terhubung ke sekolah.');
        }

        $requirements = DemoData::requirements()[$school['jenjang']];
        $alumni = $school['jenjang'] === 'TK' ? [] : DemoData::alumniForJenjang($school['jenjang']);

        return view('dashboard.create', compact('school', 'requirements', 'alumni'));
    }

    public function store(Request $request)
    {
        $schoolCode = session('user_school_code');
        $school = DemoData::getSchoolByCode($schoolCode);

        if (!$school) {
            abort(403, 'Akun ini tidak terhubung ke sekolah.');
        }

        $validated = $request->validate(RegistrationService::rules($school));
        $nomorPeserta = RegistrationService::create($validated, $school);

        DemoStore::addRiwayat($nomorPeserta, 'Pendaftaran dibuat oleh panitia', $this->actorLabel());

        return redirect('/dashboard/' . $nomorPeserta)->with('success', 'Pendaftar baru berhasil ditambahkan.');
    }

    public function reset()
    {
        DemoStore::reset();

        return back()->with('success', 'Data demo berhasil direset ke kondisi awal.');
    }

    public function accounts()
    {
        $school = DemoData::getSchoolByCode(session('user_school_code'));

        if (!$school) {
            abort(403, 'Akun ini tidak terhubung ke sekolah.');
        }

        $accounts = DemoData::accountsFor($school['code']);

        return view('dashboard.accounts', compact('school', 'accounts'));
    }

    public function periods()
    {
        $school = DemoData::getSchoolByCode(session('user_school_code'));

        if (!$school) {
            abort(403, 'Akun ini tidak terhubung ke sekolah.');
        }

        $periods = DemoData::periods();

        return view('dashboard.periods', compact('school', 'periods'));
    }

    public function whatsapp(string $nomorPeserta)
    {
        [$school, $pendaftar] = $this->resolvePendaftar($nomorPeserta);

        $status = DemoStore::statusLabels()[$pendaftar['status']];
        $message = "Assalamu'alaikum Bapak/Ibu. Pendaftaran dengan nomor peserta {$pendaftar['nomor_peserta']} "
            . "atas nama {$pendaftar['nama']} telah diproses. Hasil: " . strtoupper($status) . '. '
            . 'Informasi lebih lanjut akan disampaikan oleh pihak sekolah.';

        return response()->json([
            'nomor' => $pendaftar['whatsapp'] ?? '',
            'pesan' => $message,
            'url' => 'https://wa.me/' . ($pendaftar['whatsapp'] ?? '') . '?text=' . rawurlencode($message),
        ]);
    }

    private function resolvePendaftar(string $nomorPeserta): array
    {
        $schoolCode = session('user_school_code');
        $pendaftar = DemoStore::find($nomorPeserta);

        if (!$pendaftar) {
            abort(404);
        }

        if ($pendaftar['school_code'] !== $schoolCode) {
            abort(403, 'Anda tidak memiliki akses ke pendaftar sekolah lain.');
        }

        $school = DemoData::getSchoolByCode($pendaftar['school_code']);

        return [$school, $pendaftar];
    }

    private function actorLabel(): string
    {
        return str_replace('_', ' ', (string) session('user_role')) . ' ' . (string) session('user_school_code');
    }

    private function applyFilters(array $items, Request $request): array
    {
        $q = trim((string) $request->query('q', ''));
        $status = $request->query('status');
        $jenis = $request->query('jenis');
        $belumDikirim = $request->boolean('belum_dikirim');

        return array_values(array_filter($items, function (array $p) use ($q, $status, $jenis, $belumDikirim) {
            if ($q !== '' && stripos($p['nama'], $q) === false && stripos($p['nomor_peserta'], $q) === false) {
                return false;
            }

            if ($status && $p['status'] !== $status) {
                return false;
            }

            if ($jenis && $p['jenis'] !== $jenis) {
                return false;
            }

            if ($belumDikirim && !empty($p['pengumuman_terkirim'])) {
                return false;
            }

            return true;
        }));
    }
}
