<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class RekapRiwayatKwitansiExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithCustomStartCell, WithEvents
{
    public $index = 1;
    public $kwitansies;
    public $tahun;

    public function __construct($kwitansies, $tahun)
    {
        $this->kwitansies = $kwitansies;
        $this->tahun = $tahun;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->kwitansies;
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function headings(): array
    {
        return [
            'No',
            'No. Pendaftaran',
            'Nama Lengkap',
            'Jenis Pembayaran',
            'Nominal',
            'Penerima',
            'Tanggal',
        ];
    }

    public function map($row): array
    {
        return [
            $this->index++,
            $row->pesertaPpdb->no_pendaftaran,
            $row->pesertaPpdb->nama_lengkap,
            $row->jenis_pembayaran,
            $row->nominal,
            $row->penerima->name,
            $row->created_at->translatedFormat('l, d F Y H:i'),
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->setCellValue('A1', 'Rekap Riwayat Kwitansi PPDB Tahun ' . $this->tahun);
                $event->sheet->mergeCells('A1:G1');

                $event->sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('A1')->getFont()->setBold(true);
                $event->sheet->getStyle('A3:G3')->getFont()->setBold(true);
                $event->sheet->getStyle('A1')->getFont()->setSize(14);

                // set background color
                $event->sheet->getStyle('A3:' . $event->sheet->getHighestColumn() . '3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCCCCC');

                // set border to entire table
                $event->sheet->getStyle('A3:' . $event->sheet->getHighestColumn() . $event->sheet->getHighestRow())->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            }
        ];
    }
}
