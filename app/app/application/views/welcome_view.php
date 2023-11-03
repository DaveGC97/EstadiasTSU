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
	<script src="<?= base_url() ?>static/js/cliente_principal.js"></script>
  <script src="<?= base_url() ?>static/js/selector.js"></script>
  <link rel="shortcut icon" href="<?= base_url().'static/images/m-1.png' ?>">
	<title>PV | Inicio</title>
<SCRIPT> var base_url = "<?= base_url() ?>"; </SCRIPT>
<!-- Código de instalación Cliengo para automed.uteq@gmail.com --> 
<script type="text/javascript">
(function () { 
var ldk = document.createElement('script'); 
ldk.type = 'text/javascript'; 
ldk.async = true; 
ldk.src = 'https://s.cliengo.com/weboptimizer/5f5783efb26b27002a772c00/5f5783f1b26b27002a772c03.js'; 
var s = document.getElementsByTagName('script')[0]; 
s.parentNode.insertBefore(ldk, s); 
})();
</script>

<style type="text/css">
  label.error {
  color: #ff0000;
  font-size: 12px;
  }
</style>
</head>
<body>

<nav class="navbar navbar-expand-sm navbar-info fixed-top" style="background-image: url('<?= base_url() ?>static/images/w6.jpg');background-repeat: no-repeat;background-position: center;background-size: cover; border-bottom: 2px solid #225CAA; box-shadow: 0 0 50px #000; ">
  <!-- Brand style="background-color: #fff; border-top: 4px solid #426AEF; border-bottom: 4px solid #4674FA;"-->
  <a class="navbar-brand navbar-left" href="<?= base_url() ?>">
  	<img src="<?= base_url() ?>static/images/m-1.png" alt="Logo" style="width:60px;"></a>
    <p style="font-size: 17px; color: #3363DD">El <strong style="font-size: 18px; color: #484848">mejor</strong> servicio para ti!</p>
    <button class="navbar-toggler btn btn-info" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span ><i class="fas fa-bars" style="color:#000; font-size:28px;"></i></span>
    </button>
  

  <!-- Links style="position: relative; right:1px;background-color: #4676FF; align-items: stretch; padding: 8px; border-top-left-radius: 10px;border-top-right-radius: 10px "    px-5 py-5 -->
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav my-2 my-lg-0 ml-auto" style="position: relative; right:1px;background-color: #fff; align-items: stretch; padding: 8px; border-top-left-radius: 10px;border-top-right-radius: 10px;">
    <li class="nav-item" style="padding:5px">
      <button type="button" class="btn btn-light btn-block text-primary" data-toggle="modal" data-target="#covid"><i class="fas fa-diagnoses" style="color:#426AEF; font-size:20px;"></i> Covid-19</button>
    </li>  
    <li class="nav-item" style="padding:5px">
      <button type="button" class="btn btn-light btn-block text-primary" id="btn-solicitar-cotizacion"><i class="fas fa-file-invoice" style="color:#426AEF; font-size:20px;"></i> Solicitar cotización</button>
    </li>
    <li class="nav-item" style="padding:5px;">
      <button type="button" class="btn btn-light btn-block text-primary" id="btn-ver-modelos"><i class="fas fa-car" style="color:#426AEF; font-size:20px;"></i> Modelos</button>

    
  <!-- Nav tabs 
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link active" href="#home">Modelo 1</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#menu1">Menu 1</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#menu2">Menu 2</a>
    </li>
  </ul>
  <div class="tab-content">
  <div class="tab-pane container active" id="home">1...</div>
  <div class="tab-pane container fade" id="menu1">2...</div>
  <div class="tab-pane container fade" id="menu2">3...</div>
</div>
   Tab panes 
  <form class="px-4 py-3"></form>
  <div class="tab-content border mb-3">
    <div id="home" class="container tab-pane active"><br>
      <h3>HOME</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    </div>
    <div id="menu1" class="container tab-pane fade"><br>
      <h3>Menu 1</h3>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
    <div id="menu2" class="container tab-pane fade"><br>
      <h3>Menu 2</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
  </div>
  <p class="act"><b>Active Tab</b>: <span></span></p>
  <p class="prev"><b>Previous Tab</b>: <span></span></p>
</div>
</div>-->

    <!--<div>
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" data-toggle="tab" href="#home">Home</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#menu1">Menu 1</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#menu2">Menu 2</a>
  </li>
</ul>

<div class="tab-content">
  <div class="tab-pane container active" id="home">1...</div>
  <div class="tab-pane container fade" id="menu1">2...</div>
  <div class="tab-pane container fade" id="menu2">3...</div>
