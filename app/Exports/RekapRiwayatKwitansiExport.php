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
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RekapRiwayatKwitansiExport implements FromCollection, ShouldAutoSize, WithCustomStartCell, WithEvents, WithHeadings, WithMapping
{
    use StyledExcelExport;

    public $index = 1;

    public $kwitansies;

    public $tahun;

    public function __construct($kwitansies, $tahun)
    {
        $this->kwitansies = $kwitansies;
        $this->tahun = $tahun;
    }

    public function exportTitle(): string
    {
        return 'Rekap Riwayat Kwitansi PPDB Tahun '.$this->tahun;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return $this->kwitansies;
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

    public function afterStyle(AfterSheet $event): void
    {
        $highestRow = $event->sheet->getHighestRow();

        // Sorot baris yang dihapus dengan latar merah muda
        for ($row = 4; $row <= $highestRow; $row++) {
            $status = $event->sheet->getCell('F'.$row)->getValue();
            if ($status === 'Dihapus') {
                $event->sheet->getStyle('A'.$row.':J'.$row)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('FFFDE2E2');
            }
        }
    }
}
