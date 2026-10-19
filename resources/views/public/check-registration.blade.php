<x-layouts.public title="Cek Pendaftaran">
    <section class="container mx-auto px-4 py-12 max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Cek Pendaftaran</h1>
            <p class="text-sm text-gray-500">Masukkan nomor peserta dan tanggal lahir untuk melihat status.</p>
        </div>

        @if(session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg p-3">
                {{ session('error') }}
            </div>
        @endif

        <form action="/cek-pendaftaran" method="POST" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nomor Peserta</label>
                <input type="text" name="nomor_peserta" value="{{ old('nomor_peserta') }}"
                       placeholder="Contoh: SD-2026-0001"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                @error('nomor_peserta') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                @error('tanggal_lahir') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 rounded-lg transition">
                Cek Status
            </button>
        </form>
    </section>
</x-layouts.public>
