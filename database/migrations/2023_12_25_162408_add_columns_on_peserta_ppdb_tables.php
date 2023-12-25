<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // alamat sediakan langsung untuk mengisi Dukuh, RT, RW, Desa/Kelurahan, Kecamatan, Kabupaten/Kota, Provinsi.
        Schema::table('peserta_ppdb', function (Blueprint $table) {
            $table->after('alamat_lengkap', function ($table) {
                $table->string('dukuh')->nullable();
                $table->string('rt')->nullable();
                $table->string('rw')->nullable();
                $table->string('desa_kelurahan')->nullable();
                $table->string('kecamatan')->nullable();
                $table->string('kabupaten_kota')->nullable();
                $table->string('provinsi')->nullable();
                $table->string('kode_pos')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
            // alamat sediakan langsung untuk mengisi Dukuh, RT, RW, Desa/Kelurahan, Kecamatan, Kabupaten/Kota, Provinsi.
            Schema::table('peserta_ppdb', function (Blueprint $table) {
                $table->dropColumn('dukuh');
                $table->dropColumn('rt');
                $table->dropColumn('rw');
                $table->dropColumn('desa_kelurahan');
                $table->dropColumn('kecamatan');
                $table->dropColumn('kabupaten_kota');
                $table->dropColumn('provinsi');
                $table->dropColumn('kode_pos');
            });
    }
};
