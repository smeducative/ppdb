<?php

namespace App\Exports;

use App\Exports\Concerns\StyledExcelExport;
use App\Models\PesertaPPDB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SeragamExport implements FromCollection, ShouldAutoSize, WithCustomStartCell, WithEvents, WithHeadings, WithMapping
{
    use StyledExcelExport;

    public $jurusan;

    public $tahun;

    public $status;

    protected $index = 0;

    public function __construct($jurusan, $tahun, $status = 'diterima')
    {
        $this->jurusan = $jurusan;
        $this->tahun = $tahun;
        $this->status = $status;
    }

    public function exportTitle(): string
    {
        return 'Data Ukuran Seragam Peserta PPDB Tahun '.$this->tahun;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return PesertaPPDB::with('ukuranSeragam')
            ->when(! empty($this->jurusan), function ($query) {
                return $query->where('jurusan_id', $this->jurusan);
            })
            ->whereYear('created_at', $this->tahun)
            ->when($this->status === 'sudah_du', function ($query) {
                return $query->whereDiterima(1)->has('kwitansi');
            })
            ->when($this->status === 'diterima', function ($query) {
                return $query->whereDiterima(1);
            })
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'No Pendaftaran',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tgl Lahir',
            'Baju (wear pack)',
            'Jas',
            'Sepatu',
            'Peci',
            'Seragam Praktik',
            'Baju Batik',
            'Seragam Olahraga',
            'Jas Almamater',
            'Kaos Bintalsik',
            'Atribut',
            'Kegiatan Bintalsik',
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
            $row->tanggal_lahir?->format('d-m-Y'),
            $row->ukuranSeragam?->baju ?? '-',
            $row->ukuranSeragam?->jas ?? '-',
            $row->ukuranSeragam?->sepatu ?? '-',
            $row->ukuranSeragam?->peci ?? '-',
            ($row->ukuranSeragam?->seragam_praktik ?? false) ? 'Ya' : 'Tidak',
            ($row->ukuranSeragam?->baju_batik ?? false) ? 'Ya' : 'Tidak',
            ($row->ukuranSeragam?->seragam_olahraga ?? false) ? 'Ya' : 'Tidak',
            ($row->ukuranSeragam?->jas_almamater ?? false) ? 'Ya' : 'Tidak',
            ($row->ukuranSeragam?->kaos_bintalsik ?? false) ? 'Ya' : 'Tidak',
            ($row->ukuranSeragam?->atribut ?? false) ? 'Ya' : 'Tidak',
            ($row->ukuranSeragam?->kegiatan_bintalsik ?? false) ? 'Ya' : 'Tidak',
        ];
    }
}
