<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use Illuminate\Http\Request;
use stdClass;

class EspecialidadController extends Controller
{
    public function index(Request $request)
    {
        $response = new stdClass();

        $search = $request->search;

        $especialidades = Especialidad::search($search)->orderBy('name')->get();

        $response->success = true;
        $response->data = $especialidades;
        $response->error = [];
        return response()
            ->json($response);
    }

    public function store(Request $request)
    {
        $response = new stdClass();

        $especialidad = new Especialidad();
        $especialidad->name = $request->nombre;
        $especialidad->save();

        $response->success = true;
        $response->data = $especialidad;
        $response->error = [];
        return response()
            ->json($response);
    }

    public function show($id)
    {
        $response = new stdClass();

        $especialidad = Especialidad::find($id);

        $response->success = true;
        $response->data = $especialidad;
        $response->error = [];
        return response()
            ->json($response);
    }


    public function update(Request $request, $id)
    {
        $response = new stdClass();

        $especialidad = Especialidad::find($id);
        $especialidad->name = $request->nombre;
        $especialidad->save();

        $response->success = true;
        $response->data = $especialidad;
        $response->error = [];
        return response()
            ->json($response);
    }

    public function destroy($id)
    {
        $response = new stdClass();

        $especialidad = Especialidad::find($id);
        $especialidad->delete();

        $response->success = true;
        $response->data = $especialidad;
        $response->error = [];
        return response()
            ->json($response);
    }
}
