@php
    $config = [
        'jenjang' => $school['jenjang'],
        'alumni' => $alumni,
        'requirements' => $requirements,
        'old' => old(),
        'initialStep' => $errors->any() ? 1 : 1,
        'serverErrors' => collect($errors->messages())->map(fn ($messages) => $messages[0])->all(),
    ];
@endphp

<x-layouts.dashboard :title="'Tambah Pendaftar'" :school="$school">
    <div class="flex items-center gap-3 mb-6">
        <a href="/dashboard" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-xl font-bold text-gray-800">Tambah Pendaftar</h1>
            <p class="text-xs text-gray-500">Entry data offline untuk {{ $school['name'] }}</p>
        </div>
    </div>

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

    <div x-data="registrationWizard(@js($config))" class="max-w-2xl">
        <div class="mb-5">
            <div class="flex justify-between text-xs text-gray-500 mb-2">
                <span class="font-semibold text-emerald-700">Langkah <span x-text="step"></span> dari <span x-text="totalSteps"></span></span>
                <span x-text="progress + '%'"></span>
            </div>
            <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                <div class="h-full bg-emerald-600 transition-all duration-300" :style="`width: ${progress}%`"></div>
            </div>
        </div>

        @include('public.partials.registration-form', [
            'action' => '/dashboard/tambah',
            'submitLabel' => 'Simpan Pendaftar',
            'inputClass' => 'w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none',
        ])
    </div>
</x-layouts.dashboard>
