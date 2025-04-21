@extends('layouts.main')

@section('title', 'Pacientes')

@section('extra-css')
<link href="/assets/plugins/datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="/assets/plugins/datatable/css/buttons.bootstrap4.min.css" rel="stylesheet">
<link href="/assets/plugins/datatable/css/responsive.bootstrap4.min.css" rel="stylesheet" />
<link href="/assets/plugins/datatable/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="/assets/plugins/datatable/css/responsive.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="breadcrumb-header justify-content-between">
    <div class="left-content">
        <div>
            <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Plantilla Medicamento Médico</h2>
        </div>
    </div>
    <div class="d-flex my-xl-auto right-content">
        <div class="pr-1 mb-3 mb-xl-0">
            <button type="button" class="btn btn-primary mr-2" onclick="toggleModal(0)"><i class="fas fa-plus"></i> Nuevo</button>
            {{-- <a href="/api/pacientes/export" class="btn btn-info"><i class="fas fa-file-excel"></i> Exportar a Excel</a> --}}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Seleccione médico</label>
                            <select class="form-control" id="medico"></select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="table" class="table table-hover mb-0 text-md-nowrap">
                                <thead>
                                    <tr>
                                        <th>Nombre Generico</th>
                                        <th>Nombre Comercial</th>
                                        <th>Presentación</th>
                                        <th>Dosis</th>
                                        <th>Frecuencia</th>
                                        <th>Duración</th>
                                        <th>Vía</th>
                                        <th>Indicaciones</th>
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
@endsection

@section('extra-js')
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
        obtenerPlantillas();
        inicializarSelect2();
    })

    function obtenerPlantillas() {
        $.ajax({
            type: 'get',
            url: '/api/plantillas/medicamentos-medicos',
            data: {
                medico_id: $('#medico').val()
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
            dom: 'Bfrtip',
            buttons: [ 'copy', 'excel', 'pdf', 'colvis' ],
            responsive: true,
            language: languaje_spanish_data_table,
            data,
            columns: [
                {
                    data: 'medicamento.nombre_generico',
                    defaultContent: ''
                },
                {
                    data: 'medicamento.nombre_comercial',
                    defaultContent: ''
                },
                {
                    data: 'presentacion'
                },
                {
                    data: 'dosis'
                },
                {
                    data: 'frecuencia'
                },
                {
                    render(data, type, full, meta) {
                        return full.duracion_cantidad + ' ' + full.duracion_unidad;
                    }
                },
                {
                    data: 'via'
                },
                {
                    data: 'indicaciones'
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

    function inicializarSelect2() {
        $('#medico').select2({
            placeholder: 'SELECCIONA',
            width: '100%',
            searchInputPlaceholder: 'Buscar...',
            language: {
                noResults: function () {
                    return "No hay resultado";
                },
                searching: function () {
                    return "Buscando..";
                }
            },
            // allowClear: true,
            closeOnSelect: true,
            ajax: {
                url: function (params) {
                    var search = '';
                    if(params.term != undefined) {
                        search = params.term;
                    }
                    return '/api/medicos?search=' + search;
                },
                data: {
                    size: 100
                },
                processResults: function(response, params) {
                    return {
                        results: $.map(response.data, function(item) {
                            return {
                                text: item.lastname + ' ' + item.name,
                                id: item.id,
                                item: item
                            }
                        })
                    };
                },
                cache: true
            }
        });
    }

    $('#especialidad').change(function (e) {
        e.preventDefault();
        obtenerPlantillas();
    });

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
        var url = '/plantillas/medicamentos-medicos/' + id;
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
            url: '/api/plantillas/medicamentos-medicos/' +  id,
            data: {},
            dataType: 'json',
            success: function (response) {
                obtenerPlantillas();
            }
        });
    }
</script>
@endsection
