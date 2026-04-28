<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('peserta_ppdb', function (Blueprint $table) {
            $table->boolean('yatim_piatu')->default(false)->after('bertato');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peserta_ppdb', function (Blueprint $table) {
            $table->dropColumn('yatim_piatu');
        });
    }
};
