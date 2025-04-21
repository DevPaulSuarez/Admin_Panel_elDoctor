<input type="hidden" id="id" value="{{ $id }}">

<div class="modal" id="modal-pass">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">CAMBIAR CONTRASEÑA</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Paciente: <span id="paciente_text"></span></label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="password_registrar">Contraseña <span class="requerido">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password_registrar" autocomplete="off">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary" id="mostrar_pass_registrar"><i class="fa fa-eye-slash"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn ripple btn-primary" id="guardarPass" onclick="savePass()">Guardar</button>
                <button type="button" class="btn ripple btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<script>
    var paciente_id;
    inicializarForm();

    function inicializarForm() {
        paciente_id = $('#id').val();
        $.ajax({
            type: 'get',
            url: `https://eldoctor.pe/api/pacientes/${paciente_id}`,
            data: {},
            dataType: 'json',
            success: function (response) {
                $('#paciente_text').text(`${response.data.apellidos} ${response.data.nombres}`);
            }
        });
    }

    function savePass() {
        if ($('#password_registrar').val() == '') {
            msmToastr('ERROR!', 'CONTRASEÑA ES REQUERIDO', 'error');
            return;
        }

        $.ajax({
            type: 'put',
            url: `https://eldoctor.pe/api/pacientes/${paciente_id}/password`,
            data: {
                password: $('#password_registrar').val()
            },
            dataType: 'json',
            success: function (response) {
                $('#modal-pass').modal('hide');
            }
        });
    }

    $('#mostrar_pass_registrar').click(function (e) {
        e.preventDefault();
        var tipo = $('#password_registrar').attr('type');
        if(tipo == 'password') {
            $(this).html('<i class="fa fa-eye"></i>');
            $('#password_registrar').attr('type', 'text');
        } else {
            $(this).html('<i class="fa fa-eye-slash"></i>');
            $('#password_registrar').attr('type', 'password');
        }

    });
</script>
