$( document ).ready( function() {

  $( "#btn-ver" ).click( function() {
    $("#valor").append(
       '<h2>Autos del modelo seleccionado</h2>');
  });

   jQuery.validator.addMethod('lettersonly', function(value, element) {
    return this.optional(element) || /^[a-z áãâäàéêëèíîïìóõôöòúûüùçñ]+$/i.test(value);
    }, "Sólo letras y espacios");

  jQuery.extend(jQuery.validator.messages, {
    required: "Campo requerido. *",
    remote: "Please fix this field.",
    email: "Ingrese un email valido.",
    url: "Please enter a valid URL.",
    date: "Ingresa una fecha valida.",
    dateISO: "Please enter a valid date (ISO).",
    number: "Ingresa un número valido",
    digits: "Ingresa sólo dígitos",
    creditcard: "Please enter a valid credit card number.",
    equalTo: "Please enter the same value again.",
    accept: "Please enter a value with a valid extension.",
    maxlength: jQuery.validator.format("Ingresa menos de {0} caracteres."),
    minlength: jQuery.validator.format("Ingresa más de {0} caracteres."),
    rangelength: jQuery.validator.format("Ingresa un valor entre {0} y {1} caracteres de dimensión."),
    range: jQuery.validator.format("Ingresa un valor entre {0} y {1}."),
    max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
    min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
});

$( "#btn-agendar" ).click( function() {

    /* Fetch form to apply custom Bootstrap validation
    var form = $("#formulario")

    if (form[0].checkValidity() === false) {
      event.preventDefault()
      event.stopPropagation()
    }
    
    form.addClass('was-validated'); */
    // Perform ajax submit here...
  
  var form = $( "#formulario" );
  form.validate({
    rules: {
    horario: {
      required: true
    }, 
    apm: {
      required: true, 
      lettersonly: true
    },
    servicio: {
      required: true
    }, 
    nombre: {
      lettersonly: true
    }, 
    app: {
      lettersonly: true
    }
  },
   messages: {
      servicio: {
      required: "Selecciona un servicio"
     }
   }
  });

 // var validado = $("#formulario").valid();
 var validado = form. valid();
  if(validado){
  var nombre = $("#nombre").val();
  var app = $("#app").val();
  var apm = $("#apm").val();
  var correo = $("#correo").val();
  var notelefono = $("#notelefono").val();
  var rep_general = 0;
  var ser_mantenimiento = 0;
  var ser_hp = 0;
  var fecha = $("#fecha").val();
  var horario = $("#horario").val();
  if( $('#rep_general').is(":checked")) {
    rep_general = 1;
  }
  if( $('#ser_mantenimiento').is(":checked")) {
    ser_mantenimiento = 1;
  }
  if( $('#ser_hp').is(":checked")) {
    ser_hp = 1;
  }

 

  //jQuery.validator.messages.required = 'Esta campo es obligatorio.';
   // jQuery.validator.messages.number = 'Esta campo debe ser num&eacute;rico.';
   // jQuery.validator.messages.email = 'La direcci&oacute;n de correo es incorrecta.';
   //    var validado = $("#formulario").valid();
    //   if(validado){
         
  $.ajax({
      "url"      : base_url + "../web_service/servicio/agendar_cita",
      "type"     : "post",
      "data"     : {
        "nombre" : nombre,
        "appaterno" : app,
        "apmaterno" : apm,
        "correo"    : correo,
        "tel"       : notelefono,
        "rep_g"     : rep_general,
        "ser_m"     : ser_mantenimiento,
        "ser_hp"    : ser_hp, 
        "fecha"     : fecha,
        "horario"   : horario
      },
      "dataType" : "json",
      "success"  : function( obj ) {
        mostrar_mensaje("success", obj.mensaje);
                if(obj.resultado){
                    $("#nombre").val("");
                    $("#app").val("");
                    $("#apm").val("");
                    $("#correo").val("");
                    $("#notelefono").val("");
                    $("#fecha").val("");
                    $("#horario").val("");
                    $("#modal-cita-agendada").modal();
                    $("#cliente").val(nombre);
                  
       
                }
      }
    }); 
       }

});

$( "#btn-solicitar" ).click( function() {
  var form = $( "#formulario-cotizacion" );
  form.validate({
    rules: {
    apm: { 
      lettersonly: true
    },
    nombre: {
      lettersonly: true
    }, 
    app: {
      lettersonly: true
    },
    modelo: {
      required: true
    }
  },
   messages: {
      modelo: {
      required: "Selecciona un modelo"
     },
     version: {
      required: "Selecciona una versión"
     }
   }
  });

 // var validado = $("#formulario").valid();
 var validado = form. valid();
  if(validado){
   var nombre = $("#nombre").val();
  var app = $("#app").val();
  var apm = $("#apm").val();
  var correo = $("#correo").val();
  var notelefono = $("#notelefono").val();
  var modelo = $("#modelo").val();
  var version = $("#version").val();

  $.ajax({
      "url"      : base_url + "../web_service/servicio/solicitar_cotizacion",
      "type"     : "post",
      "data"     : {
        "nombre" : nombre,
        "appaterno" : app,
        "apmaterno" : apm,
        "correo"    : correo,
        "tel"       : notelefono,
        "modelo"    : modelo,
        "version"   : version
      },
      "dataType" : "json",
      "success"  : function( obj ) {
        mostrar_mensaje("success", obj.mensaje);
                if(obj.resultado){
                    $("#nombre").val("");
                    $("#app").val("");
                    $("#apm").val("");
                    $("#correo").val("");
                    $("#notelefono").val("");
                    $("#modelo").val("");
                    $("#version").val("");
                    $("#modal-cotizacion-realizada").modal();
                    $("#cliente").val(nombre);
                }
      }
    });
  }
})  	
});

function mostrar_mensaje(tipo, texto){
    $("#mensaje").html('<div class="alert alert-' +  tipo +' alert-dismissible"> <button type="button" class="close" data-dismiss="alert">&times;</button><strong>AVISO: </strong>' + texto + '</div>');
}