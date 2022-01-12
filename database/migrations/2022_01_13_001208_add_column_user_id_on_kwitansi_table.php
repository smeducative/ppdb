<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnUserIdOnKwitansiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peserta_ppdb', function (Blueprint $table) {
            $table->primary('id');
        });

        Schema::table('kwitansi', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('nominal'); // penerima biaya

            $table->foreign('peserta_ppdb_id')->references('id')->on('peserta_ppdb')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('peserta_ppdb', function (Blueprint $table) {
            $table->dropPrimary('id');
        });

        Schema::dropColumns('kwitansi', ['user_id']);
    }
}
