<div class="modal" id="mdHistorial">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Medico</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        @if (count($reservaciones) > 0)
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th>N°</th>
                                <th>Fecha</th>
                                <th>Modalidad</th>
                                <th>Paciente</th>
                                <th>Medico</th>
                                <th>Doc Em</th>
                                <th>Intentos de conexión</th>
                                <th>Tiempo de conexión</th>
                                <th>Intentos de conexión médico</th>
                                <th>Tiempo de conexión médicos</th>
                                <th>Intentos de conexión paciente</th>
                                <th>Tiempo de conexión paciente</th>
                            </thead>
                            <tbody>
                                @foreach ($reservaciones as  $key => $reservacion)
                                <tr>
                                    <td class="text-uppercase">{{ $key + 1 }}</td>
                                    <td class="text-uppercase">{{ date('d/m/Y', strtotime($reservacion->date_at)) }} {{ date('h:i A', strtotime($reservacion->time_at)) }}</td>
                                    <td class="text-uppercase">{{ $reservacion->medio_atencion }}</td>
                                    <td class="text-uppercase">{{ $reservacion->paciente }}</td>
                                    <td class="text-uppercase">{{ $reservacion->medico }}</td>
                                    <td class="text-uppercase">Ordenes: {{ $reservacion->documentos->ordenes }} <br>Recetas: {{ $reservacion->documentos->recetas }}</td>
                                    <td class="text-uppercase">{{ $reservacion->times_video_connected }}</td>
                                    <td class="text-uppercase">{{ $reservacion->time_video_connected }}</td>
                                    <td class="text-uppercase">{{ $reservacion->sender_times_connected }}</td>
                                    <td class="text-uppercase">{{ $reservacion->sender_time_connected }}</td>
                                    <td class="text-uppercase">{{ $reservacion->receptor_times_connected }}</td>
                                    <td class="text-uppercase">{{ $reservacion->receptor_time_connected }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p class="alert alert-danger">No hay cita</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn ripple btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

{{-- @extends('layouts.main')

@section('title', 'Historial Médico')

@section('extra-css')

@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Historial de Citas del Médico</h4>
                <p>{{ $medico->lastname }} {{ $medico->name }}</p>
            </div>
            <div class="card-content table-responsive">
                @if (count($reservaciones) > 0)
                <table class="table table-bordered table-hover">
                    <thead>
                        <th>Asunto</th>
                        <th>Paciente</th>
                        <th>Medico</th>
                        <th>Fecha</th>
                    </thead>
                    <tbody>
                        @foreach ($reservaciones as $reservacion)
                        <tr>
                            <td class="text-uppercase">{{ $reservacion->title }}</td>
                            <td class="text-uppercase">{{ $reservacion->paciente }}</td>
                            <td class="text-uppercase">{{ $reservacion->medico }}</td>
                            <td class="text-uppercase">{{ date('d/m/Y', strtotime($reservacion->date_at)) }}
                                {{ date('h:i A', strtotime($reservacion->time_at)) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="alert alert-danger">No hay cita</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-js')
@endsection --}}
