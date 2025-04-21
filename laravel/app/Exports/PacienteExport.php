<?php

namespace App\Exports;

use App\Models\Paciente;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class PacienteExport implements FromView
{
    use Exportable;
    
    public function view(): View
    {
        return view('export.paciente', [
            'pacientes' => Paciente::select('pacient.id','name','lastname','address','email', 'phone')
            // ->join('pacientes_clinica', 'pacientes_clinica.paciente_id', '=', 'pacient.id')
            // ->where('pacientes_clinica.clinica_id', session('current_user')->id)
            // ->where('pacientes_clinica.estado', true)
            ->orderBy('lastname')->get()
        ]);
    }
}
