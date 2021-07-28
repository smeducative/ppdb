<?php

namespace App\Http\Controllers;

use App\Models\PesertaPPDB;
use App\Models\Jurusan;
use Illuminate\Support\Str;

class PendaftaranPPDB extends Controller
{
    public function listPendaftar()
    {
        $tahun = request('tahun', now()->year);
        $pesertappdb = PesertaPPDB::whereYear('created_at', $tahun)->with('jurusan')->latest()->get();

        return view('ppdb.list', compact('pesertappdb'));
    }

    public function listPendaftarJurusan($jurusan)
    {
        $tahun = request('tahun', now()->year);
        $pesertappdb = PesertaPPDB::whereYear('created_at', $tahun)->with('jurusan')->whereJurusanId($jurusan)->latest()->get();

        return view('ppdb.list', compact('pesertappdb'));
    }

    public function tambahPendaftar()
    {
        return view('ppdb.tambah');
    }

    public function submitPendaftar()
    {
        request()->validate([
            "nama_lengkap" => "required",
            "jenis_kelamin" => "required",
            "tempat_lahir" => "required",
            "tanggal_lahir" => "required",
            "nik" => "required",
            "alamat_lengkap" => "required",
            "pilihan_jurusan" => "required",
            "asal_sekolah" => "required",
            "tahun_lulus" => "required",
            "nisn" => "nullable",
            "penerima_kip" => "nullable",
            "no_hp" => "required",
            "nama_ayah" => "required",
            "no_ayah" => "required",
            "nama_ibu" => "required",
            "no_ibu" => "required",
            "peringkat" => "nullable",
            "hafidz" => "nullable",
            "jenis_lomba" => "nullable",
            "juara_ke" => "nullable",
            "juara_tingkat" => "nullable",
            "rekomendasi_mwc" => "nullable"
        ]);

        $no_urut = (new PesertaPPDB)->getNoUrut();
        $jurusan = Jurusan::findOrFail(request('pilihan_jurusan'));

        $ppdb = new PesertaPPDB();
        $ppdb->id = Str::uuid();
        $ppdb->no_urut = $no_urut;
        $ppdb->semester = now()->year . '/' . now()->addYear()->year;
        $ppdb->no_pendaftaran = $jurusan->abbreviation . '-' . Str::padLeft($no_urut, 3, 0) . '-' . now()->format('m-y');
        $ppdb->nama_lengkap = request('nama_lengkap');
        $ppdb->jenis_kelamin = request('jenis_kelamin');
        $ppdb->tempat_lahir = request('tempat_lahir');
        $ppdb->tanggal_lahir = request('tanggal_lahir');
        $ppdb->nik = request('nik');
        $ppdb->alamat_lengkap = request('alamat_lengkap');
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
            'hafidz'    => request('hafidz') ?? ''
        ];
        $ppdb->non_akademik = [
            'jenis_lomba' => request('jenis_lomba') ?? '',
            'juara_ke'     => request('juara_ke') ?? '',
            'juara_tingkat' => request('juara_tingkat') ?? ''
        ];
        $ppdb->rekomendasi_mwc = request()->has('rekomendasi_mwc') ? 1 : 0;
        $ppdb->saran_dari = request('saran_dari');
        $ppdb->save();

        session()->flash('success', 'peserta ppdb di tambahkan');

        return back();
    }


    // show daftar ulang

    public function listDaftarUlang($jurusan)
    {
        $tahun = request('tahun', now()->year);
        $pesertappdb = PesertaPPDB::with('jurusan')->has('kwitansi')->whereJurusanId($jurusan)->whereYear('created_at', $tahun)->get(); // proto

        return view('ppdb.list-daftar-ulang', compact('pesertappdb'));
    }

    public function showPeserta($id)
    {
        $peserta = PesertaPPDB::find($id);

        return view('ppdb.show', compact('peserta'));
    }

    // formulir section
    public function mendaftar()
    {
        request()->validate([
            "nama_lengkap" => "required",
            "jenis_kelamin" => "required",
            "tempat_lahir" => "required",
            "tanggal_lahir" => "required",
            "nik" => "required",
            "alamat_lengkap" => "required",
            "pilihan_jurusan" => "required",
            "asal_sekolah" => "required",
            "tahun_lulus" => "required",
            "nisn" => "nullable",
            "penerima_kip" => "nullable",
            "no_hp" => "required",
            "nama_ayah" => "required",
            "nama_ibu" => "required",
            "peringkat" => "nullable",
            "hafidz" => "nullable",
            "jenis_lomba" => "nullable",
            "juara_ke" => "nullable",
            "juara_tingkat" => "nullable",
            "rekomendasi_mwc" => "nullable"
        ]);

        $no_urut = (new PesertaPPDB)->getNoUrut();
        $jurusan = Jurusan::findOrFail(request('pilihan_jurusan'));

        $ppdb = new PesertaPPDB();
        $ppdb->id = Str::uuid();
        $ppdb->no_urut = $no_urut;
        $ppdb->semester = now()->year . '/' . now()->addYear()->year;
        $ppdb->no_pendaftaran = $jurusan->abbreviation . '-' . Str::padLeft($no_urut, 3, 0) . '-' . now()->format('m-y');
        $ppdb->nama_lengkap = request('nama_lengkap');
        $ppdb->jenis_kelamin = request('jenis_kelamin');
        $ppdb->tempat_lahir = request('tempat_lahir');
        $ppdb->tanggal_lahir = request('tanggal_lahir');
        $ppdb->nik = request('nik');
        $ppdb->alamat_lengkap = request('alamat_lengkap');
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
            'hafidz'    => request('hafidz') ?? ''
        ];
        $ppdb->non_akademik = [
            'jenis_lomba' => request('jenis_lomba') ?? '',
            'juara_ke'     => request('juara_ke') ?? '',
            'juara_tingkat' => request('juara_tingkat') ?? ''
        ];
        $ppdb->rekomendasi_mwc = request()->has('rekomendasi_mwc') ? 1 : 0;
        $ppdb->saran_dari = request('saran_dari');
        $ppdb->save();

        session()->flash('success', 'berhasil');

        return back();
    }

    public function terimaPeserta($uuid)
    {
        $peserta = PesertaPPDB::with(['jurusan', 'kwitansi'])->findOrFail($uuid);

        $peserta->diterima = request()->get('status') == "y" ? 1 : 2;
        $peserta->save();

        $msg = request()->get('status') == "y" ? "Peserta Diterima" : "Peserta Ditolak";

        session()->flash('success', $msg);

        return back();
    }
}
