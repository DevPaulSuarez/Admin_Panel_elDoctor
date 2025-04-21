<div class="modal" id="mdFormCreate">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Medico</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nombres">Paciente <span class="requerid">*</span></label>
                            <select class="form-control select2" id="paciente">
                                <option value="">SELECCIONE</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nombres">Médico <span class="requerid">*</span></label>
                            <select class="form-control select2" id="medico">
                                <option value="">SELECCIONE</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nombres">Especialidad <span class="requerid">*</span></label>
                            <select class="form-control select2" id="especialidad">
                                <option value="">SELECCIONE</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Fecha <span class="requerid">*</span></label>
                            <input type="date" class="form-control" id="fecha">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="numero_celular">Duración Atención <span class="requerid">*</span></label>
                            <input type="text" class="form-control" id="tiempo_atencion">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="card shadow rounded mt-5 mb-5" style="display: flex; flex-wrap: wrap; flex-direction: row; justify-content: center;" id="horas">
                                NO HAY HORARIOS DISPONIBLES
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="numero_celular">Hora personalizada</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <label class="ckbox wd-16 mg-b-0"><input type="checkbox" class="mg-0" id="habilitar-hora_personalizada"><span></span></label>
                                    </div>
                                </div><input type="text" class="form-control" id="hora_personalizada" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn ripple btn-primary" id="guardar">Guardar</button>
                <button type="button" class="btn ripple btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>