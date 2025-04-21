<?php

namespace App\Http\Controllers;

use App\Exports\CitaExport;
use App\Mail\EditMessageReceived;
use App\Mail\MessageReceived;
use App\Models\Conversacion;
use App\Models\Departamento;
use App\Models\Especialidad;
use App\Models\Estado;
use App\Models\EstadoPago;
use App\Models\LugarAtencion;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\Pago;
use App\Models\Reservacion;
use App\Models\Solicitud;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;

class CitaController extends Controller
{
    public function index(Request $request)
    {
        $fecha_inicio = $request->fecha_inicio;
        $fecha_mayor = $request->fecha_mayor;
        $estado = $request->estado;
        $paciente_id = $request->paciente_id;

        $citas = Reservacion::select('reservation.id', 'reservation.medio_atencion', 'reservation.descripcion_tipo_consulta', 'reservation.tipo_paciente', 'reservation.tipo_atencion', 'reservation.date_at', 'reservation.time_at', DB::raw("CONCAT(pacientes.apellidos, ' ', pacientes.nombres) AS paciente"), DB::raw("UPPER(CONCAT(medic.lastname, ' ', medic.name)) AS medico"),  'reservation.registrador_nombre',  'reservation.tipo_usuario', 'reservation.created_at AS fecha_creacion', 'reservation.motivo_reprogramacion')
            // ->join('medicos_clinica', 'reservation.medic_id', '=', 'medicos_clinica.medico_id')
            ->join('pacientes', 'reservation.pacient_id', '=', 'pacientes.id')
            ->join('medic', 'reservation.medic_id', '=', 'medic.id')
            // ->where('medicos_clinica.clinica_id', session('current_user')->id)
            ->fechaMenor($fecha_inicio)
            ->fechaMayor($fecha_mayor)
            ->pacienteId($paciente_id)
            ->whereIn('estado',  explode (',', $estado))
            ->orderBy(DB::raw("CONCAT(reservation.date_at, ' ', reservation.time_at)"), 'desc')->get();
        return $citas;
    }

    public function store(Request $request)
    {
        $is_web = false;
        $request->lugar != 1 ? $is_web = false : $is_web = true;
        $reservacion = Reservacion::where('medic_id', $request->medic_id)
            ->where('date_at', $request->date_at)
            ->where('time_at', $request->time_at . ':00')
            ->get();

        if (count($reservacion) == 0) {
            $paciente = Paciente::find($request->pacient_id);
            $medico =  Medico::find($request->medic_id);
            $especialidad = Especialidad::find($request->especialidad_id);

            $pago = new Pago;
            $pago->costoreal = $request->price;
            $pago->email = $paciente->email;
            $pago->id_user = $paciente->user_id;
            $pago->montopagado = $request->price;
            $pago->idproducto = $medico->idproducto;
            $pago->creation_date = date("Y-m-d H:i:s");
            $pago->descripcion = 'Pago Consulta Medica';
            $pago->save();

            $conversacion = new Conversacion;
            $conversacion->sender_id = $medico->id;
            $conversacion->receptor_id = $paciente->id;
            $conversacion->save();

            $solicitud                  = new Solicitud;
            $solicitud->title           = $request->title;
            $solicitud->user_id         = $paciente->user_id;
            $solicitud->payment_id      = 1;
            $solicitud->status_id       = 1;
            $solicitud->conversation_id = $conversacion->id;
            $solicitud->created_at      = date("Y-m-d H:i:s");
            $solicitud->primeracita     = 0;
            $solicitud->citatarjeta     = 0;
            $solicitud->save();

            $reservacion             = new Reservacion;
            $reservacion->title      = $request->title;
            $reservacion->note       = $request->note;
            $reservacion->medic_id   = $medico->id;
            $reservacion->date_at    = $request->date_at;
            $reservacion->time_at    = $request->time_at . ':00';
            $reservacion->idlugar    = $request->lugar;
            $reservacion->especialidad_id = $request->especialidad_id;
            $reservacion->pacient_id = $paciente->id;
            $reservacion->user_id    = $paciente->user_id;
            $reservacion->tipo_usuario      = $request->tipo_usuario ?? null;
            $reservacion->registrador_id      = $request->registrador_id ?? null;
            $reservacion->registrador_nombre      = $request->registrador_nombre ?? null;
            $reservacion->price      = $request->price;
            $reservacion->is_web  = $is_web;
            // $reservacion->clinica_id  = session('current_user')->id;
            $reservacion->status_id  = 1;
            $reservacion->payment_id = 2;
            $reservacion->conversation_id = $conversacion->id;
            $reservacion->save();

            $emailData = new stdClass;
            $emailData->paciente_nombre = $paciente->name . " " . $paciente->lastname;
            $emailData->modalidad = 'Virtual';
            $emailData->medico_nombre = $medico->name . " " . $medico->lastname;
            $emailData->especialidad = $especialidad->name;
            $emailData->fecha = date("d/m/Y", strtotime($request->date_at));
            $emailData->hora = date("g:i A", strtotime($request->time_at . ':00'));
            $emailData->monto = 'S/. ' . $request->price;

            Mail::to($paciente->email)->queue(new MessageReceived($emailData, 'client'));
            Mail::to($medico->email)->queue(new MessageReceived($emailData, 'doctor'));
            $client = new Client;
            $client->request('POST', 'https://whatsappapi.syslacs.com/api/v1/messages', [
                'json' => [
                    'from' => '51964707021',
                    'to' => '51' . $paciente->phone,
                    'type' => 'text',
                    'body' => 'Registro Exitoso, MODALIDAD: Virtual, ESPECIALIDAD: ' . $especialidad->name . ', MÉDICO: ' . $medico->name . ' ' . $medico->lastname . ', FECHA: ' . date('d/m/Y', strtotime($request->date_at)) . ', HORA: ' . date('g:i A', strtotime($request->time_at . ':00')) . ' EL INGRESO A LA SALA SERÁ A LA HORA DE SU CITA. Ingrese a la plataforma https://doctorenlinea.com.pe/ e inicie sesión, Atte. Doctor en línea.'
                ]
            ]);
            $client->request('POST', 'https://whatsappapi.syslacs.com/api/v1/messages', [
                'json' => [
                    'from' => '51964707021',
                    'to' => '51' . $medico->phone,
                    'type' => 'text',
                    'body' => 'Registro Exitoso, MODALIDAD: Virtual, PACIENTE: ' . $paciente->name . ' ' . $paciente->lastname . ', FECHA: ' . date('d/m/Y', strtotime($request->date_at)) . ', HORA: ' . date('g:i A', strtotime($request->time_at . '00')) . ' EL INGRESO A LA SALA SERÁ A LA HORA DE SU CITA. Ingrese a la plataforma https://medico.doctorenlinea.com.pe/ e inicie sesión, Atte. Doctor en línea.'
                ]
            ]);
            return redirect('citas');
        } else {
            return back()->withInput()->withErrors(['Ya existe un paciente registrado en ese horario con el médico']);
        }
    }

