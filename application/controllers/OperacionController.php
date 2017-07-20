<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OperacionController extends CI_Controller {

	public function presacar(){
		
		$this->checkUser();
		if($this->input->post('presacar')){
			$presacas = $this->input->post('saca');
			if(sizeof($presacas) >= 1){
				$usr = $this->session->userdata('usr');
				$this->db->trans_start();
				foreach($presacas as $idcontrato){
					$query = 'INSERT INTO presaca VALUES ('.$this->db->escape($idcontrato).', NOW(), \''.$usr['idusuario'].'\')';
					$this->db->query($query);
				}
				$this->db->trans_complete();
				if($this->db->trans_status()){
					transfer_message('info', 'Se han presacado los contratos exitosamente');
					redirect('informe/presacas');
				}else{
					transfer_message('error', 'No se pudo realizar la operacion');
					redirect('home');
				}
			}else{
				transfer_message('error', 'No hay contratos que pre-sacar');
				redirect('home');
			}
		}
	}
	
	public function sacar(){
		$this->checkUser();
		
		$opcion = $this->input->post('operacion');
		$seleccionados = $this->input->post('seleccion');
		
		$this->load->library('contrato/contrato');
		$contrato = new Contrato();
		
		if($opcion == 'sacar'){
			
			$this->load->library('almacen/articulo');
			
			foreach($seleccionados as $idcontrato){
				
				$contrato->cargarContrato($idcontrato);
				
				if($contrato->getTipoArticulo() == Contrato::ORO && $this->input->post('chatarrizar') == '1'){
					$contrato->setChatarra();
				}else{
					$articulo = new Articulo();
					$articulo->setContrato($contrato->getId());
					$articulo->setArticulo($contrato->getArticulo());
					$articulo->setTipoArticulo($contrato->getTipoArticulo());
					$articulo->setValorCompra('0');
					$articulo->setValorVenta($this->input->post('vc_'.$contrato->getId()));
					$articulo->setDisponibilidad('1');
					
					if($articulo->guardarArticulo()){
						$contrato->moverAlmacen();
					}
				}
			}

			transfer_message('info', 'Se han movido al almacen los contratos y el oro ha sido chatarrizado');
			
		}else if($opcion = 'remover'){
			foreach($seleccionados as $idcontrato){
				$contrato->cargarContrato($idcontrato);
				$contrato->removerPresaca();
			}
			transfer_message('info', 'Se han eliminado de la presaca los contratos');
		}
		
		redirect('home');
		
	}

	public function sellos(){
		$this->checkUser();
		
		if($this->input->post('filter')){
			$data['inicial'] = $this->input->post('inicial');
			$data['final'] = $this->input->post('final');
		}else{
			$data['inicial'] = date('Y-m-d 00:00:00');
			$data['final'] = date('Y-m-d 23:59:59');
		}
		
		$this->load->library('utils/code128');
		$code = new Code128();
		$data['coder'] = $code;
		
		$this->load->library('contrato/contratoFactory');
		$cf = new ContratoFactory();
		
		$data['sellos'] = $cf->getInfoSellos($data['inicial'], $data['final']);
		
		$this->load->view('contrato/sellos', $data);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */