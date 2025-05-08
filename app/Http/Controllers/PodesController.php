<?php

namespace App\Http\Controllers;

use App\Models\PodesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PodesController extends Controller
{
    public function index(){

        $dataDesa = PodesModel::paginate(5);
        $columns = Schema::getColumnListing('pengolahan_podes_1');
        // $labels = $dataDesa->first()->toArray();

        // // Hapus baris pertama dari data utama
        // $filteredData = $dataDesa->slice(1)->map(function ($row) use ($labels) {
        //    $row = $row->toArray();
        //     return array_combine($labels, $row);
        // });

        // Hasil
        // dd($labels, $filteredData);

        return view('podes', compact('dataDesa', 'columns'));
    }
}
