<?php

namespace App\Http\Controllers;

use App\Exports\BeasiswaExport;
use App\Models\PesertaPPDB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

        // if request has export and value of export is mwc
        if ($request->isMethod('post')) {
            return Excel::download(new BeasiswaExport($pesertappdb), $tahun . '-beasiswa-rekomendasi-mwc.xlsx');
        }

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

        // if request has export and value of export is mwc
        if ($request->isMethod('post')) {
            return Excel::download(new BeasiswaExport($pesertappdb), $tahun . '-beasiswa-akademik.xlsx');
        }

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

        // if request has export and value of export is mwc
        if ($request->isMethod('post')) {
            return Excel::download(new BeasiswaExport($pesertappdb), $tahun . '-beasiswa-non-akademik.xlsx');
        }

        return view('ppdb.beasiswa.index', compact('pesertappdb', 'title'));
    }

    // beasiswa KIP
    public function beasiswaKIP(Request $request)
    {
        $tahun = request('tahun', now()->year);
        $title = 'Beasiswa KIP';

        // column akademik is json
        // {"kelas":"","semester":"","peringkat":"","hafidz":""}
        // where all column is null
        $pesertappdb = PesertaPPDB::with('jurusan')
            ->where('penerima_kip', 'y')
            ->whereYear('created_at', $tahun)
            ->latest()
            ->get();

        // if request has export and value of export is mwc
        if ($request->isMethod('post')) {
            return Excel::download(new BeasiswaExport($pesertappdb), $tahun . '-beasiswa-kip.xlsx');
        }

        return view('ppdb.beasiswa.index', compact('pesertappdb', 'title'));
    }

    // beasiswa Tahfidz (Akademik Hafidz/Hafidzoh)
    public function beasiswaTahfidz(Request $request)
    {
        $tahun = request('tahun', now()->year);
        $title = 'Beasiswa Akademik [Tahfidz]';

        // column akademik is json
        // {"kelas":"","semester":"","peringkat":"","hafidz":""}
        // filter where hafidz is not empty
        $pesertappdb = PesertaPPDB::with('jurusan')
            ->where('akademik->hafidz', '!=', "")
            ->where('akademik->hafidz', '!=', "-")
            ->where('akademik->hafidz', '!=', "_")
            ->whereYear('created_at', $tahun)
            ->latest()
            ->get();

        // if request has export
        if ($request->isMethod('post')) {
            return Excel::download(new BeasiswaExport($pesertappdb), $tahun . '-beasiswa-tahfidz.xlsx');
        }

        return view('ppdb.beasiswa.index', compact('pesertappdb', 'title'));
    }
}
