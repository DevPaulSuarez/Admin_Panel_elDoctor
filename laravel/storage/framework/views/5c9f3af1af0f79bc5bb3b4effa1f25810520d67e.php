<?php $__env->startSection('title', 'Horario Medicos'); ?>

<?php $__env->startSection('extra-css'); ?>
    <link href="/assets/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="breadcrumb-header justify-content-between">
    <div class="left-content">
        <div>
            <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Horario Médico</h2>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombres">Especialidad <span class="requerid">*</span></label>
                            <select class="form-control select2" id="especialidad">
                                <option value="">SELECCIONE</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombres">Médico <span class="requerid">*</span></label>
                            <select class="form-control select2" id="medico">
                                <option value="">SELECCIONE</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mt-5">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modalNuevo">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">HORARIO</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="formulario" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="apellido_paterno">Medio Atención</label>
                                <select class="form-control" id="medio_atencion" name="medio_atencion">
                                    <option value="VIRTUAL">VIRTUAL</option>
                                    <option value="PRESENCIAL">EN CONSULTORIO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" id="consultorios">
                            <div class="form-group">
                                <label for="apellido_paterno">Consultorio</label>
                                <select class="form-control select2" id="consultorio"></select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tipo_atencion">Tipo de Ateción</label>
                                <select class="form-control text-uppercase" id="tipo_atencion" multiple></select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="apellido_paterno">Especialidades</label>
                                <select class="form-control select2" id="especialidades" multiple="multiple"></select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apellido_paterno">Hora Inicio</label>
                                <input type="time" class="form-control" id="hora_inicio" name="hora_inicio">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apellido_paterno">Hora Fin</label>
                                <input type="time" class="form-control" id="hora_fin" name="hora_fin">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group" id="error" style="display:none">
                                <div class="alert alert-solid-danger mg-b-0" role="alert">
                                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                        <span aria-hidden="true">&times;</span></button>
                                    <ul id="listError"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn ripple btn-primary" id="guardar">GUARDAR</button>
                <button type="button" class="btn ripple btn-secondary" data-dismiss="modal">SALIR</button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-js'); ?>
<script src="/assets/plugins/fullcalendar/fullcalendar.min.js"></script>
<script src="/assets/plugins/fullcalendar/locale-all.js"></script>

