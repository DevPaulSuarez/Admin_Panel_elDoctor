@extends('layouts.main')

@section('title', 'Editar Médico')

@section('extra-css')

@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Editar Medico</h4>
            </div>
            <div class="card-content table-responsive">
                {{ Form::open(['route' => ['medicos.update', $medico->id], 'method' => 'put', 'files'=>true, 'class' => 'form-horizontal']) }}
                <input type="hidden" id="id" value="{{ $medico->id }}">
                <div class="form-group">
                    <label for="dni" class="col-lg-2 control-label">DNI*</label>
                    <div class="col-md-6">
                        <input type="text" name="dni" class="form-control" id="dni" placeholder="DNI" 
                            value="{{ $medico->dni }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
                    <div class="col-md-6">
                        <input type="text" name="name" class="form-control" id="name" placeholder="Nombre" required
                            value="{{ $medico->name }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Apellido*</label>
                    <div class="col-md-6">
                        <input type="text" name="lastname" required class="form-control" id="lastname"
                            placeholder="Apellido" required value="{{ $medico->lastname }}">
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
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Email*</label>
                    <div class="col-md-6">
                        <input type="text" name="email" class="form-control" id="email" placeholder="Email"
                            value="{{ $medico->email }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Telefono*</label>
                    <div class="col-md-6">
                        <input type="text" name="phone" class="form-control" id="phone" placeholder="Telefono"
                            value="{{ $medico->phone }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Password*</label>
                    <div class="col-md-6">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
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
<script>
    $("#especialidades").empty();
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
    $.ajax({
        type: "GET",
        url: "/categorias-medico/"+ $('#id').val(),
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

@endsection