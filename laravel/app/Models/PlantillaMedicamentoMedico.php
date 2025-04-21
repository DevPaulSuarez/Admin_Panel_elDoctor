<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantillaMedicamentoMedico extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    public function scopeMedicamentoId($query, $valor)
    {
        if($valor) {
            return $query->where('medicamento_id', $valor);
        }
        return $query;
    }

    public function scopeMedicoId($query, $valor)
    {
        if($valor) {
            return $query->where('medico_id', $valor);
        }
        return $query;
    }

    public function medicamento() {
        return $this->belongsTo(Medicamento::class, 'medicamento_id', 'id');
    }

    public function medico() {
        return $this->belongsTo(Medico::class, 'medico_id', 'id');
    }

    protected $table = 'plantillas_medicamentos_medicos';
}
