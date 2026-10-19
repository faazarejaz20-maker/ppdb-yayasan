@php
    $errorSteps = [
        'jenis' => 1, 'lookup' => 1,
        'nama' => 2, 'jenis_kelamin' => 2, 'tempat_lahir' => 2, 'tanggal_lahir' => 2,
        'agama' => 2, 'anak_ke' => 2, 'nisn' => 2,
        'nama_ayah' => 3, 'nama_ibu' => 3, 'pekerjaan' => 3, 'whatsapp' => 3, 'email' => 3,
        'alamat' => 4, 'asal_sekolah' => 4,
        'pernyataan' => 6,
    ];
    $initialStep = 1;
    if ($errors->any()) {
        $initialStep = min(array_map(fn ($key) => $errorSteps[$key] ?? 6, $errors->keys()));
    }

    $config = [
        'jenjang' => $school['jenjang'],
        'alumni' => $alumni,
        'requirements' => $requirements,
        'old' => old(),
        'initialStep' => $initialStep,
        'serverErrors' => collect($errors->messages())->map(fn ($messages) => $messages[0])->all(),
    ];
    $inputClass = 'w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none';
@endphp

<x-layouts.public :title="'Daftar ' . $school['name']">
    <section class="container mx-auto px-4 py-8 max-w-2xl"
             x-data="registrationWizard(@js($config))">

        {{-- Header --}}
        <div class="flex items-center gap-3 mb-6">
            <a href="/{{ $school['slug'] }}" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-lg font-bold text-gray-800 leading-tight">Formulir Pendaftaran</h1>
                <p class="text-xs text-gray-500">{{ $school['name'] }}</p>
            </div>
        </div>

        {{-- Progress --}}
        <div class="mb-6">
            <div class="flex justify-between text-xs text-gray-500 mb-2">
                <span class="font-semibold text-emerald-700">Langkah <span x-text="step"></span> dari <span x-text="totalSteps"></span></span>
                <span x-text="progress + '%'"></span>
            </div>
            <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                <div class="h-full bg-emerald-600 transition-all duration-300" :style="`width: ${progress}%`"></div>
            </div>
            <div class="hidden sm:grid grid-cols-6 gap-1 mt-2 text-[10px] text-center text-gray-400">
                @foreach(['Jenis', 'Siswa', 'Orang Tua', 'Alamat', 'Berkas', 'Kirim'] as $i => $label)
                    <div :class="step >= {{ $i + 1 }} ? 'text-emerald-700 font-semibold' : ''">{{ $label }}</div>
                @endforeach
            </div>
        </div>

        @if(session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg p-3">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg p-3">
                <p class="font-semibold mb-1">Periksa kembali data berikut:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @include('public.partials.registration-form', [
            'action' => '/' . $school['slug'] . '/daftar',
            'submitLabel' => 'Kirim Pendaftaran',
            'inputClass' => $inputClass,
        ])
    </section>
</x-layouts.public>
