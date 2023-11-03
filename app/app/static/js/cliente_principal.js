$(document).ready(function(){
   
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

	$("#btn-agendar-cita").click(function(){
     $(location).attr( "href", "principal/agendarCita" );
	});

	$("#btn-solicitar-cotizacion").click(function(){
     $(location).attr( "href", "principal/solicitarCotizacion" );
	});

	$("#btn-ver-modelos").click(function(){
     $(location).attr( "href", "principal/verModelos" );
	});

	$("#btn-mantenimiento").click(function(){
     $(location).attr( "href", "principal/infoMantenimiento" );
	});
	$("#btn-hp").click(function(){
     $(location).attr( "href", "principal/infoHp" );
	});
	$("#btn-status").click(function(){
     $("#status-vehiculo").modal("show");
     $("#form-status")[0].reset();
     $("#info-status").html('');
     $("#spaci-button").html('<button type="button" class="btn btn-info" style="text-align: center;"  id="button-ver-status">Ver status</button>');
	});

	//$("#button-ocultar-status").click(function(){
	$(document).on('click', '#button-ocultar-status', function (){
     $("#spaci-button").html('<button type="button" class="btn btn-info" style="text-align: center;"  id="button-ver-status">Ver status</button>');
	 $("#info-status").html('');
	});

	//$("#button-ver-status").click(function(){
	$(document).on('click', '#button-ver-status', function (){
     var form = $("#form-status");
     form.validate();
     var validado = form. valid();
     if(validado){
      var nombre = $("#nombre").val();
      var app = $("#app").val();
      var apm = $("#apm").val();
      //var correo = $("#correo").val();
      var vin = $("#vin").val();

      $.ajax({
       "url"         : base_url +"../web_service/servicio/get_status", 
       "type"        : "post",
       "data"        : {
        "nombre"     : nombre, 
        "appaterno"  : app,
        "apmaterno"  : apm,
        "vin"        : vin
      },
      "dataType" : "json",
       "success": function(obj){
       	$("#info-status").html('');
        if(obj.resultado){
          if(obj.servicio){
          var cont = parseInt(obj.tareas.length) + parseInt(1);
          $("#form-status")[0].reset();
          
          var realizadas = 0;
          for(var i = 0; i<obj.tareas.length; i++){
          	if(obj.tareas[i].status ==1){
            realizadas++;
          	}
          }
         if(obj.cita[0].status == 'Finalizado'){
            realizadas ++;
         }
          var porcentaje = realizadas * 100 / cont; 
            $("#info-status").append(
             '<center><h4>¡Tu auto esta en buenas manos!</h4></center><br>'+
     '<span><strong>Cliente: </strong>'+obj.cliente[0].cliente+'</span><br>'+
     '<span><strong>Vin: </strong>'+obj.cita[0].vin+'</span><br>'+
    '<span><strong>Asesor de servicio: </strong>'+obj.asesor[0].asesor+'</span><br>'+
    '<span><strong>Fecha de cita: </strong>'+obj.cita[0].fechacita+'</span><br>'+
    '<span><strong>Fecha de entrega: </strong>'+obj.cita[0].fechatermino+'</span><br>'+
    '<div style="background-color: #cfd8dc; padding: 10px; border-radius: 5px;">'+
      '<center><span style="font-size:20px;">Progreso de tu servicio</span></center>'+
     '<div class="progress">'+
      '<div class="progress-bar progress-bar-striped progress-bar-animated" style="width:'+porcentaje+'%">'+porcentaje+'%</div>'+
     '</div>'+
     '<center><span id="finalizado" style="color:#03a9f4; font-size: 18px;"></span></center>'+
    '</div>'+
    '<br>'
             );

            if(porcentaje == 100){
            	$("#finalizado").html('El servicio ha finalizado, puede pasar a recoger su vehículo.');
            }

          $("#spaci-button").html('<button type="button" class="btn btn-danger" style="text-align: center;"  id="button-ocultar-status">Ocultar</button>');
          }else{
          	//el auto no esta en servicio
          	$("#info-status").html('<center><span style="color: #f44336">El vin del vehículo que ingreso no esta en servicio, revisa que sea el correcto.</span></center>');
          } 
        }else{
        	//el cliente no existe
        	$("#info-status").html('<center><span style="color: #f44336">Datos incorrectos, vuelve a ingresar la información solicitada</span></center>');
        }
       }
   });
   }
	});
});