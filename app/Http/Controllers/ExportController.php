<?php

namespace App\Http\Controllers;

use App\Exports\PesertaPPDBExport;
use App\Exports\SeragamExport;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportPesertaPpdb()
    {
        $jurusan = request('jurusan');
        $diterima = request('diterima', 0);
        $tahun = request('tahun', now()->year);

        $abb = Jurusan::find($jurusan);

        $acc = $diterima == 1 ? 'data_peserta_ppdb_diterima_' : 'peserta_ppdb_';
        $filename = $acc . optional($abb)->abbreviation . '-' . $tahun . '.xlsx';

        return Excel::download(new PesertaPPDBExport($jurusan, $tahun, $diterima), $filename);
    }


    public function exportSeragam()
    {
        $jurusan = request('jurusan');
        $tahun = request('tahun', now()->year);

        $abb = Jurusan::find($jurusan);

        $filename = 'Ukuran-seragam-' . optional($abb)->abbreviation . '-' . $tahun . '.xlsx';

        return Excel::download(new SeragamExport($jurusan, $tahun), $filename);
    }
}
