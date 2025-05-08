<?php

namespace App\Http\Controllers;

use App\Models\PodesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PodesController extends Controller
{
    public function index() {
        $dataDesa = PodesModel::paginate(10);
        $labels = PodesModel::first()->toArray();

        // Ubah semua baris menjadi associative array dengan kolom sebagai key
        $filteredData = $dataDesa->slice(1, 10);

        // Dd($dataDesa);

        return view('podes', compact('dataDesa', 'filteredData', 'labels'));
    }

}




