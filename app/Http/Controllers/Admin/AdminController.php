<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PesertaPPDB;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $tahun = request('tahun', now()->year);

        $peserta = PesertaPPDB::with('jurusan')->select(\DB::raw('jurusan_id, count(*) as c'))->whereYear('created_at', $tahun)->groupBy('jurusan_id')->get();

        $pesertadu = PesertaPPDB::has('kwitansi')->with('jurusan')->select(\DB::raw('jurusan_id, count(*) as c'))->whereYear('created_at', $tahun)->groupBy('jurusan_id')->get();

        $count = [
            'tkj' => collect($peserta)->where('jurusan_id', 1)->first()->c ?? 0,
            'tbsm' => collect($peserta)->where('jurusan_id', 2)->first()->c ?? 0,
            'atph' => collect($peserta)->where('jurusan_id', 3)->first()->c ?? 0,
            'bcf' => collect($peserta)->where('jurusan_id', 4)->first()->c ?? 0,
            'all' => collect($peserta)->sum('c') ?? 0
        ];

        $du = [
            'tkj' => collect($pesertadu)->where('jurusan_id', 1)->first()->c ?? 0,
            'tbsm' => collect($pesertadu)->where('jurusan_id', 2)->first()->c ?? 0,
            'atph' => collect($pesertadu)->where('jurusan_id', 3)->first()->c ?? 0,
            'bcf' => collect($pesertadu)->where('jurusan_id', 4)->first()->c ?? 0,
            'all' => collect($pesertadu)->sum('c') ?? 0
        ];

        $compare = Jurusan::with('pesertaPpdb:id,jurusan_id')->withCount([
            'pesertaPpdb as l'   => function ($query) use ($tahun) {
                $query->whereYear('created_at', $tahun)->where('jenis_kelamin', 'l');
            },
            'pesertaPpdb as p'   => function ($query) use ($tahun) {
                $query->whereYear('created_at', $tahun)->where('jenis_kelamin', 'p');
            },
        ])->orderBy('id')->get();

        $compareSx = [
            'p'    => collect($compare)->pluck('p'),
            'l'    => collect($compare)->pluck('l')
        ];

        return view('admin.dashboard', compact('count', 'du', 'compareSx'));
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
            'password' => bcrypt(request('password'))
        ]);

        session()->flash('success', 'Data user dan password berhasil di ganti');

        return back();
    }
}
