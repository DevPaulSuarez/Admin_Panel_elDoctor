YearActual = moment().format("YYYY");
MesActual = moment().format("MM");
var medio_atencion;
Medic_Id = 0;
$(document).ready(function () {
     IniciarCalendario();
});

function IniciarCalendario() {
     Hoy = moment().format('YYYY-MM-DD');
     $('#calendar').fullCalendar({
          lang: 'es',
          header: {
               left: 'prev,next today',
               center: 'title',
               right: 'month,agendaWeek,agendaDay'
          },
          defaultDate: Hoy,
          editable: false,
          eventLimit: 3,
          viewRender: function (view, element) {
               FechaActualCalendario;
               obtenerHorario;
          },
          dayClick: function (date, jsEvent, view, resourceObj) {
               if (Hoy <= date.format() && Medic_Id > 0) {
                    $("#departamento").empty();
                    // $("#provincia").html('<option value="">-- SELECCIONE --</option>');
                    // $("#lugar").html('<option value="">-- SELECCIONE --</option>');
                    $("#id_especialidades").empty();
                    ModalNuevoHorario(date.format());
               }
          },
          eventClick: function (calEvent, jsEvent, view) {
               $("#id_especialidades").empty();
               ModalEditarHorario(calEvent);
          }
     });
}

$("#especilidad_id").change(function () {
     $("#especilidad_id option:selected").each(function () {
          id = $(this).val();
          $.get("/medicos/" + $('#clinica_id').val() + "/" + id, function (response) {
               var html = '<option selected>-- SELECCIONE --</option>';
               response.forEach(e => {
                    html += '<option value=' + e.id + '>' + e.lastname + ' ' + e.name + '</option>';
               });
               $("#medic_id").html(html);
               // $("#medic_id").change();
          });
     });
});

$("#medic_id").change(function () {
     $("#medic_id option:selected").each(function () {
          Medic_Id = $(this).val();
          obtenerHorario();
          CapturarDatosModal();
     });
});

function obtenerHorario() {
     var data = {
          id_medico: Medic_Id
     }
     $.ajax({
          type: "get",
          url: "https://doctor3.syslacsdev.com/api/horarios",
          data: data,
          dataType: "json",
          success: function (response) {
               if (response.success) {
                    var eventos = [];
                    if (response.data.length > 0) {
                         response.data.forEach(e => {
                              var color, title;
                              if (e.medio_atencion == 'VIRTUAL') {
                                   color = 'rgb(61, 92, 168)';
                                   title = e.medio_atencion;
                              }
                              if (e.medio_atencion == 'PRESENCIAL') {
                                   color = '#ff9f89';
                                   title = 'EN CONSULTORIO';
                              }
                              eventos.push({
                                   id: e.id,
                                   title: title,
                                   start: e.fecha + 'T' + e.horainicio,
                                   end: e.fecha + 'T' + e.horafin,
                                   color: color,
                              });
                         });

                    }
                    $('#calendar').fullCalendar('removeEvents');
                    $('#calendar').fullCalendar('addEventSource', eventos);
                    $('#calendar').fullCalendar('rerenderEvents');
               }
          }
     });
}

// function obtenerHorario() {
//      $.get('/horarios-medico-disponibles/' + Medic_Id, function (NuevosEventos) {
//           DibujarEventos(NuevosEventos);
//      });
// }

// function DibujarEventos(NuevosEventos) {
//      $('#calendar').fullCalendar('removeEvents');
//      $('#calendar').fullCalendar('addEventSource', NuevosEventos);
//      $('#calendar').fullCalendar('rerenderEvents');
// }

function FechaActualCalendario() {
     FechaCalendario = $("#calendar").fullCalendar('getDate');
     YearActual = FechaCalendario.format("YYYY");
     MesActual = FechaCalendario.format("MM");
}

