<?php

namespace App\Http\Controllers;

use App\Exports\BeasiswaExport;
use App\Http\Requests\BeasiswaFilterRequest;
use App\Models\PesertaPPDB;
use Maatwebsite\Excel\Facades\Excel;

class BeasiswaController extends Controller
{
    public function rekomendasiMwc(BeasiswaFilterRequest $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $search = $request->input('search');
        $title = 'Beasiswa Rekomendasi MWC';

        $query = PesertaPPDB::with('jurusan')->whereRekomendasiMwc(1)
            ->whereYear('created_at', $tahun)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('no_pendaftaran', 'like', "%{$search}%")
                        ->orWhere('asal_sekolah', 'like', "%{$search}%");
                });
            })
            ->latest();

        if ($request->isMethod('post')) {
            $pesertappdb = $query->get();

            return Excel::download(new BeasiswaExport($pesertappdb), $tahun.'-beasiswa-rekomendasi-mwc.xlsx');
        }

        $pesertappdb = $query->paginate($request->input('per_page', 10))->withQueryString();

        $years = range(now()->year, now()->year - 5);

        return inertia('Admin/Beasiswa/Index', compact('pesertappdb', 'title', 'tahun', 'years'));
    }

    // beasiswa akademik
    public function beasiswaAkademik(BeasiswaFilterRequest $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $search = $request->input('search');
        $title = 'Beasiswa Akademik';

        // column akademik is json
        // {"kelas":"","semester":"","peringkat":"","hafidz":""}
        // where all column is null
        // where all column is null
        $query = PesertaPPDB::query()->with('jurusan')
            ->where('akademik->kelas', '!=', '')
            ->where('akademik->semester', '!=', '')
            ->where('akademik->peringkat', '!=', '')
            ->whereYear('created_at', $tahun)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('no_pendaftaran', 'like', "%{$search}%")
                        ->orWhere('asal_sekolah', 'like', "%{$search}%");
                });
            })
            ->latest();

        // if request has export and value of export is mwc
        if ($request->isMethod('post')) {
            $pesertappdb = $query->get();

            return Excel::download(new BeasiswaExport($pesertappdb), $tahun.'-beasiswa-akademik.xlsx');
        }

        $pesertappdb = $query->paginate($request->input('per_page', 10))->withQueryString();
        $years = range(now()->year, now()->year - 5);

        return inertia('Admin/Beasiswa/Index', compact('pesertappdb', 'title', 'tahun', 'years'));
    }

    // beasiswa non akademik
    public function beasiswaNonAkademik(BeasiswaFilterRequest $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $search = $request->input('search');
        $title = 'Beasiswa Non Akademik';

        // column non akademik is json
        // {"jenis_lomba":"","juara_ke":"","juara_tingkat":""}
        // where all column is null / ""
        // where all column is null / ""
        $query = PesertaPPDB::with('jurusan')
            ->where('non_akademik->jenis_lomba', '!=', '')
            ->where('non_akademik->juara_ke', '!=', '')
            ->where('non_akademik->juara_tingkat', '!=', '')
            ->whereYear('created_at', $tahun)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('no_pendaftaran', 'like', "%{$search}%")
                        ->orWhere('asal_sekolah', 'like', "%{$search}%");
                });
            })
            ->latest();

        // if request has export and value of export is mwc
        if ($request->isMethod('post')) {
            $pesertappdb = $query->get();

            return Excel::download(new BeasiswaExport($pesertappdb), $tahun.'-beasiswa-non-akademik.xlsx');
        }

        $pesertappdb = $query->paginate($request->input('per_page', 10))->withQueryString();
        $years = range(now()->year, now()->year - 5);

        return inertia('Admin/Beasiswa/Index', compact('pesertappdb', 'title', 'tahun', 'years'));
    }

    // beasiswa KIP
    public function beasiswaKIP(BeasiswaFilterRequest $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $search = $request->input('search');
        $title = 'Beasiswa KIP';

        // column akademik is json
        // {"kelas":"","semester":"","peringkat":"","hafidz":""}
        // where all column is null
        // where all column is null
        $query = PesertaPPDB::with('jurusan')
            ->where('penerima_kip', 'y')
            ->whereYear('created_at', $tahun)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('no_pendaftaran', 'like', "%{$search}%")
                        ->orWhere('asal_sekolah', 'like', "%{$search}%");
                });
            })
            ->latest();

        // if request has export and value of export is mwc
        if ($request->isMethod('post')) {
            $pesertappdb = $query->get();

            return Excel::download(new BeasiswaExport($pesertappdb), $tahun.'-beasiswa-kip.xlsx');
        }

        $pesertappdb = $query->paginate($request->input('per_page', 10))->withQueryString();
        $years = range(now()->year, now()->year - 5);

        return inertia('Admin/Beasiswa/Index', compact('pesertappdb', 'title', 'tahun', 'years'));
    }

    // beasiswa Tahfidz (Akademik Hafidz/Hafidzoh)
    public function beasiswaTahfidz(BeasiswaFilterRequest $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $search = $request->input('search');
        $title = 'Beasiswa Akademik [Tahfidz]';

        // column akademik is json
        // {"kelas":"","semester":"","peringkat":"","hafidz":""}
        // filter where hafidz is not empty
        // filter where hafidz is not empty
        $query = PesertaPPDB::with('jurusan')
            ->where('akademik->hafidz', '!=', '')
            ->where('akademik->hafidz', '!=', '-')
            ->where('akademik->hafidz', '!=', '_')
            ->whereYear('created_at', $tahun)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('no_pendaftaran', 'like', "%{$search}%")
                        ->orWhere('asal_sekolah', 'like', "%{$search}%");
                });
            })
            ->latest();

        // if request has export
        if ($request->isMethod('post')) {
            $pesertappdb = $query->get();

            return Excel::download(new BeasiswaExport($pesertappdb), $tahun.'-beasiswa-tahfidz.xlsx');
        }

        $pesertappdb = $query->paginate($request->input('per_page', 10))->withQueryString();
        $years = range(now()->year, now()->year - 5);

        return inertia('Admin/Beasiswa/Index', compact('pesertappdb', 'title', 'tahun', 'years'));
    }
}
