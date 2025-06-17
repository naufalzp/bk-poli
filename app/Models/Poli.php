<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    protected $guarded = ['id'];

    public function dokters() 
    {
        $this->hasMany(User::class, 'id_poli');
    }
}