function ModalNuevoHorario(fechamodal) {
     $('#error').hide();
     $('#consultorios').hide();
     $('#nombreaccion').text('Nuevo Horario de Atención');
     $('#horarioid').val(0);
     $('#fecha').val(fechamodal);
     $('#fechareserva').html('Fecha: ' + moment(fechamodal, "YYYY-MM-DD").format("DD-MM-YYYY"));
     $('#hora_inicio').val(0);
     $('#hora_fin').val(0);
     $('#botones').html('<button onclick="NuevoHorario();" class="btn btn-primary" type="submit">Nuevo Horario</button>');
     $('#medio_atencion').val('VIRTUAL');
     medio_atencion = 'VIRTUAL';
     ConfiguracionSelectModal();
     // CargarDepartamento(0);
     // $("#departamento").val(null);
     // $("#provincia").val(null);
     // $("#lugar").val(null);
     $('#myModalNuevoHorario').modal('toggle');
     $('#id_consultorio').select2({
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
               url: 'https://doctor3.syslacsdev.com/api/lugar-atencion-medico?id_medico=' + Medic_Id,
               dataType: 'json',
               processResults: function (data, params) {
                    return {
                         results: $.map(data.data, function (item) {
                              return {
                                   text: item.direccion,
                                   id: item.id
                              }
                         })
                    };
               },
               cache: true
          },
     });
     $('#id_especialidades').select2({
          placeholder: 'SELECCIONE',
          language: {
               noResults: function () {
                    return "No hay resultado";
               },
               searching: function () {
                    return "Buscando..";
               }
          },
          width: '100%',
          closeOnSelect: false,
          allowClear: true,
          ajax: {
               url: '/categorias-medico/' + Medic_Id,
               processResults: function (data) {
                    var array = [];
                    data.forEach(e => {
                         array.push({
                              id: e.id,
                              text: e.name
                         })
                    });
                    return {
                         results: array
                    };
               }
          }
     });
}

function ModalEditarHorario(Evento) {
     $('#consultorios').hide();
     $('#nombreaccion').text('Editar Horario de Atención');
     $('#horarioid').val(Evento.id);
     $('#fechareserva').html('Fecha: ' + Evento.start.format('DD-MM-YYYY'));
     $('#hora_inicio').val(Evento.start.format('HH:mm:ss'));
     $('#hora_fin').val(Evento.end.format('HH:mm:ss'));
     $('#botones').html('<button onclick="EditarHorario();" class="btn btn-primary" type="submit">Editar Horario</button>' +
          '<button class="btn btn-danger" onclick="EliminarHorario();" type="submit">Eliminar Horario</button>');
     ConfiguracionSelectModal();
     // CargarDepartamento(Evento.iddepartamento);
     // CargarProvincia(Evento.iddepartamento, Evento.idprovincia);
     // CargarLugares(Evento.iddepartamento, Evento.idprovincia, Evento.idlugar);
     $('#id_especialidades').select2({
          placeholder: 'SELECCIONE',
          language: {
               noResults: function () {
                    return "No hay resultado";
               },
               searching: function () {
                    return "Buscando..";
               }
          },
          width: '100%',
          closeOnSelect: false,
          allowClear: true,
          ajax: {
               url: '/categorias-medico/' + Medic_Id,
               processResults: function (data) {
                    var array = [];
                    data.forEach(e => {
                         array.push({
                              id: e.id,
                              text: e.name
                         })
                    });
                    return {
                         results: array
                    };
               }
          }
     });
     $.ajax({
          type: "get",
          url: "https://doctor3.syslacsdev.com/api/horarios/" + Evento.id,
          dataType: "json",
          success: function (response) {
               if (response.success) {
                    medio_atencion = response.data.medio_atencion;
                    $('#medio_atencion').val(response.data.medio_atencion);
                    if (response.data.medio_atencion == 'PRESENCIAL') {
                         $('#consultorios').show();
                    }
                    if (response.data.lugar_atencion_medico) {
                         $('#id_consultorio').empty();
                         var newOption = new Option(response.data.lugar_atencion_medico.direccion, response.data.lugar_atencion_medico.id, true, true);
                         $('#id_consultorio').append(newOption);
                    }
                    if (response.data.especialidades) {
                         $('#id_especialidades').empty();
                         response.data.especialidades.forEach(e => {
                              var newOption = new Option(e.name, e.id, true, true);
                              $('#id_especialidades').append(newOption);
                         });
                    }

                    $('#myModalNuevoHorario').modal({
                         keyboard: false
                    });
               }
          }
     });
     // var especilidades_id = [];
     // Evento.especialidades.forEach(e => {
     //      especilidades_id.push(e.id);
     //      var newOption = new Option(e.name, e.id, true, true);
     //      $('#id_especialidades').append(newOption).trigger('change');
     // });
     // $('#id_especialidades').val(especilidades_id).trigger('change');
}

