<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\PendaftaranPPDB;
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

    Route::post('/ppdb/unduh-dokumen/{uuid}', [PendaftaranPPDB::class, 'unduhDokumen'])->name('ppdb.unduh.dokumen');

    Route::get('/ppdb/daftar-ulang/{uuid}', [PendaftaranPPDB::class, 'daftarUlang'])->name('ppdb.daftar-ulang');
    Route::post('/ppdb/daftar-ulang/{uuid}', [PendaftaranPPDB::class, 'daftarUlangPost'])->name('ppdb.daftar.ulang');


    Route::get('/ppdb/list/terdaftar-ulang/{jurusan}', [PendaftaranPPDB::class, 'listDaftarUlang'])->name('ppdb.daftar.ulang.list');
});
