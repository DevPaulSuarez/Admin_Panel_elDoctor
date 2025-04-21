<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    public function scopeSearch($query, $valor)
    {
        if($valor) {
            $query->where('nombre_generico', 'LIKE', "%$valor%");
            $query->orWhere('nombre_comercial', 'LIKE', "%$valor%");
        }
        return $query;
    }

    protected $table = 'medicamentos';
}
