<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservacion extends Model
{
    public function scopeFechaMenor($query, $valor)
    {
        if($valor)
            return $query->where('date_at', '>=', $valor);
    }

    public function scopeFechaMayor($query, $valor)
    {
        if($valor)
            return $query->where('date_at', '<=', $valor);
    }

    public function scopePacienteId($query, $valor)
    {
        if($valor)
            return $query->where('pacient_id', $valor);
    }

    protected $table = 'reservation';
}
