<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principal extends CI_Controller {
public function __construct(){
   parent::__construct();
   $this->load->model("Principal_model");
	}
	public function index()
	{
		$this->load->view('welcome_view');
	}
	public function agendarCita(){
	    $this->load->view('agendar_cita_view');	
	}
	public function solicitarCotizacion(){
	    $this->load->view('solicitar_cotizacion_view');	
	}
    public function verModelos(){
	    $this->load->view('ver_modelos_view');	
	}
	public function prueba(){
		echo "Hola";
	}
	public function redireccionar(){
		$res = $obj['resultado'] = TRUE;
         echo json_encode($res);	
	}
	public function infoMantenimiento(){
	    $this->load->view('mantenimiento_view');		
	}
	public function infoHp(){
	    $this->load->view('hp_view');	
	}
}
?>
