<div class="modal" id="mdFormCreate">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Paciente</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="dni_registrar">Tipo de documento <span class="requerido">*</span></label>
                            <select class="form-control" id="tipo_documento">
                                <option value="DNI" selected>DNI</option>
                                <option value="CARNET EXT">CARNET EXT.</option>
                                <option value="PASAPORTE">PASAPORTE</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="numero_documento">Número de documento <span class="requerid">*</span></label>
                            <input type="text" class="form-control no_is_dni" id="numero_documento" value="" style="display: none;">
                            <div class="input-group is_dni">
                                <input type="text" class="form-control" id="dni">
                                <span class="input-group-addon" id="sufixId"><button type="button" class="btn btn-info" id="buscar"><i class="fas fa-search"></i></button></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="apellido_paterno">Apellidos <span class="requerid">*</span></label>
                            <input type="text" class="form-control" id="apellidos">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombres">Nombres <span class="requerid">*</span></label>
                            <input type="text" class="form-control" id="nombres">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="email">Email <span class="requerid">*</span></label>
                            <input type="text" class="form-control" id="email">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="numero_celular">Número de celular <span class="requerid">*</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
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
                                <input type="text" class="form-control" id="numero_celular">
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

<script>
    $('#tipo_documento').change(function (e) {
        e.preventDefault();
        var tipo_documento = $(this).val();

        if (tipo_documento == 'DNI') {
            $('.is_dni').show();
            $('.no_is_dni').hide();
        } else {
            $('.is_dni').hide();
            $('.no_is_dni').show();
        }
    });
</script>
