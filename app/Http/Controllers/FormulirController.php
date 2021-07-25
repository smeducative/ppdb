<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormulirController extends Controller
{
    public function showJurusanPeserta($jurusan)
    {
        $pesertappdb = PesertaPPDB::with('jurusan')
            ->whereJurusanId($jurusan)->latest()->get();

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