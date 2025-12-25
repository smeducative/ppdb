<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentFilterRequest;
use App\Http\Requests\StorePendaftarRequest;
use App\Http\Requests\UpdatePendaftarRequest;
use App\Http\Requests\UpdatePesertaStatusRequest;
use App\Models\Jurusan;
use App\Models\PesertaPPDB;
use Illuminate\Support\Str;

class PendaftaranPPDB extends Controller
{
    public function listPendaftar(DocumentFilterRequest $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $search = $request->input('search');

        $pesertappdb = PesertaPPDB::whereYear('created_at', $tahun)
            ->with(['jurusan']) // Eager load relationships
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('no_pendaftaran', 'like', "%{$search}%")
                        ->orWhere('asal_sekolah', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate($request->input('per_page', 10))
            ->withQueryString();

        $years = range(now()->year, now()->year - 5);

        return inertia('Admin/Ppdb/ListPendaftar', compact('pesertappdb', 'tahun', 'years'));
    }

    public function listPendaftarJurusan(DocumentFilterRequest $request, $jurusan)
    {
        $tahun = $request->input('tahun', now()->year);
        $search = $request->input('search');

        $pesertappdb = PesertaPPDB::whereYear('created_at', $tahun)
            ->with(['jurusan'])
            ->whereJurusanId($jurusan)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('no_pendaftaran', 'like', "%{$search}%")
                        ->orWhere('asal_sekolah', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate($request->input('per_page', 10))
            ->withQueryString();

        $years = range(now()->year, now()->year - 5);

        return inertia('Admin/Ppdb/ListPendaftar', compact('pesertappdb', 'tahun', 'years', 'jurusan'));
    }

    public function tambahPendaftar()
    {
        $jurusan = Jurusan::all();

        return inertia('Admin/Ppdb/Create', compact('jurusan'));
    }

    public function submitPendaftar(StorePendaftarRequest $request)
    {
        $data = $request->validated();

        $data['jurusan_id'] = $request->input('pilihan_jurusan');
        unset($data['pilihan_jurusan']);
        $data['penerima_kip'] = $request->has('penerima_kip') ? 'y' : 'n';
        $data['rekomendasi_mwc'] = $request->has('rekomendasi_mwc') ? 1 : 0;
        $data['no_hp_ayah'] = $request->input('no_ayah');
        $data['no_hp_ibu'] = $request->input('no_ibu');

        $data['akademik'] = [
            'kelas' => explode('/', $request->input('peringkat'))[0] ?? '',
            'semester' => explode('/', $request->input('peringkat'))[1] ?? '',
            'peringkat' => explode('/', $request->input('peringkat'))[2] ?? '',
            'hafidz' => $request->input('hafidz') ?? '',
        ];

        $data['non_akademik'] = [
            'jenis_lomba' => $request->input('jenis_lomba') ?? '',
            'juara_ke' => $request->input('juara_ke') ?? '',
            'juara_tingkat' => $request->input('juara_tingkat') ?? '',
        ];

        unset($data['peringkat'], $data['hafidz'], $data['jenis_lomba'], $data['juara_ke'], $data['juara_tingkat'], $data['no_ayah'], $data['no_ibu']);

        PesertaPPDB::create($data);

        session()->flash('success', 'peserta ppdb di tambahkan');

        return back();
    }

    // show daftar ulang

    public function listDaftarUlang(DocumentFilterRequest $request, $jurusan = null)
    {
        $tahun = $request->input('tahun', now()->year);
        $search = $request->input('search');

        $pesertappdb = PesertaPPDB::with('jurusan')
            ->has('kwitansi')
            ->when($jurusan, fn($q) => $q->whereJurusanId($jurusan))
            ->whereYear('created_at', $tahun)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('no_pendaftaran', 'like', "%{$search}%")
                        ->orWhere('asal_sekolah', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate($request->input('per_page', 10))
            ->withQueryString();

        $years = range(now()->year, now()->year - 5);

        return inertia('Admin/Ppdb/ListDaftarUlang', compact('pesertappdb', 'tahun', 'years', 'jurusan'));
    }

    public function listBelumDaftarUlang(DocumentFilterRequest $request, $jurusan = null)
    {
        $tahun = $request->input('tahun', now()->year);
        $search = $request->input('search');

        $pesertappdb = PesertaPPDB::with('jurusan')
            ->doesntHave('kwitansi')
            ->when($jurusan, fn($q) => $q->whereJurusanId($jurusan))
            ->whereYear('created_at', $tahun)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('no_pendaftaran', 'like', "%{$search}%")
                        ->orWhere('asal_sekolah', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate($request->input('per_page', 10))
            ->withQueryString();

        $years = range(now()->year, now()->year - 5);

        return inertia('Admin/Ppdb/ListBelumDaftarUlang', compact('pesertappdb', 'tahun', 'years', 'jurusan'));
    }

    public function showPeserta($id)
    {
        $peserta = PesertaPPDB::with('jurusan')->findOrFail($id);

        return inertia('Admin/Ppdb/Show', compact('peserta'));
    }

    /*
    * Edit data peserta
    */
    public function edit($id)
    {
        $peserta = PesertaPPDB::findOrFail($id);
        $jurusan = Jurusan::all();

        return inertia('Admin/Ppdb/Edit', compact('peserta', 'jurusan'));
    }

    public function update(UpdatePendaftarRequest $request, $id)
    {
        $data = $request->validated();

        $ppdb = PesertaPPDB::findOrFail($id);
        $jurusan = Jurusan::findOrFail($request->input('pilihan_jurusan'));

        // check apakah peserta memgubah jurusan
        if ($ppdb->jurusan_id != $jurusan->id) {
            $data['no_pendaftaran'] = $jurusan->abbreviation . '-' . Str::padLeft($ppdb->no_urut, 3, 0) . '-' . now()->format('m-y');

            session()->flash('warning', 'Peserta memilih jurusan berbeda. Pastikan untuk mencetak kembali dokumen pendaftaran.');
        }

        $data['jurusan_id'] = $jurusan->id;
        unset($data['pilihan_jurusan']);

        $data['penerima_kip'] = $request->has('penerima_kip') ? 'y' : 'n';
        $data['rekomendasi_mwc'] = $request->has('rekomendasi_mwc') ? 1 : 0;
        $data['no_hp_ayah'] = $request->input('no_ayah');
        $data['no_hp_ibu'] = $request->input('no_ibu');

        $data['akademik'] = [
            'kelas' => explode('/', $request->input('peringkat'))[0] ?? '',
            'semester' => explode('/', $request->input('peringkat'))[1] ?? '',
            'peringkat' => explode('/', $request->input('peringkat'))[2] ?? '',
            'hafidz' => $request->input('hafidz') ?? '',
        ];

        $data['non_akademik'] = [
            'jenis_lomba' => $request->input('jenis_lomba') ?? '',
            'juara_ke' => $request->input('juara_ke') ?? '',
            'juara_tingkat' => $request->input('juara_tingkat') ?? '',
        ];

        unset($data['peringkat'], $data['hafidz'], $data['jenis_lomba'], $data['juara_ke'], $data['juara_tingkat'], $data['no_ayah'], $data['no_ibu']);

        $ppdb->update($data);

        session()->flash('success', 'Data peserta telah di ubah');

        return redirect()->route('ppdb.show.peserta', $ppdb->id);
    }

    // formulir section
    public function mendaftar(StorePendaftarRequest $request)
    {
        $data = $request->validated();

        $data['jurusan_id'] = $request->input('pilihan_jurusan');
        unset($data['pilihan_jurusan']);
        $data['penerima_kip'] = $request->has('penerima_kip') ? 'y' : 'n';
        $data['rekomendasi_mwc'] = $request->has('rekomendasi_mwc') ? 1 : 0;
        $data['no_hp_ayah'] = $request->input('no_ayah');
        $data['no_hp_ibu'] = $request->input('no_ibu');

        $data['akademik'] = [
            'kelas' => explode('/', $request->input('peringkat'))[0] ?? '',
            'semester' => explode('/', $request->input('peringkat'))[1] ?? '',
            'peringkat' => explode('/', $request->input('peringkat'))[2] ?? '',
            'hafidz' => $request->input('hafidz') ?? '',
        ];

        $data['non_akademik'] = [
            'jenis_lomba' => $request->input('jenis_lomba') ?? '',
            'juara_ke' => $request->input('juara_ke') ?? '',
            'juara_tingkat' => $request->input('juara_tingkat') ?? '',
        ];

        unset($data['peringkat'], $data['hafidz'], $data['jenis_lomba'], $data['juara_ke'], $data['juara_tingkat'], $data['no_ayah'], $data['no_ibu']);

        $ppdb = PesertaPPDB::create($data);

        session()->flash('success', 'Terima kasih, anda berhasil mendaftar dengan nomor pendaftaran ' . $ppdb->no_pendaftaran);

        return redirect()->route('ppdb.register');
    }

    public function terimaPeserta(UpdatePesertaStatusRequest $request, $uuid)
    {
        $request->validated();

        $peserta = PesertaPPDB::with(['jurusan', 'kwitansi'])->findOrFail($uuid);

        $peserta->diterima = $request->input('status') == 'y' ? 1 : 2;
        $peserta->save();

        $msg = $request->input('status') == 'y' ? 'Peserta Diterima' : 'Peserta Ditolak';

        session()->flash('success', $msg);

        return back();
    }

    public function hapusPeserta($uuid)
    {
        $peserta = PesertaPPDB::findOrFail($uuid);

        $peserta->delete();

        session()->flash('success', 'Peserta telah dihapus');

        return redirect()->route('ppdb.list.pendaftar');
    }
}
