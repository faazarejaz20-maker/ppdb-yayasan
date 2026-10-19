<?php

namespace App\Http\Controllers;

use App\Support\DemoData;
use App\Support\DemoStore;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function schools()
    {
        return view('super-admin.schools', [
            'schools' => DemoStore::schools(),
        ]);
    }

    public function toggleSchool(string $code)
    {
        if (!DemoData::getSchoolByCode($code)) {
            abort(404);
        }

        DemoStore::toggleSchool($code);

        return back()->with('success', 'Status sekolah berhasil diperbarui.');
    }

    public function accounts(string $scope)
    {
        abort_unless(in_array($scope, ['admin', 'yayasan'], true), 404);

        return view('super-admin.accounts', [
            'scope' => $scope,
            'title' => $scope === 'admin' ? 'Akun Admin Sekolah' : 'Akun Yayasan',
            'accounts' => DemoStore::accounts($scope),
            'schools' => DemoData::schools(),
        ]);
    }

    public function storeAccount(Request $request, string $scope)
    {
        abort_unless(in_array($scope, ['admin', 'yayasan'], true), 404);

        $rules = [
            'nama' => 'required|string|max:120',
            'email' => 'required|email|max:120',
            'sekolah' => $scope === 'admin' ? 'required|string' : 'nullable|string',
        ];

        $validated = $request->validate($rules);

        $school = $scope === 'admin' && $validated['sekolah']
            ? DemoData::getSchoolByCode($validated['sekolah'])
            : null;

        DemoStore::addAccount($scope, [
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'sekolah' => $school['code'] ?? null,
            'nama_sekolah' => $school['name'] ?? 'Yayasan',
        ]);

        return back()->with('success', 'Akun baru berhasil ditambahkan.');
    }

    public function toggleAccount(string $scope, string $email)
    {
        abort_unless(in_array($scope, ['admin', 'yayasan'], true), 404);

        DemoStore::toggleAccount($scope, urldecode($email));

        return back()->with('success', 'Status akun berhasil diperbarui.');
    }

    public function resetPassword(string $scope, string $email)
    {
        abort_unless(in_array($scope, ['admin', 'yayasan'], true), 404);

        $password = DemoStore::resetPassword($scope, urldecode($email));

        return back()->with('success', 'Password sementara: ' . $password);
    }

    public function settings()
    {
        return view('super-admin.settings', [
            'settings' => DemoData::settings(),
        ]);
    }
}
