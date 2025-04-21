<div class="modal" id="mdFormCreate">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Institución</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre">Nombre <span class="requerid">*</span></label>
                            <input type="text" class="form-control" id="nombre">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email <span class="requerid">*</span></label>
                            <input type="text" class="form-control" id="email">
                        </div>
                    </div><div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Dirección <span class="requerid">*</span></label>
                            <input type="text" class="form-control" id="email">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="telefono">Número de celular <span class="requerid">*</span></label>
                            <input type="text" class="form-control" id="telefono">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="logo">Logo <span class="requerid">*</span></label>
                            <input type="file" class="form-control" id="logo">
                        </div>
                    </div>
                    <div class="col-md-12 ocultar">
                        <div class="form-group">
                            <label for="numero_celular">Contraseña <span class="requerid">*</span></label>
                            <input type="password" class="form-control" id="password">
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

{{--
@extends('layouts.main')

@section('title', 'Nuevo Médico')

@section('extra-css')
<style>
    input:read-only {
        cursor: no-drop;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Nuevo Medico</h4>
            </div>
            <div class="card-content table-responsive">
                {{ Form::open(['route' => 'medicos.store', 'method' => 'POST', 'files'=>true, 'class' => 'form-horizontal']) }}
                <div class="form-group">
                    <label for="dni" class="col-lg-2 control-label">DNI*</label>
                    <div class="col-md-6" style="display: flex">
                        <input type="text" name="dni" class="form-control" id="dni" placeholder="DNI" minlength="8"
                            maxlength="8" required>
                        <button type="button" id="buscar" class="btn btn-secondary">Buscar</button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
                    <div class="col-md-6">
                        <input type="text" name="name" class="form-control" id="name" placeholder="Nombre" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Apellido*</label>
                    <div class="col-md-6">
                        <input type="text" name="lastname" required class="form-control" id="lastname" placeholder="Apellido" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Especialidades*</label>
                    <div class="col-md-6">
                        <select class="form-control" id="especialidades" name="especialidades[]" multiple="multiple"
                            required>
                        </select>
                    </div>
                </div>
                <div class="form-group existe">
                    <label for="inputEmail1" class="col-lg-2 control-label">Email*</label>
                    <div class="col-md-6">
                        <input type="text" name="email" class="form-control" id="email" placeholder="Email">
                    </div>
                </div>
                <div class="form-group existe">
                    <label for="inputEmail1" class="col-lg-2 control-label">Telefono*</label>
                    <div class="col-md-6">
                        <input type="text" name="phone" class="form-control" id="phone" placeholder="Telefono">
                    </div>
                </div>
                <div class="form-group existe">
                    <label for="inputEmail1" class="col-lg-2 control-label">Password*</label>
                    <div class="col-md-6">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password"
                            required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" class="btn btn-primary" id="guardar">Guardar</button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-js')
<script>
    $('#especialidades').select2({
        placeholder: 'SELECCIONE',
        language: "es",
        width: '100%',
        closeOnSelect: false,
        allowClear: true,
        ajax: {
            url: '/categorias',
            processResults: function (data) {
                var array = [];
                data.forEach(e => {
                        array.push({
                            id: e.id,
                            text: e.name
                        })
                });
                return {
                        results: array
                };
            }
        }
    });
    function filePreview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
            $('#imagePreview').empty();
            $('#imagePreview').html("<img src='" + e.target.result + "' alt='Imagen de perfil' style='width: 45px; border: 1px solid;'>");
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $('#image').change(function(e) {
        e.preventDefault();
        filePreview(this);
    });
    $("#departamento").change(function() {
        $("#departamento option:selected").each(function() {
            id = $(this).val();
            $.get("/provincias-departamento/" + id, function(response) {
                var html = '<option selected>-- SELECCIONE --</option>';
                response.forEach(e => {
                    html += '<option value='+e.idProv+'>'+e.provincia+'</option>';
                });
                $("#provincia").html(html);
            });
        });
    });
</script>
<script>
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
            $('#buscar').html('<span class="fa fa-spinner fa-spin"></span> Procesando ...');
            $('#buscar').attr('disabled', true);
            $.ajax({
                type: "GET",
                url: "/medicos-dni/" + dni,
                success: function (response) {
                    if(response.length != 0) {
                        medico = response[0];
                        $('#dni').val(medico.dni);
                        $('#name').val(medico.name);
                        $('#lastname').val(medico.lastname);
                        $('.existe').hide();
                        $.ajax({
                            type: "GET",
                            url: "/categorias-medico/"+ medico.id,
                            success: function (response) {
                                var especilidades_id = [];
                                response.forEach(e => {
                                    especilidades_id.push(e.id);
                                    var newOption = new Option(e.name, e.id, true, true);
                                    $('#especialidades').append(newOption).trigger('change');
                                });
                                $('#especialidades').val(especilidades_id).trigger('change');
                            }
                        });
                        $('#name').attr('readonly', true);
                        $('#lastname').attr('readonly', true);
                        $('#especialidades').attr('disabled', true);
                        $('#departamento').attr('disabled', true);
                        $('#provincia').attr('disabled', true);
                        $('#address').attr('readonly', true);
                        $('#email').attr('readonly', true);
                        $('#phone').attr('readonly', true);
                        $('#precioconsultorio').attr('readonly', true);
                        $('#preciomedicolinea').attr('readonly', true);
                        $('#precioespecialista').attr('readonly', true);
                        $('#preciovisitadomicilio').attr('readonly', true);
                        $('#image').attr('disabled', true);
                        $('#password').attr('readonly', true);

                        $('#buscar').html('Buscar');
                        $('#buscar').attr('disabled', false);
                        $('#guardar').html('AGREGAR');
                    } else {
                        $("input[name='gender']").prop('checked', false);
                        $.ajax({
                            type: "GET",
                            url: 'https://apis4.facttu.com/reniec/personas/' + dni,
                            dataType: "json",
                            success: function(response) {
                                var persona = response.persona;
                                $('#dni').val(persona.dni);
                                $('#name').val(persona.nombres);
                                $('#lastname').val(persona.apellido_paterno + ' ' + persona.apellido_materno);
                                $('#name').attr('readonly', true);
                                $('#lastname').attr('readonly', true);
                                $("input[name='gender']").attr('disabled', false);
                                $('#day_of_birth').attr('readonly', false);
                                $('#address').attr('readonly', false);
                                $('#email').attr('readonly', false);
                                $('#phone').attr('readonly', false);
                                $('#buscar').html('Buscar');
                                $('#buscar').attr('disabled', false);
                                $('#buscar').html('Buscar');
                                $('#buscar').attr('disabled', false);
                            }
                        });
                    }
                }
            });
        }
    }
</script>
@endsection --}}
