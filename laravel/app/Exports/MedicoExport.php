<?php

namespace App\Exports;

use App\Models\Medico;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class MedicoExport implements FromView
{
    use Exportable;
    
    public function view(): View
    {
        return view('export.medico', [
            'medicos' => Medico::select(DB::raw('UPPER(lastname) as apellidos'), DB::raw('UPPER(name) as nombres'), DB::raw('UPPER(address) as direccion'), 'email', 'phone as telefono')
            ->orderBy('lastname')->get()
        ]);
    }
}
