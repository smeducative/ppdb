<?php

namespace App\Http\Controllers;

use App\Models\PpdbSetting;

class PpdbSettingController extends Controller
{
    public function index()
    {
        $setting = PpdbSetting::latest()->first();

        return inertia('Admin/Settings/Ppdb', compact('setting'));
    }

    public function setBatasAkhir()
    {
        $batas = PpdbSetting::latest()->first();

        // Create if not exists (handling edge case if table is empty, though view assumed it exists)
        if (!$batas) {
            $batas = PpdbSetting::create(['body' => []]);
        }

        $batas->update([
            'body' => [
                'batas_akhir_ppdb' => request('batas_akhir_ppdb'),
                'no_surat' => request('no_surat'),
                'hasil_seleksi' => request('hasil_seleksi'),
            ],
        ]);

        session()->flash('success', 'Pengaturan PPDB telah di ubah');

        return back();
    }
}
