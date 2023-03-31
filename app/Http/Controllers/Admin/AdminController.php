<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\PesertaPPDB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $tahun = request('tahun', now()->year);

        $peserta = PesertaPPDB::select(\DB::raw('jurusan_id, count(*) as c'))->whereYear('created_at', $tahun)->groupBy('jurusan_id')->get();

	$acc = PesertaPPDB::whereYear('created_at', $tahun)->get();

	$penerimaan = [
	   'diterima' => $acc->where('diterima', 1)->count(),
	   'ditolak' => $acc->where('diterima', 0)->count(),
	];

        $pesertadu = PesertaPPDB::has('kwitansi')->select(\DB::raw('jurusan_id, count(*) as c'))->whereYear('created_at', $tahun)->groupBy('jurusan_id')->get();

        $count = [
            'tkj' => collect($peserta)->where('jurusan_id', 1)->first()->c ?? 0,
            'tbsm' => collect($peserta)->where('jurusan_id', 2)->first()->c ?? 0,
            'atph' => collect($peserta)->where('jurusan_id', 3)->first()->c ?? 0,
            'bdp' => collect($peserta)->where('jurusan_id', 4)->first()->c ?? 0,
            'all' => collect($peserta)->sum('c') ?? 0,
        ];

        $du = [
            'tkj' => collect($pesertadu)->where('jurusan_id', 1)->first()->c ?? 0,
            'tbsm' => collect($pesertadu)->where('jurusan_id', 2)->first()->c ?? 0,
            'atph' => collect($pesertadu)->where('jurusan_id', 3)->first()->c ?? 0,
            'bdp' => collect($pesertadu)->where('jurusan_id', 4)->first()->c ?? 0,
            'all' => collect($pesertadu)->sum('c') ?? 0,
        ];

        $compare = Jurusan::with('pesertaPpdb:id,jurusan_id')->withCount([
            'pesertaPpdb as l' => function ($query) use ($tahun) {
                $query->whereYear('created_at', $tahun)->where('jenis_kelamin', 'l');
            },
            'pesertaPpdb as p' => function ($query) use ($tahun) {
                $query->whereYear('created_at', $tahun)->where('jenis_kelamin', 'p');
            },
        ])->orderBy('id')->get();

        $compareDu = Jurusan::withCount([
            'pesertaPpdb as l' => function ($query) use ($tahun) {
                $query->has('kwitansi')->whereYear('created_at', $tahun)->where('jenis_kelamin', 'l')->where('diterima', 1);
            },
            'pesertaPpdb as p' => function ($query) use ($tahun) {
                $query->has('kwitansi')->whereYear('created_at', $tahun)->where('jenis_kelamin', 'p')->where('diterima', 1);
            },
        ])->orderBy('id')->get();

        $compareSx = [
            'p' => collect($compare)->pluck('p'),
            'l' => collect($compare)->pluck('l'),
        ];

        $compareDx = [
            'p' => collect($compareDu)->pluck('p'),
            'l' => collect($compareDu)->pluck('l'),
        ];

        // perbandingan per jumlah sekolah pendaftar
        $pendaftarPerSekolah = PesertaPPDB::select(\DB::raw('asal_sekolah, count(asal_sekolah) as as_count'))->whereYear('created_at', $tahun)->groupBy('asal_sekolah')->orderByDesc('as_count')->get();

        return view('admin.dashboard', compact('count', 'du', 'compareSx', 'compareDx', 'pendaftarPerSekolah', 'penerimaan'));
    }

    public function pengaturanAkun()
    {
        $user = auth()->user();

        return view('admin.profile', compact('user'));
    }

    public function setAkun()
    {
        $data = request()->validate([
            'name' => ['required'],
            'password' => ['required', 'confirmed'],
        ]);

        auth()->user()->update([
            'name' => request('name'),
            'password' => bcrypt(request('password')),
        ]);

        session()->flash('success', 'Data user dan password berhasil di ganti');

        return back();
    }
}
