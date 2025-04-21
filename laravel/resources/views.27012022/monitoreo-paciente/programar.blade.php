<div class="modal" id="mdFormCreate">
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
                            <div class="card shadow rounded mt-5 mb-5" style="display: flex; flex-wrap: wrap; flex-direction: row; justify-content: center;" id="horas">
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
                <button type="button" class="btn ripple btn-primary" id="guardar">Guardar</button>
                <button type="button" class="btn ripple btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

{{-- @extends('layouts.main')

@section('title', 'Programar Monitoreos del Paciente')

@section('extra-css')
<link href='{{ asset('res/assets/fullcalendar/fullcalendar.min.css') }}' rel='stylesheet' />
<link href='{{ asset('res/assets/fullcalendar/fullcalendar.print.css') }}' rel='stylesheet' media='print' />
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Programacion de Monitoreo del paciente</h4>
                <p>{{ $datos->paciente }} Desde: {{ date('d/m/Y', strtotime($datos->fecha_inicio)) }} a
                    {{ date('d/m/Y', strtotime($datos->fecha_fin)) }}</p>
            </div>

            <div class="card-content table-responsive">
                <input type="hidden" name="especialidad_id" id="especialidad_id" value="{{ $datos->especialidad_id }}">
                <input type="hidden" name="fechas" id="fechas" value="{{ $datos->fechas }}">
                <input type="hidden" name="fecha_inicio" id="fecha_inicio" value="{{ $datos->fecha_inicio }}">
                <input type="hidden" name="fecha_fin" id="fecha_fin" value="{{ $datos->fecha_fin }}">
                <input type="hidden" name="paciente_id" id="paciente_id" value="{{ $datos->paciente_id }}">
                <input type="hidden" name="citas_dia" id="citas_dia" value="{{ $datos->citas_dia }}">
                <input type="hidden" name="medicos" id="medicos" value="{{ $datos->medicos }}">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-js')
<script src='{{ asset('res/assets/fullcalendar/fullcalendar.min.js') }}'></script>
<script src="{{ asset('res/assets/fullcalendar/lang-all.js') }}"></script>
<script>
    var thisYear = moment().format('YYYY');
    var thisMonth = moment().format('MM');
    var especialidad_id = null;
    var fecha_inicio = null;
    var fecha_fin = null;
    var hora_inicio = null;
    var paciente_id = null;
    var citas_dia = null;
    var fechas = [];
    var medicos = [];
    var eventos = [];

    $(document).ready(function () {
        especialidad_id = $('#especialidad_id').val();
        fechas = $('#fechas').val().split(',');
        fecha_inicio = $('#fecha_inicio').val();
        fecha_fin = $('#fecha_fin').val();
        paciente_id = $('#paciente_id').val();
        citas_dia = $('#citas_dia').val();
        medicos = JSON.parse($('#medicos').val());        
        iniciarCalendario();        
    });
    function iniciarCalendario() {
        hoy = moment().format('YYYY-MM-DD');
        $('#calendar').fullCalendar({
            lang: 'es',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultDate: hoy,
            editable: false,
            eventLimit: 4,
            viewRender: function (view, element) {
                obtenerMonitoreo();
            },
            dayClick: function (date, jsEvent, view, resourceObj) {
                var cantidad = 0;
                eventos.forEach(e => {
                    if(e.fecha == date.format()) {
                        cantidad = e.cantidad;
                    }
                });
                var estado = false;
                fechas.forEach(e => {
                    if(e == date.format()) {
                        estado = true;
                    }
                });
                if(estado) {
                    if(cantidad < citas_dia) {
                        hora_inicio = null;
                        $('#horario').empty();
                        modalNuevo(date.format());
                    }
                }
            },
            dayRender: function(date, cell){
                fechas.forEach(e => {
                    if(e == date.format()) {
                        cell.css("background-color","rgb(40, 187, 206)");
                    }
                });
            },
            eventClick: function (calEvent, jsEvent, view) {
                modalEdit(calEvent);
            },
        });
    }

    function modalNuevo(fechamodal) {
        $('#nombre_programacion').text('Nueva programación');
        $('#fecha_programacion_label').html('Fecha: ' + moment(fechamodal, "YYYY-MM-DD").format("DD/MM/YYYY"));
        $('#fecha_programacion').val(fechamodal);
        var html = '<option value="" selected>-- SELECCIONA --</option>'
        medicos.forEach(e => {
            html += '<option value='+e.id+'>'+e.medico+'</option>'
        });
        $('#medico_programacion').html(html);
        $('#botones_programacion').html('<button onclick="guardarProgramacion();" class="btn btn-primary" id="btnGuardar" type="submit">Guardar</button>');
        $('#myModalNuevaProgramacion').modal('toggle');
    }

    function modalEdit(event) {
        $('#horario').empty();
        $('#nombre_programacion').text('Editar programación');
        $('#fecha_programacion_label').html('Fecha: ' + event.start.format('DD/MM/YYYY') + ' Hora: ' + event.start.format('HH:mm:ss'));
        $('#fecha_programacion').val(event.start.format('YYYY-MM-DD'));
        hora_inicio = event.start.format('HH:mm:ss');
        var html = '<option value="">-- SELECCIONA --</option>'
        medicos.forEach(e => {
            if(e.id == event.medic_id) {
                html += '<option value='+e.id+' selected>'+e.medico+'</option>';
            } else {
                html += '<option value='+e.id+' >'+e.medico+'</option>';
            }
        });
        $('#medico_programacion').html(html);
        $('#botones_programacion').html('<button onclick="editarProgramacion('+event.id+');" class="btn btn-primary" type="submit">Guardar</button>' +
        '<button class="btn btn-danger" onclick="eliminarProgramacion('+event.id+');" type="submit">Eliminar</button>');
        $('#myModalNuevaProgramacion').modal('toggle');
        obtenerHorario(event.medic_id)
    }

    $('#myModalNuevaProgramacion').on('change', '#hora_inicio_programacion', function(){
        hora_inicio = $(this).val();
    });

    $('#medico_programacion').change(function (e) { 
        e.preventDefault();
        var medico_id = $(this).val();
        obtenerHorario(medico_id);
    });

    function guardarProgramacion() {
        var htmlError = '';
        var medico_id = $('#medico_programacion').val();
        
        var fecha_cita = $('#fecha_programacion').val();

        if (medico_id == '') {
            htmlError += "<li>Ingrese un médico válido</li>"
        }
        if (hora_inicio == null) {
            htmlError += "<li>Ingrese una hora válida</li>"
        }
        if (medico_id == '' || hora_inicio == null) {
            $('#error-programacion').show();
            $('#listError-programacion').html(htmlError);
        } else {
            $('#error-programacion').hide();
            data = {
                "_token": $('#token').val(),
                especialidad_id,
                medico_id,
                paciente_id,
                fecha_cita,
                hora_inicio
            }
            $('#btnGuardar').html('<span class="fa fa-spinner fa-spin"></span> Procesando ...')
            $('#btnGuardar').attr('disabled', true);
            $.post('/monitoreos-paciente-programar', data, function (response) {
                $('#myModalNuevaProgramacion').modal('toggle');
                obtenerMonitoreo()
            });
        }
    }

    function editarProgramacion(id) {
        var htmlError = '';
        var medico_id = $('#medico_programacion').val();
        var fecha_cita = $('#fecha_programacion').val();

        if (medico_id == '') {
            htmlError += "<li>Ingrese un médico válido</li>"
        }
        if (hora_inicio == null) {
            htmlError += "<li>Ingrese una hora inicio válida</li>"
        }
        if (medico_id == '' || hora_inicio == '') {
            $('#error-programacion').show();
            $('#listError-programacion').html(htmlError);
        } else {
            $('#error').hide();
            data = {
                '_method': 'PUT',
                "_token": $('#token').val(),
                especialidad_id,
                medico_id,
                paciente_id,
                fecha_cita,
                hora_inicio
            };
            $.ajax({
                type: "post",
                url: "/monitoreos-paciente-programar/"+ id,
                data: data,
                success: function (response) {
                    $('#myModalNuevaProgramacion').modal('toggle');
                    obtenerMonitoreo();
                }
            });
        }
    }

    function eliminarProgramacion(id) {
        $.ajax({
            type: "POST",
            url: "/monitoreos-paciente-programar/" + id,
            data: {
                '_method': 'DELETE',
                '_token': $('#token').val()
            },
            success: function (response) {
                $('#myModalNuevaProgramacion').modal('toggle');
                obtenerMonitoreo();
            }
        });
    }

    function obtenerHorario(medico_id) {
        $('#horario').empty();
        var lugar_id = 1;
        if(medico_id != '') {
            $.get('/horario-medico-establecido/'+especialidad_id+'/'+medico_id+'/'+thisYear+'/'+thisMonth+'/'+lugar_id,
                function (response) {
                    var fecha_cita = $('#fecha_programacion').val();
                    fechaActual = moment().format('YYYY-MM-DD');
                    horaActual = moment().format('HH:mm:ss');
                    if(fecha_cita == fechaActual) {
                        horariosDisponible = response.filter(e => {
                        if (e.fecha == fechaActual && e.inicio > horaActual) {
                                return e;
                            }
                        });
                    } else {
                        horariosDisponible = response.filter(e => {
                            if (e.fecha == fecha_cita) {
                                return e;
                            }
                        });
                    }
                    if(horariosDisponible.length == 0) {
                        $('#horario').html("<div class='alert alert-danger alert-dismissible fade in' style='width: 100%'>NO HAY HORARIOS DISPONIBLES</div>");
                    } else{
                        horariosDisponible.forEach(e => {
                            HorarioDisponible24Horas = moment(e.inicio, 'HH:mm:ss').format('h:mm A');
                            $('#horario').append('<label style="margin:5px; font-size:15px; color: #000;width: 90px;">' +
                            '<input type="radio" id="hora_inicio_programacion" name="hora_inicio_programacion" value=' +
                            e.inicio +
                            ' required="required"><span style="margin: 5px">' +
                                HorarioDisponible24Horas +
                            '</span></label>');
                        });
                    }
                }
            );
        }
    }

    function obtenerMonitoreo() {
        $.ajax({
            type: "get",
            url: "/citas-monitoreo/" + paciente_id,
            success: function (response) {
                dibujarEventos(response);
            }
        });
    }

    function dibujarEventos(response) {
        $('#calendar').fullCalendar('removeEvents');
        $('#calendar').fullCalendar('addEventSource', response);
        $('#calendar').fullCalendar('rerenderEvents');
        var data = [];
        response.forEach((e, i) => {
            var fecha = moment(e.start).format('YYYY-MM-DD');
            var buscador = data.filter(a => { if(a.fecha == fecha) return a; })
            if(buscador.length == 0) {
                var obj = new Object();
                obj['fecha'] = fecha;
                obj['cantidad'] = 1;
                data.push(obj);
            } else {
                data.filter((a, e) => { if(a.fecha == buscador[0].fecha) data[e].cantidad++; })
            }
        });
        eventos = data;
    }
</script>
@endsection --}}