$('#medio_atencion').change(function (e) {
     e.preventDefault();
     medio_atencion = $(this).val();
     if (medio_atencion == 'VIRTUAL') {
          $('#consultorios').hide();
     }
     if (medio_atencion == 'PRESENCIAL') {
          $('#consultorios').show();
     }
});

function ConfiguracionSelectModal() {
     $('#DoctorSeleccionado').html('Dr(a): ' + NombreDoctor);
     $("#departamento").change(function () {
          $("#departamento option:selected").each(function () {
               id = $(this).val();
               CargarProvincia(id, 0);
          });
     });
     $("#provincia").change(function () {
          $("#provincia option:selected").each(function () {
               idprovincia = $(this).val();
               iddepartamento = $("#departamento").val();
               lugar = 0;
               CargarLugares(iddepartamento, idprovincia, lugar);
          });
     });
}

// function CargarDepartamento(departamento) {
//      $.get('/departamentos-lugar-atencion', function (response) {
//           var html = '<option>-- SELECCIONE --</option>'
//           response.forEach(e => {
//                if (e.idDepa == departamento) {
//                     html += '<option value=' + e.idDepa + ' selected>' + e.departamento + '</option>';
//                } else {
//                     html += '<option value=' + e.idDepa + '>' + e.departamento + '</option>';
//                }
//           });
//           $("#departamento").html(html);
//      });
// }

// function CargarLugares(departamento_id, provincia_id, lugar_id) {
//      $.get("/lugares-atencion-departamento-provincia/" + departamento_id + "/" + provincia_id, function (response) {
//           var html = '<option>-- SELECCIONE --</option>'
//           response.forEach(e => {
//                if (e.id == lugar_id) {
//                     html += '<option value=' + e.id + ' selected>' + e.lugar + '</option>';
//                } else {
//                     html += '<option value=' + e.id + '>' + e.lugar + '</option>';
//                }
//           });
//           $("#lugar").html(html);
//      });
// }

// function CargarProvincia(departamento_id, provincia_id) {
//      $.get("/provincias-lugar-atencion-departamento/" + departamento_id, function (response) {
//           var html = '<option>-- SELECCIONE --</option>'
//           response.forEach(e => {
//                if (e.idProv == provincia_id) {
//                     html += '<option value=' + e.idProv + ' selected>' + e.provincia + '</option>';
//                } else {
//                     html += '<option value=' + e.idProv + '>' + e.provincia + '</option>';
//                }
//           });
//           $("#provincia").html(html);
//      });
// }

function NuevoHorario() {
     var error = '';

     var id_especialidad = $('#id_especialidades').val();
     var hora_inicio = $('#hora_inicio').val();
     var hora_fin = $('#hora_fin').val();

     if (medio_atencion == 'PRESENCIAL') {
          var id_consultorio = $('#id_consultorio').val();
          if (id_consultorio == null) {
               error += '<li>CONSULTORIO ES REQUERIDO</li>';
          }
     }

     if (id_especialidad == null) {
          error += '<li>ESPECIALIDAD ES REQUERIDO</li>';
     }
     if (hora_inicio == '') {
          error += '<li>HORA DE INICIO ES REQUERIDO</li>';
     }
     if (hora_fin == '') {
          error += '<li>HORA DE FIN ES REQUERIDO</li>';
     }
     if (hora_inicio != '' && hora_fin != '') {
          if (moment(hora_fin, 'LT').format('HH:mm:ss') <= moment(hora_inicio, 'LT').format('HH:mm:ss')) {
               error += '<li>HORA DE FIN DEBE SER MAYOR A HORA DE INICIO</li>';
          }
     }
     if (error != '') {
          $('#error').show();
          $('#listError').html(error);
     } else {
          $('#error').hide();
          var data = {
               medio_atencion,
               id_medico: Medic_Id,
               id_especialidades: $('#id_especialidades').val(),
               fecha: $('#fecha').val(),
               hora_inicio: moment($('#hora_inicio').val(), 'LT').format('HH:mm:ss'),
               hora_fin: moment($('#hora_fin').val(), 'LT').format('HH:mm:ss'),
          }
          if (medio_atencion == 'PRESENCIAL') {
               data['id_lugar_atencion_medico'] = $('#id_consultorio').val();
          }
          $.ajax({
               type: "post",
               url: "https://doctor3.syslacsdev.com/api/horarios",
               data: data,
               dataType: "json",
               success: function (response) {
                    if (response.success) {
                         obtenerHorario();
                         $('#myModalNuevoHorario').modal('hide');
                    } else {
                         var errors = '';
                         response.error.forEach(e => {
                              errors += '<li>' + e + '</li>';
                         });
                         $('#error').show();
                         $('#listError').html(errors);
                    }
               }
          });
     }
}

