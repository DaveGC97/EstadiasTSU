<html>
<head>
    <style type='text/css'>
        body {background-color: #fff;
             font-family: Verdana, Geneva, sans-serif}

        h3 {color:#4C628D}

        p {font-weight:bold}
    </style>
</head>
<body>
   

     <?php $url = 'http://dtai.uteq.edu.mx/~gudrog186/estadia/app_cc/static/images/autos/'.$imagen; ?>
    <div><center><img src= "http://dtai.uteq.edu.mx/~gudrog186/estadia/app/static/images/netcar-1.jpg" style="width: 100%;"></center></div><br>
    <div><center><img src= "http://dtai.uteq.edu.mx/~gudrog186/estadia/app_cc/static/images/m-1.png" align="center" style="width: 40px;"><span style="font-weight: bold;color:#4C628D"> El <strong style="color: #000;">mejor</strong> servicio para ti</span></center></div>
    <br>
    <center><div style="width: 100%; ">
    <h3 style="color: #009688;">COTIZACIÓN</h3> 
    <table style="width: 70%;">
        <tr>
          <td style="border-bottom: 2px solid #607d8b; color: #607d8b;padding-bottom: 8px;" colspan="2">
          Cliente
          </td>
        </tr>
        <tr>
          <td style="font-size: 13px; color: #212121; padding-top: 8px;" colspan="2">
          <strong style="color: #263238;"> Nombre:</strong> <?php echo $cliente; ?><br>
          <strong style="color: #263238;">Correo:</strong> <?php echo $correo; ?><br>
          <strong style="color: #263238;">Teléfono:</strong> <?php echo $telefono; ?><br><br><br>
          </td>
        </tr>

        <tr>
          <td style="border-bottom: 2px solid #607d8b; color: #607d8b;padding-bottom: 8px;" colspan="2">
          Vehiculo
          </td>
        </tr>
        <tr>
          <td style="font-size: 13px; color: #212121;padding-top: 8px;" colspan="2">
          <center><img src= "<?php echo $url; ?>" style="width: 70%;"></center>
          </td>
          
        </tr>
        <tr>
          <td style="font-size: 13px; color: #212121;padding-top: 8px;" colspan="2">
            <center><p style="color: #3f51b5; font-size: 18px;">$ <?php echo $precio; ?></p></center>
          </td>  
        </tr>
        <tr>
          <td style="font-size: 13px; color: #212121; padding-top: 8px; width: 50%;">
          <strong style="color: #263238;">Modelo:</strong> <?php echo $modelo; ?><br>
          <strong style="color: #263238;">Versión:</strong> <?php echo $version; ?><br>
          <strong style="color: #263238;">Combustible:</strong> <?php echo $combustible; ?><br>
          <strong style="color: #263238;">Motor:</strong> <?php echo $motor; ?><br>
          <strong style="color: #263238;">Cilindros:</strong> <?php echo $cilindros; ?>
          </td>
          <td style="font-size: 13px; color: #212121; padding-top: 8px; width: 50%;">
          <strong style="color: #263238;">Potencia:</strong> <?php echo $potencia; ?><br>
          <strong style="color: #263238;">Torque:</strong> <?php echo $torque; ?><br>
          <strong style="color: #263238;">Transmisión:</strong> <?php echo $transmision; ?><br>
          <strong style="color: #263238;">Valvulas:</strong> <?php echo $valvulas; ?><br>
          <strong style="color: #263238;">Color:</strong> <?php echo $color; ?>
          </td>
        </tr>

    </table>
  <br><br>
    <p>Gracias por tu solicitud.</p>   
    <p>Nos pondremos en contacto contigo.</p>
    
    <!--<img src= "<?php echo $url; ?>" align="center" >-->
    </div></center>
</body>
</html>