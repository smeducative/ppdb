<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PpdbSetting;

class PpdbSettingController extends Controller
{
    public function setBatasAkhir()
    {
        $batas = PpdbSetting::latest()->first();

        $batas->update([
            'body' => [
                'batas_akhir_ppdb'  => request('batas_akhir_ppdb'),
                'no_surat'  => request('no_surat'),
                'hasil_seleksi' => request('hasil_seleksi')
            ]
        ]);

        session()->flash('success', 'Pengaturan PPDB telah di ubah');

        return back();
    }
}
