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
                            <label for="nombres">Especialidades <span class="requerid">*</span></label>
                            <select class="form-control select2" id="especialidades" multiple="multiple">
                                <option value="">SELECCIONE</option>
                            </select>
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
                                    <select class="form-control" id="celular_codigo_pais" style="width: 150px;"></select>
                                </div>
                                <input type="text" class="form-control" id="numero_celular">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 ocultar">
                        <div class="form-group">
                            <label for="password" id="text-password">Contraseña <span class="requerid">*</span></label>
                            <input type="password" class="form-control" id="password">
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

    inicializarForm();

    function inicializarForm() {
        inicializarCelularCodigoPais();
    }

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

    function inicializarCelularCodigoPais() {
        var celular_codigo_pais = [
            {
                codigo: 7,
                nombre: 'ABJASIA'
            },
            {
                codigo: 93,
                nombre: 'AFGANISTÁN'
            },
            {
                codigo: 355,
                nombre: 'ALBANIA'
            },
            {
                codigo: 49,
                nombre: 'ALEMANIA'
            },
            {
                codigo: 376,
                nombre: 'ANDORRA'
            },
            {
                codigo: 244,
                nombre: 'ANGOLA'
            },
            {
                codigo: 1264,
                nombre: 'ANGUILLA'
            },
            {
                codigo: 1268,
                nombre: 'ANTIGUA Y BARBUDA'
            },
            {
                codigo: 599,
                nombre: 'ANTILLAS HOLANDESAS'
            },
            {
                codigo: 966,
                nombre: 'ARABIA SAUDITA'
            },
            {
                codigo: 213,
                nombre: 'ARGELIA'
            },
            {
                codigo: 54,
                nombre: 'ARGENTINA'
            },
            {
                codigo: 374,
                nombre: 'ARMENIA'
            },
            {
                codigo: 297,
                nombre: 'ARUBA'
            },
            {
                codigo: 61,
                nombre: 'AUSTRALIA'
            },
            {
                codigo: 43,
                nombre: 'AUSTRIA'
            },
            {
                codigo: 994,
                nombre: 'AZERBAIYÁN'
            },
            {
                codigo: 1242,
                nombre: 'BAHAMAS'
            },
            {
                codigo: 973,
                nombre: 'BAHREIN'
            },
            {
                codigo: 880,
                nombre: 'BANGLADESH'
            },
            {
                codigo: 1246,
                nombre: 'BARBADOS'
            },
            {
                codigo: 501,
                nombre: 'BELICE'
            },
            {
                codigo: 229,
                nombre: 'BENIN'
            },
            {
                codigo: 1441,
                nombre: 'BERMUDAS'
            },
            {
                codigo: 375,
                nombre: 'BIELORRUSIA'
            },
            {
                codigo: 591,
                nombre: 'BOLIVIA'
            },
            {
                codigo: 599,
                nombre: 'BONAIRE'
            },
            {
                codigo: 387,
                nombre: 'BOSNIA'
            },
            {
                codigo: 267,
                nombre: 'BOTSWANA'
            },
            {
                codigo: 55,
                nombre: 'BRASIL'
            },
            {
                codigo: 673,
                nombre: 'BRUNEI DARUSSALAM'
            },
            {
                codigo: 359,
                nombre: 'BULGARIA'
            },
            {
                codigo: 226,
                nombre: 'BURKINA FASO'
            },
            {
                codigo: 257,
                nombre: 'BURUNDI'
            },
            {
                codigo: 975,
                nombre: 'BUTÁN'
            },
            {
                codigo: 32,
                nombre: 'BÉLGICA'
            },
            {
                codigo: 238,
                nombre: 'CABO VERDE'
            },
            {
                codigo: 855,
                nombre: 'CAMBOYA'
            },
            {
                codigo: 237,
                nombre: 'CAMERÚN'
            },
            {
                codigo: 1,
                nombre: 'CANADÁ'
            },
            {
                codigo: 235,
                nombre: 'CHAD'
            },
            {
                codigo: 56,
                nombre: 'CHILE'
            },
            {
                codigo: 86,
                nombre: 'CHINA'
            },
            {
                codigo: 357,
                nombre: 'CHIPRE'
            },
            {
                codigo: 57,
                nombre: 'COLOMBIA'
            },
            {
                codigo: 269,
                nombre: 'COMORES'
            },
            {
                codigo: 242,
                nombre: 'CONGO'
            },
            {
                codigo: 243,
                nombre: 'CONGO RD'
            },
            {
                codigo: 850,
                nombre: 'COREA DEL NORTE'
            },
            {
                codigo: 82,
                nombre: 'COREA DEL SUR'
            },
            {
                codigo: 225,
                nombre: 'COSTA DE MARFIL'
            },
            {
                codigo: 506,
                nombre: 'COSTA RICA'
            },
            {
                codigo: 385,
                nombre: 'CROACIA'
            },
            {
                codigo: 53,
                nombre: 'CUBA'
            },
            {
                codigo: 599,
                nombre: 'CURACAO'
            },
            {
                codigo: 45,
                nombre: 'DINAMARCA'
            },
            {
                codigo: 1767,
                nombre: 'DOMINICA'
            },
            {
                codigo: 1,
                nombre: 'DOMINICANA, REPÚBLICA'
            },
            {
                codigo: 593,
                nombre: 'ECUADOR'
            },
            {
                codigo: 20,
                nombre: 'EGIPTO'
            },
            {
                codigo: 503,
                nombre: 'EL SALVADOR'
            },
            {
                codigo: 971,
                nombre: 'EMIRATOS ÁRABES UNIDOS'
            },
            {
                codigo: 291,
                nombre: 'ERITREA'
            },
            {
                codigo: 421,
                nombre: 'ESLOVAQUIA'
            },
            {
                codigo: 386,
                nombre: 'ESLOVENIA'
            },
            {
                codigo: 34,
                nombre: 'ESPAÑA'
            },
            {
                codigo: 1,
                nombre: 'ESTADOS UNIDOS'
            },
            {
                codigo: 372,
                nombre: 'ESTONIA'
            },
            {
                codigo: 251,
                nombre: 'ETIOPÍA'
            },
            {
                codigo: 679,
                nombre: 'FIJI'
            },
            {
                codigo: 63,
                nombre: 'FILIPINAS'
            },
            {
                codigo: 358,
                nombre: 'FINLANDIA'
            },
            {
                codigo: 33,
                nombre: 'FRANCIA'
            },
            {
                codigo: 241,
                nombre: 'GABÓN'
            },
            {
                codigo: 220,
                nombre: 'GAMBIA'
            },
            {
                codigo: 995,
                nombre: 'GEORGIA'
            },
            {
                codigo: 233,
                nombre: 'GHANA'
            },
            {
                codigo: 350,
                nombre: 'GIBRALTAR'
            },
            {
                codigo: 1473,
                nombre: 'GRANADA'
            },
            {
                codigo: 30,
                nombre: 'GRECIA'
            },
            {
                codigo: 299,
                nombre: 'GROENLANDIA'
            },
            {
                codigo: 590,
                nombre: 'GUADALUPE'
            },
            {
                codigo: 1671,
                nombre: 'GUAM'
            },
            {
                codigo: 502,
                nombre: 'GUATEMALA'
            },
            {
                codigo: 594,
                nombre: 'GUAYANA FRANCÉS'
            },
            {
                codigo: 44,
                nombre: 'GUERNSEY'
            },
            {
                codigo: 245,
                nombre: 'GUINEA BISSAU'
            },
            {
                codigo: 240,
                nombre: 'GUINEA ECUATORIAL'
            },
            {
                codigo: 592,
                nombre: 'GUYANA'
            },
            {
                codigo: 509,
                nombre: 'HAITI'
            },
            {
                codigo: 504,
                nombre: 'HONDURAS'
            },
            {
                codigo: 852,
                nombre: 'HONG KONG'
            },
            {
                codigo: 36,
                nombre: 'HUNGRÍA'
            },
            {
                codigo: 91,
                nombre: 'INDIA'
            },
            {
                codigo: 62,
                nombre: 'INDONESIA'
            },
            {
                codigo: 98,
                nombre: 'IRAN'
            },
            {
                codigo: 964,
                nombre: 'IRAQ'
            },
            {
                codigo: 353,
                nombre: 'IRLANDA'
            },
            {
                codigo: 247,
                nombre: 'ISLA ASCENSIÓN'
            },
            {
                codigo: 44,
                nombre: 'ISLA DE MAN'
            },
            {
                codigo: 61,
                nombre: 'ISLA DE NAVIDAD, ISLA CHRISTMAS'
            },
            {
                codigo: 358,
                nombre: 'ISLA DE ÅLAND'
            },
            {
                codigo: 672,
                nombre: 'ISLA NORFOLK'
            },
            {
                codigo: 699,
                nombre: 'ISLA PERIFÉRICAS MENORES DE ESTADOS UNIDOS'
            },
            {
                codigo: 354,
                nombre: 'ISLANDIA'
            },
            {
                codigo: 1345,
                nombre: 'ISLAS CAIMÁN'
            },
            {
                codigo: 61,
                nombre: 'ISLAS COCOS'
            },
            {
                codigo: 682,
                nombre: 'ISLAS COOK'
            },
            {
                codigo: 298,
                nombre: 'ISLAS FEROE'
            },
            {
                codigo: 500,
                nombre: 'ISLAS MALVINAS'
            },
            {
                codigo: 692,
                nombre: 'ISLAS MARSHALL'
            },
            {
                codigo: 872,
                nombre: 'ISLAS PITCAIRN'
            },
            {
                codigo: 677,
                nombre: 'ISLAS SALOMÓN'
            },
            {
                codigo: 1649,
                nombre: 'ISLAS TURCAS Y CAICOS'
            },
            {
                codigo: 128,
                nombre: 'ISLAS VÍRGENES BRITÁNICAS'
            },
            {
                codigo: 134,
                nombre: 'ISLAS VÍRGENES DE EE.UU.'
            },
            {
                codigo: 972,
                nombre: 'ISRAEL'
            },
            {
                codigo: 39,
                nombre: 'ITALIA'
            },
            {
                codigo: 187,
                nombre: 'JAMAICA'
            },
            {
                codigo: 81,
                nombre: 'JAPÓN'
            },
            {
                codigo: 44,
                nombre: 'JERSEY'
            },
            {
                codigo: 962,
                nombre: 'JORDANIA'
            },
            {
                codigo: 7,
                nombre: 'KAZAJSTÁN'
            },
            {
                codigo: 254,
                nombre: 'KENIA'
            },
            {
                codigo: 996,
                nombre: 'KIRGUISTÁN'
            },
            {
                codigo: 686,
                nombre: 'KIRIBATI'
            },
            {
                codigo: 383,
                nombre: 'KOSOVO'
            },
            {
                codigo: 965,
                nombre: 'KUWAIT'
            },
            {
                codigo: 856,
                nombre: 'LAOS'
            },
            {
                codigo: 266,
                nombre: 'LESOTHO'
            },
            {
                codigo: 371,
                nombre: 'LETONIA'
            },
            {
                codigo: 231,
                nombre: 'LIBERIA'
            },
            {
                codigo: 218,
                nombre: 'LIBIA'
            },
            {
                codigo: 423,
                nombre: 'LIECHTENSTEIN'
            },
            {
                codigo: 370,
                nombre: 'LITUANIA'
            },
            {
                codigo: 352,
                nombre: 'LUXEMBURGO'
            },
            {
                codigo: 961,
                nombre: 'LÍBANO'
            },
            {
                codigo: 853,
                nombre: 'MACAO'
            },
            {
                codigo: 389,
                nombre: 'MACEDONIA'
            },
            {
                codigo: 261,
                nombre: 'MADAGASCAR'
            },
            {
                codigo: 60,
                nombre: 'MALASIA'
            },
            {
                codigo: 265,
                nombre: 'MALAWI'
            },
            {
                codigo: 960,
                nombre: 'MALDIVAS'
            },
            {
                codigo: 356,
                nombre: 'MALTA'
            },
            {
                codigo: 223,
                nombre: 'MALÍ'
            },
            {
                codigo: 1670,
                nombre: 'MARIANAS DEL NORTE'
            },
            {
                codigo: 212,
                nombre: 'MARRUECOS'
            },
            {
                codigo: 596,
                nombre: 'MARTINICA'
            },
            {
                codigo: 230,
                nombre: 'MAURICIO'
            },
            {
                codigo: 222,
                nombre: 'MAURITANIA'
            },
            {
                codigo: 262,
                nombre: 'MAYOTTE'
            },
            {
                codigo: 52,
                nombre: 'MEXICO'
            },
            {
                codigo: 691,
                nombre: 'MICRONESIA'
            },
            {
                codigo: 373,
                nombre: 'MOLDAVIA'
            },
            {
                codigo: 976,
                nombre: 'MONGOLIA'
            },
            {
                codigo: 382,
                nombre: 'MONTENEGRO'
            },
            {
                codigo: 1664,
                nombre: 'MONTSERRAT'
            },
            {
                codigo: 258,
                nombre: 'MOZAMBIQUE'
            },
            {
                codigo: 95,
                nombre: 'MYANMAR'
            },
            {
                codigo: 377,
                nombre: 'MÓNACO'
            },
            {
                codigo: 264,
                nombre: 'NAMIBIA'
            },
            {
                codigo: 674,
                nombre: 'NAURU'
            },
            {
                codigo: 977,
                nombre: 'NEPAL'
            },
            {
                codigo: 505,
                nombre: 'NICARAGUA'
            },
            {
                codigo: 234,
                nombre: 'NIGERIA'
            },
            {
                codigo: 683,
                nombre: 'NIUE'
            },
            {
                codigo: 47,
                nombre: 'NORUEGA'
            },
            {
                codigo: 687,
                nombre: 'NUEVA CALEDONIA'
            },
            {
                codigo: 64,
                nombre: 'NUEVA ZELANDA'
            },
            {
                codigo: 227,
                nombre: 'NÍGER'
            },
            {
                codigo: 968,
                nombre: 'OMÁN'
            },
            {
                codigo: 92,
                nombre: 'PAKISTÁN'
            },
            {
                codigo: 680,
                nombre: 'PALAU'
            },
            {
                codigo: 970,
                nombre: 'PALESTINA'
            },
            {
                codigo: 507,
                nombre: 'PANAMÁ'
            },
            {
                codigo: 675,
                nombre: 'PAPÚA'
            },
            {
                codigo: 595,
                nombre: 'PARAGUAY'
            },
            {
                codigo: 31,
                nombre: 'PAÍSES BAJOS, HOLANDA'
            },
            {
                codigo: 51,
                nombre: 'PERÚ'
            },
            {
                codigo: 689,
                nombre: 'POLINESIA FRANCESA'
            },
            {
                codigo: 48,
                nombre: 'POLONIA'
            },
            {
                codigo: 351,
                nombre: 'PORTUGAL'
            },
            {
                codigo: 1,
                nombre: 'PUERTO RICO'
            },
            {
                codigo: 974,
                nombre: 'QATAR'
            },
            {
                codigo: 44,
                nombre: 'REINO UNIDO'
            },
            {
                codigo: 236,
                nombre: 'REPÚBLICA CENTROAFRICANA'
            },
            {
                codigo: 420,
                nombre: 'REPÚBLICA CHECA'
            },
            {
                codigo: 224,
                nombre: 'REPÚBLICA GUINEA'
            },
            {
                codigo: 262,
                nombre: 'REUNIÓN'
            },
            {
                codigo: 250,
                nombre: 'RUANDA'
            },
            {
                codigo: 40,
                nombre: 'RUMANÍA'
            },
            {
                codigo: 7,
                nombre: 'RUSIA'
            },
            {
                codigo: 685,
                nombre: 'SAMOA'
            },
            {
                codigo: 1684,
                nombre: 'SAMOA AMERICANA'
            },
            {
                codigo: 1869,
                nombre: 'SAN CRISTÓBAL Y NEVIS'
            },
            {
                codigo: 378,
                nombre: 'SAN MARINO'
            },
            {
                codigo: 590,
                nombre: 'SAN MARTIN'
            },
            {
                codigo: 508,
                nombre: 'SAN PEDRO Y MIQUELÓN'
            },
            {
                codigo: 1784,
                nombre: 'SAN VINCENTE Y GRANADINAS'
            },
            {
                codigo: 290,
                nombre: 'SANTA HELENA'
            },
            {
                codigo: 1758,
                nombre: 'SANTA LUCÍA'
            },
            {
                codigo: 239,
                nombre: 'SANTO TOMÉ Y PRÍNCIPE'
            },
            {
                codigo: 221,
                nombre: 'SENEGAL'
            },
            {
                codigo: 381,
                nombre: 'SERBIA'
            },
            {
                codigo: 248,
                nombre: 'SEYCHELLES'
            },
            {
                codigo: 232,
                nombre: 'SIERRA LEONA'
            },
            {
                codigo: 65,
                nombre: 'SINGAPUR'
            },
            {
                codigo: 963,
                nombre: 'SIRIA'
            },
            {
                codigo: 252,
                nombre: 'SOMALILANDIA'
            },
            {
                codigo: 252,
                nombre: 'SOMALÍA'
            },
            {
                codigo: 94,
                nombre: 'SRI LANKA'
            },
            {
                codigo: 27,
                nombre: 'SUDÁFRICA'
            },
            {
                codigo: 249,
                nombre: 'SUDÁN'
            },
            {
                codigo: 211,
                nombre: 'SUDÁN DEL SUR'
            },
            {
                codigo: 46,
                nombre: 'SUECIA'
            },
            {
                codigo: 41,
                nombre: 'SUIZA'
            },
            {
                codigo: 597,
                nombre: 'SURINAM'
            },
            {
                codigo: 47,
                nombre: 'SVALBARD Y JAN MAYEN'
            },
            {
                codigo: 268,
                nombre: 'SWAZILANDIA'
            },
            {
                codigo: 212,
                nombre: 'SÁHARA OCCIDENTAL'
            },
            {
                codigo: 992,
                nombre: 'TADJIKISTAN'
            },
            {
                codigo: 66,
                nombre: 'TAILANDIA'
            },
            {
                codigo: 886,
                nombre: 'TAIWÁN'
            },
            {
                codigo: 255,
                nombre: 'TANZANIA'
            },
            {
                codigo: 246,
                nombre: 'TERRITORIO BRITÁNICO DEL OCÉANO ÍNDICO.'
            },
            {
                codigo: 262,
                nombre: 'TERRITORIOS FRANCESES DEL SUR'
            },
            {
                codigo: 670,
                nombre: 'TIMOR DEL ESTE'
            },
            {
                codigo: 228,
                nombre: 'TOGO'
            },
            {
                codigo: 690,
                nombre: 'TOKELAU'
            },
            {
                codigo: 676,
                nombre: 'TONGA'
            },
            {
                codigo: 1868,
                nombre: 'TRINIDAD Y TOBAGO'
            },
            {
                codigo: 993,
                nombre: 'TURKMENISTÁN'
            },
            {
                codigo: 90,
                nombre: 'TURQUÍA'
            },
            {
                codigo: 688,
                nombre: 'TUVALU'
            },
            {
                codigo: 216,
                nombre: 'TÚNEZ'
            },
            {
                codigo: 380,
                nombre: 'UCRANIA'
            },
            {
                codigo: 256,
                nombre: 'UGANDA'
            },
            {
                codigo: 598,
                nombre: 'URUGUAY'
            },
            {
                codigo: 998,
                nombre: 'UZBEKISTÁN'
            },
            {
                codigo: 678,
                nombre: 'VANUATU'
            },
            {
                codigo: 379,
                nombre: 'VATICANO'
            },
            {
                codigo: 58,
                nombre: 'VENEZUELA'
            },
            {
                codigo: 84,
                nombre: 'VIETNAM'
            },
            {
                codigo: 681,
                nombre: 'WALLIS Y FUTUNA'
            },
            {
                codigo: 967,
                nombre: 'YEMEN'
            },
            {
                codigo: 253,
                nombre: 'YIBUTI'
            },
            {
                codigo: 260,
                nombre: 'ZAMBIA'
            },
            {
                codigo: 263,
                nombre: 'ZIMBÁBUE'
            },
        ];

        var html = '';
        celular_codigo_pais.forEach(e => {
            html += '<option value="'+e.codigo+'" '+(e.codigo == 51 ? 'selected' : '')+'>'+e.nombre+'</option>';
        });
        $('#celular_codigo_pais').html(html);
    }



</script>