</div>
</div>
  <form class="px-4 py-3">
    <div class="form-group">
      <label for="exampleDropdownFormEmail1">Email address</label>
      <input type="email" class="form-control" id="exampleDropdownFormEmail1" placeholder="email@example.com">
    </div>
    <div class="form-group">
      <label for="exampleDropdownFormPassword1">Password</label>
      <input type="password" class="form-control" id="exampleDropdownFormPassword1" placeholder="Password">
    </div>
    <div class="form-check">
      <input type="checkbox" class="form-check-input" id="dropdownCheck">
      <label class="form-check-label" for="dropdownCheck">
        Remember me
      </label>
    </div>
    <button type="submit" class="btn btn-primary">Sign in</button>
  </form>
  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="#">New around here? Sign up</a>
  <a class="dropdown-item" href="#">Forgot password?</a>
</div>-->
    </li>

  <!--<li class="nav-item dropdown" style="padding:5px;">
      <button type="button" class="btn btn-light btn-block text-primary dropdown-toggle show" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-car" style="color:#426AEF; font-size:20px;"></i> Modelos</button>
   
   <div class="dropdown-menu dropdown-menu-right wrapper" id="dropdown_modelos" style="">
   <div>
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" data-toggle="tab" href="#home">Home</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#menu1">Menu 1</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#menu2">Menu 2</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#menu2">Menu 2</a>
  </li>
</ul>

<div class="tab-content">
  <div class="tab-pane container active" id="home">1...</div>
  <div class="tab-pane container fade" id="menu1">2...</div>
  <div class="tab-pane container fade" id="menu2">3...</div>
</div>
</div>

  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="#">New around here? Sign up</a>
  <a class="dropdown-item" href="#">Forgot password?</a>
</div>
 </li>-->




    <!-- Dropdown -->
    <li class="nav-item dropdown" style="padding:5px">
    <button type="button" class="btn btn-light btn-block text-primary dropdown-toggle" id="navbardrop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   <i class="fas fa-tools" style="color:#426AEF; font-size:20px;"></i> Servicios
    </button>
    <div class="dropdown-menu dropdown-menu-right" >
       <button type="button" class="btn btn-light btn-block text-primary dropdown-item" id="btn-agendar-cita"><i class="fas fa-calendar-alt" style="color:#426AEF; font-size:20px;"></i> Agendar cita </button>
       <button type="button" class="btn btn-light btn-block text-primary dropdown-item" id="btn-hp"><i class="fas fa-brush" style="color:#426AEF; font-size:20px;"></i> Hojalatería y pintura</button>
       <button type="button" class="btn btn-light btn-block text-primary dropdown-item" id="btn-mantenimiento"><i class="fas fa-wrench" style="color:#426AEF; font-size:20px;"></i> Servicio de mantenimiento</button>
       <button type="button" class="btn btn-light btn-block text-primary dropdown-item" id="btn-status" style="background-color: #cfd8dc;">¿Tu vehículo esta en servicio? <h6 style="color:#000">Revisa el status</h6></button>
    </div>
    </li>
  </ul>
</div>
</nav>


<!--<nav class="navbar navbar-expand-sm navbar-dark fixed-bottom" style="border-bottom: 8px solid #878787">
<ul class="navbar-nav">
    <li class="nav-item">
     <h6 style="color: #ff0000">Bienvenido, somos tu mejor opción</h6>
    </li>
  </ul>

  <ul class="navbar-nav my-2 my-lg-0 ml-auto">
    <button class="btn" type="button">
    <i class="fas fa-comments" style="color:#426AEF; font-size:40px;"></i>
    </button>
  </ul>
</nav>-->

<div style="height: 90px"></div>

