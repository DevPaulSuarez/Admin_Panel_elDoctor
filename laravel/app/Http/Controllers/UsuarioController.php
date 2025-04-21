<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use stdClass;

class UsuarioController extends Controller
{
    public function index()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(Usuario $id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function updateEstado(Request $request, $id)
    {
        $response = new stdClass();

        $usuario = Usuario::find($id);
        $usuario->estado = $request->estado;
        $usuario->save();

        $response->success = true;
        $response->data = $usuario;
        $response->error = [];
        return response()
            ->json($response);
    }

    public function storeAvatar(Request $request)
    {
        $imagen_url = Usuario::setAvatar($request->imagen);
        return $imagen_url;
    }

    public function destroy($id)
    {
    }

    public function login(Request $request)
    {
        $response = new stdClass();

        $usuario = Usuario::where('username', $request->email)->where('password', sha1(md5($request->password)))->first();

        if ($usuario) {
            session(['current_user' => $usuario]);

            $response->success = true;
            $response->data = null;
            $response->error = [];
            return response()
                ->json($response);
        }

        $response->success = false;
        $response->data = null;
        $response->error = ['Usuario o contraseña incorrectos'];
        return response()
            ->json($response);
    }

    public function logout(Request $request)
    {
        $response = new stdClass();

        $request->session()->forget('current_user');

        $response->success = true;
        $response->data = null;
        $response->error = [];
        return response()
            ->json($response);
    }
}
