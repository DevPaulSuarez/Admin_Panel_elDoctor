var iddepartamento = 0;
var idprovincia = 0;

// $.post('?action=departamentohorariodisponible', {
//     departamento: 0
// }, function (response) {
//     $("#departamento").html(response);
// });

$("#departamento").change(function () {
    $("#departamento option:selected").each(function () {
        iddepartamento = $(this).val();
        provincia = 0;
        CargarProvincia(iddepartamento, provincia);
    });
});
$("#provincia").change(function () {
    $("#provincia option:selected").each(function () {
        idprovincia = $(this).val();
        lugar = 0;
        CargarLugares(idprovincia, iddepartamento, lugar);
    });
});

function CargarProvincia(id, provincia_id) {
    $.get("/provincias-lugar-atencion-departamento/" + id, function (response) {
        console.log(response);
        var html = '<option>-- SELECCIONE --</option>'
        response.forEach(e => {
            if (e.idProv == provincia_id) {
                html += '<option value=' + e.idProv + ' selected>' + e.provincia + '</option>';
            } else {
                html += '<option value=' + e.idProv + '>' + e.provincia + '</option>';
            }
        });
        $("#provincia").html(html);
    });
}

function CargarLugares(provincia_id, departamento_id, lugar_id) {
    $.get("/lugares-atencion-departamento-provincia/" + departamento_id + "/" + provincia_id, function (response) {
        var html = '<option>-- SELECCIONE --</option>'
        response.forEach(e => {
            if (e.id == lugar_id) {
                html += '<option value=' + e.id + ' selected>' + e.lugar + '</option>';
            } else {
                html += '<option value=' + e.id + '>' + e.lugar + '</option>';
            }
        });
        $("#lugar").html(html);
    });
}

$('#medic_id').change(function (e) {
    e.preventDefault();
    $.get("/categorias-medico/" + $(this).val(),
        function (response) {
            var html = '<option>SELECCIONE</option>';
            response.forEach(e => {
                html += '<option value=' + e.id + '>' + e.name + '</option>';
            });
            $('#especialidad_id').html(html);
        }
    );
});