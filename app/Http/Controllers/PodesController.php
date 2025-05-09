<?php

namespace App\Http\Controllers;

use App\Models\PodesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PodesController extends Controller
{
    public function index(Request $request) {
        // Ambil data dari database
        $dataDesa = PodesModel::paginate(10);
        $labels = PodesModel::first()->toArray();
        $filteredData = $dataDesa->slice(1, 10);

        // Ambil  filter
        $query = PodesModel::where('COL_1', '!=', 'NAMA_PROV');
        if($request->provinsi) {
            $query->where('COL_1', $request->provinsi);
        }
        $filteredData = $query->paginate(10)->appends(request()->query());

        // Filter RadioButton
        $provinsi = PodesModel::select('COL_1')->distinct()->where('COL_1', '!=', 'NAMA_PROV')->get();
        $kabupaten = PodesModel::select('COL_2')->distinct()->where('COL_1', '!=', 'NAMA_PROV')->get();
        $kecamatan = PodesModel::select('COL_3')->distinct()->where('COL_1', '!=', 'NAMA_PROV')->get();
        $desa = PodesModel::select('COL_4')->distinct()->where('COL_1', '!=', 'NAMA_PROV')->get();

        return view('podes', compact('dataDesa', 'filteredData', 'labels', 'provinsi', 'kabupaten', 'kecamatan', 'desa'));
    }

    public function filter(Request $request)
    {

        return redirect()->route('podes.index',['provinsi' => $request->provinsi, 'kabupaten' => $request->kabupaten, 'kecamatan' => $request->kecamatan, 'desa' => $request->desa]);
    }

}




