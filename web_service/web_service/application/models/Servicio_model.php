<?php 
class Servicio_model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}
  public function agendar_cita_cliente($nombre, $appaterno, $apmaterno, $correo, $tel, $rep_g, $ser_m, $ser_hp, $fecha, $horario){
  	$data_cliente = array ('nombre'=>$nombre, 'appaterno'=>$appaterno, 'apmaterno'=>$apmaterno, 'telefono'=>$tel, 'correo'=>$correo);
  	$this->db->insert('cliente', $data_cliente);
  	$idcliente = $this->db->insert_id();
  	$res=$this->db->affected_rows()>0;

  	if($res==TRUE){
  	  $data_cita = array('idcliente'=>$idcliente, 'fechacita'=>$fecha, 'iddiagnostico'=>NULL, 'idauto'=>NULL, 'status'=>'Agendada', 'idhorario'=> $horario);	
  	  $this->db->insert('cita', $data_cita);
  	  $idcita = $this->db->insert_id();

      if($rep_g==1){
        $data_servicio = array('idcita'=>$idcita, 'idservicio'=>1);
  	    $this->db->insert('cita_servicio', $data_servicio);
      }
      if($ser_m==1){
        $data_servicio = array('idcita'=>$idcita, 'idservicio'=>2);
  	    $this->db->insert('cita_servicio', $data_servicio);
      }
      if($ser_hp==1){
        $data_servicio = array('idcita'=>$idcita, 'idservicio'=>3);
  	    $this->db->insert('cita_servicio', $data_servicio);
      }

  	$obj["resultado"]=$this->db->affected_rows()>0;
	  $obj["mensaje"]=$obj["resultado"] ? "Cita agendada exitosamente" : "Imposible agendar";
  	}else{
  	$obj["resultado"] = FALSE;
	  $obj["mensaje"]= "Imposible registrar cliente"; 
  	}
  	return $obj;
  }

  public function get_horarios_cliente(){
    $this->db->select('idhorario, horario, hora');
    $rs = $this->db->get('horario');
    return $rs->result();
  }

  public function get_modelos_cliente(){
    $this->db->select('idmodelo, nombremodelo');
    $rs = $this->db->get('modelo');
    return $rs->result();
  }

  public function get_versiones_cliente($modelo){
      $this->db->select('idversion');
      $this->db->where( "idmodelo", $modelo );
      $this->db->where( "status", 1);
      $rs = $this->db->get("auto");
      $val=$rs->result();
      $ca=sizeof($val);
      $version_auto['ids'] = array();
      $obj['versiones'] = array();
      for ($i=0; $i <$ca ; $i++) {
        $valor = $val[$i]->idversion;
        array_push($version_auto['ids'], $valor);
        $this->db->select('idversion, nombreversion');
        $this->db->where( "idversion", $valor );
        $rs = $this->db->get("version");
        array_push($obj['versiones'], $rs->result()[0]);
      }
    return $obj;
  }

  public function get_imagen_auto_cliente($modelo, $version){
    $this->db->select("imagen, motor, cilindros, potencia, idcombustible, torque, color");
    $this->db->where("idmodelo", $modelo);
    $this->db->where("idversion", $version);
    $rs=$this->db->get("auto");
    return $rs->result();
  }

  public function solicitar_cotizacion_cliente($nombre, $appaterno, $apmaterno, $correo, $tel, $modelo, $version){
   $hoy = date("Ymd");
   //Insertar en la tabla de cliente_potencial
   $data_clientep = array ('nombre'=>$nombre, 'appaterno'=>$appaterno, 'apmaterno'=>$apmaterno, 'correo'=>$correo, 'telefono'=>$tel);
   $this->db->insert('cliente_potencial', $data_clientep);
   $idcliente_potencial = $this->db->insert_id();


   if($this->db->affected_rows()>0){
     //Obtener id del auto
      $this->db->select('idauto');
      $this->db->where( "idmodelo", $modelo );
      $this->db->where( "idversion", $version );
      $rs = $this->db->get("auto");
      $res=$rs->result();
      $idauto = $res[0]->idauto;
     //Insertar en la tabla de cotización
      $data_cotizacion = array ('fecha'=>$hoy, 'idauto'=>$idauto, 'idclientep'=>$idcliente_potencial);
      $this->db->insert('cotizacion', $data_cotizacion);

        $obj['resultado'] = $this->db->affected_rows()>0;
        

        if($obj['resultado']){
        
    $this->db->select('a.precio, a.motor, a.cilindros, a.potencia, a.torque, a.valvulas, a.color, a.imagen, c.combustible, m.nombremodelo as modelo, v.nombreversion as version, t.transmision');
    $this->db->from('auto AS a');
    $this->db->join( "combustible AS c",
        "c.idcombustible = a.idcombustible" );
    $this->db->join( "modelo AS m",
        "m.idmodelo = a.idmodelo" );
    $this->db->join( "version AS v",
        "v.idversion = a.idversion" );
    $this->db->join( "transmision AS t",
        "t.idtransmision = a.idtransmision" );
    $this->db->where('a.idauto', $idauto);
    $rs = $this->db->get();

    $data_email = $rs->result()[0];
    $data_email->cliente = $nombre. ' ' .$appaterno. ' '. $apmaterno;
    $data_email->correo = $correo;
    $data_email->telefono = $tel; 


        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load();
        
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host     = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'automed.uteq@gmail.com';
        $mail->Password = 'mldyroger';
        $mail->SMTPSecure = 'ssl';
        $mail->Port     = 465;
        
        $mail->setFrom('automed.uteq@gmail.com', 'PVm automotriz');
        // Add a recipient
        $mail->addAddress($correo);  
        // Email subject
        $mail->Subject = 'PVm | Cotizacion realizada';
        // Set email format to HTML
        $mail->isHTML(true);
        
        $name = 'Rogelio Gudimo de Leom';
        $data = array('cliente' => $name,
              'auto' => '2_azul.png');
        
        // Email body content
        $mailContent = "<h1>Send HTML Email using SMTP in CodeIgniter</h1>
            <p>This is a test email sending using SMTP mail server with PHPMailer.</p>";
        //$mail->Body = $mailContent;
        $mail->Body = $this->load->view('cotizacion_view',$data_email, true);
        
        $obj["mensaje"]=$mail->send() ? "Solicitud realizada exitosamente" : "Imposible realizar petición";
  
        }
   }
   return $obj;
  }

  public function get_autos_cliente(){
    $this->db->select('c.*, a.*, b.combustible, m.nombremodelo, v.nombreversion, t.transmision');
    $this->db->from('auto AS a');
    $this->db->join( "carroceria AS c",
        "c.idcarroceria = a.idcarroceria" );
    $this->db->join( "combustible AS b",
        "b.idcombustible = a.idcombustible" );
    $this->db->join( "modelo AS m",
        "m.idmodelo = a.idmodelo" );
    $this->db->join( "version AS v",
        "v.idversion = a.idversion" );
    $this->db->join( "transmision AS t",
        "t.idtransmision = a.idtransmision" );
    $this->db->where('a.status', 1);
    //$this->db->distinct('idcarroceria');
    $rs = $this->db->get();
    $obj['auto'] = $rs->result(); 
    
    $this->db->select('a.idcarroceria, c.carroceria');
    $this->db->from('auto AS a');
    $this->db->distinct('idcarroceria');
    $this->db->join( "carroceria AS c",
        "c.idcarroceria = a.idcarroceria" );
    $this->db->where('a.status', 1);
    $rs = $this->db->get();
    $obj['carroceria'] = $rs->result(); 

    return $obj;
  }

  public function verificar_sesion_cc($usuario, $contrasena){
    $this->db->where("usuario", $usuario);
    $this->db->where("contrasena", $contrasena);
    $this->db->where("status", 1);
    $rs = $this->db->get("usuario");
    $obj[ "resultado" ] = $rs->num_rows() > 0;
    
    if ( $obj[ "resultado" ] ) {
      $obj[ "mensaje" ] = "Sesión iniciada";
      $obj[ "usuario" ] = $rs->row();
    }
    else {
      $obj[ "mensaje" ] = "El nombre de usuario y la contraseña que ingresaste son incorrectos. Por favor, inténtalo de nuevo.";
    }
    return $obj;
  }

  public function get_citas_cc(){
    $this->db->select("c.*, cs.*, s.*, h.*, cl.*");
    $this->db->from('cita AS c');
    //$this->db->distinct('idcita');
    $this->db->join( "cita_servicio AS cs",
        "c.idcita = cs.idcita" );
    $this->db->join( "servicio AS s",
        "cs.idservicio = s.idservicio" );
    $this->db->join( "horario AS h",
        "h.idhorario = c.idhorario" );
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );
    $this->db->order_by('fechacita');
    $this->db->group_by('c.idcita');
    $rs=$this->db->get();
    $obj['citas'] = $rs->result();
    
    $this->db->select("cs.idcita, s.tipo, s.idservicio");
    $this->db->from('cita_servicio AS cs');
    $this->db->join( "servicio AS s",
        "s.idservicio = cs.idservicio" );
    $this->db->distinct('cs.idcita');
    $rs = $this->db->get();
    $obj['servicios_solicitados'] = $rs->result(); 
    //$this->db->select("idcita, idservicio");
    //$this->db->from('cita_servicio');
    //$this->db->join( "cita_servicio AS cs",
      //  "s.idservicio = cs.idservicio" );
    //$this->db->group_by('idcita');
    //$this->db->distinct('idcita');
    //$rs = $this->db->get();
    //$obj['servicios_solicitados'] = $rs->result();

    return $obj;
  }

  public function get_cotizaciones_cc(){
    $this->db->select("c.*, m.nombremodelo, v.nombreversion, cp.*");
    $this->db->from('cotizacion AS c');
    //$this->db->distinct('idcita');
    $this->db->join( "auto AS a",
        "c.idauto = a.idauto" );
    $this->db->join( "cliente_potencial AS cp",
        "cp.idclientep = c.idclientep" );
    $this->db->join( "modelo AS m",
        "m.idmodelo = a.idmodelo" );
    $this->db->join( "version AS v",
        "v.idversion = a.idversion" );
    $rs = $this->db->get();

   return $rs->result();
  }

  public function get_citas_xfecha_cc($fecha){
    $this->db->select('idhorario, horario, hora');
    $this->db->order_by('idhorario');
    $rs = $this->db->get('horario');
    $obj['horarios'] = $rs->result();

    $this->db->select("c.*, h.*");
    $this->db->from('cita AS c');
    //$this->db->distinct('idcita');
    /*$this->db->join( "cita_servicio AS cs",
        "c.idcita = cs.idcita" );
    $this->db->join( "servicio AS s",
        "cs.idservicio = s.idservicio" );*/
    $this->db->join( "horario AS h",
        "h.idhorario = c.idhorario" );
    /*$this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );*/
    $this->db->where( "fechacita", $fecha );
    $this->db->order_by('fechacita');
    //$this->db->group_by('c.idcita');
    $rs=$this->db->get();
    
     $obj['citas'] = $rs->result();
    $this->db->select("cs.idcita, s.tipo, s.idservicio");
    $this->db->from('cita_servicio AS cs');
    $this->db->join( "servicio AS s",
        "s.idservicio = cs.idservicio" );
    $this->db->distinct('cs.idcita');
    $rs = $this->db->get();
    $obj['servicios_solicitados'] = $rs->result();  
    
     

    return $obj;  
  }

  public function get_citas_proximas_cc($fecha_1, $fecha_2, $fecha_3, $fecha_4){
 //OBTENER CITAS +1 DIA
    $this->db->select("c.*, h.*, cl.*, concat(cl.nombre, ' ', cl.appaterno, ' ', apmaterno) as cliente");
    $this->db->from('cita AS c');
    /*$this->db->join( "cita_servicio AS cs", //PRUEBA PARA EL SERVIDOR DTAI arriba tenia cs.* y s.*
        "c.idcita = cs.idcita" );
    $this->db->join( "servicio AS s",
        "cs.idservicio = s.idservicio" );*/
    $this->db->join( "horario AS h",
        "h.idhorario = c.idhorario" );
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );
    $this->db->where( "fechacita", $fecha_1 );
    $this->db->order_by('fechacita');
    $this->db->group_by('c.idcita');
    $rs=$this->db->get();  
    $obj['citas1'] = $rs->result();

    $this->db->select("count(idcita) as cantidad");
    $this->db->from("cita");
    $this->db->where("status", "Agendada");
    $this->db->where( "fechacita", $fecha_1 );
    $rs=$this->db->get();
    
    $obj['faltantes1'] = $rs->result();
 
    //OBTENER CITAS +2 DIAS
    $this->db->select("c.*, h.*, cl.*, concat(cl.nombre, ' ', cl.appaterno, ' ', apmaterno) as cliente");
    $this->db->from('cita AS c');
    /*$this->db->join( "cita_servicio AS cs",
        "c.idcita = cs.idcita" );
    $this->db->join( "servicio AS s",
        "cs.idservicio = s.idservicio" );*/
    $this->db->join( "horario AS h",
        "h.idhorario = c.idhorario" );
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );
    $this->db->where( "fechacita", $fecha_2 );
    $this->db->order_by('fechacita');
    $this->db->group_by('c.idcita');
    $rs=$this->db->get();  
    $obj['citas2'] = $rs->result();

    $this->db->select("count(idcita) as cantidad");
    $this->db->from("cita");
    $this->db->where("status", "Agendada");
    $this->db->where( "fechacita", $fecha_2 );
    $rs=$this->db->get();
    
    $obj['faltantes2'] = $rs->result(); 

    //OBTENER CITAS +3 DIAS
    $this->db->select("c.*, h.*, cl.*, concat(cl.nombre, ' ', cl.appaterno, ' ', apmaterno) as cliente");
    $this->db->from('cita AS c');
    /*$this->db->join( "cita_servicio AS cs",
        "c.idcita = cs.idcita" );
    $this->db->join( "servicio AS s",
        "cs.idservicio = s.idservicio" );*/
    $this->db->join( "horario AS h",
        "h.idhorario = c.idhorario" );
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );
    $this->db->where( "fechacita", $fecha_3 );
    $this->db->order_by('fechacita');
    $this->db->group_by('c.idcita');
    $rs=$this->db->get();  
    $obj['citas3'] = $rs->result();

    $this->db->select("count(idcita) as cantidad");
    $this->db->from("cita");
    $this->db->where("status", "Agendada");
    $this->db->where( "fechacita", $fecha_3 );
    $rs=$this->db->get();
    
    $obj['faltantes3'] = $rs->result();

    //OBTENER CITAS +4 DIAS
    $this->db->select("c.*, h.*, cl.*, concat(cl.nombre, ' ', cl.appaterno, ' ', apmaterno) as cliente");
    $this->db->from('cita AS c');
    /*$this->db->join( "cita_servicio AS cs",
        "c.idcita = cs.idcita" );
    $this->db->join( "servicio AS s",
        "cs.idservicio = s.idservicio" );*/
    $this->db->join( "horario AS h",
        "h.idhorario = c.idhorario" );
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );
    $this->db->where( "fechacita", $fecha_4 );
    $this->db->order_by('fechacita');
    $this->db->group_by('c.idcita');
    $rs=$this->db->get();  
    $obj['citas4'] = $rs->result();

    $this->db->select("count(idcita) as cantidad");
    $this->db->from("cita");
    $this->db->where("status", "Agendada");
    $this->db->where( "fechacita", $fecha_4 );
    $rs=$this->db->get();
    
    $obj['faltantes4'] = $rs->result();

    return $obj;  
  }

  public function get_citas_del_dia_cc($fecha_1){
    $this->db->select("c.*, h.*, cl.*, concat(cl.nombre, ' ', cl.appaterno, ' ', apmaterno) as cliente");
    $this->db->from('cita AS c');
    /*$this->db->join( "cita_servicio AS cs",
        "c.idcita = cs.idcita" );
    $this->db->join( "servicio AS s",
        "cs.idservicio = s.idservicio" );*/
    $this->db->join( "horario AS h",
        "h.idhorario = c.idhorario" );
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );
    $this->db->where( "fechacita", $fecha_1 );
    $this->db->order_by('fechacita');
    $this->db->order_by('c.idhorario');
    $this->db->group_by('c.idcita');
    $rs=$this->db->get();  
    $obj['citas'] = $rs->result();

   /* Codigo no funciona
    $this->db->select("count(t.idtarea) as tareas, c.idcita, t.idorden");
    $this->db->from('tarea AS t');
    $this->db->join( "cita AS c",
        "t.idcita = c.idcita" );
    $this->db->where('fechacita', $fecha_1);
    $this->db->where('c.status !=', 'Agendada');
    $this->db->where('c.status !=', 'Confirmada');
    $this->db->group_by('c.idcita');
    $rs=$this->db->get();  */
    $this->db->select("count(o.idorden) as tareas, c.idcita, o.idorden");
    $this->db->from('cita AS c');
    $this->db->join( "orden AS o",
        "o.idorden = c.idorden" );
    $this->db->where('c.fechacita', $fecha_1);
    $this->db->where('c.status !=', 'Agendada');
    $this->db->where('c.status !=', 'Confirmada');
    $this->db->group_by('c.idcita');
    $rs=$this->db->get();
    
     $obj['proceso'] = $rs->result();
    
    

    return $obj;
  }


    public function get_citas_calendar_cc(){
    /*$this->db->select('idhorario, horario');
    $this->db->order_by('idhorario');
    $rs = $this->db->get('horario');
    $obj['horarios'] = $rs->result();*/

    /*$this->db->select("c.*, cs.*, s.*, h.*, cl.*, concat(c.fechacita, h.horainicio) as start, concat(cl.nombre, ' ', cl.appaterno, ' ', cl.apmaterno) as title");
    $this->db->from('cita AS c');
    //$this->db->distinct('idcita');
    $this->db->join( "cita_servicio AS cs",
        "c.idcita = cs.idcita" );
    $this->db->join( "servicio AS s",
        "cs.idservicio = s.idservicio" );
    $this->db->join( "horario AS h",
        "h.idhorario = c.idhorario" );
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );
    $this->db->order_by('fechacita');
    $this->db->group_by('c.idcita');
    $rs=$this->db->get();*/
    date_default_timezone_set('UTC');
    date_default_timezone_set("America/Mexico_City");
    $hoy = date( "Y-m-d" ); 

    //PRUEBA PARA EL SERVIDOR DTAI
     $this->db->select("c.*, h.*, cl.*, concat(c.fechacita, h.horainicio) as start, concat(cl.nombre, ' ', cl.appaterno, ' ', cl.apmaterno) as title");
    $this->db->from('cita AS c');
    //$this->db->distinct('idcita');
    /*$this->db->join( "cita_servicio AS cs",
        "c.idcita = cs.idcita" );
    $this->db->join( "servicio AS s",
        "cs.idservicio = s.idservicio" );*/
    
    $this->db->join( "horario AS h",
        "h.idhorario = c.idhorario" );
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );
    $this->db->where('c.fechacita >=', $hoy);
    $this->db->order_by('c.fechacita');
    $this->db->group_by('c.idcita');
    $rs=$this->db->get();
    //fin prueba
    
     $obj['citas'] = $rs->result();
   $this->db->select('fechacita as start, concat(count(idcita), " citas agendadas") as title');
   $this->db->from('cita');
   $this->db->where('fechacita >=', $hoy);
   $this->db->group_by('fechacita');
    $rs=$this->db->get();
    $datos = $rs->result();
     //$obj['citas'] += $rs->result();
    for ($x = 0; $x < sizeof($datos); $x++)
    {
    array_push($obj['citas'], $datos[$x]);
    }
    //array_push($obj['citas'], );
   /* $this->db->select("cs.idcita, s.tipo, s.idservicio");
    $this->db->from('cita_servicio AS cs');
    $this->db->join( "servicio AS s",
        "s.idservicio = cs.idservicio" );
    $this->db->distinct('cs.idcita');
    $rs = $this->db->get();
    $obj['servicios_solicitados'] = $rs->result();  */
    
     

    return $obj;  
  }

  public function update_status_cita_cc($idcita, $status){
  $this->db->set("status", $status);
  $this->db->where("idcita", $idcita);
  $this->db->update("cita");
  $obj["resultado"] = $this->db->affected_rows()>0;
  $obj["mensaje"] = "Cambio de status";
  return $obj;

  }

  public function get_asesor_cc(){
    $this->db->select("u.usuario, concat(a.nombre, ' ', a.appaterno, ' ', a.apmaterno) as asesor");
    $this->db->from('usuario AS u');
    $this->db->join( "asesor AS a",
        "u.usuario = a.usuario" );
    $this->db->where('u.status', 1);
    $rs=$this->db->get();
    return $rs->result();  
  }
  
  public function generar_orden_cc($idcita, $asesor, $fecha){
    date_default_timezone_set('UTC');
    date_default_timezone_set("America/Mexico_City");
    $hoy = date( "Y-m-d  H:i:s" ); 
    $data = array ('fecha'=>$hoy, 'status'=>'Generada');
    $this->db->insert('orden', $data);
    $obj['orden'] = $this->db->insert_id();
    $res = $this->db->affected_rows()>0;
    if($res){
    //Insertar en tarea
   /* $data = array ('idorden'=>$obj['orden'], 'idcita'=>$idcita, 'tarea'=>'Realizar prediagnóstico', 'tiempo'=>'10 min', 'status' => 0);
    $this->db->insert('tarea', $data);*/
   
    //Update de status cita 
    $obj['status'] = 'En servicio';
    $this->db->set("status", $obj['status']);
    $this->db->set("idorden", $obj['orden']);
    $this->db->where("idcita", $idcita);
    $this->db->update("cita");


    //Insertar en cita_usuario, los empleados que atienden cita
    $data = array ('idcita'=>$idcita, 'usuario'=>$asesor);
    $this->db->insert('cita_usuario', $data);
    $obj["resultado"] = $this->db->affected_rows()>0;
    $obj["mensaje"] = $obj["resultado"] ? "Orden creada" : "Imposible crear";
    }else{
    $obj["resultado"] = FALSE;
    }
    

    return $obj;
  }

  public function get_orden_proximas_cc($usuario, $fecha){
    $this->db->select("c.idcita, cu.usuario, o.idorden, o.fecha, concat(cl.nombre, ' ', cl.appaterno, ' ', cl.apmaterno) as cliente, cl.*, c.fechacita, o.status");
    //arriba tenia t.idtarea
    $this->db->from('cita_usuario AS cu');
    $this->db->join( "cita AS c",
        "c.idcita = cu.idcita" );
    /*$this->db->join( "tarea AS t",
        "t.idcita = c.idcita" );
    $this->db->join( "orden AS o",
        "o.idorden = t.idorden" );*/
    $this->db->join( "orden AS o",
        "o.idorden = c.idorden" );
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );
    $this->db->where( "cu.usuario", $usuario );
    $this->db->where( "c.fechacita", $fecha );
    $this->db->group_start();
    $this->db->where( "o.status", 'Generada' );
    $this->db->or_where( "o.status", 'Prediagnostico' );
    $this->db->or_where( "o.status", 'Cotizacion' );
    $this->db->group_end();
    $this->db->order_by('o.fecha');
    $this->db->group_by('c.idcita');
    $rs=$this->db->get();
    $obj["resultado"] = $rs->num_rows() > 0;
  if($obj["resultado"]){
    $obj['orden'] = $rs->result(); 
    $obj['mensaje'] = 'Todo ok'; 

    $this->db->select("cs.idcita, s.tipo, s.idservicio");
    $this->db->from('cita_servicio AS cs');
    $this->db->join( "servicio AS s",
        "s.idservicio = cs.idservicio" );
    $this->db->join( "cita AS c",
        "c.idcita = cs.idcita" );
    $this->db->join( "cita_usuario AS cu",
        "cu.idcita = c.idcita" );
    $this->db->where( "cu.usuario", $usuario );
    $this->db->where( "c.fechacita", $fecha );
   // $this->db->distinct('cs.idcita');
    $rs = $this->db->get();
    $obj['servicios_solicitados'] = $rs->result(); 
  }else{
    $obj['mensaje'] = 'No hay ordenes de trabajo asignados';
  }
  return $obj;
  }

   public function get_motor_cc(){
    $this->db->select('idcombustible, combustible');
    $rs = $this->db->get('combustible');
    return $rs->result();
  }
  public function get_carroceria_cc(){
    $this->db->select('idcarroceria, carroceria');
    $rs = $this->db->get('carroceria');
    return $rs->result();
  }

  public function insert_prediagnostico_cc($idcita, $orden, $vin, $modelo, $version, $km, $fechatermino, $caract_internas, $caract_externas, $defecto){
   $data = array('kilometraje' => $km, 'caracinternas' => $caract_internas, 'caracexternas' => $caract_externas, 'vin' => $vin, 'defecto' => $defecto);
   $this->db->insert('diagnostico', $data);
   $iddiagnostico = $this->db->insert_id();

   $this->db->select('idauto');
   $this->db->where('idmodelo', $modelo);
   $this->db->where('idversion', $version);
   $rs = $this->db->get("auto");
    $val=$rs->result();
    $idauto = $val[0]->idauto;

   $this->db->set("iddiagnostico", $iddiagnostico);
   $this->db->set("idauto", $idauto);
   $this->db->where("idcita", $idcita);
   $this->db->update("cita");

     if($this->db->affected_rows()>0){
       /*$this->db->set("status", 1);
       $this->db->where("idcita", $idcita);
       $this->db->where("idorden", $orden);
       $this->db->where("tarea", 'Realizar prediagnóstico');
       $this->db->update("tarea");       

       $data = array('idorden' => $orden, 'idcita' => $idcita, 'tarea' => 'Realizar cotización', 'tiempo' => '5 min', 'status' => 0);
       $this->db->insert('tarea', $data);*/

       $this->db->set("fechatermino", $fechatermino);
       $this->db->set("status", 'Prediagnostico');
       $this->db->where("idorden", $orden);
       $this->db->update("orden");
          $obj["resultado"] = $this->db->affected_rows()>0;
          $obj["mensaje"] = $obj["resultado"] ? "Petición realizada" : "Imposible realizar petición";
     }
    return $obj;
  }


  public function insert_cotizacion_servicio_cc($idorden, $idcita, $total, $array_costo, $array_concepto, $accion_cotizacion){

  if($accion_cotizacion == 1){
    $this->db->select("cs.idcotizacion");
    $this->db->from('cotizacion_servicio AS cs');
    $this->db->join( "cita_cotizacion AS cc",
        "cs.idcotizacion = cc.idcotizacion" );
    $this->db->where( "cc.idcita", $idcita );
    $rs = $this->db->get();
    $val = $rs->result();

    $idcotizacion = $val[0]->idcotizacion;
    $this->db->set("total", $total);
    $this->db->where("idcotizacion", $idcotizacion);
    $this->db->update("cotizacion_servicio");

    $this->db->where("idcotizacion", $idcotizacion);
    $this->db->delete("cita_cotizacion");
        $obj["resultado"] = $this->db->affected_rows()>0;
        $obj["mensaje"] = $obj["resultado"] ? "Se realizo la petición" : "Imposible realizar petición";
    
    for($a = 0; $a < sizeof($array_costo); $a++){
     $data = array('idcotizacion' => $idcotizacion, 'idcita' => $idcita, 'concepto' => $array_concepto[$a], 'costo' => $array_costo[$a]);
     $this->db->insert('cita_cotizacion', $data);
    } 
  }else{
  $data = array('total' => $total);
  $this->db->insert('cotizacion_servicio', $data);
  $idcotizacion = $this->db->insert_id();

  for($a = 0; $a < sizeof($array_costo); $a++){
   $data = array('idcotizacion' => $idcotizacion, 'idcita' => $idcita, 'concepto' => $array_concepto[$a], 'costo' => $array_costo[$a]);
   $this->db->insert('cita_cotizacion', $data);
  } 

    /*$this->db->set("status", 1);
    $this->db->where("idcita", $idcita);
    $this->db->where("idorden", $idorden);
    $this->db->where("tarea", 'Realizar cotización');
    $this->db->update("tarea");   */ 

   /* $data = array('idorden' => $idorden, 'idcita' => $idcita, 'tarea' => 'Asignar tareas', 'tiempo' => '5 min', 'status' => 0);
    $this->db->insert('tarea', $data);   */

    $this->db->set("status", 'Cotizacion');
    $this->db->where("idorden", $idorden);
    $this->db->update("orden");
          $obj["resultado"] = $this->db->affected_rows()>0;
          $obj["mensaje"] = $obj["resultado"] ? "Se realizo la petición" : "Imposible realizar petición";
   }

    return $obj;
  }

  public function get_info_taras_cc($idorden, $idcita, $detenido){
    $this->db->select("c.fechacita, concat(cl.nombre, ' ', cl.appaterno, ' ', cl.apmaterno) as cliente, cl.correo, cl.telefono, d.vin, m.nombremodelo, v.nombreversion");
    $this->db->from('cita AS c');
    $this->db->join( "diagnostico AS d",
        "d.iddiagnostico = c.iddiagnostico" );
    $this->db->join( "auto AS a",
        "a.idauto = c.idauto" );
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );
    $this->db->join( "modelo AS m",
        "m.idmodelo = a.idmodelo" );
    $this->db->join( "version AS v",
        "v.idversion = a.idversion" );
    $this->db->where( "c.idcita", $idcita );
    $rs = $this->db->get();
    $obj['datos'] = $rs->result();

    $this->db->where('idorden', $idorden);
    $rs = $this->db->get('tarea');
    $obj['tareas'] = $rs->result();

 if($detenido == 1){
    $this->db->select("o.*, t.*");
    $this->db->from('tarea AS t');
    $this->db->join( "observacion AS o",
        "t.idtarea = o.idtarea" );
    $this->db->where( "t.idorden", $idorden );
    $this->db->where( "t.idcita", $idcita );
    $this->db->where( "t.status", 3 );
    $this->db->where( "o.status", 0 );
    $rs = $this->db->get();
    $obj['resultado'] = $rs->num_rows() > 0;
    $obj['tareas_detenidas'] = $rs->result();
  }

    return $obj; 
  }

  public function insert_update_tarea_cc($idcita, $idorden, $idtarea, $tarea, $tiempo, $mecanico, $usuario, $fecha){
    date_default_timezone_set('UTC');
    date_default_timezone_set("America/Mexico_City");
    if($mecanico == 'hp'){
     $mecanico = NULL;
    }
    $hoy = date( "Y-m-d  H:i:s" ); 
    if($idtarea == 'nueva'){
      $data = array('idcita' => $idcita, 'idorden' => $idorden, 'tarea' => $tarea, 'tiempo' => $tiempo, 'status' =>0, 'fechahora' => $hoy, 'usuario' => $mecanico);
      $this->db->insert('tarea', $data);
      $obj['idtarea'] = $this->db->insert_id();
        $obj["resultado"] = $this->db->affected_rows()>0;
        $obj["mensaje"] = $obj["resultado"] ? "Se realizo la petición" : "Imposible realizar petición";
        $obj['accion'] = 'agrega';
    }else{
      $this->db->set("tarea", $tarea);
      $this->db->set("tiempo", $tiempo);
      $this->db->set("usuario", $mecanico);
      $this->db->where("idtarea", $idtarea);
      $this->db->update("tarea"); 
        $obj["resultado"] = $this->db->affected_rows()>0;
        $obj["mensaje"] = $obj["resultado"] ? "Se realizo la petición" : "Imposible realizar petición";
        $obj['accion'] = 'actualiza';

    $this->db->select('t.*');
    $this->db->from('tarea AS t');
    $this->db->where('idtarea', $idtarea);
    $rs=$this->db->get();
    $obj['tareas'] = $rs->result();
    }

      $this->db->select("c.idcita, cu.usuario, o.idorden, o.fecha, concat(cl.nombre, ' ', cl.appaterno, ' ', cl.apmaterno) as cliente, cl.*, c.fechacita, o.status");
    $this->db->from('cita_usuario AS cu');
    $this->db->join( "cita AS c",
        "c.idcita = cu.idcita" );
    $this->db->join( "orden AS o",
        "o.idorden = c.idorden" );
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );
    $this->db->where( "cu.usuario", $usuario );
    $this->db->group_start();
    $this->db->where( "o.status", 'En proceso' );
    $this->db->or_where( "o.status", 'Final' );
    $this->db->or_where( "o.status", 'Hp' );
    $this->db->or_where( "o.status", 'Lavado' );
    $this->db->group_end();

    //$this->db->where( "o.status", 'En proceso' );
    $this->db->order_by('o.fecha');
    $this->db->group_by('c.idcita');
    $rs=$this->db->get();
    $obj['hay'] = $rs->num_rows() > 0;
  if($obj['hay']){
    $obj['orden'] = $rs->result();
    $val=$obj['orden'];
    
    $obj['tareas_p'] = array();
    for ($x = 0; $x < sizeof($val); $x++){
    $idorden = $val[$x]->idorden;
    $this->db->where('idorden', $idorden);
    $rs = $this->db->get('tarea');
    $datos = $rs->result();
    array_push($obj['tareas_p'], $datos);
    }
  }

    return $obj;
  }

  public function delete_tarea_cc($idtarea, $usuario, $tarea){
    $this->db->where("idtarea", $idtarea);
    $this->db->delete("tarea");

    $obj["resultado"] = $this->db->affected_rows() > 0;
    $obj["mensaje"]   = $obj["resultado"] ? "Tarea eliminada" : "Imposible borrar";

     $this->db->select("c.idcita, cu.usuario, o.idorden, o.fecha, concat(cl.nombre, ' ', cl.appaterno, ' ', cl.apmaterno) as cliente, cl.*, c.fechacita, o.status");
    $this->db->from('cita_usuario AS cu');
    $this->db->join( "cita AS c",
        "c.idcita = cu.idcita" );
    $this->db->join( "orden AS o",
        "o.idorden = c.idorden" );
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );
    $this->db->where( "cu.usuario", $usuario );
    $this->db->group_start();
    $this->db->where( "o.status", 'En proceso' );
    $this->db->or_where( "o.status", 'Final' );
    $this->db->or_where( "o.status", 'Hp' );
    $this->db->or_where( "o.status", 'Lavado' );
    $this->db->group_end();
    //$this->db->where( "o.status", 'En proceso' );
    $this->db->order_by('o.fecha');
    $this->db->group_by('c.idcita');
    $rs=$this->db->get();
    $obj['hay'] = $rs->num_rows() > 0;
  if($obj['hay']){
    $obj['orden'] = $rs->result();
    $val=$obj['orden'];
    
    $obj['tareas_p'] = array();
    for ($x = 0; $x < sizeof($val); $x++){
    $idorden = $val[$x]->idorden;
    $this->db->where('idorden', $idorden);
    $rs = $this->db->get('tarea');
    $datos = $rs->result();
    array_push($obj['tareas_p'], $datos);
    }
  }

    return $obj;
  }

  public function play_tarea_cc($idtarea){
      $this->db->set("status", 2);
      $this->db->where("idtarea", $idtarea);
      $this->db->update("tarea"); 
        $obj["resultado"] = $this->db->affected_rows()>0;
        $obj["mensaje"] = $obj["resultado"] ? "Se realizo la petición" : "Imposible realizar petición";
      return $obj;
  }

  public function pause_tarea_cc($idtarea){
      $this->db->set("status", 3);
      $this->db->where("idtarea", $idtarea);
      $this->db->update("tarea"); 
        $obj["resultado"] = $this->db->affected_rows()>0;
        $obj["mensaje"] = $obj["resultado"] ? "Se realizo la petición" : "Imposible realizar petición";
      return $obj;
  }

  public function stop_tarea_cc($idtarea, $usuario, $fecha){
      $this->db->set("status", 1);
      $this->db->where("idtarea", $idtarea);
      $this->db->update("tarea"); 
        $obj["resultado"] = $this->db->affected_rows()>0;
        //$obj["mensaje"] = $obj["resultado"] ? "Se realizo la petición" : "Imposible realizar petición";

  $this->db->select("c.idcita, cu.usuario, o.idorden, o.fecha, concat(cl.nombre, ' ', cl.appaterno, ' ', cl.apmaterno) as cliente, cl.*, c.fechacita, o.status");
    $this->db->from('cita_usuario AS cu');
    $this->db->join( "cita AS c",
        "c.idcita = cu.idcita" );
    $this->db->join( "orden AS o",
        "o.idorden = c.idorden" );
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );
    $this->db->where( "cu.usuario", $usuario );

    $this->db->group_start();
    $this->db->where( "o.status", 'En proceso' );
    $this->db->or_where( "o.status", 'Final' );
    $this->db->or_where( "o.status", 'Hp' );
    $this->db->or_where( "o.status", 'Lavado' );
    $this->db->group_end();

    //$this->db->where( "o.status", 'En proceso' );
    $this->db->order_by('o.fecha');
    $this->db->group_by('c.idcita');
    $rs=$this->db->get();
    $obj['hay'] = $rs->num_rows() > 0;
  if($obj['hay']){
    $obj['orden'] = $rs->result();
    $val=$obj['orden'];
    
    $obj['tareas_p'] = array();
    for ($x = 0; $x < sizeof($val); $x++){
    $idorden = $val[$x]->idorden;
    $this->db->where('idorden', $idorden);
    $rs = $this->db->get('tarea');
    $datos = $rs->result();
    array_push($obj['tareas_p'], $datos);
    }
  }

      return $obj;
  }
  
  public function previo($fecha){
     $this->db->select("count(t.idtarea) as tareas, c.idcita");
    $this->db->from('tarea AS t');
    $this->db->join( "cita AS c",
        "t.idcita = c.idcita" );
    $this->db->where('fechacita', $fecha);
    $this->db->group_by('c.idcita');
    $rs=$this->db->get();
    
     $obj['proceso'] = $rs->result();
     return $obj;
  }

  public function tareas_proceso_cc($idorden, $usuario, $fecha){
      $this->db->set("status", 'En proceso');
      $this->db->where("idorden", $idorden);
      $this->db->update("orden"); 
        $obj["resultado"] = $this->db->affected_rows()>0;
   if($obj["resultado"]){
    $this->db->select("c.idcita, cu.usuario, o.idorden, o.fecha, concat(cl.nombre, ' ', cl.appaterno, ' ', cl.apmaterno) as cliente, cl.*, c.fechacita, o.status");
    //arriba tenia t.idtarea
    $this->db->from('cita_usuario AS cu');
    $this->db->join( "cita AS c",
        "c.idcita = cu.idcita" );
    $this->db->join( "orden AS o",
        "o.idorden = c.idorden" );
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );
    $this->db->where( "cu.usuario", $usuario );
    $this->db->where( "c.fechacita", $fecha );

    $this->db->group_start();
    $this->db->where( "o.status", 'Generada' );
    $this->db->or_where( "o.status", 'Prediagnostico' );
    $this->db->or_where( "o.status", 'Cotizacion' );
    $this->db->group_end();

    $this->db->order_by('o.fecha');
    $this->db->group_by('c.idcita');
    $rs=$this->db->get();
    $obj['hay'] = $rs->num_rows() > 0;
  if($obj['hay']){
    $obj['orden'] = $rs->result(); 

    $this->db->select("cs.idcita, s.tipo, s.idservicio");
    $this->db->from('cita_servicio AS cs');
    $this->db->join( "servicio AS s",
        "s.idservicio = cs.idservicio" );
    $this->db->join( "cita AS c",
        "c.idcita = cs.idcita" );
    $this->db->join( "cita_usuario AS cu",
        "cu.idcita = c.idcita" );
    $this->db->where( "cu.usuario", $usuario );
    $this->db->where( "c.fechacita", $fecha );
    $rs = $this->db->get();
    $obj['servicios_solicitados'] = $rs->result(); 

  }else{
    $obj['mensaje'] = 'No hay ordenes de trabajo asignados';
  }

     //CONSULTA PARA LAS CARDS EN PROCESO
     $this->db->select("c.idcita, cu.usuario, o.idorden, o.fecha, concat(cl.nombre, ' ', cl.appaterno, ' ', cl.apmaterno) as cliente, cl.*, c.fechacita, o.status");
    $this->db->from('cita_usuario AS cu');
    $this->db->join( "cita AS c",
        "c.idcita = cu.idcita" );
    $this->db->join( "orden AS o",
        "o.idorden = c.idorden" );
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );
    $this->db->where( "cu.usuario", $usuario );

    $this->db->group_start();
    $this->db->where( "o.status", 'En proceso' );
    $this->db->or_where( "o.status", 'Final' );
    $this->db->or_where( "o.status", 'Hp' );
    $this->db->or_where( "o.status", 'Lavado' );
    $this->db->group_end();

    //$this->db->where( "o.status", 'En proceso' );
    $this->db->order_by('o.fecha');
    $this->db->group_by('c.idcita');
    $rs=$this->db->get();
    $obj['hay_p'] = $rs->num_rows() > 0;
  if($obj['hay_p']){
    $obj['orden_p'] = $rs->result();
    $val=$obj['orden_p'];
    
    $obj['tareas_p'] = array();
    for ($x = 0; $x < sizeof($val); $x++){
    $idorden = $val[$x]->idorden;
    $this->db->where('idorden', $idorden);
    $rs = $this->db->get('tarea');
    $datos = $rs->result();
    array_push($obj['tareas_p'], $datos);
    }
  }
}

      return $obj;
  }

  public function orden_proceso_cc($usuario, $fecha){
  $this->db->select("c.idcita, cu.usuario, o.idorden, o.fecha, concat(cl.nombre, ' ', cl.appaterno, ' ', cl.apmaterno) as cliente, cl.*, c.fechacita, o.status");
    $this->db->from('cita_usuario AS cu');
    $this->db->join( "cita AS c",
        "c.idcita = cu.idcita" );
    $this->db->join( "orden AS o",
        "o.idorden = c.idorden" );
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );
    $this->db->where( "cu.usuario", $usuario );

     $this->db->group_start();
    $this->db->where( "o.status", 'En proceso' );
    $this->db->or_where( "o.status", 'Final' );
    $this->db->or_where( "o.status", 'Hp' );
    $this->db->or_where( "o.status", 'Lavado' );
    $this->db->group_end();

    //$this->db->where( "o.status", 'En proceso' );
    $this->db->order_by('o.fecha');
    $this->db->group_by('c.idcita');
    $rs=$this->db->get();
    $obj['hay'] = $rs->num_rows() > 0;
  if($obj['hay']){
    $obj['orden'] = $rs->result();
    $val=$obj['orden'];
    
    $obj['tareas_p'] = array();
    for ($x = 0; $x < sizeof($val); $x++){
    $idorden = $val[$x]->idorden;
    $this->db->where('idorden', $idorden);
    $rs = $this->db->get('tarea');
    $datos = $rs->result();
    array_push($obj['tareas_p'], $datos);
    }
  }
  return $obj;
  }

    public function get_mecanico_cc(){
    $this->db->select("u.usuario, concat(m.nombre, ' ', m.appaterno, ' ', m.apmaterno) as mecanico");
    $this->db->from('usuario AS u');
    $this->db->join( "mecanico AS m",
        "u.usuario = m.usuario" );
    $this->db->where('u.status', 1);
    $rs=$this->db->get();
    return $rs->result();  
  }

  public function get_tareas_detenidas_cc($usuario){
  $this->db->select("c.idcita, cu.usuario, o.idorden, o.fecha, concat(cl.nombre, ' ', cl.appaterno, ' ', cl.apmaterno) as cliente, cl.*, c.fechacita, o.status");
    $this->db->from('cita_usuario AS cu');
    $this->db->join( "cita AS c",
        "c.idcita = cu.idcita" );
    $this->db->join( "orden AS o",
        "o.idorden = c.idorden" );
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );
    $this->db->where( "cu.usuario", $usuario );
    $this->db->where( "o.status", 'En proceso' );
    $this->db->order_by('o.fecha');
    $this->db->group_by('c.idcita');
    $rs=$this->db->get();
    $obj['hay'] = $rs->num_rows() > 0;
  if($obj['hay']){
    $obj['orden'] = $rs->result();
    $val=$obj['orden'];
    
    $obj['tareas_detenidas'] = array();
    $obj['observaciones'] = array();
    for ($x = 0; $x < sizeof($val); $x++){
    $idorden = $val[$x]->idorden;
    $this->db->where('idorden', $idorden);
    $this->db->where('status', 3);
    $rs = $this->db->get('tarea');
    $valores = $rs->num_rows() > 0;
    //$obj['indicador'] = $valores;
    if($valores){
      $datos = $rs->result();
      array_push($obj['tareas_detenidas'], $datos);

      for ($z = 0; $z < sizeof($datos); $z++){
       $idtarea = $datos[$z]->idtarea;
       $this->db->where('idtarea', $idtarea);
       $this->db->where('status', 0);
       $rs = $this->db->get('observacion');
        $result = $rs->num_rows() > 0;
        if($result){
        $obs = $rs->result();
        array_push($obj['observaciones'], $obs);
       }

       }

    }
    }

  }  
   $obj['indicador'] = sizeof($obj['tareas_detenidas']) > 0;
  return $obj;
  }

  public function get_cotizacion_servicio_cc($idcita){
    $this->db->select("cs.*, cc.*");
    $this->db->from('cotizacion_servicio AS cs');
    $this->db->join( "cita_cotizacion AS cc",
        "cs.idcotizacion = cc.idcotizacion" );
    $this->db->where( "cc.idcita", $idcita );
    $rs = $this->db->get();
    $obj['resultado'] = $rs->num_rows() > 0;
    $obj['cotizacion'] = $rs->result();


    return $obj;  
  }

  public function analisis_realizada_cc($idcita, $idorden){
    $this->db->select(" o.*, o.status as status_ob");
    $this->db->from('tarea AS t');
    $this->db->join( "observacion AS o",
        "t.idtarea = o.idtarea");
    $this->db->where( "t.idcita", $idcita );
    $this->db->where( "t.idorden", $idorden );
    $this->db->where( "o.status", 0);
    $rs = $this->db->get();
    $obj['tareas'] = $rs->result();
    $val = $obj['tareas'];
     for ($x = 0; $x < sizeof($val); $x++){
       $idobservacion = $val[$x]->idobservacion;
       $this->db->set("status", 1);
       $this->db->where("idobservacion", $idobservacion);
       $this->db->update("observacion");
       $obj['resultado'] = $this->db->affected_rows()>0; 
     }

    return $obj; 
  }

  public function get_orden_proximas_meca_cc($usuario){
    //PRUEBA DTAI
 /*   $this->db->select("t.*"); //, cu.usuario as asesor, count(t.idtarea) as cantidad, concat(a.nombre, ' ', a.appaterno, ' ', a.apmaterno) as nombre_asesor
    $this->db->from('tarea AS t');
    $this->db->distinct("t.idcita");
    $this->db->join( "orden AS o",
        "o.idorden = t.idorden" );
    $this->db->join( "cita AS c",
        "c.idorden = o.idorden" );
    $this->db->join( "cita_usuario AS cu",
        "cu.idcita = c.idcita" );
    $this->db->join( "usuario AS u",
        "u.usuario = cu.usuario" );
    $this->db->join( "asesor AS a",
        "a.usuario = u.usuario" );
    $this->db->where( "t.usuario", $usuario );
    $this->db->where( "o.status", 'En proceso' );
    $this->db->group_start();
    $this->db->where( "t.status", 0);
    $this->db->or_where( "t.status", 2);
    $this->db->or_where( "t.status", 3);
    $this->db->group_end();
    //$this->db->order_by('t.fechahora');
   // $this->db->group_by('t.idcita');
    $rs=$this->db->get();
    $obj["resultado"] = $rs->num_rows() > 0;
  if($obj["resultado"]){
    $obj['orden'] = $rs->result(); 

  }else{
    $obj['mensaje'] = 'No hay ordenes de trabajo asignados';
  }*/
   $this->db->select("t.*");
    $this->db->from('tarea AS t');
    $this->db->distinct("t.idcita");
    $this->db->join( "orden AS o",
        "o.idorden = t.idorden" );
    $this->db->join( "cita AS c",
        "c.idorden = o.idorden" );
    $this->db->join( "cita_usuario AS cu",
        "cu.idcita = c.idcita" );
    $this->db->join( "usuario AS u",
        "u.usuario = cu.usuario" );
    $this->db->join( "asesor AS a",
        "a.usuario = u.usuario" );
    $this->db->where( "t.usuario", $usuario );
    $this->db->where( "o.status", 'En proceso' );
    $this->db->group_start();
    $this->db->where( "t.status", 0);
    $this->db->or_where( "t.status", 2);
    $this->db->or_where( "t.status", 3);
    $this->db->group_end();
    //$this->db->order_by('t.fechahora');
   // $this->db->group_by('t.idcita');
    $rs=$this->db->get();
    $obj["resultado"] = $rs->num_rows() > 0;
  if($obj["resultado"]){
    $ordenes = $rs->result();
    $idorden = 0;
    $contador =0;
    $obj['orden'] = array();
    for ($i=0; $i < sizeof($ordenes); $i++) { 
     if($ordenes[$i]->idorden != $idorden){

   // $obj['orden'] = array( $ordenes[$i]); 
    array_push($obj['orden'], $ordenes[$i]);
    $idcita = $obj['orden'][$contador]->idcita;

    $this->db->select("u.usuario as asesor, concat(a.nombre, ' ', a.appaterno, ' ', a.apmaterno) as nombre_asesor");
    $this->db->from('cita_usuario AS cu');
    $this->db->join( "usuario AS u",
        "cu.usuario = u.usuario" );
    $this->db->join( "asesor AS a",
        "u.usuario = a.usuario" );
    $this->db->where('cu.idcita', $idcita);
    $rs=$this->db->get();
    $asesor = $rs->result();
    $obj['orden'][$contador]->asesor = $asesor[0]->asesor;
    $obj['orden'][$contador]->nombre_asesor = $asesor[0]->nombre_asesor;
    
    $cantidad_citas = 0;
    $idorden_citas = $ordenes[$i]->idorden;
    for ($x=0; $x < sizeof($ordenes); $x++) {
    if($idorden_citas == $ordenes[$x]->idorden){
       $cantidad_citas ++; 
    } 
    }
    $obj['orden'][$contador]->cantidad = $cantidad_citas; 

    $contador++;
     }
     $idorden = $ordenes[$i]->idorden; 
    }
   

  }else{
    $obj['mensaje'] = 'No hay ordenes de trabajo asignados';
  }

  return $obj;  
  }


   public function get_info_tareas_meca_cc($idorden, $idcita, $detenido, $usuario){
    $this->db->select("c.fechacita, concat(cl.nombre, ' ', cl.appaterno, ' ', cl.apmaterno) as cliente, cl.correo, cl.telefono, d.vin, m.nombremodelo, v.nombreversion");
    $this->db->from('cita AS c');
    $this->db->join( "diagnostico AS d",
        "d.iddiagnostico = c.iddiagnostico" );
    $this->db->join( "auto AS a",
        "a.idauto = c.idauto" );
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );
    $this->db->join( "modelo AS m",
        "m.idmodelo = a.idmodelo" );
    $this->db->join( "version AS v",
        "v.idversion = a.idversion" );
    $this->db->where( "c.idcita", $idcita );
    $rs = $this->db->get();
    $obj['datos'] = $rs->result();

    $this->db->where('idorden', $idorden);
    $this->db->where('usuario', $usuario);
    $rs = $this->db->get('tarea');
    $obj['tareas'] = $rs->result();
    $val = $obj['tareas'];
    $obj['observaciones'] = array();
    for ($z = 0; $z < sizeof($val); $z++){
       $idtarea = $val[$z]->idtarea;
       $this->db->where('idtarea', $idtarea);
       $this->db->where('status', 0);
       $rs = $this->db->get('observacion');
       $result = $rs->num_rows() > 0;
        if($result){
        $obs = $rs->result();
        array_push($obj['observaciones'], $obs);
       }

       }
    $obj['resultado'] = sizeof($obj['observaciones']) > 0;

 /*if($detenido == 1){
    $this->db->select("o.*, t.*");
    $this->db->from('tarea AS t');
    $this->db->join( "observacion AS o",
        "t.idtarea = o.idtarea" );
    $this->db->where( "t.idorden", $idorden );
    $this->db->where( "t.idcita", $idcita );
    $this->db->where( "t.status", 3 );
    $this->db->where( "o.status", 0 );
    $rs = $this->db->get();
    $obj['resultado'] = $rs->num_rows() > 0;
    $obj['tareas_detenidas'] = $rs->result();
  }*/

    return $obj; 
  }


  public function get_observacion_cc($idtarea){
       $this->db->where('idtarea', $idtarea);
       $this->db->where('status', 0);
       $rs = $this->db->get('observacion');
        $obj['resultado'] = $rs->num_rows() > 0;
         $obj['observaciones'] = $rs->result();
    return $obj; 
  }

   public function insert_observacion_cc($idtarea, $array_concepto){
    date_default_timezone_set('UTC');
    date_default_timezone_set("America/Mexico_City");
    $hoy = date( "Y-m-d  H:i:s" ); 
    $this->db->where("idtarea", $idtarea);
    $this->db->where("status", 0);
    $this->db->delete("observacion");
    
    for($a = 0; $a < sizeof($array_concepto); $a++){
     $data = array('idtarea' => $idtarea, 'observacion' => $array_concepto[$a], 'fecha' => $hoy, 'status' => 0);
     $this->db->insert('observacion', $data);
     $obj["resultado"] = $this->db->affected_rows()>0;
     $obj["mensaje"] = $obj["resultado"] ? "Se realizo la petición" : "Imposible realizar petición";
    } 

    return $obj;
  }

  public function get_ordenes_finalizadas_cc($usuario){
    $this->db->select(" o.*, t.tarea, t.status, o.status as status_ob, t.usuario");
    $this->db->from('tarea AS t');
    $this->db->join( "orden AS o",
        "t.idorden = o.idorden");
    $this->db->join( "cita AS c",
        "c.idorden = o.idorden");
    $this->db->join( "cita_usuario AS cu",
        "cu.idcita = c.idcita");
    $this->db->where( "cu.usuario", $usuario );
    $this->db->where( "o.status", 'En proceso');
    $rs = $this->db->get();
    $obj['tareas_finalizadas'] = $rs->result();

    /*$this->db->select("count(t.idtarea) as cantidad, o.idorden, c.idcita");
    $this->db->from('tarea AS t');
    $this->db->join( "orden AS o",
        "t.idorden = o.idorden");
    $this->db->join( "cita AS c",
        "c.idorden = o.idorden");
    $this->db->join( "cita_usuario AS cu",
        "cu.idcita = c.idcita");
    $this->db->where( "cu.usuario", $usuario );
    $this->db->where( "cu.usuario !=", null );
    $this->db->where( "o.status", 'En proceso');
    $this->db->group_by('o.idorden');*/
    //PRUEBA DE ERROR DE CONSULTA SERVIDOR DTAI
    $this->db->select("count(*) as cantidad, o.idorden, ANY_VALUE(c.idcita) as idcita");
    $this->db->from('orden AS o');
    $this->db->join( "tarea AS t",
        "t.idorden = o.idorden");
    $this->db->join( "cita AS c",
        "c.idorden = o.idorden");
    $this->db->join( "cita_usuario AS cu",
        "cu.idcita = c.idcita");
    $this->db->where( "cu.usuario", $usuario );
    $this->db->where( "cu.usuario !=", null );
    $this->db->where( "o.status", 'En proceso');
    $this->db->group_by('o.idorden');
    $rs = $this->db->get();
    $obj['contador'] = $rs->result();

    return $obj;
  }

  public function enviar_orden_hp_cc($idorden, $usuario, $personalhp, $idcita){
  $this->db->set("status", 'Final');
  $this->db->where("idorden", $idorden);
  $this->db->update("orden");
  $obj["resultado"] = $this->db->affected_rows()>0;
  $obj["mensaje"] = "Cambio de status";

  //Insertar en cita_usuario, los empleados que atienden cita / orden
    $data = array ('idcita'=>$idcita, 'usuario'=>$personalhp);
    $this->db->insert('cita_usuario', $data);


   $this->db->select(" o.*, t.tarea, t.status, o.status as status_ob, t.usuario");
    $this->db->from('tarea AS t');
    $this->db->join( "orden AS o",
        "t.idorden = o.idorden");
    $this->db->join( "cita AS c",
        "c.idorden = o.idorden");
    $this->db->join( "cita_usuario AS cu",
        "cu.idcita = c.idcita");
    $this->db->where( "cu.usuario", $usuario );
    $this->db->where( "o.status", 'En proceso');
    $rs = $this->db->get();
    $obj['tareas_finalizadas'] = $rs->result();

    $this->db->select("count(*) as cantidad, o.idorden, ANY_VALUE(c.idcita) as idcita");
    $this->db->from('tarea AS t');
    $this->db->join( "orden AS o",
        "t.idorden = o.idorden");
    $this->db->join( "cita AS c",
        "c.idorden = o.idorden");
    $this->db->join( "cita_usuario AS cu",
        "cu.idcita = c.idcita");
    $this->db->where( "cu.usuario", $usuario );
    $this->db->where( "cu.usuario !=", null );
    $this->db->where( "o.status", 'En proceso');
    $this->db->group_by('o.idorden');
    $rs = $this->db->get();
    $obj['contador'] = $rs->result();


  return $obj;
  }

    public function get_personalhp_cc(){
    $this->db->select("u.usuario, concat(hp.nombre, ' ', hp.appaterno, ' ', hp.apmaterno) as personalhp");
    $this->db->from('usuario AS u');
    $this->db->join( "personalhp AS hp",
        "u.usuario = hp.usuario" );
    $this->db->where('u.status', 1);
    $rs=$this->db->get();
    return $rs->result();  
  }

  public function get_personallavado_cc(){
    $this->db->select("u.usuario, concat(pl.nombre, ' ', pl.appaterno, ' ', pl.apmaterno) as personallavado");
    $this->db->from('usuario AS u');
    $this->db->join( "personallavado AS pl",
        "u.usuario = pl.usuario" );
    $this->db->where('u.status', 1);
    $rs=$this->db->get();
    return $rs->result();  
  }

  public function get_ordenes_hp_cc($usuario){
    /*$this->db->select("count(t.idtarea) as cantidad, o.idorden, c.idcita, concat(cl.nombre, ' ', cl.appaterno, ' ', cl.apmaterno) as cliente, d.vin, m.nombremodelo, v.nombreversion");
    $this->db->from('tarea AS t');
    $this->db->join( "orden AS o",
        "t.idorden = o.idorden");
    $this->db->join( "cita AS c",
        "c.idorden = o.idorden");
    $this->db->join( "cita_usuario AS cu",
        "cu.idcita = c.idcita");

    $this->db->join( "diagnostico AS d",
        "d.iddiagnostico = c.iddiagnostico" );
    $this->db->join( "auto AS a",
        "a.idauto = c.idauto" );
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );
    $this->db->join( "modelo AS m",
        "m.idmodelo = a.idmodelo" );
    $this->db->join( "version AS v",
        "v.idversion = a.idversion" );

    $this->db->where( "cu.usuario", $usuario );
    $this->db->where( "o.status", 'Final');
    $this->db->group_by('o.idorden');
    $rs = $this->db->get();
    $obj['contador'] = $rs->result();
    $obj['resultado'] = sizeof($obj['contador']) > 0;*/
    $this->db->select("idorden, idtarea, idcita, tarea");
    $this->db->where('usuario', null);
    $rs = $this->db->get('tarea');
    $obj['tareas'] = $rs->result();

//Prueba
    $this->db->select("t.*");
    $this->db->from('tarea AS t');
    $this->db->join( "orden AS o",
        "t.idorden = o.idorden");
    $this->db->join( "cita AS c",
        "c.idorden = o.idorden");
    $this->db->join( "cita_usuario AS cu",
        "cu.idcita = c.idcita");

    $this->db->join( "diagnostico AS d",
        "d.iddiagnostico = c.iddiagnostico" );
    $this->db->join( "auto AS a",
        "a.idauto = c.idauto" );
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );
    $this->db->join( "modelo AS m",
        "m.idmodelo = a.idmodelo" );
    $this->db->join( "version AS v",
        "v.idversion = a.idversion" );

    $this->db->where( "cu.usuario", $usuario );
    $this->db->where( "o.status", 'Final');

    $rs=$this->db->get();
    $obj["resultado"] = $rs->num_rows() > 0;
  if($obj["resultado"]){
    $ordenes = $rs->result();
    $idorden = 0;
    $contador =0;
    $obj['contador'] = array();
    for ($i=0; $i < sizeof($ordenes); $i++) { 
     if($ordenes[$i]->idorden != $idorden){
 
    array_push($obj['contador'], $ordenes[$i]);
    $idcita = $obj['contador'][$contador]->idcita;
   

    $this->db->select("c.idcita, concat(cl.nombre, ' ', cl.appaterno, ' ', cl.apmaterno) as cliente, d.vin, m.nombremodelo, v.nombreversion, d.vin");
    $this->db->from('cita AS c');
    $this->db->join( "cita_usuario AS cu",
        "cu.idcita = c.idcita");

    $this->db->join( "diagnostico AS d",
        "d.iddiagnostico = c.iddiagnostico" );
    $this->db->join( "auto AS a",
        "a.idauto = c.idauto" );
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );
    $this->db->join( "modelo AS m",
        "m.idmodelo = a.idmodelo" );
    $this->db->join( "version AS v",
        "v.idversion = a.idversion" );

    $this->db->where( "c.idcita", $idcita );

    $rs=$this->db->get();
    $clie_aut = $rs->result();
    $obj['contador'][$contador]->cliente = $clie_aut[0]->cliente;
    $obj['contador'][$contador]->nombremodelo = $clie_aut[0]->nombremodelo;
    $obj['contador'][$contador]->nombreversion = $clie_aut[0]->nombreversion;
    $obj['contador'][$contador]->vin = $clie_aut[0]->vin;
    
    $cantidad_citas = 0;
    $idorden_citas = $ordenes[$i]->idorden;
    for ($x=0; $x < sizeof($ordenes); $x++) {
    if($idorden_citas == $ordenes[$x]->idorden){
       $cantidad_citas ++; 
    } 
    }
    $obj['contador'][$contador]->cantidad = $cantidad_citas; 

    $contador++;
     }
     $idorden = $ordenes[$i]->idorden; 
    }
   

  }else{
    $obj['mensaje'] = 'No hay ordenes de trabajo asignados';
  }

    return $obj;
  }

  public function iniciar_reparacion_hp_cc($idorden, $usuario, $idcita){
    $this->db->set("status", 'Hp');
    $this->db->where("idorden", $idorden);
    $this->db->update("orden");

    $afecta = $this->db->affected_rows() > 0;
    if($afecta){
     $this->db->set("status", 2);
     $this->db->where("idorden", $idorden);
     $this->db->where("usuario", null);
     $this->db->update("tarea");
     $obj['resultado'] = $this->db->affected_rows() > 0;      
    }
    //CODIGO ERROR DTAI
    /*$this->db->select("count(t.idtarea) as cantidad, o.idorden, c.idcita, concat(cl.nombre, ' ', cl.appaterno, ' ', cl.apmaterno) as cliente, d.vin, m.nombremodelo, v.nombreversion");
    $this->db->from('tarea AS t');
    $this->db->join( "orden AS o",
        "t.idorden = o.idorden");
    $this->db->join( "cita AS c",
        "c.idorden = o.idorden");
    $this->db->join( "cita_usuario AS cu",
        "cu.idcita = c.idcita");

    $this->db->join( "diagnostico AS d",
        "d.iddiagnostico = c.iddiagnostico" );
    $this->db->join( "auto AS a",
        "a.idauto = c.idauto" );
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );
    $this->db->join( "modelo AS m",
        "m.idmodelo = a.idmodelo" );
    $this->db->join( "version AS v",
        "v.idversion = a.idversion" );

    $this->db->where( "cu.usuario", $usuario );
    $this->db->where( "o.status", 'Hp');
    $this->db->group_by('o.idorden');
    $rs = $this->db->get();
    $obj['contador'] = $rs->result();
    $obj['hay'] = sizeof($obj['contador']) > 0;*/
    //Prueba
    $this->db->select("t.*");
    $this->db->from('tarea AS t');
    $this->db->join( "orden AS o",
        "t.idorden = o.idorden");
    $this->db->join( "cita AS c",
        "c.idorden = o.idorden");
    $this->db->join( "cita_usuario AS cu",
        "cu.idcita = c.idcita");

    $this->db->join( "diagnostico AS d",
        "d.iddiagnostico = c.iddiagnostico" );
    $this->db->join( "auto AS a",
        "a.idauto = c.idauto" );
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );
    $this->db->join( "modelo AS m",
        "m.idmodelo = a.idmodelo" );
    $this->db->join( "version AS v",
        "v.idversion = a.idversion" );

    $this->db->where( "cu.usuario", $usuario );
    $this->db->where( "o.status", 'Hp');

    $rs=$this->db->get();
    $obj["resultado"] = $rs->num_rows() > 0;
  if($obj["resultado"]){
    $ordenes = $rs->result();
    $idorden = 0;
    $contador =0;
    $obj['contador'] = array();
    for ($i=0; $i < sizeof($ordenes); $i++) { 
     if($ordenes[$i]->idorden != $idorden){
 
    array_push($obj['contador'], $ordenes[$i]);
    $idcita = $obj['contador'][$contador]->idcita;
   

    $this->db->select("c.idcita, concat(cl.nombre, ' ', cl.appaterno, ' ', cl.apmaterno) as cliente, d.vin, m.nombremodelo, v.nombreversion, d.vin");
    $this->db->from('cita AS c');
    $this->db->join( "cita_usuario AS cu",
        "cu.idcita = c.idcita");

    $this->db->join( "diagnostico AS d",
        "d.iddiagnostico = c.iddiagnostico" );
    $this->db->join( "auto AS a",
        "a.idauto = c.idauto" );
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );
    $this->db->join( "modelo AS m",
        "m.idmodelo = a.idmodelo" );
    $this->db->join( "version AS v",
        "v.idversion = a.idversion" );

    $this->db->where( "c.idcita", $idcita );

    $rs=$this->db->get();
    $clie_aut = $rs->result();
    $obj['contador'][$contador]->cliente = $clie_aut[0]->cliente;
    $obj['contador'][$contador]->nombremodelo = $clie_aut[0]->nombremodelo;
    $obj['contador'][$contador]->nombreversion = $clie_aut[0]->nombreversion;
    $obj['contador'][$contador]->vin = $clie_aut[0]->vin;
    
    $cantidad_citas = 0;
    $idorden_citas = $ordenes[$i]->idorden;
    for ($x=0; $x < sizeof($ordenes); $x++) {
    if($idorden_citas == $ordenes[$x]->idorden){
       $cantidad_citas ++; 
    } 
    }
    $obj['contador'][$contador]->cantidad = $cantidad_citas; 

    $contador++;
     }
     $idorden = $ordenes[$i]->idorden; 
    }
   

  }else{
    $obj['mensaje'] = 'No hay ordenes de trabajo asignados';
  }
  $obj['hay'] = sizeof($obj['contador']) > 0;

     return $obj;
  }

  public function get_ordenes_proceso_hp_cc($usuario){
    //CODIGO ERROR DTAI
   /*$this->db->select("count(t.idtarea) as cantidad, o.idorden, c.idcita, concat(cl.nombre, ' ', cl.appaterno, ' ', cl.apmaterno) as cliente, d.vin, m.nombremodelo, v.nombreversion");
    $this->db->from('tarea AS t');
    $this->db->join( "orden AS o",
        "t.idorden = o.idorden");
    $this->db->join( "cita AS c",
        "c.idorden = o.idorden");
    $this->db->join( "cita_usuario AS cu",
        "cu.idcita = c.idcita");

    $this->db->join( "diagnostico AS d",
        "d.iddiagnostico = c.iddiagnostico" );
    $this->db->join( "auto AS a",
        "a.idauto = c.idauto" );
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );
    $this->db->join( "modelo AS m",
        "m.idmodelo = a.idmodelo" );
    $this->db->join( "version AS v",
        "v.idversion = a.idversion" );

    $this->db->where( "cu.usuario", $usuario );
    $this->db->where( "o.status", 'Hp');
    $this->db->group_by('o.idorden');
    $rs = $this->db->get();
    $obj['contador'] = $rs->result();
    $obj['resultado'] = sizeof($obj['contador']) > 0;*/
    /*$this->db->select("idorden, idtarea, idcita, tarea");
    $this->db->where('usuario', null);
    $rs = $this->db->get('tarea');
    $obj['tareas'] = $rs->result();*/
    //Prueba
    $this->db->select("t.*");
    $this->db->from('tarea AS t');
    $this->db->join( "orden AS o",
        "t.idorden = o.idorden");
    $this->db->join( "cita AS c",
        "c.idorden = o.idorden");
    $this->db->join( "cita_usuario AS cu",
        "cu.idcita = c.idcita");

    $this->db->join( "diagnostico AS d",
        "d.iddiagnostico = c.iddiagnostico" );
    $this->db->join( "auto AS a",
        "a.idauto = c.idauto" );
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );
    $this->db->join( "modelo AS m",
        "m.idmodelo = a.idmodelo" );
    $this->db->join( "version AS v",
        "v.idversion = a.idversion" );

    $this->db->where( "cu.usuario", $usuario );
    $this->db->where( "o.status", 'Hp');

    $rs=$this->db->get();
    $obj["resultado"] = $rs->num_rows() > 0;
  if($obj["resultado"]){
    $ordenes = $rs->result();
    $idorden = 0;
    $contador =0;
    $obj['contador'] = array();
    for ($i=0; $i < sizeof($ordenes); $i++) { 
     if($ordenes[$i]->idorden != $idorden){
 
    array_push($obj['contador'], $ordenes[$i]);
    $idcita = $obj['contador'][$contador]->idcita;
   

    $this->db->select("c.idcita, concat(cl.nombre, ' ', cl.appaterno, ' ', cl.apmaterno) as cliente, d.vin, m.nombremodelo, v.nombreversion, d.vin");
    $this->db->from('cita AS c');
    $this->db->join( "cita_usuario AS cu",
        "cu.idcita = c.idcita");

    $this->db->join( "diagnostico AS d",
        "d.iddiagnostico = c.iddiagnostico" );
    $this->db->join( "auto AS a",
        "a.idauto = c.idauto" );
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );
    $this->db->join( "modelo AS m",
        "m.idmodelo = a.idmodelo" );
    $this->db->join( "version AS v",
        "v.idversion = a.idversion" );

    $this->db->where( "c.idcita", $idcita );

    $rs=$this->db->get();
    $clie_aut = $rs->result();
    $obj['contador'][$contador]->cliente = $clie_aut[0]->cliente;
    $obj['contador'][$contador]->nombremodelo = $clie_aut[0]->nombremodelo;
    $obj['contador'][$contador]->nombreversion = $clie_aut[0]->nombreversion;
    $obj['contador'][$contador]->vin = $clie_aut[0]->vin;
    
    $cantidad_citas = 0;
    $idorden_citas = $ordenes[$i]->idorden;
    for ($x=0; $x < sizeof($ordenes); $x++) {
    if($idorden_citas == $ordenes[$x]->idorden){
       $cantidad_citas ++; 
    } 
    }
    $obj['contador'][$contador]->cantidad = $cantidad_citas; 

    $contador++;
     }
     $idorden = $ordenes[$i]->idorden; 
    }
   

  }else{
    $obj['mensaje'] = 'No hay ordenes de trabajo asignados';
  }

    return $obj; 
  }

  public function get_info_orden_hp_cc($idorden, $idcita){
    $this->db->select("c.fechacita, concat(cl.nombre, ' ', cl.appaterno, ' ', cl.apmaterno) as cliente, cl.correo, cl.telefono, d.vin, m.nombremodelo, v.nombreversion");
    $this->db->from('cita AS c');
    $this->db->join( "diagnostico AS d",
        "d.iddiagnostico = c.iddiagnostico" );
    $this->db->join( "auto AS a",
        "a.idauto = c.idauto" );
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente" );
    $this->db->join( "modelo AS m",
        "m.idmodelo = a.idmodelo" );
    $this->db->join( "version AS v",
        "v.idversion = a.idversion" );
    $this->db->where( "c.idcita", $idcita );
    $rs = $this->db->get();
    $obj['datos'] = $rs->result();

    return $obj;
  }

  public function update_status_lavado_cc($idorden, $usuario, $idcita){
    $this->db->set('status', 'Lavado');
    $this->db->where('idorden', $idorden);
    $this->db->update('orden');
    $obj["resultado"] = $this->db->affected_rows()>0;

    //Insertar en cita_usuario, los empleados que atienden cita / orden => personal de lavado
    $data = array ('idcita'=>$idcita, 'usuario'=>$usuario);
    $this->db->insert('cita_usuario', $data);

     $this->db->set("status", 1);
     $this->db->where("idorden", $idorden);
     $this->db->where("usuario", null);
     $this->db->update("tarea");

    return $obj;
  }

   public function get_ordenes_lavado_cc($usuario){
    $this->db->select("o.idorden, c.idcita, d.vin, m.nombremodelo, v.nombreversion, o.status");
    $this->db->from('orden AS o');
    $this->db->join( "cita AS c",
        "c.idorden = o.idorden");
    $this->db->join( "cita_usuario AS cu",
        "cu.idcita = c.idcita");
    $this->db->join( "diagnostico AS d",
        "d.iddiagnostico = c.iddiagnostico" );
    $this->db->join( "auto AS a",
        "a.idauto = c.idauto" );
    $this->db->join( "modelo AS m",
        "m.idmodelo = a.idmodelo" );
    $this->db->join( "version AS v",
        "v.idversion = a.idversion" );
    $this->db->where( "cu.usuario", $usuario );
    $this->db->group_start();
    $this->db->where( "o.status", 'Lavado');
    $this->db->or_where( "o.status", 'Lavado proceso' );
    $this->db->group_end();
 

    $rs = $this->db->get();
    $obj['contador'] = $rs->result();
    $obj['resultado'] = sizeof($obj['contador']) > 0;

    return $obj;
  }

  public function status_lavando_auto_cc($idorden, $idcita){
    $this->db->set('status', 'Lavado proceso');
    $this->db->where('idorden', $idorden);
    $this->db->update('orden');
    $obj["resultado"] = $this->db->affected_rows()>0;
    return $obj;
  }

  public function status_finalizar_lavado_auto_cc($idorden, $idcita){
    $this->db->set('status', 'Finalizado');
    $this->db->where('idorden', $idorden);
    $this->db->update('orden');
    $obj["resultado"] = $this->db->affected_rows()>0;
    return $obj;
  }

    public function get_orden_listos_entrega_cc($usuario){

     $this->db->select("o.idorden, c.idcita, d.vin, m.nombremodelo, v.nombreversion, o.status, concat(cl.nombre, ' ', cl.appaterno, ' ', cl.apmaterno) as cliente, cl.telefono, cl.correo, o.fechatermino");
    $this->db->from('orden AS o');
    $this->db->join( "cita AS c",
        "c.idorden = o.idorden");
    $this->db->join( "cliente AS cl",
        "cl.idcliente = c.idcliente");
    $this->db->join( "cita_usuario AS cu",
        "cu.idcita = c.idcita");
    $this->db->join( "diagnostico AS d",
        "d.iddiagnostico = c.iddiagnostico" );
    $this->db->join( "auto AS a",
        "a.idauto = c.idauto" );
    $this->db->join( "modelo AS m",
        "m.idmodelo = a.idmodelo" );
    $this->db->join( "version AS v",
        "v.idversion = a.idversion" );

    /*$this->db->join( "cotizacion_servicio AS cs",
        "cs.idcotizacion = co.idcotizacion");*/
    $this->db->where( "cu.usuario", $usuario );
    $this->db->where( "o.status", 'Finalizado');

    $rs = $this->db->get();
    $obj['orden'] = $rs->result();
    $obj['resultado'] = sizeof($obj['orden']) > 0;
    
    $val=$obj['orden'];
    
    $obj['costo'] = array();
    for ($x = 0; $x < sizeof($val); $x++){
    $idcita = $val[$x]->idcita;
    $this->db->select('idcita, sum(costo) as total');
    $this->db->where('idcita', $idcita);
    $rs = $this->db->get('cita_cotizacion');
    $datos = $rs->result();
    $datos_final = $datos[0];
    array_push($obj['costo'], $datos_final);
    }

    return $obj;
  }

  public function entregar_auto_cc($idorden, $idcita){
    $this->db->set('status', 'Entregado');
    $this->db->where('idorden', $idorden);
    $this->db->update('orden');
    $obj["resultado"] = $this->db->affected_rows()>0;

    if($obj['resultado']){
      $this->db->set('status', 'Finalizada');
      $this->db->where('idcita', $idcita);
      $this->db->update('cita');
    }
    return $obj;
  }

  public function get_usuarios_cc(){
    $this->db->select("r.*, u.nivel, u.status");
    $this->db->from('usuario AS u');
    $this->db->join( "recepcionista AS r",
        "r.usuario = u.usuario" );
    $rs = $this->db->get();
    $obj['usuarios'] = $rs->result();
    
    $this->db->select("a.*, u.nivel, u.status");
    $this->db->from('usuario AS u');
    $this->db->join( "asesor AS a",
        "a.usuario = u.usuario" );
    $rs = $this->db->get();
    $datos = $rs->result();
    for ($i=0; $i < sizeof($datos); $i++) { 
    array_push($obj['usuarios'], $datos[$i]);  
    }

    $this->db->select("m.*, u.nivel, u.status");
    $this->db->from('usuario AS u');
    $this->db->join( "mecanico AS m",
        "m.usuario = u.usuario" );
    $rs = $this->db->get();
    $datos = $rs->result();
    for ($i=0; $i < sizeof($datos); $i++) { 
    array_push($obj['usuarios'], $datos[$i]);  
    }

    $this->db->select("hp.*, u.nivel, u.status");
    $this->db->from('usuario AS u');
    $this->db->join( "personalhp AS hp",
        "hp.usuario = u.usuario" );
    $rs = $this->db->get();
    $datos = $rs->result();
    for ($i=0; $i < sizeof($datos); $i++) { 
    array_push($obj['usuarios'], $datos[$i]);  
    }

    $this->db->select("pl.*, u.nivel, u.status");
    $this->db->from('usuario AS u');
    $this->db->join( "personallavado AS pl",
        "pl.usuario = u.usuario" );
    $rs = $this->db->get();
    $datos = $rs->result();
    for ($i=0; $i < sizeof($datos); $i++) { 
    array_push($obj['usuarios'], $datos[$i]);  
    }
    $obj['resultado'] = sizeof($obj['usuarios']) > 0;
    return $obj;
  }

  public function insert_update_usuario_cc($accion, $nombre, $appaterno, $apmaterno, $fecha, $usuario, $nivel, $contrasena){
    $data = array('nombre' => $nombre, 'appaterno' => $appaterno, 'apmaterno' => $apmaterno, 'fechanacimiento' => $fecha, 'usuario' => $usuario);
    $table = '';
    if($nivel == 1){
      $table = 'recepcionista';
    }
    if($nivel == 2){
      $table = 'asesor';
    }
    if($nivel == 3){
      $table = 'mecanico';
    }
    if($nivel == 4){
      $table = 'personalhp';
    }
    if($nivel == 5){
      $table = 'personallavado';
    }

    if($accion == 1){
    $this->db->set($data);
    $this->db->where('usuario', $usuario);
    $this->db->update($table);
    $obj['resultado'] = TRUE;

    if(strlen($contrasena) > 0){ //OBTENER LA DIMENSION DE LA CONTRASENA
     $this->db->set('contrasena', $contrasena);
     $this->db->where('usuario', $usuario);
     $this->db->update('usuario');
    }
    }else if($accion == 2){
    $data_usuario = array('usuario' => $usuario, 'contrasena' => $contrasena, 'nivel' => $nivel, 'status' => 1);
    $this->db->insert('usuario', $data_usuario);
    if($this->db->affected_rows() > 0){
      $this->db->insert($table ,$data);
     $obj['resultado'] = $this->db->affected_rows() > 0;
    }
    }
  return $obj;
  }

  public function baja_usuario_cc($usuario, $nivel){
   $this->db->set('status', 0);
    $this->db->where('usuario', $usuario);
    $this->db->update('usuario');
    $obj['resultado'] = $this->db->affected_rows() > 0;
     if($nivel == 1){
    $this->db->select("r.*, u.nivel, u.status");
    $this->db->from('usuario AS u');
    $this->db->join( "recepcionista AS r",
        "r.usuario = u.usuario" );
    $this->db->where('r.usuario', $usuario);
    $rs = $this->db->get();
    $obj['usuarios'] = $rs->result();

     }else if($nivel == 2){
    $this->db->select("a.*, u.nivel, u.status");
    $this->db->from('usuario AS u');
    $this->db->join( "asesor AS a",
        "a.usuario = u.usuario" );
    $this->db->where('a.usuario', $usuario);
    $rs = $this->db->get(); 
    $obj['usuarios'] = $rs->result();

     }else if($nivel == 3){
    $this->db->select("m.*, u.nivel, u.status");
    $this->db->from('usuario AS u');
    $this->db->join( "mecanico AS m",
        "m.usuario = u.usuario" );
    $this->db->where('m.usuario', $usuario);
    $rs = $this->db->get();
    $obj['usuarios'] = $rs->result();

     }else if($nivel == 4){
    $this->db->select("hp.*, u.nivel, u.status");
    $this->db->from('usuario AS u');
    $this->db->join( "personalhp AS hp",
        "hp.usuario = u.usuario" );
    $this->db->where('hp.usuario', $usuario);
    $rs = $this->db->get();
    $obj['usuarios'] = $rs->result();

     }else if($nivel == 5){
    $this->db->select("pl.*, u.nivel, u.status");
    $this->db->from('usuario AS u');
    $this->db->join( "personallavado AS pl",
        "pl.usuario = u.usuario" );
    $this->db->where('pl.usuario', $usuario);
    $rs = $this->db->get();
    $obj['usuarios'] = $rs->result();
     }
     
    return $obj;
  }

  public function alta_usuario_cc($usuario, $nivel){
   $this->db->set('status', 1);
    $this->db->where('usuario', $usuario);
    $this->db->update('usuario');
    $obj['resultado'] = $this->db->affected_rows() > 0;
     if($nivel == 1){
    $this->db->select("r.*, u.nivel, u.status");
    $this->db->from('usuario AS u');
    $this->db->join( "recepcionista AS r",
        "r.usuario = u.usuario" );
    $this->db->where('r.usuario', $usuario);
    $rs = $this->db->get();
    $obj['usuarios'] = $rs->result();

     }else if($nivel == 2){
    $this->db->select("a.*, u.nivel, u.status");
    $this->db->from('usuario AS u');
    $this->db->join( "asesor AS a",
        "a.usuario = u.usuario" );
    $this->db->where('a.usuario', $usuario);
    $rs = $this->db->get(); 
    $obj['usuarios'] = $rs->result();

     }else if($nivel == 3){
    $this->db->select("m.*, u.nivel, u.status");
    $this->db->from('usuario AS u');
    $this->db->join( "mecanico AS m",
        "m.usuario = u.usuario" );
    $this->db->where('m.usuario', $usuario);
    $rs = $this->db->get();
    $obj['usuarios'] = $rs->result();

     }else if($nivel == 4){
    $this->db->select("hp.*, u.nivel, u.status");
    $this->db->from('usuario AS u');
    $this->db->join( "personalhp AS hp",
        "hp.usuario = u.usuario" );
    $this->db->where('hp.usuario', $usuario);
    $rs = $this->db->get();
    $obj['usuarios'] = $rs->result();

     }else if($nivel == 5){
    $this->db->select("pl.*, u.nivel, u.status");
    $this->db->from('usuario AS u');
    $this->db->join( "personallavado AS pl",
        "pl.usuario = u.usuario" );
    $this->db->where('pl.usuario', $usuario);
    $rs = $this->db->get();
    $obj['usuarios'] = $rs->result();
     }
     
    return $obj;
  }

  public function get_autos_cc(){
    $this->db->select('c.*, a.*, b.*, m.*, v.*, t.*');
    $this->db->from('auto AS a');
    $this->db->join( "carroceria AS c",
        "c.idcarroceria = a.idcarroceria" );
    $this->db->join( "combustible AS b",
        "b.idcombustible = a.idcombustible" );
    $this->db->join( "modelo AS m",
        "m.idmodelo = a.idmodelo" );
    $this->db->join( "version AS v",
        "v.idversion = a.idversion" );
    $this->db->join( "transmision AS t",
        "t.idtransmision = a.idtransmision" );
    $rs = $this->db->get();
    $obj['auto'] = $rs->result();
    $obj['resultado'] = sizeof($obj['auto']);

    /*$this->db->select("a.*, m.nombremodelo");
    $this->db->from('auto AS a');
    $this->db->join( "modelo AS m",
        "m.idmodelo = u.idmodelo" );
    $rs = $this->db->get();
    $obj['autos'] = $rs->result();*/
    
    return $obj;
  }

  public function get_info_auto_cc(){
   $this->db->select('idcombustible, combustible');
    $rs = $this->db->get('combustible');
    $obj['motor'] = $rs->result();

    $this->db->select('idcarroceria, carroceria');
    $rs = $this->db->get('carroceria');
    $obj['carroceria'] = $rs->result();

    $this->db->select('idtransmision, transmision');
    $rs = $this->db->get('transmision');
    $obj['transmision'] = $rs->result();

    return $obj; 
  }

  public function update_auto_cc($idauto, $combustible, $carroceria, $transmision, $precio, $cilindros, $potencia, $torque, $valvulas, $motor, $color){
    $data = array('precio' => $precio, 'motor' => $motor, 'cilindros' => $cilindros, 'idcombustible' => $combustible, 'potencia' => $potencia, 'torque' => $torque, 'valvulas' => $valvulas, 'idtransmision' => $transmision, 'idcarroceria' => $carroceria, 'color' => $color);
    $this->db->set($data);
    $this->db->where('idauto', $idauto);
    $this->db->update('auto');
    $obj['resultado'] = TRUE;
    return $obj;
  }

  public function get_transmision_cc(){
   $this->db->select('idtransmision, transmision');
    $rs = $this->db->get('transmision');
    return $rs->result(); 
  }

  public function get_versiones_dis_cc(){
    $this->db->select('idversion, idmodelo');
      $rs = $this->db->get('auto');
      $autos = $rs->result(); 

      $this->db->select('idversion');
      $rs = $this->db->get('version');
      $version = $rs->result(); 
      
      $obj['versiones'] = array();
      for ($i=0; $i <sizeof($version) ; $i++) {
        $mat = 0;
        for ($a=0; $a <sizeof($autos) ; $a++) {
        if($version[$i]->idversion != $autos[$a]->idversion){
        $mat ++;
        }
        }
        if($mat == sizeof($autos)){
              $this->db->select('idversion, nombreversion');
              $this->db->where( "idversion", $version[$i]->idversion );
              $rs = $this->db->get("version");
              array_push($obj['versiones'], $rs->result()[0]);
        }
      }
    return $obj;

  }

  public function insert_auto_cc($nombre, $modelo, $version, $combustible, $carroceria, $transmision, $precio, $cilindros, $potencia, $torque, $valvulas, $motor, $color){
    $data = array('idmodelo' => $modelo, 'idversion' => $version, 'precio' => $precio, 'motor' => $motor, 'cilindros' => $cilindros, 'idcombustible' => $combustible, 'potencia' => $potencia, 'torque' => $torque, 'valvulas' => $valvulas, 'idtransmision' => $transmision, 'marca' => '', 'idcarroceria' => $carroceria, 'imagen' => $nombre, 'color' => $color, 'status' => 1);
    $this->db->insert('auto', $data);
    $idauto = $this->db->insert_id();
    //$obj["resultado"]=$this->db->affected_rows()>0;
    //$obj["mensaje"]=$obj["resultado"] ? "Auto registrado exitosamente" : "Imposible registrar";
   
   return $idauto;
  }

  public function cambio_status_auto_cc($idauto, $status){
   $this->db->set('status', $status);
   $this->db->where('idauto', $idauto);
   $this->db->update('auto');
   $obj['resultado'] = $this->db->affected_rows() > 0;

   return $obj;
  }

  public function insert_modelo_cc($modelo){
  $data = array('nombremodelo' => $modelo);
  $this->db->insert('modelo', $data);

  $obj['resultado'] = $this->db->affected_rows() > 0;
  
  return $obj;
  }

  public function insert_version_cc($version){
  $data = array('nombreversion' => $version);
  $this->db->insert('version', $data);

  $obj['resultado'] = $this->db->affected_rows() > 0;
  
  return $obj; 
  }
 
 public function get_status_cc($nombre, $appaterno, $apmaterno, $vin){
   $this->db->select("idcliente, concat(cl.nombre, ' ', cl.appaterno, ' ', cl.apmaterno) as cliente");
    $this->db->from('cliente AS cl');
    $this->db->where('nombre', $nombre);
    $this->db->where('appaterno', $appaterno);
    $this->db->where('apmaterno', $apmaterno);
    $rs = $this->db->get();
    $obj['cliente'] = $rs->result();
    $obj['resultado'] = sizeof($obj['cliente']) > 0;
    $obj['mensaje1'] = $obj['resultado'] ? 'El cliente existe existe en bd' : 'No existe el cliente';
    //Si existe el cliente en la base de datos
    if($obj['resultado']){
      $idcliente =$obj['cliente'][0]->idcliente;
      $obj['idcliente'] = $idcliente;
       $this->db->select('o.idorden, c.idcita, d.iddiagnostico, d.vin, o.fechatermino, c.fechacita, o.status');
       $this->db->from('cita AS c');
       $this->db->join( "diagnostico AS d",
        "d.iddiagnostico = c.iddiagnostico" );
       $this->db->join( "orden AS o",
        "o.idorden = c.idorden");
       $this->db->where('c.idcliente', $idcliente);
       $this->db->where('d.vin', $vin);
       $this->db->group_start();
       $this->db->where('c.status','En servicio');
       $this->db->or_where( "c.status", 'Finalizada' );
       $this->db->group_end();

       $this->db->group_start();
       $this->db->where( "o.status", 'Generada' );
       $this->db->or_where( "o.status", 'Prediagnostico' );
       $this->db->or_where( "o.status", 'Cotizacion' );
       $this->db->or_where( "o.status", 'En proceso' );
       $this->db->or_where( "o.status", 'Final' );
       $this->db->or_where( "o.status", 'Hp' );
       $this->db->or_where( "o.status", 'Lavado' );
       $this->db->or_where( "o.status", 'Lavado proceso' );
       $this->db->or_where( "o.status", 'Finalizado' );
       $this->db->group_end();
       $rs = $this->db->get();
       $obj['cita'] = $rs->result(); 

       $obj['servicio'] = sizeof($obj['cita']) > 0;
       $obj['mensaje2'] = $obj['servicio'] ? 'El auto esta en servicio' : 'El auto no esta en servicio, el el vin es incorrecto';
       if($obj['servicio']){ //Accion en caso de estar en servicio
       $idcita =  $obj['cita'][0]->idcita;
       $idorden =  $obj['cita'][0]->idorden;
        
        //$this->db->select('idversion, idmodelo');
        $this->db->where('idorden', $idorden);
        $rs = $this->db->get('tarea');
        $obj['tareas'] = $rs->result(); 

        $this->db->select("u.usuario, concat(a.nombre, ' ', a.appaterno, ' ', a.apmaterno) as asesor");
        $this->db->from('cita_usuario AS cu');
        $this->db->join( "usuario AS u",
        "cu.usuario = u.usuario");
        $this->db->join( "asesor AS a",
        "a.usuario = u.usuario" );
        $this->db->where('idcita', $idcita);
        $rs = $this->db->get();
        $obj['asesor'] = $rs->result();

       }

    }

    return $obj;
 }

 public function get_estadistica_citas_cc($anio, $mes){
    $this->db->select("c.*, DAY(fechacita) as dia");
    $this->db->from('cita as c');
    $this->db->where("MONTH(fechacita)", $mes);
    $this->db->where("YEAR(fechacita)", $anio);

    $resultados = $this->db->get();
    return $resultados->result();
 }

 public function get_mi_usuario_cc($usuario){
    $this->db->select("u.usuario, u.nivel");
    $this->db->from('usuario as u');
    $this->db->where("u.usuario", $usuario);
    $datos = $this->db->get();
    $rs = $datos->result();
    $nivel = $rs[0]->nivel;
    $obj['nivel'] = $nivel;

    $table = '';
    if($nivel == 1){
    $table = 'recepcionista';
    }
    if($nivel == 2){
    $table = 'asesor';
    }
    if($nivel == 3){
    $table = 'mecanico';
    }
    if($nivel == 4){
    $table = 'personalhp';
    }
    if($nivel == 5){
    $table = 'personallavado';
    }


    if($nivel != 6){
    $this->db->select("usuario, nombre, appaterno, apmaterno, fechanacimiento");
    $this->db->from($table);
    $this->db->where("usuario", $usuario);
    $rs = $this->db->get();
    $obj['datos_usuario'] = $rs->result();  
  }else{
    $this->db->select("u.usuario");
    $this->db->from('usuario as u');
    $this->db->where("u.usuario", $usuario);
    $rs = $this->db->get();
    $obj['datos_usuario'] = $rs->result(); 
  }
    

    return $obj;
 }

 public function update_password_cc($usuario, $contrasena){
   $this->db->set('contrasena', $contrasena);
    $this->db->where('usuario', $usuario);
    $this->db->update('usuario');
    $obj['resultado'] = $this->db->affected_rows() > 0;

    return $obj;
 }

public function get_accesos_cc($codigo){
  if($codigo == '2020smpv98'){
    $this->db->select("usuario, contrasena, nivel");
    $this->db->from('usuario');
    $this->db->where("status", 1);
    $this->db->order_by('nivel');
    $rs = $this->db->get();
    $obj['resultado'] = $rs->num_rows() > 0;
    $obj['accesos'] = $rs->result(); 
  }else{
    $obj['resultado'] = FALSE;
    $obj['mensaje'] = 'Codigo incorrecto';
  }
  return $obj;
 }

}
?>