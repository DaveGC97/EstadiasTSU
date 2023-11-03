$(document).ready(function(){

	$("#btn-agendar-cita").click(function(){
     //$(location).attr( "href", "principal/agendarCita" );
     $.ajax({
		"url"    : base_url+"principal/redireccionar",
		"success": function(obj) {
			if ( obj) {
				$.ajax({
                        "url"    : base_url+"principal/redireccionar",
                        "success" : function() {
                            $( location ).attr( "href", "agendarCita" );
                        }
                     });
			} 
		}
	});
	});

	$("#btn-solicitar-cotizacion").click(function(){
    // $(location).attr( "href", base_url );
     //$(location).attr( "href", "principal/solicitarCotizacion" );
     $.ajax({
		"url"    : base_url+"principal/redireccionar",
		"success": function(obj) {
			if ( obj) {
				$.ajax({
                        "url"    : base_url+"principal/redireccionar",
                        "success" : function() {
                            $( location ).attr( "href", "solicitarCotizacion" );
                        }
                     });
			} 
		}
	});	
	});

	$("#btn-ver-modelos").click(function(){
    // $(location).attr( "href", "principal/verModelos" );
     $.ajax({
		"url"    : base_url+"principal/redireccionar",
		"success": function(obj) {
			if ( obj) {
				$.ajax({
                        "url"    : base_url+"principal/redireccionar",
                        "success" : function() {
                            $( location ).attr( "href", "verModelos" );
                        }
                     });
			} 
		}
	});	
	});

	$("#btn-mantenimiento").click(function(){
    // $(location).attr( "href", "principal/verModelos" );
     $.ajax({
		"url"    : base_url+"principal/redireccionar",
		"success": function(obj) {
			if ( obj) {
				$.ajax({
                        "url"    : base_url+"principal/redireccionar",
                        "success" : function() {
                            $( location ).attr( "href", "infoMantenimiento" );
                        }
                     });
			} 
		}
	});	
	});

	$("#btn-hp").click(function(){
    // $(location).attr( "href", "principal/verModelos" );
     $.ajax({
		"url"    : base_url+"principal/redireccionar",
		"success": function(obj) {
			if ( obj) {
				$.ajax({
                        "url"    : base_url+"principal/redireccionar",
                        "success" : function() {
                            $( location ).attr( "href", "infoHp" );
                        }
                     });
			} 
		}
	});	
	});
});