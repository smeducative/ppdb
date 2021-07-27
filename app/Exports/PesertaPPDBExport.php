<?php

namespace App\Exports;

use App\Models\PesertaPPDB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PesertaPPDBExport implements FromCollection, WithHeadings, WithMapping
{
    public $jurusan;
    public $tahun;

    public function __construct($jurusan, $tahun)
    {
        $this->jurusan = $jurusan;
        $this->tahun = $tahun;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return PesertaPPDB::when($this->jurusan != null, function ($query) {
            $query->where('jurusan_id', $this->jurusan);
        })
            ->whereYear('created_at', $this->tahun)->get();
    }

    // heading
    public function headings(): array
    {
        return [
            'No. Pendaftaran',
            'Nama Lengkap'
        ];
    }

    // map
    public function map($peserta): array
    {
        return [
            $peserta->no_pendaftaran,
            $peserta->nama_lengkap
        ];
    }
}
