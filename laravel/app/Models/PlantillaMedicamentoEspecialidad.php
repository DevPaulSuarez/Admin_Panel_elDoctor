<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantillaMedicamentoEspecialidad extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    public function scopeMedicamentoId($query, $valor)
    {
        if($valor) {
            return $query->where('medicamento_id', $valor);
        }
        return $query;
    }

    public function scopeEspecialidadId($query, $valor)
    {
        if($valor) {
            return $query->where('especialidad_id', $valor);
        }
        return $query;
    }

    public function medicamento() {
        return $this->belongsTo(Medicamento::class, 'medicamento_id', 'id');
    }

    public function especialidad() {
        return $this->belongsTo(Especialidad::class, 'especialidad_id', 'id');
    }

    protected $table = 'plantillas_medicamentos_especialidades';
}
