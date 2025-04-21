<?php

namespace App\Exports;

use App\Models\Reservacion;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class EncuestaExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        return view('export.encuesta', [
            'encuestas' => Reservacion::select(
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
                ->get()
        ]);
    }
}
