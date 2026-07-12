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

class RekapDanaKwitansiExport implements FromCollection, ShouldAutoSize, WithCustomStartCell, WithEvents, WithHeadings, WithMapping
{
    use StyledExcelExport;

    public $danaKelola;

    public $jenisPembayaran;

    public $tahun;

    protected $index = 0;

    /**
     * __construct
     *
     * @param  mixed  $danaKelola
     * @param  mixed  $jenisPembayaran
     * @return void
     */
    public function __construct($danaKelola, $jenisPembayaran, $tahun)
    {
        $this->danaKelola = $danaKelola;
        $this->jenisPembayaran = $jenisPembayaran;
        $this->tahun = $tahun;
    }

    public function exportTitle(): string
    {
        return 'Rekap Dana Pembayaran PPDB Tahun '.$this->tahun;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return $this->jenisPembayaran;
    }

    public function headings(): array
    {
        return [
            'No',
            'Jenis Pembayaran',
            'Jumlah Dana',
            'Jumlah Kwitansi',
        ];
    }

    public function map($row): array
    {
        $this->index++;

        return [
            $this->index,
            $row->first()->jenis_pembayaran,
            $row->sum('nominal'),
            $row->count(),
        ];
    }
}
