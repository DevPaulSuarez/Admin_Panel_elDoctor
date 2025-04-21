<?php

namespace App\Exports;

use App\Models\Medico;
use App\Models\MonitoreoPaciente;
use App\Models\MonitoreoPacienteMedico;
use App\Models\Reservacion;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use stdClass;

class MonitoreoPacienteExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        $maxMedicos = 0;
        $maxFechas = 0;
        $monitoreosPacienteMedico = [];
        $monitoreosPaciente = MonitoreoPaciente::select('monitoreos_paciente.id', 'monitoreos_paciente.paciente_id', DB::raw("CONCAT(pacient.lastname, ' ', pacient.name) AS paciente"), 'fechas', 'fecha_inicio', 'fecha_fin', 'citas_dia')
            ->join('pacient', 'pacient.id', '=', 'monitoreos_paciente.paciente_id')
            ->where('clinica_id', session('current_user')->id)
            ->where('fecha_fin', '>=', DB::raw("CURDATE()"))
            ->orderBy('fecha_inicio')->get();

        foreach ($monitoreosPaciente as $monitoreoPaciente) {
            $monitoreoPacienteMedico = MonitoreoPacienteMedico::select('medic.id', DB::raw("UPPER (CONCAT(medic.lastname, ' ', medic.name)) AS nombre"))
                ->join('medic', 'monitoreos_paciente_medico.medico_id', '=', 'medic.id')
                ->where('monitoreos_paciente_medico.monitoreos_paciente_id', $monitoreoPaciente->id)
                ->orderBy('nombre')->get();

            if(count($monitoreoPacienteMedico) > $maxMedicos) {
                $maxMedicos = count($monitoreoPacienteMedico);
            }

            $fechas = [];
            foreach (explode(",", $monitoreoPaciente->fechas) as $fecha) {
                array_push($fechas, date('d/m/Y', strtotime($fecha)));
            }

            if(count($fechas) > $maxFechas) {
                $maxFechas = count($fechas);
            }

            $datos = new stdClass();
            $datos = $monitoreoPaciente;
            $datos->fechas = $fechas;
            $datos->medicos = $monitoreoPacienteMedico;

            array_push($monitoreosPacienteMedico, $datos);
        }
        $parametros = new stdClass();
        $parametros->maxMedicos = $maxMedicos;
        $parametros->maxFechas = $maxFechas;

        return view('export.monitoreo-paciente', [
            'monitoreosPaciente' => $monitoreosPacienteMedico,
            'parametros' => $parametros
        ]);
    }
}
