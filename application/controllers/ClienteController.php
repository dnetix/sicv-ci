<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ClienteController extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function nuevo(){
		
		$this->checkUser();
		
		$this->load->library('cliente/cliente');
		$cliente = new Cliente();
		
		$data['tipos'] = $cliente->getTiposId();
		
		$this->load->view('ajax/nuevocliente', $data);
		
	}
	
	public function crear($estado = ''){
		
		$this->checkUser();
		
		$this->load->library('cliente/cliente');
		$cliente = new Cliente();
		
		$data['tipos'] = $cliente->getTiposId();
		$data['estado'] = $estado;
		
		$this->load->view('cliente/nuevo', $data);
		
	}
	
	public function docrear(){
		$this->checkUser();
		
		$this->load->library('cliente/cliente');
		$cliente = new Cliente();
		
		$idcliente = $this->input->post('idcliente');
		
		if($idcliente){
			
			$cliente->setId($idcliente);
			$cliente->setTipoId($this->input->post('tipoid'));
			$cliente->setLugarExpedicion($this->input->post('lugarexpedicion'));
			$cliente->setNombre($this->input->post('nombre'));
			$cliente->setDireccion($this->input->post('direccion'));
			$cliente->setTelefono($this->input->post('telefono'));
			$cliente->setCelular($this->input->post('celular'));
			$cliente->setCiudad($this->input->post('ciudad'));
			$cliente->setEmail($this->input->post('email'));
			
			if($cliente->guardarCliente()){
				transfer_message('info', 'Se ha guardado el cliente exitosamente');
				redirect('home');
			}else{
				transfer_message('error', 'No se ha guardado el cliente debido a un error');
				redirect('cliente/nuevo');
			}
		}else{
			transfer_message('error', 'No se ingresaron todos los datos requeridos');
			redirect('home');
		}
	}

	public function guardar(){
		$this->checkUser();
		
		$this->load->library('cliente/cliente');
		$cliente = new Cliente();
		
		$idcliente = $this->input->post('idcliente');
		
		if($idcliente){
			
			$data['creado'] = 1;
			$data['existe'] = 0;
			
			if($cliente->cargarCliente($idcliente)){
				
				$data['existe'] = 1;
				
			}else{
			
				$cliente->setId($idcliente);
				$cliente->setTipoId($this->input->post('tipoid'));
				$cliente->setLugarExpedicion($this->input->post('lugarexpedicion'));
				$cliente->setNombre($this->input->post('nombre'));
				$cliente->setDireccion($this->input->post('direccion'));
				$cliente->setTelefono($this->input->post('telefono'));
				$cliente->setCelular($this->input->post('celular'));
				$cliente->setCiudad($this->input->post('ciudad'));
				$cliente->setEmail($this->input->post('email'));
				
				if($cliente->guardarCliente()){
					$data['creado'] = 1;
				}else{
					$data['creado'] = 0;
				}
			}
			$data['idcliente'] = $cliente->getId();
			$data['nombre'] = $cliente->getNombre();
			$data['telefono'] = $cliente->getTelefono();
		}else{
			$data['creado'] = 0;
		}
		
		echo json_encode($data);
		
	}

	public function editar(){
		$this->checkUser();
		
		$this->load->library('cliente/cliente');
		$cliente = new Cliente();
		
		$idcliente = $this->input->post('idcliente');
		
		if($cliente->cargarCliente($idcliente)){
			
			$cliente->setTipoId($this->input->post('tipoid'));
			$cliente->setLugarExpedicion($this->input->post('lugarexpedicion'));
			$cliente->setNombre($this->input->post('nombre'));
			$cliente->setDireccion($this->input->post('direccion'));
			$cliente->setTelefono($this->input->post('telefono'));
			$cliente->setCelular($this->input->post('celular'));
			$cliente->setCiudad($this->input->post('ciudad'));
			$cliente->setEmail($this->input->post('email'));
			
			if($cliente->editarCliente()){
				$this->session->set_flashdata('idcliente', $cliente->getId());
				transfer_message('info', 'Se ha editado el cliente exitosamente');
				redirect('cliente/ver');
			}else{
				transfer_message('error', 'No se ha guardado el cliente debido a un error');
				redirect('home');
			}
		}else{
			transfer_message('error', 'No existe el cliente a editar');
			redirect('home');
		}
	}
	
	public function buscar(){
		
		$this->checkUser();
		
		$client_q = $this->input->post('client_q');
		
		if($client_q){
			
			$this->load->library('cliente/cliente');
			$cliente = new Cliente();
			
			$data['clientes'] = $cliente->buscarCliente($client_q);
			
			$this->load->view('ajax/cliente', $data);
			
		}
		
	}
	
	public function buscarciudad(){
		$this->checkUser();
		
		$nombre = $this->input->post('nombre');
		
		$this->load->library('cliente/cliente');
		$cliente = new Cliente();
		
		$data['ciudades'] = $cliente->buscarCiudad($nombre);
		$data['field'] = $this->input->post('field');
		
		$this->load->view('cliente/ciudades', $data);
		
	}
	
	public function ver($id = ''){
		$this->checkUser();
		$data['cliente'] = TRUE;
		if($id === ''){
			$id = $this->session->flashdata('idcliente');
			if($id !== FALSE){
				$idcliente = $id;
			}else{
				$id = $this->input->post('idcliente');
				if($id !== FALSE){
					$idcliente = $id;
				}else{
					$data['cliente'] = FALSE;
				}
			}
		}else{
			$idcliente = $id;
		}
		
		if($data['cliente']){
			$this->load->library('cliente/cliente');
			$cliente = new Cliente();
			if($cliente->cargarCliente($idcliente)){
				
				$data['cliente'] = $cliente;
				$data['tipos'] = $cliente->getTiposId();
				
				$this->load->library('contrato/contratoFactory');
				$cf = new ContratoFactory();
				
				$this->load->library('contrato/contrato');
				
				$data['contratos'] = $cf->getHistorialContratos($cliente->getId());
				
				$this->load->library('almacen/almacen');
				$almacen = new Almacen();
				
				$data['compras'] = $almacen->getNotasPorCliente($cliente->getId());
				
			}else{
				$data['cliente'] = FALSE;
			}
		}
		
		$this->load->view('cliente/ver', $data);
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */