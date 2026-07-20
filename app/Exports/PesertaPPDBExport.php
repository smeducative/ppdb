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

class PesertaPPDBExport implements FromCollection, ShouldAutoSize, WithCustomStartCell, WithEvents, WithHeadings, WithMapping
{
    use StyledExcelExport;

    public $jurusan;

    public $tahun;

    public $status;

    protected $index = 0;

    public function __construct($jurusan, $tahun, $status = 'semua')
    {
        $this->jurusan = $jurusan;
        $this->tahun = $tahun;
        $this->status = $status;
    }

    public function exportTitle(): string
    {
        return 'Data Peserta PPDB Tahun '.$this->tahun;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return PesertaPPDB::when(! empty($this->jurusan), function ($query) {
            $query->where('jurusan_id', $this->jurusan);
        })
            ->whereYear('created_at', $this->tahun)
            ->when($this->status === 'diterima', function ($query) {
                $query->whereDiterima(1);
            })
            ->when($this->status === 'sudah_du', function ($query) {
                $query->whereDiterima(1)->has('kwitansi');
            })
            ->when($this->status === 'belum_du', function ($query) {
                $query->doesntHave('kwitansi');
            })
            ->get();
    }

    // heading
    public function headings(): array
    {
        return [
            'No',
            'No. Pendaftaran',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Pilihan Jurusan',
            'NIK',
            'NISN',
            'Alamat Lengkap',
            'Dukuh',
            'rt',
            'rw',
            'desa_kelurahan',
            'kecamatan',
            'kabupaten_kota',
            'provinsi',
            'kode_pos',
            'Asal Sekolah',
            'Tahun Lulus',
            'Penerima KIP',
            'No. KIP',
            'Nomor Telepon',
            'Bertindik',
            'Bertato',
            'Yatim Piatu',
            'Nama Ayah',
            'Pekerjaan Ayah',
            'Nomor Telepon Ayah',
            'Nama Ibu',
            'Pekerjaan Ibu',
            'Nomor Telepon Ibu',
            'Akademik Kelas / Semster / Peringkat',
            'Akademik Hafidz / Hafidzoh',
            'Non Akademik Jenis Lomba',
            'Non Akademik Juara ke',
            'Non Akademik Tingkat',
            'Rekomendasi MWC',
            'Saran Dari',
        ];
    }

    // map
    public function map($peserta): array
    {
        $this->index++;

        return [
            $this->index,
            $peserta->no_pendaftaran,
            $peserta->nama_lengkap,
            $peserta->jenis_kelamin == 'l' ? 'Laki-laki' : 'Perempuan',
            $peserta->tempat_lahir,
            $peserta->tanggal_lahir->format('d F Y'),
            $peserta->jurusan->nama,
            '\''.$peserta->nik,
            '\''.$peserta->nisn,
            $peserta->alamat_lengkap,
            $peserta->dukuh,
            $peserta->rt,
            $peserta->rw,
            $peserta->desa_kelurahan,
            $peserta->kecamatan,
            $peserta->kabupaten_kota,
            $peserta->provinsi,
            $peserta->kode_pos,
            $peserta->asal_sekolah,
            $peserta->tahun_lulus,
            $peserta->penerima_kip == 'y' ? 'Ya' : 'Tidak',
            '\''.$peserta->no_kip,
            '\''.$peserta->no_hp,
            $peserta->bertindik ? 'Ya' : 'Tidak',
            $peserta->bertato ? 'Ya' : 'Tidak',
            $peserta->yatim_piatu ? 'Ya' : 'Tidak',
            $peserta->nama_ayah,
            $peserta->pekerjaan_ayah,
            '\''.$peserta->no_hp_ayah,
            $peserta->nama_ibu,
            $peserta->pekerjaan_ibu,
            '\''.$peserta->no_hp_ibu,
            $peserta->akademik['kelas'].' / '.$peserta->akademik['semester'].' / '.$peserta->akademik['peringkat'],
            $peserta->akademik['hafidz'],
            $peserta->non_akademik['jenis_lomba'],
            $peserta->non_akademik['juara_ke'],
            $peserta->non_akademik['juara_tingkat'],
            $peserta->rekomendasi_mwc == 1 ? 'Ya' : 'Tidak',
            $peserta->saran_dari,
        ];
    }
}