<div class="container col-sm-12" id="contenido" style="background-color: #fff">
<div class="row">
	<div >
 <div id="demo" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ul class="carousel-indicators">
    <li data-target="#demo" data-slide-to="0" class="active"></li>
    <li data-target="#demo" data-slide-to="1"></li>
    <li data-target="#demo" data-slide-to="2"></li>
  </ul>
  <!-- The slideshow -->
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="img-fluid" src="<?= base_url() ?>static/images/pos-3.jpg" alt="Mustang">
        <div class="carousel-caption" style="background-color: #000; opacity: 0.7;box-shadow: 0 0 35px #000;width: 100%; left: 0">
    <h1 style="font-size: 4vw; color: #66A9FF">Sabemos lo que tu auto significa para ti!</h1>
    <p style="font-size: 2vw; font-family: unset;">Atención especializada para tu vehículo</p>
      </div>
    </div>
    <div class="carousel-item">
      <img class="img-fluid" src="<?= base_url() ?>static/images/pos-2.jpg" alt="Chicago">
      <div class="carousel-caption" style="background-color: #000; opacity: 0.8;justify-content: center;width: 100%; left: 0">
    <h1 style="font-size: 8vw; color: #ff0000; font-family: unset;">¡No busque más!</h1> <h1 style="font-size: 3vw; color: #fff">Tenemos la solución para su vehículo</h1>
  </div>
    </div>
    <div class="carousel-item">
      <img class="img-fluid" src="<?= base_url() ?>static/images/pos-5.jpg" alt="New York">
       <div class="carousel-caption" style="background-color: #000; opacity: 0.8;justify-content: center; width: 100%; left: 0">
    <h1 style="font-size: 5vw; color: #FF7318; font-family: unset;">Todo lo que necesitas en un solo lugar</h1> <h1 style="font-size: 3vw; color: #fff">El aliado en tu camino</h1>
  </div>
    </div>
  </div>
  <!-- Left and right controls -->
  <a class="carousel-control-prev" href="#demo" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>
    </div>		
	</div>
</div>

<div class="row" style="background-color: #F3F3F3; height: 10px">
  
</div>

<div class="row">
  <div class="col-sm-6 text-light" style="height: 280px; background-color: #1B3676; text-align: center;">
     <br/><br/>
     <h2>Mantén tu vehículo en </h2>
     <h3>buenas condiciones </h3>
    <br/>
    <br/>
    <h5>Descubre los beneficios de nuestros servicios </h5>
    <br/>
  </div>
  <div class="col-sm-6 text-light" style="height: 280px;">
   <img class="img-fluid" src="<?= base_url() ?>static/images/servicio_1.jpg" alt="Mustang" style="position: absolute; right: 0; height: 100%; width: 100%">
  </div>
</div>

<div class="row" style="background-color: #F3F3F3;">
  <div class="col-sm-6" style="padding: 50px">
    <div class="row" style="justify-content: center; align-items: start; display: flex;"> 
    <img class="rounded-circle img-fluid" src="<?= base_url() ?>static/images/servicio_mant.jpg" alt="Mustang" style=" width: 50%;">   
    </div>
    <div class="row" style="justify-content: center; align-items: start; display: flex; padding-top: 10px">
      <div class="col-sm-12" style="text-align: center;background-color: #F0F0F0; box-shadow: 0 0 15px #1C2C7F;" >
     <h5>Servicio de mantenimiento</h5>
     <p style="padding-left: 10px; padding-right: 10px; font-family: inherit;color: #225CAA;">Si quieres prolongar la vida útil del auto es preciso realizarle un correcto mantenimiento.</p>   
      </div>
    </div> 

     
  </div>
  <div class="col-sm-6" style="padding: 50px">
    <div class="row" style="justify-content: center; align-items: start; display: flex;">
    <img class="rounded-circle img-fluid" src="<?= base_url() ?>static/images/mant_3.jpg" alt="Mustang" style=" width: 50%">    
    </div>

    <div class="row" style="justify-content: center; align-items: start; display: flex; padding-top: 10px">
    <div class="col-sm-12" style="text-align: center;background-color: #F0F0F0; box-shadow: 0 0 15px #1C2C7F;">
     <h5>Hojalatería y pintura</h5>
     <p style="padding-left: 10px; padding-right: 10px; font-family: inherit;color: #225CAA;">Beneficios que garantizará el detallado automotriz, con una mejor conservación del vehículo y sus materiales. </p>   
      </div>
    </div>
    
  </div>
</div>


<div class="row" >
  <div class="col-sm-12 text-light" style="background-color: #F3F3F3;border-top: 2px solid #225CAA;">
   <img class="img-fluid" src="<?= base_url() ?>static/images/netcar-1.jpg" alt="Mustang" style="width: 100%">
  </div>
</div>



