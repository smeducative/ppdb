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
        PesertaPPDB::factory(5)->create();

        // add more 300 but for the before this year
        PesertaPPDB::factory(5)->create(['created_at' => now()->subYear()]);
    }
}
