<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\PesertaPPDB;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $tahun = request('tahun', now()->year);

        $peserta = PesertaPPDB::select(DB::raw('jurusan_id, count(*) as c'))->whereYear('created_at', $tahun)->groupBy('jurusan_id')->get();

        $acc = PesertaPPDB::whereYear('created_at', $tahun);

        // if (!$acc->count()) {
        //     return abort(404);
        // }

        $penerimaan = [
            'diterima' => $acc->where('diterima', 1)->count(),
            'ditolak' => $acc->where('diterima', 2)->count(),
        ];

        $pesertadu = PesertaPPDB::has('kwitansi')->select(DB::raw('jurusan_id, count(*) as c'))->whereYear('created_at', $tahun)->groupBy('jurusan_id')->get();

        // based on id
        // tjk = 1,  atph = 3,
        // bdp = 4, tsm = 6, tkr = 7

        $count = [
            'tkj' => collect($peserta)->where('jurusan_id', 1)->first()->c ?? 0,
            'to' => collect($peserta)->where('jurusan_id', 2)->first()->c ?? 0,
            'atph' => collect($peserta)->where('jurusan_id', 3)->first()->c ?? 0,
            'bdp' => collect($peserta)->where('jurusan_id', 4)->first()->c ?? 0,
            'tsm' => collect($peserta)->where('jurusan_id', 6)->first()->c ?? 0,
            'tkr' => collect($peserta)->where('jurusan_id', 7)->first()->c ?? 0,
            'all' => collect($peserta)->sum('c') ?? 0,
        ];

        $du = [
            'tkj' => collect($pesertadu)->where('jurusan_id', 1)->first()->c ?? 0,
            'to' => collect($pesertadu)->where('jurusan_id', 2)->first()->c ?? 0,
            'atph' => collect($pesertadu)->where('jurusan_id', 3)->first()->c ?? 0,
            'bdp' => collect($pesertadu)->where('jurusan_id', 4)->first()->c ?? 0,
            'tsm' => collect($pesertadu)->where('jurusan_id', 6)->first()->c ?? 0,
            'tkr' => collect($pesertadu)->where('jurusan_id', 7)->first()->c ?? 0,
            'all' => collect($pesertadu)->sum('c') ?? 0,
        ];

        $compare = Jurusan::with('pesertaPpdb:id,jurusan_id')->withCount([
            'pesertaPpdb as l' => function ($query) use ($tahun) {
                $query->whereYear('created_at', $tahun)->where('jenis_kelamin', 'l');
            },
            'pesertaPpdb as p' => function ($query) use ($tahun) {
                $query->whereYear('created_at', $tahun)->where('jenis_kelamin', 'p');
            },
        ])->orderBy('id')->get();

        $compareDu = Jurusan::withCount([
            'pesertaPpdb as l' => function ($query) use ($tahun) {
                $query->has('kwitansi')->whereYear('created_at', $tahun)->where('jenis_kelamin', 'l')->where('diterima', 1);
            },
            'pesertaPpdb as p' => function ($query) use ($tahun) {
                $query->has('kwitansi')->whereYear('created_at', $tahun)->where('jenis_kelamin', 'p')->where('diterima', 1);
            },
        ])->orderBy('id')->get();

        $compareSx = [
            'p' => collect($compare)->pluck('p'),
            'l' => collect($compare)->pluck('l'),
        ];

        $compareDx = [
            'p' => collect($compareDu)->pluck('p'),
            'l' => collect($compareDu)->pluck('l'),
        ];

        $lastYear = now()->setYear($tahun)->subYear()->format('Y');

        // Perbandingan pendaftar bulanan per tahun sekarang dengan tahun sebelumnya
        $yearDiff = PesertaPPDB::select(
            DB::raw('YEAR(created_at) as tahun, MONTH(created_at) as bulan, count(*) as jumlah_pendaftar')
        )
            ->whereRaw("YEAR(created_at) >= $lastYear")
            ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
            ->get();

        // Perbandingan daftar ulang bulanan per tahun sekarang dengan tahun sebelumnya
        $yearDiffDaftarUlang = PesertaPPDB::select(
            DB::raw('YEAR(created_at) as tahun, MONTH(created_at) as bulan, count(*) as jumlah_daftar_ulang')
        )
            ->has('kwitansi')
            ->whereRaw("YEAR(created_at) >= $lastYear")
            ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
            ->get();

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        $yearDiff = $yearDiff->map(function ($item) use ($months) {
            return [
                'tahun' => $item->tahun,
                'bulan' => $months[$item->bulan - 1],
                'jumlah_pendaftar' => $item->jumlah_pendaftar,
            ];
        })->groupBy('tahun');

        // If current year is not in the yearDiff, add it
        if (! $yearDiff->has(now()->year)) {
            $yearDiff->put(now()->year, collect());
        }

        $yearDiffDaftarUlang = $yearDiffDaftarUlang->map(function ($item) use ($months) {
            return [
                'tahun' => $item->tahun,
                'bulan' => $months[$item->bulan - 1],
                'jumlah_daftar_ulang' => $item->jumlah_daftar_ulang,
            ];
        })->groupBy('tahun');

        // If current year is not in the yearDiffDaftarUlang, add it
        if (! $yearDiffDaftarUlang->has(now()->year)) {
            $yearDiffDaftarUlang->put(now()->year, collect());
        }

        // Daily registration trends for the current year
        $dailyTrends = PesertaPPDB::select(
            DB::raw('DATE(created_at) as tanggal, count(*) as jumlah')
        )
            ->whereYear('created_at', $tahun)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('tanggal')
            ->get();

        // Acceptance rates by major
        $acceptanceByMajor = Jurusan::withCount([
            'pesertaPpdb as total' => function ($query) use ($tahun) {
                $query->whereYear('created_at', $tahun);
            },
            'pesertaPpdb as diterima' => function ($query) use ($tahun) {
                $query->whereYear('created_at', $tahun)->where('diterima', 1);
            },
            'pesertaPpdb as ditolak' => function ($query) use ($tahun) {
                $query->whereYear('created_at', $tahun)->where('diterima', 2);
            }
        ])->orderBy('id')->get();

        // Gender distribution over time (monthly)
        $genderOverTime = PesertaPPDB::select(
            DB::raw('MONTH(created_at) as bulan, jenis_kelamin, count(*) as jumlah')
        )
            ->whereYear('created_at', $tahun)
            ->groupBy(DB::raw('MONTH(created_at), jenis_kelamin'))
            ->orderBy('bulan')
            ->get()
            ->groupBy('bulan')
            ->map(function ($group) use ($months) {
                return [
                    'bulan' => $months[$group->first()->bulan - 1],
                    'laki' => $group->where('jenis_kelamin', 'l')->first()->jumlah ?? 0,
                    'perempuan' => $group->where('jenis_kelamin', 'p')->first()->jumlah ?? 0,
                ];
            });

        // perbandingan per jumlah sekolah pendaftar
        $pendaftarPerSekolah = PesertaPPDB::select(DB::raw('asal_sekolah, count(asal_sekolah) as as_count'))
            ->whereYear('created_at', $tahun)
            ->groupBy('asal_sekolah')
            ->orderByDesc('as_count')
            ->limit(10) // Limit to top 10 schools for the chart
            ->get();

        $pendaftarPerSekolahCount = PesertaPPDB::select(DB::raw('asal_sekolah, count(asal_sekolah) as as_count'))
            ->whereYear('created_at', $tahun)
            ->groupBy('asal_sekolah')
            ->orderByDesc('as_count')
            ->get();

        $daftarUlangPerSekolah = PesertaPPDB::select(DB::raw('asal_sekolah, count(asal_sekolah) as as_count'))
            ->has('kwitansi')
            ->whereYear('created_at', $tahun)
            ->groupBy('asal_sekolah')
            ->orderByDesc('as_count')
            ->limit(10) // Limit to top 10 schools for the chart
            ->get();

        $daftarUlangPerSekolahCount = PesertaPPDB::select(DB::raw('asal_sekolah, count(asal_sekolah) as as_count'))
            ->has('kwitansi')
            ->whereYear('created_at', $tahun)
            ->groupBy('asal_sekolah')
            ->orderByDesc('as_count')
            ->get();

        return inertia('Admin/Dashboard', compact('count', 'du', 'compareSx', 'compareDx', 'pendaftarPerSekolah', 'penerimaan', 'yearDiff', 'yearDiffDaftarUlang', 'tahun', 'lastYear', 'dailyTrends', 'acceptanceByMajor', 'genderOverTime', 'pendaftarPerSekolahCount', 'daftarUlangPerSekolah', 'daftarUlangPerSekolahCount'));
    }

    public function pengaturanAkun()
    {
        $user = auth()->user();

        return inertia('Admin/Profile', compact('user'));
    }

    public function setAkun()
    {
        $data = request()->validate([
            'name' => ['required'],
            'password' => ['required', 'confirmed'],
        ]);

        auth()->user()->update([
            'name' => request('name'),
            'password' => bcrypt(request('password')),
        ]);

        session()->flash('success', 'Data user dan password berhasil di ganti');

        return back();
    }
}
