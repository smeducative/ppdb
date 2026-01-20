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
        Schema::table('ukuran_seragam', function (Blueprint $table) {
            $table->boolean('seragam_praktik')->default(false)->after('peci');
            $table->boolean('baju_batik')->default(false)->after('seragam_praktik');
            $table->boolean('seragam_olahraga')->default(false)->after('baju_batik');
            $table->boolean('jas_almamater')->default(false)->after('seragam_olahraga');
            $table->boolean('kaos_bintalsik')->default(false)->after('jas_almamater');
            $table->boolean('atribut')->default(false)->after('kaos_bintalsik');
            $table->boolean('kegiatan_bintalsik')->default(false)->after('atribut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ukuran_seragam', function (Blueprint $table) {
            $table->dropColumn([
                'seragam_praktik',
                'baju_batik',
                'seragam_olahraga',
                'jas_almamater',
                'kaos_bintalsik',
                'atribut',
                'kegiatan_bintalsik',
            ]);
        });
    }
};
