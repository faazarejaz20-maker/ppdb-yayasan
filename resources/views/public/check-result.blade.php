<x-layouts.public title="Hasil Cek Pendaftaran">
    @php
        $statusMap = [
            'terdaftar' => ['label' => 'Terdaftar', 'class' => 'bg-gray-100 text-gray-700'],
            'berkas_diverifikasi' => ['label' => 'Berkas Diverifikasi', 'class' => 'bg-blue-100 text-blue-700'],
            'diterima' => ['label' => 'Diterima', 'class' => 'bg-green-100 text-green-700'],
            'ditolak' => ['label' => 'Ditolak', 'class' => 'bg-red-100 text-red-700'],
        ];
        $status = $statusMap[$pendaftar['status']];
        $school = \App\Support\DemoData::getSchoolByCode($pendaftar['school_code']);
    @endphp

    <section class="container mx-auto px-4 py-12 max-w-md">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 text-center border-b border-gray-100">
                <p class="text-xs text-gray-400 mb-1">Nomor Peserta</p>
                <p class="text-xl font-bold text-gray-800 tracking-wide">{{ $pendaftar['nomor_peserta'] }}</p>
                <span class="inline-block mt-3 text-xs font-semibold px-3 py-1 rounded-full {{ $status['class'] }}">
                    {{ $status['label'] }}
                </span>
            </div>
            <div class="p-6 space-y-3 text-sm">
                <div class="flex justify-between gap-4">
                    <span class="text-gray-500">Nama</span>
                    <span class="font-semibold text-gray-800 text-right">{{ $pendaftar['nama'] }}</span>
                </div>
                <div class="flex justify-between gap-4">
                    <span class="text-gray-500">Sekolah</span>
                    <span class="font-semibold text-gray-800 text-right">{{ $school['name'] ?? $pendaftar['school_code'] }}</span>
                </div>
                <div class="flex justify-between gap-4">
                    <span class="text-gray-500">Jenis</span>
                    <span class="font-semibold text-gray-800 text-right">{{ $pendaftar['jenis'] }}</span>
                </div>
                <div class="flex justify-between gap-4">
                    <span class="text-gray-500">Tanggal Daftar</span>
                    <span class="font-semibold text-gray-800 text-right">{{ \Carbon\Carbon::parse($pendaftar['tanggal_daftar'])->translatedFormat('d F Y') }}</span>
                </div>
            </div>

            @if($pendaftar['status'] === 'diterima')
                <div class="px-6 pb-6">
                    <div class="bg-green-50 border border-green-100 rounded-lg p-4 text-sm text-green-800">
                        Selamat! Informasi daftar ulang akan disampaikan sekolah.
                    </div>
                </div>
            @endif

            @if($pendaftar['jenis'] === 'Lanjutan' && $pendaftar['school_code'] === 'SMP')
                <div class="px-6 pb-6">
                    <div class="bg-amber-50 border border-amber-100 rounded-lg p-4 text-sm text-amber-800">
                        <span class="font-semibold">Uang gedung gratis</span> berlaku untuk lulusan SDIT yang melanjutkan ke SMPIT.
                    </div>
                </div>
            @endif
        </div>

        <div class="mt-6 text-center">
            <a href="/cek-pendaftaran" class="text-sm text-emerald-600 hover:text-emerald-700 font-semibold">&larr; Cek nomor lain</a>
        </div>
    </section>
</x-layouts.public>
