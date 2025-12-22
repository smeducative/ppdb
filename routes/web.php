<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\BeasiswaController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FormulirController;
use App\Http\Controllers\KartuPendaftaranController;
use App\Http\Controllers\KwitansiController;
use App\Http\Controllers\PendaftaranPPDB;
use App\Http\Controllers\PpdbSettingController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\UkuranSeragamController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return inertia('Landing');
});
Route::get('/register', function () {
    return inertia('Pendaftaran', [
        'jurusan' => \App\Models\Jurusan::all()->map(fn ($j) => [
            'value' => $j->id,
            'label' => $j->nama,
        ]),
    ]);
})->name('ppdb.register');

Route::post('/register', [PendaftaranPPDB::class, 'mendaftar'])->name('ppdb.register.submit');

Route::view('/formulir-old', 'formulir'); // Keeping old just in case

Route::prefix('/dashboard')->middleware('auth')->group(function () {
    // setting profile
    Route::get('setting/profile', [AdminController::class, 'pengaturanAkun'])->name('setting.profile');
    Route::put('setting/profile', [AdminController::class, 'setAkun'])->name('setting.profile');

    // ppdb setting
    Route::get('/setting/ppdb', [PpdbSettingController::class, 'index'])->name('ppdb.set.batas.akhir');
    Route::put('/setting/ppdb', [PpdbSettingController::class, 'setBatasAkhir'])->name('ppdb.set.batas.akhir');

    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // list pendaftar

    Route::get('/ppdb/list-pendaftar', [PendaftaranPPDB::class, 'listPendaftar'])->name('ppdb.list.pendaftar');

    Route::get('/ppdb/list-pendaftar/{jurusan}', [PendaftaranPPDB::class, 'listPendaftarJurusan'])->name('ppdb.list.pendaftar.jurusan');

    // tanbah pendaftar

    Route::get('/ppdb/tambah-pendaftar', [PendaftaranPPDB::class, 'tambahPendaftar'])->name('ppdb.tambah.pendaftar');

    Route::post('/ppdb/tambah-pendaftar', [PendaftaranPPDB::class, 'submitPendaftar'])->name('ppdb.tambah.pendaftar');

    // -- lihat identias pendaftar

    Route::get('/ppdb/show/{id}', [PendaftaranPPDB::class, 'showPeserta'])->name('ppdb.show.peserta');

    // edit pendaftar
    Route::get('/ppdb/edit/{id}', [PendaftaranPPDB::class, 'edit'])->name('ppdb.edit.peserta');
    Route::put('/ppdb/edit/{id}', [PendaftaranPPDB::class, 'update'])->name('ppdb.edit.peserta');
    Route::delete('/ppdb/delete/{id}', [PendaftaranPPDB::class, 'hapusPeserta'])->name('ppdb.delete.peserta');

    // daftar ulanng

    Route::post('/ppdb/daftar-ulang/{uuid}', [PendaftaranPPDB::class, 'terimaPeserta'])->name('ppdb.terima.peserta');

    Route::get('/ppdb/list/terdaftar-ulang/{jurusan?}', [PendaftaranPPDB::class, 'listDaftarUlang'])->name('ppdb.daftar.ulang.list');
    Route::get('/ppdb/list/belum-daftar-ulang/{jurusan?}', [PendaftaranPPDB::class, 'listBelumDaftarUlang'])->name('ppdb.belum.daftar.ulang.list');

    Route::prefix('kwitansi')->group(function () {
        Route::get('show', [KwitansiController::class, 'showPesertaDiterima'])->name('ppdb.kwitansi.show');
        Route::get('show/{jurusan}', [KwitansiController::class, 'showJurusanPeserta'])->name('ppdb.kwitansi.show.jurusan');

        // tambah kwitansi
        Route::get('/tambah/{uuid}', [KwitansiController::class, 'tambahKwitansi'])->name('ppdb.kwitansi.tambah');
        Route::post('/tambah/{uuid}', [KwitansiController::class, 'storeKwitansi'])->name('ppdb.kwitansi.tambah');
        Route::delete('/hapus/{id}', [KwitansiController::class, 'hapusKwitansi'])->name('ppdb.kwitansi.hapus');

        // cetak
        Route::post('/cetak/kwitansi/{uuid}', [KwitansiController::class, 'cetakKwitansi'])->name('ppdb.cetak.kwitansi');
        Route::post('/cetak/kwitansi/{uuid}/{id}', [KwitansiController::class, 'cetakKwitansiSingle'])->name('ppdb.cetak.kwitansi.single');

        // rekap kwitansi
        Route::get('/rekap', [KwitansiController::class, 'rekapKwitansi'])->name('ppdb.rekap.kwitansi');
        Route::get('/rekap/cetak-dana', [KwitansiController::class, 'cetakRekapDanaKwitansi'])->name('ppdb.rekap.kwitansi-dana');
        Route::get('/rekap/cetak-riwayat', [KwitansiController::class, 'cetakRekapRiwayatKwitansi'])->name('ppdb.rekap.kwitansi-riwayat');
    });

    Route::prefix('ukuran-seragam')->group(function () {
        Route::get('show/{jurusan?}', [UkuranSeragamController::class, 'showJurusanPeserta'])->name('ppdb.seragam.show.jurusan');

        Route::post('/ubah/seragam', [UkuranSeragamController::class, 'ubahUkuranSeragam'])->name('ppdb.ubah.seragam');
    });

    Route::prefix('surat')->group(function () {
        Route::get('show/{jurusan}', [SuratController::class, 'showJurusanPeserta'])->name('ppdb.surat.show.jurusan');

        Route::post('/cetak/surat/{jurusan}', [SuratController::class, 'cetakSurat'])->name('ppdb.cetak.surat.semua');
        Route::post('/cetak/surat/{uuid}/single', [SuratController::class, 'cetakSuratSingle'])->name('ppdb.cetak.surat');
    });

    Route::prefix('formulir')->group(function () {
        Route::get('show/{jurusan}', [FormulirController::class, 'showJurusanPeserta'])->name('ppdb.formulir.show.jurusan');

        Route::post('/cetak/formulir/{jurusan}', [FormulirController::class, 'cetakFormulir'])->name('ppdb.cetak.formulir.semua');
        Route::post('/cetak/formulir/{uuid}/single', [FormulirController::class, 'cetakFormulirSingle'])->name('ppdb.cetak.formulir');
    });

    Route::prefix('kartu-pendaftaran')->group(function () {
        Route::get('show/{jurusan}', [KartuPendaftaranController::class, 'showJurusanPeserta'])->name('ppdb.kartu.show.jurusan');

        Route::post('/cetak/kartu/{jurusan}', [KartuPendaftaranController::class, 'cetakKartu'])->name('ppdb.cetak.kartu.semua');
        Route::post('/cetak/kartu/{uuid}/single', [KartuPendaftaranController::class, 'cetakKartuSingle'])->name('ppdb.cetak.kartu');
    });

    Route::prefix('export')->group(function () {
        // peserta ppdb
        Route::get('peserta-ppdb', [ExportController::class, 'exportPesertaPpdb'])->name('export.peserta.ppdb');

        // ukuran seragam
        Route::get('ukuran-seragam', [ExportController::class, 'exportSeragam'])->name('export.seragam');

        // export rekap sekolah
        Route::get('rekap-sekolah', [ExportController::class, 'exportRekapSekolah'])->name('export.rekap-sekolah');

        // export belum daftar ulang
        Route::get('belum-daftar-ulang', [ExportController::class, 'exportBelumDaftarUlang'])->name('export.belum.daftar.ulang');
    });

    // beasiswa route
    Route::prefix('beasiswa')->group(function () {
        // route berdasarkan jenis beasiswa
        // beasiswa rekomendasi mwc, akademik, non akademik, kip
        Route::get('rekomendasi-mwc', [BeasiswaController::class, 'rekomendasiMwc'])->name('ppdb.beasiswa.mwc');
        Route::get('akademik', [BeasiswaController::class, 'beasiswaAkademik'])->name('ppdb.beasiswa.akademik');
        Route::get('non-akademik', [BeasiswaController::class, 'beasiswaNonAkademik'])->name('ppdb.beasiswa.non-akademik');
        Route::get('kip', [BeasiswaController::class, 'beasiswaKip'])->name('ppdb.beasiswa.kip');
        Route::get('tahfidz', [BeasiswaController::class, 'beasiswaTahfidz'])->name('ppdb.beasiswa.tahfidz');
    });
});
