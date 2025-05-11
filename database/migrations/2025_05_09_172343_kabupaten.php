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
        schema::table('kabupaten', function (Blueprint $table) {
            $table->renameColumn('COL 1','kode_provinsi');
            $table->string('kode_provinsi')->change();
            $table->foreign('kode_provinsi')->references('kode_provinsi')->on('provinsi')->onDelete('cascade');
            $table->renameColumn('COL 2','kode_kabkota');
            $table->string('kode_kabkota')->unique()->change();

            $table->renameColumn('COL 3','nama_kabupaten_kota');
            $table->string('nama_kabupaten_kota')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
