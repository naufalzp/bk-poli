<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPeriksa extends Model
{
    protected $guarded = ['id'];

    public function getFullJadwalAttribute()
    {
        return $this->hari . ', ' . $this->jam_mulai . '-' . $this->jam_selesai;
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'id_dokter');
    }

    public function janjiPeriksas()
    {
        return $this->hasMany(JanjiPeriksa::class, 'id_jadwal_periksa');
    }
}
