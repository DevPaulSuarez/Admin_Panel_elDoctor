<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistente extends Model
{
    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function scopeMedicoId($query, $valor)
    {
        if($valor) {
            return $query->where('id_medico', $valor);
        }
        return $query;
    }

    public function medico() {
        return $this->belongsTo(Medico::class, 'id_medico', 'id')->select(['id','name', 'lastname']);
    }

    protected $table = 'asistentes';
}
