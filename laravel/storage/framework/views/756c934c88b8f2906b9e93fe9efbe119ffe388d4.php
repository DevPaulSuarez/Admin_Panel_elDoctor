<?php $__env->startSection('title', 'Asistentes'); ?>

<?php $__env->startSection('extra-css'); ?>
<link href="/assets/plugins/datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="/assets/plugins/datatable/css/buttons.bootstrap4.min.css" rel="stylesheet">
<link href="/assets/plugins/datatable/css/responsive.bootstrap4.min.css" rel="stylesheet" />
<link href="/assets/plugins/datatable/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="/assets/plugins/datatable/css/responsive.dataTables.min.css" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="breadcrumb-header justify-content-between">
    <div class="left-content">
        <div>
            <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Asistentes</h2>
        </div>
    </div>
    <div class="d-flex my-xl-auto right-content">
        <div class="pr-1 mb-3 mb-xl-0">
            <button type="button" class="btn btn-primary mr-2" onclick="toggleModal(0)"><i class="fas fa-plus"></i> Nuevo</button>
            
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="table" class="table table-hover mb-0 text-md-nowrap">
                                <thead>
                                    <tr>
                                        <th>DNI</th>
                                        <th>Asistente</th>
                                        <th>Celular</th>
                                        <th>Email</th>
                                        <th>Médico</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-create-container"></div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-js'); ?>
<script src="/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatable/js/dataTables.dataTables.min.js"></script>
<script src="/assets/plugins/datatable/js/dataTables.responsive.min.js"></script>
<script src="/assets/plugins/datatable/js/responsive.dataTables.min.js"></script>
<script src="/assets/plugins/datatable/js/jquery.dataTables.js"></script>
<script src="/assets/plugins/datatable/js/dataTables.bootstrap4.js"></script>
<script src="/assets/plugins/datatable/js/dataTables.buttons.min.js"></script>
<script src="/assets/plugins/datatable/js/buttons.bootstrap4.min.js"></script>
<script src="/assets/plugins/datatable/js/jszip.min.js"></script>
<script src="/assets/plugins/datatable/js/pdfmake.min.js"></script>
<script src="/assets/plugins/datatable/js/vfs_fonts.js"></script>
<script src="/assets/plugins/datatable/js/buttons.html5.min.js"></script>
<script src="/assets/plugins/datatable/js/buttons.print.min.js"></script>
<script src="/assets/plugins/datatable/js/buttons.colVis.min.js"></script>
<script src="/assets/plugins/datatable/js/dataTables.responsive.min.js"></script>
<script src="/assets/plugins/datatable/js/responsive.bootstrap4.min.js"></script>

<script>
    $(document).ready(function () {
        obtenerAsistentes();
    })

    function obtenerAsistentes() {
        $.ajax({
            type: 'get',
            url: '/api/asistentes',
            data: {
                // especialidad_id: $('#especialidad').val()
            },
            dataType: 'json',
            success: function (response) {
                listar(response.data)
            }
        });
    }

    function listar(data) {
        table = $('#table').DataTable({
            destroy: true,
            lengthChange: false,
            paging:false,
            dom: 'Bfrtip',
            buttons: [ 'copy', 'excel', 'pdf', 'colvis' ],
            responsive: true,
            language: languaje_spanish_data_table,
            data,
            columns: [
                {
                    data: 'dni',
                    render(data, type, full, meta) {
                        return data;
                    },
                },
                {
                    data: 'apellidos',
                    render(data, type, full, meta) {
                        return `${full.apellidos} ${full.nombres}`;
                    },
                },
                {
                    data: 'celular',
                    render(data, type, full, meta) {
                        return `${full.celular_codigo_pais}${full.celular}`;
                    },
                },
                {
                    data: 'email',
                    render(data, type, full, meta) {
                        return data;
                    },
                },
                {
                    data: 'medico',
                    render(data, type, full, meta) {
                        return `${data.lastname} ${data.name}`;
                    },
                },
                {
                    data: 'id',
                    render(data, type, full, meta) {
                        return '<button type="button" class="btn btn-info btn-sm m-1 editar" data-id="'+data+'"><i class="fas fa-pen"></i></button><button type="button" class="btn btn-danger btn-sm m-1 eliminar" data-id="'+data+'"><i class="fas fa-trash"></i></button>';
                    },
                    width: '70px'
                }
            ]
        });
    }

    $('#table').on('click', '.editar', function () {
        toggleModal($(this).data('id'));
    });

    $('#table').on('click', '.eliminar', function () {
        var data_id = $(this).data('id');
        bootbox.dialog({
			title: "",
			message: "¿Esta seguro de Eliminar?",
			buttons: {
				cancel: {
					label: "SI",
					className: 'btn-success btn-lg',
					callback: function() {
						destroy(data_id);
					}
				},
				ok: {
					label: "NO",
					className: 'btn-danger btn-lg'
				}
			}
		});
    });

    function toggleModal(id) {
        var url = '/asistentes/' + id;
        $('.modal-create-container').load(url, function (result) {
            $('#mdFormCreate').modal({
                show: true,
                backdrop: 'static',
                keyboard: false
            });
        });
    }

    function destroy(id) {
        $.ajax({
            type: 'delete',
            url: '/api/asistentes/' +  id,
            data: {},
            dataType: 'json',
            success: function (response) {
               // obtenerMedicamentos();
               obtenerAsistentes();
            }
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\PessDev\Downloads\admin-eldoctor.pe\laravel\resources\views/asistente/index.blade.php ENDPATH**/ ?>