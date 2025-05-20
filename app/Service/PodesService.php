<?php

namespace App\Service;
use App\Models\Podes;
use Illuminate\Support\Facades\DB;
use App\Models\KodePodes;

class PodesService
{
        public function getPodesQuery($kodewilayah)
{
// Tentukan level berdasarkan panjang kode
$length = strlen($kodewilayah);
    if ($length == 2) {
        // Provinsi
        return $query = Podes::query()->whereHas('desaKelurahan.kecamatan.kabupatenKota.provinsi', function ($q) use ($kodewilayah) {
            $q->where('kode_provinsi', $kodewilayah);
        });
    } elseif ($length == 5) {
        // Kabupaten/Kota
        return $query = Podes::query()->whereHas('desaKelurahan.kecamatan.kabupatenKota', function ($q) use ($kodewilayah) {
            $q->where('kode_kabupaten_kota', $kodewilayah);
        });
    } elseif ($length == 9) {
        // Kecamatan
        return $query = Podes::query()->whereHas('desaKelurahan.kecamatan', function ($q) use ($kodewilayah) {
            $q->where('kode_kecamatan', $kodewilayah);
        });
    } else {
        // Default: return null or error
        return null;
    }
}

// =====PODES SUMMARY=====
public function getPodesSummary($kodewilayah)
{
$kodepodes = KodePodes::all();

    // Tentukan level berdasarkan panjang kode
    $length = strlen($kodewilayah);
    if ($length == 2) {
        // Provinsi
        $selectRaw = ['provinsi.kode_provinsi', 'provinsi.nama_provinsi'];
        $summaryQuery = Podes::query()
            ->join('desa_kelurahan', 'podes.kode_desa_kelurahan', '=', 'desa_kelurahan.kode_desa_kelurahan')
            ->join('kecamatan', 'desa_kelurahan.kode_kecamatan', '=', 'kecamatan.kode_kecamatan')
            ->join('kabupaten_kota', 'kecamatan.kode_kabupaten_kota', '=', 'kabupaten_kota.kode_kabupaten_kota')
            ->join('provinsi', 'kabupaten_kota.kode_provinsi', '=', 'provinsi.kode_provinsi')
            ->where('provinsi.kode_provinsi', $kodewilayah);
        $groupBy = ['provinsi.kode_provinsi', 'provinsi.nama_provinsi'];
    } elseif ($length == 5) {
        // Kabupaten/Kota
        $selectRaw = ['kabupaten_kota.kode_kabupaten_kota', 'kabupaten_kota.nama_kabupaten_kota'];
        $summaryQuery = Podes::query()
            ->join('desa_kelurahan', 'podes.kode_desa_kelurahan', '=', 'desa_kelurahan.kode_desa_kelurahan')
            ->join('kecamatan', 'desa_kelurahan.kode_kecamatan', '=', 'kecamatan.kode_kecamatan')
            ->join('kabupaten_kota', 'kecamatan.kode_kabupaten_kota', '=', 'kabupaten_kota.kode_kabupaten_kota')
            ->where('kabupaten_kota.kode_kabupaten_kota', $kodewilayah);
        $groupBy = ['kabupaten_kota.kode_kabupaten_kota', 'kabupaten_kota.nama_kabupaten_kota'];
    } elseif ($length == 9) {
        // Kecamatan
        $selectRaw = ['kecamatan.kode_kecamatan', 'kecamatan.nama_kecamatan'];
        $summaryQuery = Podes::query()
            ->join('desa_kelurahan', 'podes.kode_desa_kelurahan', '=', 'desa_kelurahan.kode_desa_kelurahan')
            ->join('kecamatan', 'desa_kelurahan.kode_kecamatan', '=', 'kecamatan.kode_kecamatan')
            ->where('kecamatan.kode_kecamatan', $kodewilayah);
        $groupBy = ['kecamatan.kode_kecamatan', 'kecamatan.nama_kecamatan'];
    } else {
        // Default: return null or error
        return null;
    }

    foreach ($kodepodes as $kodep) {
        $columnName = $kodep->{'COL 1'};
        $selectRaw[] = DB::raw("SUM(podes.{$columnName}) as '{$kodep->{'COL 2'} }'");
    }

    return $summaryQuery->select($selectRaw)->groupBy(...$groupBy)->first();
}

// =====PODES QUERY=====
public function getPodesDetail($query)
    {
    $kodepodes = KodePodes::all();

        $podes = $query->paginate(10);
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
        return $podes;
    }
}

