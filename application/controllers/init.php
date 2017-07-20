<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Init extends CI_Controller {

	public function index(){
		
		$usr = $this->session->userdata('usr');
		
		if($usr){
			
			if($usr['rol'] > 0){
				transfer_message('info', 'Ha sido redireccionado al men&uacute; de la aplicaci&oacute;n');
				redirect('home');
			}else{
				$this->load->view('login');
			}
			
		}else{
			$this->load->view('login');
		}
	
	}
	
	public function menu(){
		
		$usr = $this->session->userdata('usr');
		
		if($usr){
			
			if($usr['rol'] > 0){
				
				$this->load->library('contrato/contratoFactory');
				$cf = new ContratoFactory();
				$data['contratos'] = $cf->getContratosActivos('', 'idcontrato', 'ASC', date('Y-m-d').' 00:00:00', date('Y-m-d').' 23:59:59');
				
				$this->load->view('menu', $data);
			}else{
				transfer_message('error', 'Hay un error con su sesión, por favor inicie sesión de nuevo');
				redirect('init/index');
			}
			
		}else{
			transfer_message('error', 'Debe estar logueado para acceder a esta parte de la aplicaci&oacute;n');
			redirect('init/index');
		}
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */