<?php

namespace App\Http\Controllers;

use App\Support\DemoData;
use App\Support\RegistrationService;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function create(string $slug)
    {
        $school = DemoData::getSchoolBySlug($slug);

        if (!$school) {
            abort(404);
        }

        if (!DemoData::isRegistrationOpen($school)) {
            return redirect('/' . $slug)->with('error', 'Pendaftaran untuk sekolah ini sedang ditutup.');
        }

        $requirements = DemoData::requirements()[$school['jenjang']];
        $alumni = $school['jenjang'] === 'TK'
            ? []
            : DemoData::alumniForJenjang($school['jenjang']);

        return view('public.register', compact('school', 'requirements', 'alumni'));
    }

    public function store(Request $request, string $slug)
    {
        $school = DemoData::getSchoolBySlug($slug);

        if (!$school) {
            abort(404);
        }

        if (!DemoData::isRegistrationOpen($school)) {
            return redirect('/' . $slug)->with('error', 'Pendaftaran untuk sekolah ini sedang ditutup.');
        }

        $validated = $request->validate(RegistrationService::rules($school));

        $nomorPeserta = RegistrationService::create($validated, $school);

        return redirect('/pendaftaran/sukses/' . $nomorPeserta);
    }

    public function success(string $nomorPeserta)
    {
        $pendaftar = \App\Support\DemoStore::find($nomorPeserta);

        if (!$pendaftar) {
            abort(404);
        }

        $school = DemoData::getSchoolByCode($pendaftar['school_code']);

        return view('public.register-success', compact('pendaftar', 'school'));
    }

    public function print(string $nomorPeserta)
    {
        $pendaftar = \App\Support\DemoStore::find($nomorPeserta);

        if (!$pendaftar) {
            abort(404);
        }

        $school = DemoData::getSchoolByCode($pendaftar['school_code']);

        return view('public.register-print', compact('pendaftar', 'school'));
    }
}
