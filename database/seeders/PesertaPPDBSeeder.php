<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PesertaPPDB;

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
