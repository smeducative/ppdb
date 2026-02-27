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
            $table->boolean('bertindik')->default(false)->after('no_hp');
            $table->boolean('bertato')->default(false)->after('bertindik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peserta_ppdb', function (Blueprint $table) {
            $table->dropColumn(['bertindik', 'bertato']);
        });
    }
};
