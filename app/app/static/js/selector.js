$(document).ready(function() {

$('.dropdown-menu').on('click', function (e) {
 e.stopPropagation();
  console.log(`${e.target.textContent} clicado!`);
});

$(".nav-tabs a").click(function(){
    $(this).tab('show');
  });
  $('.nav-tabs a').on('shown.bs.tab', function(event){
    var x = $(event.target).text();         // active tab
    var y = $(event.relatedTarget).text();  // previous tab
    $(".act span").text(x);
    $(".prev span").text(y);
  });
 // $('#dropdown_modelos').on('click', function(event){
   // event.stopPropagation();
  // });

  /*$('#desplegable_modelos').on('click', function (event) {
    $(this).parent().toggleClass('open');
});

  $('body').on('click', function (e) {
    if (!$('#dropdown_modelos').is(e.target) 
        && $('#dropdown_modelos').has(e.target).length === 0 
        && $('.open').has(e.target).length === 0
    ) {
        $('#dropdown_modelos').removeClass('open');
    }
}); */

  //Selector de horarios del formulario <<Agendar cita>>
    $.ajax({
       "url": base_url + "../web_service/servicio/get_horarios", 
       "success": function(response){
       var obj = JSON.parse(response);
       $("#horario").append(
       '<option value="">Seleccione horario</option>');
       for(var i=0; i<obj.length;i++){ 
       $("#horario").append('<option value="'+obj[i].idhorario+'">' +obj[i].horario+'</option>');
            }
       } 
     });

  //Selector de modelos del formulario <<Solicitar cotizacion>>
    $.ajax({
       "url": base_url + "../web_service/servicio/get_modelos", 
       "success": function(response){
       var obj = JSON.parse(response);
       $("#auto_seleccionado").html(
        '<img class="img-fluid" src="'+base_url+'static/images/autos/pre_seleccion2.png" alt="auto">'
        );
       $("#modelo").append(
       '<option value="">Seleccione modelo</option>');
       for(var i=0; i<obj.length;i++){ 
       $("#modelo").append('<option value="'+obj[i].idmodelo+'">' +obj[i].nombremodelo+'</option>');
            }
       } 
     });

  //Selector de versiones de acuerdo al modelo seleccionado en <<Solicitar cotizacion>>
  $("#modelo").change(function(){
  $("#version").html("");
   $.ajax({
   "url"  : base_url + "../web_service/servicio/get_versiones", 
   "type" : "post",
   "data" : {
           "modelo":$(this).val() 
            },
    "success": function(response){
    var ob = JSON.parse(response);
    let obj=new Object(ob.versiones);
    $("#auto_seleccionado").html(
      '<img class="img-fluid" src="'+base_url+'static/images/autos/pre_seleccion2.png" alt="auto">')
      ;
    $("#version").html("");
       $("#version").append(
       '<option value="">Seleccione versión</option>');
       for(var i=0; i<obj.length;i++){ 
       $("#version").append('<option value="'+obj[i].idversion+'">' +obj[i].nombreversion+'</option>');
            }
       }

   });
});

  //Informacion e imagen del auto seleccionado en los selectores
 $("#version").change(function(){
   $.ajax({
       "url":      base_url + "../web_service/servicio/get_imagen_auto", 
       "type"      : "post",
       "data"      : {
           "modelo"   : $("#modelo").val(),
           "version"   : $(this).val() 
           },
       "success": function(response){
       var obj = JSON.parse(response);
       $("#auto_seleccionado").html('');
       $("#auto_seleccionado").append(
       '<img class="img-fluid" src="../../app_cc/static/images/autos/'+obj[0].imagen+'" alt="auto">'
       );
       $("#auto_seleccionado").append(
       '<br><h5><strong>Caracteristicas</strong></h5><h6><strong>Motor: </strong>'+obj[0].motor+'</h6><h6><strong>Cilindors: </strong>'+
       obj[0].cilindros+'</h6>' +
       '<h6><strong>Potencia: </strong>'+
       obj[0].potencia+'</h6>' +
       '<h6><strong>Torque: </strong>'+
       obj[0].torque+'</h6>' +
       '<h6><strong>Color: </strong>'+
       obj[0].color+'</h6>' 
       );
       }

 });
});

 $.ajax({
       "url":    base_url + "../web_service/servicio/get_autos", 
       "success": function(response){
        var obj = JSON.parse(response);
        var active="";
        var active_show="";
        
        for(var i=0; i<obj.carroceria.length;i++){
          
          $("#tipo_carroceria").append(
       '<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu-'+obj.carroceria[i].idcarroceria+'">'+
       obj.carroceria[i].carroceria+'</a></li>'
       );

          $("#content").append('<div class="tab-pane container fade" id="menu-'+obj.carroceria[i].idcarroceria+
            '"><div class="row" id="autos-'+obj.carroceria[i].idcarroceria+'"></div></div>'); 
        if(i==0){
            $('.nav-tabs a[href="#menu-'+obj.carroceria[i].idcarroceria+'"]').tab('show');
          }
        }

        

       //var a=obj.carroceria[0].idcarroceria;
        for(var i=0; i<obj.auto.length;i++){
       var a = obj.auto[i].idcarroceria;
       $('#autos-'+a).append('<div class="col-sm-4"><img class="img-fluid" src="../../app_cc/static/images/autos/'+
        obj.auto[i].imagen+'" alt="auto"><br/><br/><br/><div class="col-sm-11" style="position: absolute; bottom: 0; background-color:#DEDEDE; border-top-left-radius: 10px;border-top-right-radius: 10px; opacity: 0.9;"><h6 >'+
        obj.auto[i].nombremodelo +'<small style="float:right">'+obj.auto[i].nombreversion
        +'</small></h6><button data-toggle="collapse" data-target="#demo-'+obj.auto[i].idauto
        +'" class="btn btn-dark btn-sm">Ver mas</button><div id="demo-'+obj.auto[i].idauto+'" class="collapse"><small><strong>Marca: </strong>'+obj.auto[i].marca
        +'<br/><strong>Motor: </strong>'+obj.auto[i].motor 
        +'<br/><strong>Cilindros: </strong>'+obj.auto[i].cilindros
        +' <br/><strong>Combustible: </strong>'+obj.auto[i].combustible
        +' <br/><strong>Potencia: </strong>'+obj.auto[i].potencia
        +'</small></div></div></div>'
        );
          }
        } 
     });
  })