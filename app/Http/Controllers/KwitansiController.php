<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PesertaPPDB;
use Illuminate\Support\Str;
use PDF;

class KwitansiController extends Controller
{

    // show kwitansi   \
    public function showPesertaDiterima()
    {
        $pesertappdb = PesertaPPDB::with('jurusan')->where('diterima', 1)->latest()->get();

        return view('pdf.kwitansi', compact('pesertappdb'));
    }

    public function tambahKwitansi($uuid)
    {
        $peserta = PesertaPPDB::with(['jurusan', 'kwitansi'])->findOrFail($uuid);

        return view('ppdb.tambah-kwitansi', compact('peserta'));
    }

    public function storeKwitansi($uuid)
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
        $pesertappdb = PesertaPPDB::with(['jurusan', 'kwitansi'])->findOrFail($uuid);

        // $pdf = PDF::loadView('pdf.cetak-kwitansi', $peserta);

        // return $pdf->stream('kwitansi-' . Str::slug($peserta->nama_lengkap) . '.pdf');

        return view('pdf.cetak-kwitansi', compact('pesertappdb'));
    }

    public function cetakKwitansiSingle($uuid, $id)
    {
        $pesertappdb = PesertaPPDB::with([
            'jurusan',
            'kwitansi' => function ($query) use ($id) {
                $query->whereId($id);
            }
        ])->findOrFail($uuid);

        // $pdf = PDF::loadView('pdf.cetak-kwitansi', $peserta);

        // return $pdf->stream('kwitansi-' . Str::slug($peserta->nama_lengkap) . '.pdf');

        return view('pdf.cetak-kwitansi', compact('pesertappdb'));
    }
}
