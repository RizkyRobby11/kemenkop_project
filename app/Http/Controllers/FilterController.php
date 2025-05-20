<?php

namespace App\Http\Controllers;

use App\Models\DesaKelurahan;
use App\Models\KabupatenKota;
use App\Models\Kecamatan;
use App\Models\KodePodes;
use App\Models\Podes;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Service\PodesService;

class FilterController extends Controller
{
    protected $podesService;
    public function __construct(PodesService $podesService)
    {
        $this->podesService = $podesService;
    }

 		public function getAllPodes(Request $request)
    {
        // Query
        $query = $this->podesService->getPodesQuery($request->kodewilayah);

        // Detail
        $podes = $this->podesService->getPodesDetail($query);

        // Summary
       $summary = $this->podesService->getPodesSummary($request->kodewilayah);
        $summaryArray = [];


        if ($summary) {
            foreach ($summary->toArray() as $key => $value) {
                $summaryArray[] = [
                    'nama' => $key,
                    'nilai' => $value
        ];
    }
}
        return response()->json([
            'detail' => $podes,
            'summary' => $summaryArray
        ]);
    }
    public function getProvinsi()
    {
        $provinsi = Provinsi::all();
        return response()->json($provinsi);
    }

    public function getKabupatenKota()
    {
        $kabupaten = KabupatenKota::all();
        return response()->json($kabupaten);
    }

    public function getKecamatan()
    {
        $kecamatan = Kecamatan::all();
        return response()->json($kecamatan);
    }
    public function getDesaKelurahan()
    {
        $desaKelurahan = DesaKelurahan::all();
        return response()->json($desaKelurahan);
    }

    public function getKabupatenByProvinsi($kode_provinsi)
    {
        if ($kode_provinsi) {
            $kabupaten = KabupatenKota::where("kode_provinsi", $kode_provinsi)->get();
            return response()->json($kabupaten);
        }
    }

    public function getKecamatanByKabupaten($kode_kabupaten_kota)
    {
        if ($kode_kabupaten_kota) {
            $kecamatan = Kecamatan::where("kode_kabupaten_kota", $kode_kabupaten_kota)->get();
            return response()->json($kecamatan);
        }
    }
    public function getDesaKelurahanByKecamatan($kode_kecamatan)
    {
        if ($kode_kecamatan) {
            $desaKelurahan = DesaKelurahan::where("kode_kecamatan", $kode_kecamatan)->get();
            return response()->json($desaKelurahan);
        }
    }


public function getPodesByFilter(Request $request)
{
    $kodepodes = KodePodes::all();
    // $search  = $request->search ;
    $podes = Podes::query()

        ->when($request->desa_kelurahan, function ($query) use ($request) {
            $query->whereHas('desaKelurahan', function ($q) use ($request) {
                $q->where('kode_desa_kelurahan', $request->desa_kelurahan);
            });
        })
        ->when($request->kecamatan, function ($query) use ($request) {
            $query->whereHas('desaKelurahan.kecamatan', function ($q) use ($request) {
                $q->where('kode_kecamatan', $request->kecamatan);
            });
        })
        ->when($request->kabupaten_kota, function ($query) use ($request) {
            $query->whereHas('desaKelurahan.kecamatan.kabupatenKota', function ($q) use ($request) {
                $q->where('kode_kabupaten_kota', $request->kabupaten_kota);
            });
        })
        ->when($request->provinsi, function ($query) use ($request) {
            $query->whereHas('desaKelurahan.kecamatan.kabupatenKota.provinsi', function ($q) use ($request) {
                $q->where('kode_provinsi', $request->provinsi);
            });
        })
        ->paginate($request->per_page ?? 10);

    // Transform pagination results
    $podes->getCollection()->transform(function ($item) use ($kodepodes) {
        $podesArray = $item->toArray();
        $transformedData = [
            'Provinsi' => $item->desaKelurahan->kecamatan->kabupatenKota->provinsi->nama_provinsi ?? null,
            'Kabupaten' => $item->desaKelurahan->kecamatan->kabupatenKota->nama_kabupaten_kota ?? null,
            'Kecamatan' => $item->desaKelurahan->kecamatan->nama_kecamatan ?? null,
            'Desa' => $item->desaKelurahan->nama_desa_kelurahan ?? null,
            'Kode Desa' => $item->kode_desa_kelurahan,
            'podes' => [] // Tambahkan object podes
        ];

        // Add PODES data with descriptions into podes object
        foreach ($kodepodes as $kode) {
            $columnName = $kode->{'COL 1'};
            if (isset($podesArray[$columnName])) {
                $transformedData['podes'][] = [
                    'nama' => $kode->{'COL 2'},
                    'nilai' => $podesArray[$columnName]
                ];
            }
        }

        return $transformedData;
    });

    return response()->json($podes);
}



}


