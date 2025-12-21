<?php

namespace App\Http\Controllers;

use App\Models\PesertaPPDB;

class FormulirController extends Controller
{
    public function showJurusanPeserta($jurusan)
    {
        $tahun = request('tahun', now()->year);
        $search = request('search');

        $pesertappdb = PesertaPPDB::with('jurusan')
            ->whereJurusanId($jurusan)
            // ->whereDiterima(1)
            ->whereYear('created_at', $tahun)
            ->when($search, function ($query, $search) {
                $query->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('no_pendaftaran', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $years = range(now()->year, now()->year - 5);

        return inertia('Admin/Document/Index', [
            'pesertappdb' => $pesertappdb,
            'tahun' => $tahun,
            'years' => $years,
            'jurusan' => $jurusan,
            'title' => 'Formulir Pendaftaran Peserta PPDB',
            'printSingleRoute' => 'ppdb.cetak.formulir',
            'printAllRoute' => 'ppdb.cetak.formulir.semua',
            'showSettings' => false,
        ]);
    }

    public function cetakFormulir($jurusan)
    {
        $pesertappdb = PesertaPPDB::with(['jurusan'])
            ->whereJurusanId($jurusan)
            // ->whereDiterima(1)
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
