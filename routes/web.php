<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\KwitansiController;
use App\Http\Controllers\PendaftaranPPDB;
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
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/ppdb/list-pendaftar', [PendaftaranPPDB::class, 'listPendaftar'])->name('ppdb.list.pendaftar');

    Route::get('/ppdb/tambah-pendaftar', [PendaftaranPPDB::class, 'tambahPendaftar'])->name('ppdb.tambah.pendaftar');

    Route::post('/ppdb/tambah-pendaftar', [PendaftaranPPDB::class, 'submitPendaftar'])->name('ppdb.tambah.pendaftar');

    Route::get('/ppdb/show/{id}', [PendaftaranPPDB::class, 'showPeserta'])->name('ppdb.show.peserta');

    Route::post('/ppdb/daftar-ulang/{uuid}', [PendaftaranPPDB::class, 'terimaPeserta'])->name('ppdb.terima.peserta');

    Route::get('/ppdb/list/terdaftar-ulang/{jurusan}', [PendaftaranPPDB::class, 'listDaftarUlang'])->name('ppdb.daftar.ulang.list');


    Route::prefix('kwitansi')->group(function () {
        Route::get('show', [KwitansiController::class, 'showPesertaDiterima'])->name('ppdb.kwitansi.show');

        // tambah kwitansi
        Route::get('/tambah/{uuid}', [KwitansiController::class, 'tambahKwitansi'])->name('ppdb.kwitansi.tambah');
        Route::post('/tambah/{uuid}', [KwitansiController::class, 'tambahKwitansi'])->name('ppdb.kwitansi.tambah');

        // cetak
        Route::post('/cetak/kwitansi/{uuid}', [KwitansiController::class, 'cetakKwitansi'])->name('ppdb.cetak.kwitansi');
        Route::post('/cetak/kwitansi/{uuid}/{id}', [KwitansiController::class, 'cetakKwitansiSingle'])->name('ppdb.cetak.kwitansi.single');
    });
});
