@extends('layouts.main')

@section('title', 'Médicos')

@section('extra-css')

@endsection

@section('content')
<div class="breadcrumb-header justify-content-between">
    <div class="left-content">
        <div>
            <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Medicos</h2>
        </div>
    </div>
    <div class="d-flex my-xl-auto right-content">
        <div class="pr-1 mb-3 mb-xl-0">
            <button type="button" class="btn btn-primary mr-2" id="button-modal-create"><i class="fas fa-plus"></i>
                Nuevo</button>
            <a href="/api/medicos/export" class="btn btn-info"><i class="fas fa-file-excel"></i> Exportar a Excel</a>
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
                            <label for="">Médico</label>
                            <select class="form-control" id="id_medico"></select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-primary mt-4" onclick="obtenerMedicos()"><i class="fa fa-search"></i></button>
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
                                <th>Habilitado</th>
                                <th>Nombre completo</th>
                                <th>Email</th>
                                <th>Telefono</th>
                                <th>Especialidades</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="medicos"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-create-container"></div>
@endsection

@section('extra-js')

<script>
    $(document).ready(function () {
        inicializar();
    });

    function inicializar() {
        inicializarSelect2();
        obtenerMedicos();
    }

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
                    return '/api/medicos?numero_documento=' + search;
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

        $('#id_medico').select2({
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
                    return '/api/medicos?search=' + search;
                },
                processResults: function(data, params) {
                    return {
                        results: $.map(data.data, function(item) {
                            return {
                                text: `${item.lastname} ${item.name}`,
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
        $('#id_medico').val(null).trigger('change');
        $('#numero_documento').val(null).trigger('change');
        obtenerMedicos();
    }

    function obtenerMedicos() {
        var id_medico;
        var medico = $('#id_medico').val();
        var numero_documento = $('#numero_documento').val();

        if (numero_documento != null) {
            id_medico = numero_documento;
        } else {
            if (medico != null) {
                id_medico = medico;
            }
        }
        var data = {
            id_medico
        };
        $.ajax({
            type: "get",
            url: "/api/medicos",
            data: data,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    dibujarMedicos(response.data)
                }
            }
        });
    }

    function dibujarMedicos(data) {
        var html = '';
        data.forEach(e => {
            html += '<tr>';
            html += '<td>';
            html += '<input type="checkbox" id="'+e.id+'" name="check" class="medico-activo" '+ (e.is_active ? 'checked' : '')+ ' data-id-medico="'+e.id+'">';
            html += '</td>';
            html += '<td>'+e.lastname+' '+e.name+'</td>';
            html += '<td>'+e.email+'</td>';
            html += '<td>'+e.phone+'</td>';
            html += '<td>';
            e.especialidades.forEach(a => {
                html += '<li>'+a.name+'</li>';
            });
            html += '</td>';
            html += '<td style="width:280px;">';
            html += '<button type="button" class="btn btn-secondary btn-sm m-1 button-modal-historial" data-id="'+e.id+'">Historial</button>';
            html += '<button type="button" class="btn btn-warning btn-sm m-1 button-modal-edit" data-id="'+e.id+'">Editar</button>';
            // html += '<button class="btn btn-danger btn-sm m-1 eliminar" data-id="'+e.id+'" data-nombre="'+e.lastname+' '+e.name +'" type="button">Eliminar<div class="ripple-container"></div></button>';
            html += '</td>';
            html += '</tr>';
        });
        $('#medicos').html(html);
    }

    $('#button-modal-create').click(function (e) {
        e.preventDefault();
        var url = '/medicos/create';
        $('.modal-create-container').load(url, function (result) {
            $('#especialidades').select2({
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
            });

            $.ajax({
                type: "get",
                url: "/api/especialidades",
                dataType: "json",
                success: function (response) {
                    var html = '';
                    if (response.success) {
                        response.data.forEach(e => {
                            html += '<option value="'+e.id+'">'+e.name+'</option>';
                        });
                    }
                    $('#especialidades').html(html);
                }
            });

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
                var especialidades = $('#especialidades').val();
                var email = $('#email').val();
                var celular_codigo_pais = $('#celular_codigo_pais').val();
                var celular = $('#numero_celular').val();
                var password = $('#password').val();

                if (numero_documento == '') {
                    error.push('NÚMERO DOCUMENTO ES REQUERIDO');
                }
                if (apellidos == '') {
                    error.push('APELLIDOS ES REQUERIDO');
                }
                if (nombres == '') {
                    error.push('NOMBRES ES REQUERIDO');
                }
                if (especialidades.length == 0) {
                    error.push('ESPECIALIDAD ES REQUERIDO');
                }
                if (email == '') {
                    error.push('EMAIL ES REQUERIDO');
                }
                if (celular == '') {
                    error.push('NUMERO DE CELULAR ES REQUERIDO');
                }
                if (password == '') {
                    error.push('CONTRASEÑA ES REQUERIDO');
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
                        especialidades,
                        celular_codigo_pais,
                        celular,
                        password,
                    }
                    $.ajax({
                        type: "post",
                        url: "/api/medicos",
                        data,
                        dataType: "json",
                        success: function (response) {
                            if (response.success) {
                                obtenerMedicos();
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

            function obtenerDatos() {
                var dni = $('#dni').val();
                if (dni.length == 8) {
                    $('#buscar').html('<span class="fa fa-spinner fa-spin"></span>');
                    $('#buscar').attr('disabled', true);
                    $.ajax({
                        type: "GET",
                        url: "/api/medicos/dni/" + dni,
                        success: function (response) {
                            if(response.length != 0) {
                                paciente = response;
                                $('#dni').val(paciente.dni);
                                $('#nombres').val(paciente.name);
                                $('#apellidos').val(paciente.lastname);
                                $('#email').val(paciente.email);
                                $('#numero_celular').val(paciente.phone);

                                $('#especialidades').empty();
                                var especilidades_id = [];
                                paciente.especialidades.forEach(a => {
                                    especilidades_id.push(a.id);
                                    var newOption = new Option(a.name, a.id, true, true);
                                    $('#especialidades').append(newOption).trigger('change');
                                });
                                // $('#especialidades').val(especilidades_id).trigger('change');

                                $('#nombres').attr('readonly', true);
                                $('#apellidos').attr('readonly', true);
                                $('#email').attr('readonly', true);
                                $('#especialidades').attr('disabled', true);
                                $('#numero_celular').attr('readonly', true);
                                $('#buscar').html('<i class="fas fa-search"></i>');
                                $('#buscar').attr('disabled', false);
                            } else {
                                $.ajax({
                                    type: "GET",
                                    url: 'https://apis4.facttu.com/reniec/personas/' + dni,
                                    dataType: "json",
                                    success: function(response) {
                                        var persona = response.persona;
                                        $('#dni').val(persona.dni);
                                        $('#nombres').val(persona.nombres);
                                        $('#apellidos').val(persona.apellido_paterno + ' ' + persona.apellido_materno);
                                        $('#nombres').attr('readonly', true);
                                        $('#apellidos').attr('readonly', true);
                                        $('#email').attr('readonly', false);
                                        $('#numero_celular').attr('readonly', false);
                                        $('#buscar').attr('disabled', false);
                                        $('#buscar').html('<i class="fas fa-search"></i>');
                                    }
                                });
                            }
                        }
                    });
                }
            }
        });
    });

    $('#medicos').on('click', '.button-modal-historial', function () {
        var url = '/medicos/historial/' + $(this).data('id');
        $('.modal-create-container').load(url, function (result) {
            $('#mdHistorial').modal({
                show: true,
                backdrop: 'static',
                // size: 'lg',
                keyboard: false
            });
        });
    });

    $('#medicos').on('click', '.button-modal-edit', function () {
        var id =  $(this).data('id');
        var url = '/medicos/create';
        $('.modal-create-container').load(url, function (result) {
            // $('.ocultar').hide();
            $('#especialidades').select2({
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
            });
            $('#text-password').html('Ingrese nueva contraseña si quiere cambiar');

            $('#mdFormCreate').modal({
                show: true,
                backdrop: 'static',
                // size: 'lg',
                keyboard: false
            });
            $.ajax({
                type: "get",
                url: "/api/medicos/" + id,
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        var especialidades = response.data.especialidades;
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
                        $('#apellidos').val(response.data.lastname);
                        $('#nombres').val(response.data.name);
                        $('#email').val(response.data.email);
                        $('#numero_celular').val(response.data.phone);
                        $('#celular_codigo_pais').val(response.data.celular_codigo_pais);

                        $('#especialidades').empty();
                        $.ajax({
                            type: "get",
                            url: "/api/especialidades",
                            dataType: "json",
                            success: function (response) {
                                var html = '';
                                if (response.success) {
                                    response.data.forEach(e => {
                                        html += '<option value="'+e.id+'">'+e.name+'</option>';
                                    });
                                }
                                $('#especialidades').html(html);
                                var especilidades_id = [];
                                especialidades.forEach(a => {
                                    especilidades_id.push(a.id);
                                });
                                $('#especialidades').val(especilidades_id).trigger('change');
                            }
                        });

                        $('#tipo_documento').attr('disabled', true);
                        $('#dni').attr('readonly', true);
                        $('#numero_documento').attr('readonly', true);
                        $('#buscar').attr('disabled', true);
                        $('#nombres').attr('readonly', true);
                        $('#apellidos').attr('readonly', true);
                    }
                }
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
                var especialidades = $('#especialidades').val();
                var email = $('#email').val();
                var celular_codigo_pais = $('#celular_codigo_pais').val();
                var celular = $('#numero_celular').val();
                var password = $('#password').val();

                if (numero_documento == '') {
                    error.push('NÚMERO DOCUMENTO ES REQUERIDO');
                }
                if (apellidos == '') {
                    error.push('APELLIDOS ES REQUERIDO');
                }
                if (nombres == '') {
                    error.push('NOMBRES ES REQUERIDO');
                }
                if (especialidades.length == 0) {
                    error.push('ESPECIALIDAD ES REQUERIDO');
                }
                if (email == '') {
                    error.push('EMAIL ES REQUERIDO');
                }
                if (celular == '') {
                    error.push('NUMERO DE CELULAR ES REQUERIDO');
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
                        especialidades,
                        celular_codigo_pais,
                        celular,
                        password,
                    }

                    $.ajax({
                        type: "put",
                        url: "/api/medicos/" + id,
                        data,
                        dataType: "json",
                        success: function (response) {
                            if (response.success) {
                                obtenerMedicos();
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

    $('#medicos').on('click', '.medico-activo', function () {
        var medic_id = $(this).data('id-medico');
		var is_active = null;
		if ($(this).prop('checked')) {
			is_active = 1;
		} else {
			is_active = 0;
        }
        console.log(is_active);
        $.ajax({
            type: "put",
            url: "/api/medicos/active/" + medic_id,
            data: {
                is_active
            },
            dataType: "json",
            success: function (response) { }
        });
    });

    $('#medicos').on('click', '.eliminar', function () {
        var id = $(this).data('id');
        var nombre = $(this).data('nombre');
        bootbox.dialog({
			title: "",
			message: "Esta seguro de Eliminar " + nombre,
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
            url: "/api/medicos/" + id,
            success: function (response) {
                if (response.success) {
                    obtenerMedicos();
                }
            }
        });
	}
</script>
@endsection
