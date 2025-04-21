<?php

namespace App\Http\Controllers;

use App\Models\Asistente;
use App\Web\ResponseUtils;
use Illuminate\Http\Request;

class AsistenteController extends Controller
{
    public function findAll(Request $request)
    {
        $search = $request->search;
        $medico_id = $request->medico_id;
        $size = $request->size;

        $asistentes = Asistente::with('medico')->medicoId($medico_id)->limit($size)->get();

        return ResponseUtils::response($asistentes, 200);
    }

    public function save(Request $request)
    {
        $asistente = new Asistente();
        $asistente->dni = $request->dni;
        $asistente->apellidos = $request->apellidos;
        $asistente->nombres = $request->nombres;
        $asistente->celular_codigo_pais = $request->celular_codigo_pais;
        $asistente->celular = $request->celular;
        $asistente->password = sha1(md5($request->password));
        $asistente->email = $request->email;
        $asistente->id_medico = $request->id_medico;
        $asistente->is_active = true;
        $asistente->save();

        return ResponseUtils::response($asistente, 200);
    }

    public function update($id, Request $request)
    {
        $asistente = Asistente::find($id);

        if (!$asistente) {
            return ResponseUtils::response(null, 404, ['No existe el registro con el id ' . $id]);
        }

        $asistente->dni = $request->dni ?? $asistente->dni;
        $asistente->apellidos = $request->apellidos ?? $asistente->apellidos;
        $asistente->nombres = $request->nombres ?? $asistente->nombres;
        $asistente->celular_codigo_pais = $request->celular_codigo_pais ?? $asistente->celular_codigo_pais;
        $asistente->celular = $request->celular ?? $asistente->celular;
        $asistente->password = sha1(md5($request->password)) ?? $asistente->password;
        $asistente->email = $request->email ?? $asistente->email;
        $asistente->id_medico = $request->id_medico ?? $asistente->id_medico;
        $asistente->save();

        return ResponseUtils::response($asistente, 200);
    }

    public function findById($id) {
        $asistente = Asistente::with('medico')->find($id);

        if (!$asistente) {
            return ResponseUtils::response(null, 404, ['No existe el registro con el id ' . $id]);
        }
        return ResponseUtils::response($asistente, 200);
    }

    public function delete($id)
    {
        $asistente = Asistente::find($id);

        if (!$asistente) {
            return ResponseUtils::response(null, 404, ['No existe el registro con el id ' . $id]);
        }

        $asistente->delete();

        return ResponseUtils::response($asistente, 200);
    }
}
