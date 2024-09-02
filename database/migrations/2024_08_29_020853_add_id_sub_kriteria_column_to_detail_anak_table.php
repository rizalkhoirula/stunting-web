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
        Schema::table('tb_detail_anak', function (Blueprint $table) {
            $table->unsignedBigInteger('id_sub_kriteria')->after('id');
            $table->foreign('id_sub_kriteria')->references('id')->on('tb_sub_kriteria');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_detail_anak', function (Blueprint $table) {
            $table->dropForeign(['id_sub_kriteria']);
            $table->dropColumn('id_sub_kriteria');
        });
    }
};
