<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public function scopeIdReservacion($query, $valor)
    {
        if($valor) {
            return $query->where('id_reservacion', $valor);
        }
        return $query;
    }

    public function scopeIdPaciente($query, $valor)
    {
        if($valor) {
            return $query->where('id_paciente', $valor);
        }
        return $query;
    }

    public function scopeMayorFecha($query, $valor)
    {
        if($valor) {
            return $query->where('fecha', '>=', $valor);
        }
        return $query;
    }

    public function scopeMenorFecha($query, $valor)
    {
        if($valor) {
            return $query->where('fecha', '<=', $valor);
        }
        return $query;
    }

    public function ordenTipo() {
        return $this->belongsTo(OrdenTipo::class, 'id_orden_tipo', 'id')->select(['id','nombre']);
    }

    public function medico() {
        return $this->belongsTo(Medico::class, 'id_medico', 'id')->select(['id','lastname','name', 'imagen_firma', 'medic_profile_id']);
    }

    public function diagnostico() {
        return $this->belongsTo(Cie10::class, 'id_diagnostico', 'id')->select(['id','codigo','nombre']);
    }

    protected $table = 'ordenes';
}
