<?php

use Illuminate\Support\Facades\Route;

Route::post('/login', 'UsuarioController@login');

Route::get('/', 'ViewController@showHome');

Route::get('/login', 'ViewController@showLogin');

Route::get('/especialidades', 'ViewController@viewEspecialidad');

Route::get('/especialidades/create', 'ViewController@viewEspecialidadCreate');


Route::get('/blogs', 'ViewController@showBlog');

// medicos

Route::get('/medicos', 'ViewController@viewMedico');

Route::get('/medicos/create', 'ViewController@viewMedicoCreate');

Route::get('/medicos/historial/{id}', 'ViewController@viewMedicoHistorial');

// pacientes

Route::get('/pacientes', 'ViewController@viewPaciente');

Route::get('/pacientes/create', 'ViewController@viewPacienteCreate');

Route::get('/pacientes/pass/{id}', function ($id) {
    return view('paciente.pass')->with('id', $id);
});

Route::get('/pacientes/historial/{id}', 'ViewController@viewPacienteHistorial');

// Citas

Route::get('/citas', 'ViewController@viewCita');

Route::get('/citas/canceladas', function () {
    if (!session()->has('current_user')) {
        return redirect()->intended('/login');
    }

    return view('cita.cancelada');
});

Route::get('/citas/reprogramadas', function () {
    if (!session()->has('current_user')) {
        return redirect()->intended('/login');
    }

    return view('cita.reprogramada');
});

Route::get('/citas/agendadas', function () {
    if (!session()->has('current_user')) {
        return redirect()->intended('/login');
    }

    return view('cita.agendada');
});

Route::get('/citas/create', 'ViewController@viewCitaCreate');

// Horarios medico

Route::get('/horarios-medico', 'ViewController@showHorarioMedico');

// Encuesta

Route::get('/encuestas', 'ViewController@viewEncuesta');

// Clinica

Route::get('/instituciones', 'ViewController@viewClinica');
Route::get('/instituciones/create', 'ViewController@viewClinicaCreate');

// Monitoreio Paciente

Route::get('/monitoreos-paciente', 'ViewController@viewMonitoreoPaciente');

Route::get('/monitoreos-paciente/create', 'ViewController@viewMonitoreoPacienteCreate');

Route::get('/monitoreos-paciente/programar', 'ViewController@viewMonitoreoPacienteProgramar');

Route::get('/plantillas/medicamentos-especialidades', 'ViewController@viewPlantillaMedicamentoEspecialidad');
Route::get('/plantillas/medicamentos-especialidades/{id}', 'ViewController@viewPlantillaMedicamentoEspecialidadCreate');

Route::get('/plantillas/medicamentos-medicos', 'ViewController@viewPlantillaMedicamentoMedico');
Route::get('/plantillas/medicamentos-medicos/{id}', 'ViewController@viewPlantillaMedicamentoMedicoCreate');


Route::get('/medicamentos', 'ViewController@viewMedicamento');
Route::get('/medicamentos/{id}', 'ViewController@viewMedicamentoCreate');

Route::get('/asistentes', function () {
    return view('asistente.index');
});
Route::get('/asistentes/{id}', function ($id) {
    return view('asistente.create')->with('id', $id);
});
