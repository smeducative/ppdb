<?php

namespace App\Exports;

use App\Models\PesertaPPDB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SeragamExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public $jurusan;

    public $tahun;

    public function __construct($jurusan, $tahun)
    {
        $this->jurusan = $jurusan;
        $this->tahun = $tahun;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return PesertaPPDB::with('ukuranSeragam')
            ->when($this->jurusan != null, function ($query) {
                return $query->where('jurusan_id', $this->jurusan);
            })
            ->whereDiterima(1)
            ->whereYear('created_at', $this->tahun)
            ->get();
    }

    public function headings(): array
    {
        return [
            'No Pendaftaran',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tgl Lahir',
            'Baju (wear pack)',
            'Jas',
            'Sepatu',
            'Peci',
        ];
    }

    public function map($row): array
    {
        return [
            $row->no_pendaftaran,
            $row->nama_lengkap,
            $row->jenis_kelamin === 'p' ? 'Perempuan' : 'Laki-laki',
            $row->tempat_lahir,
            $row->tanggal_lahir?->format('d-m-Y'),
            $row->ukuranSeragam->baju ?? '-',
            $row->ukuranSeragam->jas ?? '-',
            $row->ukuranSeragam->sepatu ?? '-',
            $row->ukuranSeragam->peci ?? '-',
        ];
    }
}
