<x-layouts.dashboard title="Rekap Pendaftar">
    <div class="flex flex-wrap items-start justify-between gap-3 mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Rekap Pendaftar</h1>
            <p class="text-xs text-gray-500">Semua unit pendidikan &middot; Tahun Ajaran 2026/2027</p>
        </div>
        <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 text-[11px] font-semibold px-3 py-1.5 rounded-full border border-blue-100">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            Hanya lihat
        </span>
    </div>

    {{-- Total --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
        @foreach([
            ['label' => 'Total Pendaftar', 'value' => $totals['total'], 'class' => 'text-gray-800'],
            ['label' => 'Diterima', 'value' => $totals['diterima'], 'class' => 'text-emerald-700'],
            ['label' => 'Ditolak', 'value' => $totals['ditolak'], 'class' => 'text-red-700'],
            ['label' => 'Jalur Lanjutan', 'value' => $totals['lanjutan'], 'class' => 'text-violet-700'],
        ] as $card)
            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <div class="text-[11px] text-gray-500 mb-1">{{ $card['label'] }}</div>
                <div class="text-2xl font-bold {{ $card['class'] }}">{{ $card['value'] }}</div>
            </div>
        @endforeach
    </div>

    {{-- Rekap per sekolah --}}
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
        @foreach($rekap as $row)
            <a href="/yayasan?sekolah={{ $row['school']['code'] }}"
               class="bg-white rounded-xl border p-4 hover:shadow-sm transition {{ $selected === $row['school']['code'] ? 'border-emerald-500 ring-1 ring-emerald-500' : 'border-gray-200' }}">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-[10px] font-bold"
                         style="background-color: {{ $row['school']['color'] }}">
                        {{ substr($row['school']['code'], 0, 2) }}
                    </div>
                    <div class="text-xs font-bold text-gray-800 leading-tight">{{ $row['school']['name'] }}</div>
                </div>
                <div class="text-2xl font-bold text-gray-800 mb-1">{{ $row['total'] }}</div>
                <div class="flex flex-wrap gap-x-3 gap-y-0.5 text-[10px] text-gray-500">
                    <span><span class="font-semibold text-emerald-700">{{ $row['diterima'] }}</span> diterima</span>
                    <span><span class="font-semibold text-red-700">{{ $row['ditolak'] }}</span> ditolak</span>
                    <span><span class="font-semibold text-violet-700">{{ $row['lanjutan'] }}</span> lanjutan</span>
                    <span><span class="font-semibold text-slate-600">{{ $row['baru'] }}</span> baru</span>
                </div>
            </a>
        @endforeach
    </div>

    {{-- Filter --}}
    <form method="GET" action="/yayasan" class="flex flex-wrap items-center gap-2 mb-4">
        <select name="sekolah" onchange="this.form.submit()"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white">
            <option value="">Semua sekolah</option>
            @foreach($schools as $school)
                <option value="{{ $school['code'] }}" @selected($selected === $school['code'])>{{ $school['name'] }}</option>
            @endforeach
        </select>
        @if($selected)
            <a href="/yayasan" class="text-xs text-gray-500 hover:text-gray-700">Hapus filter</a>
        @endif
        <span class="text-xs text-gray-400 ml-auto">{{ count($pendaftar) }} pendaftar ditampilkan</span>
    </form>

    {{-- Tabel (desktop, tanpa aksi) --}}
    <div class="hidden md:block bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left text-[11px] uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-4 py-3 font-semibold">Nomor Peserta</th>
                        <th class="px-4 py-3 font-semibold">Nama</th>
                        <th class="px-4 py-3 font-semibold">Sekolah</th>
                        <th class="px-4 py-3 font-semibold">Jenis</th>
                        <th class="px-4 py-3 font-semibold">Status</th>
                        <th class="px-4 py-3 font-semibold">Tgl Daftar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pendaftar as $p)
                        <tr class="hover:bg-gray-50/70">
                            <td class="px-4 py-3 font-mono text-xs text-gray-700 whitespace-nowrap">{{ $p['nomor_peserta'] }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-800">{{ $p['nama'] }}</td>
                            <td class="px-4 py-3 text-xs text-gray-600">{{ $p['school_code'] }}</td>
                            <td class="px-4 py-3"><x-ui.jenis-badge :jenis="$p['jenis']" /></td>
                            <td class="px-4 py-3"><x-ui.status-badge :status="$p['status']" /></td>
                            <td class="px-4 py-3 text-xs text-gray-500 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($p['tanggal_daftar'])->translatedFormat('d M Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-sm text-gray-500">Belum ada pendaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Kartu (mobile, tanpa aksi) --}}
    <div class="md:hidden space-y-2.5">
        @forelse($pendaftar as $p)
            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <div class="flex items-start justify-between gap-3 mb-2">
                    <div class="min-w-0">
                        <div class="text-sm font-bold text-gray-800 leading-tight">{{ $p['nama'] }}</div>
                        <div class="font-mono text-[11px] text-gray-500 mt-0.5">{{ $p['nomor_peserta'] }}</div>
                    </div>
                    <x-ui.status-badge :status="$p['status']" />
                </div>
                <div class="flex flex-wrap items-center gap-2 text-[11px] text-gray-500">
                    <span class="font-semibold text-gray-700">{{ $p['school_code'] }}</span>
                    <span>&middot;</span>
                    <x-ui.jenis-badge :jenis="$p['jenis']" />
                    <span>&middot;</span>
                    <span>{{ \Carbon\Carbon::parse($p['tanggal_daftar'])->translatedFormat('d M Y') }}</span>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl border border-gray-200 px-4 py-10 text-center text-sm text-gray-500">
                Belum ada pendaftar.
            </div>
        @endforelse
    </div>

    <p class="text-[11px] text-gray-400 mt-3">Akun yayasan hanya dapat melihat data. Tidak ada tombol ubah.</p>
</x-layouts.dashboard>
