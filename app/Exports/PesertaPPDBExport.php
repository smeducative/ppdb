<?php

namespace App\Exports;

use App\Models\PesertaPPDB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PesertaPPDBExport implements FromCollection, WithHeadings, WithMapping
{
    public $jurusan;
    public $tahun;
    public $diterima;

    public function __construct($jurusan, $tahun, $diterima)
    {
        $this->jurusan = $jurusan;
        $this->tahun = $tahun;
        $this->diterima = $diterima;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return PesertaPPDB::when($this->jurusan != null, function ($query) {
            $query->where('jurusan_id', $this->jurusan);
        })->when($this->diterima, function ($query) {
            $query->has('kwitansi')->whereDiterima(1);
        })
            ->whereYear('created_at', $this->tahun)->get();
    }

    // heading
    public function headings(): array
    {
        return [
            'No. Pendaftaran',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Pilihan Jurusan',
            'NIK',
            'NISN',
            'Alamat Lengkap',
            'Asal Sekolah',
            'Tahun Lulus',
            'Penerima KIP',
            'No. KIP',
            'Nomor Telepon',
            'Nama Ayah',
            'Pekerjaan Ayah',
            'Nomor Telepon Ayah',
            'Nama Ibu',
            'Pekerjaan Ibu',
            'Nomor Telepon Ibu',
            'Akademik Kelas / Semster / Peringkat',
            'Akademik Hafidz / Hafidzoh',
            'Non Akademik Jenis Lomba',
            'Non Akademik Juara ke',
            'Non Akademik Tingkat',
            'Rekomendasi MWC',
            'Saran Dari'
        ];
    }

    // map
    public function map($peserta): array
    {
        return [
            $peserta->no_pendaftaran,
            $peserta->nama_lengkap,
            $peserta->jenis_kelamin == 'l' ? 'Laki-laki' : 'Perempuan',
            $peserta->tempat_lahir,
            $peserta->tanggal_lahir->format('d F Y'),
            $peserta->jurusan->nama,
            $peserta->nik,
            $peserta->nisn,
            $peserta->alamat_lengkap,
            $peserta->asal_sekolah,
            $peserta->tahun_lulus,
            $peserta->penerima_kip == 'y' ? 'Ya' : 'Tidak',
            $peserta->no_kip,
            $peserta->no_hp,
            $peserta->nama_ayah,
            $peserta->pekerjaan_ayah,
            $peserta->no_hp_ayah,
            $peserta->nama_ibu,
            $peserta->pekerjaan_ibu,
            $peserta->no_hp_ibu,
            $peserta->akademik['kelas'] . ' / ' . $peserta->akademik['semester'] . ' / ' . $peserta->akademik['peringkat'],
            $peserta->akademik['hafidz'],
            $peserta->non_akademik['jenis_lomba'],
            $peserta->non_akademik['juara_ke'],
            $peserta->non_akademik['juara_tingkat'],
            $peserta->rekomendasi_mwc == 1 ? 'Ya' : 'Tidak',
            $peserta->saran_dari
        ];
    }
}
