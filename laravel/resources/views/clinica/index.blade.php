@extends('layouts.main')

@section('title', 'Médicos')

@section('extra-css')

@endsection

@section('content')
<div class="breadcrumb-header justify-content-between">
    <div class="left-content">
        <div>
            <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Instituciones</h2>
        </div>
    </div>
    <div class="d-flex my-xl-auto right-content">
        <div class="pr-1 mb-3 mb-xl-0">
            <button type="button" class="btn btn-primary mr-2" id="button-modal-create"><i class="fas fa-plus"></i> Nuevo</button>
            <a href="/api/clinicas/export" class="btn btn-info"><i class="fas fa-file-excel"></i> Exportar a Excel</a>
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
                                <th>Habilitado</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Telefono</th>
                                <th>Dirección</th>
                                <th>Logo</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="clinicas"></tbody>
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
        obtenerClinicas();
    });

    function obtenerClinicas() {
        $.ajax({
            type: "get",
            url: "/api/clinicas",
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    dibujarClinicas(response.data)
                }
            }
        });
    }

    function dibujarClinicas(data) {
        var html = '';
        data.forEach(e => {
            html += '<tr>';
            html += '<td>';
            html += '<input type="checkbox" id="'+e.id+'" name="check" class="clinica-activo" '+ (e.is_active ? 'checked' : '')+ ' data-id-clinica="'+e.id+'">';
            html += '</td>';
            html += '<td>'+e.nombre+'</td>';
            html += '<td>'+e.email+'</td>';
            html += '<td>'+e.telefono+'</td>';
            html += '<td>'+e.direccion+'</td>';
            html += '<td>'+e.logo+'</td>';
            html += '<td style="width:280px;">';
            html += '<button type="button" class="btn btn-warning btn-sm m-1 button-modal-edit" data-id="'+e.id+'">Editar</button>';
            html += '<button class="btn btn-danger btn-sm m-1 eliminar" data-id="'+e.id+'" data-nombre="'+e.nombre +'" type="button">Eliminar<div class="ripple-container"></div></button>';
            html += '</td>';
            html += '</tr>';
        });
        $('#clinicas').html(html);
    }

    $('#button-modal-create').click(function (e) {
        e.preventDefault();
        var url = '/instituciones/create';
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
                var error = [];

                var dni = $('#dni').val();
                var apellidos = $('#apellidos').val();
                var nombres = $('#nombres').val();
                var especialidades = $('#especialidades').val();
                var email = $('#email').val();
                var numero_celular = $('#numero_celular').val();
                var password = $('#password').val();

                if (dni == '') {
                    error.push('DNI ES REQUERIDO');
                }
                if (apellidos == '') {
                    error.push('APELLIDOS ES REQUERIDO');
                }
                if (nombres == '') {
                    error.push('APELLIDOS ES REQUERIDO');
                }
                if (especialidades.length == 0) {
                    error.push('ESPECIALIDAD ES REQUERIDO');
                }
                if (email == '') {
                    error.push('APELLIDOS ES REQUERIDO');
                }
                if (numero_celular == '') {
                    error.push('APELLIDOS ES REQUERIDO');
                }
                if (password == '') {
                    error.push('CONTRASEÑA ES REQUERIDO');
                }
                if (error.length > 0) {
                    error.forEach(e => {
                        msmToastr('ERROR!', e, 'error');
                    });
                } else {
                    var data = {
                        dni,
                        apellidos,
                        nombres,
                        especialidades,
                        email,
                        numero_celular,
                        password
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

    $('#clinicas').on('click', '.button-modal-edit', function () {
        var id =  $(this).data('id');
        var url = '/instituciones/create';
        $('.modal-create-container').load(url, function (result) {
            $('.ocultar').hide();
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
                        $('#dni').val(response.data.dni);
                        $('#apellidos').val(response.data.lastname);
                        $('#nombres').val(response.data.name);
                        $('#email').val(response.data.email);
                        $('#numero_celular').val(response.data.phone);

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
                                    // var newOption = new Option(a.name, a.id, true, true);
                                    // $('#especialidades').append(newOption).trigger('change');
                                });
                                $('#especialidades').val(especilidades_id).trigger('change');
                            }
                        });

                        $('#dni').attr('readonly', true);
                        $('#buscar').attr('disabled', true);
                        $('#nombres').attr('readonly', true);
                        $('#apellidos').attr('readonly', true);
                    }
                }
            });

            $('#guardar').click(function (e) {
                e.preventDefault();
                var error = [];

                var dni = $('#dni').val();
                var apellidos = $('#apellidos').val();
                var nombres = $('#nombres').val();
                var especialidades = $('#especialidades').val();
                var email = $('#email').val();
                var numero_celular = $('#numero_celular').val();

                if (dni == '') {
                    error.push('DNI ES REQUERIDO');
                }
                if (apellidos == '') {
                    error.push('APELLIDOS ES REQUERIDO');
                }
                if (nombres == '') {
                    error.push('APELLIDOS ES REQUERIDO');
                }
                if (especialidades.length == 0) {
                    error.push('ESPECIALIDAD ES REQUERIDO');
                }
                if (email == '') {
                    error.push('APELLIDOS ES REQUERIDO');
                }
                if (numero_celular == '') {
                    error.push('APELLIDOS ES REQUERIDO');
                }
                if (error.length > 0) {
                    error.forEach(e => {
                        msmToastr('ERROR!', e, 'error');
                    });
                } else {
                    var data = {
                        dni,
                        apellidos,
                        nombres,
                        especialidades,
                        email,
                        numero_celular
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
                        }
                    });
                }
            });
        });
    });

    $('#clinicas').on('click', '.clinica-activo', function () {
        var medic_id = $(this).data('id-clinica');
		var is_active = null;
		if ($(this).prop('checked')) {
			is_active = 1;
		} else {
			is_active = 0;
        }
        console.log(is_active);
        $.ajax({
            type: "put",
            url: "/api/clinicas/active/" + medic_id,
            data: {
                is_active
            },
            dataType: "json",
            success: function (response) { }
        });
    });

    $('#clinicas').on('click', '.eliminar', function () {
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
            url: "/api/clinicas/" + id,
            success: function (response) {
                if (response.success) {
                    obtenerClinicas();
                }
            }
        });
	}
</script>
@endsection
