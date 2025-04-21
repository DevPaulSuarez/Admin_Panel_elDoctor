<?php $__env->startSection('title', 'Encuesta'); ?>

<?php $__env->startSection('extra-css'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="breadcrumb-header justify-content-between">
    <div class="left-content">
        <div>
            <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Encuestas</h2>
        </div>
    </div>
    <div class="d-flex my-xl-auto right-content">
        <div class="pr-1 mb-3 mb-xl-0">
            <a href="/api/encuestas/export" class="btn btn-info"><i class="fas fa-file-excel"></i> Exportar a Excel</a>
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
                                <th>Fecha</th>
                                <th>Médico</th>
                                <th>Paciente</th>
                                <th>Puntuacion del servicio de la plataforma</th>
                                <th>Sugerencia de la plataforma</th>
                                <th>Puntuacion de la atencion del medico</th>
                                <th>Opinión al medico</th>
                                <th>Intentos de conexión</th>
                                <th>Tiempo de conexión</th>
                            </tr>
                        </thead>
                        <tbody id="encuestas"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-js'); ?>
<script>
    $(document).ready(function() {
        obtenerEncuestas();
    });

    function obtenerEncuestas() {
        $.ajax({
            type: "get",
            url: "/api/encuestas",
            dataType: "json",
            success: function (response) {
                dibujarEncuetas(response);
            }
        });
    }

    function dibujarEncuetas(data) {
        var html = '';
        data.forEach(e => {
            html += '<tr>';
            html += '<td>';
            html += '<input type="checkbox" id="'+e.id+'" name="check" class="encuesta-activo" '+ (e.is_active ? 'checked' : '')+ ' data-id-encuesta="'+e.id+'">';
            html += '</td>';
            html += '<td>'+moment(e.fecha).format('DD/MM/YYYY')+'</td>';
            html += '<td>'+(e.medico ? e.medico : '')+'</td>';
            html += '<td>'+(e.paciente ? e.paciente : '')+'</td>';
            html += '<td>'+(e.puntuacion_servicio_plataforma ? e.puntuacion_servicio_plataforma : '')+'</td>';
            html += '<td>'+(e.sugerencia_plataforma ? e.sugerencia_plataforma : '')+'</td>';
            html += '<td>'+(e.puntuacion_atencion_medico ? e.puntuacion_atencion_medico : '')+'</td>';
            html += '<td>'+(e.opinion_medico ? e.opinion_medico : '')+'</td>';
            html += '<td>'+(e.times_video_connected ? e.times_video_connected : '')+'</td>';
            html += '<td>'+(e.time_video_connected ? e.time_video_connected : '')+'</td>';
            html += '</tr>';
        });
        $('#encuestas').html(html);
    }

    $('#encuestas').on('click', '.encuesta-activo', function () {
        var id_encuesta = $(this).data('id-encuesta');
		var is_active = null;
		if ($(this).prop('checked')) {
			is_active = 1;
		} else {
			is_active = 0;
        }
        $.ajax({
            type: "put",
            url: "/api/encuestas/active/" + id_encuesta,
            data: {
                is_active
            },
            dataType: "json",
            success: function (response) { }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\PessDev\Downloads\admin-eldoctor.pe\laravel\resources\views/encuesta/index.blade.php ENDPATH**/ ?>