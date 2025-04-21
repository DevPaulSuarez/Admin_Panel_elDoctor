<div class="modal" id="mdFormCreate">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Medicamentos</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" id="id" value="{{ $id }}">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre_generico">Nombre generico <span class="requerid">*</span></label>
                            <input type="text" class="form-control" id="nombre_generico" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre_comercial">Nombre comercial <span class="requerid">*</span></label>
                            <input type="text" class="form-control" id="nombre_comercial" autocomplete="off">
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
    }

    function inicializarEditForm() {
        $.ajax({
                type: 'get',
                url: '/api/medicamentos/' + id,
                data: {},
                dataType: "json",
                success: function (response) {
                    var data = response.data;

                    $('#nombre_generico').val(data.nombre_generico);
                    $('#nombre_comercial').val(data.nombre_comercial);
                }
            });
    }

    function save() {
        $submit.html('<i class="fas fa-spinner fa-spin"></i>');
        $submit.attr('disabled', true);
        var errors = [];

        var nombre_generico = $('#nombre_generico').val();
        var nombre_comercial = $('#nombre_comercial').val();

        if (nombre_generico == null) {
            errors.push('NOMBRE GENERICO ES REQUERIDO');
        }
        if (nombre_comercial == null) {
            errors.push('NOMBRE COMERCIAL ES REQUERIDO');
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
                nombre_generico: (nombre_generico != '' ? nombre_generico.toUpperCase() : ''),
                nombre_comercial: (nombre_comercial != '' ? nombre_comercial.toUpperCase() : '')
            }
            if (id == 0) {
                ajax_type = 'POST';
                ajax_url = '/api/medicamentos';
            } else {
                ajax_type = 'PUT';
                ajax_url = '/api/medicamentos/' + id;
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
                    obtenerMedicamentos();
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
