<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use App\Web\ResponseUtils;
use Illuminate\Http\Request;

class MedicamentoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $size = $request->size;

        $medicamentos = Medicamento::search($search)->orderBy('nombre_generico')->limit($size)->get();

        return ResponseUtils::response($medicamentos, 200);
    }

    public function store(Request $request)
    {
        $medicamentos = Medicamento::where('nombre_comercial', $request->nombre_comercial)
            ->where('nombre_generico', $request->nombre_generico)
            ->get();

        if (count($medicamentos)) {
            return ResponseUtils::response(null, 500, ['Ya existe un medicamento con los datos ingresados']);
        }

        $medicamento = new Medicamento();
        $medicamento->nombre_generico = $request->nombre_generico;
        $medicamento->nombre_comercial = $request->nombre_comercial;
        $medicamento->save();

        return ResponseUtils::response($medicamento, 200);
    }

    public function update($id, Request $request)
    {
        $medicamentos = Medicamento::where('nombre_comercial', $request->nombre_comercial)
            ->where('nombre_generico', $request->nombre_generico)
            ->get();

        if (count($medicamentos)) {
            foreach ($medicamentos as $medicamento) {
                if ($medicamento->id != $id) {
                    return ResponseUtils::response(null, 500, ['Ya existe un registro con los datos ingresados']);
                }
            }
        }

        $medicamento = Medicamento::find($id);

        if (!$medicamento) {
            return ResponseUtils::response(null, 404, ['No existe el registro con el id ' . $id]);
        }

        $medicamento->nombre_generico = $request->nombre_generico;
        $medicamento->nombre_comercial = $request->nombre_comercial;
        $medicamento->save();

        return ResponseUtils::response($medicamento, 200);
    }

    public function show($id) {
        $medicamento = Medicamento::find($id);

        if (!$medicamento) {
            return ResponseUtils::response(null, 404, ['No existe el registro con el id ' . $id]);
        }
        return ResponseUtils::response($medicamento, 200);
    }

    public function destroy($id)
    {
        $medicamento = Medicamento::find($id);

        if (!$medicamento) {
            return ResponseUtils::response(null, 404, ['No existe el registro con el id ' . $id]);
        }

        $medicamento->delete();

        return ResponseUtils::response($medicamento, 200);
    }
}
