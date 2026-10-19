@props(['title' => null, 'school' => null])

@php
    $role = session('user_role');
    $roleLabels = [
        'panitia' => 'Panitia',
        'admin_sekolah' => 'Admin Sekolah',
        'yayasan' => 'Yayasan',
        'super_admin' => 'Super Admin',
    ];
    $isAdminSekolah = $role === 'admin_sekolah';
    $current = request()->path();
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} - PPDB Al-Ishlah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div x-data="{ sidebar: false }" class="min-h-screen">
        {{-- Topbar mobile --}}
        <div class="lg:hidden sticky top-0 z-40 bg-white border-b border-gray-200">
            <div class="flex items-center justify-between px-4 h-14">
                <button @click="sidebar = !sidebar" class="p-2 text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div class="text-sm font-bold text-gray-800">PPDB Al-Ishlah</div>
                <div class="w-8"></div>
            </div>
        </div>

        <div class="flex">
            {{-- Sidebar --}}
            <aside :class="sidebar ? 'translate-x-0' : '-translate-x-full'"
                   class="fixed lg:static lg:translate-x-0 z-40 w-64 h-screen lg:h-auto lg:min-h-screen overflow-y-auto bg-emerald-800 text-emerald-50 flex flex-col transition-transform duration-200">
                <div class="px-5 py-5 border-b border-emerald-700/60">
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-full bg-white/15 flex items-center justify-center font-bold text-sm">AI</div>
                            <div class="leading-tight">
                                <div class="text-sm font-bold">PPDB Al-Ishlah</div>
                                <div class="text-[10px] text-emerald-200">{{ $roleLabels[$role] ?? 'Dashboard' }}</div>
                            </div>
                        </div>
                        <button type="button" @click="sidebar = false" class="lg:hidden p-1 -mr-1 text-emerald-200 hover:text-white" aria-label="Tutup menu">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    @if($school)
                        <div class="mt-3 text-[11px] bg-emerald-900/50 rounded-lg px-3 py-2">
                            {{ $school['name'] }}
                        </div>
                    @endif
                </div>

                <nav class="flex-1 p-3 space-y-1 text-sm" @click="if ($event.target.closest('a')) sidebar = false">
                    @if(in_array($role, ['panitia', 'admin_sekolah'], true))
                        <a href="/dashboard" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg {{ $current === 'dashboard' ? 'bg-white/15 font-semibold' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Pendaftar
                        </a>
                        <a href="/dashboard/tambah" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg {{ str_starts_with($current, 'dashboard/tambah') ? 'bg-white/15 font-semibold' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah Pendaftar
                        </a>

                        @if($isAdminSekolah)
                            <div class="pt-3 pb-1 px-3 text-[10px] uppercase tracking-wide text-emerald-300">Admin Sekolah</div>
                            <a href="/dashboard/akun" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg {{ str_starts_with($current, 'dashboard/akun') ? 'bg-white/15 font-semibold' : 'hover:bg-white/10' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                Akun Panitia
                            </a>
                            <a href="/dashboard/periode" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg {{ str_starts_with($current, 'dashboard/periode') ? 'bg-white/15 font-semibold' : 'hover:bg-white/10' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Periode Pendaftaran
                            </a>
                        @endif
                    @endif

                    @if($role === 'yayasan')
                        <a href="/yayasan" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg {{ $current === 'yayasan' ? 'bg-white/15 font-semibold' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Rekap Pendaftar
                        </a>
                        <div class="mx-3 mt-3 rounded-lg bg-emerald-900/50 px-3 py-2.5">
                            <div class="text-[10px] uppercase tracking-wide text-emerald-300">Mode</div>
                            <div class="text-xs font-semibold">Hanya lihat</div>
                        </div>
                    @endif

                    @if($role === 'super_admin')
                        <a href="/super-admin" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg {{ $current === 'super-admin' ? 'bg-white/15 font-semibold' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            Sekolah
                        </a>
                        <a href="/super-admin/akun/admin" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg {{ $current === 'super-admin/akun/admin' ? 'bg-white/15 font-semibold' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Akun Admin Sekolah
                        </a>
                        <a href="/super-admin/akun/yayasan" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg {{ $current === 'super-admin/akun/yayasan' ? 'bg-white/15 font-semibold' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Akun Yayasan
                        </a>
                        <a href="/super-admin/pengaturan" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg {{ $current === 'super-admin/pengaturan' ? 'bg-white/15 font-semibold' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Pengaturan
                        </a>
                    @endif
                </nav>

                <div class="p-3 border-t border-emerald-700/60 space-y-2">
                    @if(in_array($role, ['panitia', 'admin_sekolah'], true))
                        <form action="/dashboard/reset" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left text-[11px] text-emerald-200 hover:text-white px-3 py-2 rounded-lg hover:bg-white/10">
                                Reset data demo
                            </button>
                        </form>
                    @endif
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left text-[11px] text-emerald-200 hover:text-white px-3 py-2 rounded-lg hover:bg-white/10">
                            Keluar
                        </button>
                    </form>
                </div>
            </aside>

            <div x-show="sidebar" @click="sidebar = false" class="fixed inset-0 bg-black/40 z-30 lg:hidden" style="display: none;"></div>

            {{-- Content --}}
            <div class="flex-1 min-w-0">
                <main class="p-4 md:p-8 max-w-6xl mx-auto">
                    @if(session('success'))
                        <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm rounded-lg p-3">
                            {{ session('success') }}
                        </div>
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

                    {{ $slot }}
                </main>

                <footer class="px-4 md:px-8 pb-6 text-center text-[11px] text-gray-400">
                    Prototipe: data contoh
                </footer>
            </div>
        </div>
    </div>
</body>
</html>
