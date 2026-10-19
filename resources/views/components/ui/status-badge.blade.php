@props(['status'])

@php
    $map = [
        'terdaftar' => 'bg-gray-100 text-gray-700',
        'berkas_diverifikasi' => 'bg-blue-100 text-blue-700',
        'diterima' => 'bg-green-100 text-green-700',
        'ditolak' => 'bg-red-100 text-red-700',
    ];
    $labels = [
        'terdaftar' => 'Terdaftar',
        'berkas_diverifikasi' => 'Berkas Diverifikasi',
        'diterima' => 'Diterima',
        'ditolak' => 'Ditolak',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-block whitespace-nowrap text-[11px] font-semibold px-2.5 py-1 rounded-full ' . ($map[$status] ?? 'bg-gray-100 text-gray-700')]) }}>
    {{ $labels[$status] ?? $status }}
</span>
