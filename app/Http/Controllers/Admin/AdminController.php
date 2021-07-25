<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PesertaPPDB;
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
            'all' => collect($peserta)->sum('c') ?? 0
		];

		$du = [
			'tkj' => collect($pesertadu)->where('jurusan_id', 1)->first()->c ?? 0,
            'tbsm' => collect($pesertadu)->where('jurusan_id', 2)->first()->c ?? 0,
            'atph' => collect($pesertadu)->where('jurusan_id', 3)->first()->c ?? 0,
            'all' => collect($pesertadu)->sum('c') ?? 0
		];


        return view('admin.dashboard', compact('count', 'du'));
    }
}