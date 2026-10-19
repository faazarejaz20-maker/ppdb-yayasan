<x-layouts.dashboard title="Sekolah">
    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-800">Sekolah</h1>
        <p class="text-xs text-gray-500">Kelola unit pendidikan di bawah yayasan.</p>
    </div>

    <div class="grid sm:grid-cols-2 gap-4">
        @foreach($schools as $school)
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-start gap-3 mb-3">
                    <div class="w-11 h-11 rounded-full flex items-center justify-center text-white font-bold text-sm shrink-0"
                         style="background-color: {{ $school['color'] }}">
                        {{ substr($school['code'], 0, 2) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h2 class="text-sm font-bold text-gray-800 leading-tight">{{ $school['name'] }}</h2>
                        <p class="text-xs text-gray-500">Jenjang {{ $school['jenjang'] }}</p>
                    </div>
                    <span class="text-[10px] font-semibold px-2 py-1 rounded-full {{ $school['aktif'] ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $school['aktif'] ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>

                <dl class="text-xs space-y-1.5 mb-4">
                    <div class="flex justify-between gap-3">
                        <dt class="text-gray-500">Admin</dt>
                        <dd class="font-semibold text-gray-800 text-right">{{ $school['admin'] }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-gray-500">Slug</dt>
                        <dd class="font-mono text-gray-600 text-right">{{ $school['slug'] }}</dd>
                    </div>
                </dl>

                <div class="flex gap-2">
                    <a href="/{{ $school['slug'] }}" target="_blank"
                       class="flex-1 text-center border border-gray-300 text-gray-700 text-xs font-semibold py-2 rounded-lg hover:bg-gray-50">
                        Lihat Halaman
                    </a>
                    <form action="/super-admin/sekolah/{{ $school['code'] }}/toggle" method="POST" class="flex-1">
                        @csrf
                        <button type="submit"
                                class="w-full text-xs font-semibold py-2 rounded-lg {{ $school['aktif'] ? 'border border-red-300 text-red-600 hover:bg-red-50' : 'bg-emerald-600 text-white hover:bg-emerald-700' }}">
                            {{ $school['aktif'] ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <p class="text-[11px] text-gray-400 mt-4">Perubahan status sekolah disimpan di session demo.</p>
</x-layouts.dashboard>
