var conversation_id = 0;
var MensajesLocales = [];
var SolicitudesLocales = [];
var IsLoading = false;
var user_id = 0;
$(function() {
  setInterval(ObtenerSolicitudes, 2000);
  setInterval(ObtenerMensajes, 2000);
});

function ObtenerMensajes() {
  //if (IsLoading) return;
  IsLoading = true;
  $.ajax({
      type: "GET",
      data: {
          conversation_id
      },
      dataType: 'json',
      url: '?action=loadmessages',
      success: function(mensajes) {
          MostrarMensajes(mensajes);
      }
  });
}

function MostrarMensajes(messages) {
  var MensajeNuevos;
  MensajeNuevos = FiltrarMensajes(messages);
  for (i = 0; i < MensajeNuevos.length; i++) {
      AgregarMensajeChat(MensajeNuevos[i]);
  }
  IsLoading = false;
}

function FiltrarMensajes(messages) {
  var MensajeNuevos = [];
  var Existe;
  for (i = 0; i < messages.length; i++) {
    Existe = false;
    for (j = 0; j < MensajesLocales.length; j++) {
      if (messages[i].id == MensajesLocales[j].id) {
          Existe = true;
          break;
      }
    }
    if (!Existe) {
        MensajeNuevos.push(messages[i]);
    }
  }
  return MensajeNuevos;
}

function AgregarMensajeChat(mensaje) {
  Mensajesalida = MensajeSalida(mensaje);
  mensaje.user_id > 0 ? AgregarMensajeCliente(Mensajesalida) : AgregarMensajeAdmin(Mensajesalida);
  MensajesLocales.push(mensaje);
  $(".messages").animate({scrollTop: '+=' +$(".messages").height()}, "fast");
}

function MensajeSalida(mensaje) {
  mensajepartes = mensaje.content.split(' ');
  Mensajesalida = '';
  mensajepartes.map(
    parte => {
      parte = isUrlValid(parte) ? FormatURL(parte): parte
      Mensajesalida = Mensajesalida + parte + ' '
    }
  )
  return Mensajesalida
}

function FormatURL(parte) {
  return '<a class="btn-success" href="'+parte+'" target="_blank">'+parte.substr(0,26)+'...'+'</a>';
}

function isUrlValid(url) {
  return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
}

function AgregarMensajeAdmin(mensaje) {
  $('<li class="sent"><img src="assets/avatar/avatar1.png" alt="" /><p>' + mensaje + '</p></li>').appendTo($('.messages ul'));
  $('.contact.active .preview').html('<span>Tu: </span>' + mensaje);
}

function AgregarMensajeCliente(mensaje) {
  $('<li class="replies"><img src="'+$('#'+ conversation_id).attr('image')+'" /><p>' + mensaje + '</p></li>').appendTo($('.messages ul'));
}

function ObtenerSolicitudes() {
  $.ajax({
    type: "POST",
    dataType: 'json',
    url: '?action=listsolicitudes',
    success: function(solicitudes) {
      MostrarSolicitudes(solicitudes);
    }
  });
}

function MostrarSolicitudes(solicitudes) {
  var NuevaSolicitud;
  var PrimeraSolicitud = true;
  NuevaSolicitud = FiltrarSolicitudes(solicitudes);
  for (i = 0; i < NuevaSolicitud.length; i++) {
      AgregarSolicitudContacto(NuevaSolicitud[i], PrimeraSolicitud);
      PrimeraSolicitud = false;
  }
  IsLoading = false;
}

function FiltrarSolicitudes(solicitudes) {
  var SolicitudNuevos = [];
  var Existe;
  for (i = 0; i < solicitudes.length; i++) {
    Existe = false;
    for (j = 0; j < SolicitudesLocales.length; j++) {
      if (solicitudes[i].id == SolicitudesLocales[j].id) {
          Existe = true;
          break;
      }
    }
    if (!Existe) {
        SolicitudNuevos.push(solicitudes[i]);
    }
  }
  return SolicitudNuevos;
}

function AgregarSolicitudContacto(solicitud, PrimeraSolicitud) {
  rutaimagen = solicitud.image == null ? 'http://lapreventiva.com/paciente/res/assets/images/avatar.png' :'http://lapreventiva.com/paciente/storage/users/profile/'+solicitud.image;
  $(
    '<li class="contact" value='+solicitud.conversation_id+' id='+solicitud.conversation_id+' image='+rutaimagen+' nombre =\"'+solicitud.username+' '+solicitud.lastname+'\">'+
      '<div class="wrap">' + '<span class="contact-status online"></span>' +
      '<img alt="" src="'+rutaimagen+'"/>' + 
        '<div class="meta">' +
        '<p class="name">' + solicitud.username + ' ' + solicitud.lastname + '</p>' +
        '<p class="preview"></p>' +
        '</div>'+
      '</div>'+
    '</li>'
    ).appendTo($('#contacts ul'));
  PrimeraSolicitud ? CambioChatClick($('#' + solicitud.conversation_id)) : '';
  SolicitudesLocales.push(solicitud);
  CambioChat();
}

function CambioChat() {
  $("#contacts ul li").click(function() {
    CambioChatClick($(this));
  });
}

function CambioChatClick($this) {
  $("#contacts ul li").removeClass("active");
  VaciarChat();
  conversation_id = $this.val();
  $this.addClass("active");
  $('#nombrechat').html($('#' + conversation_id).attr('nombre'));
  $('#avatarcliente').attr('src',$('#' + conversation_id).attr('image'));
}

function VaciarChat() {
  MensajesLocales = [];
  $('.messages ul').empty();
  $('#nombrechat').html('SELECCIONAR CHAT');
  conversation_id = 0;
}

function CambioEstadoConversacion() {
  $.ajax({
    type: "POST",
    data: {
        conversation_id
    },
    url: '?action=cambioestadosolicitud',
    success: function(response) {
      QuitarConversacion(conversation_id);
    }
  });
}

function QuitarConversacion(conversation_id) {
  $('#' + conversation_id).remove();
  VaciarChat();
}
$(".messages").animate({scrollTop: '+=' +$(".messages").height()}, "fast");
$("#profile-img").click(function() {
  $("#status-options").toggleClass("active");
});
$(".expand-button").click(function() {
  $("#profile").toggleClass("expanded");
  $("#contacts").toggleClass("expanded");
});

function newMessage() {
  content = $(".message-input input").val();
  if ($.trim(content) == '') {
    return false;
  }
  IsLoading = true;
  var dataenvio = {
    user_id,
    content,
    conversation_id
  };
  $.ajax({
    type: "POST",
    url: '?action=sendmsg',
    data: dataenvio,
    success: function(id) {
      nuevomenaje = {
        user_id,
        content,
        id,
        conversation_id
      }
      AgregarMensajeChat(nuevomenaje);
      $('.message-input input').val(null);
      IsLoading = false;
    }
  });
};
$('.submit').click(function() {
  newMessage();
});
$(window).on('keydown', function(e) {
  if (e.which == 13) {
    newMessage();
    return false;
  }
});


function TerminarConversacion() {
  bootbox.dialog({
    title: "CONFIRMACIÓN",
    message: "Esta seguro de Terminar Conversación",
    buttons: {
        cancel: {
            label: "SI",
            className: 'btn-success btn-lg',
            callback: function(){
              CambioEstadoConversacion();
            }
        },
        ok: {
            label: "NO",
            className: 'btn-danger btn-lg'
        }
    }
  });
}