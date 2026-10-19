<x-layouts.dashboard :title="'Detail ' . $pendaftar['nomor_peserta']" :school="$school">
    <div class="flex items-center gap-3 mb-6">
        <a href="/dashboard" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="flex-1">
            <h1 class="text-xl font-bold text-gray-800">{{ $pendaftar['nama'] }}</h1>
            <p class="text-xs text-gray-500 font-mono">{{ $pendaftar['nomor_peserta'] }}</p>
        </div>
        <x-ui.status-badge :status="$pendaftar['status']" />
    </div>

    <div class="grid lg:grid-cols-3 gap-4">
        {{-- Kolom kiri --}}
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h2 class="text-sm font-bold text-gray-800 mb-3">Data Pendaftar</h2>
                <dl class="grid sm:grid-cols-2 gap-x-6 gap-y-2.5 text-sm">
                    @php
                        $rows = [
                            'Jenis Pendaftaran' => $pendaftar['jenis'],
                            'Jenis Kelamin' => $pendaftar['jenis_kelamin'],
                            'Tempat, Tanggal Lahir' => $pendaftar['tempat_lahir'] . ', ' . \Carbon\Carbon::parse($pendaftar['tanggal_lahir'])->translatedFormat('d F Y'),
                            'Agama' => $pendaftar['agama'] ?? '-',
                            'Anak Ke-' => $pendaftar['anak_ke'] ?? '-',
                            'NISN' => ($pendaftar['nisn'] ?? null) ?: '-',
                            'Nama Ayah' => $pendaftar['nama_ayah'] ?? '-',
                            'Nama Ibu' => $pendaftar['nama_ibu'] ?? '-',
                            'Pekerjaan' => $pendaftar['pekerjaan'] ?? '-',
                            'WhatsApp' => \App\Support\DemoStore::localWhatsapp($pendaftar['whatsapp'] ?? null),
                            'Email' => ($pendaftar['email'] ?? null) ?: '-',
                            'Asal Sekolah' => ($pendaftar['asal_sekolah'] ?? null) ?: '-',
                            'Tanggal Daftar' => \Carbon\Carbon::parse($pendaftar['tanggal_daftar'])->translatedFormat('d F Y'),
                        ];
                    @endphp
                    @foreach($rows as $label => $value)
                        <div>
                            <dt class="text-[11px] text-gray-500">{{ $label }}</dt>
                            <dd class="font-semibold text-gray-800">{{ $value }}</dd>
                        </div>
                    @endforeach
                    <div class="sm:col-span-2">
                        <dt class="text-[11px] text-gray-500">Alamat</dt>
                        <dd class="font-semibold text-gray-800">{{ $pendaftar['alamat'] ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Berkas --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h2 class="text-sm font-bold text-gray-800 mb-3">Verifikasi Berkas</h2>

                <div class="space-y-3">
                    @foreach($berkas as $file)
                        <div class="border border-gray-200 rounded-lg p-3.5" x-data="{ open: false }">
                            <div class="flex flex-wrap items-start justify-between gap-2">
                                <div>
                                    <div class="text-sm font-semibold text-gray-800">{{ $file['label'] }}</div>
                                    <div class="text-xs text-gray-500">{{ $file['keterangan'] }}</div>
                                </div>
                                @php
                                    $badge = [
                                        'valid' => 'bg-emerald-100 text-emerald-700',
                                        'tidak_valid' => 'bg-red-100 text-red-700',
                                        'menunggu' => 'bg-gray-100 text-gray-600',
                                    ][$file['status']];
                                    $labels = ['valid' => 'Valid', 'tidak_valid' => 'Tidak valid', 'menunggu' => 'Menunggu'];
                                @endphp
                                <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full {{ $badge }}">{{ $labels[$file['status']] }}</span>
                            </div>

                            @if($file['catatan'])
                                <p class="text-xs text-gray-500 mt-2 italic">Catatan: {{ $file['catatan'] }}</p>
                            @endif

                            <button type="button" @click="open = !open" class="text-xs font-semibold text-emerald-700 mt-2.5">
                                <span x-text="open ? 'Tutup' : 'Verifikasi berkas ini'"></span>
                            </button>

                            <form x-show="open" x-transition method="POST" action="/dashboard/{{ $pendaftar['nomor_peserta'] }}/berkas" class="mt-3 pt-3 border-t border-gray-100 space-y-2.5" style="display: none;">
                                @csrf
                                <input type="hidden" name="index" value="{{ $file['index'] }}">
                                <div class="flex flex-wrap gap-2">
                                    <label class="flex items-center gap-1.5 text-xs text-gray-700 cursor-pointer">
                                        <input type="radio" name="status" value="valid" @checked($file['status'] === 'valid') class="text-emerald-600 focus:ring-emerald-500"> Valid
                                    </label>
                                    <label class="flex items-center gap-1.5 text-xs text-gray-700 cursor-pointer">
                                        <input type="radio" name="status" value="tidak_valid" @checked($file['status'] === 'tidak_valid') class="text-red-600 focus:ring-red-500"> Tidak valid
                                    </label>
                                    <label class="flex items-center gap-1.5 text-xs text-gray-700 cursor-pointer">
                                        <input type="radio" name="status" value="menunggu" @checked($file['status'] === 'menunggu') class="text-gray-600 focus:ring-gray-400"> Menunggu
                                    </label>
                                </div>
                                <input type="text" name="catatan" value="{{ $file['catatan'] }}" placeholder="Catatan (opsional)"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs">
                                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white text-xs font-semibold px-3 py-2 rounded-lg">
                                    Simpan
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Riwayat --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h2 class="text-sm font-bold text-gray-800 mb-3">Riwayat Perubahan</h2>
                <ol class="space-y-3">
                    @foreach($riwayat as $entry)
                        <li class="flex gap-3 text-xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mt-1.5 shrink-0"></span>
                            <div>
                                <div class="font-semibold text-gray-800">{{ $entry['aksi'] }}</div>
                                <div class="text-gray-500">
                                    {{ \Carbon\Carbon::parse($entry['waktu'])->translatedFormat('d M Y H:i') }}
                                    @if($entry['catatan']) &middot; {{ $entry['catatan'] }} @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>

        {{-- Kolom kanan --}}
        <div class="space-y-4">
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h2 class="text-sm font-bold text-gray-800 mb-3">Keputusan</h2>

                <form method="POST" action="/dashboard/{{ $pendaftar['nomor_peserta'] }}/status" class="space-y-2">
                    @csrf
                    <input type="hidden" name="status" value="diterima">
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold py-2.5 rounded-lg transition">
                        Terima
                    </button>
                </form>

                <form method="POST" action="/dashboard/{{ $pendaftar['nomor_peserta'] }}/status" class="mt-2">
                    @csrf
                    <input type="hidden" name="status" value="ditolak">
                    <button type="submit" class="w-full border border-red-300 text-red-600 hover:bg-red-50 text-sm font-semibold py-2.5 rounded-lg transition">
                        Tolak
                    </button>
                </form>

                <form method="POST" action="/dashboard/{{ $pendaftar['nomor_peserta'] }}/status" class="mt-2">
                    @csrf
                    <input type="hidden" name="status" value="berkas_diverifikasi">
                    <button type="submit" class="w-full border border-gray-300 text-gray-700 hover:bg-gray-50 text-xs font-semibold py-2 rounded-lg transition">
                        Tandai berkas terverifikasi
                    </button>
                </form>
            </div>

            {{-- WhatsApp --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5" x-data="{
                open: false,
                nomor: '',
                pesan: '',
                url: '',
                sent: {{ !empty($pendaftar['pengumuman_terkirim']) ? 'true' : 'false' }},
                async prepare() {
                    this.open = true;
                    const res = await fetch('/dashboard/{{ $pendaftar['nomor_peserta'] }}/whatsapp', { headers: { 'Accept': 'application/json' } });
                    const data = await res.json();
                    this.nomor = data.nomor;
                    this.pesan = data.pesan;
                    this.url = data.url;
                },
                updateUrl() {
                    this.url = 'https://wa.me/' + this.nomor + '?text=' + encodeURIComponent(this.pesan);
                },
                send() {
                    window.open(this.url, '_blank');
                    this.sent = true;
                    this.$refs.form.submit();
                }
            }">
                <h2 class="text-sm font-bold text-gray-800 mb-1">Kirim via WhatsApp</h2>
                <p class="text-xs text-gray-500 mb-3">
                    @if(!empty($pendaftar['pengumuman_terkirim']))
                        <span class="font-semibold text-emerald-700">Sudah dikirim</span>
                    @else
                        Belum dikirim
                    @endif
                </p>

                <button type="button" @click="prepare()" x-show="!open"
                        class="w-full bg-[#25D366] hover:opacity-90 text-white text-sm font-semibold py-2.5 rounded-lg transition">
                    Siapkan Pesan
                </button>

                <div x-show="open" x-transition style="display: none;">
                    <label class="block text-[11px] font-semibold text-gray-600 mb-1">Nomor WhatsApp</label>
                    <input type="text" x-model="nomor" @input="updateUrl()" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs mb-2">

                    <label class="block text-[11px] font-semibold text-gray-600 mb-1">Pesan (bisa diedit)</label>
                    <textarea x-model="pesan" @input="updateUrl()" rows="5" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs mb-2"></textarea>

                    <button type="button" @click="send()"
                            class="w-full bg-[#25D366] hover:opacity-90 text-white text-sm font-semibold py-2.5 rounded-lg transition">
                        Buka WhatsApp &amp; Tandai Terkirim
                    </button>

                    <form x-ref="form" method="POST" action="/dashboard/{{ $pendaftar['nomor_peserta'] }}/pengumuman" class="hidden">
                        @csrf
                    </form>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h2 class="text-sm font-bold text-gray-800 mb-3">Bukti</h2>
                <a href="/pendaftaran/cetak/{{ $pendaftar['nomor_peserta'] }}" target="_blank"
                   class="block text-center border border-gray-300 text-gray-700 text-xs font-semibold py-2 rounded-lg hover:bg-gray-50">
                    Lihat / Cetak Bukti
                </a>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
