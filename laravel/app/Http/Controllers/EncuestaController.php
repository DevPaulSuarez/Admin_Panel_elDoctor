<?php

namespace App\Http\Controllers;

use App\Models\Encuesta;
use App\Models\Reservacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class EncuestaController extends Controller
{
    public function index()
    {
        $encuestas = Reservacion::select(
            'encuestas.id',
            DB::raw("CONCAT(medic.lastname,' ',medic.name) as medico"),
            DB::raw("CONCAT(pacientes.apellidos,' ',pacientes.nombres) as paciente"),
            'encuestas.puntuacion_servicio_plataforma',
            'encuestas.puntuacion_atencion_medico',
            'encuestas.sugerencia_plataforma',
            'encuestas.opinion_medico',
            'conversation.time_video_connected',
            'conversation.times_video_connected',
            'reservation.date_at AS fecha'
        )
            ->leftJoin('encuestas', 'encuestas.reservation_id', "=", "reservation.id")
            ->join('medic', 'medic.id', "=", "reservation.medic_id")
            ->join('pacientes', 'pacientes.id', "=", "reservation.pacient_id")
            ->join('conversation', 'conversation.id', "=", "reservation.conversation_id")
            ->where('medic.id', '!=', 45)
            ->where('medic.id', '!=', 70)
            ->where('medic.id', '!=', 90)
            ->orderBy('reservation.date_at', 'DESC')
            ->get();
        return $encuestas;
    }

    public function updateActive(Request $request, $id)
    {
        $response = new stdClass();

        $encuesta = Encuesta::find($id);
        $encuesta->is_active = $request->is_active;
        $encuesta->save();

        $response->success = true;
        $response->data = $encuesta;
        $response->error = [];
        return response()
            ->json($response);
    }
}
