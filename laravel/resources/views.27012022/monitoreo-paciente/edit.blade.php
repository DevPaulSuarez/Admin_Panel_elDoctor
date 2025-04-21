@extends('layouts.main')

@section('title', 'Editar Monitoreo Paciente')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('res/assets/multidatepicker/multidatespicker.css') }}">
<style>
    #fechas {
        border-radius: 16px 16px 16px 16px;
        border: 0px solid #000000;
        -webkit-box-shadow: 0px 9px 22px -8px rgba(0, 0, 0, 0.5);
        -moz-box-shadow: 0px 9px 22px -8px rgba(0, 0, 0, 0.5);
        box-shadow: 0px 9px 22px -8px rgba(0, 0, 0, 0.5);
        padding: 15px;
        min-height: 50px;
        margin-bottom: 10px;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Editar Monitoreo Paciente</h4>
            </div>
            <div class="card-content table-responsive">
                {{ Form::open(['route' => ['monitoreos-paciente.update', $monitoreoPaciente->id], 'method' => 'PUT', 'class' => 'form-horizontal']) }}
                <input type="hidden" id="clinica_id" value="{{ session('current_user')->id }}">
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Paciente *</label>
                    <div class="col-md-6">
                        <select name="paciente_id" id="paciente_id" class="form-control text-uppercase" required>
                            <option value="">-- SELECCIONE --</option>
                            @foreach ($pacientes as $paciente)
                            <option value="{{ $paciente->id }}" {{ $monitoreoPaciente->paciente_id == $paciente->id ? 'selected' : '' }}>{{ $paciente->lastname }} {{ $paciente->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Especialidad *</label>
                    <div class="col-md-6">
                        <select name="especialidad_id" id="especialidad_id" class="form-control text-uppercase"
                            required>
                            <option value="">-- SELECCIONE --</option>
                            @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ $monitoreoPaciente->especialidad_id == $categoria->id ? 'selected' : '' }}>{{ $categoria->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Médico *</label>
                    <div class="col-md-6">
                        <input type="hidden" name="medicos" id="medicos" value="{{ $monitoreoPaciente->medicos }}">
                        <select class="form-control text-uppercase" id="medicos_id" name="medicos_id[]" multiple="multiple"></select>
                    </div>
                </div>
                {{-- <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Fecha de Inicio *</label>
                    <div class="col-md-6">
                        <input type="date" name="fecha_inicio" class="form-control" id="fecha_inicio"
                            placeholder="Fecha de Inicio" required value="{{ $monitoreoPaciente->fecha_inicio }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Fecha de Fin *</label>
                    <div class="col-md-6">
                        <input type="date" name="fecha_fin" class="form-control" id="fecha_fin"
                            placeholder="Fecha de Fin" required value="{{ $monitoreoPaciente->fecha_fin }}">
                    </div>
                </div> --}}
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Fechas *</label>
                    <div class="col-md-6">
                        <div id="fechas" style="display: flex; flex-wrap: wrap">
                            @php
                                $fechas = explode(',',$monitoreoPaciente->fechas)
                            @endphp
                            @foreach ($fechas as $fecha)
                            <div class="fechas">{{ date('d/m/Y', strtotime($fecha)) }}</div>
                            @endforeach
                        </div>
                        <input type="hidden" id="selectedValues" name="fechas" class="date-values" value="{{ $monitoreoPaciente->fechas }}" readonly />
                        <div id="parent" class="" style="width: 297px; margin: auto">
                            <div class="header-row" style="display: flex">
                                <div class="col-xs previous">
                                    <a href="javascrip:;" id="previous" onclick="previous()">
                                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <div class="card-header month-selected col-sm" id="monthAndYear">
                                </div>
                                <div class="col-sm">
                                    <select class="form-control col-xs-6" name="month" id="month"
                                        onchange="change()"></select>
                                </div>
                                <div class="col-sm">
                                    <select class="form-control col-xs-6" name="year" id="year"
                                        onchange="change()"></select>
                                </div>
                                <div class="col-xs next">
                                    <a href="javascrip:;" id="next" onclick="next()">
                                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            <table id="calendar">
                                <thead>
                                    <tr>
                                        <th>DO</th>
                                        <th>LU</th>
                                        <th>MA</th>
                                        <th>MI</th>
                                        <th>JU</th>
                                        <th>VI</th>
                                        <th>SA</th>
                                    </tr>
                                </thead>
                                <tbody id="calendarBody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Citas por día *</label>
                    <div class="col-md-6">
                        <input type="number" name="citas_dia" class="form-control" id="citas_dia"
                            placeholder="Citas po día" required value="{{ $monitoreoPaciente->citas_dia }}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-js')
<script src="{{ asset('res/assets/multidatepicker/multidatespicker.js?v=1.0.1') }}"></script>
<script>
    var fechas = $('#selectedValues').val().split(',');
    
    var marcarFechas = setInterval(() => {
        var estado = false;
        selectedDates = fechas;
        fechas.forEach(e => {
            $('#'+e).addClass('highlight');
            if($('#'+e).html() !== undefined) {
                estado = true;
            }
        });
        if(estado) {
            clearInterval(marcarFechas)
        }
    }, 1000);
    
    var medicos = JSON.parse($('#medicos').val());
    
    $('#medicos_id').select2({
        placeholder: 'SELECCIONE',
        language: {
            noResults: function () {
                    return "No hay resultado";
            },
            searching: function () {
                    return "Buscando..";
            }
        },
        width: '100%',
        closeOnSelect: false,
        allowClear: true,
        ajax: {
            url: '/medicos/' + $('#clinica_id').val() + "/" + $('#especialidad_id').val(),
            processResults: function (data) {
                    var array = [];
                    data.forEach(e => {
                        array.push({
                            id: e.id,
                            text: (e.lastname + ' ' + e.name).toUpperCase()
                        })
                    });
                    return {
                        results: array
                    };
            }
        }
    });
    var medicos_id = [];
    medicos.forEach(e => {
        medicos_id.push(e.id);
        var newOption = new Option(e.nombre, e.id, true, true);
        $('#medicos_id').append(newOption).trigger('change');
    });
    $('#medicos_id').val(medicos_id).trigger('change');

    $("#especialidad_id").change(function () {
        $("#especialidad_id option:selected").each(function () {
            id = $(this).val();

            $('#medicos_id').select2({
                placeholder: 'SELECCIONE',
                language: {
                    noResults: function () {
                            return "No hay resultado";
                    },
                    searching: function () {
                            return "Buscando..";
                    }
                },
                width: '100%',
                closeOnSelect: false,
                allowClear: true,
                ajax: {
                    url: '/medicos/' + $('#clinica_id').val() + "/" + id,
                    processResults: function (data) {
                            var array = [];
                            data.forEach(e => {
                                array.push({
                                    id: e.id,
                                    text: (e.lastname + ' ' + e.name).toUpperCase()
                                })
                            });
                            return {
                                results: array
                            };
                    }
                }
            });
        });
    });
</script>
@endsection