    public function create()
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }
        $departamentos = Departamento::select('ubdepartamento.idDepa', 'ubdepartamento.departamento')
            ->join('lugaratencion', 'lugaratencion.iddepartamento', '=', 'ubdepartamento.idDepa')
            ->groupBy('ubdepartamento.idDepa')
            ->orderBy('ubdepartamento.idDepa')->get();

        $pacientes = Paciente::select('pacient.id', 'name', 'lastname', 'address', 'email', 'phone')
            ->join('pacientes_clinica', 'pacientes_clinica.paciente_id', '=', 'pacient.id')
            ->where('pacientes_clinica.clinica_id', session('current_user')->id)
            ->orderBy('lastname')->get();

        $medicos = Medico::select('medic.id', 'name', 'lastname', 'address', 'email', 'phone', 'medic.is_active', 'medic.medic_profile_id')
            ->join('medicos_clinica', 'medicos_clinica.medico_id', '=', 'medic.id')
            ->where('medicos_clinica.clinica_id', session('current_user')->id)
            ->orderBy('lastname')->get();

        $estados = Estado::orderBy('name')->get();

        return view('cita.create')->with('departamentos', $departamentos)
            ->with('pacientes', $pacientes)
            ->with('medicos', $medicos)
            ->with('estados', $estados);
    }

    public function update($id, Request $request)
    {
        $time_at = null;
        strlen($request->time_at) == 5 ? $time_at = $request->time_at . ':00' : $time_at = $request->time_at;
        $reservaciones = Reservacion::where('medic_id', $request->medic_id)
            ->where('date_at', $request->date_at)
            ->where('time_at', $time_at)
            ->get();

        if (count($reservaciones) == 0) {
            $reservacion = Reservacion::find($id);
            $paciente = Paciente::find($request->pacient_id);
            $medico =  Medico::find($request->medic_id);
            $especialidad = Especialidad::find($request->especialidad_id);
            $lugarAtencion = LugarAtencion::find($reservacion->idlugar);

            $reservacion->date_at    = $request->date_at;
            $reservacion->time_at    = $time_at;
            $reservacion->status_id  = $request->status_id;
            $reservacion->save();

            if ($request->status_id == 1) {
                $emailData = new stdClass;
                $emailData->paciente_nombre = $paciente->name . " " . $paciente->lastname;
                $emailData->modalidad = $lugarAtencion->lugar;
                $emailData->medico_nombre = $medico->name . " " . $medico->lastname;
                $emailData->especialidad = $especialidad->name;
                $emailData->fecha = date("d/m/Y", strtotime($request->date_at));
                $emailData->hora = date("g:i A", strtotime($time_at));

                Mail::to($paciente->email)->queue(new EditMessageReceived($emailData, 'client'));
                Mail::to($medico->email)->queue(new EditMessageReceived($emailData, 'doctor'));
                $client = new Client;
                $client->request('POST', 'https://whatsappapi.syslacs.com/api/v1/messages', [
                    'json' => [
                        'from' => '51964707021',
                        'to' => '51' . $paciente->phone,
                        'type' => 'text',
                        'body' => 'Horario Actualizado Exitoso, MODALIDAD: Virtual, ESPECIALIDAD: ' . $especialidad->name . ', MÉDICO: ' . $medico->name . ' ' . $medico->lastname . ', FECHA: ' . date('d/m/Y', strtotime($request->date_at)) . ', HORA: ' . date('g:i A', strtotime($request->time_at . ':00')) . ' EL INGRESO A LA SALA SERÁ A LA HORA DE SU CITA. Ingrese a la plataforma https://doctorenlinea.com.pe/ e inicie sesión, Atte. Doctor en línea.'
                    ]
                ]);
                $client->request('POST', 'https://whatsappapi.syslacs.com/api/v1/messages', [
                    'json' => [
                        'from' => '51964707021',
                        'to' => '51' . $medico->phone,
                        'type' => 'text',
                        'body' => 'Horario Actualizado Exitoso, MODALIDAD: Virtual, PACIENTE: ' . $paciente->name . ' ' . $paciente->lastname . ', FECHA: ' . date('d/m/Y', strtotime($request->date_at)) . ', HORA: ' . date('g:i A', strtotime($request->time_at . '00')) . ' EL INGRESO A LA SALA SERÁ A LA HORA DE SU CITA. Ingrese a la plataforma https://medico.doctorenlinea.com.pe/ e inicie sesión, Atte. Doctor en línea.'
                    ]
                ]);
            }
            return redirect('citas');
        } else {
            return back()->withInput()->withErrors(['Ya existe un paciente registrado en ese horario con el médico']);
        }
    }

    public function destroy($id)
    {
        return $id;
    }

    public function show()
    {
    }

    public function edit($id)
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }
        $reservacion =  Reservacion::find($id);

        $pacientes = Paciente::select('pacient.id', 'name', 'lastname', 'address', 'email', 'phone')
            ->join('pacientes_clinica', 'pacientes_clinica.paciente_id', '=', 'pacient.id')
            ->where('pacientes_clinica.clinica_id', session('current_user')->id)
            ->orderBy('lastname')->get();

        $medicos = Medico::select('medic.id', 'name', 'lastname', 'address', 'email', 'phone', 'medic.is_active', 'medic.medic_profile_id')
            ->join('medicos_clinica', 'medicos_clinica.medico_id', '=', 'medic.id')
            ->where('medicos_clinica.clinica_id', session('current_user')->id)
            ->orderBy('lastname')->get();

        $estados = Estado::orderBy('name')->get();
        $estadosPago = EstadoPago::orderBy('name')->get();

        return view('cita.edit')
            ->with('reservacion', $reservacion)
            ->with('pacientes', $pacientes)
            ->with('medicos', $medicos)
            ->with('estados', $estados)
            ->with('estadosPago', $estadosPago);
    }

    public function getMonitoreoPacienteId($paciente_id)
    {
        $reservaciones = Reservacion::select('reservation.id', 'reservation.medic_id', 'reservation.especialidad_id', 'date_at', 'time_at', DB::raw("UPPER (CONCAT(medic.lastname, ' ', medic.name)) AS medico"))
            ->join('medic', 'reservation.medic_id', '=', 'medic.id')
            ->where('pacient_id', $paciente_id)
            ->where('tipo_cita', 'MONITOREO')
            ->where('clinica_id', session('current_user')->id)
            ->where('date_at', '>=', DB::raw('curdate()'))
            ->get();

        $data = [];

        foreach ($reservaciones as $reservacion) {
            $NuevoHEEvento = new stdClass();
            $NuevoHEEvento->id = $reservacion->id;
            $NuevoHEEvento->medic_id = $reservacion->medic_id;
            $NuevoHEEvento->especialidad_id = $reservacion->especialidad_id;
            $NuevoHEEvento->title = $reservacion->medico;
            $NuevoHEEvento->start = $reservacion->date_at . 'T' . $reservacion->time_at;
            $NuevoHEEvento->end = $reservacion->date_at . 'T' . date('H:i:s', strtotime($reservacion->time_at) + 900);
            $NuevoHEEvento->color = 'rgb(255, 194, 0)';
            array_push($data, $NuevoHEEvento);
        }

        return $data;
    }
}
