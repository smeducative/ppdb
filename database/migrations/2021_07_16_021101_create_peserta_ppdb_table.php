<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesertaPpdbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peserta_ppdb', function (Blueprint $table) {

            // identitas diri
            $table->uuid('id');
            $table->integer('jurusan_id');
            $table->string('gelombang')->nullable();
            $table->string('photo')->nullable();
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['l', 'p']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('nik');
            $table->string('nisn')->nullable();
            $table->text('alamat_lengkap');
            $table->string('asal_sekolah');
            $table->year('tahun_lulus');
            $table->enum('penerima_kip', ['y', 'n']);
            $table->string('no_kip')->nullable();
            $table->string('no_hp')->nullable();

            // identitas orti or wali

            $table->string('nama_ayah');
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('no_hp_ayah')->nullable();
            $table->string('nama_ibu');
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('no_hp_ibu')->nullable();

            // jenis beasiswa
            // $table->string('jenis_beasiswa')->nullable();

            // a. kelas, semester, peringkat
            // b. hafidz, hafidzoh
            $table->json('akademik')->nullable();
            $table->json('non_akademik')->nullable();
            $table->boolean('rekomendasi_mwc')->default(0);

            // saran dari
            $table->string('saran_dari')->nullable();


            // additional
            $table->string('password')->nullable();


            // di terima apa tidak akan di lakkukan pengecekan oleh admin
            // 0 = proses seleksi
            // 1 = diterima
            // 2 = di tolak
            $table->tinyInteger('diterima')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peserta_ppdb');
    }
}
