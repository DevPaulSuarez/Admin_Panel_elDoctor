<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use App\Models\Medico;
use App\Models\Orden;
use App\Models\Paciente;
use App\Models\Receta;
use App\Models\Reservacion;
use Illuminate\Support\Facades\DB;
use stdClass;

class ViewController extends Controller
{
    public function viewEspecialidadCreate()
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }

        return view('especialidad.create');
    }

    public function viewEspecialidad()
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }

        return view('especialidad.index');
    }

    public function showBlog()
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }

        return view('blog.index');
    }

    public function viewEncuesta()
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }

        return view('encuesta.index');
    }

    public function showHome()
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }

        return view('home.index');
    }

    public function showHorarioMedico()
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }

        return view('horario-medico.index');
    }

    public function viewMedico()
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }

        return view('medico.index');
    }

    public function viewMedicoCreate()
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }

        return view('medico.create');
    }

    public function viewMedicoEdit()
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }

        return view('medico.edit');
    }

    public function viewMedicoHistorial($id)
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }

        $medico = Medico::find($id);

        $reservaciones = Reservacion::select('reservation.id', 'medio_atencion', DB::raw("CONCAT(pacientes.apellidos, ' ', pacientes.nombres) AS paciente"), DB::raw("CONCAT(medic.lastname, ' ', medic.name) AS medico"), 'reservation.date_at', 'reservation.time_at','conversation.time_video_connected', 'conversation.times_video_connected', 'conversation.sender_time_connected', 'conversation.sender_times_connected', 'conversation.receptor_time_connected', 'conversation.receptor_times_connected')
            ->join('pacientes', 'pacientes.id', '=', 'reservation.pacient_id')
            ->join('medic', 'medic.id', '=', 'reservation.medic_id')
            ->join('conversation', 'conversation.id', "=", "reservation.conversation_id")
            ->where('medic_id', $id)
            ->orderBy(DB::raw("CONCAT(date_at, ' ', time_at)"), 'DESC')->get();
        $newReservaciones = [];
        foreach ($reservaciones as $reservacion) {
            $documentos = new stdClass();
            $documentos->ordenes = Orden::where('id_reservacion', $reservacion->id)->count();
            $documentos->recetas = Receta::where('id_reservacion', $reservacion->id)->count();

            $data = new stdClass();
            $data->medio_atencion = $reservacion->medio_atencion;
            $data->paciente = $reservacion->paciente;
            $data->medico = $reservacion->medico;
            $data->date_at = $reservacion->date_at;
            $data->time_at = $reservacion->time_at;
            $data->time_video_connected = $reservacion->time_video_connected;
            $data->times_video_connected = $reservacion->times_video_connected;
            $data->sender_time_connected = $reservacion->sender_time_connected;
            $data->sender_times_connected = $reservacion->sender_times_connected;
            $data->receptor_time_connected = $reservacion->receptor_time_connected;
            $data->receptor_times_connected = $reservacion->receptor_times_connected;
            $data->documentos = $documentos;


            $newReservaciones[] = $data;
        }
        return view('medico.historial')->with('medico', $medico)->with('reservaciones', $newReservaciones);
    }

    public function viewPaciente()
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }

        return view('paciente.index');
    }

    public function viewPacienteCreate()
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }

        return view('paciente.create');
    }

    public function viewCita()
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }

        return view('cita.index');
    }

    public function viewCitaCreate()
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }

        return view('cita.create');
    }

    public function viewPacienteEdit()
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }

        return view('paciente.edit');
    }

    public function viewPacienteHistorial($id)
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }

        $paciente = Paciente::find($id);

        $reservaciones = Reservacion::select('title', DB::raw("CONCAT(pacientes.apellidos, ' ', pacientes.nombres) AS paciente"), DB::raw("CONCAT(medic.lastname, ' ', medic.name) AS medico"), 'reservation.date_at', 'reservation.time_at')
            ->join('pacientes', 'pacientes.id', '=', 'reservation.pacient_id')
            ->join('medic', 'medic.id', '=', 'reservation.medic_id')
            ->where('pacient_id', $id)
            ->orderBy('date_at')->get();
        return view('paciente.historial')->with('paciente', $paciente)->with('reservaciones', $reservaciones);
    }


    public function viewClinica()
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }

        return view('clinica.index');
    }
    public function viewClinicaCreate()
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }

        return view('clinica.create');
    }
    public function viewClinicaEdit()
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }

        return view('clinica.edit');
    }


    public function showLogin()
    {
        return view('usuario.login');
    }

    public function viewMonitoreoPaciente()
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }

        return view('monitoreo-paciente.index');
    }

    public function viewMonitoreoPacienteCreate()
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }

        return view('monitoreo-paciente.create');
    }

    public function viewMonitoreoPacienteProgramar()
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }

        return view('monitoreo-paciente.programar');
    }

    public function viewPlantillaMedicamentoEspecialidad() {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }

        return view('plantilla.medicamento-especialidad.index');
    }

    public function viewPlantillaMedicamentoEspecialidadCreate($id) {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }

        return view('plantilla.medicamento-especialidad.create')->with('id', $id);
    }

    public function viewPlantillaMedicamentoMedico() {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }

        return view('plantilla.medicamento-medico.index');
    }

    public function viewPlantillaMedicamentoMedicoCreate($id) {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }

        return view('plantilla.medicamento-medico.create')->with('id', $id);
    }

    public function viewMedicamento() {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }

        return view('medicamento.index');
    }

    public function viewMedicamentoCreate($id) {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }

        return view('medicamento.create')->with('id', $id);
    }
}
