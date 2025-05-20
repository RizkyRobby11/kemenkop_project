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

class FilterController extends Controller
{
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
// public function getPodesAllProvinsiIndustri(Request $request)
// {
//     $kodepodes = KodePodes::all();
//     $podes = Podes::query()
//         ->when($request->provinsi, function ($query) use ($request) {
//             $query->whereHas('desaKelurahan.kecamatan.kabupatenKota.provinsi', function ($q) use ($request) {
//                 $q->where('kode_provinsi', $request->provinsi);
//             });
//         })
//         ->get();
//     // Group by provinsi
//     $grouped = $podes->groupBy(function($item) {
//         return $item->desaKelurahan->kecamatan->kabupatenKota->provinsi->nama_provinsi ?? 'Tidak diketahui';
//     });

//     $result = [];
//     foreach ($grouped as $provinsi => $items) {
//         foreach ($kodepodes as $kode) {
//             $columnName = $kode->{'COL 1'};
//             $namaIndustri = $kode->{'COL 2'};
//             $totalNilai = 0;
//             foreach ($items as $item) {
//                 $podesArray = $item->toArray();
//                 if (isset($podesArray[$columnName])) {
//                     $totalNilai += $podesArray[$columnName];
//                 }
//             }
//             $result[] = [
//                 'provinsi' => $provinsi,
//                 'nama' => $namaIndustri,
//                 'nilai' => $totalNilai
//             ];
//         }
//     }

//     return response()->json($result);
// }


public function getAllPodesByKecamatan(Request $request)
    {
        if (!$request->kecamatan) {
            return response()->json([
                'message' => 'Kode kecamatan is required'
            ], 400);
        }

        $kodepodes = KodePodes::all();

        // Get detailed podes data
        $podes = Podes::query()
            ->whereHas('desaKelurahan.kecamatan', function ($query) use ($request) {
                $query->where('kode_kecamatan', $request->kecamatan);
            })
            ->paginate(10);

        // Get summary data
        $selectRaw = ['kecamatan.kode_kecamatan', 'kecamatan.nama_kecamatan'];
        foreach ($kodepodes as $kode) {
            $columnName = $kode->{'COL 1'};
            $selectRaw[] = DB::raw("SUM(podes.{$columnName}) as '{$kode->{'COL 2'} }'");
        }

        $summary = Podes::query()
            ->join('desa_kelurahan', 'podes.kode_desa_kelurahan', '=', 'desa_kelurahan.kode_desa_kelurahan')
            ->join('kecamatan', 'desa_kelurahan.kode_kecamatan', '=', 'kecamatan.kode_kecamatan')
            ->where('kecamatan.kode_kecamatan', $request->kecamatan)
            ->select($selectRaw)
            ->groupBy('kecamatan.kode_kecamatan', 'kecamatan.nama_kecamatan')
            ->first();

        // Transform pagination results
        $podes->getCollection()->transform(function ($item) use ($kodepodes) {
            $podesArray = $item->toArray();
            $transformedData = [
                'NAMA PROVINSI' => $item->desaKelurahan->kecamatan->kabupatenKota->provinsi->nama_provinsi ?? null,
                'NAMA KABUPATEN' => $item->desaKelurahan->kecamatan->kabupatenKota->nama_kabupaten_kota ?? null,
                'NAMA KECAMATAN' => $item->desaKelurahan->kecamatan->nama_kecamatan ?? null,
                'NAMA DESA' => $item->desaKelurahan->nama_desa_kelurahan ?? null,
                'KODE DESA' => $item->kode_desa_kelurahan
            ];

            // Add PODES data with descriptions
            foreach ($kodepodes as $kode) {
                $columnName = $kode->{'COL 1'};
                if (isset($podesArray[$columnName])) {
                    $transformedData[$kode->{'COL 2'}] = $podesArray[$columnName];
                }
            }

            return $transformedData;
        });

        return response()->json([
            'detail' => $podes,
            'summary' => $summary
        ]);
    }
    public function getAllPodesByKabupaten(Request $request)
{
    if (!$request->kabupaten_kota) {
        return response()->json([
            'message' => 'Kode kabupaten/kota is required'
        ], 400);
    }

    $kodepodes = KodePodes::all();

    // Get detailed podes data
    $podes = Podes::query()
        ->whereHas('desaKelurahan.kecamatan.kabupatenKota', function ($query) use ($request) {
            $query->where('kode_kabupaten_kota', $request->kabupaten_kota);
        })
        ->paginate(10);

    // Get summary data
    $selectRaw = ['kabupaten_kota.kode_kabupaten_kota', 'kabupaten_kota.nama_kabupaten_kota'];
    foreach ($kodepodes as $kode) {
        $columnName = $kode->{'COL 1'};
        $selectRaw[] = DB::raw("SUM(podes.{$columnName}) as '{$kode->{'COL 2'} }'");
    }

    $summary = Podes::query()
        ->join('desa_kelurahan', 'podes.kode_desa_kelurahan', '=', 'desa_kelurahan.kode_desa_kelurahan')
        ->join('kecamatan', 'desa_kelurahan.kode_kecamatan', '=', 'kecamatan.kode_kecamatan')
        ->join('kabupaten_kota', 'kecamatan.kode_kabupaten_kota', '=', 'kabupaten_kota.kode_kabupaten_kota')
        ->where('kabupaten_kota.kode_kabupaten_kota', $request->kabupaten_kota)
        ->select($selectRaw)
        ->groupBy('kabupaten_kota.kode_kabupaten_kota', 'kabupaten_kota.nama_kabupaten_kota')
        ->first();

    // Transform pagination results
    $podes->getCollection()->transform(function ($item) use ($kodepodes) {
        $podesArray = $item->toArray();
        $transformedData = [
            'NAMA PROVINSI' => $item->desaKelurahan->kecamatan->kabupatenKota->provinsi->nama_provinsi ?? null,
            'NAMA KABUPATEN' => $item->desaKelurahan->kecamatan->kabupatenKota->nama_kabupaten_kota ?? null,
            'NAMA KECAMATAN' => $item->desaKelurahan->kecamatan->nama_kecamatan ?? null,
            'NAMA DESA' => $item->desaKelurahan->nama_desa_kelurahan ?? null,
            'KODE DESA' => $item->kode_desa_kelurahan
        ];

        foreach ($kodepodes as $kode) {
            $columnName = $kode->{'COL 1'};
            if (isset($podesArray[$columnName])) {
                $transformedData[$kode->{'COL 2'}] = $podesArray[$columnName];
            }
        }

        return $transformedData;
    });

    return response()->json([
        'detail' => $podes,
        'summary' => $summary
    ]);
}
public function getAllPodesByProvinsi(Request $request)
{
    if (!$request->provinsi) {
        return response()->json([
            'message' => 'Kode provinsi is required'
        ], 400);
    }

    $kodepodes = KodePodes::all();

    // Get detailed podes data
    $podes = Podes::query()
        ->whereHas('desaKelurahan.kecamatan.kabupatenKota.provinsi', function ($query) use ($request) {
            $query->where('kode_provinsi', $request->provinsi);
        })
        ->paginate(10);

    // Get summary data
    $selectRaw = ['provinsi.kode_provinsi', 'provinsi.nama_provinsi'];
    foreach ($kodepodes as $kode) {
        $columnName = $kode->{'COL 1'};
        $selectRaw[] = DB::raw("SUM(podes.{$columnName}) as '{$kode->{'COL 2'} }'");
    }

    $summary = Podes::query()
        ->join('desa_kelurahan', 'podes.kode_desa_kelurahan', '=', 'desa_kelurahan.kode_desa_kelurahan')
        ->join('kecamatan', 'desa_kelurahan.kode_kecamatan', '=', 'kecamatan.kode_kecamatan')
        ->join('kabupaten_kota', 'kecamatan.kode_kabupaten_kota', '=', 'kabupaten_kota.kode_kabupaten_kota')
        ->join('provinsi', 'kabupaten_kota.kode_provinsi', '=', 'provinsi.kode_provinsi')
        ->where('provinsi.kode_provinsi', $request->provinsi)
        ->select($selectRaw)
        ->groupBy('provinsi.kode_provinsi', 'provinsi.nama_provinsi')
        ->first();

    // Transform pagination results
    $podes->getCollection()->transform(function ($item) use ($kodepodes) {
        $podesArray = $item->toArray();
        $transformedData = [
            'NAMA PROVINSI' => $item->desaKelurahan->kecamatan->kabupatenKota->provinsi->nama_provinsi ?? null,
            'NAMA KABUPATEN' => $item->desaKelurahan->kecamatan->kabupatenKota->nama_kabupaten_kota ?? null,
            'NAMA KECAMATAN' => $item->desaKelurahan->kecamatan->nama_kecamatan ?? null,
            'NAMA DESA' => $item->desaKelurahan->nama_desa_kelurahan ?? null,
            'KODE DESA' => $item->kode_desa_kelurahan
        ];

        foreach ($kodepodes as $kode) {
            $columnName = $kode->{'COL 1'};
            if (isset($podesArray[$columnName])) {
                $transformedData[$kode->{'COL 2'}] = $podesArray[$columnName];
            }
        }

        return $transformedData;
    });

    return response()->json([
        'detail' => $podes,
        'summary' => $summary
    ]);
}
}


