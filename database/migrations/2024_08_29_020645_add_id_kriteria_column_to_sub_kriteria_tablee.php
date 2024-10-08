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
        Schema::table('tb_sub_kriteria', function (Blueprint $table) {
            $table->unsignedBigInteger('id_kriteria')->after('id');
            $table->foreign('id_kriteria')->references('id')->on('tb_kriteria');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_sub_kriteria', function (Blueprint $table) {
            $table->dropForeign(['id_kriteria']);
            $table->dropColumn('id_kriteria');
        });
    }
};
