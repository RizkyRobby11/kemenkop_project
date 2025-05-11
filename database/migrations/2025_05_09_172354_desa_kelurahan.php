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
        schema::table('desa_kelurahan', function (Blueprint $table) {
            $table->renameColumn('COL 1', 'kode_provinsi');
            $table->string('kode_provinsi')->change();
        $table->foreign('kode_provinsi')->references('kode_provinsi')->on('provinsi')->onDelete('cascade');

            $table->renameColumn('COL 2', 'kode_kabkota');
            $table->string('kode_kabkota')->change();
        $table->foreign('kode_kabkota')->references('kode_kabkota')->on('kabupaten')->onDelete('cascade');

        $table->renameColumn('COL 3', 'kode_kecamatan');
            $table->string('kode_kecamatan')->change();
            $table->foreign('kode_kecamatan')->references('kode_kecamatan')->on('kecamatan')->onDelete('cascade');

            $table->renameColumn('COL 4', 'kode_desa_kelurahan');
            $table->string('kode_desa_kelurahan')->unique()->change();

            $table->renameColumn('COL 5', 'nama_desa_kelurahan');
            $table->string('nama_desa_kelurahan')->change();


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
