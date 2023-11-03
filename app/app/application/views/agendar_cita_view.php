<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	 <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
	 <LINK href="<?= base_url() ?>static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
     <LINK href="<?= base_url() ?>static/fontawesome/css/all.min.css" rel="stylesheet">
     <LINK href="<?= base_url() ?>static/css/style.css" rel="stylesheet">

	<SCRIPT src="<?= base_url() ?>static/js/jquery-3.4.1.min.js"></SCRIPT>
  <SCRIPT src="<?= base_url() ?>static/js/jquery.validate.js"></SCRIPT>
	<SCRIPT src="<?= base_url() ?>static/bootstrap/js/bootstrap.min.js"></SCRIPT>
	<script src="<?= base_url() ?>static/js/cliente_contenido.js"></script>
	<script src="<?= base_url() ?>static/js/cliente_bd.js"></script>
  <script src="<?= base_url() ?>static/js/selector.js"></script>
  <link rel="shortcut icon" href="<?= base_url().'static/images/m-1.png' ?>">
	<title>PV | Agendar cita</title>
<SCRIPT> var base_url = "<?= base_url() ?>"; </SCRIPT>
<style type="text/css">
  label.error {
  color: #E00011;
  font-size: 12px;
}
h1 { 
  font-size: 10px 
}
</style>
</head>
<body style="background-image: url('<?= base_url() ?>static/images/w3.jpg');background-repeat: no-repeat center center fixed; -webkit-background-size: cover;
  -moz-background-size: cover;background-size: cover;">

<nav class="navbar navbar-expand-sm navbar-info fixed-top" style="background-image: url('<?= base_url() ?>static/images/w6.jpg');background-repeat: no-repeat;background-position: center;background-size: cover; border-bottom: 2px solid #225CAA; box-shadow: 0 0 50px #000;">
  <!-- Brand style="background-color: #fff; border-top: 4px solid #426AEF; border-bottom: 4px solid #4674FA;"-->
  <a class="navbar-brand navbar-left" href="<?= base_url() ?>">
  	<img src="<?= base_url() ?>static/images/m-1.png" alt="Logo" style="width:60px;"></a>
    <p style="font-size: 17px; color: #3363DD">El <strong style="font-size: 18px; color: #484848">mejor</strong> servicio para ti!</p>
    <button class="navbar-toggler btn btn-info" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span ><i class="fas fa-bars" style="color:#000; font-size:28px;"></i></span>
    </button>
  

  <!-- Links style="position: relative; right:1px;background-color: #4676FF; align-items: stretch; padding: 8px; border-top-left-radius: 10px;border-top-right-radius: 10px "-->
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav my-2 my-lg-0 ml-auto" style="position: relative; right:1px;background-color: #FFFFFF; align-items: stretch; padding: 8px; border-top-left-radius: 10px;border-top-right-radius: 10px; opacity: 0.9; ">
    <li class="nav-item" style="padding:5px">
      <button type="button" class="btn btn-light btn-block text-primary" data-toggle="modal" data-target="#covid"><i class="fas fa-calendar-alt" style="color:#426AEF; font-size:20px;"></i> Covid-19</button>
    </li>  
    <li class="nav-item" style="padding:5px">
      <button type="button" class="btn btn-light btn-block text-primary" id="btn-solicitar-cotizacion"><i class="fas fa-brush" style="color:#426AEF; font-size:20px;"></i> Solicitar cotización</button>
    </li>
    <li class="nav-item" style="padding:5px">
      <button type="button" class="btn btn-light btn-block text-primary" id="btn-ver-modelos"><i class="fas fa-wrench" style="color:#426AEF; font-size:20px;"></i> Modelos</button>
    </li>

    <!-- Dropdown -->
    <li class="nav-item dropdown" style="padding:5px">
    <button type="button" class="btn btn-light btn-block text-primary dropdown-toggle" id="navbardrop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   <i class="fas fa-tools" style="color:#426AEF; font-size:20px;"></i> Servicios
    </button>
    <div class="dropdown-menu dropdown-menu-right" >
       <button type="button" class="btn btn-light btn-block text-primary dropdown-item"><i class="fas fa-car" style="color:#426AEF; font-size:20px;"></i> Agendar cita</button>
       <button type="button" class="btn btn-light btn-block text-primary dropdown-item" id="btn-hp"><i class="fas fa-car" style="color:#426AEF; font-size:20px;"></i> Hojalatería y pintura</button>
       <button type="button" class="btn btn-light btn-block text-primary dropdown-item" id="btn-mantenimiento"><i class="fas fa-car" style="color:#426AEF; font-size:20px;"></i> Servicio de mantenimiento</button>
       <!--<button type="button" class="btn btn-light btn-block text-primary dropdown-item"><i class="fas fa-car" style="color:#426AEF; font-size:20px;"></i>¿Tu vehículo esta en servicio? <h6 style="color:#000">Revisa el status</h6></button>-->
    </div>
    </li>
  </ul>
