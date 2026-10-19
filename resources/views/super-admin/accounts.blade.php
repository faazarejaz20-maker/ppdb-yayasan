<x-layouts.dashboard :title="$title">
    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-800">{{ $title }}</h1>
        <p class="text-xs text-gray-500">
            {{ $scope === 'admin' ? 'Akun pengelola PPDB di tiap sekolah.' : 'Akun pengurus yayasan dengan akses lihat rekap.' }}
        </p>
    </div>

    {{-- Tambah akun --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 mb-4" x-data="{ open: false }">
        <div class="flex items-center justify-between gap-3">
            <h2 class="text-sm font-bold text-gray-800">Daftar Akun</h2>
            <button type="button" @click="open = !open"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-3.5 py-2 rounded-lg">
                + Tambah Akun
            </button>
        </div>

        <form x-show="open" x-transition method="POST" action="/super-admin/akun/{{ $scope }}" class="mt-4 pt-4 border-t border-gray-100 grid sm:grid-cols-3 gap-3" style="display: none;">
            @csrf
            <div>
                <label class="block text-[11px] font-semibold text-gray-600 mb-1">Nama</label>
                <input type="text" name="nama" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-gray-600 mb-1">Email</label>
                <input type="email" name="email" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            @if($scope === 'admin')
                <div>
                    <label class="block text-[11px] font-semibold text-gray-600 mb-1">Sekolah</label>
                    <select name="sekolah" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        @foreach($schools as $school)
                            <option value="{{ $school['code'] }}">{{ $school['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            @else
                <div class="flex items-end">
                    <p class="text-[11px] text-gray-500 pb-2">Akun yayasan tidak terikat sekolah.</p>
                </div>
            @endif
            <div class="sm:col-span-3">
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white text-xs font-semibold px-4 py-2 rounded-lg">
                    Simpan Akun
                </button>
            </div>
        </form>
    </div>

    {{-- Tabel (desktop) --}}
    <div class="hidden md:block bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left text-[11px] uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-4 py-3 font-semibold">Nama</th>
                        <th class="px-4 py-3 font-semibold">Email</th>
                        @if($scope === 'admin')
                            <th class="px-4 py-3 font-semibold">Sekolah</th>
                        @endif
                        <th class="px-4 py-3 font-semibold">Status</th>
                        <th class="px-4 py-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($accounts as $account)
                        <tr>
                            <td class="px-4 py-3 font-semibold text-gray-800">{{ $account['nama'] }}</td>
                            <td class="px-4 py-3 text-xs text-gray-600">{{ $account['email'] }}</td>
                            @if($scope === 'admin')
                                <td class="px-4 py-3 text-xs text-gray-600">{{ $account['nama_sekolah'] ?? '-' }}</td>
                            @endif
                            <td class="px-4 py-3">
                                <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full {{ $account['aktif'] ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $account['aktif'] ? 'Aktif' : 'Nonaktif' }}
                                </span>
                                @if($password = \App\Support\DemoStore::tempPassword($scope, $account['email']))
                                    <div class="text-[10px] text-amber-700 mt-1">Password sementara: <span class="font-mono font-semibold">{{ $password }}</span></div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap justify-end gap-1.5">
                                    <form action="/super-admin/akun/{{ $scope }}/{{ urlencode($account['email']) }}/reset" method="POST">
                                        @csrf
                                        <button type="submit" class="text-[11px] font-semibold text-gray-600 hover:text-gray-800 border border-gray-300 px-2.5 py-1.5 rounded-lg">
                                            Reset password
                                        </button>
                                    </form>
                                    <form action="/super-admin/akun/{{ $scope }}/{{ urlencode($account['email']) }}/toggle" method="POST">
                                        @csrf
                                        <button type="submit" class="text-[11px] font-semibold px-2.5 py-1.5 rounded-lg border {{ $account['aktif'] ? 'border-red-300 text-red-600 hover:bg-red-50' : 'border-emerald-300 text-emerald-700 hover:bg-emerald-50' }}">
                                            {{ $account['aktif'] ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-sm text-gray-500">Belum ada akun.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Kartu (mobile) --}}
    <div class="md:hidden space-y-2.5">
        @forelse($accounts as $account)
            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <div class="flex items-start justify-between gap-3 mb-1">
                    <div class="min-w-0">
                        <div class="text-sm font-bold text-gray-800 leading-tight">{{ $account['nama'] }}</div>
                        <div class="text-[11px] text-gray-500 mt-0.5 break-all">{{ $account['email'] }}</div>
                    </div>
                    <span class="shrink-0 text-[10px] font-semibold px-2 py-1 rounded-full {{ $account['aktif'] ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $account['aktif'] ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>

                @if($scope === 'admin')
                    <p class="text-[11px] text-gray-500 mb-1">{{ $account['nama_sekolah'] ?? '-' }}</p>
                @endif

                @if($password = \App\Support\DemoStore::tempPassword($scope, $account['email']))
                    <div class="text-[10px] text-amber-700 bg-amber-50 border border-amber-100 rounded px-2 py-1.5 mt-2">
                        Password sementara: <span class="font-mono font-semibold">{{ $password }}</span>
                    </div>
                @endif

                <div class="flex gap-2 mt-3">
                    <form action="/super-admin/akun/{{ $scope }}/{{ urlencode($account['email']) }}/reset" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full text-[11px] font-semibold text-gray-600 border border-gray-300 px-2.5 py-2 rounded-lg active:bg-gray-50">
                            Reset password
                        </button>
                    </form>
                    <form action="/super-admin/akun/{{ $scope }}/{{ urlencode($account['email']) }}/toggle" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full text-[11px] font-semibold px-2.5 py-2 rounded-lg border {{ $account['aktif'] ? 'border-red-300 text-red-600 active:bg-red-50' : 'border-emerald-300 text-emerald-700 active:bg-emerald-50' }}">
                            {{ $account['aktif'] ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl border border-gray-200 px-4 py-10 text-center text-sm text-gray-500">Belum ada akun.</div>
        @endforelse
    </div>

    <p class="text-[11px] text-gray-400 mt-3">Prototipe: akun dan password sementara hanya tersimpan di session.</p>
</x-layouts.dashboard>
