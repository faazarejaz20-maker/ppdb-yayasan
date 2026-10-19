@props(['schools'])

<nav x-data="{ open: false, dropdown: false }" class="bg-white shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <a href="/" class="flex items-center gap-2">
                <div class="w-9 h-9 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold">AI</div>
                <div class="leading-tight">
                    <div class="text-sm font-bold text-gray-800">Al-Ishlah Insan Mulia</div>
                    <div class="text-[10px] text-gray-500">PPDB Online</div>
                </div>
            </a>

            <div class="hidden md:flex items-center gap-6">
                <a href="/" class="text-sm text-gray-700 hover:text-emerald-600">Beranda</a>

                <div class="relative" x-data="{ openDropdown: false }">
                    <button @click="openDropdown = !openDropdown" @click.outside="openDropdown = false"
                        class="text-sm text-gray-700 hover:text-emerald-600 flex items-center gap-1">
                        Sekolah
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openDropdown" x-transition class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg border py-2" style="display: none;">
                        @foreach($schools as $s)
                            <a href="/{{ $s['slug'] }}"
                               class="block px-4 py-2 text-sm {{ request()->is($s['slug']) ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-gray-700' }} hover:bg-emerald-50 hover:text-emerald-700">
                                {{ $s['name'] }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <a href="/cek-pendaftaran" class="text-sm text-gray-700 hover:text-emerald-600">Cek Pendaftaran</a>
                <a href="/login" class="text-sm bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700">Login</a>
            </div>

            <button @click="open = !open" class="md:hidden p-2 text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <div x-show="open" x-transition class="md:hidden pb-4 space-y-1" style="display: none;">
            <a href="/" class="block px-3 py-2 text-sm text-gray-700 hover:bg-emerald-50 rounded">Beranda</a>
            <div class="px-3 py-2 text-xs font-semibold text-gray-400 uppercase">Sekolah</div>
            @foreach($schools as $s)
                <a href="/{{ $s['slug'] }}" class="block px-5 py-2 text-sm text-gray-700 hover:bg-emerald-50 rounded">{{ $s['name'] }}</a>
            @endforeach
            <a href="/cek-pendaftaran" class="block px-3 py-2 text-sm text-gray-700 hover:bg-emerald-50 rounded">Cek Pendaftaran</a>
            <a href="/login" class="block px-3 py-2 text-sm bg-emerald-600 text-white rounded text-center">Login</a>
        </div>
    </div>
</nav>
