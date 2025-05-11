<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Podes extends Model
{
    protected $table = 'podes';

    public function desaKelurahan()
    {
        return $this->belongsTo(DesaKelurahan::class, 'kode_kelurahan', 'kode_desa_kelurahan');
    }


}
