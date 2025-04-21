<?php

namespace App\Http\Controllers;

use App\Mail\NuevaCuentaReceived;
use App\Models\ArchivoPaciente;
use App\Models\MiPago;
use App\Models\MonitoreoPaciente;
use App\Models\Paciente;
use App\Models\PacienteMedico;
use App\Models\PacientePerfil;
use App\Models\Perfil;
use App\Models\Telemonitoreo;
use App\Models\TokenMail;
use App\Models\UsuarioPaciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use stdClass;

class PacienteController extends Controller
{
    public function index(Request $request)
    {
        $response = new stdClass();

        $id_paciente = $request->id_paciente;
        $search = $request->search;
        $numero_documento = $request->numero_documento;

        $pacientes = Paciente::select('id', 'numero_documento','apellidos', 'nombres', 'email', 'celular')
            ->idPaciente($id_paciente)
            ->search($search)
            ->numeroDocumento($numero_documento)
            ->orderBy('apellidos')->get();

        $response->success = true;
        $response->data = $pacientes;
        $response->error = [];
        return response()
            ->json($response);
    }

    public function store(Request $request)
    {
        $response = new stdClass();

        $paciente = Paciente::where('numero_documento', $request->numero_documento)->first();

        if ($paciente) {
            $response->success = false;
            $response->data = null;
            $response->error = ['YA EXISTE EL PACIENTE'];
            return response()
                ->json($response);
        } else {
            $str = "abcdefghijklmopqrstuvwxyz1234567890";
            $code = "";
            for ($i = 0; $i < 6; $i++) {
                $code .= $str[rand(0, strlen($str) - 1)];
            }

            $pacientePerfil = new PacientePerfil();
            $pacientePerfil->save();

            $paciente = new Paciente();
            $paciente->nombres = $request->nombres;
            $paciente->apellidos = $request->apellidos;
            $paciente->email = $request->email;
            $paciente->password = sha1(md5($code));
            $paciente->code = $code;
            $paciente->celular_codigo_pais = $request->celular_codigo_pais;
            $paciente->celular = $request->celular;
            $paciente->numero_documento = $request->numero_documento;
            $paciente->tipo_documento = $request->tipo_documento;
            $paciente->is_active = 1;
            $paciente->id_paciente_perfil = $pacientePerfil->id;
            $paciente->save();

            $tokenMail = new TokenMail;
            $tokenMail->usuario_id = $paciente->id;
            $tokenMail->token = $code;
            $tokenMail->estado = 1;
            $tokenMail->save();

            $paciente->id_token = $tokenMail->id;
            $paciente->save();

            Mail::to(mb_strtolower($request->email))->queue(new NuevaCuentaReceived($paciente, $code));

            $response->success = true;
            $response->data = $paciente;
            $response->error = [];
            return response()
                ->json($response);
        }
    }

    public function update($id, Request $request)
    {
        $response = new stdClass();

        $paciente = Paciente::find($id);
        $paciente->nombres = $request->nombres;
        $paciente->apellidos = $request->apellidos;
        $paciente->email = $request->email;
        $paciente->celular = $request->celular;
        $paciente->celular_codigo_pais = $request->celular_codigo_pais;
        $paciente->save();

        $response->success = true;
        $response->data = $paciente;
        $response->error = [];
        return response()
            ->json($response);
    }

    public function show($id) {
        $response = new stdClass();

        $paciente = Paciente::find($id);

        $response->success = true;
        $response->data = $paciente;
        $response->error = [];
        return response()
            ->json($response);
    }

    public function destroy($id)
    {
        $response = new stdClass();

        $paciente = Paciente::find($id);

        PacientePerfil::where('id', $paciente->id_paciente_perfil)->delete();

        TokenMail::where('usuario_id', $paciente->id)->delete();

        ArchivoPaciente::where('paciente_id', $paciente->id)->delete();

        ArchivoPaciente::where('paciente_id', $paciente->id)->delete();
        MiPago::where('paciente_id', $paciente->id)->delete();
        MonitoreoPaciente::where('paciente_id', $paciente->id)->delete();
        PacienteMedico::where('id_paciente', $paciente->id)->delete();
        Telemonitoreo::where('id_paciente', $paciente->id)->delete();


        $paciente->delete();

        $response->success = true;
        $response->data = null;
        $response->error = [];
        return response()
            ->json($response);
    }

    public function getByDni($dni)
    {
        $paciente = Paciente::select('id', 'apellidos', 'nombres', 'email', 'celular', 'numero_documento')
            ->where('numero_documento', $dni)->get();
        return $paciente;
    }
}
