<?php

namespace App\Http\Controllers;

use App\Models\Clinica;
use Illuminate\Http\Request;
use stdClass;

class ClinicaController extends Controller
{
    public function index() {
        $response = new stdClass();

        $clinicas = Clinica::all();

        $response->success = true;
        $response->data = $clinicas;
        $response->error = [];
        return response()
            ->json($response);
    }

    public function showLogin() {
        return view('login');
    }

    public function login(Request $request)
    {
        $clinica = Clinica::where('email', $request->email)->where('password', sha1(md5($request->password)))->get();
        if (count($clinica) > 0) {
            session(['current_user' => $clinica[0]]);
            return redirect()->intended('/');
        } else {
            return back()->withInput()->withErrors(['Usuario o contraseña incorrectos']);
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('current_user');
        return redirect()->intended('/');
    }
}