function EditarHorario() {
     var error = '';

     var id_especialidad = $('#id_especialidades').val();
     var hora_inicio = $('#hora_inicio').val();
     var hora_fin = $('#hora_fin').val();

     if (medio_atencion == 'PRESENCIAL') {
          var id_consultorio = $('#id_consultorio').val();
          if (id_consultorio == null) {
               error += '<li>CONSULTORIO ES REQUERIDO</li>';
          }
     }

     if (id_especialidad == null) {
          error += '<li>ESPECIALIDAD ES REQUERIDO</li>';
     }
     if (hora_inicio == '') {
          error += '<li>HORA DE INICIO ES REQUERIDO</li>';
     }
     if (hora_fin == '') {
          error += '<li>HORA DE FIN ES REQUERIDO</li>';
     }
     if (hora_inicio != '' && hora_fin != '') {
          if (moment(hora_fin, 'LT').format('HH:mm:ss') <= moment(hora_inicio, 'LT').format('HH:mm:ss')) {
               error += '<li>HORA DE FIN DEBE SER MAYOR A HORA DE INICIO</li>';
          }
     }
     if (error != '') {
          $('#error').show();
          $('#listError').html(error);
     } else {
          $('#error').hide();
          var data = {
               medio_atencion,
               id_medico: Medic_Id,
               id_especialidades: $('#id_especialidades').val(),
               fecha: $('#fecha').val(),
               hora_inicio: moment($('#hora_inicio').val(), 'LT').format('HH:mm:ss'),
               hora_fin: moment($('#hora_fin').val(), 'LT').format('HH:mm:ss'),
          }
          if (medio_atencion == 'PRESENCIAL') {
               data['id_lugar_atencion_medico'] = $('#id_consultorio').val();
          }
          $.ajax({
               type: "put",
               url: "https://doctor3.syslacsdev.com/api/horarios/" + $('#horarioid').val(),
               data: data,
               dataType: "json",
               success: function (response) {
                    if (response.success) {
                         obtenerHorario();
                         $('#myModalNuevoHorario').modal('hide');
                    } else {
                         var errors = '';
                         response.error.forEach(e => {
                              errors += '<li>' + e + '</li>';
                         });
                         $('#error').show();
                         $('#listError').html(errors);
                    }
               }
          });
     }
}

function EliminarHorario() {
     horarioid = $('#horarioid').val();

     $.ajax({
          type: "delete",
          url: "https://doctor3.syslacsdev.com/api/horarios/" + horarioid,
          dataType: "json",
          success: function (response) {
               if (response.success) {
                    ReloadCalendar();
               } else {
                    var errors = '';
                    response.error.forEach(e => {
                         errors += '<li>' + e + '</li>';
                    });
                    $('#error').show();
                    $('#listError').html(errors);
               }
          }
     });
}

function CapturarDatosModal() {
     NombreDoctor = $("#medic_id option:selected").text();
}

function ReloadCalendar() {
     obtenerHorario();
     $('#myModalNuevoHorario').modal('hide');
}