</div>
</nav>

<div style="height: 90px"></div>
<div class="container col-sm-12">
<div class="row">
	<div class="text-center" style="position: relative;">
      <img class="img-fluid" src="<?= base_url() ?>static/images/car_ag3.jpg" alt="Mustang">
        <div style="background-color: #000; opacity: 0.7;box-shadow: 0 0 35px #000; position: absolute;
 top: 45%;
 left: 0;
 width: 100%;">
    <h1 style="font-size: 4vw; color: #fff">Somos tu taller de confianza</h1>
      </div>
	</div>
</div>
<br/>
<div class="row">
	<div class="col-sm-2">
	</div>
	<div class="col-sm-8">
    <div class="card" style="border: 1px solid #225CAA">
   	<div class="card-header" style="background-color: #F3F3F3;  border-top: 5px solid #225CAA;border-bottom: 1px solid #225CAA;"><center><h3 class="box-title">Agendar cita</h3></center></div>
   	<div class="card-body" style="background-color: #fff">
      <form id="formulario">
   	<h5 style="color: #2B2B2B"><strong>Datos de contacto</strong></h5>
    <div class="row">
   	 <div class="form-group col-sm-4">
      <label for="nombre" class="text-primary">Nombre:</label>
      <input type="text" class="form-control" id="nombre" name="nombre" style="border-radius: 5px; border: 1px solid #2E8EFB;" placeholder="Escribe tu nombre" minlength="2" maxlength="25" required>
      </div>
      <div class="form-group col-sm-4">
      <label for="app" class="text-primary">Apellido paterno:</label>
      <input type="text" class="form-control" id="app" name="app" style="border-radius: 5px; border: 1px solid #2E8EFB;" placeholder="Escribe tu apellido paterno" minlength="2" maxlength="25" required>
      </div>
      <div class="form-group col-sm-4">
      <label for="apm" class="text-primary">Apellido materno:</label>
      <input type="text" class="form-control" id="apm" name="apm" style="border-radius: 5px; border: 1px solid #2E8EFB;" placeholder="Escribe tu apellido materno" minlength="2" maxlength="25" required>
      </div>
   	</div>
   	<div class="row">
   	 <div class="form-group col-sm-4">
      <label for="correo" class="text-primary">Correo:</label>
      <input type="email" class="form-control" id="correo" name="correo" style="border-radius: 5px; border: 1px solid #2E8EFB;" placeholder="ejemplo@gmail.com" required>
      </div>
      <div class="form-group col-sm-4">
      <label for="notelefono" class="text-primary">Número telefónico:</label>
      <input type="number" class="form-control" id="notelefono" name="notelefono" style="border-radius: 5px; border: 1px solid #2E8EFB;" placeholder="Escribe tu número telefónico" required>
      </div>
   	</div>
    <br/>

    <h5 style="color: #2B2B2B"><strong>Selecciona servicio</strong></h5>
     <div class="row">
   	 <div class="form-group col-sm-4">
      <div class="form-check-inline">
      <label class="form-check-label text-primary">
       <input type="checkbox" class="form-check-input" id="rep_general" name="servicio">Reparación general 
      </label>
      </div>
      </div>
      <div class="form-group col-sm-4">
      <div class="form-check-inline">
      <label class="form-check-label text-primary">
       <input type="checkbox" class="form-check-input" id="ser_mantenimiento" name="servicio">Servicios de Mantenimiento 
      </label>
      </div>
      </div>
      <div class="form-group col-sm-4">
      <div class="form-check-inline">
      <label class="form-check-label text-primary">
       <input type="checkbox" class="form-check-input" id="ser_hp" name="servicio">Hojalatería y Pintura
      </label>
     </div>
   	 </div>
   	</div>
    <label id="servicio-error" class="error" for="servicio"></label>
    <br/>
   <?php 
  //$hoy = date("Ymd");
 // echo $hoy;
  $hoy = date( "Y-m-d" ); 
  //$hoy_1 = strtotime( "-1 day", strtotime( $hoy ) );

  //$hoy_1 = date( "Y-m-d", $hoy_1 );
   ?>
   	<h5 style="color: #2B2B2B"><strong>Selecciona horario</strong></h5>
     <div class="row">
   	 <div class="form-group col-sm-4">
      <label for="fecha" class="text-primary">Fecha:</label>
      <input type="date" class="form-control" id="fecha" min="<?php echo $hoy; ?>" style="border-radius: 5px; border: 1px solid #2E8EFB;" placeholder="Selecciona fecha" required>
      </div>
      <div class="form-group col-sm-4">
      <label for="horario" class="text-primary">Horario:</label>
      <select class="form-control" id="horario" name="horario" style="border-radius: 5px; border: 1px solid #2E8EFB;" required>
      </select>
      </div>
     </div>
     <div class="row">
     	<div class="form-group col-sm-12 float-right" >
     	<div class="float-right">
     	<button type="button" class="btn btn-primary" id="btn-agendar" >
        	<i class="fas fa-check-circle"></i> Enviar datos
        </button>		
     	</div>
     	</div>
     </div>
     <div class="row">
     	<div class="form-group col-sm-12" id="mensaje">
  	
     	</div>
     </div>
     </form>
     </div>
        
   	 </div>
   	</div>
   	<div class="col-sm-1">
   		<div class="row">
   			
   		</div>
   	</div>
	</div>
  <br/>

  <div class="row">
  <div class="text-center" style="position: relative;">
      <img class="img-fluid" src="<?= base_url() ?>static/images/car_ag9.jpg" alt="Mustang">
       <div style="background-color: #000; opacity: 0.7;box-shadow: 0 0 35px #000; position: absolute;
 top: 45%;
 left: 0;
 width: 100%;">
    <h1 style="font-size: 4vw; color: #04FFD5">Sabemos lo que tu auto quiere</h1>
      </div>
  </div>
  </div>

