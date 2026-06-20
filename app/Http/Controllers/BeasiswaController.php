<?php

namespace App\Http\Controllers;

use App\Exports\BeasiswaExport;
use App\Http\Requests\BeasiswaFilterRequest;
use App\Models\PesertaPPDB;
use Maatwebsite\Excel\Facades\Excel;

class BeasiswaController extends Controller
{
    private function getKeteranganBeasiswa(string $jenis): string
    {
        return match ($jenis) {
            'mwc' => 'Beasiswa Rekomendasi/Usulan dari Pengurus Ranting MWC Karanganyar. Diberikan kepada anak di setiap daerah Ranting masing-masing. Masing-masing Ranting mendapatkan kesempatan untuk mengusulkan 1 anak. Perolehan Beasiswa: 1,5 Tahun.',
            'akademik' => 'Beasiswa Akademik diberikan kepada calon peserta didik baru yang mempunyai Peringkat 1/2/3 pada waktu duduk di bangku SMP/MTs Sederajat. Dibuktikan raport asli/fotokopi yang dilegalisir oleh Kepala Sekolah SMP/MTs Asal. Peringkat I: 1,5 Tahun, Peringkat II: 1 Tahun, Peringkat III: 1 Semester.',
            'non-akademik' => 'Beasiswa Non Akademik diberikan kepada calon peserta didik baru yang mempunyai prestasi di bidang Non Akademik (Olahraga, Seni). Dibuktikan fotokopi Sertifikat/Piagam penghargaan. Juara I Kabupaten: 1,5 Tahun, Karesidenan: 2 Tahun, Provinsi: 3 Tahun.',
            'kip' => '-',
            'tahfidz' => 'Beasiswa Hafidz dan Hafidzah diberikan kepada calon peserta didik baru yang mampu menghafal Al-Qur\'an minimal 1 Juz. Dibuktikan mampu menghafal di hadapan Petugas Tes Hafalan. Perolehan Beasiswa: Bebas Biaya Pendidikan Selama Sekolah.',
            'yatim-piatu' => 'Beasiswa Yatim Piatu diberikan kepada calon peserta didik baru yang merupakan anak yatim/piatu. Bebas biaya pendidikan selama menjalani pendidikan di SMK Diponegoro Karanganyar.',
            default => '-',
        };
    }

    private function getJenisTitle(string $jenis): string
    {
        return match ($jenis) {
            'mwc' => 'Rekomendasi MWC',
            'akademik' => 'Akademik',
            'non-akademik' => 'Non Akademik',
            'kip' => 'KIP',
            'tahfidz' => 'Tahfidz',
            'yatim-piatu' => 'Yatim Piatu',
            default => '-',
        };
    }

    private function getInertiaProps(array $compact, string $jenis): array
    {
        return $compact + [
            'printSingleRoute' => 'ppdb.cetak.beasiswa',
            'printAllRoute' => 'ppdb.cetak.beasiswa.semua',
            'jenis' => $jenis,
            'defaultKeterangan' => $this->getKeteranganBeasiswa($jenis),
        ];
    }

