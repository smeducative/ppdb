<?php

namespace App\Http\Controllers;

use App\Models\PesertaPPDB;

class SuratController extends Controller
{
    public function showJurusanPeserta($jurusan)
    {
        $tahun = request('tahun', now()->year);
        $search = request('search');

        $pesertappdb = PesertaPPDB::with('jurusan')
            ->whereJurusanId($jurusan)
            ->whereDiterima(1)
            ->whereYear('created_at', $tahun)
            ->when($search, function ($query, $search) {
                $query->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('no_pendaftaran', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $years = range(now()->year, now()->year - 5);
        $settingBody = optional((\App\Models\PpdbSetting::latest()->first())->body);
        $settings = [
            'no_surat' => $settingBody['no_surat'] ?? '-',
            'batas_akhir_ppdb' => $settingBody['batas_akhir_ppdb'] ?? null,
        ];

        return inertia('Admin/Document/Index', [
            'pesertappdb' => $pesertappdb,
            'tahun' => $tahun,
            'years' => $years,
            'jurusan' => $jurusan,
            'title' => 'Surat Diterima Peserta PPDB',
            'printSingleRoute' => 'ppdb.cetak.surat',
            'printAllRoute' => 'ppdb.cetak.surat.semua',
            'showSettings' => true,
            'settings' => $settings,
        ]);
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
