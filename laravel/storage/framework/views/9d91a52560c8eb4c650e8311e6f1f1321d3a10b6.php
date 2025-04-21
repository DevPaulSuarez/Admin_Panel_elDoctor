<?php $__env->startSection('title', 'Monitoreos Paciente'); ?>

<?php $__env->startSection('extra-css'); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css" rel="stylesheet">
<style>
    .fechas {
        background: rgb(0, 68, 117);
        color: rgb(255, 255, 255);
        margin: 5px;
        padding: 5px;
        border-radius: 5px;
        font-weight: 500;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="breadcrumb-header justify-content-between">
    <div class="left-content">
        <div>
            <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">MONITOREOS PACIENTE</h2>
        </div>
    </div>
    <div class="d-flex my-xl-auto right-content">
        <div class="pr-1 mb-3 mb-xl-0">
            <button type="button" class="btn btn-primary mr-2" id="button-modal-create"><i class="fas fa-plus"></i> Nuevo</button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-md-nowrap">
                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th style="width: 500px; ">Fecha de monitoreo</th>
                                <th>Médicos</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="monitoreos-paciente">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-create-container"></div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-js'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script>
    $(document).ready(function () {
        obtenerMonitoreoPaciente();
    });

    function obtenerMonitoreoPaciente() {
        $.ajax({
            type: "get",
            url: "/api/monitoreos-paciente",
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    dibujarMonitoreoPaciente(response.data);
                }
            }
        });
    }

    function dibujarMonitoreoPaciente(data) {
        var html = '';
        data.forEach(e => {
            html += '<tr>';
            html += '<td>'+e.paciente+'</td>';
            html += '<td style="display: flex; flex-wrap: wrap; justify-content: center">';
            e.reservaciones.sort(function (a, b) {
                if (a.date_at + ' ' + a.time_at > b.date_at + ' ' + b.time_at) {
                    return 1;
                }
                if (a.date_at + ' ' + a.time_at < b.date_at + ' ' + b.time_at) {
                    return -1;
                }
                return 0;
            });

            e.reservaciones.forEach(a => {
                html += '<div class="fechas">'+moment(a.date_at + ' ' + a.time_at).format('DD/MM/YYYY hh:mm A')+'</div>';
            });
            html += '</td>';
            html += '<td>'+e.medico+'</td>';
            html += '<td style="width:280px;">';
            html += '<button class="btn btn-danger btn-sm m-1 eliminar" data-id="'+e.id+'" data-nombre="'+e.paciente+'" type="button">Eliminar<div class="ripple-container"></div></button>';
            html += '</td>';
            html += '</tr>';
        });
        $('#monitoreos-paciente').html(html);
    }

    $('#button-modal-create').click(function (e) {
        e.preventDefault();
        var citas = [];
        var url = '/monitoreos-paciente/create';
        $('.modal-create-container').load(url, function (result) {
            inicializarSelect2();
            inicializarTimepiker();

            $('#habilitar-hora_personalizada').prop("checked", false);
            $('#hora_personalizada').prop("disabled", true)
            $('#fecha').val(moment().format('YYYY-MM-DD'));
            $('#tiempo_atencion').val('00:15:00');
            $('#hora_personalizada').val('');

            $('#medico').change(function (e) {
                e.preventDefault();
                var id_medico = $(this).val();
                medicos.forEach(e => {
                    if (e.id == id_medico) {
                        var html = '<option value="">SELECCIONE</option>';
                        e.especialidades.forEach(a => {
                            html += '<option value="'+a.id+'">'+a.name+'</option>';
                        });
                        $('#especialidad').html(html);
                    }
                });
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

            $('#fecha').blur(function (e) {
                e.preventDefault();
                obtenerCupos();
            });

            $('#habilitar-hora_personalizada').change(function (e) {
                e.preventDefault();
                if ($(this).is(':checked')) {
                    $("#horas button").each(function(){
                        $(this).addClass('btn-success');
                        $(this).removeClass('btn-primary');
                    });
                    $('#hora_personalizada').prop("disabled", false);
                } else {
                    $('#hora_personalizada').val('');
                    $('#hora_personalizada').prop("disabled", true);
                }
            })

            $('#horas').on('click', '.hora', function () {
                var hora = $(this).data('hora');
                $("#horas button").each(function(){
                    if($(this).data('hora') == hora) {
                        $("#habilitar-hora_personalizada").prop('checked', false);
                        $('#hora_personalizada').val('');
                        $('#hora_personalizada').prop("disabled", true);
                        $(this).addClass('btn-primary');
                        $(this).removeClass('btn-success');
                    } else {
                        $(this).addClass('btn-success');
                        $(this).removeClass('btn-primary');
                    }
                });
            });

            $('#guardar').click(function (e) {
                e.preventDefault();
                $('#guardar').prop("disabled", true);
                $('#guardar').html('<span class="fa fa-spinner fa-spin"></span>');
                var hora = null;
                $("#horas button").each(function(){
                    if($(this).hasClass('btn-primary')) {
                        hora = $(this).data('hora');
                    }
                });
                if (hora == null) {
                    if ($('#hora_personalizada').val() != '') {
                        hora = moment($('#hora_personalizada').val(), 'LT').format('HH:mm:ss')
                    }
                }
                var errors = [];
                var id_medico = $('#medico').val();
                var id_paciente = $('#paciente').val();
                var id_especialidad =  $('#especialidad').val();
                var fecha = $('#fecha').val();
                var tiempo_atencion = $('#tiempo_atencion').val();

                if (id_paciente == '') {
                    errors.push('PACIENTE ES REQUERIDO');
                }
                if (id_medico == '') {
                    errors.push('MEDICO ES REQUERIDO');
                }
                if (id_especialidad == '') {
                    errors.push('ESPECIALIDAD ES REQUERIDO');
                }
                if (fecha == '') {
                    errors.push('FECHA ES REQUERIDO');
                }
                if (hora == null) {
                    errors.push('HORA ES REQUERIDO');
                }
                if (tiempo_atencion == '') {
                    errors.push('TIEMPO DE ATENCION ES REQUERIDO');
                }

                if (errors.length > 0) {
                    errors.forEach(e => {
                        msmToastr('ERROR!', e, 'error');
                    });
                    $('#guardar').prop("disabled", false);
                    $('#guardar').html('Guardar');
                } else {
                    var data = {
                        id_medico,
                        id_paciente,
                        id_especialidad,
                        fecha,
                        hora,
                        tiempo_atencion,
                        medio_atencion: 'VIRTUAL',
                        tipo_atencion: 'CONSULTA',
                        monto_pagado: 0
                    };
                    $.ajax({
                        type: "post",
                        url: "https://doctor3.syslacsdev.com/api/citas",
                        data,
                        dataType: "json",
                        success: function (response) {
                            if (response.success) {
                                msmToastr('REGISTRADO!', 'SE REGISTRO CON EXITO LA CITA', 'success');
                                obtenerCitas();
                                $('#mdFormCreate').modal('hide');
                            } else {
                                response.error.forEach(e => {
                                    msmToastr('ERROR!', e, 'error');
                                });
                                $('#guardar').prop("disabled", false);
                                $('#guardar').html('Guardar');
                            }
                        }
                    });
                }
            });

            $('#guardar-monitoreo').click(function (e) {
                $(this).prop("disabled",true);
                $(this).html('<i class="fas fa-spinner fa-spin"></i>');
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
                    url: "https://eldoctor.pe/api/telemonitoreos",
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

            $('#mdFormCreate').modal({
                show: true,
                backdrop: 'static',
                // size: 'lg',
                keyboard: false
            });

            $('#mdFormProgramar').on('hidden.bs.modal', function (e) {
                $('#mdFormCreate').modal({
                    show: true,
                    backdrop: 'static',
                    // size: 'lg',
                    keyboard: false
                });
            })

            $('#programar_cita').click(function (e) {
                e.preventDefault();
                $('#mdFormCreate').modal('hide');
                obtenerCupos();
                $('#mdFormProgramar').modal({
                    show: true,
                    backdrop: 'static',
                    // size: 'lg',
                    keyboard: false
                });
            });

            $('#agregar-cita').click(function (e) {
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
                    fecha: $('#fecha').val(),
                    hora,
                    tiempo_atencion: $('#tiempo_atencion').val(),
                    medio_atencion: 'VIRTUAL',
                    tipo_atencion: 'MONITOREO',
                    monto_pagado: 0

                });
                $('#mdFormProgramar').modal('hide');
                agregarCitas();
            });

            function agregarCitas() {
                var html = '';
                citas.forEach((e,i) => {
                    html += '<div class="col-md-12">';
                    html += '<div class="card shadow rounded mt-3 p-2">';
                    html += '<div class="row">';
                    html += '<div class="col-md-9">';
                    html += '<p><label class="mr-3">Fecha y Hora:</label>'+moment(e.fecha + ' ' +e.hora).format('DD/MM/YYYY hh:mm A')+'</p>';
                    html += '</div>';
                    html += '<div class="col-md-3">';
                    html += '<button type="button" class="btn btn-danger btn-sm m-2 eliminar" data-index="'+i+'"><i class="fas fa-trash"></i></button>';
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
    });

    function inicializarSelect2() {
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
            // allowClear: true,
            closeOnSelect: true,
        });
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
            url: "/api/medicos",
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

        $.ajax({
            type: "get",
            url: "/api/pacientes",
            dataType: "json",
            success: function (response) {
                var html = '<option value="">SELECCIONE</option>';
                if (response.success) {
                    response.data.forEach(e => {
                        html += '<option value="'+e.id+'">'+e.apellidos+' '+e.nombres+'</option>';
                    });
                }
                $('#paciente').html(html);
            }
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
                var fechaActual = $('#fecha').val();
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

    $('#monitoreos-paciente').on('click', '.eliminar', function () {
        var id = $(this).data('id');
        var nombre = $(this).data('nombre');
        bootbox.dialog({
			title: "",
			message: "¿Esta seguro de Eliminar?. Se eliminaron todos los registros de monitoreo del paciente " + nombre,
			buttons: {
				cancel: {
					label: "SI",
					className: 'btn-success btn-lg',
					callback: function() {
						eliminar(id);
					}
				},
				ok: {
					label: "NO",
					className: 'btn-danger btn-lg'
				}
			}
		});
    });

	function eliminar(id) {
        $.ajax({
            type: "delete",
            url: "https://doctor3.syslacsdev.com/api/telemonitoreos/" + id,
            success: function (response) {
                if (response.success) {
                    window.location = '/monitoreos-paciente';
                }
            }
        });
	}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\PessDev\Downloads\admin-eldoctor.pe\laravel\resources\views/monitoreo-paciente/index.blade.php ENDPATH**/ ?>