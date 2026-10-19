<x-layouts.dashboard title="Pengaturan">
    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-800">Pengaturan</h1>
        <p class="text-xs text-gray-500">Identitas sistem PPDB.</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5 max-w-lg">
        <dl class="space-y-4 text-sm">
            <div>
                <dt class="text-[11px] text-gray-500 mb-1">Nama Sistem</dt>
                <dd class="font-semibold text-gray-800">{{ $settings['nama_sistem'] }}</dd>
            </div>
            <div>
                <dt class="text-[11px] text-gray-500 mb-1">Tahun Ajaran Aktif</dt>
                <dd class="font-semibold text-gray-800">{{ $settings['tahun_ajaran'] }}</dd>
            </div>
        </dl>

        <div class="mt-5 pt-4 border-t border-gray-100 text-xs text-gray-500">
            Pengaturan ini masih tampilan saja pada prototipe.
        </div>
    </div>
</x-layouts.dashboard>
