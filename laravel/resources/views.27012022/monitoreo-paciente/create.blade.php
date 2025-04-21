<div class="modal" id="mdFormCreate">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Monitoreo Paciente</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nombres">Paciente <span class="requerid">*</span></label>
                            <select class="form-control select2" id="paciente">
                                <option value="">SELECCIONE</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nombres">Médico <span class="requerid">*</span></label>
                            <select class="form-control select2" id="medico">
                                <option value="">SELECCIONE</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nombres">Especialidad <span class="requerid">*</span></label>
                            <select class="form-control select2" id="especialidad">
                                <option value="">SELECCIONE</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <fieldset>
                                <legend>Citas <span class="requerid">*</span> <button type="button" class="btn btn-primary btn-sm" id="programar_cita" disabled>Agregar</button></legend>
                                <div class="row" id="citas-programadas"></div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn ripple btn-primary" id="guardar-monitoreo">Guardar</button>
                <button type="button" class="btn ripple btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="mdFormProgramar">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Programar</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Fecha <span class="requerid">*</span></label>
                            <input type="date" class="form-control" id="fecha">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="numero_celular">Duración Atención <span class="requerid">*</span></label>
                            <input type="text" class="form-control" id="tiempo_atencion">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="card shadow rounded mt-3 mb-3" style="display: flex; flex-wrap: wrap; flex-direction: row; justify-content: center;" id="horas">
                                NO HAY HORARIOS DISPONIBLES
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="numero_celular">Hora personalizada</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <label class="ckbox wd-16 mg-b-0"><input type="checkbox" class="mg-0" id="habilitar-hora_personalizada"><span></span></label>
                                    </div>
                                </div><input type="text" class="form-control" id="hora_personalizada" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn ripple btn-primary" id="agregar-cita">Guardar</button>
                <button type="button" class="btn ripple btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

