export default function registrationWizard(config) {
    const old = config.old || {};
    const isTk = config.jenjang === 'TK';
    const isSmp = config.jenjang === 'SMP';

    const value = (key, fallback = '') => old[key] ?? fallback;

    return {
        step: config.initialStep || 1,
        totalSteps: 6,
        jenjang: config.jenjang,
        isTk,
        isSmp,
        alumni: config.alumni || [],
        requirements: config.requirements || [],
        errors: { ...(config.serverErrors || {}) },
        serverErrors: config.serverErrors || {},
        lookupError: '',
        lookupDone: false,
        alumniMatch: null,
        maskedName: '',
        files: {},

        form: {
            jenis: value('jenis', isTk ? 'Baru' : ''),            nomor_induk: value('nomor_induk'),
            tanggal_lahir_alumni: value('tanggal_lahir_alumni'),
            nama: value('nama'),
            jenis_kelamin: value('jenis_kelamin'),
            tempat_lahir: value('tempat_lahir'),
            tanggal_lahir: value('tanggal_lahir'),
            agama: value('agama'),
            anak_ke: value('anak_ke'),
            nisn: value('nisn'),
            nama_ayah: value('nama_ayah'),
            nama_ibu: value('nama_ibu'),
            pekerjaan: value('pekerjaan'),
            whatsapp: value('whatsapp'),
            email: value('email'),
            alamat: value('alamat'),
            asal_sekolah: value('asal_sekolah'),
            pernyataan: value('pernyataan') === '1',
        },

        init() {
            if (this.form.jenis === 'Lanjutan' && this.form.nomor_induk && this.form.tanggal_lahir_alumni) {
                const found = this.alumni.find(
                    (item) => item.nomor_induk === this.form.nomor_induk
                        && item.tanggal_lahir === this.form.tanggal_lahir_alumni
                );

                if (found) {
                    this.alumniMatch = found;
                    this.maskedName = this.maskName(found.nama);
                    this.lookupDone = true;
                }
            }
        },

        get gedungGratis() {
            return this.isSmp && this.form.jenis === 'Lanjutan';
        },

        get progress() {
            return Math.round((this.step / this.totalSteps) * 100);
        },

        next() {
            if (!this.validateStep(this.step)) {
                return;
            }

            if (this.step < this.totalSteps) {
                this.step++;
                this.scrollTop();
            }
        },

        prev() {
            if (this.step > 1) {
                this.step--;
                this.scrollTop();
            }
        },

        goTo(step) {
            if (step < this.step) {
                this.step = step;
                this.scrollTop();
            }
        },

        scrollTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },

        resetLookup() {
            this.lookupDone = false;
            this.alumniMatch = null;
            this.maskedName = '';
            this.lookupError = '';
        },

        lookupAlumni() {
            this.lookupError = '';
            this.alumniMatch = null;
            this.lookupDone = false;

            const nomorInduk = (this.form.nomor_induk || '').trim();
            const tanggalLahir = this.form.tanggal_lahir_alumni;

            if (!nomorInduk || !tanggalLahir) {
                this.lookupError = 'Isi nomor induk dan tanggal lahir terlebih dahulu.';
                return;
            }

            const found = this.alumni.find(
                (item) => item.nomor_induk === nomorInduk && item.tanggal_lahir === tanggalLahir
            );

            if (!found) {
                this.lookupError = 'Data tidak ditemukan. Periksa kembali nomor induk dan tanggal lahir, atau hubungi panitia sekolah.';
                return;
            }

            this.alumniMatch = found;
            this.maskedName = this.maskName(found.nama);
            this.lookupDone = true;

            this.form.nama = found.nama;
            this.form.tanggal_lahir = found.tanggal_lahir;
            this.form.asal_sekolah = found.asal_sekolah;
        },

        maskName(name) {
            return name
                .split(' ')
                .filter((word) => word.length > 0)
                .map((word, index) => {
                    if (index === 0) {
                        return word.slice(0, 3) + '**';
                    }

                    return word.slice(0, 2) + '***';
                })
                .join(' ');
        },

        handleFile(index, event) {
            const file = event.target.files[0];
            const key = 'file_' + index;

            delete this.errors[key];

            if (!file) {
                delete this.files[index];
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                this.errors[key] = 'Ukuran berkas maksimal 2 MB.';
                delete this.files[index];
                event.target.value = '';
                return;
            }

            this.files[index] = { name: file.name };
        },

        validateStep(step) {
            this.errors = {};

            if (step === 1) {
                if (!this.form.jenis) {
                    this.errors.jenis = 'Pilih jenis pendaftaran.';
                }

                if (this.form.jenis === 'Lanjutan' && !this.lookupDone) {
                    this.errors.lookup = 'Cari dan pastikan data alumni terlebih dahulu.';
                }
            }

            if (step === 2) {
                this.require('nama', 'Nama lengkap wajib diisi.');
                this.require('jenis_kelamin', 'Jenis kelamin wajib dipilih.');
                this.require('tempat_lahir', 'Tempat lahir wajib diisi.');
                this.require('tanggal_lahir', 'Tanggal lahir wajib diisi.');
                this.require('agama', 'Agama wajib dipilih.');
                this.require('anak_ke', 'Anak ke-berapa wajib diisi.');

                if (!this.isTk) {
                    this.require('nisn', 'NISN wajib diisi untuk jenjang ini.');
                }
            }

            if (step === 3) {
                this.require('nama_ayah', 'Nama ayah wajib diisi.');
                this.require('nama_ibu', 'Nama ibu wajib diisi.');
                this.require('pekerjaan', 'Pekerjaan orang tua/wali wajib diisi.');
                this.require('whatsapp', 'Nomor WhatsApp wajib diisi.');

                if (this.form.whatsapp && !/^(\+?62|0)8[1-9][0-9]{6,11}$/.test(this.form.whatsapp)) {
                    this.errors.whatsapp = 'Format nomor WhatsApp tidak valid (contoh: 08123456789).';
                }

                if (this.form.email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.form.email)) {
                    this.errors.email = 'Format email tidak valid.';
                }
            }

            if (step === 4) {
                this.require('alamat', 'Alamat lengkap wajib diisi.');

                if (!this.isTk) {
                    this.require('asal_sekolah', 'Asal sekolah wajib diisi.');
                }
            }

            if (step === 6) {
                if (!this.form.pernyataan) {
                    this.errors.pernyataan = 'Centang pernyataan sebelum mengirim.';
                }
            }

            return Object.keys(this.errors).length === 0;
        },

        validateAll() {
            for (let step = 1; step <= this.totalSteps; step++) {
                if (!this.validateStep(step)) {
                    this.step = step;
                    this.scrollTop();
                    return false;
                }
            }

            return true;
        },

        require(field, message) {
            const value = this.form[field];

            if (value === null || value === undefined || String(value).trim() === '') {
                this.errors[field] = message;
            }
        },
    };
}
