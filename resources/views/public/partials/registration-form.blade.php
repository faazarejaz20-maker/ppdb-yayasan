        <form method="POST" action="{{ $action }}" @submit="if (!validateAll()) { $event.preventDefault(); }" novalidate>
            @csrf

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">

                {{-- LANGKAH 1 --}}
                <div x-show="step === 1" x-transition>
                    <h2 class="text-base font-bold text-gray-800 mb-1">Jenis Pendaftaran</h2>
                    <p class="text-xs text-gray-500 mb-5">Pilih jalur pendaftaran yang sesuai.</p>

                    <div class="space-y-3">
                        @if($school['jenjang'] !== 'TK')
                            <label class="block cursor-pointer">
                                <input type="radio" name="jenis" value="Lanjutan" x-model="form.jenis" @change="resetLookup()" class="peer sr-only">
                                <div class="border-2 border-gray-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 rounded-xl p-4 transition">
                                    <div class="font-semibold text-sm text-gray-800">Lulusan sekolah yayasan</div>
                                    <div class="text-xs text-gray-500 mt-1">Data siswa terisi otomatis menggunakan nomor induk.</div>
                                </div>
                            </label>
                        @endif

                        <label class="block cursor-pointer">
                            <input type="radio" name="jenis" value="Baru" x-model="form.jenis" @change="resetLookup()" class="peer sr-only">
                            <div class="border-2 border-gray-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 rounded-xl p-4 transition">
                                <div class="font-semibold text-sm text-gray-800">Pendaftar baru</div>
                                <div class="text-xs text-gray-500 mt-1">Isi seluruh data calon siswa secara manual.</div>
                            </div>
                        </label>
                    </div>
                    <p class="text-xs text-red-600 mt-2" x-show="errors.jenis" x-text="errors.jenis"></p>

                    {{-- Pencarian alumni --}}
                    <div x-show="form.jenis === 'Lanjutan'" x-transition class="mt-6 border-t border-gray-100 pt-5">
                        <h3 class="text-sm font-semibold text-gray-800 mb-3">Cari Data Alumni</h3>

                        <div class="grid sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Nomor Induk</label>
                                <input type="text" name="nomor_induk" x-model="form.nomor_induk" placeholder="Contoh: {{ $school['jenjang'] === 'SMP' ? '2019001' : '2021001' }}" class="{{ $inputClass }}">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir_alumni" x-model="form.tanggal_lahir_alumni" class="{{ $inputClass }}">
                            </div>
                        </div>

                        <button type="button" @click="lookupAlumni()"
                                class="mt-3 bg-gray-800 hover:bg-gray-900 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition">
                            Cari Data
                        </button>

                        <p class="text-xs text-red-600 mt-3" x-show="lookupError" x-text="lookupError"></p>

                        <div x-show="lookupDone" x-transition class="mt-3 bg-emerald-50 border border-emerald-100 rounded-lg p-4">
                            <p class="text-xs text-emerald-700 mb-1">Data ditemukan:</p>
                            <p class="text-sm font-bold text-emerald-900" x-text="maskedName"></p>
                            <p class="text-xs text-emerald-700 mt-1">Data siswa akan terisi otomatis dan tetap bisa diedit.</p>
                        </div>
                        <p class="text-xs text-red-600 mt-2" x-show="errors.lookup" x-text="errors.lookup"></p>

                        @if($school['jenjang'] === 'SMP')
                            <div x-show="gedungGratis" x-transition class="mt-3 bg-amber-50 border border-amber-100 rounded-lg p-3 text-xs text-amber-800">
                                <span class="font-semibold">Uang gedung gratis</span> untuk lulusan SDIT yang melanjutkan ke SMPIT.
                            </div>
                        @endif
                    </div>

                    @if($school['jenjang'] !== 'TK')
                        <p class="text-xs text-gray-400 mt-5">
                            Catatan demo:
                            @if($school['jenjang'] === 'SMP')
                                gunakan nomor induk <span class="font-semibold">2019001</span> dan tanggal lahir
                                <span class="font-semibold">2013-05-14</span>.
                            @else
                                gunakan nomor induk <span class="font-semibold">2021001</span> dan tanggal lahir
                                <span class="font-semibold">2019-03-09</span>.
                            @endif
                        </p>
                    @endif
                </div>

                {{-- LANGKAH 2 --}}
                <div x-show="step === 2" x-transition style="display: none;">
                    <h2 class="text-base font-bold text-gray-800 mb-1">Data Calon Siswa</h2>
                    <p class="text-xs text-gray-500 mb-5">Isi data sesuai akta kelahiran.</p>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Lengkap</label>
                            <input type="text" name="nama" x-model="form.nama" class="{{ $inputClass }}">
                            <p class="text-xs text-red-600 mt-1" x-show="errors.nama" x-text="errors.nama"></p>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Jenis Kelamin</label>
                                <select name="jenis_kelamin" x-model="form.jenis_kelamin" class="{{ $inputClass }}">
                                    <option value="">Pilih</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                                <p class="text-xs text-red-600 mt-1" x-show="errors.jenis_kelamin" x-text="errors.jenis_kelamin"></p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Agama</label>
                                <select name="agama" x-model="form.agama" class="{{ $inputClass }}">
                                    <option value="">Pilih</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                </select>
                                <p class="text-xs text-red-600 mt-1" x-show="errors.agama" x-text="errors.agama"></p>
                            </div>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" x-model="form.tempat_lahir" class="{{ $inputClass }}">
                                <p class="text-xs text-red-600 mt-1" x-show="errors.tempat_lahir" x-text="errors.tempat_lahir"></p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" x-model="form.tanggal_lahir" class="{{ $inputClass }}">
                                <p class="text-xs text-red-600 mt-1" x-show="errors.tanggal_lahir" x-text="errors.tanggal_lahir"></p>
                            </div>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Anak Ke-</label>
                                <input type="number" min="1" name="anak_ke" x-model="form.anak_ke" class="{{ $inputClass }}">
                                <p class="text-xs text-red-600 mt-1" x-show="errors.anak_ke" x-text="errors.anak_ke"></p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">
                                    NISN @if($school['jenjang'] === 'TK')<span class="font-normal text-gray-400">(opsional)</span>@endif
                                </label>
                                <input type="text" name="nisn" x-model="form.nisn" class="{{ $inputClass }}">
                                <p class="text-xs text-red-600 mt-1" x-show="errors.nisn" x-text="errors.nisn"></p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- LANGKAH 3 --}}
                <div x-show="step === 3" x-transition style="display: none;">
                    <h2 class="text-base font-bold text-gray-800 mb-1">Data Orang Tua / Wali</h2>
                    <p class="text-xs text-gray-500 mb-5">Nomor WhatsApp dipakai untuk pengumuman.</p>

                    <div class="space-y-4">
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Ayah</label>
                                <input type="text" name="nama_ayah" x-model="form.nama_ayah" class="{{ $inputClass }}">
                                <p class="text-xs text-red-600 mt-1" x-show="errors.nama_ayah" x-text="errors.nama_ayah"></p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Ibu</label>
                                <input type="text" name="nama_ibu" x-model="form.nama_ibu" class="{{ $inputClass }}">
                                <p class="text-xs text-red-600 mt-1" x-show="errors.nama_ibu" x-text="errors.nama_ibu"></p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Pekerjaan Orang Tua / Wali</label>
                            <input type="text" name="pekerjaan" x-model="form.pekerjaan" class="{{ $inputClass }}">
                            <p class="text-xs text-red-600 mt-1" x-show="errors.pekerjaan" x-text="errors.pekerjaan"></p>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Nomor WhatsApp <span class="text-red-500">*</span></label>
                            <input type="tel" name="whatsapp" x-model="form.whatsapp" placeholder="08xxxxxxxxxx" class="{{ $inputClass }}">
                            <p class="text-[11px] text-gray-400 mt-1">Nomor <span class="font-mono">08xx</span> otomatis diubah menjadi <span class="font-mono">628xx</span>.</p>
                            <p class="text-xs text-red-600 mt-1" x-show="errors.whatsapp" x-text="errors.whatsapp"></p>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Email <span class="font-normal text-gray-400">(opsional)</span></label>
                            <input type="email" name="email" x-model="form.email" class="{{ $inputClass }}">
                            <p class="text-xs text-red-600 mt-1" x-show="errors.email" x-text="errors.email"></p>
                        </div>
                    </div>
                </div>

                {{-- LANGKAH 4 --}}
                <div x-show="step === 4" x-transition style="display: none;">
                    <h2 class="text-base font-bold text-gray-800 mb-1">Alamat & Asal Sekolah</h2>
                    <p class="text-xs text-gray-500 mb-5">Alamat domisili calon siswa.</p>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Alamat Lengkap</label>
                            <textarea name="alamat" rows="3" x-model="form.alamat" class="{{ $inputClass }}"></textarea>
                            <p class="text-xs text-red-600 mt-1" x-show="errors.alamat" x-text="errors.alamat"></p>
                        </div>

                        <div x-show="!isTk">
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Asal Sekolah</label>
                            <input type="text" name="asal_sekolah" x-model="form.asal_sekolah" class="{{ $inputClass }}">
                            <p class="text-xs text-red-600 mt-1" x-show="errors.asal_sekolah" x-text="errors.asal_sekolah"></p>
                        </div>
                    </div>
                </div>

                {{-- LANGKAH 5 --}}
                <div x-show="step === 5" x-transition style="display: none;">
                    <h2 class="text-base font-bold text-gray-800 mb-1">Unggah Berkas</h2>
                    <p class="text-xs text-gray-500 mb-5">Format JPG/PNG/PDF, maksimal 2 MB per berkas. (Demo: file tidak disimpan.)</p>

                    <div class="space-y-3">
                        @foreach($requirements as $i => $req)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-start justify-between gap-3 mb-2">
                                    <div>
                                        <div class="text-sm font-semibold text-gray-800">{{ $req['label'] }}</div>
                                        <div class="text-xs text-gray-500">{{ $req['keterangan'] }}</div>
                                    </div>
                                    <div x-show="files[{{ $i }}]" class="text-emerald-600 shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                </div>
                                <input type="file" accept=".jpg,.jpeg,.png,.pdf" @change="handleFile({{ $i }}, $event)"
                                       class="block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                                <p class="text-xs text-emerald-700 mt-2" x-show="files[{{ $i }}]" x-text="files[{{ $i }}]?.name"></p>
                                <p class="text-xs text-red-600 mt-1" x-show="errors['file_{{ $i }}']" x-text="errors['file_{{ $i }}']"></p>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- LANGKAH 6 --}}
                <div x-show="step === 6" x-transition style="display: none;">
                    <h2 class="text-base font-bold text-gray-800 mb-1">Tinjau & Kirim</h2>
                    <p class="text-xs text-gray-500 mb-5">Periksa kembali data sebelum dikirim.</p>

                    @php
                        $sections = [
                            ['step' => 1, 'title' => 'Jenis Pendaftaran', 'rows' => ['jenis' => 'Jenis']],
                            ['step' => 2, 'title' => 'Data Calon Siswa', 'rows' => ['nama' => 'Nama', 'jenis_kelamin' => 'Jenis Kelamin', 'tempat_lahir' => 'Tempat Lahir', 'tanggal_lahir' => 'Tanggal Lahir', 'agama' => 'Agama', 'anak_ke' => 'Anak Ke-', 'nisn' => 'NISN']],
                            ['step' => 3, 'title' => 'Data Orang Tua / Wali', 'rows' => ['nama_ayah' => 'Nama Ayah', 'nama_ibu' => 'Nama Ibu', 'pekerjaan' => 'Pekerjaan', 'whatsapp' => 'WhatsApp', 'email' => 'Email']],
                            ['step' => 4, 'title' => 'Alamat & Asal Sekolah', 'rows' => ['alamat' => 'Alamat', 'asal_sekolah' => 'Asal Sekolah']],
                        ];
                    @endphp

                    <div class="space-y-4">
                        @foreach($sections as $section)
                            <div class="border border-gray-100 rounded-lg p-4 bg-gray-50/60">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-sm font-bold text-gray-800">{{ $section['title'] }}</h3>
                                    <button type="button" @click="goTo({{ $section['step'] }})" class="text-xs font-semibold text-emerald-700 hover:text-emerald-800">Ubah</button>
                                </div>
                                <dl class="space-y-1">
                                    @foreach($section['rows'] as $field => $label)
                                        <div class="flex justify-between gap-4 text-xs">
                                            <dt class="text-gray-500">{{ $label }}</dt>
                                            <dd class="font-semibold text-gray-800 text-right" x-text="form.{{ $field }} || '-'"></dd>
                                        </div>
                                    @endforeach
                                </dl>
                            </div>
                        @endforeach

                        <div class="border border-gray-100 rounded-lg p-4 bg-gray-50/60">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-sm font-bold text-gray-800">Berkas</h3>
                                <button type="button" @click="goTo(5)" class="text-xs font-semibold text-emerald-700 hover:text-emerald-800">Ubah</button>
                            </div>
                            <p class="text-xs text-gray-500">
                                <span x-text="Object.keys(files).length"></span> dari {{ count($requirements) }} berkas dipilih.
                            </p>
                        </div>

                        @if($school['jenjang'] === 'SMP')
                            <div x-show="gedungGratis" class="bg-amber-50 border border-amber-100 rounded-lg p-3 text-xs text-amber-800">
                                Pendaftar jalur lanjutan SDIT berhak atas <span class="font-semibold">uang gedung gratis</span>.
                            </div>
                        @endif
                    </div>

                    <label class="flex items-start gap-2 mt-5 cursor-pointer">
                        <input type="checkbox" name="pernyataan" value="1" x-model="form.pernyataan"
                               class="mt-0.5 w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                        <span class="text-xs text-gray-600">
                            Saya menyatakan data yang diisi benar dan bersedia mengikuti seluruh proses PPDB.
                        </span>
                    </label>
                    <p class="text-xs text-red-600 mt-1" x-show="errors.pernyataan" x-text="errors.pernyataan"></p>
                </div>
            </div>

            {{-- Navigasi --}}
            <div class="flex items-center justify-between gap-3 mt-5">
                <button type="button" @click="prev()" x-show="step > 1"
                        class="px-5 py-2.5 text-sm font-semibold text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Kembali
                </button>
                <div x-show="step === 1"></div>

                <button type="button" @click="next()" x-show="step < totalSteps"
                        class="px-6 py-2.5 text-sm font-semibold text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition">
                    Lanjut
                </button>

                <button type="submit" x-show="step === totalSteps"
                        class="px-6 py-2.5 text-sm font-semibold text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition">
                    {{ $submitLabel ?? 'Kirim Pendaftaran' }}
                </button>
            </div>
        </form>
