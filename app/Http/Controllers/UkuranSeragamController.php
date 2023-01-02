<?php

namespace App\Http\Controllers;

use App\Models\PesertaPPDB;
use App\Models\UkuranSeragam;

class UkuranSeragamController extends Controller
{
    public function showJurusanPeserta($jurusan)
    {
        $tahun = request('tahun', now()->year);

        $pesertappdb = PesertaPPDB::with(['jurusan', 'ukuranSeragam'])->where('diterima', 1)
            ->whereJurusanId($jurusan)
            ->whereYear('created_at', $tahun)->latest()->get();

        return view('ppdb.ukuran-seragam', compact('pesertappdb'));
    }

    public function ubahUkuranSeragam()
    {
        $peserta = UkuranSeragam::updateOrCreate(
            ['peserta_ppdb_id' => request('uuid')],
            [
                'baju' => request('baju'),
                'jas' => request('jas'),
                'sepatu' => request('sepatu'),
                'peci' => request('peci'),
            ]
        );

        session()->flash('success', 'data ukuran di ubah');

        return back();
    }
}
