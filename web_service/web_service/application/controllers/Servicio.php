<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicio extends CI_Controller {
public function __construct(){
   parent::__construct();
   $this->load->model("Servicio_model");
	}
	public function agendar_cita(){
	$nombre = $this->input->post("nombre");
	$appaterno = $this->input->post("appaterno");
	$apmaterno = $this->input->post("apmaterno");
	$correo = $this->input->post("correo");
	$tel = $this->input->post("tel");
	$rep_g = $this->input->post("rep_g");
	$ser_m = $this->input->post("ser_m");
	$ser_hp = $this->input->post("ser_hp");
    $fecha = $this->input->post("fecha");
    $horario = $this->input->post("horario");
    
    $obj = $this->Servicio_model->agendar_cita_cliente($nombre, $appaterno, $apmaterno, $correo, $tel, $rep_g, $ser_m, $ser_hp, $fecha, $horario);
    echo json_encode($obj);
	}

	public function get_horarios(){
	$obj = $this->Servicio_model->get_horarios_cliente();
    echo json_encode($obj);	
	}

	public function get_modelos(){
	$obj = $this->Servicio_model->get_modelos_cliente();
    echo json_encode($obj);	
	}

	public function get_versiones(){
	$modelo = $this->input->post("modelo");
	$obj = $this->Servicio_model->get_versiones_cliente($modelo);
    echo json_encode($obj);	
	}

	public function get_imagen_auto(){
	$modelo = $this->input->post("modelo");
	$version = $this->input->post("version");
	$obj = $this->Servicio_model->get_imagen_auto_cliente($modelo, $version);
	echo json_encode($obj);	
	}

	public function solicitar_cotizacion(){
    $nombre = $this->input->post("nombre");
	$appaterno = $this->input->post("appaterno");
	$apmaterno = $this->input->post("apmaterno");
	$correo = $this->input->post("correo");
	$tel = $this->input->post("tel");
    $modelo = $this->input->post("modelo");
    $version = $this->input->post("version");
    
    $obj = $this->Servicio_model->solicitar_cotizacion_cliente($nombre, $appaterno, $apmaterno, $correo, $tel, $modelo, $version);
   // $obj = $this->Servicio_model->solicitar_cotizacion_cliente();
    echo json_encode($obj);
	}

	public function get_autos(){
	$obj = $this->Servicio_model->get_autos_cliente();
	echo json_encode($obj);
	}

	public function verificar_sesion(){
	$usuario=$this->input->post("usuario");
	$contrasena=$this->input->post("contrasena");
    $obj=$this->Servicio_model->verificar_sesion_cc($usuario, $contrasena);
    echo json_encode($obj);	
	}

	public function get_citas(){
    $obj=$this->Servicio_model->get_citas_cc();
    echo json_encode($obj);
	}

	public function get_cotizaciones(){
    $obj=$this->Servicio_model->get_cotizaciones_cc();
    echo json_encode($obj);
	}

	public function get_citas_xfecha(){
	$fecha = $this->input->post("fecha");
	$obj=$this->Servicio_model->get_citas_xfecha_cc($fecha);
    echo json_encode($obj);	
	}
	public function get_citas_proximas(){
	$fecha_1 = $this->input->post("fecha_1");
	$fecha_2 = $this->input->post("fecha_2");
	$fecha_3 = $this->input->post("fecha_3");
	$fecha_4 = $this->input->post("fecha_4");
	$obj=$this->Servicio_model->get_citas_proximas_cc($fecha_1, $fecha_2, $fecha_3, $fecha_4);
    echo json_encode($obj);	
	}
	public function get_citas_del_dia(){
	$fecha_1 = $this->input->post("fecha_1");
	$obj=$this->Servicio_model->get_citas_del_dia_cc($fecha_1);
    echo json_encode($obj);	
	}
	public function get_citas_calendar(){
	//$fecha = $this->input->post("fecha");
	$obj=$this->Servicio_model->get_citas_calendar_cc();
    //$val = json_encode($obj);	
    //$data[]=$val;
    //echo $data;
    echo json_encode($obj);
    //$val = json_encode($obj);	
	//echo $obj;
	}
	public function update_status_cita(){
	$idcita = $this->input->post("idcita");
	$status = $this->input->post("status");
	$obj=$this->Servicio_model->update_status_cita_cc($idcita, $status);
    echo json_encode($obj);	
	}

	public function get_asesor(){
	$obj = $this->Servicio_model->get_asesor_cc();
    echo json_encode($obj);	
	}

	public function generar_orden(){
	$idcita = $this->input->post("idcita");
	$asesor = $this->input->post("asesor");
	$fecha = $this->input->post("fecha");
	$obj=$this->Servicio_model->generar_orden_cc($idcita, $asesor, $fecha);
    echo json_encode($obj);	
	}
	public function get_orden_proximas(){
	$usuario = $this->input->post("usuario");
	$fecha = $this->input->post("fecha");
	$obj=$this->Servicio_model->get_orden_proximas_cc($usuario, $fecha);
    echo json_encode($obj);	
	}

	public function get_motor(){
	$obj = $this->Servicio_model->get_motor_cc();
    echo json_encode($obj);	
	}
	public function get_carroceria(){
	$obj = $this->Servicio_model->get_carroceria_cc();
    echo json_encode($obj);	
	}
	public function insert_prediagnostico(){
    $idcita = $this->input->post("idcita");
	$orden = $this->input->post("orden");
	$vin = $this->input->post("vin");
	$modelo = $this->input->post("modelo");
	$version = $this->input->post("version");
	$motor = $this->input->post("motor");
	$carroceria = $this->input->post("carroceria");
	$km = $this->input->post("km");
	$potencia = $this->input->post("potencia");
	$fechatermino = $this->input->post("fechatermino");
	$caract_internas = $this->input->post("caract_internas");
	$caract_externas = $this->input->post("caract_externas");
	$defecto = $this->input->post("defecto");
	$obj=$this->Servicio_model->insert_prediagnostico_cc($idcita, $orden, $vin, $modelo, $version, $km, $fechatermino, $caract_internas, $caract_externas, $defecto);
    echo json_encode($obj);	    
	}
   

    public function insert_cotizacion_servicio(){
    $idorden = $this->input->post("idorden");
    $idcita = $this->input->post("idcita");
    $total = $this->input->post("total");
    $array_costo = json_decode(stripslashes($this->input->post("array_costo")));
    $array_concepto = json_decode(stripslashes($this->input->post("array_concepto")));
    $accion_cotizacion = $this->input->post("accion_cotizacion");
    $obj=$this->Servicio_model->insert_cotizacion_servicio_cc($idorden, $idcita, $total, $array_costo, $array_concepto, $accion_cotizacion);
    echo json_encode($obj);		
    }

    public function get_info_tareas(){
    $idorden = $this->input->post("idorden");
    $idcita = $this->input->post("idcita");
    $detenido = $this->input->post("detenido");
    $obj=$this->Servicio_model->get_info_taras_cc($idorden, $idcita, $detenido);
    echo json_encode($obj);	
    }

    public function insert_update_tarea(){
    $idcita = $this->input->post("idcita");
    $idorden = $this->input->post("idorden");
    $idtarea = $this->input->post("idtarea");
    $tarea = $this->input->post("tarea");
    $tiempo = $this->input->post("tiempo");
    $mecanico = $this->input->post("mecanico");
    $usuario = $this->input->post("usuario");
	$fecha = $this->input->post("fecha");
    $obj=$this->Servicio_model->insert_update_tarea_cc($idcita, $idorden, $idtarea, $tarea, $tiempo, $mecanico, $usuario, $fecha);
    echo json_encode($obj);
    }

    public function delete_tarea(){
    $idtarea = $this->input->post("idtarea");
    $usuario = $this->input->post("usuario");
	$fecha = $this->input->post("fecha");
    $obj=$this->Servicio_model->delete_tarea_cc($idtarea, $usuario, $fecha);
    echo json_encode($obj);
    }

    public function play_tarea(){
    $idtarea = $this->input->post("idtarea");
    $obj=$this->Servicio_model->play_tarea_cc($idtarea);
    echo json_encode($obj);	
    }

    public function pause_tarea(){
    $idtarea = $this->input->post("idtarea");
    $obj=$this->Servicio_model->pause_tarea_cc($idtarea);
    echo json_encode($obj);	
    }

    public function stop_tarea(){
    $idtarea = $this->input->post("idtarea");
    $usuario = $this->input->post("usuario");
	$fecha = $this->input->post("fecha");
    $obj=$this->Servicio_model->stop_tarea_cc($idtarea, $usuario, $fecha);
    echo json_encode($obj);	
    }

    public function get_mecanico(){
	$obj = $this->Servicio_model->get_mecanico_cc();
    echo json_encode($obj);	
	}

	public function tareas_proceso(){
	$idorden = $this->input->post("idorden");
	$usuario = $this->input->post("usuario");
	$fecha = $this->input->post("fecha");
    $obj=$this->Servicio_model->tareas_proceso_cc($idorden, $usuario, $fecha);
    echo json_encode($obj);	
	}

	public function orden_proceso(/*$usuario, $fecha*/){
	$usuario = $this->input->post("usuario");
	$fecha = $this->input->post("fecha");
    $obj=$this->Servicio_model->orden_proceso_cc($usuario, $fecha);
    echo json_encode($obj);	
	}

	public function get_tareas_detenidas(){
	$usuario = $this->input->post("usuario");
	//$fecha = $this->input->post("fecha");
    $obj=$this->Servicio_model->get_tareas_detenidas_cc($usuario);
    echo json_encode($obj);	
	}
 
    public function get_cotizacion_servicio(){
    $idcita = $this->input->post("idcita");
    $obj=$this->Servicio_model->get_cotizacion_servicio_cc($idcita);
    echo json_encode($obj);	
    }

    public function analisis_realizada(){
    $idcita = $this->input->post("idcita");
    $idorden = $this->input->post("idorden");
    $obj=$this->Servicio_model->analisis_realizada_cc($idcita, $idorden);
    echo json_encode($obj);	
    }

    public function get_orden_proximas_meca(){
    $usuario = $this->input->post("usuario");
    //$fecha = $this->input->post("fecha");
    $obj=$this->Servicio_model->get_orden_proximas_meca_cc($usuario);
    echo json_encode($obj);	
    }

    public function get_info_tareas_meca(){
    $idorden = $this->input->post("idorden");
    $idcita = $this->input->post("idcita");
    $detenido = $this->input->post("detenido");
    $usuario = $this->input->post("usuario");
    $obj=$this->Servicio_model->get_info_tareas_meca_cc($idorden, $idcita, $detenido, $usuario);
    echo json_encode($obj);	
    }




	public function previo($fecha){
	$obj=$this->Servicio_model->previo($fecha);
    echo json_encode($obj);	
	}
	public function get_observacion(){
	$idtarea = $this->input->post("idtarea");
    //$usuario = $this->input->post("usuario");
	$obj=$this->Servicio_model->get_observacion_cc($idtarea);
    echo json_encode($obj);	
	}

	 public function insert_observacion(){
    $idtarea = $this->input->post("idtarea");
    $array_concepto = json_decode(stripslashes($this->input->post("array_concepto")));
    $obj=$this->Servicio_model->insert_observacion_cc($idtarea, $array_concepto);
    echo json_encode($obj);		
    }

    public function get_ordenes_finalizadas(){
    $usuario = $this->input->post("usuario");
	$obj=$this->Servicio_model->get_ordenes_finalizadas_cc($usuario);
    echo json_encode($obj);	
    }

    public function enviar_orden_hp(){
    $idorden = $this->input->post("idorden");
    $usuario = $this->input->post("usuario");
    $personalhp = $this->input->post("personalhp");
    $idcita = $this->input->post("idcita");
	$obj=$this->Servicio_model->enviar_orden_hp_cc($idorden, $usuario, $personalhp, $idcita);
    echo json_encode($obj);	
    }

    public function get_personalhp(){
	$obj = $this->Servicio_model->get_personalhp_cc();
    echo json_encode($obj);	
	}

	public function get_personallavado(){
	$obj = $this->Servicio_model->get_personallavado_cc();
    echo json_encode($obj);	
	}

	public function get_ordenes_hp(){
	$usuario = $this->input->post("usuario");
    $obj = $this->Servicio_model->get_ordenes_hp_cc($usuario);
    echo json_encode($obj);	
	}

	public function iniciar_reparacion_hp(){
    $idorden = $this->input->post("idorden");
    $idcita = $this->input->post("idcita");
    $usuario = $this->input->post("usuario");
	$obj=$this->Servicio_model->iniciar_reparacion_hp_cc($idorden, $usuario, $idcita);
    echo json_encode($obj);
	}

	public function get_ordenes_proceso_hp(){
	$usuario = $this->input->post("usuario");
	$obj=$this->Servicio_model->get_ordenes_proceso_hp_cc($usuario);
    echo json_encode($obj);	
	}

	public function get_info_orden_hp(){
	$idorden = $this->input->post("idorden");
    $idcita = $this->input->post("idcita");
	$obj=$this->Servicio_model->get_info_orden_hp_cc($idorden, $idcita);
    echo json_encode($obj);	
	}

	public function update_status_lavado(){
	$idorden = $this->input->post("idorden");
    $idcita = $this->input->post("idcita");
    $usuario = $this->input->post("personallavado");
	$obj=$this->Servicio_model->update_status_lavado_cc($idorden, $usuario, $idcita);
    echo json_encode($obj);
	}

	public function get_ordenes_lavado(){
	$usuario = $this->input->post("usuario");
    $obj = $this->Servicio_model->get_ordenes_lavado_cc($usuario);
    echo json_encode($obj);	
	}

	public function status_lavando_auto(){
	$idorden = $this->input->post("idorden");
    $idcita = $this->input->post("idcita");
	$obj=$this->Servicio_model->status_lavando_auto_cc($idorden, $idcita);
    echo json_encode($obj);
	}

	public function status_finalizar_lavado_auto(){
	$idorden = $this->input->post("idorden");
    $idcita = $this->input->post("idcita");
	$obj=$this->Servicio_model->status_finalizar_lavado_auto_cc($idorden, $idcita);
    echo json_encode($obj);
	}

	public function get_orden_listos_entrega(){
    $usuario = $this->input->post("usuario");
    $obj=$this->Servicio_model->get_orden_listos_entrega_cc($usuario);
    echo json_encode($obj);	
    }

    public function entregar_auto(){
	$idorden = $this->input->post("idorden");
    $idcita = $this->input->post("idcita");
	$obj=$this->Servicio_model->entregar_auto_cc($idorden, $idcita);
    echo json_encode($obj);
	}

	public function get_usuarios(){
	$obj=$this->Servicio_model->get_usuarios_cc();
    echo json_encode($obj);	
	}

	public function insert_update_usuario(){
	$accion = $this->input->post("accion");
    $nombre = $this->input->post("nombre");
    $appaterno = $this->input->post("appaterno");
    $apmaterno = $this->input->post("apmaterno");
    $fecha = $this->input->post("fecha");
    $usuario = $this->input->post("usuario");
    $nivel = $this->input->post("nivel");
    $contrasena = $this->input->post("contrasena");
	$obj=$this->Servicio_model->insert_update_usuario_cc($accion, $nombre, $appaterno, $apmaterno, $fecha, $usuario, $nivel, $contrasena);
    echo json_encode($obj);
	}

	public function baja_usuario(){
	$usuario = $this->input->post("usuario");
	$nivel = $this->input->post("nivel");
	$obj=$this->Servicio_model->baja_usuario_cc($usuario, $nivel);
    echo json_encode($obj);	
	}
	public function alta_usuario(){
	$usuario = $this->input->post("usuario");
	$nivel = $this->input->post("nivel");
	$obj=$this->Servicio_model->alta_usuario_cc($usuario, $nivel);
    echo json_encode($obj);	
	}

	public function get_autos_admin(){
	$obj=$this->Servicio_model->get_autos_cc();
    echo json_encode($obj);	
	}

	public function get_info_auto(){
	$obj=$this->Servicio_model->get_info_auto_cc();
    echo json_encode($obj);		
	}

	public function update_auto(){
	$idauto = $this->input->post("idauto");
	$combustible = $this->input->post("combustible");
	$carroceria = $this->input->post("carroceria");
	$transmision = $this->input->post("transmision");
	$precio = $this->input->post("precio");
    $cilindros = $this->input->post("cilindros");
    $potencia = $this->input->post("potencia");
    $torque = $this->input->post("torque");
	$valvulas = $this->input->post("valvulas");
    $motor = $this->input->post("motor");
    $color = $this->input->post("color");

	$obj=$this->Servicio_model->update_auto_cc($idauto, $combustible, $carroceria, $transmision, $precio, $cilindros, $potencia, $torque, $valvulas, $motor, $color);
    echo json_encode($obj);	
	}

	public function get_transmision(){
	$obj=$this->Servicio_model->get_transmision_cc();
    echo json_encode($obj);		
	}

	public function get_versiones_dis(){
	//$modelo = $this->input->post('modelo');
    $obj = $this->Servicio_model->get_versiones_dis_cc();
    echo json_encode($obj);	
	}

    public function subir_imagen()
    {
        $config['upload_path'] = '../app_cc/static/images/autos/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 2048;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('images')) { #Aquí me refiero a "foto", el nombre que pusimos en FormData
            $error = array('error' => $this->upload->display_errors());
            echo json_encode($error);
        } else {
            //echo json_encode(true);
       $nombre = $this->input->post('nombre');
       $modelo = $this->input->post('modelo');
       $version = $this->input->post('version');
       $combustible = $this->input->post('combustible');
       $carroceria = $this->input->post('carroceria');
       $transmision = $this->input->post('transmision');
       $precio = $this->input->post('precio');
       $cilindros = $this->input->post('cilindros');
       $potencia = $this->input->post('potencia');
       $torque = $this->input->post('torque');
       $valvulas = $this->input->post('valvulas');
       $motor = $this->input->post('motor');
       $color = $this->input->post('color');

       $obj=$this->Servicio_model->insert_auto_cc($nombre, $modelo, $version, $combustible, $carroceria, $transmision, $precio, $cilindros, $potencia, $torque, $valvulas, $motor, $color);
       echo json_encode($obj);
        }
  }

  public function cambio_status_auto(){
   $idauto = $this->input->post('idauto');
   $status = $this->input->post('status');
   $obj=$this->Servicio_model->cambio_status_auto_cc($idauto, $status);
   echo json_encode($obj);
  }

  public function insert_modelo(){
   $modelo = $this->input->post('modelo');
   $obj=$this->Servicio_model->insert_modelo_cc($modelo);
   echo json_encode($obj);
  }

  public function insert_version(){
   $version = $this->input->post('version');
   $obj=$this->Servicio_model->insert_version_cc($version);
   echo json_encode($obj);
  }

  public function get_status(/*$nombre, $appaterno, $apmaterno, $vin*/){
  $nombre = $this->input->post('nombre');
  $appaterno = $this->input->post('appaterno');
  $apmaterno = $this->input->post('apmaterno');
  $vin = $this->input->post('vin');
  $obj = $this->Servicio_model->get_status_cc($nombre, $appaterno, $apmaterno, $vin);
   echo json_encode($obj);	
  }

  public function prueba_error(){
  $obj=$this->Servicio_model->prueba_error();
   echo json_encode($obj);	
  }

  public function get_estadistica_citas(){
  $anio = $this->input->post('anio');
  $mes = $this->input->post('mes');
  $obj_estadistica=$this->Servicio_model->get_estadistica_citas_cc($anio, $mes);
 //  echo json_encode($obj);	
   
   $a = 0;
   $b = 0;
   $c = 0;
   $d = 0;

   $e = 0;
   $f = 0;
   $g = 0;
   $h = 0;
   $obj['nocitas'] = array();
   $obj['sicitas'] = array();
   foreach ($obj_estadistica as $objcita ) {
   	 if($objcita->status == 'Confirmada' || $objcita->status == 'Agendada'){
           if($objcita->dia >= 1 && $objcita->dia <=7){
             $a ++;
           }else if($objcita->dia >= 8 && $objcita->dia <=14){
             $b ++;
           }else if($objcita->dia >= 15 && $objcita->dia <=21){
             $c++;
           }else if($objcita->dia >= 22){
             $d++;
           } 
   	 }else{
           if($objcita->dia >= 1 && $objcita->dia <=7){
             $e ++;
           }else if($objcita->dia >= 8 && $objcita->dia <=14){
             $f ++;
           }else if($objcita->dia >= 15 && $objcita->dia <=21){
             $g ++;
           }else if($objcita->dia >= 22){
             $h ++;
           } 
   	 }
        //	$meses[] = $objmes->nommes;
   	    }
        
        //$obj["meses"] = $meses;
        array_push($obj['nocitas'], $a);
        array_push($obj['nocitas'], $b);
        array_push($obj['nocitas'], $c);
        array_push($obj['nocitas'], $d);

        array_push($obj['sicitas'], $e);
        array_push($obj['sicitas'], $f);
        array_push($obj['sicitas'], $g);
        array_push($obj['sicitas'], $h);

        $series[] =  (object) array(
               "name" => 'Citas realizadas', 
               "data" => $obj['sicitas']
        	   );

        $series[] =  (object) array(
               "name" => 'No asistidas', 
               "data" => $obj['nocitas']
        	   );
      
        $object["series"] = $series;
 
		echo json_encode($object);

  }
 
 public function get_mi_usuario(){
    $usuario = $this->input->post('usuario');
    $obj = $this->Servicio_model->get_mi_usuario_cc($usuario);
    echo json_encode($obj);	
    }

    public function update_password(){
    $usuario = $this->input->post('usuario');
    $contrasena = $this->input->post('contrasena');
    $obj = $this->Servicio_model->update_password_cc($usuario, $contrasena);
    echo json_encode($obj);	
    }

  public function get_accesos(){
    $codigo = $this->input->post('codigo');
    $obj = $this->Servicio_model->get_accesos_cc($codigo);
    echo json_encode($obj);		
    }


}
?>
