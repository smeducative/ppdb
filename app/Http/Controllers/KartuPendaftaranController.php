<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PesertaPPDB;

class KartuPendaftaranController extends Controller
{
    public function showJurusanPeserta($jurusan)
    {
        $pesertappdb = PesertaPPDB::with('jurusan')->where('diterima', 1)
            ->whereJurusanId($jurusan)->latest()->get();

        return view('pdf.kartu-ppdb', compact('pesertappdb'));
    }

    public function cetakKartu()
    {
        $pesertappdb = PesertaPPDB::with(['jurusan'])
            ->where('diterima', 1)
            ->whereYear('created_at', now()->year)
            ->get();

        return view('pdf.cetak-kartu', compact('pesertappdb'));
    }

    public function cetakKartuSingle($uuid)
    {
        $pesertappdb = PesertaPPDB::with(['jurusan'])
            ->where('diterima', 1)
            ->whereId($uuid)
            ->get();

        return view('pdf.cetak-kartu', compact('pesertappdb'));
    }
}
