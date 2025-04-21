<?php $__env->startSection('title', 'Pacientes'); ?>

<?php $__env->startSection('extra-css'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="breadcrumb-header justify-content-between">
    <div class="left-content">
        <div>
            <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Pacientes</h2>
        </div>
    </div>
    <div class="d-flex my-xl-auto right-content">
        <div class="pr-1 mb-3 mb-xl-0">
            <button type="button" class="btn btn-primary mr-2" id="button-modal-create"><i class="fas fa-plus"></i> Nuevo</button>
            <a href="/api/pacientes/export" class="btn btn-info"><i class="fas fa-file-excel"></i> Exportar a Excel</a>
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
                        <button type="button" class="btn btn-primary mt-4" onclick="obtenerPacientes()"><i class="fa fa-search"></i></button>
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
                                <th>Nombre completo</th>
                                <th>Email</th>
                                <th>Telefono</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="pacientes">
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
<script>
    $(document).ready(function () {
        inicializarSelect2();
        obtenerPacientes();
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
        obtenerPacientes();
    }

    function obtenerPacientes() {
        var id_paciente;
        var paciente = $('#id_paciente').val();
        var numero_documento = $('#numero_documento').val();

        if (numero_documento != null) {
            id_paciente = numero_documento;
        } else {
            if (paciente != null) {
                id_paciente = paciente;
            }
        }

        var data = {
            id_paciente
        };
        $.ajax({
            type: "get",
            url: "/api/pacientes",
            data,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    dibujarPacientes(response.data)
                }
            }
        });
    }

    function dibujarPacientes(data) {
        var html = '';
        data.forEach(e => {
            html += '<tr>';
            html += '<td>'+e.apellidos+' '+e.nombres+'</td>';
            html += '<td>'+e.email+'</td>';
            html += '<td>'+e.celular+'</td>';
            html += '<td style="width:280px;">';
            html += '<button type="button" class="btn btn-secondary btn-sm m-1 button-modal-historial" data-id="'+e.id+'">Historial</button>';
            html += '<button type="button" class="btn btn-warning btn-sm m-1 button-modal-edit" data-id="'+e.id+'">Editar</button>';
            html += '<button type="button" class="btn btn-danger btn-sm m-1 button-modal-pass" data-id="'+e.id+'" onclick="cambiarPass('+e.id+')"><i class="fas fa-key"></i></button>';
            // html += '<button class="btn btn-danger btn-sm m-1 eliminar" data-id="'+e.id+'" data-nombre="'+e.apellidos+' '+e.nombres +'" type="button">Eliminar<div class="ripple-container"></div></button>';
            html += '</td>';
            html += '</tr>';
        });
        $('#pacientes').html(html);
    }

    function cambiarPass(id) {
        var url = `/pacientes/pass/${id}`;
        $('.modal-create-container').load(url, function (result) {
            $('#modal-pass').modal({
                show: true,
                backdrop: 'static',
                size: 'lg',
                keyboard: false
            });
            // inicializarForm();
        });
    }

    $('#button-modal-create').click(function (e) {
        e.preventDefault();
        var url = '/pacientes/create';
        $('.modal-create-container').load(url, function (result) {
            $('#mdFormCreate').modal({
                show: true,
                backdrop: 'static',
                // size: 'lg',
                keyboard: false
            });

            $('#guardar').click(function (e) {
                e.preventDefault();
                $('#guardar').html('<i class="fas fa-spinner fa-spin"></i>');
                $('#guardar').attr('disabled', true);
                var error = [];

                var tipo_documento = $('#tipo_documento').val();
                var numero_documento = (tipo_documento == 'DNI' ? $('#dni').val() : $('#numero_documento').val());

                var apellidos = $('#apellidos').val();
                var nombres = $('#nombres').val();
                var email = $('#email').val();
                var celular_codigo_pais = $('#celular_codigo_pais').val();
                var celular = $('#numero_celular').val();

                if (numero_documento == '') {
                    error.push('NÚMERO DOCUMENTO ES REQUERIDO');
                }
                if (apellidos == '') {
                    error.push('APELLIDOS ES REQUERIDO');
                }
                if (nombres == '') {
                    error.push('APELLIDOS ES REQUERIDO');
                }
                if (email == '') {
                    error.push('APELLIDOS ES REQUERIDO');
                }
                if (celular == '') {
                    error.push('APELLIDOS ES REQUERIDO');
                }
                if (error.length > 0) {
                    error.forEach(e => {
                        msmToastr('ERROR!', e, 'error');
                    });
                    $('#guardar').html('Guardar');
                    $('#guardar').attr('disabled', false);
                } else {
                    var data = {
                        tipo_documento,
                        numero_documento,
                        apellidos: (apellidos != '' ? apellidos.toUpperCase() : null),
                        nombres: (nombres != '' ? nombres.toUpperCase() : null),
                        email: (email != '' ? email.toLowerCase() : null),
                        celular_codigo_pais,
                        celular
                    }

                    $.ajax({
                        type: "post",
                        url: "/api/pacientes",
                        data,
                        dataType: "json",
                        success: function (response) {
                            if (response.success) {
                                obtenerPacientes();
                                $('#mdFormCreate').modal('hide');
                            } else {
                                response.error.forEach(e => {
                                    msmToastr('ERROR!', e, 'error');
                                });
                            }
                            $('#guardar').html('Guardar');
                            $('#guardar').attr('disabled', false);
                        }
                    });
                }
            });

            $('#dni').keypress(function (e) {
                var key = window.Event ? e.which : e.keyCode;
                if (key == 13) {
                    obtenerDatos();
                }

                if (key < 48 || key > 57) {
                    return false;
                }
            });

            $('#buscar').click(function (e) {
                e.preventDefault();
                obtenerDatos();
            });


        });
    });

    function obtenerDatos() {
        var dni = $('#dni').val();
        if (dni.length == 8) {
            $('#buscar').html('<span class="fa fa-spinner fa-spin"></span>');
            $('#buscar').attr('disabled', true);
            $.ajax({
                type: "GET",
                url: "/api/pacientes/dni/" + dni,
                success: function (response) {
                    if(response.length != 0) {
                        paciente = response[0];
                        $('#dni').val(paciente.numero_documento);
                        $('#nombres').val(paciente.nombres);
                        $('#apellidos').val(paciente.apellidos);
                        $('#email').val(paciente.email);
                        $('#numero_celular').val(paciente.celular);

                        // $('#nombres').attr('readonly', true);
                        // $('#apellidos').attr('readonly', true);
                        // $('#email').attr('readonly', true);
                        // $('#numero_celular').attr('readonly', true);
                        $('#buscar').html('<i class="fas fa-search"></i>');
                        $('#buscar').attr('disabled', false);
                    } else {
                        $.ajax({
                            type: "GET",
                            url: 'https://apis4.facttu.com/reniec/personas/' + dni,
                            dataType: "json",
                            success: function(response) {
                                if (response.success) {
                                    var persona = response.persona;
                                    $('#dni').val(persona.dni);
                                    $('#nombres').val(persona.nombres);
                                    $('#apellidos').val(persona.apellido_paterno + ' ' + persona.apellido_materno);
                                    // $('#nombres').attr('readonly', true);
                                    // $('#apellidos').attr('readonly', true);
                                    // $('#email').attr('readonly', false);
                                    // $('#numero_celular').attr('readonly', false);
                                    $('#buscar').attr('disabled', false);
                                    $('#buscar').html('<i class="fas fa-search"></i>');
                                }
                            }
                        });
                    }
                }
            });
        }
    }

    $('#pacientes').on('click', '.button-modal-historial', function () {
        var url = '/pacientes/historial/' + $(this).data('id');
        $('.modal-create-container').load(url, function (result) {
            $('#mdHistorial').modal({
                show: true,
                backdrop: 'static',
                size: 'lg',
                keyboard: false
            });
        });
    });

    $('#pacientes').on('click', '.button-modal-edit', function () {
        var id =  $(this).data('id');
        var url = '/pacientes/create';
        $('.modal-create-container').load(url, function (result) {
            $('#mdFormCreate').modal({
                show: true,
                backdrop: 'static',
                // size: 'lg',
                keyboard: false
            });
            $.ajax({
                type: "get",
                url: "/api/pacientes/" + id,
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        $('#tipo_documento').val(response.data.tipo_documento);
                        if (response.data.tipo_documento == 'DNI') {
                            $('#dni').val(response.data.numero_documento);
                            $('.is_dni').show();
                            $('.no_is_dni').hide();
                        } else {
                            $('#numero_documento').val(response.data.numero_documento);
                            $('.is_dni').hide();
                            $('.no_is_dni').show();
                        }
                        $('#apellidos').val(response.data.apellidos);
                        $('#nombres').val(response.data.nombres);
                        $('#email').val(response.data.email);
                        $('#numero_celular').val(response.data.celular);
                        $('#celular_codigo_pais').val(response.data.celular_codigo_pais);

                        // $('#tipo_documento').attr('disabled', true);
                        // $('#dni').attr('readonly', true);
                        // $('#numero_documento').attr('readonly', true);
                        // $('#buscar').attr('disabled', true);
                        // $('#nombres').attr('readonly', true);
                        // $('#apellidos').attr('readonly', true);
                    }
                }
            });

            $('#dni').keypress(function (e) {
                var key = window.Event ? e.which : e.keyCode;
                if (key == 13) {
                    obtenerDatos();
                }

                if (key < 48 || key > 57) {
                    return false;
                }
            });

            $('#buscar').click(function (e) {
                e.preventDefault();
                obtenerDatos();
            });

            $('#guardar').click(function (e) {
                e.preventDefault();
                $('#guardar').html('<i class="fas fa-spinner fa-spin"></i>');
                $('#guardar').attr('disabled', true);
                var error = [];

                var tipo_documento = $('#tipo_documento').val();
                var numero_documento = (tipo_documento == 'DNI' ? $('#dni').val() : $('#numero_documento').val());

                var apellidos = $('#apellidos').val();
                var nombres = $('#nombres').val();
                var email = $('#email').val();
                var celular = $('#numero_celular').val();
                var celular_codigo_pais = $('#celular_codigo_pais').val();

                if (numero_documento == '') {
                    error.push('NÚMERO DOCUMENTO ES REQUERIDO');
                }
                if (apellidos == '') {
                    error.push('APELLIDOS ES REQUERIDO');
                }
                if (nombres == '') {
                    error.push('APELLIDOS ES REQUERIDO');
                }
                if (email == '') {
                    error.push('APELLIDOS ES REQUERIDO');
                }
                if (celular == '') {
                    error.push('APELLIDOS ES REQUERIDO');
                }
                if (error.length > 0) {
                    error.forEach(e => {
                        msmToastr('ERROR!', e, 'error');
                    });
                    $('#guardar').html('Guardar');
                    $('#guardar').attr('disabled', false);
                } else {
                    var data = {
                        tipo_documento,
                        numero_documento,
                        apellidos: (apellidos != '' ? apellidos.toUpperCase() : null),
                        nombres: (nombres != '' ? nombres.toUpperCase() : null),
                        email: (email != '' ? email.toLowerCase() : null),
                        celular_codigo_pais,
                        celular
                    }

                    $.ajax({
                        type: "put",
                        url: "/api/pacientes/" + id,
                        data,
                        dataType: "json",
                        success: function (response) {
                            if (response.success) {
                                obtenerPacientes();
                                $('#mdFormCreate').modal('hide');
                            } else {
                                response.error.forEach(e => {
                                    msmToastr('ERROR!', e, 'error');
                                });
                            }
                            $('#guardar').html('Guardar');
                            $('#guardar').attr('disabled', false);
                        }
                    });
                }
            });
        });
    });

    $('#pacientes').on('click', '.eliminar', function () {
        var id = $(this).data('id');
        var nombre = $(this).data('nombre');
        bootbox.dialog({
			title: "",
			message: "Esta seguro de Eliminar al paciente " + nombre + " se eliminara todas sus citas.",
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
            url: "/api/pacientes/" + id,
            success: function (response) {
                if (response.success) {
                    obtenerPacientes();
                }
            }
        });
	}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\PessDev\Downloads\admin-eldoctor.pe\laravel\resources\views/paciente/index.blade.php ENDPATH**/ ?>