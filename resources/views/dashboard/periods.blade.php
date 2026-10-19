<x-layouts.dashboard :title="'Periode Pendaftaran'" :school="$school">
    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-800">Periode Pendaftaran</h1>
        <p class="text-xs text-gray-500">Periode PPDB {{ $school['name'] }} (tampilan demo).</p>
    </div>

    {{-- Tabel (desktop) --}}
    <div class="hidden md:block bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left text-[11px] uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-4 py-3 font-semibold">Periode</th>
                        <th class="px-4 py-3 font-semibold">Dibuka</th>
                        <th class="px-4 py-3 font-semibold">Ditutup</th>
                        <th class="px-4 py-3 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($periods as $period)
                        <tr>
                            <td class="px-4 py-3 font-semibold text-gray-800">{{ $period['nama'] }}</td>
                            <td class="px-4 py-3 text-xs text-gray-600">{{ $period['dibuka'] }}</td>
                            <td class="px-4 py-3 text-xs text-gray-600">{{ $period['ditutup'] }}</td>
                            <td class="px-4 py-3">
                                <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700">{{ $period['status'] }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Kartu (mobile) --}}
    <div class="md:hidden space-y-2.5">
        @foreach($periods as $period)
            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <div class="flex items-start justify-between gap-3 mb-2">
                    <div class="text-sm font-bold text-gray-800 leading-tight">{{ $period['nama'] }}</div>
                    <span class="shrink-0 text-[10px] font-semibold px-2 py-1 rounded-full bg-emerald-100 text-emerald-700">{{ $period['status'] }}</span>
                </div>
                <dl class="text-[11px] text-gray-500 space-y-1">
                    <div class="flex justify-between gap-3"><dt>Dibuka</dt><dd class="text-gray-700">{{ $period['dibuka'] }}</dd></div>
                    <div class="flex justify-between gap-3"><dt>Ditutup</dt><dd class="text-gray-700">{{ $period['ditutup'] }}</dd></div>
                </dl>
            </div>
        @endforeach
    </div>

    <p class="text-[11px] text-gray-400 mt-3">Prototipe: data periode masih contoh.</p>
</x-layouts.dashboard>
