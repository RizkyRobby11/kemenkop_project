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

    public function getKabupatenByProvinsi(Request $request)
    {
        if ($request->has("provinsi")) {
            $kabupaten = KabupatenKota::where("kode_provinsi", $request->provinsi)->get();
            return response()->json($kabupaten);
        }
    }

    public function getKecamatanByKabupaten(Request $request)
    {
        if ($request->has("kabupaten")) {
            $kecamatan = Kecamatan::where("kode_kabupaten_kota", $request->kabupaten)->get();
            return response()->json($kecamatan);
        }
    }
    public function getDesaKelurahanByKecamatan(Request $request)
    {
        if ($request->has("kecamatan")) {
            $desaKelurahan = DesaKelurahan::where("kode_kecamatan", $request->kecamatan)->get();
            return response()->json($desaKelurahan);
        }
    }

    public function getPodesByFilter(Request $request)
    {
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

        // modifikasi hasil paginasi
        $podes->getCollection()->transform(function ($item) {
            return collect($item->toArray())
                ->prepend($item->desaKelurahan->nama_desa_kelurahan ?? null, 'nama_desa_kelurahan')
                ->all();
        });

        return response()->json($podes);
    }
}
