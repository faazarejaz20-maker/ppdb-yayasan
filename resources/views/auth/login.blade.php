<x-layouts.public title="Login">
    <section class="container mx-auto px-4 py-12 max-w-lg">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Login</h1>
            <p class="text-sm text-gray-500">Pilih peran untuk masuk ke dashboard demo.</p>
            <span class="inline-block mt-2 text-[10px] font-semibold bg-amber-100 text-amber-700 px-2 py-0.5 rounded">
                Login contoh untuk demo
            </span>
        </div>

        <form action="/login" method="POST" x-data="{ role: '{{ old('role', 'panitia') }}' }"
              class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Peran</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach([
                        'panitia' => 'Panitia',
                        'admin_sekolah' => 'Admin Sekolah',
                        'yayasan' => 'Yayasan',
                        'super_admin' => 'Super Admin',
                    ] as $value => $label)
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="{{ $value }}" x-model="role" class="peer sr-only">
                            <div class="border-2 border-gray-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 rounded-lg px-3 py-2.5 text-center text-sm font-semibold text-gray-600 peer-checked:text-emerald-700 transition">
                                {{ $label }}
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('role') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror

                <div class="mt-3 text-[11px] leading-relaxed text-gray-500 bg-gray-50 border border-gray-100 rounded-lg p-3">
                    <p x-show="role === 'panitia'">Panitia: kelola pendaftar satu sekolah, verifikasi berkas, Terima/Tolak, kirim WhatsApp.</p>
                    <p x-show="role === 'admin_sekolah'">Admin Sekolah: tugas panitia ditambah akun panitia dan periode pendaftaran.</p>
                    <p x-show="role === 'yayasan'">Yayasan: hanya melihat rekap 4 sekolah, tanpa tombol ubah.</p>
                    <p x-show="role === 'super_admin'">Super Admin: kelola sekolah, akun admin sekolah, akun yayasan, dan pengaturan.</p>
                </div>
            </div>

            <div x-show="role === 'panitia' || role === 'admin_sekolah'" x-transition>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Pilih Sekolah</label>
                <select name="school_code"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    @foreach($schools as $s)
                        <option value="{{ $s['code'] }}" @selected(old('school_code') === $s['code'])>{{ $s['name'] }}</option>
                    @endforeach
                </select>
                @error('school_code') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 rounded-lg transition">
                Masuk
            </button>
        </form>
    </section>
</x-layouts.public>
