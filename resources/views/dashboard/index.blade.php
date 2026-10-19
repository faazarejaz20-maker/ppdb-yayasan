<x-layouts.dashboard :title="'Pendaftar ' . $school['name']" :school="$school">
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Daftar Pendaftar</h1>
            <p class="text-xs text-gray-500">{{ $school['name'] }} &middot; Tahun Ajaran 2026/2027</p>
        </div>
        <a href="/dashboard/tambah" class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition">
            + Tambah Pendaftar
        </a>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
        @foreach([
            ['label' => 'Total Pendaftar', 'value' => $stats['total'], 'class' => 'text-gray-800', 'bg' => 'bg-white'],
            ['label' => 'Menunggu Verifikasi', 'value' => $stats['menunggu'], 'class' => 'text-amber-700', 'bg' => 'bg-amber-50'],
            ['label' => 'Diterima', 'value' => $stats['diterima'], 'class' => 'text-emerald-700', 'bg' => 'bg-emerald-50'],
            ['label' => 'Ditolak', 'value' => $stats['ditolak'], 'class' => 'text-red-700', 'bg' => 'bg-red-50'],
        ] as $card)
            <div class="rounded-xl border border-gray-200 p-4 {{ $card['bg'] }}">
                <div class="text-[11px] text-gray-500 mb-1">{{ $card['label'] }}</div>
                <div class="text-2xl font-bold {{ $card['class'] }}">{{ $card['value'] }}</div>
            </div>
        @endforeach
    </div>

    {{-- Filter --}}
    <form method="GET" action="/dashboard" class="bg-white rounded-xl border border-gray-200 p-3 mb-4">
        <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-2">
            <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Cari nama / nomor peserta"
                   class="lg:col-span-2 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">

            <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <option value="">Semua status</option>
                @foreach(\App\Support\DemoStore::statusLabels() as $value => $label)
                    <option value="{{ $value }}" @selected(($filters['status'] ?? '') === $value)>{{ $label }}</option>
                @endforeach
            </select>

            <select name="jenis" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <option value="">Semua jenis</option>
                <option value="Lanjutan" @selected(($filters['jenis'] ?? '') === 'Lanjutan')>Lanjutan</option>
                <option value="Baru" @selected(($filters['jenis'] ?? '') === 'Baru')>Baru</option>
            </select>

            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 bg-gray-800 hover:bg-gray-900 text-white text-sm font-semibold px-3 py-2 rounded-lg">
                    Terapkan
                </button>
                <a href="/dashboard" class="text-xs text-gray-500 hover:text-gray-700 px-2">Reset</a>
            </div>
        </div>

        <label class="flex items-center gap-2 mt-2.5 text-xs text-gray-600 cursor-pointer w-fit">
            <input type="checkbox" name="belum_dikirim" value="1" @checked($filters['belum_dikirim'] ?? false)
                   class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
            Tampilkan hanya yang belum dikirim pengumuman
        </label>
    </form>

    {{-- Tabel (desktop) --}}
    <div class="hidden md:block bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left text-[11px] uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-4 py-3 font-semibold">Nomor Peserta</th>
                        <th class="px-4 py-3 font-semibold">Nama</th>
                        <th class="px-4 py-3 font-semibold">Jenis</th>
                        <th class="px-4 py-3 font-semibold">Status</th>
                        <th class="px-4 py-3 font-semibold">Tgl Daftar</th>
                        <th class="px-4 py-3 font-semibold">Pengumuman</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pendaftar as $p)
                        <tr class="hover:bg-gray-50/70">
                            <td class="px-4 py-3 font-mono text-xs text-gray-700 whitespace-nowrap">{{ $p['nomor_peserta'] }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-800">{{ $p['nama'] }}</td>
                            <td class="px-4 py-3"><x-ui.jenis-badge :jenis="$p['jenis']" /></td>
                            <td class="px-4 py-3"><x-ui.status-badge :status="$p['status']" /></td>
                            <td class="px-4 py-3 text-xs text-gray-500 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($p['tanggal_daftar'])->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-4 py-3">
                                @if(!empty($p['pengumuman_terkirim']))
                                    <span class="text-[11px] font-semibold text-emerald-700">Sudah dikirim</span>
                                @else
                                    <span class="text-[11px] text-gray-400">Belum</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="/dashboard/{{ $p['nomor_peserta'] }}" class="text-xs font-semibold text-emerald-700 hover:text-emerald-800 whitespace-nowrap">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-sm text-gray-500">
                                Tidak ada pendaftar yang cocok dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Kartu (mobile) --}}
    <div class="md:hidden space-y-2.5">
        @forelse($pendaftar as $p)
            <a href="/dashboard/{{ $p['nomor_peserta'] }}"
               class="block bg-white rounded-xl border border-gray-200 p-4 active:bg-gray-50">
                <div class="flex items-start justify-between gap-3 mb-2">
                    <div class="min-w-0">
                        <div class="text-sm font-bold text-gray-800 leading-tight">{{ $p['nama'] }}</div>
                        <div class="font-mono text-[11px] text-gray-500 mt-0.5">{{ $p['nomor_peserta'] }}</div>
                    </div>
                    <x-ui.status-badge :status="$p['status']" />
                </div>
                <div class="flex flex-wrap items-center gap-2 text-[11px] text-gray-500">
                    <x-ui.jenis-badge :jenis="$p['jenis']" />
                    <span>&middot;</span>
                    <span>{{ \Carbon\Carbon::parse($p['tanggal_daftar'])->translatedFormat('d M Y') }}</span>
                    <span>&middot;</span>
                    @if(!empty($p['pengumuman_terkirim']))
                        <span class="font-semibold text-emerald-700">Sudah dikirim</span>
                    @else
                        <span>Belum dikirim</span>
                    @endif
                </div>
            </a>
        @empty
            <div class="bg-white rounded-xl border border-gray-200 px-4 py-10 text-center text-sm text-gray-500">
                Tidak ada pendaftar yang cocok dengan filter.
            </div>
        @endforelse
    </div>

    @if($pagination['lastPage'] > 1)
        <div class="bg-white md:bg-transparent rounded-xl md:rounded-none border md:border-0 border-gray-200 mt-2 md:mt-0 flex flex-wrap items-center justify-between gap-3 px-4 md:px-4 py-3 md:border-t md:border-gray-100 text-xs text-gray-500">
            <span>
                Menampilkan {{ ($pagination['page'] - 1) * $pagination['perPage'] + 1 }}&ndash;{{ min($pagination['page'] * $pagination['perPage'], $pagination['total']) }}
                dari {{ $pagination['total'] }}
            </span>
            <div class="flex gap-1">
                @for($i = 1; $i <= $pagination['lastPage']; $i++)
                    <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}"
                       class="px-2.5 py-1.5 rounded-lg border {{ $i === $pagination['page'] ? 'bg-emerald-600 text-white border-emerald-600' : 'border-gray-300 hover:bg-gray-50' }}">
                        {{ $i }}
                    </a>
                @endfor
            </div>
        </div>
    @endif
</x-layouts.dashboard>
