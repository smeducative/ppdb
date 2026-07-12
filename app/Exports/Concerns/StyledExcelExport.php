<?php

namespace App\Exports\Concerns;

use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

trait StyledExcelExport
{
    public function startCell(): string
    {
        return 'A3';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $highestColumn = $sheet->getHighestColumn();
                $highestRow = $sheet->getHighestRow();

                // Judul laporan (baris 1)
                $sheet->setCellValue('A1', $this->exportTitle());
                $sheet->mergeCells("A1:{$highestColumn}1");
                $sheet->getStyle('A1')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(14);
                $sheet->getStyle('A1')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Waktu unduh (baris 2)
                $sheet->setCellValue('A2', 'Diekspor pada: '.now()->translatedFormat('l, d F Y H:i'));
                $sheet->mergeCells("A2:{$highestColumn}2");
                $sheet->getStyle('A2')
                    ->getFont()
                    ->setItalic(true)
                    ->setSize(10)
                    ->getColor()
                    ->setARGB('FF6B7280');
                $sheet->getStyle('A2')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Baris header (baris 3) dengan warna
                $headerRange = "A3:{$highestColumn}3";
                $sheet->getStyle($headerRange)
                    ->getFont()
                    ->setBold(true)
                    ->getColor()
                    ->setARGB('FFFFFFFF');
                $sheet->getStyle($headerRange)
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('FF1E40AF');
                $sheet->getStyle($headerRange)
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Garis tepi seluruh tabel
                $tableRange = "A3:{$highestColumn}{$highestRow}";
                $sheet->getStyle($tableRange)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                if (method_exists($this, 'afterStyle')) {
                    $this->afterStyle($event);
                }
            },
        ];
    }

    abstract public function exportTitle(): string;
}
