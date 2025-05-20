<?php

use App\Http\Controllers\FilterController;
use App\Models\KodePodes;
use Illuminate\Support\Facades\Route;



Route::get("/", function () {
    $labels = KodePodes::all();
    return view("dashboard.index", compact("labels"));
});

Route::get("/provinsi", [FilterController::class,"getProvinsi"]);
Route::get("/kabupatenkota", [FilterController::class, "getKabupatenKota"]);
Route::get("/kecamatan", [FilterController::class, "getKecamatan"]);
Route::get("/desakelurahan", [FilterController::class, "getDesaKelurahan"]);

Route::get("/provinsi/{kode_provinsi}/kabupatenkota", [FilterController::class, "getKabupatenByProvinsi"]);
Route::get("/kabupatenkota/{kode_kabupaten_kota}/kecamatan", [FilterController::class, "getKecamatanByKabupaten"]);
Route::get("/kecamatan/{kode_kecamatan}/desakelurahan", [FilterController::class, "getDesaKelurahanByKecamatan"]);

Route::get("/filter", [FilterController::class, "getPodesByFilter"]);
Route::get('/podes/{kodewilayah}' ,[FilterController::class, "getAllPodes"]);
