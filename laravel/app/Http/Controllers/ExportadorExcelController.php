<?php

namespace App\Http\Controllers;

use App\Exports\CitaAgendadaExport;
use App\Exports\CitaCanceladaExport;
use App\Exports\CitaExport;
use App\Exports\CitaReprogramadaExport;
use App\Exports\EncuestaExport;
use App\Exports\EspecialidadExport;
use App\Exports\MedicoExport;
use App\Exports\PacienteExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportadorExcelController extends Controller
{
    public function exportPaciente()
    {
        return Excel::download(new PacienteExport, 'pacientes-' . date('YmdHis') . '.xlsx');
    }

    public function exportMedico()
    {
        return Excel::download(new MedicoExport, 'medicos-' . date('YmdHis') . '.xlsx');
    }

    public function exportCita()
    {
        return Excel::download(new CitaExport, 'citas-monitoreo-' . date('YmdHis') . '.xlsx');
    }

    public function exportCitaAgendada()
    {
        return Excel::download(new CitaAgendadaExport, 'citas-monitoreo-' . date('YmdHis') . '.xlsx');
    }
    public function exportCitaReprogramada()
    {
        return Excel::download(new CitaReprogramadaExport, 'citas-monitoreo-' . date('YmdHis') . '.xlsx');
    }
    public function exportCitaCancelada()
    {
        return Excel::download(new CitaCanceladaExport, 'citas-monitoreo-' . date('YmdHis') . '.xlsx');
    }

    public function exportEncuesta()
    {
        return Excel::download(new EncuestaExport, 'encuesta-' . date('YmdHis') . '.xlsx');
    }

    public function exportEspecialidad()
    {
        return Excel::download(new EspecialidadExport, 'especialidad-' . date('YmdHis') . '.xlsx');
    }
}
