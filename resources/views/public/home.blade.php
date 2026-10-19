<x-layouts.public title="Beranda">
    {{-- Hero --}}
    <section class="bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 text-white">
        <div class="container mx-auto px-4 py-16 md:py-24 text-center">
            <div class="w-20 h-20 mx-auto rounded-full bg-white/20 backdrop-blur flex items-center justify-center mb-6">
                <span class="text-3xl font-bold">AI</span>
            </div>
            <h1 class="text-3xl md:text-5xl font-bold mb-4 leading-tight">
                Yayasan Al-Ishlah<br class="md:hidden"> Insan Mulia
            </h1>
            <p class="text-emerald-100 text-base md:text-xl max-w-2xl mx-auto mb-2">Wonosobo</p>
            <p class="text-emerald-50 text-sm md:text-lg max-w-xl mx-auto mb-8">
                Penerimaan Peserta Didik Baru Online tahun ajaran 2026/2027 untuk 4 unit pendidikan.
            </p>
            <a href="#unit-pendidikan" class="inline-block bg-white text-emerald-700 font-semibold px-8 py-3 rounded-xl hover:bg-emerald-50 transition">
                Lihat Unit Pendidikan
            </a>
        </div>
    </section>

    {{-- Tentang Yayasan --}}
    <section class="py-14 md:py-20">
        <div class="container mx-auto px-4 max-w-4xl">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4 text-center">Tentang Yayasan</h2>
            <p class="text-gray-600 leading-relaxed text-center max-w-3xl mx-auto">
                Yayasan Al-Ishlah Insan Mulia Wonosobo adalah lembaga pendidikan Islam yang berkomitmen
                mencetak generasi Qur'ani, berakhlak mulia, dan berprestasi. Kami mengelola empat unit
                pendidikan mulai dari jenjang TK hingga SMP yang saling terintegrasi.
            </p>
        </div>
    </section>

    {{-- Visi Misi --}}
    <section class="py-14 md:py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                <div class="bg-emerald-50 rounded-2xl p-6 md:p-8">
                    <h3 class="text-xl font-bold text-emerald-800 mb-3">Visi</h3>
                    <p class="text-gray-700 leading-relaxed">
                        Menjadi lembaga pendidikan Islam terdepan yang melahirkan generasi Qur'ani,
                        berakhlak mulia, cerdas, dan berdaya saing global.
                    </p>
                </div>
                <div class="bg-emerald-50 rounded-2xl p-6 md:p-8">
                    <h3 class="text-xl font-bold text-emerald-800 mb-3">Misi</h3>
                    <ul class="space-y-2 text-gray-700 text-sm leading-relaxed">
                        <li class="flex gap-2"><span class="text-emerald-600 font-bold">1.</span> Menanamkan nilai-nilai Qur'ani dalam kehidupan sehari-hari.</li>
                        <li class="flex gap-2"><span class="text-emerald-600 font-bold">2.</span> Mengembangkan potensi akademik dan non-akademik siswa.</li>
                        <li class="flex gap-2"><span class="text-emerald-600 font-bold">3.</span> Membangun karakter kepemimpinan yang Islami.</li>
                        <li class="flex gap-2"><span class="text-emerald-600 font-bold">4.</span> Menyediakan lingkungan belajar yang aman dan menyenangkan.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- Unit Pendidikan --}}
    <section id="unit-pendidikan" class="py-14 md:py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2 text-center">Unit Pendidikan</h2>
            <p class="text-gray-500 text-center mb-10">Pilih sekolah yang ingin Anda daftarkan</p>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 max-w-6xl mx-auto">
                @foreach($schools as $school)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col hover:shadow-md transition">
                        <div class="w-14 h-14 rounded-full flex items-center justify-center text-white font-bold text-lg mb-4"
                             style="background-color: {{ $school['color'] }}">
                            {{ substr($school['code'], 0, 2) }}
                        </div>
                        <div class="text-xs font-semibold text-gray-400 mb-1">Jenjang {{ $school['jenjang'] }}</div>
                        <h3 class="font-bold text-gray-800 mb-2 leading-snug">{{ $school['name'] }}</h3>
                        <p class="text-xs text-gray-500 mb-4 flex-1">{{ $school['tagline'] }}</p>
                        <a href="/{{ $school['slug'] }}"
                           class="block text-center text-sm font-semibold text-white py-2.5 rounded-lg hover:opacity-90 transition"
                           style="background-color: {{ $school['color'] }}">
                            Lihat & Daftar
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Alur PPDB --}}
    <section class="py-14 md:py-20 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-10 text-center">Alur PPDB</h2>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-6 max-w-5xl mx-auto">
                @php
                    $alur = [
                        ['icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'label' => 'Pilih Sekolah'],
                        ['icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z', 'label' => 'Isi Data'],
                        ['icon' => 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12', 'label' => 'Unggah Berkas'],
                        ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Verifikasi'],
                        ['icon' => 'M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z', 'label' => 'Pengumuman'],
                    ];
                @endphp

                @foreach($alur as $i => $step)
                    <div class="text-center">
                        <div class="w-14 h-14 mx-auto rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center mb-3">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $step['icon'] }}"/>
                            </svg>
                        </div>
                        <div class="text-xs text-emerald-600 font-bold mb-1">Langkah {{ $i + 1 }}</div>
                        <div class="text-sm font-semibold text-gray-700">{{ $step['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Kontak --}}
    <section class="py-14 md:py-20 bg-emerald-700 text-white">
        <div class="container mx-auto px-4 text-center max-w-2xl">
            <h2 class="text-2xl md:text-3xl font-bold mb-6">Hubungi Kami</h2>
            <div class="space-y-2 text-emerald-50 text-sm md:text-base">
                <p>Jl. Raya Wonosobo, Wonosobo, Jawa Tengah</p>
                <p>Telepon: (0286) 123-4567</p>
                <p>Email: info@alishlah.sch.id</p>
            </div>
        </div>
    </section>
</x-layouts.public>
