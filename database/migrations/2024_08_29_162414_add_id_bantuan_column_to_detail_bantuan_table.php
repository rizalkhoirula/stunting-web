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
        Schema::table('tb_detail_bantuan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_bantuan')->after('id');
            $table->foreign('id_bantuan')->references('id')->on('tb_bantuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_detail_bantuan', function (Blueprint $table) {
            $table->dropForeign(['id_bantuan']);
            $table->dropColumn('id_bantuan');
        });
    }
};
