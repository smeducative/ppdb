<?php

namespace App\Http\Controllers;

use App\Exports\RekapDanaKwitansiExport;
use App\Models\Kwitansi;
use Illuminate\Http\Request;
use App\Models\PesertaPPDB;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class KwitansiController extends Controller
{

    // show kwitansi   \
    public function showPesertaDiterima()
    {
        $tahun = request('tahun', now()->year);

        $pesertappdb = PesertaPPDB::with('jurusan')->where('diterima', 1)
            ->whereYear('created_at', $tahun)
            ->latest('updated_at')->get();

        return view('pdf.kwitansi', compact('pesertappdb'));
    }

    public function showJurusanPeserta($jurusan)
    {
        $tahun = request('tahun', now()->year);

        $pesertappdb = PesertaPPDB::with('jurusan')->where('diterima', 1)
            ->whereJurusanId($jurusan)
            ->whereYear('created_at', $tahun)->latest()->get();

        return view('pdf.kwitansi', compact('pesertappdb'));
    }

    public function tambahKwitansi($uuid)
    {
        $peserta = PesertaPPDB::with(['jurusan', 'kwitansi' => function ($query) {
            $query->with('penerima');
        }])->findOrFail($uuid);

        return view('ppdb.tambah-kwitansi', compact('peserta'));
    }

    public function storeKwitansi($uuid)
    {
        $data = request()->validate([
            'jenis_pembayaran' => ['required'],
            'nominal'   => ['required']
        ]);

        $peserta = PesertaPPDB::findOrFail($uuid);

        $peserta->kwitansi()->create($data + ['user_id' => request()->user()->id]);

        session()->flash('success', 'Kwitansi Berhasil di Tambahkan');

        return back();
    }

    public function cetakKwitansi($uuid)
    {
        $pesertappdb = PesertaPPDB::with(['jurusan', 'kwitansi'])->where('diterima', 1)->findOrFail($uuid);

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
        ])->where('diterima', 1)->findOrFail($uuid);

        // $pdf = PDF::loadView('pdf.cetak-kwitansi', $peserta);

        // return $pdf->stream('kwitansi-' . Str::slug($peserta->nama_lengkap) . '.pdf');

        return view('pdf.cetak-kwitansi', compact('pesertappdb'));
    }

    /**
     * rekap kwitansi
     *
     * @return void
     */
    public function rekapKwitansi()
    {
        $tahun = request('tahun', now()->year);

        $kwitansies = Kwitansi::whereYear('created_at', $tahun)->latest()->get();

        $danaKelola = $kwitansies->sum('nominal');

        $jenisPembayaran = $kwitansies->map(function ($item) {
            $item->jenis_pembayaran = Str::title($item->jenis_pembayaran);

            return $item;
        })->groupBy('jenis_pembayaran');

        return view('ppdb.rekap-kwitansi', compact('kwitansies', 'danaKelola', 'jenisPembayaran'));
    }

    public function cetakRekapDanaKwitansi()
    {
        $tahun = request('tahun', now()->year);

        $kwitansies = Kwitansi::whereYear('created_at', $tahun)->latest()->get();

        $danaKelola = $kwitansies->sum('nominal');

        $jenisPembayaran = $kwitansies->map(function ($item) {
            $item->jenis_pembayaran = Str::title($item->jenis_pembayaran);

            return $item;
        })->groupBy('jenis_pembayaran');

        return Excel::download(new RekapDanaKwitansiExport($danaKelola, $jenisPembayaran, $tahun), 'rekap-dana-kwitansi-ppdb-' . $tahun . '.xlsx');
    }
}
