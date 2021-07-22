<?php

namespace Database\Seeders;

use App\Models\Jurusan;
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
                'id'    => 1,
                'nama'  => 'Teknik Komputer dan Jaringan',
                'abbreviation'  => 'TKJ'
            ], [
                'id'    => 2,
                'nama'  => 'Teknik dan Bisnis Sepeda Motor',
                'abbreviation'  => 'TBSM'
            ], [
                'id'    => 3,
                'nama'  => 'Agribisnis Tanaman Pangan dan Holtikultura',
                'abbreviation'  => 'ATPH'
            ],
        ];

        Jurusan::insert($data);
    }
}
