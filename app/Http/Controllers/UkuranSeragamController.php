<?php

namespace App\Http\Controllers;

use App\Models\PesertaPPDB;
use App\Models\UkuranSeragam;

class UkuranSeragamController extends Controller
{
    public function showJurusanPeserta($jurusan = null)
    {
        $tahun = request('tahun', now()->year);
        $search = request('search');

        $pesertappdb = PesertaPPDB::with(['jurusan', 'ukuranSeragam'])->where('diterima', 1)
            ->when($jurusan, fn($q) => $q->whereJurusanId($jurusan))
            ->whereYear('created_at', $tahun)
            ->when($search, function ($query, $search) {
                $query->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('no_pendaftaran', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $years = range(now()->year, now()->year - 5);

        return inertia('Admin/UkuranSeragam/Index', compact('pesertappdb', 'tahun', 'years', 'jurusan'));
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
