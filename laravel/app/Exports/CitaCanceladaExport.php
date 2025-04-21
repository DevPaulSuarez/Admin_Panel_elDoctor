<?php

namespace App\Exports;

use App\Models\Reservacion;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class CitaCanceladaExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        return view('export.cita', [
            'citas' => Reservacion::select('reservation.id', 'reservation.title', 'reservation.date_at', 'reservation.time_at', DB::raw("CONCAT(pacientes.apellidos, ' ', pacientes.nombres) AS paciente"), DB::raw("UPPER(CONCAT(medic.lastname, ' ', medic.name)) AS medico"),  'reservation.registrador_nombre',  'reservation.tipo_usuario', 'reservation.created_at AS fecha_creacion')
            ->whereIn('estado',  ['CANCELADO'])
            // ->join('pacient', 'reservation.pacient_id', '=', 'pacient.id')
            ->join('pacientes', 'reservation.pacient_id', '=', 'pacientes.id')
            ->join('medic', 'reservation.medic_id', '=', 'medic.id')
            ->orderBy(DB::raw("CONCAT(reservation.date_at, ' ', reservation.time_at)"), 'desc')->get()
        ]);
    }
}
