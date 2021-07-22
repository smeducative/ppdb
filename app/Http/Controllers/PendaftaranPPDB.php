<?php

namespace App\Http\Controllers;

use App\Models\PesertaPPDB;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;

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
        $ppdb->no_hp = request('no_hp');
        $ppdb->nama_ayah = request('nama_ayah');
        $ppdb->no_hp_ayah = request('no_ayah');
        $ppdb->nama_ibu = request('nama_ibu');
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


    // unduh data
    public function unduhDokumen($uuid)
    {
        $peserta = PesertaPPDB::findOrFail($uuid);

        $phpword = new TemplateProcessor(storage_path('app/form_pendaftaran_ppdb.docx'));

        $phpword->setValues([
            'no_pendaftaran'    => $peserta->no_pendaftaran,
            'nama_lengkap'  => $peserta->nama_lengkap,
            'jenis_kelamin'  => $peserta->jenis_kelamin == 'l' ? 'Laki-laki' : 'Perempuan',
            'tempat_lahir'  => $peserta->tempat_lahir,
            'tanggal_lahir' => $peserta->tanggal_lahir->format('d-m-Y'),
            'alamat_lengkap' => $peserta->alamat_lengkap,
            'pilihan_jurusan'  => $peserta->jurusan->nama,
            'asal_sekolah'  => $peserta->asal_sekolah,
            'tahun_lulus'   => $peserta->tahun_lulus,
            'nisn'          => $peserta->nisn,
            'nik'          => $peserta->nik,
            'penerima_kip'  => $peserta->penerima_kip,
            'no_kip'  => $peserta->no_kip,
            'no_hp'         => $peserta->no_hp,
            'nama_ayah'     => $peserta->nama_ayah,
            'no_hp_ayah'       => $peserta->no_hp_ayah,
            'nama_ibu'      => $peserta->nama_ibu,
            'no_hp_ibu'        => $peserta->no_hp_ibu,
            'akademik_kelas'    => $peserta->akademik['kelas'],
            'akademik_semester' => $peserta->akademik['semester'],
            'akademik_peringkat' => $peserta->akademik['peringkat'],
            'akademik_hafidz'    => $peserta->akademik['hafidz'],
            'non_akademik_jenis_lomba' => $peserta->non_akademik['jenis_lomba'],
            'non_akademik_juara_ke' => $peserta->non_akademik['juara_ke'],
            'non_akademik_juara_tingkat' => $peserta->non_akademik['juara_tingkat'],
            'rekomendasi_mwc' => $peserta->rekomendasi_mwc ? 'ya' : 'tidak',
        ]);

        $filename = Str::slug($peserta->nama_lengkap) . '.docx';

        $phpword->saveAs($filename);

        return response()->download($filename);
    }
}
