<?php

namespace App\Http\Controllers;

use App\Models\Departamento;

class DepartamentoController extends Controller
{
    public function getByLugarAtencion() {
        $departamentos = Departamento::select('ubdepartamento.idDepa','ubdepartamento.departamento')
        ->join('lugaratencion', 'lugaratencion.iddepartamento', '=', 'ubdepartamento.idDepa')
        ->groupBy('ubdepartamento.idDepa')
        ->orderBy('ubdepartamento.idDepa')->get();
        return $departamentos;
    }
}
