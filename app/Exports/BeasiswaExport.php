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

class BeasiswaExport implements FromCollection, ShouldAutoSize, WithCustomStartCell, WithEvents, WithHeadings, WithMapping
{
    use StyledExcelExport;

    public $pesertappdb;

    protected $index = 0;

    public function __construct($pesertappdb)
    {
        $this->pesertappdb = $pesertappdb;
    }

    public function exportTitle(): string
    {
        return 'Data Penerima Beasiswa PPDB Tahun '.now()->year;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return $this->pesertappdb;
    }

    public function headings(): array
    {
        return [
            'No',
            'no pendaftaran',
            'nama lengkap',
            'jenis kelamin',
            'tempat lahir',
            'tanggal lahir',
            'pilihan jurusan',
            'akademik',
            'non akademik',
            'penerima kip',
            'no kip',
            'rekomendasi mwc',
            'no hp',
            'alamat lengkap',
            'asal sekolah',
        ];
    }

    public function map($row): array
    {
        $this->index++;

        return [
            $this->index,
            $row->no_pendaftaran,
            $row->nama_lengkap,
            $row->jenis_kelamin === 'p' ? 'Perempuan' : 'Laki-laki',
            $row->tempat_lahir,
            $row->tanggal_lahir,
            $row->jurusan->nama,
            $row->akademik,
            $row->non_akademik,
            $row->penerima_kip === 'y' ? 'Ya' : 'Tidak',
            $row->no_kip,
            $row->rekomendasi_mwc ? 'Ya' : 'Tidak',
            $row->no_hp,
            $row->alamat_lengkap,
            $row->asal_sekolah,
        ];
    }
}
