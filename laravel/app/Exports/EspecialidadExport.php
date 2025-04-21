<?php

namespace App\Exports;

use App\Models\Especialidad;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class EspecialidadExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        return view('export.especialidad', [
            'especialidades' => Especialidad::orderBy('name')->get()
        ]);
    }
}
