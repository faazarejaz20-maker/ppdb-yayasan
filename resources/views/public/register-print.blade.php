<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pendaftaran {{ $pendaftar['nomor_peserta'] }}</title>
    @vite(['resources/css/app.css'])
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: #fff !important; }
            .print-card { box-shadow: none !important; border: 1px solid #d1d5db !important; }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="max-w-2xl mx-auto px-4 py-8">
        <div class="no-print mb-5 flex items-center justify-between">
            <a href="/pendaftaran/sukses/{{ $pendaftar['nomor_peserta'] }}" class="text-sm text-gray-600 hover:text-gray-800">&larr; Kembali</a>
            <button onclick="window.print()" class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-4 py-2 rounded-lg">
                Cetak
            </button>
        </div>

        <div class="print-card bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
            <div class="flex items-center gap-4 border-b border-gray-200 pb-5 mb-5">
                <div class="w-14 h-14 rounded-full flex items-center justify-center text-white font-bold text-lg shrink-0"
                     style="background-color: {{ $school['color'] }}">
                    {{ substr($school['code'], 0, 2) }}
                </div>
                <div>
                    <h1 class="text-lg font-bold text-gray-800 leading-tight">{{ $school['name'] }}</h1>
                    <p class="text-xs text-gray-500">{{ $school['address'] }}</p>
                </div>
            </div>

            <div class="text-center mb-6">
                <h2 class="text-base font-bold text-gray-800 uppercase tracking-wide">Bukti Pendaftaran PPDB</h2>
                <p class="text-xs text-gray-500">Tahun Ajaran 2026/2027</p>
            </div>

            <div class="bg-gray-50 rounded-lg p-4 mb-5 text-center">
                <p class="text-xs text-gray-500 mb-1">Nomor Peserta</p>
                <p class="text-xl font-bold tracking-wider text-gray-800">{{ $pendaftar['nomor_peserta'] }}</p>
            </div>

            <table class="w-full text-sm">
                <tbody class="divide-y divide-gray-100">
                    @php
                        $rows = [
                            'Nama Lengkap' => $pendaftar['nama'],
                            'Jenis Kelamin' => $pendaftar['jenis_kelamin'],
                            'Tempat / Tanggal Lahir' => $pendaftar['tempat_lahir'] . ', ' . \Carbon\Carbon::parse($pendaftar['tanggal_lahir'])->translatedFormat('d F Y'),
                            'Agama' => $pendaftar['agama'] ?? '-',
                            'Nama Ayah' => $pendaftar['nama_ayah'] ?? '-',
                            'Nama Ibu' => $pendaftar['nama_ibu'] ?? '-',
                            'WhatsApp' => \App\Support\DemoStore::localWhatsapp($pendaftar['whatsapp'] ?? null),
                            'Alamat' => $pendaftar['alamat'] ?? '-',
                            'Asal Sekolah' => $pendaftar['asal_sekolah'] ?? '-',
                            'Jenis Pendaftaran' => $pendaftar['jenis'],
                            'Tanggal Daftar' => \Carbon\Carbon::parse($pendaftar['tanggal_daftar'])->translatedFormat('d F Y'),
                        ];
                    @endphp
                    @foreach($rows as $label => $value)
                        <tr>
                            <td class="py-2 pr-4 text-gray-500 w-1/2 align-top">{{ $label }}</td>
                            <td class="py-2 font-semibold text-gray-800">{{ $value }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-6 pt-5 border-t border-gray-200 text-xs text-gray-500 leading-relaxed">
                <p>Simpan bukti ini sebagai tanda pendaftaran. Status pendaftaran dapat dicek di halaman Cek Pendaftaran
                    menggunakan nomor peserta dan tanggal lahir.</p>
                <p class="mt-2 font-semibold text-gray-600">Prototipe: data contoh</p>
            </div>
        </div>
    </div>
</body>
</html>
