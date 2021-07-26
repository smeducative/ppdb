<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PesertaPPDB;

class FormulirController extends Controller
{
    public function showJurusanPeserta($jurusan)
    {
        $tahun = request('tahun', now()->year);

        $pesertappdb = PesertaPPDB::with('jurusan')
            ->whereJurusanId($jurusan)
            ->whereYear('created_at', $tahun)
            ->latest()->get();

        return view('pdf.formulir-ppdb', compact('pesertappdb', 'jurusan'));
    }

    public function cetakFormulir($jurusan)
    {
        $pesertappdb = PesertaPPDB::with(['jurusan'])
            ->whereJurusanId($jurusan)
            ->whereYear('created_at', now()->year)
            ->get();

        return view('pdf.cetak-formulir', compact('pesertappdb'));
    }

    public function cetakFormulirSingle($uuid)
    {
        $pesertappdb = PesertaPPDB::with(['jurusan'])
            ->whereId($uuid)
            ->get();

        return view('pdf.cetak-formulir', compact('pesertappdb'));
    }
}
