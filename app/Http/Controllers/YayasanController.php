<?php

namespace App\Http\Controllers;

use App\Support\DemoData;
use App\Support\DemoStore;
use Illuminate\Http\Request;

class YayasanController extends Controller
{
    public function index(Request $request)
    {
        $schools = DemoData::schools();
        $selected = $request->query('sekolah');

        $rekap = [];

        foreach ($schools as $school) {
            $items = DemoStore::pendaftar($school['code']);

            $rekap[] = [
                'school' => $school,
                'total' => count($items),
                'diterima' => count(array_filter($items, fn ($p) => $p['status'] === 'diterima')),
                'ditolak' => count(array_filter($items, fn ($p) => $p['status'] === 'ditolak')),
                'lanjutan' => count(array_filter($items, fn ($p) => $p['jenis'] === 'Lanjutan')),
                'baru' => count(array_filter($items, fn ($p) => $p['jenis'] === 'Baru')),
            ];
        }

        $pendaftar = DemoStore::pendaftar($selected ?: null);

        if ($selected && !DemoData::getSchoolByCode($selected)) {
            $selected = null;
        }

        return view('yayasan.index', [
            'rekap' => $rekap,
            'pendaftar' => $pendaftar,
            'schools' => $schools,
            'selected' => $selected,
            'totals' => [
                'total' => array_sum(array_column($rekap, 'total')),
                'diterima' => array_sum(array_column($rekap, 'diterima')),
                'ditolak' => array_sum(array_column($rekap, 'ditolak')),
                'lanjutan' => array_sum(array_column($rekap, 'lanjutan')),
            ],
        ]);
    }
}
