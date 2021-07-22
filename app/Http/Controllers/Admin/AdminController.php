<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PesertaPPDB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $peserta = PesertaPPDB::query()->whereYear('created_at', now()->year);

        $count['tkj'] = $peserta->where('jurusan_id', 1)->count();
        $count['tbsm'] = $peserta->where('jurusan_id', 2)->count();
        $count['atph'] = $peserta->where('jurusan_id', 3)->count();

        return view('admin.dashboard', compact('count', 'peserta'));
    }
}
