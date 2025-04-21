<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    public function scopeSearch($query, $valor)
    {
        if($valor) {
            return $query->where('name', 'LIKE','%'.$valor.'%');
        }
        return $query;
    }

    protected $table = 'category';
}
