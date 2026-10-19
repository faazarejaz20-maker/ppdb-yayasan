<?php

namespace App\Http\Controllers;

use App\Support\DemoData;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $schools = DemoData::schools();
        
        return view('public.home', compact('schools'));
    }

    public function school(string $slug)
    {
        $school = DemoData::getSchoolBySlug($slug);
        
        if (!$school) {
            abort(404);
        }

        $schools = DemoData::schools();
        $requirements = DemoData::requirements()[$school['jenjang']];
        $isOpen = DemoData::isRegistrationOpen($school);
        
        return view('public.school', compact('school', 'schools', 'requirements', 'isOpen'));
    }

    public function checkRegistration()
    {
        return view('public.check-registration');
    }

    public function checkRegistrationSubmit(Request $request)
    {
        $request->validate([
            'nomor_peserta' => 'required',
            'tanggal_lahir' => 'required|date'
        ]);

        // Cari di data contoh dan pendaftar baru (session)
        $pendaftar = \App\Support\DemoStore::find($request->nomor_peserta);

        if (!$pendaftar || $pendaftar['tanggal_lahir'] !== $request->tanggal_lahir) {
            return back()->with('error', 'Data tidak ditemukan. Periksa kembali nomor peserta dan tanggal lahir.');
        }

        return view('public.check-result', compact('pendaftar'));
    }
}
