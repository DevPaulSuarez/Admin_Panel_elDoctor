<?php $__env->startSection('title', 'Especialdad'); ?>

<?php $__env->startSection('extra-css'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="breadcrumb-header justify-content-between">
    <div class="left-content">
        <div>
            <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Especialidades</h2>
        </div>
    </div>
    <div class="d-flex my-xl-auto right-content">
        <div class="pr-1 mb-3 mb-xl-0">
            <button type="button" class="btn btn-primary mr-2" id="button-modal-create"><i class="fas fa-plus"></i> Nuevo</button>
            <a href="/api/especialidades/export" class="btn btn-info"><i class="fas fa-file-excel"></i> Exportar a Excel</a>
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
                                <th>Nombre</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="especialidades"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-create-container"></div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-js'); ?>
<script>
    $(document).ready(function() {
        obtenerEspecialidades();
    });

    function obtenerEspecialidades() {
        $.ajax({
            type: "get",
            url: "/api/especialidades",
            dataType: "json",
            success: function (response) {
                dibujarEncuetas(response.data);
            }
        });
    }

    function dibujarEncuetas(data) {
        var html = '';
        data.forEach(e => {
            html += '<tr>';
            html += '<td>'+e.name+'</td>';
            html += '<td><button type="button" class="btn btn-warning btn-sm m-1 button-modal-edit" data-id="'+e.id+'">Editar</button></td>';
            html += '</tr>';
        });
        $('#especialidades').html(html);
    }

    $('#button-modal-create').click(function (e) {
        e.preventDefault();
        var url = '/especialidades/create';
        $('.modal-create-container').load(url, function (result) {
            $('#mdFormCreate').modal({
                show: true,
                backdrop: 'static',
                // size: 'lg',
                keyboard: false
            });

            $('#guardar').click(function (e) {
                e.preventDefault();
                var error = [];

                var nombre = $('#nombre').val();

                if (nombre == '') {
                    error.push('NOMBRE ES REQUERIDO');
                }
                if (error.length > 0) {
                    error.forEach(e => {
                        msmToastr('ERROR!', e, 'error');
                    });
                } else {
                    var data = {
                        nombre: nombre.toUpperCase(),
                    }
                    $.ajax({
                        type: "post",
                        url: "/api/especialidades",
                        data,
                        dataType: "json",
                        success: function (response) {
                            if (response.success) {
                                obtenerEspecialidades();
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

    $('#especialidades').on('click', '.button-modal-edit', function () {
        var id =  $(this).data('id');
        var url = '/especialidades/create';
        $('.modal-create-container').load(url, function (result) {
            $('#mdFormCreate').modal({
                show: true,
                backdrop: 'static',
                // size: 'lg',
                keyboard: false
            });
            $.ajax({
                type: "get",
                url: "/api/especialidades/" + id,
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        $('#nombre').val(response.data.name);
                    }
                }
            });

            $('#guardar').click(function (e) {
                e.preventDefault();
                var error = [];

                var nombre = $('#nombre').val();


                if (nombre== '') {
                    error.push('NOMBRE ES REQUERIDO');
                }
                if (error.length > 0) {
                    error.forEach(e => {
                        msmToastr('ERROR!', e, 'error');
                    });
                } else {
                    var data = {
                        nombre: nombre.toUpperCase(),
                    }

                    $.ajax({
                        type: "put",
                        url: "/api/especialidades/" + id,
                        data,
                        dataType: "json",
                        success: function (response) {
                            if (response.success) {
                                obtenerEspecialidades();
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
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\PessDev\Downloads\admin-eldoctor.pe\laravel\resources\views/especialidad/index.blade.php ENDPATH**/ ?>