<?php

namespace App\Service;
use App\Models\Podes;
use Illuminate\Support\Facades\DB;
use App\Models\KodePodes;

class PodesService
{
    protected $kodepodes;

    public function __construct()
    {
        $this->kodepodes = KodePodes::all();
    }
    // =====PODES QUERY=====
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
        } elseif ($length == 13) {
            // Kelurahan
            return $query = Podes::query()->whereHas('desaKelurahan', function ($q) use ($kodewilayah) {
                $q->where('kode_desa_kelurahan', $kodewilayah);
            });
        } else {
            // Default: return null or error
            return null;
        }
    }

    // =====PODES SUMMARY=====
    public function getPodesSummary($kodewilayah)
    {
        // Tentukan level berdasarkan panjang kode
        $length = strlen($kodewilayah);
        if ($length == 2) {
            // Provinsi
            $selectRaw = ['provinsi.kode_provinsi', 'provinsi.nama_provinsi'];
            $summaryQuery = Podes::query()->join('desa_kelurahan', 'podes.kode_desa_kelurahan', '=', 'desa_kelurahan.kode_desa_kelurahan')->join('kecamatan', 'desa_kelurahan.kode_kecamatan', '=', 'kecamatan.kode_kecamatan')->join('kabupaten_kota', 'kecamatan.kode_kabupaten_kota', '=', 'kabupaten_kota.kode_kabupaten_kota')->join('provinsi', 'kabupaten_kota.kode_provinsi', '=', 'provinsi.kode_provinsi')->where('provinsi.kode_provinsi', $kodewilayah);
            $groupBy = ['provinsi.kode_provinsi', 'provinsi.nama_provinsi'];
        } elseif ($length == 5) {
            // Kabupaten/Kota
            $selectRaw = ['kabupaten_kota.kode_kabupaten_kota', 'kabupaten_kota.nama_kabupaten_kota'];
            $summaryQuery = Podes::query()->join('desa_kelurahan', 'podes.kode_desa_kelurahan', '=', 'desa_kelurahan.kode_desa_kelurahan')->join('kecamatan', 'desa_kelurahan.kode_kecamatan', '=', 'kecamatan.kode_kecamatan')->join('kabupaten_kota', 'kecamatan.kode_kabupaten_kota', '=', 'kabupaten_kota.kode_kabupaten_kota')->where('kabupaten_kota.kode_kabupaten_kota', $kodewilayah);
            $groupBy = ['kabupaten_kota.kode_kabupaten_kota', 'kabupaten_kota.nama_kabupaten_kota'];
        } elseif ($length == 9) {
            // Kecamatan
            $selectRaw = ['kecamatan.kode_kecamatan', 'kecamatan.nama_kecamatan'];
            $summaryQuery = Podes::query()->join('desa_kelurahan', 'podes.kode_desa_kelurahan', '=', 'desa_kelurahan.kode_desa_kelurahan')->join('kecamatan', 'desa_kelurahan.kode_kecamatan', '=', 'kecamatan.kode_kecamatan')->where('kecamatan.kode_kecamatan', $kodewilayah);
            $groupBy = ['kecamatan.kode_kecamatan', 'kecamatan.nama_kecamatan'];
        } elseif ($length == 13) {
            // Kelurahan
            $selectRaw = ['desa_kelurahan.kode_desa_kelurahan', 'desa_kelurahan.kode_desa_kelurahan'];
            $summaryQuery = Podes::query()->join('desa_kelurahan', 'podes.kode_desa_kelurahan', '=', 'desa_kelurahan.kode_desa_kelurahan')->join('kecamatan', 'desa_kelurahan.kode_kecamatan', '=', 'kecamatan.kode_kecamatan')->where('kecamatan.kode_kecamatan', $kodewilayah);
            $groupBy = ['desa_kelurahan.kode_desa_kelurahan', 'desa_kelurahan.nama_desa_kelurahan'];
        } else {
            return null;
        }

        $summaryArray = [];
        foreach ($this->kodepodes as $kodep) {
            $columnName = $kodep->{'COL 1'};
            $selectRaw[] = DB::raw("SUM(podes.{$columnName}) as '{$kodep->{'COL 2'} }'");
        }

        $summary = $summaryQuery->select($selectRaw)->groupBy($groupBy)->first();
        $summary = array_slice($summary->toArray(), 2);

        if ($summary) {
            foreach ($summary as $key => $value) {
                $summaryArray[] = [
                    'nama' => $key,
                    'kode_podes' => $this->kodepodes->where('COL 2', $key)->first()->{'COL 1'},
                    'nilai' => $value
                ];
            }
        }

        return $summaryArray;
    }

    public function getPodesDetail($query)
    {
        $kodepodes = $this->kodepodes;

        $podes = $query->paginate(10);
        $podes->getCollection()->transform(function ($item) use ($kodepodes) {
            $podesArray = $item->toArray();
            $transformedData = [
                'NAMA PROVINSI' => $item->desaKelurahan->kecamatan->kabupatenKota->provinsi->nama_provinsi ?? null,
                'NAMA KABUPATEN' => $item->desaKelurahan->kecamatan->kabupatenKota->nama_kabupaten_kota ?? null,
                'NAMA KECAMATAN' => $item->desaKelurahan->kecamatan->nama_kecamatan ?? null,
                'NAMA DESA' => $item->desaKelurahan->nama_desa_kelurahan ?? null,
                'KODE DESA' => $item->kode_desa_kelurahan,
            ];
            foreach ($kodepodes as $kode) {
                $columnName = $kode->{'COL 1'};
                $desc = $kode->{'COL 2'};
                if (isset($podesArray[$columnName])) {
                    $transformedData['PODES'][] = [
                        'kode_podes' => $columnName,
                        'nama' => $desc,
                        'nilai' => $podesArray[$columnName],
                    ];
                }
            }
            return $transformedData;
        });
        return $podes;
    }

    public function getAllPodesProvinsi()
    {
        return cache()->remember('summary_podes_per_provinsi', 60 * 60, function () {
            $selectRaw = ['provinsi.kode_provinsi', 'provinsi.nama_provinsi'];
            $totalColumns = [];
            foreach ($this->kodepodes as $kodep) {
                $columnName = $kodep->{'COL 1'};
                $alias = $kodep->{'COL 2'};
                $selectRaw[] = DB::raw("SUM($columnName) as `$alias`");
                $totalColumns[] = $alias;
            }

            $result = Podes::query()->join('desa_kelurahan', 'podes.kode_desa_kelurahan', '=', 'desa_kelurahan.kode_desa_kelurahan')->join('kecamatan', 'desa_kelurahan.kode_kecamatan', '=', 'kecamatan.kode_kecamatan')->join('kabupaten_kota', 'kecamatan.kode_kabupaten_kota', '=', 'kabupaten_kota.kode_kabupaten_kota')->join('provinsi', 'kabupaten_kota.kode_provinsi', '=', 'provinsi.kode_provinsi')->select($selectRaw)->groupBy('provinsi.kode_provinsi', 'provinsi.nama_provinsi')->get();

            $result = $result->map(function ($item) use ($totalColumns) {
                $total = 0;
                foreach ($totalColumns as $col) {
                    $total += (int) $item->$col;
                }
                return [
                    'kode_provinsi' => $item->kode_provinsi,
                    'nama_provinsi' => $item->nama_provinsi,
                    'total_semua_podes' => $total,
                ];
            });

            return $result->values()->toArray();
        });
    }

    public function getPodesDetailByKodePodes($kodewilayah, $kodepodes)
    {
        // Tentukan level berdasarkan panjang kode
        $length = strlen($kodewilayah);
        if ($length == 2) {
            // Provinsi - Group by Kabupaten
            $selectRaw = ['kabupaten_kota.kode_kabupaten_kota', 'kabupaten_kota.nama_kabupaten_kota', 'provinsi.nama_provinsi'];
            $summaryQuery = Podes::query()->join('desa_kelurahan', 'podes.kode_desa_kelurahan', '=', 'desa_kelurahan.kode_desa_kelurahan')->join('kecamatan', 'desa_kelurahan.kode_kecamatan', '=', 'kecamatan.kode_kecamatan')->join('kabupaten_kota', 'kecamatan.kode_kabupaten_kota', '=', 'kabupaten_kota.kode_kabupaten_kota')->join('provinsi', 'kabupaten_kota.kode_provinsi', '=', 'provinsi.kode_provinsi')->where('provinsi.kode_provinsi', $kodewilayah);
            $groupBy = ['kabupaten_kota.kode_kabupaten_kota', 'kabupaten_kota.nama_kabupaten_kota', 'provinsi.nama_provinsi'];
        } elseif ($length == 5) {
            // Kabupaten/Kota - Group by Kecamatan
            $selectRaw = ['kecamatan.kode_kecamatan', 'kecamatan.nama_kecamatan', 'kabupaten_kota.kode_kabupaten_kota', 'kabupaten_kota.nama_kabupaten_kota'];
            $summaryQuery = Podes::query()->join('desa_kelurahan', 'podes.kode_desa_kelurahan', '=', 'desa_kelurahan.kode_desa_kelurahan')->join('kecamatan', 'desa_kelurahan.kode_kecamatan', '=', 'kecamatan.kode_kecamatan')->join('kabupaten_kota', 'kecamatan.kode_kabupaten_kota', '=', 'kabupaten_kota.kode_kabupaten_kota')->where('kabupaten_kota.kode_kabupaten_kota', $kodewilayah);
            $groupBy = ['kecamatan.kode_kecamatan', 'kecamatan.nama_kecamatan', 'kabupaten_kota.kode_kabupaten_kota', 'kabupaten_kota.nama_kabupaten_kota'];
        } elseif ($length == 9) {
            // Kecamatan - Group by Desa/Kelurahan
            $selectRaw = ['desa_kelurahan.kode_desa_kelurahan', 'desa_kelurahan.nama_desa_kelurahan', 'kecamatan.kode_kecamatan', 'kecamatan.nama_kecamatan'];
            $summaryQuery = Podes::query()->join('desa_kelurahan', 'podes.kode_desa_kelurahan', '=', 'desa_kelurahan.kode_desa_kelurahan')->join('kecamatan', 'desa_kelurahan.kode_kecamatan', '=', 'kecamatan.kode_kecamatan')->where('kecamatan.kode_kecamatan', $kodewilayah);
            $groupBy = ['desa_kelurahan.kode_desa_kelurahan', 'desa_kelurahan.nama_desa_kelurahan', 'kecamatan.kode_kecamatan', 'kecamatan.nama_kecamatan'];
        } elseif ($length == 13) {
            // Kelurahan - Detail level
            $selectRaw = ['desa_kelurahan.kode_desa_kelurahan', 'desa_kelurahan.nama_desa_kelurahan'];
            $summaryQuery = Podes::query()->join('desa_kelurahan', 'podes.kode_desa_kelurahan', '=', 'desa_kelurahan.kode_desa_kelurahan')->where('desa_kelurahan.kode_desa_kelurahan', $kodewilayah);
            $groupBy = ['desa_kelurahan.kode_desa_kelurahan', 'desa_kelurahan.nama_desa_kelurahan'];
        } else {
            return null;
        }

        // Get specific column name based on kodepodes
        $kodepodesItem = $this->kodepodes->where('COL 1', $kodepodes)->first();
        if ($kodepodesItem) {
            $columnName = $kodepodesItem->{'COL 1'};
            $alias = $kodepodesItem->{'COL 2'};
            $selectRaw[] = DB::raw("SUM(podes.{$columnName}) as '{$alias}'");
        }

        $results = $summaryQuery->select($selectRaw)->groupBy(...$groupBy)->get();

        return $results->map(function ($item) use ($kodepodes) {
            $result = $item->toArray();
            $result['kode_podes'] = $kodepodes; // Selalu isi dengan kodepodes yang di-request
            return $result;
        });
    }
}