<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $guarded = ['id'];

    public function detailPeriksas()
    {
        return $this->hasMany(DetailPeriksa::class, 'id_obat');
    }

    public function periksas()
    {
        return $this->belongsToMany(Periksa::class, 'detail_periksas', 'id_obat', 'id_periksa');
    }
}
