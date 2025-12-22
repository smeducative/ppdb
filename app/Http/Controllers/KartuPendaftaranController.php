<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentFilterRequest;
use App\Models\PesertaPPDB;

class KartuPendaftaranController extends Controller
{
    public function showJurusanPeserta(DocumentFilterRequest $request, $jurusan)
    {
        $tahun = $request->input('tahun', now()->year);
        $search = $request->input('search');

        $pesertappdb = PesertaPPDB::with('jurusan')
            ->whereJurusanId($jurusan)
            // ->whereDiterima(1)
            ->whereYear('created_at', $tahun)
            ->when($search, function ($query, $search) {
                $query->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('no_pendaftaran', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate($request->input('per_page', 10))
            ->withQueryString();

        $years = range(now()->year, now()->year - 5);

        return inertia('Admin/Document/Index', [
            'pesertappdb' => $pesertappdb,
            'tahun' => $tahun,
            'years' => $years,
            'jurusan' => $jurusan,
            'title' => 'Kartu Pendaftaran Peserta PPDB',
            'printSingleRoute' => 'ppdb.cetak.kartu',
            'printAllRoute' => 'ppdb.cetak.kartu.semua',
            'showSettings' => false,
        ]);
    }

    public function cetakKartu($jurusan)
    {
        $pesertappdb = PesertaPPDB::with(['jurusan'])
            ->whereJurusanId($jurusan)
            // ->whereDiterima(1)
            ->whereYear('created_at', now()->year)
            ->get();

        return view('pdf.cetak-kartu', compact('pesertappdb'));
    }

    public function cetakKartuSingle($uuid)
    {
        $pesertappdb = PesertaPPDB::with(['jurusan'])
            ->whereId($uuid)
            ->get();

        return view('pdf.cetak-kartu', compact('pesertappdb'));
    }
}
