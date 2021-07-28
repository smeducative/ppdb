<?php

namespace App\Http\Controllers;

use App\Models\PesertaPPDB;

use Illuminate\Http\Request;

class SuratController extends Controller
{
    public function showJurusanPeserta($jurusan)
    {
        $tahun = request('tahun', now()->year);

        $pesertappdb = PesertaPPDB::with('jurusan')
            ->whereJurusanId($jurusan)
            ->whereDiterima(1)
            ->whereYear('created_at', $tahun)
            ->latest()->get();

        return view('pdf.surat', compact('pesertappdb', 'jurusan'));
    }

    public function cetakSurat($jurusan)
    {
        $pesertappdb = PesertaPPDB::with(['jurusan'])
            ->whereJurusanId($jurusan)
            ->whereDiterima(1)
            ->whereYear('created_at', now()->year)
            ->get();

        return view('pdf.cetak-surat', compact('pesertappdb'));
    }

    public function cetakSuratSingle($uuid)
    {
        $pesertappdb = PesertaPPDB::with(['jurusan'])
            ->whereId($uuid)
            ->get();

        return view('pdf.cetak-surat', compact('pesertappdb'));
    }
}
