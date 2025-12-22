<?php

namespace App\Http\Controllers;

use App\Exports\RekapDanaKwitansiExport;
use App\Exports\RekapRiwayatKwitansiExport;
use App\Models\Kwitansi;
use App\Models\PesertaPPDB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class KwitansiController extends Controller
{
    // show kwitansi   \
    // show kwitansi
    public function showPesertaDiterima()
    {
        $tahun = request('tahun', now()->year);
        $jurusan = request('jurusan');
        $search = request('search');

        $pesertappdb = PesertaPPDB::with('jurusan', 'kwitansi')
            ->where('diterima', 1)
            ->whereYear('created_at', $tahun)
            ->when($jurusan, fn ($q) => $q->whereJurusanId($jurusan))
            ->when($search, function ($query, $search) {
                $query->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('no_pendaftaran', 'like', "%{$search}%")
                    ->orWhere('asal_sekolah', 'like', "%{$search}%");
            })
            ->latest('updated_at')
            ->paginate(10)
            ->withQueryString();

        $years = range(now()->year, now()->year - 5);

        return inertia('Admin/Kwitansi/Index', compact('pesertappdb', 'tahun', 'years', 'jurusan'));
    }

    public function showJurusanPeserta($jurusan)
    {
        return redirect()->route('ppdb.kwitansi.show', ['jurusan' => $jurusan]);
    }

    public function tambahKwitansi($uuid)
    {
        $peserta = PesertaPPDB::with(['jurusan', 'kwitansi' => fn ($query) => $query->withTrashed()->latest()->with('penerima', 'deletedBy')])->findOrFail($uuid);

        return inertia('Admin/Kwitansi/Create', compact('peserta'));
    }

    public function storeKwitansi($uuid)
    {
        $data = request()->validate([
            'jenis_pembayaran' => ['required'],
            'nominal' => ['required'],
        ]);

        $peserta = PesertaPPDB::findOrFail($uuid);

        $peserta->kwitansi()->create($data + ['user_id' => request()->user()->id]);

        session()->flash('success', 'Kwitansi Berhasil di Tambahkan');

        return back();
    }

    public function hapusKwitansi($id)
    {
        /** @var \App\Models\Kwitansi $kwitansi */
        $kwitansi = Kwitansi::findOrFail($id);

        $kwitansi->delete();

        session()->flash('success', 'Kwitansi Berhasil di Hapus');

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
            },
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

        $kwitansiesAll = Kwitansi::withTrashed()
            ->has('pesertaPpdb')
            ->whereYear('created_at', $tahun)
            ->get();

        $danaKelola = $kwitansiesAll->filter(fn ($d) => is_null($d->deleted_at))->sum('nominal');

        $jenisPembayaran = $kwitansiesAll->filter(fn ($d) => is_null($d->deleted_at))
            ->groupBy(fn ($item) => Str::title($item->jenis_pembayaran))
            ->map(fn ($group) => [
                'count' => $group->count(),
                'total' => $group->sum('nominal'),
            ]);

        $kwitansiesHistory = Kwitansi::withTrashed()
            ->has('pesertaPpdb')
            ->with(['pesertaPpdb', 'penerima', 'deletedBy'])
            ->whereYear('created_at', $tahun)
            ->latest()
            ->paginate(50)
            ->withQueryString();

        $years = range(now()->year, now()->year - 5);

        return inertia('Admin/Kwitansi/Rekap', compact('kwitansiesHistory', 'danaKelola', 'jenisPembayaran', 'tahun', 'years'));
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

        return Excel::download(new RekapDanaKwitansiExport($danaKelola, $jenisPembayaran, $tahun), 'rekap-dana-kwitansi-ppdb-'.$tahun.'.xlsx');
    }

    public function cetakRekapRiwayatKwitansi()
    {
        $tahun = request('tahun', now()->year);

        $kwitansies = Kwitansi::with(['pesertaPpdb', 'penerima'])->whereYear('created_at', $tahun)->get();

        return Excel::download(new RekapRiwayatKwitansiExport($kwitansies, $tahun), 'rekap-riwayat-kwitansi-ppdb-'.$tahun.'.xlsx');
    }
}
