<?php

namespace App\Exports;

use App\Models\PesertaPPDB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BelumDaftarUlangExport implements FromCollection, WithHeadings, WithMapping
{
    protected $tahun;
    protected $jurusan;

    public function __construct($tahun = null, $jurusan = null)
    {
        $this->tahun = $tahun ?? now()->year;
        $this->jurusan = $jurusan;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return PesertaPPDB::with('jurusan')
            ->doesntHave('kwitansi')
            ->when($this->jurusan, fn($q) => $q->whereJurusanId($this->jurusan))
            ->whereYear('created_at', $this->tahun)
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'No Pendaftaran',
            'Nama Lengkap',
            'Jurusan',
            'Asal Sekolah',
            'Tahun Lulus',
            'Status',
            'No HP',
            'Alamat Lengkap',
        ];
    }

    public function map($peserta): array
    {
        static $index = 0;
        $index++;

        return [
            $index,
            $peserta->no_pendaftaran,
            $peserta->nama_lengkap,
            $peserta->jurusan->nama_jurusan ?? '-',
            $peserta->asal_sekolah,
            $peserta->tahun_lulus,
            $peserta->diterima == 1 ? 'Diterima' : ($peserta->diterima == 2 ? 'Ditolak' : 'Belum Diverifikasi'),
            $peserta->no_hp,
            $peserta->alamat_lengkap,
        ];
    }
}
