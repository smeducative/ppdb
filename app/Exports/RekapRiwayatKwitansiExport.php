<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RekapRiwayatKwitansiExport implements FromCollection, ShouldAutoSize, WithCustomStartCell, WithEvents, WithHeadings, WithMapping
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
     * @return Collection
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
            'Status',
            'Penerima',
            'Tanggal',
            'Waktu Hapus',
            'Dihapus Oleh',
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
            $row->deleted_at ? 'Dihapus' : 'Aktif',
            $row->penerima->name,
            $row->created_at->translatedFormat('l, d F Y H:i'),
            $row->deleted_at ? $row->deleted_at->translatedFormat('l, d F Y H:i') : '-',
            $row->deletedBy?->name ?? '-',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->setCellValue('A1', 'Rekap Riwayat Kwitansi PPDB Tahun '.$this->tahun);
                $event->sheet->mergeCells('A1:J1');

                $event->sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('A1')->getFont()->setBold(true);
                $event->sheet->getStyle('A3:J3')->getFont()->setBold(true);
                $event->sheet->getStyle('A1')->getFont()->setSize(14);

                // set header background color
                $event->sheet->getStyle('A3:'.$event->sheet->getHighestColumn().'3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCCCCC');

                // set border to entire table
                $event->sheet->getStyle('A3:'.$event->sheet->getHighestColumn().$event->sheet->getHighestRow())->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                // highlight deleted rows with red background
                $highestRow = $event->sheet->getHighestRow();
                for ($row = 4; $row <= $highestRow; $row++) {
                    $status = $event->sheet->getCell('F'.$row)->getValue();
                    if ($status === 'Dihapus') {
                        $event->sheet->getStyle('A'.$row.':J'.$row)->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB('FFFDE2E2');
                    }
                }
            },
        ];
    }
}
