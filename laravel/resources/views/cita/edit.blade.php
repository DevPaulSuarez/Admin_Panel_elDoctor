@extends('layouts.main')

@section('title', 'Editar Citas')

@section('extra-css')

@endsection

@section('content')
<div class="row">
    <div class="col-md-12">

        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Editar Cita</h4>
            </div>
            <div class="card-content table-responsive">
                {{ Form::open(['route' => ['citas.update', $reservacion->id], 'method' => 'PUT', 'class' => 'form-horizontal']) }}
                <input type="hidden" name="pacient_id" value="{{ $reservacion->pacient_id }}">
                <input type="hidden" name="medic_id" value="{{ $reservacion->medic_id }}">
                <input type="hidden" name="especialidad_id" value="{{ $reservacion->especialidad_id }}">
                <input type="hidden" name="idlugar" value="{{ $reservacion->idlugar }}">
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Fecha/Hora</label>
                    <div class="col-lg-5">
                        <input type="date" name="date_at" value="{{ $reservacion->date_at }}" required
                            class="form-control" id="inputEmail1" placeholder="Fecha">
                    </div>
                    <div class="col-lg-5">
                        <input type="time" name="time_at" value="{{ $reservacion->time_at }}" required
                            class="form-control" id="inputEmail1" placeholder="Hora">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Estado de la cita</label>
                    <div class="col-lg-4">
                        <select name="status_id" class="form-control" required>
                            @foreach ($estados as $estado)
                            <option value="{{ $estado->id }}"
                                {{ $reservacion->status_id == $estado->id ? 'selected':'' }}>{{ $estado->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="align-center">
                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade in">
                        @foreach ($errors->all() as $error)
                        <p style="margin: 0;">{{ $error }}</p>
                        @endforeach
                    </div>
                    @endif
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" class="btn btn-default">Guardar</button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-js')

@endsection