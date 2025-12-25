<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use App\Models\PpdbSetting;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'nama' => 'Teknik Komputer dan Jaringan',
                'abbreviation' => 'TKJ',
            ], [
                'id' => 2,
                'nama' => 'Teknik dan Bisnis Sepeda Motor',
                'abbreviation' => 'TBSM',
            ], [
                'id' => 3,
                'nama' => 'Agribisnis Tanaman Pangan dan Holtikultura',
                'abbreviation' => 'ATPH',
            ], [
                'id' => 8,
                'nama' => 'Axioo Class Program',
                'abbreviation' => 'ACP',
            ],
        ];

        $setting = [
            'body' => json_encode([
                'batas_akhir_ppdb' => now(),
                'no_surat' => '247/Pan.PPDB/2021',
                'hasil_akhir' => now(),
            ]),
        ];

        Jurusan::insert($data);
        PpdbSetting::insert($setting);
    }
}
