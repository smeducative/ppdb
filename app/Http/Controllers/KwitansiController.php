<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PesertaPPDB;
use Illuminate\Support\Str;
use PDF;

class KwitansiController extends Controller
{
    public function tambahKwitansi($uuid)
    {
        $data = request()->validate([
            'jenis_pembayaran' => ['required'],
            'nominal'   => ['required']
        ]);

        $peserta = PesertaPPDB::findOrFail($uuid);

        $peserta->kwitansi()->create($data);

        session()->flash('success', 'Kwitansi Berhasil di Tambahkan');

        return back(201);
    }

    public function cetakKwitansi($uuid)
    {
        $peserta = PesertaPPDB::with(['jurusan', 'kwitansi'])->findOrFail($uuid);

        // $pdf = PDF::loadView('pdf.cetak-kwitansi', $peserta);

        // return $pdf->stream('kwitansi-' . Str::slug($peserta->nama_lengkap) . '.pdf');

        return view('pdf.cetak-kwitansi', $peserta);
    }
}