<input type="hidden" id="id" value="{{ $id }}">

<div class="modal" id="mdFormCreate">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Asistente</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="dni">DNI <span class="requerido">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="dni" value="">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary" id="buscar_persona"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="apellidos">Apellidos <span class="required">*</span></label>
                            <input type="text" class="form-control" id="apellidos" name="lastname" value="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nombres">Nombres <span class="required">*</span></label>
                            <input type="text" class="form-control" id="nombres" name="name" value="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="celular">N° de celular <span class="required">*</span></label>
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <select class="form-control" id="celular_codigo_pais" style="width: 150px;">
                                        <option value="7">ABJASIA</option>
                                        <option value="93">AFGANISTÁN</option>
                                        <option value="355">ALBANIA</option>
                                        <option value="49">ALEMANIA</option>
                                        <option value="376">ANDORRA</option>
                                        <option value="244">ANGOLA</option>
                                        <option value="1264">ANGUILLA</option>
                                        <option value="1268">ANTIGUA Y BARBUDA</option>
                                        <option value="599">ANTILLAS HOLANDESAS</option>
                                        <option value="966">ARABIA SAUDITA</option>
                                        <option value="213">ARGELIA</option>
                                        <option value="54">ARGENTINA</option>
                                        <option value="374">ARMENIA</option>
                                        <option value="297">ARUBA</option>
                                        <option value="61">AUSTRALIA</option>
                                        <option value="43">AUSTRIA</option>
                                        <option value="994">AZERBAIYÁN</option>
                                        <option value="1242">BAHAMAS</option>
                                        <option value="973">BAHREIN</option>
                                        <option value="880">BANGLADESH</option>
                                        <option value="1246">BARBADOS</option>
                                        <option value="501">BELICE</option>
                                        <option value="229">BENIN</option>
                                        <option value="1441">BERMUDAS</option>
                                        <option value="375">BIELORRUSIA</option>
                                        <option value="591">BOLIVIA</option>
                                        <option value="599">BONAIRE</option>
                                        <option value="387">BOSNIA</option>
                                        <option value="267">BOTSWANA</option>
                                        <option value="55">BRASIL</option>
                                        <option value="673">BRUNEI DARUSSALAM</option>
                                        <option value="359">BULGARIA</option>
                                        <option value="226">BURKINA FASO</option>
                                        <option value="257">BURUNDI</option>
                                        <option value="975">BUTÁN</option>
                                        <option value="32">BÉLGICA</option>
                                        <option value="238">CABO VERDE</option>
                                        <option value="855">CAMBOYA</option>
                                        <option value="237">CAMERÚN</option>
                                        <option value="1">CANADÁ</option>
                                        <option value="235">CHAD</option>
                                        <option value="56">CHILE</option>
                                        <option value="86">CHINA</option>
                                        <option value="357">CHIPRE</option>
                                        <option value="57">COLOMBIA</option>
                                        <option value="269">COMORES</option>
                                        <option value="242">CONGO</option>
                                        <option value="243">CONGO RD</option>
                                        <option value="850">COREA DEL NORTE</option>
                                        <option value="82">COREA DEL SUR</option>
                                        <option value="225">COSTA DE MARFIL</option>
                                        <option value="506">COSTA RICA</option>
                                        <option value="385">CROACIA</option>
                                        <option value="53">CUBA</option>
                                        <option value="599">CURACAO</option>
                                        <option value="45">DINAMARCA</option>
                                        <option value="1767">DOMINICA</option>
                                        <option value="1">DOMINICANA, REPÚBLICA</option>
                                        <option value="593">ECUADOR</option>
                                        <option value="20">EGIPTO</option>
                                        <option value="503">EL SALVADOR</option>
                                        <option value="971">EMIRATOS ÁRABES UNIDOS</option>
                                        <option value="291">ERITREA</option>
                                        <option value="421">ESLOVAQUIA</option>
                                        <option value="386">ESLOVENIA</option>
                                        <option value="34">ESPAÑA</option>
                                        <option value="1">ESTADOS UNIDOS</option>
                                        <option value="372">ESTONIA</option>
                                        <option value="251">ETIOPÍA</option>
                                        <option value="679">FIJI</option>
                                        <option value="63">FILIPINAS</option>
                                        <option value="358">FINLANDIA</option>
                                        <option value="33">FRANCIA</option>
                                        <option value="241">GABÓN</option>
                                        <option value="220">GAMBIA</option>
                                        <option value="995">GEORGIA</option>
                                        <option value="233">GHANA</option>
                                        <option value="350">GIBRALTAR</option>
                                        <option value="1473">GRANADA</option>
                                        <option value="30">GRECIA</option>
                                        <option value="299">GROENLANDIA</option>
                                        <option value="590">GUADALUPE</option>
                                        <option value="1671">GUAM</option>
                                        <option value="502">GUATEMALA</option>
                                        <option value="594">GUAYANA FRANCÉS</option>
                                        <option value="44">GUERNSEY</option>
                                        <option value="245">GUINEA BISSAU</option>
                                        <option value="240">GUINEA ECUATORIAL</option>
                                        <option value="592">GUYANA</option>
                                        <option value="509">HAITI</option>
                                        <option value="504">HONDURAS</option>
                                        <option value="852">HONG KONG</option>
                                        <option value="36">HUNGRÍA</option>
                                        <option value="91">INDIA</option>
                                        <option value="62">INDONESIA</option>
                                        <option value="98">IRAN</option>
                                        <option value="964">IRAQ</option>
                                        <option value="353">IRLANDA</option>
                                        <option value="247">ISLA ASCENSIÓN</option>
                                        <option value="44">ISLA DE MAN</option>
                                        <option value="61">ISLA DE NAVIDAD, ISLA CHRISTMAS</option>
                                        <option value="358">ISLA DE ÅLAND</option>
                                        <option value="672">ISLA NORFOLK</option>
                                        <option value="699">ISLA PERIFÉRICAS MENORES DE ESTADOS UNIDOS</option>
                                        <option value="354">ISLANDIA</option>
                                        <option value="1345">ISLAS CAIMÁN</option>
                                        <option value="61">ISLAS COCOS</option>
                                        <option value="682">ISLAS COOK</option>
                                        <option value="298">ISLAS FEROE</option>
                                        <option value="500">ISLAS MALVINAS</option>
                                        <option value="692">ISLAS MARSHALL</option>
                                        <option value="872">ISLAS PITCAIRN</option>
                                        <option value="677">ISLAS SALOMÓN</option>
                                        <option value="1649">ISLAS TURCAS Y CAICOS</option>
                                        <option value="128">ISLAS VÍRGENES BRITÁNICAS</option>
                                        <option value="134">ISLAS VÍRGENES DE EE.UU.</option>
                                        <option value="972">ISRAEL</option>
                                        <option value="39">ITALIA</option>
                                        <option value="187">JAMAICA</option>
                                        <option value="81">JAPÓN</option>
                                        <option value="44">JERSEY</option>
                                        <option value="962">JORDANIA</option>
                                        <option value="7">KAZAJSTÁN</option>
                                        <option value="254">KENIA</option>
                                        <option value="996">KIRGUISTÁN</option>
                                        <option value="686">KIRIBATI</option>
                                        <option value="383">KOSOVO</option>
                                        <option value="965">KUWAIT</option>
                                        <option value="856">LAOS</option>
                                        <option value="266">LESOTHO</option>
                                        <option value="371">LETONIA</option>
                                        <option value="231">LIBERIA</option>
                                        <option value="218">LIBIA</option>
                                        <option value="423">LIECHTENSTEIN</option>
                                        <option value="370">LITUANIA</option>
                                        <option value="352">LUXEMBURGO</option>
                                        <option value="961">LÍBANO</option>
                                        <option value="853">MACAO</option>
                                        <option value="389">MACEDONIA</option>
                                        <option value="261">MADAGASCAR</option>
                                        <option value="60">MALASIA</option>
                                        <option value="265">MALAWI</option>
                                        <option value="960">MALDIVAS</option>
                                        <option value="356">MALTA</option>
                                        <option value="223">MALÍ</option>
                                        <option value="1670">MARIANAS DEL NORTE</option>
                                        <option value="212">MARRUECOS</option>
                                        <option value="596">MARTINICA</option>
                                        <option value="230">MAURICIO</option>
                                        <option value="222">MAURITANIA</option>
                                        <option value="262">MAYOTTE</option>
                                        <option value="52">MEXICO</option>
                                        <option value="691">MICRONESIA</option>
                                        <option value="373">MOLDAVIA</option>
                                        <option value="976">MONGOLIA</option>
                                        <option value="382">MONTENEGRO</option>
                                        <option value="1664">MONTSERRAT</option>
                                        <option value="258">MOZAMBIQUE</option>
                                        <option value="95">MYANMAR</option>
                                        <option value="377">MÓNACO</option>
                                        <option value="264">NAMIBIA</option>
                                        <option value="674">NAURU</option>
                                        <option value="977">NEPAL</option>
                                        <option value="505">NICARAGUA</option>
                                        <option value="234">NIGERIA</option>
                                        <option value="683">NIUE</option>
                                        <option value="47">NORUEGA</option>
                                        <option value="687">NUEVA CALEDONIA</option>
                                        <option value="64">NUEVA ZELANDA</option>
                                        <option value="227">NÍGER</option>
                                        <option value="968">OMÁN</option>
                                        <option value="92">PAKISTÁN</option>
                                        <option value="680">PALAU</option>
                                        <option value="970">PALESTINA</option>
                                        <option value="507">PANAMÁ</option>
                                        <option value="675">PAPÚA</option>
                                        <option value="595">PARAGUAY</option>
                                        <option value="31">PAÍSES BAJOS, HOLANDA</option>
                                        <option value="51" selected>PERÚ</option>
                                        <option value="689">POLINESIA FRANCESA</option>
                                        <option value="48">POLONIA</option>
                                        <option value="351">PORTUGAL</option>
                                        <option value="1">PUERTO RICO</option>
                                        <option value="974">QATAR</option>
                                        <option value="44">REINO UNIDO</option>
                                        <option value="236">REPÚBLICA CENTROAFRICANA</option>
                                        <option value="420">REPÚBLICA CHECA</option>
                                        <option value="224">REPÚBLICA GUINEA</option>
                                        <option value="262">REUNIÓN</option>
                                        <option value="250">RUANDA</option>
                                        <option value="40">RUMANÍA</option>
                                        <option value="7">RUSIA</option>
                                        <option value="685">SAMOA</option>
                                        <option value="1684">SAMOA AMERICANA</option>
                                        <option value="1869">SAN CRISTÓBAL Y NEVIS</option>
                                        <option value="378">SAN MARINO</option>
                                        <option value="590">SAN MARTIN</option>
                                        <option value="508">SAN PEDRO Y MIQUELÓN</option>
                                        <option value="1784">SAN VINCENTE Y GRANADINAS</option>
                                        <option value="290">SANTA HELENA</option>
                                        <option value="1758">SANTA LUCÍA</option>
                                        <option value="239">SANTO TOMÉ Y PRÍNCIPE</option>
                                        <option value="221">SENEGAL</option>
                                        <option value="381">SERBIA</option>
                                        <option value="248">SEYCHELLES</option>
                                        <option value="232">SIERRA LEONA</option>
                                        <option value="65">SINGAPUR</option>
                                        <option value="963">SIRIA</option>
                                        <option value="252">SOMALILANDIA</option>
                                        <option value="252">SOMALÍA</option>
                                        <option value="94">SRI LANKA</option>
                                        <option value="27">SUDÁFRICA</option>
                                        <option value="249">SUDÁN</option>
                                        <option value="211">SUDÁN DEL SUR</option>
                                        <option value="46">SUECIA</option>
                                        <option value="41">SUIZA</option>
                                        <option value="597">SURINAM</option>
                                        <option value="47">SVALBARD Y JAN MAYEN</option>
                                        <option value="268">SWAZILANDIA</option>
                                        <option value="212">SÁHARA OCCIDENTAL</option>
                                        <option value="992">TADJIKISTAN</option>
                                        <option value="66">TAILANDIA</option>
                                        <option value="886">TAIWÁN</option>
                                        <option value="255">TANZANIA</option>
                                        <option value="246">TERRITORIO BRITÁNICO DEL OCÉANO ÍNDICO.</option>
                                        <option value="262">TERRITORIOS FRANCESES DEL SUR</option>
                                        <option value="670">TIMOR DEL ESTE</option>
                                        <option value="228">TOGO</option>
                                        <option value="690">TOKELAU</option>
                                        <option value="676">TONGA</option>
                                        <option value="1868">TRINIDAD Y TOBAGO</option>
                                        <option value="993">TURKMENISTÁN</option>
                                        <option value="90">TURQUÍA</option>
                                        <option value="688">TUVALU</option>
                                        <option value="216">TÚNEZ</option>
                                        <option value="380">UCRANIA</option>
                                        <option value="256">UGANDA</option>
                                        <option value="598">URUGUAY</option>
                                        <option value="998">UZBEKISTÁN</option>
                                        <option value="678">VANUATU</option>
                                        <option value="379">VATICANO</option>
                                        <option value="58">VENEZUELA</option>
                                        <option value="84">VIETNAM</option>
                                        <option value="681">WALLIS Y FUTUNA</option>
                                        <option value="967">YEMEN</option>
                                        <option value="253">YIBUTI</option>
                                        <option value="260">ZAMBIA</option>
                                        <option value="263">ZIMBÁBUE</option>
                                    </select>
                                </div>
                                <input type="tel" class="form-control" id="celular" name="phone" value="">
                            </div>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="email">Correo electrónico <span class="required">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="password">Contraseña <span class="required">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary" id="mostrar_pass_registrar"><i
                                            class="fa fa-eye-slash"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Médico <span class="required">*</span></label>
                            <select class="form-control" id="id_medico"></select>
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
        inicializarSelect2();
        if (id != 0) {
            inicializarEditForm();
        }
    }

    function inicializarSelect2() {
        $('#id_medico').select2({
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
            allowClear: true,
            closeOnSelect: true,
            ajax: {
                url: function (params) {
                    var search = '';
                    if(params.term != undefined) {
                        search = params.term;
                    }
                    return '/api/medicos?search=' + search;
                },
                processResults: function(data, params) {
                    return {
                        results: $.map(data.data, function(item) {
                            return {
                                text: `${item.lastname} ${item.name}`,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            },
        });
    }

    function inicializarEditForm() {
        $.ajax({
            type: 'get',
            url: '/api/asistentes/' + id,
            data: {},
            dataType: "json",
            success: function (response) {
                var data = response.data;
                $('#dni').val(data.dni);
                $('#apellidos').val(data.apellidos);
                $('#nombres').val(data.nombres);
                $('#celular_codigo_pais').val(data.celular_codigo_pais);
                $('#celular').val(data.celular);
                $('#email').val(data.email);
                // $('#password').val(data.password);
                var newOption = new Option(`${data.medico.lastname} ${data.medico.name}`, data.medico.id, false, false);
                $('#id_medico').append(newOption);
                $('#id_medico').val(data.id_medico).trigger('change');
            }
        });
    }

    function save() {
        $submit.html('<i class="fas fa-spinner fa-spin"></i>');
        $submit.attr('disabled', true);
        var errors = [];

        var dni = $('#dni').val();
        var apellidos = $('#apellidos').val();
        var nombres = $('#nombres').val();
        var celular_codigo_pais = $('#celular_codigo_pais').val();
        var celular = $('#celular').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var id_medico = $('#id_medico').val();

        if (dni == '') {
            errors.push('DNI ES REQUERIDO');
        }
        if (apellidos == '') {
            errors.push('APELLIDOS ES REQUERIDO');
        }
        if (nombres == '') {
            errors.push('NOMBRES ES REQUERIDO');
        }
        if (celular == '') {
            errors.push('CELULAR ES REQUERIDO');
        }
        if (email == '') {
            errors.push('EMAIL ES REQUERIDO');
        }
        if (password == '' && id == 0) {
            errors.push('CONTRASEÑA ES REQUERIDO');
        }
        if (id_medico == null) {
            errors.push('MÉDICO ES REQUERIDO');
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
                dni,
                apellidos: (apellidos != '' ? apellidos.toUpperCase() : ''),
                nombres: (nombres != '' ? nombres.toUpperCase() : ''),
                celular_codigo_pais,
                celular,
                email,
                password,
                id_medico
            }
            if (id == 0) {
                ajax_type = 'POST';
                ajax_url = '/api/asistentes';
            } else {
                ajax_type = 'PUT';
                ajax_url = '/api/asistentes/' + id;
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

    $('#dni').keypress(function (e) {
        if(e.keyCode == 13) {
            buscarDniPersona();
        }
    });

    $('#buscar_persona').click(function (e) {
        e.preventDefault();
        buscarDniPersona();
    });

    function buscarDniPersona() {
        var dni = $('#dni').val();
        if (dni.length == 8) {
            var requestURL = 'https://apis4.facttu.com/reniec/personas/' + dni;
            $.ajax({
                type: "GET",
                url: requestURL,
                dataType: "json",
                success: function(response) {
                    var persona = response.persona;
                    $('#dni').val(persona.dni);
                    $('#nombres').val(persona.nombres);
                    $('#apellidos').val(persona.apellido_paterno + ' ' + persona.apellido_materno);
                }
            });
        } else {
            msmToastr('ERROR!', 'INGRESE UN NÚMERO DE DNI VÁLIDO', 'error');
        }
    }
    $('#mostrar_pass_registrar').click(function (e) {
        e.preventDefault();
        var tipo = $('#password').attr('type');
        if(tipo == 'password') {
            $(this).html('<i class="fa fa-eye"></i>');
            $('#password').attr('type', 'text');
        } else {
            $(this).html('<i class="fa fa-eye-slash"></i>');
            $('#password').attr('type', 'password');
        }

    });
</script>
