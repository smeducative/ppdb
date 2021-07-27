<?php

namespace App\Http\Controllers;

use App\Exports\PesertaPPDBExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportPesertaPpdb()
    {
        $jurusan = request('jurusan');
        $tahun = request('tahun', now()->year);

        return Excel::download(new PesertaPPDBExport($jurusan, $tahun), 'peserta_ppdb_' . $tahun . '.xlsx');
    }
}
