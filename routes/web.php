<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PodesController;

Route::get('/', function () {
    return view('welcome');


}

);

Route::get('/podes', [PodesController::class, 'index'])->name('podes.index');
