<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\PesertaPPDB;
use Illuminate\Support\Str;

class PendaftaranPPDB extends Controller
{
    public function listPendaftar()
    {
        $tahun = request('tahun', now()->year);
        $search = request('search');

        $pesertappdb = PesertaPPDB::whereYear('created_at', $tahun)
            ->with(['jurusan']) // Eager load relationships
            ->when($search, function ($query, $search) {
                $query->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('no_pendaftaran', 'like', "%{$search}%")
                    ->orWhere('asal_sekolah', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(request('per_page', 10))
            ->withQueryString();

        $years = range(now()->year, now()->year - 5);

        return inertia('Admin/Ppdb/ListPendaftar', compact('pesertappdb', 'tahun', 'years'));
    }

    public function listPendaftarJurusan($jurusan)
    {
        $tahun = request('tahun', now()->year);
        $search = request('search');

        $pesertappdb = PesertaPPDB::whereYear('created_at', $tahun)
            ->with(['jurusan'])
            ->whereJurusanId($jurusan)
            ->when($search, function ($query, $search) {
                $query->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('no_pendaftaran', 'like', "%{$search}%")
                    ->orWhere('asal_sekolah', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(request('per_page', 10))
            ->withQueryString();

        $years = range(now()->year, now()->year - 5);

        return inertia('Admin/Ppdb/ListPendaftar', compact('pesertappdb', 'tahun', 'years', 'jurusan'));
    }

    public function tambahPendaftar()
    {
        $jurusan = Jurusan::all();

        return inertia('Admin/Ppdb/Create', compact('jurusan'));
    }

    public function submitPendaftar()
    {
        request()->validate([
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'nik' => 'required',
            'alamat_lengkap' => 'required',
            'dukuh' => 'nullable',
            'rt' => 'nullable',
            'rw' => 'nullable',
            'desa_kelurahan' => 'nullable',
            'kecamatan' => 'nullable',
            'kabupaten_kota' => 'nullable',
            'provinsi' => 'nullable',
            'kode_pos' => 'nullable',
            'pilihan_jurusan' => 'required',
            'asal_sekolah' => 'required',
            'tahun_lulus' => 'required',
            'nisn' => 'nullable',
            'penerima_kip' => 'nullable',
            'no_hp' => 'required',
            'nama_ayah' => 'required',
            'nama_ibu' => 'required',
            'peringkat' => 'nullable',
            'hafidz' => 'nullable',
            'jenis_lomba' => 'nullable',
            'juara_ke' => 'nullable',
            'juara_tingkat' => 'nullable',
            'rekomendasi_mwc' => 'nullable',
        ]);

        $no_urut = (new PesertaPPDB)->getNoUrut();
        $jurusan = Jurusan::findOrFail(request('pilihan_jurusan'));

        $ppdb = new PesertaPPDB;
        $ppdb->id = Str::uuid();
        $ppdb->no_urut = $no_urut;
        $ppdb->semester = now()->year.'/'.now()->addYear()->year;
        $ppdb->no_pendaftaran = $jurusan->abbreviation.'-'.Str::padLeft($no_urut, 3, 0).'-'.now()->format('m-y');
        $ppdb->nama_lengkap = request('nama_lengkap');
        $ppdb->jenis_kelamin = request('jenis_kelamin');
        $ppdb->tempat_lahir = request('tempat_lahir');
        $ppdb->tanggal_lahir = request('tanggal_lahir');
        $ppdb->nik = request('nik');
        $ppdb->alamat_lengkap = request('alamat_lengkap');
        $ppdb->dukuh = request('dukuh');
        $ppdb->rt = request('rt');
        $ppdb->rw = request('rw');
        $ppdb->desa_kelurahan = request('desa_kelurahan');
        $ppdb->kecamatan = request('kecamatan');
        $ppdb->kabupaten_kota = request('kabupaten_kota');
        $ppdb->provinsi = request('provinsi');
        $ppdb->kode_pos = request('kode_pos');
        $ppdb->jurusan_id = request('pilihan_jurusan');
        $ppdb->asal_sekolah = request('asal_sekolah');
        $ppdb->tahun_lulus = request('tahun_lulus');
        $ppdb->nisn = request('nisn');
        $ppdb->penerima_kip = request()->has('penerima_kip') ? 'y' : 'n';
        $ppdb->no_kip = request('no_kip');
        $ppdb->no_hp = request('no_hp');
        $ppdb->nama_ayah = request('nama_ayah');
        $ppdb->pekerjaan_ayah = request('pekerjaan_ayah');
        $ppdb->no_hp_ayah = request('no_ayah');
        $ppdb->nama_ibu = request('nama_ibu');
        $ppdb->pekerjaan_ibu = request('pekerjaan_ibu');
        $ppdb->no_hp_ibu = request('no_ibu');
        $ppdb->akademik = [
            'kelas' => explode('/', request('peringkat'))[0] ?? '',
            'semester' => explode('/', request('peringkat'))[1] ?? '',
            'peringkat' => explode('/', request('peringkat'))[2] ?? '',
            'hafidz' => request('hafidz') ?? '',
        ];
        $ppdb->non_akademik = [
            'jenis_lomba' => request('jenis_lomba') ?? '',
            'juara_ke' => request('juara_ke') ?? '',
            'juara_tingkat' => request('juara_tingkat') ?? '',
        ];
        $ppdb->rekomendasi_mwc = request()->has('rekomendasi_mwc') ? 1 : 0;
        $ppdb->saran_dari = request('saran_dari');
        $ppdb->save();

        session()->flash('success', 'peserta ppdb di tambahkan');

        return back();
    }

    // show daftar ulang

    public function listDaftarUlang($jurusan = null)
    {
        $tahun = request('tahun', now()->year);
        $search = request('search');

        $pesertappdb = PesertaPPDB::with('jurusan')
            ->has('kwitansi')
            ->when($jurusan, fn ($q) => $q->whereJurusanId($jurusan))
            ->whereYear('created_at', $tahun)
            ->when($search, function ($query, $search) {
                $query->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('no_pendaftaran', 'like', "%{$search}%")
                    ->orWhere('asal_sekolah', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(request('per_page', 10))
            ->withQueryString();

        $years = range(now()->year, now()->year - 5);

        return inertia('Admin/Ppdb/ListDaftarUlang', compact('pesertappdb', 'tahun', 'years', 'jurusan'));
    }

    public function listBelumDaftarUlang($jurusan = null)
    {
        $tahun = request('tahun', now()->year);
        $search = request('search');

        $pesertappdb = PesertaPPDB::with('jurusan')
            ->doesntHave('kwitansi')
            ->when($jurusan, fn ($q) => $q->whereJurusanId($jurusan))
            ->whereYear('created_at', $tahun)
            ->when($search, function ($query, $search) {
                $query->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('no_pendaftaran', 'like', "%{$search}%")
                    ->orWhere('asal_sekolah', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(request('per_page', 10))
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

    public function update($id)
    {
        request()->validate([
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'nik' => 'required',
            'alamat_lengkap' => 'required',
            'dukuh' => 'nullable',
            'rt' => 'nullable',
            'rw' => 'nullable',
            'desa_kelurahan' => 'nullable',
            'kecamatan' => 'nullable',
            'kabupaten_kota' => 'nullable',
            'provinsi' => 'nullable',
            'kode_pos' => 'nullable',
            'pilihan_jurusan' => 'required',
            'asal_sekolah' => 'required',
            'tahun_lulus' => 'required',
            'nisn' => 'nullable',
            'penerima_kip' => 'nullable',
            'no_hp' => 'required',
            'nama_ayah' => 'required',
            'nama_ibu' => 'required',
            'peringkat' => 'nullable',
            'hafidz' => 'nullable',
            'jenis_lomba' => 'nullable',
            'juara_ke' => 'nullable',
            'juara_tingkat' => 'nullable',
            'rekomendasi_mwc' => 'nullable',
        ]);

        $jurusan = Jurusan::findOrFail(request('pilihan_jurusan'));

        $ppdb = PesertaPPDB::findOrFail($id);

        // check apakah peserta memgubah jurusan
        if ($ppdb->jurusan_id != $jurusan->id) {
            $ppdb->no_pendaftaran = $jurusan->abbreviation.'-'.Str::padLeft($ppdb->no_urut, 3, 0).'-'.now()->format('m-y');
            $ppdb->jurusan_id = $jurusan->id;

            session()->flash('warning', 'Peserta memilih jurusan berbeda. Pastikan untuk mencetak kembali dokumen pendaftaran.');
        }

        $ppdb->semester = now()->year.'/'.now()->addYear()->year;
        $ppdb->nama_lengkap = request('nama_lengkap');
        $ppdb->jenis_kelamin = request('jenis_kelamin');
        $ppdb->tempat_lahir = request('tempat_lahir');
        $ppdb->tanggal_lahir = request('tanggal_lahir');
        $ppdb->nik = request('nik');
        $ppdb->alamat_lengkap = request('alamat_lengkap');
        $ppdb->dukuh = request('dukuh');
        $ppdb->rt = request('rt');
        $ppdb->rw = request('rw');
        $ppdb->desa_kelurahan = request('desa_kelurahan');
        $ppdb->kecamatan = request('kecamatan');
        $ppdb->kabupaten_kota = request('kabupaten_kota');
        $ppdb->provinsi = request('provinsi');
        $ppdb->kode_pos = request('kode_pos');
        $ppdb->asal_sekolah = request('asal_sekolah');
        $ppdb->tahun_lulus = request('tahun_lulus');
        $ppdb->nisn = request('nisn');
        $ppdb->penerima_kip = request()->has('penerima_kip') ? 'y' : 'n';
        $ppdb->no_kip = request('no_kip');
        $ppdb->no_hp = request('no_hp');
        $ppdb->nama_ayah = request('nama_ayah');
        $ppdb->pekerjaan_ayah = request('pekerjaan_ayah');
        $ppdb->no_hp_ayah = request('no_ayah');
        $ppdb->nama_ibu = request('nama_ibu');
        $ppdb->pekerjaan_ibu = request('pekerjaan_ibu');
        $ppdb->no_hp_ibu = request('no_ibu');
        $ppdb->akademik = [
            'kelas' => explode('/', request('peringkat'))[0] ?? '',
            'semester' => explode('/', request('peringkat'))[1] ?? '',
            'peringkat' => explode('/', request('peringkat'))[2] ?? '',
            'hafidz' => request('hafidz') ?? '',
        ];
        $ppdb->non_akademik = [
            'jenis_lomba' => request('jenis_lomba') ?? '',
            'juara_ke' => request('juara_ke') ?? '',
            'juara_tingkat' => request('juara_tingkat') ?? '',
        ];
        $ppdb->rekomendasi_mwc = request()->has('rekomendasi_mwc') ? 1 : 0;
        $ppdb->saran_dari = request('saran_dari');
        $ppdb->save();

        session()->flash('success', 'Data peserta telah di ubah');

        return redirect()->route('ppdb.show.peserta', $ppdb->id);
    }

    // formulir section
    public function mendaftar()
    {
        request()->validate([
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'nik' => 'required',
            'alamat_lengkap' => 'required',
            'dukuh' => 'nullable',
            'rt' => 'nullable',
            'rw' => 'nullable',
            'desa_kelurahan' => 'nullable',
            'kecamatan' => 'nullable',
            'kabupaten_kota' => 'nullable',
            'provinsi' => 'nullable',
            'kode_pos' => 'nullable',
            'pilihan_jurusan' => 'required',
            'asal_sekolah' => 'required',
            'tahun_lulus' => 'required',
            'nisn' => 'nullable',
            'penerima_kip' => 'nullable',
            'no_hp' => 'required',
            'nama_ayah' => 'required',
            'nama_ibu' => 'required',
            'peringkat' => 'nullable',
            'hafidz' => 'nullable',
            'jenis_lomba' => 'nullable',
            'juara_ke' => 'nullable',
            'juara_tingkat' => 'nullable',
            'rekomendasi_mwc' => 'nullable',
        ]);

        $no_urut = (new PesertaPPDB)->getNoUrut();
        $jurusan = Jurusan::findOrFail(request('pilihan_jurusan'));

        $ppdb = new PesertaPPDB;
        $ppdb->id = Str::uuid();
        $ppdb->no_urut = $no_urut;
        $ppdb->semester = now()->year.'/'.now()->addYear()->year;
        $ppdb->no_pendaftaran = $jurusan->abbreviation.'-'.Str::padLeft($no_urut, 3, 0).'-'.now()->format('m-y');
        $ppdb->nama_lengkap = request('nama_lengkap');
        $ppdb->jenis_kelamin = request('jenis_kelamin');
        $ppdb->tempat_lahir = request('tempat_lahir');
        $ppdb->tanggal_lahir = request('tanggal_lahir');
        $ppdb->nik = request('nik');
        $ppdb->alamat_lengkap = request('alamat_lengkap');
        $ppdb->dukuh = request('dukuh');
        $ppdb->rt = request('rt');
        $ppdb->rw = request('rw');
        $ppdb->desa_kelurahan = request('desa_kelurahan');
        $ppdb->kecamatan = request('kecamatan');
        $ppdb->kabupaten_kota = request('kabupaten_kota');
        $ppdb->provinsi = request('provinsi');
        $ppdb->kode_pos = request('kode_pos');
        $ppdb->jurusan_id = request('pilihan_jurusan');
        $ppdb->asal_sekolah = request('asal_sekolah');
        $ppdb->tahun_lulus = request('tahun_lulus');
        $ppdb->nisn = request('nisn');
        $ppdb->penerima_kip = request()->has('penerima_kip') ? 'y' : 'n';
        $ppdb->no_kip = request('no_kip');
        $ppdb->no_hp = request('no_hp');
        $ppdb->nama_ayah = request('nama_ayah');
        $ppdb->pekerjaan_ayah = request('pekerjaan_ayah');
        $ppdb->no_hp_ayah = request('no_ayah');
        $ppdb->nama_ibu = request('nama_ibu');
        $ppdb->pekerjaan_ibu = request('pekerjaan_ibu');
        $ppdb->no_hp_ibu = request('no_ibu');
        $ppdb->akademik = [
            'kelas' => explode('/', request('peringkat'))[0] ?? '',
            'semester' => explode('/', request('peringkat'))[1] ?? '',
            'peringkat' => explode('/', request('peringkat'))[2] ?? '',
            'hafidz' => request('hafidz') ?? '',
        ];
        $ppdb->non_akademik = [
            'jenis_lomba' => request('jenis_lomba') ?? '',
            'juara_ke' => request('juara_ke') ?? '',
            'juara_tingkat' => request('juara_tingkat') ?? '',
        ];
        $ppdb->rekomendasi_mwc = request()->has('rekomendasi_mwc') ? 1 : 0;
        $ppdb->saran_dari = request('saran_dari');
        $ppdb->save();

        session()->flash('success', 'Terima kasih, anda berhasil mendaftar dengan nomor pendaftaran '.$ppdb->no_pendaftaran);

        return back();
    }

    public function terimaPeserta($uuid)
    {
        $peserta = PesertaPPDB::with(['jurusan', 'kwitansi'])->findOrFail($uuid);

        $peserta->diterima = request()->get('status') == 'y' ? 1 : 2;
        $peserta->save();

        $msg = request()->get('status') == 'y' ? 'Peserta Diterima' : 'Peserta Ditolak';

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