{{-- @extends('layouts.main')

@section('title', 'Crear Monitoreo Paciente')

@section('extra-css')

@endsection

@section('content')
<div class="row">
    <div class="col-md-12">

        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Nuevo Cita</h4>
            </div>
            <div class="card-content table-responsive">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="inputEmail1" class="col-lg-2 control-label">Paciente</label>
                        <div class="col-lg-10">
                            <select name="paciente" id="paciente" class="form-control text-uppercase" required>
                                <option value="">SELECCIONE</option>
                                @foreach ($pacientes as $paciente)
                                <option value="{{ $paciente->id }}">{{ $paciente->lastname }} {{ $paciente->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-lg-2 control-label">Medico</label>
                        <div class="col-lg-10">
                            <select name="medico" id="medico" class="form-control text-uppercase" required>
                                <option value="">SELECCIONE</option>
                                @foreach ($medicos as $medico)
                                <option value="{{ $medico->id }}">{{ $medico->lastname }} {{ $medico->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-lg-2 control-label">Especialidad</label>
                        <div class="col-lg-10">
                            <select name="especialidad" id="especialidad" class="form-control text-uppercase" required>
                                <option value="">SELECCIONE</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                            <label for="" class="col-lg-2 control-label">Citas</label>
                            <div class="col-lg-10">
                                <button type="button" class="btn btn-primary" id="programar_cita">Agregar Cita</button>
                                <div class="row" id="citas-programadas"></div>
                            </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button type="button" class="btn btn-default" id="guardarTelemonitoreo">Agregar Cita</button>
                        </div>
                    </div>
                </form>
    </div>
</div>
</div>
</div>

@endsection

@section('extra-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script>
    $(document).ready(function () {
        citas = [];
        $('#citas-programadas').empty();

        $('#programar_cita').prop("disabled", true)
        $('#guardarTelemonitoreo').prop("disabled",false);
        $('#guardarTelemonitoreo').html('Guardar');
        inicializarSelect2();

        $('#medico').change(function (e) {
            e.preventDefault();
            $.get("/categorias-medico/" + $(this).val(),
                function (response) {
                    var html = '<option value="">SELECCIONE</option>';
                    response.forEach(e => {
                        html += '<option value=' + e.id + '>' + e.name + '</option>';
                    });
                    $('#especialidad').html(html);
                }
            );
        });

        $('#especialidad').change(function (e) { 
            e.preventDefault();
            obtenerCupos();
        });

        function inicializarSelect2() {
            $('#especialidad').select2({
                placeholder: 'SELECCIONA',
                width: '100%',
                searchInputPlaceholder: 'Buscar...',
                language: {
                    noResults: function () {
                        return "No hay resultado";
                    },
                    searching: function () {
                        return "Buscando..";
                    }
                },
                allowClear: true,
                closeOnSelect: true
            });
            $('#medico').select2({
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
                closeOnSelect: true,
                allowClear: true,
            });

            $('#paciente').select2({
                placeholder: 'SELECCIONA',
                width: '100%',
                searchInputPlaceholder: 'Buscar...',
                language: {
                    noResults: function () {
                        return "No hay resultado";
                    },
                    searching: function () {
                        return "Buscando..";
                    }
                },
                allowClear: true,
                closeOnSelect: true
            });
        }

        function inicializarTimepiker() {
            $('#hora_personalizada').timepicker({
                timeFormat: 'h:mm p',
                minTime: '06:00:00',
                maxHour: 22,
                maxMinutes: 00,
                startTime: new Date(0,0,0,6,0,0),
                interval: 15,
                dynamic: false,
                dropdown: true,
                scrollbar: true,
                zindex: 999999
            });
            $('#tiempo_atencion').timepicker({
                timeFormat: 'HH:mm:ss',
                minTime: '00:15:00',
                maxHour: 2,
                maxMinutes: 00,
                startTime: new Date(0,0,0,0,15,0),
                interval: 15,
                dynamic: false,
                dropdown: true,
                scrollbar: true,
                zindex: 999999,
                change: function(time) {
                    obtenerCupos();
                }
            });
        }

        $('#fecha_cita').blur(function (e) { 
            e.preventDefault();
            obtenerCupos();
        });
        function obtenerCupos() {
            var data = {
                id_medico: $('#medico').val(),
                id_especialidad: $('#especialidad').val(),
                medio_atencion: 'VIRTUAL',
                tiempo_atencion: $('#tiempo_atencion').val(),
            }
            $.ajax({
                type: "get",
                url: 'https://doctor3.syslacsdev.com/api/medico/horario',
                data: data,
                dataType: "json",
                success: function (response) {
                    var fechaActual = $('#fecha_cita').val();
                    var horaActual = moment().format('HH:mm:ss');
                    var horarios = [];
                    var horas = '';
                    if(response.length > 0) {
                        horarios = response.filter(e => {
                            if (e.fecha == fechaActual && e.inicio > horaActual) {
                                return e;
                            } else if (e.fecha > fechaActual) {
                                return e;
                            }
                        });

                        if(horarios.length > 0) {
                            horarios.forEach(h => {                    
                                horas += '<button type="button" class="btn btn-success btn-sm m-2 hora" data-hora="'+h.inicio+'">'+moment(h.inicio, 'HH:mm:ss').format('hh:mm A')+'</button>';
                            });
                        } else {
                            horas += 'NO HAY HORARIOS DISPONIBLES';
                        }
                    } else {
                        horas += 'NO HAY HORARIOS DISPONIBLES';
                    }
                    $('#horas').html(horas);
                }
            });
        }

        $('#habilitar-hora_personalizada').change(function (e) { 
            e.preventDefault();
            $(this).is(':checked') ? $('#hora_personalizada').prop("disabled", false) : $('#hora_personalizada').prop("disabled", true);
        })

        $('#horas').on('click', '.hora', function () {
            var hora = $(this).data('hora');
            $("#horas button").each(function(){
                if($(this).data('hora') == hora) {
                    $(this).addClass('btn-primary');
                    $(this).removeClass('btn-success');
                } else {
                    $(this).addClass('btn-success');
                    $(this).removeClass('btn-primary');
                }
            });
        });

        $('#medico').change(function (e) { 
            e.preventDefault();
            habilitarAgregarCita();
        });

        $('#paciente').change(function (e) { 
            e.preventDefault();
            habilitarAgregarCita();
        });

        $('#especialidad').change(function (e) { 
            e.preventDefault();
            habilitarAgregarCita();
        });

        function habilitarAgregarCita() {
            var medico = $('#medico').val();
            var paciente = $('#paciente').val();
            var especialidad = $('#especialidad').val();

            if (medico != '' && paciente != '' && especialidad != '') {
                $('#programar_cita').prop("disabled", false)
            } else {
                $('#programar_cita').prop("disabled", true)
            }
        }

        $('#programar_cita').click(function (e) { 
            e.preventDefault();
            inicializarTimepiker();
            $('#habilitar-hora_personalizada').prop("checked", false);
            $('#hora_personalizada').prop("disabled", true)
            $('#fecha_cita').val(moment().format('YYYY-MM-DD'));
            $('#tiempo_atencion').val('00:15:00');
            $('#hora_personalizada').val('');
            obtenerCupos();
            $('#programar').modal({
                keyboard: false
            });
        });

        $('#guardarTelemonitoreo').click(function (e) {
            $(this).prop("disabled",true);
            $(this).html('<i class="fas fa-spinner fa-spin"></i> Procesando ...');
            e.preventDefault();
            var fechas = [];
            citas.forEach(e => {
                fechas.push(e.fecha);
            });
            fechas = fechas.unique();

            var data = {
                id_paciente: $('#paciente').val(),
                id_medico: $('#medico').val(),
                id_especialidad: $('#especialidad').val(),
                fecha_inicio: fechas[0],
                fecha_fin: fechas[fechas.length - 1],
                citas
            }
            $.ajax({
                type: "post",
                url: "https://doctor3.syslacsdev.com/api/telemonitoreos",
                data: data,
                dataType: "json",
                success: function (response) {
                    if(response.success) {
                        location.href = '/monitoreos-paciente';
                    } else {
                        response.error.forEach(e => {
                            msmToastr('ERROR!', e, 'error');
                        });
                        $('#guardarTelemonitoreo').prop("disabled", false);
                        $('#guardarTelemonitoreo').html('Guardar');
                    }
                }
            });
        });
        
        $('#agregarCita').click(function (e) { 
            e.preventDefault();
            var hora = null;
            $("#horas button").each(function(){
                if($(this).hasClass('btn-primary')) {
                    hora = $(this).data('hora');
                }
            });
            if (hora == null) {
                hora = moment($('#hora_personalizada').val(), 'LT').format('HH:mm:ss')
            }
            citas.push({
                id_medico: $('#medico').val(),
                id_paciente: $('#paciente').val(),
                id_especialidad: $('#especialidad').val(),
                fecha: $('#fecha_cita').val(),
                hora,
                tiempo_atencion: $('#tiempo_atencion').val(),
                medio_atencion: 'VIRTUAL',
                tipo_atencion: 'MONITOREO',
                monto_pagado: 0

            });
            $('#programar').modal('hide');
            agregarCitas();
        });

        function agregarCitas() {
            var html = '';
            citas.forEach((e,i) => {
                html += '<div class="col-md-12">';
                html += '<div class="card shadow rounded mt-5">';
                html += '<div class="row">';
                html += '<div class="col-md-4">';
                html += '<p><label class="mr-3">Fecha:</label>'+e.fecha+'</p>';
                html += '</div>';
                html += '<div class="col-md-5">';
                html += '<p><label class="mr-3">Hora:</label>'+e.hora+'</p>';
                html += '</div>';
                html += '<div class="col-md-3">';
                html += '<button type="button" class="btn btn-danger m-2 eliminar" data-index="'+i+'"><i class="fas fa-trash"></i></button>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
            });
            $('#citas-programadas').html(html);
        }
        $('#citas-programadas').on('click', '.eliminar', function () {
            citas.splice($(this).data('index'), 1);
            agregarCitas();
        });

        Array.prototype.unique=function(a){
            return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0
        });
    });
</script>
@endsection --}}