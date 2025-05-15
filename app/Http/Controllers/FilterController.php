<?php

namespace App\Http\Controllers;

use App\Models\DesaKelurahan;
use App\Models\KabupatenKota;
use App\Models\Kecamatan;
use App\Models\KodePodes;
use App\Models\Podes;
use App\Models\Provinsi;
use Illuminate\Http\Request;

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
            'Industri' => [] // Tambahkan object industri
        ];

        // Add PODES data with descriptions into Industri object
        foreach ($kodepodes as $kode) {
            $columnName = $kode->{'COL 1'};
            if (isset($podesArray[$columnName])) {
                $transformedData['Industri'][] = [
                    'nama' => $kode->{'COL 2'},
                    'nilai' => $podesArray[$columnName]
                ];
            }
        }

        return $transformedData;
    });

    return response()->json($podes);
}
    public function getPodesBySearch(Request $request)
    {
        // Validasi input search
        if (empty($request->search)) {
            return response()->json(['data' => [], 'total' => 0]);
        }

        // Gunakan query builder yang lebih efisien
        $searchTerm = '%' . strtolower($request->search) . '%';

        $podes = Podes::query()
            ->select('podes.*')
            ->join('desa_kelurahan', 'podes.kode_desa_kelurahan', '=', 'desa_kelurahan.kode_desa_kelurahan')
            ->join('kecamatan', 'desa_kelurahan.kode_kecamatan', '=', 'kecamatan.kode_kecamatan')
            ->join('kabupaten_kota', 'kecamatan.kode_kabupaten_kota', '=', 'kabupaten_kota.kode_kabupaten_kota')
            ->join('provinsi', 'kabupaten_kota.kode_provinsi', '=', 'provinsi.kode_provinsi')
            ->where(function ($query) use ($searchTerm) {
                $query->whereRaw('LOWER(desa_kelurahan.nama_desa_kelurahan) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(kecamatan.nama_kecamatan) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(kabupaten_kota.nama_kabupaten_kota) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(provinsi.nama_provinsi) LIKE ?', [$searchTerm]);
            })
            ->paginate($request->per_page ?? 10);

        // Transform data dengan cara yang lebih efisien
        $podes->getCollection()->transform(function ($item) {
            // Get base podes data
            $podesData = $item->toArray();

            // Create new array with ordered columns
            $orderedData = [
                'nama_provinsi' => $item->desaKelurahan->kecamatan->kabupatenKota->provinsi->nama_provinsi ?? null,
                'nama_kabupaten_kota' => $item->desaKelurahan->kecamatan->kabupatenKota->nama_kabupaten_kota ?? null,
                'nama_kecamatan' => $item->desaKelurahan->kecamatan->nama_kecamatan ?? null,
                'nama_desa_kelurahan' => $item->desaKelurahan->nama_desa_kelurahan ?? null,
            ];

            // Merge ordered location data with podes data
            return array_merge($orderedData, $podesData);
        });

        return response()->json($podes);
    }


}
