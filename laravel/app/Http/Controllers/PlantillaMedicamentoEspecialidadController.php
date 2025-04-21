<?php

namespace App\Http\Controllers;

use App\Models\PlantillaMedicamentoEspecialidad;
use App\Web\ResponseUtils;
use Illuminate\Http\Request;

class PlantillaMedicamentoEspecialidadController extends Controller
{
    public function index(Request $request)
    {
        $medicamento_id = $request->medicamento_id;
        $especialidad_id = $request->especialidad_id;
        $size = $request->size;

        $plantillas = PlantillaMedicamentoEspecialidad::medicamentoId($medicamento_id)
            ->especialidadId($especialidad_id)->with('medicamento')->limit($size)->get();

        return ResponseUtils::response($plantillas, 200);
    }

    public function store(Request $request)
    {
        $plantillas = PlantillaMedicamentoEspecialidad::where('especialidad_id', $request->especialidad_id)
            ->where('medicamento_id', $request->medicamento_id)
            ->where('presentacion', $request->presentacion)
            ->where('dosis', $request->dosis)
            ->where('frecuencia', $request->frecuencia)
            ->where('duracion_cantidad', $request->duracion_cantidad)
            ->where('duracion_unidad', $request->duracion_unidad)
            ->where('via', $request->via)
            ->get();

        if (count($plantillas)) {
            return ResponseUtils::response(null, 500, ['Ya existe una plantilla con los datos ingresados']);
        }

        $plantilla = new PlantillaMedicamentoEspecialidad();
        $plantilla->especialidad_id = $request->especialidad_id;
        $plantilla->medicamento_id = $request->medicamento_id;
        $plantilla->presentacion = $request->presentacion;
        $plantilla->dosis = $request->dosis;
        $plantilla->frecuencia = $request->frecuencia;
        $plantilla->duracion_cantidad = $request->duracion_cantidad;
        $plantilla->duracion_unidad = $request->duracion_unidad;
        $plantilla->via = $request->via;
        $plantilla->indicaciones = $request->indicaciones ?? null;
        $plantilla->save();

        return ResponseUtils::response($plantilla, 200);
    }

    public function update($id, Request $request)
    {
        $plantillas = PlantillaMedicamentoEspecialidad::where('especialidad_id', $request->especialidad_id)
            ->where('medicamento_id', $request->medicamento_id)
            ->where('presentacion', $request->presentacion)
            ->where('dosis', $request->dosis)
            ->where('frecuencia', $request->frecuencia)
            ->where('duracion_cantidad', $request->duracion_cantidad)
            ->where('duracion_unidad', $request->duracion_unidad)
            ->where('via', $request->via)
            ->get();

        if (count($plantillas)) {
            foreach ($plantillas as $plantilla) {
                if ($plantilla->id != $id) {
                    return ResponseUtils::response(null, 500, ['Ya existe una registro con los datos ingresados']);
                }
            }
        }

        $plantilla = PlantillaMedicamentoEspecialidad::find($id);

        if (!$plantilla) {
            return ResponseUtils::response(null, 404, ['No existe el registro con el id ' . $id]);
        }

        $plantilla->especialidad_id = $request->especialidad_id;
        $plantilla->medicamento_id = $request->medicamento_id;
        $plantilla->presentacion = $request->presentacion;
        $plantilla->dosis = $request->dosis;
        $plantilla->frecuencia = $request->frecuencia;
        $plantilla->duracion_cantidad = $request->duracion_cantidad;
        $plantilla->duracion_unidad = $request->duracion_unidad;
        $plantilla->via = $request->via;
        $plantilla->indicaciones = $request->indicaciones ?? null;
        $plantilla->save();

        return ResponseUtils::response($plantilla, 200);
    }

    public function show($id) {
        $plantilla = PlantillaMedicamentoEspecialidad::with('medicamento', 'especialidad')->find($id);

        if (!$plantilla) {
            return ResponseUtils::response(null, 404, ['No existe el registro con el id ' . $id]);
        }
        return ResponseUtils::response($plantilla, 200);
    }

    public function destroy($id)
    {
        $plantilla = PlantillaMedicamentoEspecialidad::find($id);

        if (!$plantilla) {
            return ResponseUtils::response(null, 404, ['No existe el registro con el id ' . $id]);
        }

        $plantilla->delete();

        return ResponseUtils::response($plantilla, 200);
    }
}
