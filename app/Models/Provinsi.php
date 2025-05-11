<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
protected $table = 'provinsi';


    public function kabupaten()
    {
return $this->hasMany(KabupatenKota::class, 'kode_provinsi', 'kode_provinsi');
    }

    public function kecamatan()
    {
return $this->hasManyThrough(Kecamatan::class, KabupatenKota::class, 'kode_provinsi','kode_kabupaten_kota','kode_provinsi','kode_kabupaten_kota');
    }

    public function desaKelurahan()
    {
    return $this->hasManyThrough(DesaKelurahan::class, Kecamatan::class, 'kode_provinsi', 'kode_kecamatan', 'kode_provinsi', 'kode_kecamatan');
    }

    public function podes()
    {
    return $this->hasManyThrough(Podes::class, DesaKelurahan::class, 'kode_provinsi','kode_desa_kelurahan', 'kode_provinsi','kode_desa_kelurahan');
    }

}
