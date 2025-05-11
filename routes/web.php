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

Route::get("/kabupatenbyprovinsi", [FilterController::class, "getKabupatenByProvinsi"]);
Route::get("/kecamatanbykabupaten", [FilterController::class, "getKecamatanByKabupaten"]);
Route::get("/desakelurahanbykecamatan", [FilterController::class, "getDesaKelurahanByKecamatan"]);

Route::get("/podesbyfilter", [FilterController::class, "getPodesByFilter"]);
