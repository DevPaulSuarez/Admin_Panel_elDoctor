<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Especialidad;
use App\Models\Medico;
use App\Models\MedicoEspecialidad;
use App\Models\PerfilMedico;
use Illuminate\Http\Request;
use stdClass;

class MedicoController extends Controller
{
    public function index(Request $request)
    {
        $response = new stdClass();

        $id_medico = $request->id_medico;
        $search = $request->search;
        $numero_documento = $request->numero_documento;

        $medicosCategorias = [];
        $medicos = Medico::select('medic.id', 'numero_documento', 'name', 'lastname', 'address', 'email', 'phone', 'medic.is_active', 'medic.medic_profile_id')
            ->search($search)
            ->idMedico($id_medico)
            ->numeroDocumento($numero_documento)
            ->orderBy('lastname')->get();

        foreach ($medicos as $medico) {
            $categorias = Especialidad::select('category.id', 'category.name')
                ->join('medicos_especialidades', 'medicos_especialidades.especialidad_id', '=', 'category.id')
                ->join('medic', 'medicos_especialidades.medico_id', '=', 'medic.id')
                ->where('medic.id', $medico->id)
                ->orderBy('category.name', 'asc')->get();

            $datos = new stdClass();
            $datos = $medico;
            $datos->especialidades = $categorias;

            array_push($medicosCategorias, $datos);
        }

        $response->success = true;
        $response->data = $medicosCategorias;
        $response->error = [];
        return response()
            ->json($response);
    }

    public function store(Request $request)
    {
        $response = new stdClass();

        $medico = Medico::where('numero_documento', $request->dni)->first();

        if ($medico) {
            $response->success = false;
            $response->data = null;
            $response->error = ['YA EXISTE EL MEDICO'];
            return response()
                ->json($response);
        } else {
            $url_image_server = asset('image_medic/img-staff-avatar.png');

            $perfilMedico = new PerfilMedico();
            $perfilMedico->cmp = '';
            $perfilMedico->rne = '';
            $perfilMedico->save();

            $medico = new Medico;
            $medico->tipo_documento = $request->tipo_documento;
            $medico->numero_documento = $request->numero_documento;
            $medico->name = $request->apellidos;
            $medico->lastname = $request->nombres;
            $medico->email = $request->email;
            $medico->celular_codigo_pais = $request->celular_codigo_pais;
            $medico->phone = str_replace(' ', '', $request->celular);
            $medico->image = $url_image_server;
            $medico->password = $request->password;
            $medico->medic_profile_id = $perfilMedico->id;
            $medico->save();

            $especialidades = $request->especialidades;
            foreach ($especialidades as $especialidad) {
                $medicoEspecialidad = new MedicoEspecialidad();
                $medicoEspecialidad->medico_id = $medico->id;
                $medicoEspecialidad->especialidad_id = (int) $especialidad;
                $medicoEspecialidad->save();
            }

            $response->success = true;
            $response->data = null;
            $response->error = [];
            return response()
                ->json($response);
        }
    }

