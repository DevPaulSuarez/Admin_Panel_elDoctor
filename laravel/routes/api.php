<?php

use Illuminate\Support\Facades\Route;

// Especialidades
Route::get('/especialidades/export', 'ExportadorExcelController@exportEspecialidad');
Route::get('/especialidades', 'EspecialidadController@index');
Route::get('/especialidades/{id}', 'EspecialidadController@show');
Route::post('/especialidades', 'EspecialidadController@store');
Route::put('/especialidades/{id}', 'EspecialidadController@update');
Route::delete('/especialidades/{id}', 'EspecialidadController@destroy');

// Medicos
Route::put('/medicos/active/{id}', 'MedicoController@updateActive');
Route::get('/medicos/dni/{dni}', 'MedicoController@getByDni');
Route::get('/medicos/especialidad/{id_especialidad}', 'MedicoController@getEspecialidad');
Route::get('/medicos/export', 'ExportadorExcelController@exportMedico');
Route::get('/medicos', 'MedicoController@index');
Route::get('/medicos/{id}', 'MedicoController@show');
Route::post('/medicos', 'MedicoController@store');
Route::put('/medicos/{id}', 'MedicoController@update');
Route::delete('/medicos/{id}', 'MedicoController@destroy');

// Pacientes
Route::get('/pacientes/dni/{dni}', 'PacienteController@getByDni');
Route::get('/pacientes/export', 'ExportadorExcelController@exportPaciente');
Route::get('/pacientes', 'PacienteController@index');
Route::get('/pacientes/{id}', 'PacienteController@show');
Route::post('/pacientes', 'PacienteController@store');
Route::put('/pacientes/{id}', 'PacienteController@update');
Route::delete('/pacientes/{id}', 'PacienteController@destroy');

// Citas

Route::get('/citas/export', 'ExportadorExcelController@exportCita');
Route::get('/citas/export/agendadas', 'ExportadorExcelController@exportCitaAgendada');
Route::get('/citas/export/reprogramadas', 'ExportadorExcelController@exportCitaReprogramada');
Route::get('/citas/export/canceladas', 'ExportadorExcelController@exportCitaCancelada');
Route::get('/citas', 'CitaController@index');
Route::get('/citas/{id}', 'CitaController@show');
Route::post('/citas', 'CitaController@store');
Route::put('/citas/{id}', 'CitaController@update');
Route::delete('/citas/{id}', 'CitaController@destroy');

// Encuestas
Route::get('/encuestas/export', 'ExportadorExcelController@exportEncuesta');
Route::get('/encuestas', 'EncuestaController@index');
Route::put('/encuestas/active/{id}', 'EncuestaController@updateActive');
Route::get('/monitoreos-paciente', 'MonitoreoPacienteController@index');
Route::get('/appointment-reminder-emails', 'NotificacionController@sendingAppointmentReminderEmails');
Route::get('/clinicas', 'ClinicaController@index');

Route::get('/plantillas/medicamentos-especialidades', 'PlantillaMedicamentoEspecialidadController@index');
Route::get('/plantillas/medicamentos-especialidades/{id}', 'PlantillaMedicamentoEspecialidadController@show');
Route::post('/plantillas/medicamentos-especialidades', 'PlantillaMedicamentoEspecialidadController@store');
Route::put('/plantillas/medicamentos-especialidades/{id}', 'PlantillaMedicamentoEspecialidadController@update');
Route::delete('/plantillas/medicamentos-especialidades/{id}', 'PlantillaMedicamentoEspecialidadController@destroy');

Route::get('/plantillas/medicamentos-medicos', 'PlantillaMedicamentoMedicoController@index');
Route::get('/plantillas/medicamentos-medicos/{id}', 'PlantillaMedicamentoMedicoController@show');
Route::post('/plantillas/medicamentos-medicos', 'PlantillaMedicamentoMedicoController@store');
Route::put('/plantillas/medicamentos-medicos/{id}', 'PlantillaMedicamentoMedicoController@update');
Route::delete('/plantillas/medicamentos-medicos/{id}', 'PlantillaMedicamentoMedicoController@destroy');

Route::get('/medicamentos', 'MedicamentoController@index');
Route::get('/medicamentos/{id}', 'MedicamentoController@show');
Route::post('/medicamentos', 'MedicamentoController@store');
Route::put('/medicamentos/{id}', 'MedicamentoController@update');
Route::delete('/medicamentos/{id}', 'MedicamentoController@destroy');

Route::get('/asistentes', 'AsistenteController@findAll');
Route::get('/asistentes/{id}', 'AsistenteController@findById');
Route::post('/asistentes', 'AsistenteController@save');
Route::put('/asistentes/{id}', 'AsistenteController@update');
Route::delete('/asistentes/{id}', 'AsistenteController@delete');
