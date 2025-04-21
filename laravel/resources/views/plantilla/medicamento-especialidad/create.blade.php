<div class="modal" id="mdFormCreate">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Plantilla Medicamento Especialidad</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" id="id" value="{{ $id }}">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="especialidad_id">Especialidad <span class="requerido">*</span></label>
                            <select class="form-control" id="especialidad_id"></select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="medicamento_id">Medicamento <span class="requerido">*</span></label>
                            <select class="form-control" id="medicamento_id"></select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="presentacion">Presentación <span class="requerid">*</span></label>
                            <input type="text" class="form-control" id="presentacion" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="dosis">Dosis <span class="requerid">*</span></label>
                            <input type="text" class="form-control" id="dosis" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="frecuencia">Frecuencia <span class="requerid">*</span></label>
                            <select class="form-control" id="frecuencia">
                                <option value="">SELECCIONE</option>
                                <option value="24 HORAS">STAT C/ 24 HORAS</option>
                                <option value="12 HORAS">STAT C/ 12 HORAS</option>
                                <option value="8 HORAS">STAT C/ 8 HORAS</option>
                                <option value="6 HORAS">STAT C/ 6 HORAS</option>
                                <option value="4 HORAS">STAT C/ 4 HORAS</option>
                                <option value="2 HORAS">STAT C/ 2 HORAS</option>
                                <option value="1 HORAS">STAT C/ 1 HORAS</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="duracion_cantidad">Duración <span class="requerid">*</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="duracion_cantidad" autocomplete="off">
                                <span class="input-group-btn">
                                    <select class="form-control" id="duracion_unidad" style="width: 85px;padding: 0px;">
                                        <option value="HORAS">HORAS</option>
                                        <option value="DIAS">DIAS</option>
                                        <option value="SEMANAS">SEMANAS</option>
                                        <option value="MESES">MESES</option>
                                        <option value="AÑOS">AÑOS</option>
                                    </select>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="via">Vía <span class="requerid">*</span></label>
                            <select class="form-control" id="via">
                                <option value="">SELECCIONE</option>
                                <option value="ORAL">VIA ORAL</option>
                                <option value="SUBLINGUAL">VIA SUBLINGUAL</option>
                                <option value="TOPICA">VIA TOPICA</option>
                                <option value="TRANSDERMICA">VIA TRANSDERMICA</option>
                                <option value="OFTALMICA">VIA OFTALMICA</option>
                                <option value="OTICA">VIA OTICA</option>
                                <option value="INTRANASAL">VIA INTRANASAL</option>
                                <option value="INHALATORIA">VIA INHALATORIA</option>
                                <option value="RECTAL">VIA RECTAL</option>
                                <option value="VAGINAL">VIA VAGINAL</option>
                                <option value="INTRAVENOSA">VIA INTRAVENOSA</option>
                                <option value="INTRAMUSCULAR">VIA INTRAMUSCULAR</option>
                                <option value="SUBCUTANEA">VIA SUBCUTANEA</option>
                                <option value="ENDOVENOSO">VIA ENDOVENOSO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="indicaciones">Indicaciones</label>
                            <textarea class="form-control" id="indicaciones" rows="3" autocomplete="off"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn ripple btn-primary" id="submit" onclick="save()">Guardar</button>
                <button type="button" class="btn ripple btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    var id, $submit;
    inicializarForm();

    function inicializarForm() {
        id = $('#id').val();
        $submit = $('#submit');
        if (id != 0) {
            inicializarEditForm();
        }
        inicializarSelect2Form();
    }

    function inicializarEditForm() {
        $.ajax({
                type: 'get',
                url: '/api/plantillas/medicamentos-especialidades/' + id,
                data: {},
                dataType: "json",
                success: function (response) {
                    var data = response.data;

                    if ($('#especialidad_id').find("option[value='" + data.especialidad.id + "']").length) {
                        $('#especialidad_id').val(data.especialidad.id).trigger('change');
                    } else {
                        var newOption = new Option(data.especialidad.name, data.especialidad.id, true, true);
                        $('#especialidad_id').append(newOption).trigger('change');
                    }

                    if ($('#medicamento_id').find("option[value='" + data.medicamento.id + "']").length) {
                        $('#medicamento_id').val(data.medicamento.id).trigger('change');
                    } else {
                        var newOption = new Option(data.medicamento.nombre_generico + ' - ' + data.medicamento.nombre_comercial, data.medicamento.id, true, true);
                        $('#medicamento_id').append(newOption).trigger('change');
                    }

                    $('#presentacion').val(data.presentacion);
                    $('#dosis').val(data.dosis);
                    $('#frecuencia').val(data.frecuencia);
                    $('#duracion_cantidad').val(data.duracion_cantidad);
                    $('#duracion_unidad').val(data.duracion_unidad);
                    $('#via').val(data.via);
                    $('#indicaciones').val(data.indicaciones);
                }
            });
    }

    function inicializarSelect2Form() {
        $('#especialidad_id').select2({
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
                    return '/api/especialidades?search=' + search;
                },
                data: {
                    size: 100
                },
                processResults: function(response, params) {
                    return {
                        results: $.map(response.data, function(item) {
                            return {
                                text: item.name,
                                id: item.id,
                                item: item
                            }
                        })
                    };
                },
                cache: true
            }
        });

        $('#medicamento_id').select2({
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
                    return '/api/medicamentos?search=' + search;
                },
                data: {
                    size: 100
                },
                processResults: function(response, params) {
                    return {
                        results: $.map(response.data, function(item) {
                            return {
                                text: item.nombre_generico + ' - ' + item.nombre_comercial,
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

    function save() {
        $submit.html('<i class="fas fa-spinner fa-spin"></i>');
        $submit.attr('disabled', true);
        var errors = [];

        var especialidad_id = $('#especialidad_id').val();
        var medicamento_id = $('#medicamento_id').val();
        var presentacion = $('#presentacion').val();
        var dosis = $('#dosis').val();
        var frecuencia = $('#frecuencia').val();
        var duracion_cantidad = $('#duracion_cantidad').val();
        var duracion_unidad = $('#duracion_unidad').val();
        var via = $('#via').val();
        var indicaciones = $('#indicaciones').val();

        if (especialidad_id == null) {
            errors.push('ESPECIALIDAD ES REQUERIDO');
        }
        if (medicamento_id == null) {
            errors.push('MEDICAMENTO ES REQUERIDO');
        }
        if (presentacion == '') {
            errors.push('PRESENTACIÓN ES REQUERIDO');
        }
        if (dosis == '') {
            errors.push('DOSIS ES REQUERIDO');
        }
        if (frecuencia == '') {
            errors.push('FRECUENCIA ES REQUERIDO');
        }
        if (duracion_cantidad == '') {
            errors.push('DURACIÓN ES REQUERIDO');
        }
        if (via == '') {
            errors.push('VÍA ES REQUERIDO');
        }
        if (errors.length > 0) {
            errors.forEach(e => {
                msmToastr('ERROR!', e, 'error');
            });
            $submit.html('Guardar');
            $submit.attr('disabled', false);
        } else {
            var ajax_type = '';
            var ajax_url = '';
            var ajax_data = {
                especialidad_id,
                medicamento_id,
                presentacion: (presentacion != '' ? presentacion.toUpperCase() : ''),
                dosis,
                frecuencia,
                duracion_cantidad,
                duracion_unidad,
                via,
                indicaciones: (indicaciones != '' ? indicaciones.toUpperCase() : '')
            }
            if (id == 0) {
                ajax_type = 'POST';
                ajax_url = '/api/plantillas/medicamentos-especialidades';
            } else {
                ajax_type = 'PUT';
                ajax_url = '/api/plantillas/medicamentos-especialidades/' + id;
                ajax_data['id'] = id;
            }
            $.ajax({
                type: ajax_type,
                url: ajax_url,
                contentType: "application/json",
                data: JSON.stringify(ajax_data),
                dataType: 'json',
                success: function (response) {
                    $submit.html('Guardar');
                    $submit.attr('disabled', false);
                    $('#mdFormCreate').modal('hide');
                    obtenerPlantillas();
                }
            }).fail( function(jqXHR, textStatus, errorThrown) {
                var response = jqXHR.responseJSON;
                $submit.html('Guardar');
                $submit.attr('disabled', false);
                response.errors.forEach(e => {
                    msmToastr('ERROR!', e, 'error');
                });
            })
        }
    }
</script>