<div class="row" style="background-color: #ECECEC; height: 270px;  padding-top: 10px;">
  <div class="col-sm-3 text-body">
    <div class="card card-cascade narrower" style="height: 95%; border-top: 3px solid #225CAA; padding: 30px; padding-top: 10px">
      <div style="text-align: center;">
     <h5>Ubicación</h5> 
     </div>
      <p><small>Av. Pie de la Cuesta 2501, Nacional, 76148 Santiago de Querétaro, Qro.</small></p>
      <!--Card content-->
      <div class="text-center">
        <!--Google map-->
        <div id="map-container-google-9" class="z-depth-1-half map-container-5" >
            <div class="map-responsive">
   <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&q=UTEQ" width="250" height="110" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>

      </div>
    </div>
  </div>

  <div class="col-sm-3 text-body">
    <div class="card card-cascade narrower" style="height: 95%; border-top: 3px solid #225CAA; padding: 30px; padding-top: 10px">
      <div style="text-align: center;">
      <h5>Contacto</h5> 
      </div>
      <p><i class="fas fa-phone"></i><small> Teléfono: 4411391198.</small></p>
      <p><i class="fas fa-envelope"></i><small> Correo: automed.uteq@gmail.com</small></p>
    </div>
  </div>

  <div class="col-sm-3 text-body">
     <div class="card card-cascade narrower" style="height: 95%; border-top: 3px solid #225CAA; padding: 30px; padding-top: 10px">
      <div style="text-align: center;">
      <h5>Horario de servicio</h5> 
      </div>
      <p><i class="fas fa-clock fa-1x"></i><small> Lunes a vienes 7:00-17:00 hrs</small></p>
      
    </div>
  </div>

  <div class="col-sm-3 text-body">
     <div class="card card-cascade narrower" style="height: 95%; border-top: 3px solid #225CAA; padding: 30px; padding-top: 10px">
      <div style="text-align: center;">
      <h5>Redes sociales</h5> 
      </div>
      <br/>
      <div class="row">
        <div class="col-sm-3 col-md-4 col-lg-4">
          <i class="fab fa-facebook fa-2x"></i>
        </div>
        <div class="col-sm-3 col-md-4 col-lg-4">
           <i class="fab fa-instagram fa-2x"></i>
        </div>
        <div class="col-sm-3 col-md-4 col-lg-4">
           <i class="fab fa-twitter-square fa-2x"></i>
        </div>
      </div>
      
     
     
      
    </div>
  </div>
  <br/><br/><br/>
</div>

</div>



<!-- The Modal -->
<div class="modal" id="status-vehiculo" style="background-color: rgba(10,10,10, 0.8) !important;">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <!--<h4 class="modal-title">Status de tu vehiculo</h4>-->
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body" style="background-color: #eceff1;">
         <div class="container">
          <div class="text-center" style="position: relative;">
      <img class="img-fluid" src="<?= base_url() ?>static/images/mant_m.jpg" alt="Mustang">
        <div style="background-color: #000; opacity: 0.7;box-shadow: 0 0 35px #000; position: absolute;bottom: 10%;left: 0;width: 100%;">
    <h1 style="font-size: 4vw; color: #fff">Revisa el status de tu vehiculo, mientras esta en servicio</h1>
      </div>
  </div>
        <!--<img class="img-fluid" src="<?= base_url() ?>static/images/mant_m.jpg" alt="Mustang" style="width: 100%">-->
        <h6>Ingresa los datos solicitados</h6>
        <form id="form-status">
        <div class="row">
     <div class="form-group col-sm-6 col-md-6 col-lg-4">
      <label for="nombre" class="text-primary">Nombre:</label>
      <input type="text" class="form-control" id="nombre" name="nombre" style="border-radius: 5px; border: 1px solid #2E8EFB;" placeholder="Escribe tu nombre" minlength="2" maxlength="25" required>
      </div>
      <div class="form-group col-sm-6 col-md-6 col-lg-4">
      <label for="app" class="text-primary">Apellido paterno:</label>
      <input type="text" class="form-control" id="app" name="app" style="border-radius: 5px; border: 1px solid #2E8EFB;" placeholder="Escribe tu apellido paterno" minlength="2" maxlength="25" required>
      </div>
      <div class="form-group col-sm-6 col-md-6 col-lg-4">
      <label for="apm" class="text-primary">Apellido materno:</label>
      <input type="text" class="form-control" id="apm" name="apm" style="border-radius: 5px; border: 1px solid #2E8EFB;" placeholder="Escribe tu apellido materno" minlength="2" maxlength="25" required>
      </div>
    </div>
    <div class="row">

      <div class="form-group col-sm-6 col-md-6 col-lg-4">
      <label for="vin" class="text-primary">Vin del vehiculo:</label>
      <input type="text" class="form-control" id="vin" name="vin" style="border-radius: 5px; border: 1px solid #2E8EFB;" placeholder="Escribe tu vin del vehiculo" required>
      </div>
    </div>
    </form>

    <div class="float-right" id="spaci-button">
      
    </div>
    <br><br>
    <div class="col sm-12" style="background-color: #fafafa; padding: 10px; border-radius: 5px;" id="info-status">
      
    </div>
      </div>
    </div>

      <!-- Modal footer -->
      <div class="modal-footer ">
        <button type="button" class="btn btn-danger btn-light float-left" data-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>



<!-- The Modal -->
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