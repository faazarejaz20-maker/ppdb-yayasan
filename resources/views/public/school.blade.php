<x-layouts.public :title="$school['name']">
    {{-- Header sekolah --}}
    <section class="text-white" style="background: linear-gradient(135deg, {{ $school['color'] }} 0%, {{ $school['color'] }}dd 100%)">
        <div class="container mx-auto px-4 py-12 md:py-16">
            <div class="flex flex-col md:flex-row md:items-center gap-6">
                <div class="w-20 h-20 rounded-full bg-white/20 backdrop-blur flex items-center justify-center text-white font-bold text-2xl shrink-0">
                    {{ substr($school['code'], 0, 2) }}
                </div>
                <div class="flex-1">
                    <div class="text-xs font-semibold text-white/80 mb-1">Jenjang {{ $school['jenjang'] }}</div>
                    <h1 class="text-2xl md:text-4xl font-bold mb-2">{{ $school['name'] }}</h1>
                    <p class="text-white/90 text-sm md:text-base mb-1">{{ $school['tagline'] }}</p>
                    <p class="text-white/80 text-xs md:text-sm">{{ $school['address'] }}</p>
                </div>
                <div class="md:text-right shrink-0">
                    @if($isOpen)
                        <div class="inline-flex items-start gap-2 bg-white/20 backdrop-blur px-3 py-2 rounded-lg text-xs mb-3 max-w-full">
                            <span class="w-2 h-2 rounded-full bg-green-300 mt-1 shrink-0"></span>
                            <span>Pendaftaran dibuka sampai {{ \Carbon\Carbon::parse($school['closes_at'])->translatedFormat('d F Y') }}</span>
                        </div>
                        <div>
                            <a href="/{{ $school['slug'] }}/daftar"
                               class="inline-block bg-emerald-600 text-white font-bold px-6 py-3 rounded-xl hover:bg-emerald-700 transition">
                                Daftar Sekarang
                            </a>
                        </div>
                    @else
                        <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur px-3 py-2 rounded-lg text-xs mb-3">
                            <span class="w-2 h-2 rounded-full bg-red-300"></span>
                            Pendaftaran ditutup
                        </div>
                        <div>
                            <span class="inline-block bg-white/30 text-white/80 font-bold px-6 py-3 rounded-xl cursor-not-allowed">
                                Daftar Sekarang
                            </span>
                        </div>
                    @endif
                    <div class="mt-3">
                        <a href="/cek-pendaftaran" class="text-xs text-white/90 underline underline-offset-2">Cek Pendaftaran</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Tabs --}}
    <section x-data="{ tab: 'tentang' }" class="container mx-auto px-4 py-8 md:py-12 max-w-5xl">
        <div class="flex overflow-x-auto gap-1 bg-white rounded-xl shadow-sm border border-gray-100 p-1.5 mb-8">
            @foreach(['tentang' => 'Tentang', 'alur' => 'Alur', 'jadwal' => 'Jadwal', 'kontak' => 'Kontak'] as $key => $label)
                <button @click="tab = '{{ $key }}'"
                        :class="tab === '{{ $key }}' ? 'text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50'"
                        :style="tab === '{{ $key }}' ? 'background-color: {{ $school['color'] }}' : ''"
                        class="flex-1 min-w-[70px] text-sm font-semibold py-2.5 px-3 rounded-lg transition whitespace-nowrap">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        {{-- Tentang --}}
        <div x-show="tab === 'tentang'" x-transition>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Tentang {{ $school['name'] }}</h2>
                <p class="text-gray-600 leading-relaxed mb-6">{{ $school['about'] }}</p>

                <h3 class="font-bold text-gray-800 mb-3">Keunggulan</h3>
                <ul class="grid sm:grid-cols-2 gap-3">
                    @foreach($school['highlights'] as $highlight)
                        <li class="flex gap-2 items-start text-sm text-gray-700">
                            <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ $highlight }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Alur --}}
        <div x-show="tab === 'alur'" x-transition style="display: none;">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                <h2 class="text-xl font-bold text-gray-800 mb-5">Alur Pendaftaran</h2>
                <ol class="space-y-4 mb-8">
                    @foreach($school['steps'] as $i => $step)
                        <li class="flex gap-4">
                            <div class="w-8 h-8 rounded-full text-white flex items-center justify-center text-sm font-bold shrink-0"
                                 style="background-color: {{ $school['color'] }}">
                                {{ $i + 1 }}
                            </div>
                            <p class="text-sm text-gray-700 pt-1.5">{{ $step }}</p>
                        </li>
                    @endforeach
                </ol>

                <h3 class="font-bold text-gray-800 mb-2">Persyaratan Berkas</h3>
                <p class="text-xs text-gray-500 mb-4">Format JPG/PNG/PDF, maksimal 2 MB per berkas.</p>
                <ul class="space-y-3 mb-6">
                    @foreach($requirements as $req)
                        <li class="flex gap-3 items-start bg-gray-50 rounded-lg p-3">
                            <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <div class="text-sm font-semibold text-gray-800">{{ $req['label'] }}</div>
                                <div class="text-xs text-gray-500">{{ $req['keterangan'] }}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div class="bg-amber-50 border border-amber-100 rounded-lg p-4 text-sm text-amber-800">
                    {{ $school['requirements'] }}
                </div>
            </div>
        </div>

        {{-- Jadwal --}}
        <div x-show="tab === 'jadwal'" x-transition style="display: none;">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                <div class="flex items-center gap-2 mb-5">
                    <h2 class="text-xl font-bold text-gray-800">Jadwal PPDB</h2>
                    <span class="text-[10px] font-semibold bg-amber-100 text-amber-700 px-2 py-0.5 rounded">Contoh</span>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($school['schedule'] as $item)
                        <div class="flex justify-between gap-4 py-3">
                            <span class="text-sm text-gray-700">{{ $item['kegiatan'] }}</span>
                            <span class="text-sm font-semibold text-gray-800 text-right">{{ $item['tanggal'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Kontak --}}
        <div x-show="tab === 'kontak'" x-transition style="display: none;">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 space-y-4">
                <h2 class="text-xl font-bold text-gray-800 mb-2">Kontak</h2>
                <div class="flex gap-3 items-start">
                    <svg class="w-5 h-5 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <div>
                        <div class="text-sm font-semibold text-gray-800">Alamat</div>
                        <div class="text-sm text-gray-600">{{ $school['address'] }}</div>
                    </div>
                </div>
                <div class="flex gap-3 items-start">
                    <svg class="w-5 h-5 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <div>
                        <div class="text-sm font-semibold text-gray-800">Telepon / WhatsApp</div>
                        <div class="text-sm text-gray-600">{{ $school['phone'] }}</div>
                        <div class="text-xs text-gray-500 mt-0.5">{{ \App\Support\DemoStore::localWhatsapp($school['whatsapp']) }}</div>
                        <a href="https://wa.me/{{ $school['whatsapp'] }}" target="_blank"
                           class="inline-flex items-center gap-1.5 mt-2 text-xs font-semibold text-white px-3 py-1.5 rounded-lg"
                           style="background-color: #25D366">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Hubungi via WhatsApp
                        </a>
                    </div>
                </div>
                <div class="flex gap-3 items-start">
                    <svg class="w-5 h-5 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <div>
                        <div class="text-sm font-semibold text-gray-800">Email</div>
                        <div class="text-sm text-gray-600">{{ $school['email'] }}</div>
                    </div>
                </div>
                <div class="flex gap-3 items-start">
                    <svg class="w-5 h-5 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <div class="text-sm font-semibold text-gray-800">Jam Layanan</div>
                        <div class="text-sm text-gray-600">Senin - Jumat, 08.00 - 14.00 WIB</div>
                    </div>
                </div>
                <div class="pt-2">
                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($school['address']) }}"
                       target="_blank" rel="noopener"
                       class="inline-flex items-center gap-1.5 text-sm font-semibold"
                       style="color: {{ $school['color'] }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Lihat di Peta
                    </a>
                </div>
            </div>
        </div>

        {{-- Jalur lanjutan (SD & SMP) --}}
        @if(in_array($school['jenjang'], ['SD', 'SMP']))
            <div class="mt-6 rounded-2xl p-5 md:p-6 text-white" style="background-color: {{ $school['color'] }}">
                <h3 class="font-bold mb-1">
                    @if($school['jenjang'] === 'SD')
                        Lulusan TKIT?
                    @else
                        Lulusan SDIT?
                    @endif
                </h3>
                <p class="text-sm text-white/90 mb-3">
                    Daftar lewat jalur lanjutan, data terisi otomatis.
                </p>
                <a href="/{{ $school['slug'] }}/daftar" class="inline-block bg-white text-sm font-semibold px-4 py-2 rounded-lg"
                   style="color: {{ $school['color'] }}">
                    Daftar Jalur Lanjutan
                </a>
            </div>
        @endif

        <div class="mt-6 text-center">
            <a href="/" class="text-sm text-gray-500 hover:text-gray-700">&larr; Kembali ke Beranda Yayasan</a>
        </div>
    </section>
</x-layouts.public>
