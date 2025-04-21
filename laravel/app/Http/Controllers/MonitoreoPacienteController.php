<?php

namespace App\Http\Controllers;

use App\Exports\MonitoreoPacienteExport;
use App\Mail\MessageReceived;
use App\Models\Conversacion;
use App\Models\Especialidad;
use App\Models\Medico;
use App\Models\MonitoreoPaciente;
use App\Models\MonitoreoPacienteMedico;
use App\Models\Paciente;
use App\Models\Reservacion;
use App\Models\Solicitud;
use App\Models\Telemonitoreo;
use App\Models\Triaje;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;

class MonitoreoPacienteController extends Controller
{
    public function index()
    {
        $response = new stdClass();

        $monitoreosPacienteMedico = [];

        $monitoreosPaciente = Telemonitoreo::select('telemonitoreos.id', 'telemonitoreos.id_paciente', 'telemonitoreos.id_medico', 'telemonitoreos.fecha_fin', DB::raw("CONCAT(pacientes.apellidos, ' ', pacientes.nombres) AS paciente"), DB::raw("CONCAT(medic.lastname, ' ', medic.name) AS medico"), DB::raw("GROUP_CONCAT(reservaciones_telemonitoreo.id_reservacion) AS id_reservaciones"))
            ->join('pacientes', 'pacientes.id', '=', 'telemonitoreos.id_paciente')
            ->join('medic', 'medic.id', '=', 'telemonitoreos.id_medico')
            ->join('reservaciones_telemonitoreo', 'reservaciones_telemonitoreo.id_telemonitoreo', '=', 'telemonitoreos.id')
            // ->where('telemonitoreos.fecha_fin', '>=', DB::raw("CURDATE()"))
            ->groupBy('reservaciones_telemonitoreo.id_telemonitoreo')
            ->orderBy('telemonitoreos.fecha_fin', 'DESC')->get();

        foreach ($monitoreosPaciente as $monitoreoPaciente) {
            $reservaciones = [];
            $id_reservaciones = explode(',', $monitoreoPaciente->id_reservaciones);
            foreach ($id_reservaciones as $id_reservacion) {
                $reservaciones[] = Reservacion::find($id_reservacion);
            }

            $datos = new stdClass();
            $datos = $monitoreoPaciente;
            $datos->reservaciones = $reservaciones;

            $monitoreosPacienteMedico[] = $datos;
        }

        $response->success = true;
        $response->data = $monitoreosPacienteMedico;
        $response->error = [];
        return response()
            ->json($response);
    }

    public function store(Request $request)
    {
        $fechasArray = explode(',', $request->fechas);
        $monitoreoPaciente = new MonitoreoPaciente;
        $monitoreoPaciente->clinica_id = session('current_user')->id;
        $monitoreoPaciente->paciente_id = $request->paciente_id;
        $monitoreoPaciente->especialidad_id = $request->especialidad_id;
        $monitoreoPaciente->fechas = $request->fechas;
        $monitoreoPaciente->fecha_inicio = $fechasArray[0];
        $monitoreoPaciente->fecha_fin = end($fechasArray);
        $monitoreoPaciente->citas_dia = $request->citas_dia;
        $monitoreoPaciente->save();

        if ($request->medicos_id != null) {
            $medicos = $request->medicos_id;
            foreach ($medicos as $medico) {
                $monitoreoPacienteMedico = new  MonitoreoPacienteMedico;
                $monitoreoPacienteMedico->monitoreos_paciente_id = $monitoreoPaciente->id;
                $monitoreoPacienteMedico->medico_id = $medico;
                $monitoreoPacienteMedico->save();
            }
        }
        return redirect('monitoreos-paciente');
    }