    public function rekomendasiMwc(BeasiswaFilterRequest $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $search = $request->input('search');
        $title = 'Beasiswa Rekomendasi MWC';

        $query = PesertaPPDB::with('jurusan')->whereRekomendasiMwc(1)
            ->whereYear('created_at', $tahun)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('no_pendaftaran', 'like', "%{$search}%")
                        ->orWhere('asal_sekolah', 'like', "%{$search}%");
                });
            })
            ->latest();

        if ($request->has('export')) {
            $pesertappdb = $query->get();

            return Excel::download(new BeasiswaExport($pesertappdb), $tahun.'-beasiswa-rekomendasi-mwc.xlsx');
        }

        $pesertappdb = $query->paginate($request->input('per_page', 10))->withQueryString();
        $years = range(now()->year, now()->year - 5);

        return inertia('Admin/Beasiswa/Index', $this->getInertiaProps(
            compact('pesertappdb', 'title', 'tahun', 'years'), 'mwc'
        ));
    }

    public function beasiswaAkademik(BeasiswaFilterRequest $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $search = $request->input('search');
        $title = 'Beasiswa Akademik';

        $query = PesertaPPDB::query()->with('jurusan')
            ->where('akademik->kelas', '!=', '')
            ->where('akademik->semester', '!=', '')
            ->where('akademik->peringkat', '!=', '')
            ->whereYear('created_at', $tahun)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('no_pendaftaran', 'like', "%{$search}%")
                        ->orWhere('asal_sekolah', 'like', "%{$search}%");
                });
            })
            ->latest();

        if ($request->has('export')) {
            $pesertappdb = $query->get();

            return Excel::download(new BeasiswaExport($pesertappdb), $tahun.'-beasiswa-akademik.xlsx');
        }

        $pesertappdb = $query->paginate($request->input('per_page', 10))->withQueryString();
        $years = range(now()->year, now()->year - 5);

        return inertia('Admin/Beasiswa/Index', $this->getInertiaProps(
            compact('pesertappdb', 'title', 'tahun', 'years'), 'akademik'
        ));
    }

    public function beasiswaNonAkademik(BeasiswaFilterRequest $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $search = $request->input('search');
        $title = 'Beasiswa Non Akademik';

        $query = PesertaPPDB::with('jurusan')
            ->where('non_akademik->jenis_lomba', '!=', '')
            ->where('non_akademik->juara_ke', '!=', '')
            ->where('non_akademik->juara_tingkat', '!=', '')
            ->whereYear('created_at', $tahun)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('no_pendaftaran', 'like', "%{$search}%")
                        ->orWhere('asal_sekolah', 'like', "%{$search}%");
                });
            })
            ->latest();

        if ($request->has('export')) {
            $pesertappdb = $query->get();

            return Excel::download(new BeasiswaExport($pesertappdb), $tahun.'-beasiswa-non-akademik.xlsx');
        }

        $pesertappdb = $query->paginate($request->input('per_page', 10))->withQueryString();
        $years = range(now()->year, now()->year - 5);

        return inertia('Admin/Beasiswa/Index', $this->getInertiaProps(
            compact('pesertappdb', 'title', 'tahun', 'years'), 'non-akademik'
        ));
    }

    public function beasiswaKIP(BeasiswaFilterRequest $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $search = $request->input('search');
        $title = 'Beasiswa KIP';

        $query = PesertaPPDB::with('jurusan')
            ->where('penerima_kip', 'y')
            ->whereYear('created_at', $tahun)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('no_pendaftaran', 'like', "%{$search}%")
                        ->orWhere('asal_sekolah', 'like', "%{$search}%");
                });
            })
            ->latest();

        if ($request->has('export')) {
            $pesertappdb = $query->get();

            return Excel::download(new BeasiswaExport($pesertappdb), $tahun.'-beasiswa-kip.xlsx');
        }

        $pesertappdb = $query->paginate($request->input('per_page', 10))->withQueryString();
        $years = range(now()->year, now()->year - 5);

        return inertia('Admin/Beasiswa/Index', $this->getInertiaProps(
            compact('pesertappdb', 'title', 'tahun', 'years'), 'kip'
        ));
    }

    public function beasiswaTahfidz(BeasiswaFilterRequest $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $search = $request->input('search');
        $title = 'Beasiswa Akademik [Tahfidz]';

        $query = PesertaPPDB::with('jurusan')
            ->where('akademik->hafidz', '!=', '')
            ->where('akademik->hafidz', '!=', '-')
            ->where('akademik->hafidz', '!=', '_')
            ->whereYear('created_at', $tahun)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('no_pendaftaran', 'like', "%{$search}%")
                        ->orWhere('asal_sekolah', 'like', "%{$search}%");
                });
            })
            ->latest();

        if ($request->has('export')) {
            $pesertappdb = $query->get();

            return Excel::download(new BeasiswaExport($pesertappdb), $tahun.'-beasiswa-tahfidz.xlsx');
        }

        $pesertappdb = $query->paginate($request->input('per_page', 10))->withQueryString();
        $years = range(now()->year, now()->year - 5);

        return inertia('Admin/Beasiswa/Index', $this->getInertiaProps(
            compact('pesertappdb', 'title', 'tahun', 'years'), 'tahfidz'
        ));
    }

    public function beasiswaYatimPiatu(BeasiswaFilterRequest $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $search = $request->input('search');
        $title = 'Beasiswa Yatim Piatu';

        $query = PesertaPPDB::with('jurusan')
            ->whereYatimPiatu(1)
            ->whereYear('created_at', $tahun)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('no_pendaftaran', 'like', "%{$search}%")
                        ->orWhere('asal_sekolah', 'like', "%{$search}%");
                });
            })
            ->latest();

        if ($request->has('export')) {
            $pesertappdb = $query->get();

            return Excel::download(new BeasiswaExport($pesertappdb), $tahun.'-beasiswa-yatim-piatu.xlsx');
        }

        $pesertappdb = $query->paginate($request->input('per_page', 10))->withQueryString();
        $years = range(now()->year, now()->year - 5);

        return inertia('Admin/Beasiswa/Index', $this->getInertiaProps(
            compact('pesertappdb', 'title', 'tahun', 'years'), 'yatim-piatu'
        ));
    }

    public function cetakBeasiswaSingle($uuid)
    {
        $peserta = PesertaPPDB::with('jurusan')->findOrFail($uuid);
        $jenis = $this->resolveJenis($peserta);
        $defaultKeterangan = $this->getKeteranganBeasiswa($jenis);
        $keterangan = request('keterangan', $defaultKeterangan);
        $user = auth()->user();

        return view('pdf.cetak-beasiswa', compact('peserta', 'keterangan', 'jenis', 'user'));
    }

    public function cetakBeasiswaSemua($jenis)
    {
        $query = match ($jenis) {
            'mwc' => PesertaPPDB::with('jurusan')->whereRekomendasiMwc(1),
            'akademik' => PesertaPPDB::with('jurusan')
                ->where('akademik->kelas', '!=', '')
                ->where('akademik->semester', '!=', '')
                ->where('akademik->peringkat', '!=', ''),
            'non-akademik' => PesertaPPDB::with('jurusan')
                ->where('non_akademik->jenis_lomba', '!=', '')
                ->where('non_akademik->juara_ke', '!=', '')
                ->where('non_akademik->juara_tingkat', '!=', ''),
            'kip' => PesertaPPDB::with('jurusan')->where('penerima_kip', 'y'),
            'tahfidz' => PesertaPPDB::with('jurusan')
                ->where('akademik->hafidz', '!=', '')
                ->where('akademik->hafidz', '!=', '-')
                ->where('akademik->hafidz', '!=', '_'),
            'yatim-piatu' => PesertaPPDB::with('jurusan')->whereYatimPiatu(1),
            default => null,
        };

        if (! $query) {
            abort(404);
        }

        $pesertas = $query->whereYear('created_at', now()->year)->latest()->get();
        $defaultKeterangan = $this->getKeteranganBeasiswa($jenis);
        $keterangan = request('keterangan', $defaultKeterangan);
        $user = auth()->user();

        return view('pdf.cetak-beasiswa', compact('pesertas', 'keterangan', 'jenis', 'user'));
    }

    private function resolveJenis(PesertaPPDB $peserta): string
    {
        if ($peserta->rekomendasi_mwc) {
            return 'mwc';
        }

        if ($peserta->penerima_kip === 'y') {
            return 'kip';
        }

        if ($peserta->yatim_piatu) {
            return 'yatim-piatu';
        }

        $akademik = $peserta->akademik ?? [];
        if (! empty($akademik['hafidz']) && ! in_array($akademik['hafidz'], ['-', '_'])) {
            return 'tahfidz';
        }

        if (! empty($akademik['kelas']) && ! empty($akademik['semester']) && ! empty($akademik['peringkat'])) {
            return 'akademik';
        }

        $nonAkademik = $peserta->non_akademik ?? [];
        if (! empty($nonAkademik['jenis_lomba']) && ! empty($nonAkademik['juara_ke']) && ! empty($nonAkademik['juara_tingkat'])) {
            return 'non-akademik';
        }

        return 'mwc';
    }
}