    public function create()
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }
        $departamentos = Departamento::orderBy('departamento')->get();
        return view('medico.create')->with('departamentos', $departamentos);
    }

    public function update($id, Request $request)
    {
        $response = new stdClass();

        $medico = Medico::find($id);
        $medico->tipo_documento = $request->tipo_documento;
        $medico->numero_documento = $request->numero_documento;
        $medico->name = mb_strtoupper($request->nombres);
        $medico->lastname = mb_strtoupper($request->apellidos);
        $medico->email = $request->email;
        $medico->password = $request->password ?? $medico->password;
        $medico->celular_codigo_pais = $request->celular_codigo_pais;
        $medico->phone = str_replace(' ', '', $request->celular);
        $medico->save();


        $medicoEspecialidades = MedicoEspecialidad::where('medico_id', $medico->id)->get();
        $especialidades = $request->especialidades;

        foreach ($especialidades as $especialidad) {
            $existe = false;
            foreach ($medicoEspecialidades as $medicoEspecialidad) {
                if ($especialidad == $medicoEspecialidad->especialidad_id) {
                    $existe = true;
                    break;
                }
            }
            if (!$existe) {
                $medicoEspecialidad = new MedicoEspecialidad;
                $medicoEspecialidad->medico_id = $medico->id;
                $medicoEspecialidad->especialidad_id = (int) $especialidad;
                $medicoEspecialidad->save();
            }
        }

        foreach ($medicoEspecialidades as $medicoEspecialidad) {
            $existe = false;
            foreach ($especialidades as $especialidad) {
                if ($medicoEspecialidad->especialidad_id == $especialidad) {
                    $existe = true;
                    break;
                }
            }
            if (!$existe) {
                $medicoEspecialidad->delete();
            }
        }

        $response->success = true;
        $response->data = null;
        $response->error = [];
        return response()
            ->json($response);
    }

    public function show($id)
    {
        $response = new stdClass();

        $medico = Medico::find($id);

        $especialidades = Especialidad::select('category.id', 'category.name')
            ->join('medicos_especialidades', 'medicos_especialidades.especialidad_id', '=', 'category.id')
            ->join('medic', 'medicos_especialidades.medico_id', '=', 'medic.id')
            ->where('medic.id', $medico->id)
            // ->groupBy('name')
            ->orderBy('category.name', 'asc')->get();
        $medico->especialidades = $especialidades;

        $response->success = true;
        $response->data = $medico;
        $response->error = [];
        return response()
            ->json($response);
    }

    public function destroy($id)
    {
        $response = new stdClass();

        $medico = Medico::find($id);

        PerfilMedico::find($medico->medic_profile_id)->delete();

        MedicoEspecialidad::where('medico_id', $medico->id)->delete();

        $medico->delete();

        $response->success = true;
        $response->data = null;
        $response->error = [];
        return response()
            ->json($response);
    }

    public function getEspecialidad($id_especialidad)
    {
        $response = new stdClass();

        $medicosCategorias = [];

        $medicos = Medico::select('medic.id', 'medic.name', 'medic.lastname')
            ->join('medicos_especialidades', 'medicos_especialidades.medico_id', '=', 'medic.id')
            ->where('medic.is_active', 1)
            ->where('medicos_especialidades.especialidad_id', $id_especialidad)
            ->groupBy('medic.id')
            ->orderBy('lastname')
            ->get();

        foreach ($medicos as $medico) {
            $categorias = Especialidad::select('category.id', 'category.name')
                ->join('medicos_especialidades', 'medicos_especialidades.especialidad_id', '=', 'category.id')
                ->join('medic', 'medicos_especialidades.medico_id', '=', 'medic.id')
                ->where('medic.id', $medico->id)
                ->groupBy('category.id')
                ->orderBy('category.name', 'asc')
                ->get();

            $datos = new stdClass();
            $datos = $medico;
            $datos->especialidades = $categorias;

            array_push($medicosCategorias, $datos);
        }

        $response->success = true;
        $response->data = $medicosCategorias;
        $response->error = [];
        return response()
            ->json($response);
    }

    public function showEditperfil($id)
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }
        $perfilMedico = PerfilMedico::find($id);
        return view('medico.edit-perfil')->with('perfilMedico', $perfilMedico);
    }

    public function putPerfil($id, Request $request)
    {
        $perfilMedico = PerfilMedico::find($id);
        $perfilMedico->cmp = $request->cmp;
        $perfilMedico->rne = $request->rne;
        $perfilMedico->save();

        return redirect('medicos');
    }

    public function updateActive(Request $request, $id)
    {
        $response = new stdClass();

        $medico = Medico::find($id);
        $medico->is_active = $request->is_active;
        $medico->save();

        $response->success = true;
        $response->data = $medico;
        $response->error = [];
        return response()
            ->json($response);
    }

    public function getByDni($dni)
    {
        $medico = Medico::where('numero_documento', $dni)->first();

        if ($medico) {
            $especialidades = Especialidad::select('category.id', 'category.name')
                ->join('medicos_especialidades', 'medicos_especialidades.especialidad_id', '=', 'category.id')
                ->join('medic', 'medicos_especialidades.medico_id', '=', 'medic.id')
                ->where('medic.id', $medico->id)
                ->groupBy('name')
                ->orderBy('name', 'asc')->get();
            $medico->especialidades = $especialidades;
        }

        return $medico;
    }
}
