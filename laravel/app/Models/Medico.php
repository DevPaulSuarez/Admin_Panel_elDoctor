<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Medico extends Model
{
    protected $hidden = ['password', 'created_at', 'updated_at'];

    protected $table = 'medic';

    public function scopeIdMedico($query, $valor)
    {
        if($valor) {
            return $query->where('id', $valor);
        }
        return $query;
    }

    public function scopeSearch($query, $valor)
    {
        if($valor) {
            return $query->where(DB::raw("CONCAT(lastname, ' ', name)"), 'LIKE', "%$valor%");
        }
        return $query;
    }

    public function scopeNumeroDocumento($query, $valor)
    {
        if($valor) {
            return $query->where('numero_documento', 'LIKE', "%$valor%");
        }
        return $query;
    }
}
