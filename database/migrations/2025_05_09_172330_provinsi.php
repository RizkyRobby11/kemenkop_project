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
        Schema::table('provinsi', function (Blueprint $table) {
            $table->renameColumn('COL 1', 'kode_provinsi');
            $table->string('kode_provinsi')->unique()->change();
            $table->renameColumn('COL 2', 'nama_provinsi');
            $table->string('nama_provinsi')->change();
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
