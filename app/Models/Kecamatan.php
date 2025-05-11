<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';


    public function kabupatenKota()
    {
        return $this->belongsTo(KabupatenKota::class, 'kode_kabupaten_kota', 'kode_kabupaten_kota');
    }
}
