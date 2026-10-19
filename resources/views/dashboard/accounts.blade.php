<x-layouts.dashboard :title="'Akun Panitia'" :school="$school">
    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-800">Akun Panitia</h1>
        <p class="text-xs text-gray-500">Daftar akun panitia {{ $school['name'] }} (tampilan demo).</p>
    </div>

    {{-- Tabel (desktop) --}}
    <div class="hidden md:block bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left text-[11px] uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-4 py-3 font-semibold">Nama</th>
                        <th class="px-4 py-3 font-semibold">Email</th>
                        <th class="px-4 py-3 font-semibold">Status</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($accounts as $account)
                        <tr>
                            <td class="px-4 py-3 font-semibold text-gray-800">{{ $account['nama'] }}</td>
                            <td class="px-4 py-3 text-xs text-gray-600">{{ $account['email'] }}</td>
                            <td class="px-4 py-3">
                                <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full {{ $account['aktif'] ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $account['aktif'] ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right text-[11px] text-gray-400">Tampilan saja</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Kartu (mobile) --}}
    <div class="md:hidden space-y-2.5">
        @foreach($accounts as $account)
            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <div class="text-sm font-bold text-gray-800 leading-tight">{{ $account['nama'] }}</div>
                        <div class="text-[11px] text-gray-500 mt-0.5 break-all">{{ $account['email'] }}</div>
                    </div>
                    <span class="shrink-0 text-[10px] font-semibold px-2 py-1 rounded-full {{ $account['aktif'] ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $account['aktif'] ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                <p class="text-[10px] text-gray-400 mt-2">Tampilan saja</p>
            </div>
        @endforeach
    </div>

    <p class="text-[11px] text-gray-400 mt-3">Prototipe: pengelolaan akun akan aktif pada versi database.</p>
</x-layouts.dashboard>
