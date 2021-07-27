<?php

namespace Database\Factories;

use App\Models\PesertaPPDB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class PesertaPPDBFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PesertaPPDB::class;

    /**
     * Define the model's default state.
     *
     * @re
     * turn array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid(),
            'no_urut' => (new PesertaPPDB)->getNoUrut(),
            'no_pendaftaran' => 'TEST-' . (new PesertaPPDB)->getNoUrut() . now()->format('m-y'),
            'semester' => now()->year . '/' . now()->addYear()->year,
            'nama_lengkap' => $this->faker->name(),
            'jenis_kelamin' => rand(0, 1) ? 'l' : 'p',
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date(),
            'nik'   => $this->faker->randomDigit(),
            'nisn' => $this->faker->randomDigit(),
            'asal_sekolah' => $this->faker->word(),
            'tahun_lulus' => $this->faker->year(),
            'jurusan_id'    => rand(1, 3),
            'alamat_lengkap'   => $this->faker->streetAddress(),
            'penerima_kip' =>
            rand(0, 1) ? 'y' : 'n',
            'no_kip' => 'TEST12',
            'no_hp' => $this->faker->phoneNumber(),
            'nama_ayah' => $this->faker->name('male'),
            'nama_ibu' => $this->faker->name('female'),
            'pekerjaan_ayah'    => 'wirausaha',
            'pekerjaan_ibu' => 'wirausaha',
            'no_hp_ayah'    => $this->faker->phoneNumber(),
            'no_hp_ibu'    => $this->faker->phoneNumber(),
            'akademik'  => [
                'kelas' => '',
                'semester' => '',
                'peringkat' => '',
                'hafidz' => ''
            ],
            'non_akademik' => [
                "jenis_lomba" => '',
                "juara_ke" => '',
                "juara_tingkat" => ''
            ],
            'rekomendasi_mwc'   => rand(0, 1),
            'saran_dari'    => $this->faker->name()
        ];
    }
}
