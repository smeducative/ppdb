<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\KartuPendaftaranController;
use App\Http\Controllers\FormulirController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\KwitansiController;
use App\Http\Controllers\PpdbSettingController;
use App\Http\Controllers\PendaftaranPPDB;
use App\Http\Controllers\UkuranSeragamController;
use App\Http\Controllers\ExportController;
use App\Models\Kwitansi;
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

Route::view('/', 'welcome');
Route::view('/formulir', 'formulir');
Route::post('/formulir', [PendaftaranPPDB::class, 'mendaftar'])->name('ppdb.mendaftar');

Route::prefix('/dashboard')->middleware('auth')->group(function () {

    // setting profile
    ROute::get('setting/profile', [AdminController::class, 'pengaturanAkun'])->name('setting.profile');
    ROute::put('setting/profile', [AdminController::class, 'setAkun'])->name('setting.profile');



    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // ppdb setting
    Route::put('/setting/batas_akhir', [PpdbSettingController::class, 'setBatasAkhir'])->name('ppdb.set.batas.akhir');

    Route::get('/ppdb/list-pendaftar', [PendaftaranPPDB::class, 'listPendaftar'])->name('ppdb.list.pendaftar');

    Route::get('/ppdb/list-pendaftar/{jurusan}', [PendaftaranPPDB::class, 'listPendaftarJurusan'])->name('ppdb.list.pendaftar.jurusan');

    Route::get('/ppdb/tambah-pendaftar', [PendaftaranPPDB::class, 'tambahPendaftar'])->name('ppdb.tambah.pendaftar');

    Route::post('/ppdb/tambah-pendaftar', [PendaftaranPPDB::class, 'submitPendaftar'])->name('ppdb.tambah.pendaftar');

    Route::get('/ppdb/show/{id}', [PendaftaranPPDB::class, 'showPeserta'])->name('ppdb.show.peserta');

    Route::post('/ppdb/daftar-ulang/{uuid}', [PendaftaranPPDB::class, 'terimaPeserta'])->name('ppdb.terima.peserta');

    Route::get('/ppdb/list/terdaftar-ulang/{jurusan}', [PendaftaranPPDB::class, 'listDaftarUlang'])->name('ppdb.daftar.ulang.list');


    Route::prefix('kwitansi')->group(function () {
        Route::get('show', [KwitansiController::class, 'showPesertaDiterima'])->name('ppdb.kwitansi.show');
        Route::get('show/{jurusan}', [KwitansiController::class, 'showJurusanPeserta'])->name('ppdb.kwitansi.show.jurusan');

        // tambah kwitansi
        Route::get('/tambah/{uuid}', [KwitansiController::class, 'tambahKwitansi'])->name('ppdb.kwitansi.tambah');
        Route::post('/tambah/{uuid}', [KwitansiController::class, 'storeKwitansi'])->name('ppdb.kwitansi.tambah');


        // cetak
        Route::post('/cetak/kwitansi/{uuid}', [KwitansiController::class, 'cetakKwitansi'])->name('ppdb.cetak.kwitansi');
        Route::post('/cetak/kwitansi/{uuid}/{id}', [KwitansiController::class, 'cetakKwitansiSingle'])->name('ppdb.cetak.kwitansi.single');
    });


    Route::prefix('ukuran-seragam')->group(function () {
        Route::get('show/{jurusan}', [UkuranSeragamController::class, 'showJurusanPeserta'])->name('ppdb.seragam.show.jurusan');

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
        Route::post('peserta-ppdb', [ExportController::class, 'exportPesertaPpdb'])->name('export.peserta.ppdb');

        // ukuran seragam
        Route::post('ukuran-seragam', [ExportController::class, 'exportSeragam'])->name('export.seragam');
    });
});
