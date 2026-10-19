@props(['jenis'])

<span {{ $attributes->merge(['class' => 'inline-block text-[11px] font-semibold px-2.5 py-1 rounded-full ' . ($jenis === 'Lanjutan' ? 'bg-violet-100 text-violet-700' : 'bg-slate-100 text-slate-600')]) }}>
    {{ $jenis }}
</span>