<script>
    var hoy = moment().format('YYYY-MM-DD');
    var id_medico = null;
    var medicos = [];
    var medio_atencion;
    var medico_seleccionado = null;
    var fecha_seleccionado = null;
    var id = null;

    $(document).ready(function () {
        inicializarSelect2();

        $('#especialidad').change(function (e) {
            e.preventDefault();
            $.ajax({
                type: "get",
                url: "/api/medicos/especialidad/" + $(this).val(),
                dataType: "json",
                success: function (response) {
                    var html = '<option value="">SELECCIONE</option>';
                    if (response.success) {
                        medicos = response.data;
                        response.data.forEach(e => {
                            html += '<option value="'+e.id+'">'+e.lastname+' '+e.name+'</option>';
                        });
                    }
                    $('#medico').html(html);
                }
            });
        });

        $('#medico').change(function (e) {
            e.preventDefault();
            var id_medico = $(this).val();
            medicos.forEach(e => {
                if (e.id == id_medico) {
                    medico_seleccionado = e;
                }
            });
            obtenerHorariosMedico();
        });

        $('#calendar').fullCalendar({
            locale: 'es',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultDate: hoy,
            editable: false,
            eventLimit: 3,
            viewRender: function (view, element) {
                fechaActualCalendario();
            },
            dayClick: function (date, jsEvent, view, resourceObj) {
                if (hoy <= date.format() && medico_seleccionado != null) {
                    id = null;
                    $("#especialidades").empty();
                    $('#hora_inicio').val('');
                    $('#hora_fin').val('');
                    fecha_seleccionado = date.format();
                    nuevoHorario();
                }
            },
            eventClick: function (calEvent, jsEvent, view) {
                $("#especialidades").empty();
                editarHorario(calEvent);
            }
        });

        function fechaActualCalendario() {
            fechaCalendario = $("#calendar").fullCalendar('getDate');
            yearActual = fechaCalendario.format("YYYY");
            mesActual = fechaCalendario.format("MM");
        }

        function nuevoHorario() {
            var data = [];
            medico_seleccionado.especialidades.forEach(e => {
                data.push({
                    id: e.id,
                    text: e.name
                })
            });
            $('#guardar').prop("disabled", false);
            $('#guardar').html('Guardar');
            $('#medio_atencion').val('VIRTUAL');
            medio_atencion = 'VIRTUAL';
            $('#consultorios').hide();
            $('#consultorio').select2({
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
                // allowClear: true,
                closeOnSelect: true,
                ajax: {
                    url: 'https://eldoctor.pe/api/lugar-atencion-medico?id_medico=' + $('#medico').val(),
                    dataType: 'json',
                    processResults: function (data, params) {
                            return {
                                results: $.map(data.data, function (item) {
                                    return {
                                        text: item.direccion,
                                        id: item.id
                                    }
                                })
                            };
                    },
                    cache: true
                },
            });

            $('#tipo_atencion').select2({
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
                closeOnSelect: true,
                ajax: {
                    url: 'https://eldoctor.pe/api/tipos-atencion',
                    dataType: 'json',
                    processResults: function(data, params) {
                        var datos = [];
                        data.data.forEach(e => {
                            if (e.admin_view == 0) {
                                datos.push(e);
                            }
                        });
                        return {
                            results: $.map(datos, function(item) {
                                return {
                                    text: item.nombre,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                },
            });

            $('#especialidades').select2({
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
                data: data
            });
            $('#modalNuevo').modal('toggle');
        }

        function editarHorario(evento) {
            id = evento.id;
            $('#guardar').prop("disabled", false);
            $('#guardar').html('Guardar');
            $('#hora_inicio').val(evento.start.format('HH:mm:ss'));
            $('#hora_fin').val(evento.end.format('HH:mm:ss'));
            var data = [];
            medico_seleccionado.especialidades.forEach(e => {
                data.push({
                    id: e.id,
                    text: e.name
                })
            });
            $('#medio_atencion').val('VIRTUAL');
            medio_atencion = 'VIRTUAL';
            $('#consultorios').hide();
            $('#consultorio').select2({
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
                // allowClear: true,
                closeOnSelect: true,
                ajax: {
                    url: 'https://eldoctor.pe/api/lugar-atencion-medico?id_medico=' + $('#medico').val(),
                    dataType: 'json',
                    processResults: function (data, params) {
                            return {
                                results: $.map(data.data, function (item) {
                                    return {
                                        text: item.direccion,
                                        id: item.id
                                    }
                                })
                            };
                    },
                    cache: true
                },
            });
            $('#tipo_atencion').select2({
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
                closeOnSelect: true,
                ajax: {
                    url: 'https://eldoctor.pe/api/tipos-atencion',
                    dataType: 'json',
                    processResults: function(data, params) {
                        var datos = [];
                        data.data.forEach(e => {
                            if (e.admin_view == 0) {
                                datos.push(e);
                            }
                        });
                        return {
                            results: $.map(datos, function(item) {
                                return {
                                    text: item.nombre,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                },
            });
            $('#especialidades').select2({
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
                data: data
            });

            $.ajax({
                type: "get",
                url: "https://eldoctor.pe/api/horarios/" + id,
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        medio_atencion = response.data.medio_atencion;
                        $('#medio_atencion').val(response.data.medio_atencion);
                        if (response.data.medio_atencion == 'PRESENCIAL') {
                            $('#consultorios').show();
                        }
                        if (response.data.lugar_atencion_medico) {
                            $('#consultorio').empty();
                            var newOption = new Option(response.data.lugar_atencion_medico.direccion, response.data.lugar_atencion_medico.id, true, true);
                            $('#consultorio').append(newOption);
                        }
                        if(response.data.tipos_atencion) {
                            $('#tipo_atencion').empty();
                            response.data.tipos_atencion.forEach(e => {
                                var newOption = new Option(e.nombre, e.id, true, true);
                                $('#tipo_atencion').append(newOption);
                            });
                        }
                        if (response.data.especialidades) {
                            // $('#especialidades').empty();
                            var id_especialidades = [];
                            response.data.especialidades.forEach(e => {
                                id_especialidades.push(e.id);
                                // var newOption = new Option(e.name, e.id, true, true);
                                // $('#especialidades').append(newOption);
                            });
                            $('#especialidades').val(id_especialidades).trigger('change');
                        }

                        $('#modalNuevo').modal('toggle');
                    }
                }
            });
        }

        function obtenerHorariosMedico() {
            var id_medico = $('#medico').val();
            if (id_medico != '') {
                $.ajax({
                    type: "get",
                    url: "https://eldoctor.pe/api/horarios",
                    data: {
                        id_medico
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.success) {
                            if (response.data.length > 0) {
                                var data = [];
                                response.data.forEach(e => {
                                    var color, title;
                                    if (e.medio_atencion == 'VIRTUAL') {
                                        color = 'rgb(61, 92, 168)';
                                        title = e.medio_atencion;
                                    }
                                    if (e.medio_atencion == 'PRESENCIAL') {
                                        color = '#ff9f89';
                                        title = 'EN CONSULTORIO';
                                    }
                                    data.push({
                                        id: e.id,
                                        title: title,
                                        start: e.fecha + 'T' + e.horainicio,
                                        end: e.fecha + 'T' + e.horafin,
                                        color: color,
                                    });
                                });
                                dibujarEventos(data);
                            }
                        }
                    }
                });
            }
        }

        function dibujarEventos(NuevosEventos) {
            $('#calendar').fullCalendar('removeEvents');
            $('#calendar').fullCalendar('addEventSource', NuevosEventos);
            $('#calendar').fullCalendar('rerenderEvents');
        }

        $('#medio_atencion').change(function (e) {
            e.preventDefault();
            medio_atencion = $(this).val();
            if (medio_atencion == 'VIRTUAL') {
                $('#consultorios').hide();
            }
            if (medio_atencion == 'PRESENCIAL') {
                $('#consultorios').show();
            }
        });

        $('#guardar').click(function (e) {
            e.preventDefault();

            $('#guardar').prop("disabled", true);
            $('#guardar').html('<span class="fa fa-spinner fa-spin"></span>');

            var error = [];

            var id_especialidad = $('#especialidades').val();
            var id_tipos_atencion = $('#tipo_atencion').val();
            var hora_inicio = $('#hora_inicio').val();
            var hora_fin = $('#hora_fin').val();

            if (medio_atencion == 'PRESENCIAL') {
                var id_consultorio = $('#consultorio').val();
                if (id_consultorio == null) {
                    error.push('CONSULTORIO ES REQUERIDO');
                }
            }

            var cobit = false;

            if (id_tipos_atencion != null ) {
                if (id_tipos_atencion.length > 0) {
                    id_tipos_atencion.forEach(e => {
                        if (e == 4) {
                            cobit = true;
                        }
                    });
                }
            }

            if(tipo_atencion == null) {
                error.push('TIPO ATENCION ES REQUERIDO');
            }

            if (id_especialidad == null && !cobit) {
                error.push('ESPECIALIDAD ES REQUERIDO');
            }
            if (hora_inicio == '') {
                error.push('HORA DE INICIO  ES REQUERIDO');
            }
            if (hora_fin == '') {
                error.push('HORA DE FIN ES REQUERIDO');
            }
            if (hora_inicio != '' && hora_fin != '') {
                if (moment(hora_fin, 'LT').format('HH:mm:ss') <= moment(hora_inicio, 'LT').format('HH:mm:ss')) {
                    error.push('HORA DE FIN DEBE SER MAYOR A HORA DE INICIO');
                }
            }
            if (error.length > 0) {
                error.forEach(e => {
                    errors.forEach(e => {
                        msmToastr('ERROR!', e, 'error');
                    });
                    $('#guardar').prop("disabled", false);
                    $('#guardar').html('Guardar');
                });
            } else {
                var data = {
                    medio_atencion,
                    id_medico: $('#medico').val(),
                    id_especialidades: $('#especialidades').val(),
                    id_tipos_atencion,
                    fecha: fecha_seleccionado,
                    hora_inicio: moment($('#hora_inicio').val(), 'LT').format('HH:mm:ss'),
                    hora_fin: moment($('#hora_fin').val(), 'LT').format('HH:mm:ss'),
                }
                if (medio_atencion == 'PRESENCIAL') {
                    data['id_lugar_atencion_medico'] = $('#consultorio').val();
                }

                if(id == null) {
                    $.ajax({
                        type: "post",
                        url: "https://eldoctor.pe/api/horarios",
                        data: data,
                        dataType: "json",
                        success: function (response) {
                            obtenerHorariosMedico();
                            if (response.success) {
                                $('#modalNuevo').modal('hide');
                            } else {
                                response.errors.forEach(e => {
                                    msmToastr('ERROR!', e, 'error');
                                });
                                $('#guardar').prop("disabled", false);
                                $('#guardar').html('Guardar');
                            }
                        }
                    });
                } else {
                    $.ajax({
                        type: "put",
                        url: "https://eldoctor.pe/api/horarios/" + id,
                        data: data,
                        dataType: "json",
                        success: function (response) {
                            obtenerHorariosMedico();
                            if (response.success) {
                                $('#modalNuevo').modal('hide');
                            } else {
                                response.errors.forEach(e => {
                                    msmToastr('ERROR!', e, 'error');
                                });
                                $('#guardar').prop("disabled", false);
                                $('#guardar').html('Guardar');
                            }
                        }
                    });
                }


            }
        });
    });

    function inicializarSelect2() {
        $('#medico').select2({
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
            // allowClear: true,
            closeOnSelect: true,
        });
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
            // allowClear: true,
            closeOnSelect: true,
        });

        $.ajax({
            type: "get",
            url: "/api/especialidades",
            dataType: "json",
            success: function (response) {
                var html = '<option value="">SELECCIONE</option>';
                if (response.success) {
                    response.data.forEach(e => {
                        html += '<option value="'+e.id+'">'+e.name+'</option>';
                    });
                }
                $('#especialidad').html(html);
            }
        });

    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\PessDev\Downloads\admin-eldoctor.pe\laravel\resources\views/horario-medico/index.blade.php ENDPATH**/ ?>