</div>

</div>

<div class="modal fade show" id="modal-cita-agendada" aria-modal="true" >
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header" style="background-color: #53ABF6 !important;">
        <h4 class="modal-title">Cita agendada</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      	Tu cita ha sido agendada satisfactoriamente
      	<strong>
      		<span id="cliente"></span>
      	</strong>
      
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">
        	<i class="fas fa-check-circle"></i> Aceptar
        </button>
      </div>

    </div>
  </div>
</div>
</div>

<div class="modal fade" id="covid">
  <div class="modal-dialog" >
    <div class="modal-content" style="border: 1px solid #225CAA; ">

      <!-- Modal Header -->
      <div class="modal-header" style="background-color: #F3F3F3;  border-top: 5px solid #225CAA;border-bottom: 1px solid #C9C9C9; ">
        <h4 class="modal-title">Medidas sanitarias (covid-19)</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body" >
        <div class="card" style="padding: 19px">
         <center><img src="<?= base_url() ?>static/images/sanitaria.png" alt="Medidas_sanitarias" style="width:270px;"></center>
         <h6 style="color: #426AEF"><i class="fas fa-check-circle fa-1x"></i><strong> Lavarse las manos frecuentemente</strong></h6>
         <p style="text-align: justify;">Lávese las manos con frecuencia con agua y jabón por al menos 20 segundos, especialmente después de haber estado en un lugar público, o después de sonarse la nariz, toser o estornudar.</p>
         <br/>

         <h6 style="color: #426AEF"><i class="fas fa-check-circle fa-1x"></i><strong> Evite el contacto directo</strong></h6>
         <p style="text-align: justify;">Mantenga una distancia de al menos 6 pies (aproximadamente la longitud de 2 brazos) de otras personas.</p>
         <p style="text-align: justify;">Mantener distancia con los demás es especialmente importante para las personas que tienen mayor riesgo de enfermarse gravemente.</p>
         <br/>

         <h6 style="color: #426AEF"><i class="fas fa-check-circle fa-1x"></i><strong> Cubrirse la boca y la nariz con una cubierta de tela para la cara al estar rodeados de personas</strong></h6>
         <p></p>

         <br/>
         <h6 style="color: #426AEF"><i class="fas fa-check-circle fa-1x"></i><strong> Cúbrase la nariz y la boca al toser y estornudar</strong></h6>
         <p style="text-align: justify;">Cúbrase siempre la boca y la nariz con un pañuelo desechable al toser o estornudar o cúbrase con la parte interna del codo y no escupa</p>
         <p style="text-align: justify;">Bote los pañuelos desechables usados a la basura.</p>
         <p style="text-align: justify;">Lávese las manos inmediatamente con agua y jabón por al menos 20 segundos.</p>

         <br/>
         <h6 style="color: #426AEF"><i class="fas fa-check-circle fa-1x"></i><strong> Cúbrase la nariz y la boca al toser y estornudar</strong></h6>
         <p style="text-align: justify;">Limpie Y desinfecte diariamente las superficies que se tocan con frecuencia </p>
         <p style="text-align: justify;">Si las superficies están sucias, límpielas. Lávelas con agua y detergente o jabón antes de desinfectarlas.</p>

         <br/>
         <h6 style="color: #426AEF"><i class="fas fa-check-circle fa-1x"></i><strong> Monitoree su salud a diario</strong></h6>
         <p style="text-align: justify;">Esté atento a los síntomas. Esté atento a la aparición de fiebre, tos, dificultad para respirar u otros síntomas del COVID-19.</p>
         <p style="text-align: justify;">Controle su temperatura si presenta síntomas.</p>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>
</body>
</html>