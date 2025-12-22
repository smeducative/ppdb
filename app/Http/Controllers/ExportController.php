<?php

namespace App\Http\Controllers;

use App\Exports\PesertaPPDBExport;
use App\Exports\RekapSekolahExport;
use App\Exports\SeragamExport;
use App\Http\Requests\ExportPesertaRequest;
use App\Http\Requests\ExportRekapSekolahRequest;
use App\Http\Requests\ExportSeragamRequest;
use App\Models\Jurusan;
use App\Models\PesertaPPDB;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportPesertaPpdb(ExportPesertaRequest $request)
    {
        $jurusan = $request->filled('jurusan') ? $request->input('jurusan') : null;
        $diterima = $request->input('diterima', 0);
        $tahun = $request->input('tahun', now()->year);
        $all = $request->input('all', 0);

        $abb = $jurusan ? Jurusan::find($jurusan) : null;

        $acc = $diterima == 1 ? 'data_peserta_ppdb_diterima_' : 'peserta_ppdb_';
        $filename = $acc . ($abb ? $abb->abbreviation : 'Semua') . '-' . $tahun . '.xlsx';

        return Excel::download(new PesertaPPDBExport($jurusan, $tahun, $diterima, $all), $filename);
    }

    public function exportSeragam(ExportSeragamRequest $request)
    {
        $jurusan = $request->filled('jurusan') ? $request->input('jurusan') : null;
        $tahun = $request->input('tahun', now()->year);

        $abb = $jurusan ? Jurusan::find($jurusan) : null;

        $filename = 'Ukuran-seragam-' . ($abb ? $abb->abbreviation : 'Semua') . '-' . $tahun . '.xlsx';

        return Excel::download(new SeragamExport($jurusan, $tahun), $filename);
    }

    public function exportRekapSekolah(ExportRekapSekolahRequest $request)
    {
        $tahun = $request->input('tahun', now()->year);

        // perbandingan per jumlah sekolah pendaftar
        $pendaftarPerSekolah = PesertaPPDB::select(DB::raw('asal_sekolah, count(asal_sekolah) as as_count'))->whereYear('created_at', $tahun)->groupBy('asal_sekolah')->orderByDesc('as_count')->get();

        return Excel::download(new RekapSekolahExport($tahun, $pendaftarPerSekolah), 'Rekap-sekolah-' . $tahun . '.xlsx');
    }

    public function exportBelumDaftarUlang(ExportPesertaRequest $request)
    {
        $jurusan = $request->filled('jurusan') ? $request->input('jurusan') : null;
        $tahun = $request->input('tahun', now()->year);

        $abb = $jurusan ? Jurusan::find($jurusan) : null;

        $filename = 'peserta_ppdb_belum_daftar_ulang_' . ($abb ? $abb->abbreviation : 'Semua') . '-' . $tahun . '.xlsx';

        return Excel::download(new PesertaPPDBExport($jurusan, $tahun, 0), $filename);
    }
}
