<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class RekapDanaKwitansiExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithCustomStartCell, WithEvents
{
    public $danaKelola;
    public $jenisPembayaran;
    public $tahun;

    /**
     * __construct
     *
     * @param  mixed $danaKelola
     * @param  mixed $jenisPembayaran
     * @return void
     */
    public function __construct($danaKelola, $jenisPembayaran, $tahun)
    {
        $this->danaKelola = $danaKelola;
        $this->jenisPembayaran = $jenisPembayaran;
        $this->tahun = $tahun;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->jenisPembayaran;
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function headings(): array
    {
        return [
            'Jenis Pembayaran',
            'Jumlah Dana',
            'Jumlah Kwitansi'
        ];
    }

    public function map($row): array
    {
        return [
            $row->first()->jenis_pembayaran,
            $row->sum('nominal'),
            $row->count()
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // set cell header to rekap dana
                $event->sheet->setCellValue("A1", "Rekap dana pembayaran PPDB Tahun " . $this->tahun);
                // merge cell
                $event->sheet->mergeCells('A1:C1');

                $event->sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
                // bold the text
                $event->sheet->getStyle('A1')->getFont()->setBold(true);
                $event->sheet->getStyle('A3:C3')->getFont()->setBold(true);
                // text size to 14
                $event->sheet->getStyle('A1')->getFont()->setSize(14);

                // set background color
                $event->sheet->getStyle('A3:' . $event->sheet->getHighestColumn() . '3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF35D7EC');

                // set border to entire table
                $event->sheet->getStyle('A3:' . $event->sheet->getHighestColumn() . $event->sheet->getHighestRow())->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            }
        ];
    }
}
