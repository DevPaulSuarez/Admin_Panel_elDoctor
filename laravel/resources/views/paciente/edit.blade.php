<div class="modal" id="mdFormCreate">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Paciente</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="numero_documento">DNI <span class="requerid">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="dni">
                                <span class="input-group-addon" id="sufixId"><button type="button" class="btn btn-info" id="buscar"><i class="fas fa-search"></i></button></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="apellido_paterno">Apellidos <span class="requerid">*</span></label>
                            <input type="text" class="form-control" id="apellidos">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombres">Nombres <span class="requerid">*</span></label>
                            <input type="text" class="form-control" id="nombres">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email <span class="requerid">*</span></label>
                            <input type="text" class="form-control" id="email">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="numero_celular">Número de celular <span class="requerid">*</span></label>
                            <input type="text" class="form-control" id="numero_celular">
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

@section('title', 'Editar Paciente')

@section('extra-css')

@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Editar Paciente</h4>
            </div>
            <div class="card-content table-responsive">
                {{ Form::open(['route' => ['pacientes.update', $paciente->id], 'method' => 'put', 'class' => 'form-horizontal']) }}
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">DNI*</label>
                    <div class="col-md-6">
                        <input type="text" name="dni" class="form-control" id="dni" placeholder="DNI" value="{{ $paciente->dni }}" required readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
                    <div class="col-md-6">
                        <input type="text" name="name" class="form-control" id="name" placeholder="Nombre" value="{{ $paciente->name }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Apellido</label>
                    <div class="col-md-6">
                        <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Apellido" value="{{ $paciente->lastname }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Genero*</label>
                    <div class="col-md-6">
                        <label class="checkbox-inline">
                            <input type="radio" id="inlineCheckbox1" name="gender" required value="h" {{ $paciente->gender == "h" ? 'checked': '' }}> Hombre
                        </label>
                        <label class="checkbox-inline">
                            <input type="radio" id="inlineCheckbox2" name="gender" required value="m" {{ $paciente->gender == "m" ? 'checked': '' }}> Mujer
                        </label>

                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Fecha de Nacimiento</label>
                    <div class="col-md-6">
                        <input type="date" name="day_of_birth" class="form-control" id="address1"
                            placeholder="Fecha de Nacimiento" value="{{ $paciente->day_of_birth }}">
                    </div>
                </div>


                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Direccion*</label>
                    <div class="col-md-6">
                        <input type="text" name="address" class="form-control" id="address1" placeholder="Direccion" value="{{ $paciente->address }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Email*</label>
                    <div class="col-md-6">
                        <input type="email" name="email" class="form-control" id="email1" placeholder="Email" value="{{ $paciente->email }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Telefono*</label>
                    <div class="col-md-6">
                        <input type="text" name="phone" class="form-control" id="phone1" placeholder="Telefono" value="{{ $paciente->phone }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Enfermedad</label>
                    <div class="col-md-6">
                        <textarea  name="sick" class="form-control" id="sick" placeholder="Enfermedad">{{ $paciente->sick }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Medicamentos</label>
                    <div class="col-md-6">
                        <textarea name="medicaments" class="form-control" id="sick"
                            placeholder="Medicamentos">{{ $paciente->medicaments }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Alergia</label>
                    <div class="col-md-6">
                        <textarea name="alergy" class="form-control" id="sick" placeholder="Alergia">{{ $paciente->alergy }}</textarea>
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

@endsection --}}