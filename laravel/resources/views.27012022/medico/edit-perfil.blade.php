@extends('layouts.main')

@section('title', 'Nuevo Médico')

@section('extra-css')

@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Nuevo Medico</h4>
            </div>
            <div class="card-content table-responsive">
                {{ Form::open(['url' => ['/medico-perfil', $perfilMedico->id], 'method' => 'PUT', 'class' => 'form-horizontal']) }}

                <div class="form-group">
                    <label for="cmp" class="col-lg-2 control-label">CMP*</label>
                    <div class="col-md-6">
                        <input type="text" name="cmp" value="{{ $perfilMedico->cmp }}" class="form-control" id="cmp"
                            placeholder="CMP">
                    </div>
                </div>

                <div class="form-group">
                    <label for="rne" class="col-lg-2 control-label">RNE*</label>
                    <div class="col-md-6">
                        <input type="text" name="rne" value="{{ $perfilMedico->rne }}" class="form-control" id="rne"
                            placeholder="RNE">
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

@endsection