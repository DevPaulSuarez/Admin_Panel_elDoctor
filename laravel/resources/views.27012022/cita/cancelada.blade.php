@extends('layouts.main')

@section('title', 'Citas')

@section('extra-css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="breadcrumb-header justify-content-between">
    <div class="left-content">
        <div>
            <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Citas Canceladas</h2>
        </div>
    </div>
    <div class="d-flex my-xl-auto right-content">
        <div class="pr-1 mb-3 mb-xl-0">
            {{-- <button type="button" class="btn btn-primary mr-2" id="button-modal-create"><i class="fas fa-plus"></i> Nuevo</button> --}}
            <a href="/api/citas/export/canceladas" class="btn btn-info"><i class="fas fa-file-excel"></i> Exportar a Excel</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">N° de documento</label>
                            <select class="form-control" id="numero_documento"></select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Paciente</label>
                            <select class="form-control" id="id_paciente"></select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-primary mt-4" onclick="obtenerCitas()"><i class="fa fa-search"></i></button>
                        <button type="button" class="btn btn-primary mt-4" onclick="limpiarBusqueda()"><i class="fa fa-search"></i> Nueva busqueda</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-md-nowrap">
                        <thead>
                            <tr>
                                <th>Fecha y hora</th>
                                <th>Medio de atención</th>
                                <th>Tipo de paciente</th>
                                <th>Paciente</th>
                                <th>Consulta</th>
                                <th>Medico</th>
                                <th>Fecha de creación</th>
                                <th>Tipo Registrador</th>
                                <th>Nombre Registrador</th>
                                {{-- <th></th> --}}
                            </tr>
                        </thead>
                        <tbody id="citas"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-create-container"></div>
@endsection

@section('extra-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script>
    var medicos = [];
    $(document).ready(function () {
        inicializarSelect2();
        obtenerCitas();
    });

    function inicializarSelect2() {
        $('#numero_documento').select2({
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
                url: function (params) {
                    var search = '';
                    if(params.term != undefined) {
                        search = params.term;
                    }
                    return '/api/pacientes?numero_documento=' + search;
                },
                processResults: function(data, params) {
                    return {
                        results: $.map(data.data, function(item) {
                            return {
                                text: item.numero_documento,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            },
        });

        $('#id_paciente').select2({
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
                url: function (params) {
                    var search = '';
                    if(params.term != undefined) {
                        search = params.term;
                    }
                    return '/api/pacientes?search=' + search;
                },
                processResults: function(data, params) {
                    return {
                        results: $.map(data.data, function(item) {
                            return {
                                text: `${item.apellidos} ${item.nombres}`,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            },
        });
    }

    function limpiarBusqueda() {
        $('#id_paciente').val(null).trigger('change');
        $('#numero_documento').val(null).trigger('change');
        obtenerCitas();
    }

    function obtenerCitas() {
        var data = {
            fecha_inicio: $('#fecha_inicio').val(),
            fecha_fin: $('#fecha_fin').val(),
            paciente_id: ($('#id_paciente').val() != null ? $('#id_paciente').val() : $('#numero_documento').val()),
            estado: 'CANCELADO'
        }
        $.ajax({
            type: "get",
            url: "/api/citas",
            data,
            dataType: "json",
            success: function (response) {
                dibujarCitas(response);
            }
        });
    }

    function dibujarCitas(data) {
        var html = '';
        data.forEach(e => {
            html += '<tr>';
            html += '<td>'+moment(e.date_at+' '+e.time_at).format('DD/MM/YYYY hh:mm A')+'</td>';
            html += '<td>'+e.medio_atencion+'</td>';
            html += '<td>'+e.tipo_paciente+'</td>';
            html += '<td>'+e.paciente+'</td>';
            html += '<td>'+(e.descripcion_tipo_consulta == null ? '' : e.descripcion_tipo_consulta)+'</td>';
            html += '<td>'+e.medico+'</td>';
            html += '<td>'+moment(e.fecha_creacion).format('DD/MM/YYYY hh:mm A')+'</td>';
            html += '<td>'+(e.tipo_usuario == null ? '' : e.tipo_usuario)+'</td>';
            html += '<td>'+(e.registrador_nombre == null ? '' : e.registrador_nombre)+'</td>';
            // html += '<td style="width:280px;">';
            // html += '<button type="button" class="btn btn-warning btn-sm m-1 button-modal-edit" data-id="'+e.id+'">Editar</button>';
            // html += '<button type="button" class="btn btn-danger btn-sm eliminar" data-id="'+e.id+'">Eliminar</button>';
            // html += '</td>';
            html += '</tr>';
        });
        $('#citas').html(html);
    }

    // $('#button-modal-create').click(function (e) {
    //     e.preventDefault();
    //     var url = '/citas/create';
    //     $('.modal-create-container').load(url, function (result) {
    //         inicializarSelect2();
    //         inicializarTimepiker();

    //         $('#habilitar-hora_personalizada').prop("checked", false);
    //         $('#hora_personalizada').prop("disabled", true)
    //         $('#fecha').val(moment().format('YYYY-MM-DD'));
    //         $('#tiempo_atencion').val('00:15:00');
    //         $('#hora_personalizada').val('');

    //         $('#medico').change(function (e) {
    //             e.preventDefault();
    //             var id_medico = $(this).val();
    //             medicos.forEach(e => {
    //                 if (e.id == id_medico) {
    //                     var html = '<option value="">SELECCIONE</option>';
    //                     e.especialidades.forEach(a => {
    //                         html += '<option value="'+a.id+'">'+a.name+'</option>';
    //                     });
    //                     $('#especialidad').html(html);
    //                 }
    //             });
    //         });

    //         $('#especialidad').change(function (e) {
    //             e.preventDefault();
    //             obtenerCupos();
    //         });

    //         $('#fecha').blur(function (e) {
    //             e.preventDefault();
    //             obtenerCupos();
    //         });

    //         $('#habilitar-hora_personalizada').change(function (e) {
    //             e.preventDefault();
    //             if ($(this).is(':checked')) {
    //                 $("#horas button").each(function(){
    //                     $(this).addClass('btn-success');
    //                     $(this).removeClass('btn-primary');
    //                 });
    //                 $('#hora_personalizada').prop("disabled", false);
    //             } else {
    //                 $('#hora_personalizada').val('');
    //                 $('#hora_personalizada').prop("disabled", true);
    //             }
    //         })

    //         $('#horas').on('click', '.hora', function () {
    //             var hora = $(this).data('hora');
    //             $("#horas button").each(function(){
    //                 if($(this).data('hora') == hora) {
    //                     $("#habilitar-hora_personalizada").prop('checked', false);
    //                     $('#hora_personalizada').val('');
    //                     $('#hora_personalizada').prop("disabled", true);
    //                     $(this).addClass('btn-primary');
    //                     $(this).removeClass('btn-success');
    //                 } else {
    //                     $(this).addClass('btn-success');
    //                     $(this).removeClass('btn-primary');
    //                 }
    //             });
    //         });

    //         $('#guardar').click(function (e) {
    //             e.preventDefault();
    //             $('#guardar').prop("disabled", true);
    //             $('#guardar').html('<span class="fa fa-spinner fa-spin"></span>');
    //             var hora = null;
    //             $("#horas button").each(function(){
    //                 if($(this).hasClass('btn-primary')) {
    //                     hora = $(this).data('hora');
    //                 }
    //             });
    //             if (hora == null) {
    //                 if ($('#hora_personalizada').val() != '') {
    //                     hora = moment($('#hora_personalizada').val(), 'LT').format('HH:mm:ss')
    //                 }
    //             }
    //             var errors = [];
    //             var id_medico = $('#medico').val();
    //             var id_paciente = $('#paciente').val();
    //             var id_especialidad =  $('#especialidad').val();
    //             var fecha = $('#fecha').val();
    //             var tiempo_atencion = $('#tiempo_atencion').val();

    //             if (id_paciente == '') {
    //                 errors.push('PACIENTE ES REQUERIDO');
    //             }
    //             if (id_medico == '') {
    //                 errors.push('MEDICO ES REQUERIDO');
    //             }
    //             if (id_especialidad == '') {
    //                 errors.push('ESPECIALIDAD ES REQUERIDO');
    //             }
    //             if (fecha == '') {
    //                 errors.push('FECHA ES REQUERIDO');
    //             }
    //             if (hora == null) {
    //                 errors.push('HORA ES REQUERIDO');
    //             }
    //             if (tiempo_atencion == '') {
    //                 errors.push('TIEMPO DE ATENCION ES REQUERIDO');
    //             }

    //             if (errors.length > 0) {
    //                 errors.forEach(e => {
    //                     msmToastr('ERROR!', e, 'error');
    //                 });
    //                 $('#guardar').prop("disabled", false);
    //                 $('#guardar').html('Guardar');
    //             } else {
    //                 var data = {
    //                     id_medico,
    //                     id_paciente,
    //                     id_especialidad,
    //                     fecha,
    //                     hora,
    //                     tiempo_atencion,
    //                     medio_atencion: 'VIRTUAL',
    //                     tipo_atencion: 'CONSULTA',
    //                     monto_pagado: 0
    //                 };
    //                 $.ajax({
    //                     type: "post",
    //                     url: "https://doctor3.syslacsdev.com/api/citas",
    //                     data,
    //                     dataType: "json",
    //                     success: function (response) {
    //                         if (response.success) {
    //                             msmToastr('REGISTRADO!', 'SE REGISTRO CON EXITO LA CITA', 'success');
    //                             obtenerCitas();
    //                             $('#mdFormCreate').modal('hide');
    //                         } else {
    //                             response.error.forEach(e => {
    //                                 msmToastr('ERROR!', e, 'error');
    //                             });
    //                             $('#guardar').prop("disabled", false);
    //                             $('#guardar').html('Guardar');
    //                         }
    //                     }
    //                 });
    //             }
    //         });

    //         $('#mdFormCreate').modal({
    //             show: true,
    //             backdrop: 'static',
    //             // size: 'lg',
    //             keyboard: false
    //         });
    //     });
    // });

    // function inicializarSelect2() {
    //     $('#paciente').select2({
    //         placeholder: 'SELECCIONA',
    //         width: '100%',
    //         searchInputPlaceholder: 'Buscar...',
    //         language: {
    //             noResults: function () {
    //                 return "No hay resultado";
    //             },
    //             searching: function () {
    //                 return "Buscando..";
    //             }
    //         },
    //         // allowClear: true,
    //         closeOnSelect: true,
    //     });
    //     $('#medico').select2({
    //         placeholder: 'SELECCIONA',
    //         width: '100%',
    //         searchInputPlaceholder: 'Buscar...',
    //         language: {
    //             noResults: function () {
    //                 return "No hay resultado";
    //             },
    //             searching: function () {
    //                 return "Buscando..";
    //             }
    //         },
    //         // allowClear: true,
    //         closeOnSelect: true,
    //     });
    //     $('#especialidad').select2({
    //         placeholder: 'SELECCIONA',
    //         width: '100%',
    //         searchInputPlaceholder: 'Buscar...',
    //         language: {
    //             noResults: function () {
    //                 return "No hay resultado";
    //             },
    //             searching: function () {
    //                 return "Buscando..";
    //             }
    //         },
    //         // allowClear: true,
    //         closeOnSelect: true,
    //     });

    //     $.ajax({
    //         type: "get",
    //         url: "/api/medicos",
    //         dataType: "json",
    //         success: function (response) {
    //             var html = '<option value="">SELECCIONE</option>';
    //             if (response.success) {
    //                 medicos = response.data;
    //                 response.data.forEach(e => {
    //                     html += '<option value="'+e.id+'">'+e.lastname+' '+e.name+'</option>';
    //                 });
    //             }
    //             $('#medico').html(html);
    //         }
    //     });

    //     $.ajax({
    //         type: "get",
    //         url: "/api/pacientes",
    //         dataType: "json",
    //         success: function (response) {
    //             var html = '<option value="">SELECCIONE</option>';
    //             if (response.success) {
    //                 response.data.forEach(e => {
    //                     html += '<option value="'+e.id+'">'+e.apellidos+' '+e.nombres+'</option>';
    //                 });
    //             }
    //             $('#paciente').html(html);
    //         }
    //     });

    // }

    // function inicializarTimepiker() {
    //     $('#hora_personalizada').timepicker({
    //         timeFormat: 'h:mm p',
    //         minTime: '06:00:00',
    //         maxHour: 22,
    //         maxMinutes: 00,
    //         startTime: new Date(0,0,0,6,0,0),
    //         interval: 15,
    //         dynamic: false,
    //         dropdown: true,
    //         scrollbar: true,
    //         zindex: 999999
    //     });
    //     $('#tiempo_atencion').timepicker({
    //         timeFormat: 'HH:mm:ss',
    //         minTime: '00:15:00',
    //         maxHour: 2,
    //         maxMinutes: 00,
    //         startTime: new Date(0,0,0,0,15,0),
    //         interval: 15,
    //         dynamic: false,
    //         dropdown: true,
    //         scrollbar: true,
    //         zindex: 999999,
    //         change: function(time) {
    //             obtenerCupos();
    //         }
    //     });
    // }

    // function obtenerCupos() {
    //     var data = {
    //         id_medico: $('#medico').val(),
    //         id_especialidad: $('#especialidad').val(),
    //         medio_atencion: 'VIRTUAL',
    //         tiempo_atencion: $('#tiempo_atencion').val(),
    //     }
    //     $.ajax({
    //         type: "get",
    //         url: 'https://doctor3.syslacsdev.com/api/medico/horario',
    //         data: data,
    //         dataType: "json",
    //         success: function (response) {
    //             var fechaActual = $('#fecha').val();
    //             var horaActual = moment().format('HH:mm:ss');
    //             var horarios = [];
    //             var horas = '';
    //             if(response.length > 0) {
    //                 horarios = response.filter(e => {
    //                     if (e.fecha == fechaActual && e.inicio > horaActual) {
    //                         return e;
    //                     } else if (e.fecha > fechaActual) {
    //                         return e;
    //                     }
    //                 });

    //                 if(horarios.length > 0) {
    //                     horarios.forEach(h => {
    //                         horas += '<button type="button" class="btn btn-success btn-sm m-2 hora" data-hora="'+h.inicio+'">'+moment(h.inicio, 'HH:mm:ss').format('hh:mm A')+'</button>';
    //                     });
    //                 } else {
    //                     horas += 'NO HAY HORARIOS DISPONIBLES';
    //                 }
    //             } else {
    //                 horas += 'NO HAY HORARIOS DISPONIBLES';
    //             }
    //             $('#horas').html(horas);
    //         }
    //     });
    // }

    // $('#citas').on('click', '.eliminar', function () {
    //     var id = $(this).data('id');
    //     bootbox.dialog({
	// 		title: "",
	// 		message: "Esta seguro de Eliminar",
	// 		buttons: {
	// 			cancel: {
	// 				label: "SI",
	// 				className: 'btn-success btn-lg',
	// 				callback: function() {
	// 					eliminar(id);
	// 				}
	// 			},
	// 			ok: {
	// 				label: "NO",
	// 				className: 'btn-danger btn-lg'
	// 			}
	// 		}
	// 	});
    // });

	// function eliminar(id) {
    //     $.ajax({
    //         type: "delete",
    //         url: "/citas/" + id,
    //         success: function (response) {
    //             if (response.success) {
    //                 obtenerCitas();
    //             }
    //         }
    //     });
	// }
</script>
@endsection
