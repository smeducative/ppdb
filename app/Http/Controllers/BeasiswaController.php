<?php

namespace App\Http\Controllers;

use App\Models\PesertaPPDB;
use Illuminate\Http\Request;

class BeasiswaController extends Controller
{
    public function rekomendasiMwc(Request $request)
    {
        $tahun = request('tahun', now()->year);
        $title = 'Beasiswa Rekomendasi MWC';

        $pesertappdb = PesertaPPDB::with('jurusan')->whereRekomendasiMwc(1)
            ->whereYear('created_at', $tahun)
            ->latest()
            ->get();

        return view('ppdb.beasiswa.index', compact('pesertappdb', 'title'));
    }

    // beasiswa akademik
    public function beasiswaAkademik(Request $request)
    {
        $tahun = request('tahun', now()->year);
        $title = 'Beasiswa Akademik';

        // column akademik is json
        // {"kelas":"","semester":"","peringkat":"","hafidz":""}
        // where all column is null
        $pesertappdb = PesertaPPDB::query()->with('jurusan')
            ->where('akademik->kelas', '!=', "")
            ->where('akademik->semester', '!=', "")
            ->where('akademik->peringkat', '!=', "")
            ->whereYear('created_at', $tahun)
            ->latest()
            ->get();

        return view('ppdb.beasiswa.index', compact('pesertappdb', 'title'));
    }

    // beasiswa non akademik
    public function beasiswaNonAkademik(Request $request)
    {
        $tahun = request('tahun', now()->year);
        $title = 'Beasiswa Non Akademik';

        // column non akademik is json
        // {"jenis_lomba":"","juara_ke":"","juara_tingkat":""}
        // where all column is null / ""
        $pesertappdb = PesertaPPDB::with('jurusan')
            ->where('non_akademik->jenis_lomba', '!=', "")
            ->where('non_akademik->juara_ke', '!=', "")
            ->where('non_akademik->juara_tingkat', '!=', "")
            ->whereYear('created_at', $tahun)
            ->latest()
            ->get();

        return view('ppdb.beasiswa.index', compact('pesertappdb', 'title'));
    }

    // beasiswa KIP
    public function beasiswaKIP(Request $request)
    {
        $tahun = request('tahun', now()->year);
        $title = 'Beasiswa Non Akademik';

        // column akademik is json
        // {"kelas":"","semester":"","peringkat":"","hafidz":""}
        // where all column is null
        $pesertappdb = PesertaPPDB::with('jurusan')
            ->where('penerima_kip', 'y')
            ->whereYear('created_at', $tahun)
            ->latest()
            ->get();

        return view('ppdb.beasiswa.index', compact('pesertappdb', 'title'));
    }
}
