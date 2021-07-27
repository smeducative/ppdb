<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUkuranSeragamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ukuran_seragam', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('peserta_ppdb_id');
            $table->string('baju', 3)->nullable();
            $table->string('jas', 3)->nullable();
            $table->string('sepatu', 3)->nullable();
            $table->string('peci', 3)->nullable();
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
        Schema::dropIfExists('ukuran_seragams');
    }
}
