<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PpdbSetting;

class PpdbSettingController extends Controller
{
    public function setBatasAkhir()
	{
		$batas = PpdbSetting::latest()->first();

		$batas->body = [
			'batas_akhir_ppdb'	=> request('batas_akhir_ppdb', now()->format('d-m-Y'))
		];

		dd($batas);

		$batas->save();

		session()->flash('success', 'Batas akhir telah di tentukan');

		return back();
	}
}