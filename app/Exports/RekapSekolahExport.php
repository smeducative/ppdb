<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RekapSekolahExport implements FromCollection, ShouldAutoSize, WithCustomStartCell, WithHeadings, WithMapping
{
    public $tahun;
    public $pendaftarPerSekolah;

    public function __construct($tahun, $pendaftarPerSekolah)
    {
        $this->tahun = $tahun;
        $this->pendaftarPerSekolah = $pendaftarPerSekolah;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->pendaftarPerSekolah;
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function headings(): array
    {
        return [
            'Nama Sekolah',
            'Jumlah Pendaftar',
        ];
    }

    public function map($row): array
    {
        return [
            $row->asal_sekolah,
            $row->as_count,
        ];
    }
}
