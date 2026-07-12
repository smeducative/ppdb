<?php

namespace App\Exports;

use App\Exports\Concerns\StyledExcelExport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RekapSekolahExport implements FromCollection, ShouldAutoSize, WithCustomStartCell, WithEvents, WithHeadings, WithMapping
{
    use StyledExcelExport;

    public $tahun;

    public $pendaftarPerSekolah;

    protected $index = 0;

    public function __construct($tahun, $pendaftarPerSekolah)
    {
        $this->tahun = $tahun;
        $this->pendaftarPerSekolah = $pendaftarPerSekolah;
    }

    public function exportTitle(): string
    {
        return 'Rekap Asal Sekolah Pendaftar PPDB Tahun '.$this->tahun;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return $this->pendaftarPerSekolah;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Sekolah',
            'Jumlah Pendaftar',
        ];
    }

    public function map($row): array
    {
        $this->index++;

        return [
            $this->index,
            $row->asal_sekolah,
            $row->as_count,
        ];
    }
}
