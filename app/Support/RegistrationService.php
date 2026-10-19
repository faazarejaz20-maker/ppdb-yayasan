<?php

namespace App\Support;

class RegistrationService
{
    public static function rules(array $school): array
    {
        return [
            'jenis' => 'required|in:Baru,Lanjutan',
            'nama' => 'required|string|max:120',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:80',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:40',
            'anak_ke' => 'required|integer|min:1|max:20',
            'nisn' => $school['jenjang'] === 'TK' ? 'nullable|string|max:20' : 'required|string|max:20',
            'nama_ayah' => 'required|string|max:120',
            'nama_ibu' => 'required|string|max:120',
            'pekerjaan' => 'required|string|max:120',
            'whatsapp' => ['required', 'regex:/^(\+?62|0)8[1-9][0-9]{6,11}$/'],
            'email' => 'nullable|email|max:120',
            'alamat' => 'required|string|max:500',
            'asal_sekolah' => $school['jenjang'] === 'TK' ? 'nullable|string|max:120' : 'required|string|max:120',
            'pernyataan' => 'accepted',
        ];
    }

    public static function create(array $validated, array $school): string
    {
        $nomorPeserta = DemoData::nextParticipantNumber($school['code']);

        $pendaftar = [
            'nomor_peserta' => $nomorPeserta,
            'school_code' => $school['code'],
            'jenis' => $validated['jenis'],
            'nama' => $validated['nama'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'tempat_lahir' => $validated['tempat_lahir'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'agama' => $validated['agama'],
            'anak_ke' => (int) $validated['anak_ke'],
            'nisn' => $validated['nisn'] ?? null,
            'nama_ayah' => $validated['nama_ayah'],
            'nama_ibu' => $validated['nama_ibu'],
            'pekerjaan' => $validated['pekerjaan'],
            'whatsapp' => self::normalizeWhatsapp($validated['whatsapp']),
            'email' => $validated['email'] ?? null,
            'alamat' => $validated['alamat'],
            'asal_sekolah' => $validated['asal_sekolah'] ?? null,
            'status' => 'terdaftar',
            'tanggal_daftar' => now()->toDateString(),
            'pengumuman_terkirim' => false,
        ];

        $existing = session('new_pendaftar', []);
        $existing[] = $pendaftar;
        session(['new_pendaftar' => $existing]);

        return $nomorPeserta;
    }

    public static function normalizeWhatsapp(string $number): string
    {
        $number = preg_replace('/[^0-9]/', '', $number);

        if (str_starts_with($number, '0')) {
            return '62' . substr($number, 1);
        }

        if (str_starts_with($number, '8')) {
            return '62' . $number;
        }

        return $number;
    }
}
