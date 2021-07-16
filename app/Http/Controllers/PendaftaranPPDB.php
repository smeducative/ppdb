<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PendaftaranPPDB extends Controller
{
    public function listPendaftar()
    {
        //
    }

    public function tambahPendaftar()
    {
        // logic ...

        return view('ppdb.tambah');
    }

    public function submitPendaftar()
    {
        dd(request()->all());
    }
}
