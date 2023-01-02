<?php

namespace Database\Seeders;

use App\Models\PesertaPPDB;
use Illuminate\Database\Seeder;

class PesertaPPDBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PesertaPPDB::factory(500)->create();
    }
}