    public function create()
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }
        $pacientes = Paciente::select('pacientes.id', 'nombres', 'apellidos', 'email', 'celular')
            ->join('pacientes_clinica', 'pacientes_clinica.paciente_id', '=', 'pacient.id')
            ->where('pacientes_clinica.clinica_id', session('current_user')->id)
            ->where('pacientes_clinica.estado', true)
            ->orderBy('lastname')->get();

        $categorias = Especialidad::orderBy('name')->get();

        $medicos = Medico::select('medic.id', 'name', 'lastname', 'email', 'phone', 'medic.is_active', 'medic.medic_profile_id')
            ->join('medicos_clinica', 'medicos_clinica.medico_id', '=', 'medic.id')
            ->where('medicos_clinica.clinica_id', session('current_user')->id)
            ->orderBy('lastname')->get();

        return view('monitoreo-paciente.create')
            ->with('pacientes', $pacientes)
            ->with('medicos', $medicos)
            ->with('categorias', $categorias);
    }

    public function update($id, Request $request)
    {
        $fechasArray = explode(',', $request->fechas);
        $monitoreoPaciente = MonitoreoPaciente::find($id);
        $monitoreoPaciente->paciente_id = $request->paciente_id;
        $monitoreoPaciente->especialidad_id = $request->especialidad_id;
        $monitoreoPaciente->fechas = $request->fechas;
        $monitoreoPaciente->fecha_inicio = $fechasArray[0];
        $monitoreoPaciente->fecha_fin = end($fechasArray);
        $monitoreoPaciente->citas_dia = $request->citas_dia;
        $monitoreoPaciente->save();

        $monitoreosPacienteMedico = MonitoreoPacienteMedico::where('monitoreos_paciente_id', $id)->get();
        if ($request->medicos_id != null) {
            $medicos = $request->medicos_id;
            foreach ($medicos as $medico) {
                $existe = false;
                foreach ($monitoreosPacienteMedico as $monitoreoPacienteMedico) {
                    if ($medico == $monitoreoPacienteMedico->medico_id) {
                        $existe = true;
                        break;
                    }
                }

                if (!$existe) {
                    $monitoreoPacienteMedico = new  MonitoreoPacienteMedico;
                    $monitoreoPacienteMedico->monitoreos_paciente_id = $monitoreoPaciente->id;
                    $monitoreoPacienteMedico->medico_id = $medico;
                    $monitoreoPacienteMedico->save();
                }
            }

            foreach ($monitoreosPacienteMedico as $monitoreoPacienteMedico) {
                $existe = false;
                foreach ($medicos as $medico) {
                    if ($monitoreoPacienteMedico->medico_id == $medico) {
                        $existe = true;
                        break;
                    }
                }
                if (!$existe) {
                    $monitoreoPacienteMedico->delete();
                }
            }
        }
        return redirect('monitoreos-paciente');
    }

    public function destroy($id)
    {
        $monitoreoPaciente = MonitoreoPaciente::find($id);
        foreach (explode(',', $monitoreoPaciente->fechas) as $fecha) {
            $reservaciones = Reservacion::where('date_at', $fecha)->where('pacient_id', $monitoreoPaciente->paciente_id)->where('tipo_cita', 'MONITOREO')->get();
            foreach ($reservaciones as $reservacion) {
                Conversacion::find($reservacion->conversation_id)->delete();
                Solicitud::where('conversation_id', $reservacion->conversation_id)->delete();
                Triaje::where('reservacion_id', $reservacion->id)->delete();
                $reservacion->delete();
            }
        }
        $monitoreoPaciente->delete();
        MonitoreoPacienteMedico::where('monitoreos_paciente_id', $id)->delete();
        return $monitoreoPaciente;
    }

    public function edit($id)
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }
        $monitoreoPaciente = MonitoreoPaciente::find($id);

        $monitoreoPacienteMedico = MonitoreoPacienteMedico::select('medic.id', DB::raw("UPPER (CONCAT(medic.lastname, ' ', medic.name)) AS nombre"))
            ->join('medic', 'monitoreos_paciente_medico.medico_id', '=', 'medic.id')
            ->where('monitoreos_paciente_medico.monitoreos_paciente_id', $monitoreoPaciente->id)
            ->orderBy('nombre')->get();
        $monitoreoPaciente->medicos = $monitoreoPacienteMedico;

        $medicos = Medico::select('medic.id', 'medic.name', 'medic.lastname')
            ->join('medicos_especialidades', 'medicos_especialidades.medico_id', '=', 'medic.id')
            ->join('medicos_clinica', 'medicos_clinica.medico_id', '=', 'medic.id')
            ->where('medic.is_active', 1)
            ->where('medicos_clinica.clinica_id', session('current_user')->id)
            ->where('medicos_especialidades.especialidad_id', $monitoreoPaciente->especialidad_id)
            ->groupBy('medic.id')
            ->orderBy('lastname')->get();

        $pacientes = Paciente::select('pacientes.id', 'nombres', 'apellidos', 'email', 'celular')
            ->join('pacientes_clinica', 'pacientes_clinica.paciente_id', '=', 'pacient.id')
            ->where('pacientes_clinica.clinica_id', session('current_user')->id)
            ->where('pacientes_clinica.estado', true)
            ->orderBy('apellidos')->get();

        $categorias = Especialidad::orderBy('name')->get();
        return view('monitoreo-paciente.edit')
            ->with('pacientes', $pacientes)
            ->with('medicos', $medicos)
            ->with('categorias', $categorias)
            ->with('monitoreoPaciente', $monitoreoPaciente);
    }

    public function showProgramar($id)
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }
        $monitoreoPaciente = MonitoreoPaciente::select('monitoreos_paciente.id', 'monitoreos_paciente.especialidad_id', 'pacient.id as paciente_id', DB::raw("CONCAT(pacientes.apellidos, ' ', pacientes.nombres) AS paciente"), 'fecha_inicio', 'fecha_fin', 'citas_dia', 'fechas')
            ->join('pacientes', 'pacientes.id', '=', 'monitoreos_paciente.paciente_id')
            ->where('clinica_id', session('current_user')->id)
            ->where('monitoreos_paciente.id', $id)
            ->orderBy('paciente')->get();

        $monitoreoPacienteMedico = MonitoreoPacienteMedico::select('medic.id', DB::raw("UPPER (CONCAT(medic.lastname, ' ', medic.name)) AS medico"))
            ->join('medic', 'monitoreos_paciente_medico.medico_id', '=', 'medic.id')
            ->where('monitoreos_paciente_medico.monitoreos_paciente_id', $monitoreoPaciente[0]->id)
            ->orderBy('medico')->get();

        $datos = new stdClass();
        $datos = $monitoreoPaciente[0];
        $datos->medicos = $monitoreoPacienteMedico;
        return view('monitoreo-paciente.programar')
            ->with('datos', $datos);
    }

    public function postProgramar(Request $request)
    {
        $paciente = Paciente::find($request->paciente_id);
        $medico =  Medico::find($request->medico_id);
        $categoria = Especialidad::find($request->especialidad_id);

        $conversacion = new Conversacion;
        $conversacion->sender_id = $medico->id;
        $conversacion->receptor_id = $paciente->id;
        $conversacion->save();

        $solicitud                  = new Solicitud;
        $solicitud->title           = 'RESERVAR CITA DE MONITOREO';
        $solicitud->user_id         = $paciente->user_id;
        $solicitud->payment_id      = 1;
        $solicitud->status_id       = 1;
        $solicitud->conversation_id = $conversacion->id;
        $solicitud->created_at      = date("Y-m-d H:i:s");
        $solicitud->primeracita     = 0;
        $solicitud->citatarjeta     = 0;
        $solicitud->save();

        $reservacion = new Reservacion;
        $reservacion->title = 'RESERVAR CITA DE MONITOREO';
        $reservacion->note = 'RESERVAR CITA DE MONITOREO';
        $reservacion->medic_id = $medico->id;
        $reservacion->date_at = $request->fecha_cita;
        $reservacion->time_at = $request->hora_inicio;
        $reservacion->idlugar = 1;
        $reservacion->especialidad_id = $request->especialidad_id;
        $reservacion->pacient_id = $paciente->id;
        $reservacion->user_id = $paciente->user_id;
        $reservacion->price = 0;
        $reservacion->tipo_cita = 'MONITOREO';
        // $reservacion->clinica_id  = session('current_user')->id;
        $reservacion->status_id  = 1;
        $reservacion->payment_id = 2;
        $reservacion->conversation_id = $conversacion->id;
        $reservacion->save();

        $emailData = new stdClass();
        $emailData->paciente_nombre = $paciente->apellidos . ' ' . $paciente->nombres;
        $emailData->medico_nombre = $medico->lastname . ' ' . $medico->name;
        $emailData->especialidad = $categoria->name;
        $emailData->fecha = date("d/m/Y", strtotime($request->fecha_cita));
        $emailData->hora = date("g:i A", strtotime($request->hora_inicio));
        $emailData->monto = 'S/. 0';

        Mail::to($paciente->email)->queue(new MessageReceived($emailData, 'client'));
        Mail::to($medico->email)->queue(new MessageReceived($emailData, 'doctor'));
        $client = new Client();
        $client->request('POST', 'https://whatsappapi.syslacs.com/api/v1/messages', [
            'json' => [
                'from' => '51964707021',
                'to' => '51' . $paciente->phone,
                'type' => 'text',
                'body' => 'Registro Exitoso, MODALIDAD: MONITOREO, ESPECIALIDAD: ' . $categoria->name . ', MÉDICO: ' . $medico->lastname . ' ' . $medico->name . ', FECHA: ' . date('d/m/Y', strtotime($request->fecha_cita)) . ', HORA: ' . date('g:i A', strtotime($request->hora_inicio)) . ' EL INGRESO A LA SALA SERÁ A LA HORA DE SU CITA. Ingrese a la plataforma https://doctorenlinea.com.pe/ e inicie sesión, Atte. Doctor en línea.'
            ]
        ]);
        $client->request('POST', 'https://whatsappapi.syslacs.com/api/v1/messages', [
            'json' => [
                'from' => '51964707021',
                'to' => '51' . $medico->phone,
                'type' => 'text',
                'body' => 'Registro Exitoso, MODALIDAD: MONITOREO, PACIENTE: ' . $paciente->lastname . ' ' . $paciente->name . ', FECHA: ' . date('d/m/Y', strtotime($request->fecha_cita)) . ', HORA: ' . date('g:i A', strtotime($request->hora_inicio)) . ' EL INGRESO A LA SALA SERÁ A LA HORA DE SU CITA. Ingrese a la plataforma https://medico.doctorenlinea.com.pe/ e inicie sesión, Atte. Doctor en línea.'
            ]
        ]);

        return $reservacion;
    }

    public function putProgramar($id, Request $request)
    {

        $reservacion = Reservacion::find($id);
        $reservacion->medic_id = $request->medico_id;
        $reservacion->time_at = $request->hora_inicio;
        $reservacion->save();

        $conversacion = Conversacion::find($reservacion->conversation_id);
        $conversacion->sender_id = $request->medico_id;
        $conversacion->save();

        return $reservacion;
    }

    public function deleteProgramar($id)
    {
        $reservacion = Reservacion::find($id);
        Conversacion::find($reservacion->conversation_id)->delete();
        Solicitud::where('conversation_id', $reservacion->conversation_id)->delete();
        $reservacion->delete();
        return $reservacion;
    }

    public function export()
    {
        return Excel::download(new MonitoreoPacienteExport, 'monitoreo-paciente-' . date('YmdHis') . '.xlsx');
    }
}
