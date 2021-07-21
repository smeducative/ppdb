<?php

namespace App\Http\Controllers;

use App\Models\PesertaPPDB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PendaftaranPPDB extends Controller
{
    public function listPendaftar()
    {
        $pesertappdb = PesertaPPDB::with('jurusan')->get();

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

        $ppdb = new PesertaPPDB();
        $ppdb->id = Str::uuid();
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
        $ppdb->no_hp = request('no_hp');
        $ppdb->nama_ayah = request('nama_ayah');
        $ppdb->no_hp_ayah = request('no_ayah');
        $ppdb->nama_ibu = request('nama_ibu');
        $ppdb->no_hp_ibu = request('no_ibu');
        $ppdb->akademik = [
            'kelas' => explode('/', request('peringkat'))[0],
            'semseter' => explode('/', request('peringkat'))[1],
            'peringkat' => explode('/', request('peringkat'))[2],
            'hafidz'    => request('hafidz')
        ];
        $ppdb->non_akademik = [
            'jenis_lomba' => request('jenis_lomba'),
            'juara_ke'     => request('juara_ke'),
            'juara_tingkat' => request('juara_tingkat')
        ];
        $ppdb->rekomendasi_mwc = request()->has('rekomendasi_mwc') ? 1 : 0;
        $ppdb->save();

        session()->flash('success', 'peserta ppdb di tambahkan');

        return back();
    }

    public function showPeserta($id)
    {
        $peserta = PesertaPPDB::find($id);

        return view('ppdb.show', compact('peserta'));
    }



    // formulir section
    public function mendaftar()
    {
        dd(request()->all());
    }
}
