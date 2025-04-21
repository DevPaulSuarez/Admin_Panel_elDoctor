<?php

namespace App\Http\Controllers;

use App\Models\Provincia;

class ProvinciaController extends Controller
{
    public function getProvinciasDepartamentoId($departamento_id) {
        $provincias = Provincia::where('idDepa', $departamento_id)->get();
        return $provincias;
    }

    public function getProvinciasByLugarAtencion($departamento_id) {
        $provincias = Provincia::select('ubprovincia.idProv','ubprovincia.provincia')
        ->join('lugaratencion', 'lugaratencion.idprovincia', '=', 'ubprovincia.idProv')
        ->where('lugaratencion.iddepartamento', $departamento_id)
        ->groupBy('ubprovincia.idProv')
        ->orderBy('ubprovincia.idProv')->get();
        return $provincias;
    }
}
