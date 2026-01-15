<?php

namespace Tests\Feature;

use App\Models\Jurusan;
use App\Models\PesertaPPDB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PendaftaranAlamatTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test major/jurusan
        Jurusan::factory()->create([
            'id' => 1,
            'nama' => 'Teknik Jaringan Komputer',
            'abbreviation' => 'TJKT',
        ]);
    }

    /**
     * Test that alamat_lengkap is optional in validation
     */
    public function test_alamat_lengkap_is_optional(): void
    {
        $response = $this->post('/register', [
            'nama_lengkap' => 'John Doe',
            'jenis_kelamin' => 'l',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2005-01-15',
            'nik' => '1234567890123456',
            'alamat_lengkap' => '', // Empty
            'pilihan_jurusan' => 1,
            'asal_sekolah' => 'SMP Negeri 1',
            'tahun_lulus' => 2025,
            'no_hp' => '08123456789',
            'nama_ayah' => 'Ayah Doe',
            'nama_ibu' => 'Ibu Doe',
            'dukuh' => 'Dukuh A',
            'rt' => '01',
            'rw' => '02',
            'desa_kelurahan' => 'Kayugeritan',
            'kecamatan' => 'Karanganyar',
            'kabupaten_kota' => 'Pekalongan',
            'provinsi' => 'Jawa Tengah',
            'kode_pos' => '51182',
        ]);

        $response->assertRedirect('/register');
        $this->assertDatabaseHas('peserta_ppdb', [
            'nama_lengkap' => 'John Doe',
            'nik' => '1234567890123456',
        ]);
    }

    /**
     * Test that alamat is automatically merged from address components when alamat_lengkap is empty
     */
    public function test_alamat_is_merged_when_empty(): void
    {
        $this->post('/register', [
            'nama_lengkap' => 'Jane Doe',
            'jenis_kelamin' => 'p',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '2006-05-20',
            'nik' => '9876543210987654',
            'alamat_lengkap' => '', // Empty - should be merged
            'pilihan_jurusan' => 1,
            'asal_sekolah' => 'SMP Negeri 2',
            'tahun_lulus' => 2025,
            'no_hp' => '08987654321',
            'nama_ayah' => 'Ayah Doe',
            'nama_ibu' => 'Ibu Doe',
            'dukuh' => 'Dukuh B',
            'rt' => '03',
            'rw' => '04',
            'desa_kelurahan' => 'Desa X',
            'kecamatan' => 'Kec Y',
            'kabupaten_kota' => 'Kab Z',
            'provinsi' => 'Jawa Tengah',
            'kode_pos' => '51182',
        ]);

        // Check that alamat_lengkap was merged from address components
        $peserta = PesertaPPDB::where('nik', '9876543210987654')->first();
        $this->assertNotNull($peserta);

        // Verify the merged address contains expected parts
        $this->assertStringContainsString('Dk. Dukuh B', $peserta->alamat_lengkap);
        $this->assertStringContainsString('RT 03 / RW 04', $peserta->alamat_lengkap);
        $this->assertStringContainsString('Desa X', $peserta->alamat_lengkap);
        $this->assertStringContainsString('Kec Y', $peserta->alamat_lengkap);
        $this->assertStringContainsString('Kab Z', $peserta->alamat_lengkap);
        $this->assertStringContainsString('Jawa Tengah', $peserta->alamat_lengkap);
        $this->assertStringContainsString('Kode Pos 51182', $peserta->alamat_lengkap);
    }

    /**
     * Test that user-provided alamat_lengkap is used as-is (not merged)
     */
    public function test_provided_alamat_lengkap_is_used(): void
    {
        $customAddress = 'Jl. Kutilang No. 12';

        $this->post('/register', [
            'nama_lengkap' => 'Bob Smith',
            'jenis_kelamin' => 'l',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '2004-03-10',
            'nik' => '5555555555555555',
            'alamat_lengkap' => $customAddress, // Provided
            'pilihan_jurusan' => 1,
            'asal_sekolah' => 'SMP Negeri 3',
            'tahun_lulus' => 2025,
            'no_hp' => '08555555555',
            'nama_ayah' => 'Ayah Smith',
            'nama_ibu' => 'Ibu Smith',
            'dukuh' => 'Dukuh C',
            'rt' => '05',
            'rw' => '06',
            'desa_kelurahan' => 'Desa Y',
            'kecamatan' => 'Kec Z',
            'kabupaten_kota' => 'Kab A',
            'provinsi' => 'Jawa Timur',
            'kode_pos' => '60000',
        ]);

        $peserta = PesertaPPDB::where('nik', '5555555555555555')->first();
        $this->assertNotNull($peserta);

        // Verify the custom address is stored as-is
        $this->assertEquals($customAddress, $peserta->alamat_lengkap);
    }
}
