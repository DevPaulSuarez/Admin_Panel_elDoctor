<div class="modal" id="mdHistorial">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Paciente</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
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
            <div class="modal-footer">
                <button type="button" class="btn ripple btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>