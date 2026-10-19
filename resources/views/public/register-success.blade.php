@php
    $statusMap = [
        'terdaftar' => ['label' => 'Terdaftar', 'class' => 'bg-gray-100 text-gray-700'],
        'berkas_diverifikasi' => ['label' => 'Berkas Diverifikasi', 'class' => 'bg-blue-100 text-blue-700'],
        'diterima' => ['label' => 'Diterima', 'class' => 'bg-green-100 text-green-700'],
        'ditolak' => ['label' => 'Ditolak', 'class' => 'bg-red-100 text-red-700'],
    ];
    $status = $statusMap[$pendaftar['status']];
@endphp

<x-layouts.public title="Pendaftaran Berhasil">
    <section class="container mx-auto px-4 py-10 max-w-md">
        <div class="text-center mb-6">
            <div class="w-16 h-16 mx-auto rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h1 class="text-xl font-bold text-gray-800 mb-1">Pendaftaran Berhasil</h1>
            <p class="text-sm text-gray-500">Simpan nomor peserta berikut untuk cek status.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
            <p class="text-xs text-gray-400 mb-1">Nomor Peserta</p>
            <p class="text-2xl font-bold tracking-wider text-emerald-700 mb-3">{{ $pendaftar['nomor_peserta'] }}</p>
            <span class="inline-block text-xs font-semibold px-3 py-1 rounded-full {{ $status['class'] }}">{{ $status['label'] }}</span>

            <div class="mt-5 pt-5 border-t border-gray-100 text-left space-y-2 text-sm">
                <div class="flex justify-between gap-4">
                    <span class="text-gray-500">Nama</span>
                    <span class="font-semibold text-gray-800 text-right">{{ $pendaftar['nama'] }}</span>
                </div>
                <div class="flex justify-between gap-4">
                    <span class="text-gray-500">Sekolah</span>
                    <span class="font-semibold text-gray-800 text-right">{{ $school['name'] }}</span>
                </div>
                <div class="flex justify-between gap-4">
                    <span class="text-gray-500">Jenis</span>
                    <span class="font-semibold text-gray-800 text-right">{{ $pendaftar['jenis'] }}</span>
                </div>
            </div>

            @if($pendaftar['jenis'] === 'Lanjutan' && $pendaftar['school_code'] === 'SMP')
                <div class="mt-4 bg-amber-50 border border-amber-100 rounded-lg p-3 text-xs text-amber-800 text-left">
                    <span class="font-semibold">Uang gedung gratis</span> berlaku untuk lulusan SDIT yang melanjutkan ke SMPIT.
                </div>
            @endif
        </div>

        <div class="space-y-3 mt-5">
            <a href="/pendaftaran/cetak/{{ $pendaftar['nomor_peserta'] }}"
               class="block text-center bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold py-3 rounded-lg transition">
                Cetak Bukti Pendaftaran
            </a>
            <a href="/cek-pendaftaran"
               class="block text-center border border-gray-300 text-gray-700 text-sm font-semibold py-3 rounded-lg hover:bg-gray-50 transition">
                Cek Status Pendaftaran
            </a>
            <a href="/{{ $school['slug'] }}" class="block text-center text-xs text-gray-500 hover:text-gray-700 pt-1">
                &larr; Kembali ke halaman sekolah
            </a>
        </div>
    </section>
</x-layouts.public>
