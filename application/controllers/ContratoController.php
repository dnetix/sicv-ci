<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ContratoController extends CI_Controller {

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
	public function nuevo($idcliente = ''){
		
		$this->checkUser();
		
		$this->load->library('contrato/contrato');
		
		$contrato = new Contrato();
		
		$data['porcentaje'] = $contrato->getPorcentaje();
		$data['nroMeses'] = $contrato->getNroMeses();
		
		$this->load->library('almacen/articulo');
		$art = new Articulo();
		$data['tiposarticulo'] = $art->getTiposArticulo();
		
		$data['buscar'] = '';
		$data['ver'] = 'off';
		$data['idcliente'] = '';
		$data['nombre'] = '';
		$data['telefono'] = '';
		
		if($idcliente != ''){
			$this->load->library('cliente/cliente');
			$cliente = new Cliente();
			if($cliente->cargarCliente($idcliente)){
				$data['buscar'] = 'off';
				$data['ver'] = '';
				$data['idcliente'] = $cliente->getId();
				$data['nombre'] = $cliente->getNombre();
				$data['telefono'] = $cliente->getTelefono();
			}
		}
		
		$this->load->view('contrato/nuevo.php', $data);
		
	}
	
	public function guardar(){
		
		$this->checkUser();
		
		$usr = $this->session->userdata('usr');
		
		$this->load->library('contrato/contrato');
		
		$contrato = new Contrato();
		
		$contrato->setCliente($this->input->post('idcliente'));
		$contrato->setArticulo($this->input->post('articulo'));
		$contrato->setTipoArticulo($this->input->post('tipoarticulo'));
		$contrato->setPeso($this->input->post('peso'));
		$contrato->setValor($this->input->post('valor'));
		$contrato->setNroMeses($this->input->post('nromeses'));
		$contrato->setPorcentaje($this->input->post('porcentaje'));
		$contrato->setUsuario($usr['idusuario']);
		
		if($contrato->crearContrato()){
			$this->session->set_flashdata('idcontrato', $contrato->getId());
			redirect('contrato/imprimir');
		}else{
			log_message('error', 'Ha ocurrido un error al crear el contrato: '.$this->db->_error_message());
			transfer_message('error', 'Ha ocurrido un error al crear el contrato');
			redirect('contrato/nuevo');
		}
		
	}
	
	public function imprimir($sw = ''){
		$this->checkUser();
		
		$id = $this->session->flashdata('idcontrato');
		
		if($id){
			$idcontrato = $id;
		}else{
			if($id = $this->input->post('idcontrato')){
				$idcontrato = $id;
			}else{
				transfer_message('error', 'No se ha seleccionado un contrato');
				redirect('home');
			}
		}
		
		$this->load->library('main');
		$main = new Main();
		
		$this->load->library('contrato/contrato');
		$contrato = new Contrato();
		
		if(!$contrato->cargarContrato($idcontrato)){
			
			transfer_message('error', 'El contrato ingresado no existe');
			redirect('home');
			
		}
		
		$this->load->library('utils/code128');
		$code = new Code128();
		$data['coder'] = $code;
		
		$this->load->library('cliente/cliente');
		$cliente = new Cliente();
		$cliente->cargarCliente($contrato->getCliente());
		
		$data['nombreEmpresa'] = $main->getNombre();
		$data['nitEmpresa'] = $main->getNit();
		$data['direccionEmpresa'] = $main->getDireccion();
		$data['ciudadEmpresa'] = $main->getCiudad();
		$data['telefonoEmpresa'] = $main->getTelefono();
		$data['razonsocial'] = $main->getRazonSocial();
		$data['logo'] = $main->getLogoImg();
		$data['copia'] = $sw == 'copia' ? TRUE : FALSE;
		
		$data['idcontrato'] = $contrato->getId();
		$data['nombreCliente'] = $cliente->getNombre();
		$data['tipoidCliente'] = $cliente->getTipoIdNombre();
		$data['tipoid'] = $cliente->getTipoId();
		$data['idcliente'] = $cliente->getId();
		$data['lugarExpedicion'] = $cliente->getLugarExpedicion();
		$data['ciudadDomicilio'] = $cliente->getCiudad();
		$data['telefonoCliente'] = $cliente->getTelefono();
		
		$data['fechaingreso'] = $contrato->getFechaIngreso();
		$data['fechavencimiento'] = $contrato->getFechaVencimiento();
		
		$data['articulo'] = $contrato->getArticulo();
		$data['valorContrato'] = $contrato->getValor();
		$data['nromeses'] = $contrato->getNroMeses();
		
		$data['retroventa'] = $contrato->getValor() + (($contrato->getValor() * ($contrato->getPorcentaje() / 100)) * $contrato->getNroMeses());
		
		$this->load->view('contrato/imprimir', $data);
		
	}

	public function ver($id = ''){
		$this->checkUser();
		
		if($id == ''){
			$id = $this->session->flashdata('idcontrato');
			
			if($id){
				$idcontrato = $id;
			}else{
				if($id = $this->input->post('idcontrato')){
					$idcontrato = $id;
				}else{
					transfer_message('error', 'No se ha seleccionado un contrato');
					redirect('home');
				}
			}
		}else{
			$idcontrato = $id;
		}
		
		$this->load->library('contrato/contrato');
		$contrato = new Contrato();
		$this->load->library('almacen/articulo');
		$articulo = new Articulo();
		
		if(!$contrato->cargarContrato($idcontrato)){
			
			transfer_message('error', 'El contrato ingresado no existe');
			redirect('home');
			
		}
		
		$this->load->library('cliente/cliente');
		$cliente = new Cliente();
		$cliente->cargarCliente($contrato->getCliente());
		
		$data['idcontrato'] = $contrato->getId();
		$data['fechaIngreso'] = $contrato->getFechaIngreso();
		$data['articulo'] = $contrato->getArticulo();
		$data['tipoArticulo'] = $articulo->getNombreTipo($contrato->getTipoArticulo());
		$data['peso'] = $contrato->getPeso();
		$data['valorContrato'] = $contrato->getValor();
		$data['valorProrroga'] = $contrato->getValorProrroga();
		$data['fechaVencimiento'] = $contrato->getFechaVencimiento();
		$data['mesesTranscurridos'] = $contrato->getMesesTranscurridos();
		$data['nroMeses'] = $contrato->getNroMeses();
		$data['porcentaje'] = $contrato->getPorcentaje();
		$data['estadoContrato'] = $contrato->getEstado();
		
		$this->load->library('contrato/estado');
		$estado = new Estado();
		$subdata['descEstado'] = $estado->getNombreEstado($contrato->getEstado());
		
		/**
		 * Información de acuerdo al estado
		 */
		$data['presaca'] = FALSE;
		if($contrato->getEstado() == Contrato::ACTIVO){
			$data['presaca'] = $contrato->esPresaca();
		}else if($contrato->getEstado() == Contrato::CANCELADO){
			$subdata['valorCancelado'] = $contrato->getValorCancelado();
			$subdata['fechaSalida'] = $contrato->getFechaSalida();
			$subdata['fechaContrato'] = $contrato->getFechaIngreso();
		}else if($contrato->getEstado() == Contrato::ANULADO){
			$this->load->library('contrato/anulacion');
			$anulacion = new Anulacion();
			$anulacion->cargarAnulacion($contrato->getAnulacion());
			
			$this->load->library('usuario/usuario');
			$usuario = new Usuario();
			$usuario->cargarUsuario($anulacion->getUsuario());
			
			$subdata['fechaAnulacion'] = $anulacion->getFecha();
			$subdata['motivo'] = $anulacion->getMotivo();
			$subdata['usuario'] = $usuario->getNombre();
		}else if($contrato->getEstado() == Contrato::ALMACEN){
			$subdata['fechaSalida'] = $contrato->getFechaSalida(); 
		}else if($contrato->getEstado() == Contrato::VENDIDO){
			$tmp = $contrato->getInfoVenta();
			$subdata['fechaVenta'] = $tmp['fecha'];
			$subdata['valorVenta'] = $tmp['valor'];
			$subdata['idclienteVenta'] = $tmp['idcliente'];
			$subdata['idnotacobro'] = $tmp['idnotacobro'];
		}else if($contrato->getEstado() == Contrato::CHATARRIZADO){
			$subdata['fechaSalida'] = $contrato->getFechaSalida();
		}else if($contrato->getEstado() == Contrato::PROBLEMALEGAL){
			$subdata['fechaSalida'] = $contrato->getFechaSalida();
		}
		$data['info'] = $subdata;
		
		/**
		 * Objeto de tipo result
		 */
		$data['prorrogas'] = $contrato->getProrrogas();
		
		$data['nombreCliente'] = $cliente->getNombre();
		$data['idcliente'] = $cliente->getId();
		$data['lugarExpedicion'] = $cliente->getLugarExpedicion();
		$data['telefonoCliente'] = $cliente->getTelefono();
		
		/**
		 * Datos de Cancelacion
		 */
		$data['valorCancelado'] = $contrato->getValorCancelado();
		
		$this->load->view('contrato/ver', $data);
		
	}

	public function prorrogar(){
			
		$this->checkUser();
		
		$valor = $this->input->post('valorProrroga');
		$idcontrato = $this->input->post('idcontrato');
		
		if($valor && $idcontrato){
			
			$this->load->library('contrato/contrato');
			$contrato = new Contrato();
			
			if($contrato->cargarContrato($idcontrato)){
				
				if($contrato->getEstado() == Contrato::ACTIVO){
					$username = $this->session->userdata('usr');
					
					$this->load->library('contrato/prorroga');
					$prorroga = new Prorroga();
					
					$prorroga->setContrato($contrato->getId());
					$prorroga->setValor($valor);
					$prorroga->setNroMeses($valor / $contrato->getValorProrroga());
					$prorroga->setUsuario($username['idusuario']);
					
					if($prorroga->guardarProrroga()){
						$this->session->set_flashdata('idcontrato', $idcontrato);
						transfer_message('info', 'Se ha guardado el abono');
						redirect('contrato/ver');
					}
				}else{
					transfer_message('error', 'No se puede prorrogar un contrato inactivo');
					redirect('home');
				}
				
			}else{
				transfer_message('error', 'No existe el contrato a abonar');
				redirect('home');
			}
			
		}else{
			transfer_message('error', 'Ha ocurrido un error al crear el abono');
			redirect('home');
		}
	}

	public function cancelar(){
		$this->checkUser();
		
		$idcontrato = $this->input->post('idcontrato');
		$valor = $this->input->post('valorcancelar');
		
		if($idcontrato && $valor !== FALSE){
			
			$this->load->library('contrato/contrato');
			$contrato = new Contrato();
			
			if($contrato->cargarContrato($idcontrato)){
				
				if($contrato->cancelarContrato($valor)){
					$this->session->set_flashdata('idcontrato', $idcontrato);
					transfer_message('info', 'Se ha cancelado el contrato');
					redirect('contrato/ver');
				}else{
					transfer_message('error', 'Ha ocurrido un error al cancelar el contrato, segunda etapa');
					redirect('home');
				}
				
			}else{
				transfer_message('error', 'El contrato ingresado no existe');
				redirect('home');
			}
			
		}else{
			transfer_message('error', 'Ha ocurrido un error al cancelar el contrato');
			redirect('home');
		}
		
	}
	
	public function anular(){
		$this->checkUser();
		
		$idcontrato = $this->input->post('idcontrato');
		$motivo = $this->input->post('motivo');
		
		if($idcontrato){
			
			$this->load->library('contrato/contrato');
			$contrato = new Contrato();
			
			if($contrato->cargarContrato($idcontrato)){
				
				if($contrato->getEstado() == Contrato::ACTIVO){
					$this->load->library('contrato/anulacion');
					$anulacion = new Anulacion();
					
					$usuario = $this->session->userdata('usr');
					
					$anulacion->setMotivo($motivo.' [Valor Anterior $ '.number_format($contrato->getValor()).']');
					$anulacion->setUsuario($usuario['idusuario']);
					$anulacion->guardarAnulacion();
					
					if($contrato->anularContrato($anulacion)){
						
						$this->session->set_flashdata('idcontrato', $idcontrato);
						transfer_message('info', 'Se ha anulado el contrato');
						redirect('contrato/ver');
						
					}else{
						transfer_message('error', 'No se pudo agregar la anulaci&oacute;n');
						redirect('home');
					}
					
				}else{
					transfer_message('error', 'No se pudo agregar la anulaci&oacute;n');
					redirect('home');
				}
				
			}else{
				transfer_message('error', 'El contrato ingresado no existe');
				redirect('home');
			}
			
		}else{
			transfer_message('error', 'Ha ocurrido un error al cancelar el contrato');
			redirect('home');
		}
		
	}

	public function mover(){
		$this->checkUser();
		
		$idcontrato = $this->input->post('idcontrato');
		
		if($idcontrato){
			$this->load->library('contrato/contrato');
			$contrato = new Contrato();
			if($contrato->cargarContrato($idcontrato)){
				
				if($contrato->getEstado() == Contrato::ACTIVO){
					
					$this->load->library('almacen/articulo');
					$articulo = new Articulo();
					
					$valorventa = $this->input->post('valorventa');
					
					$articulo->setContrato($contrato->getId());
					$articulo->setArticulo($contrato->getArticulo());
					$articulo->setTipoArticulo($contrato->getTipoArticulo());
					$articulo->setValorCompra('0');
					$articulo->setValorVenta($valorventa);
					$articulo->setDisponibilidad('1');
					
					if($articulo->guardarArticulo()){
						if($contrato->moverAlmacen()){
							$this->session->set_flashdata('idcontrato', $idcontrato);
							transfer_message('info', 'Se ha movido el contrato');
							redirect('contrato/ver');
						}else{
							transfer_message('error', 'No se pudo modificar el contrato');
							redirect('home');
						}
					}else{
						transfer_message('error', 'No se pudo guardar el articulo');
						redirect('home');
					}
					
				}else{
					transfer_message('error', 'El contrato no está activo por lo cual no se puede mover');
					redirect('home');
				}
				
			}else{
				transfer_message('error', 'No existe el contrato a mover');
				redirect('home');
			}
		}else{
			transfer_message('error', 'No se enviaron los datos necesarios para mover el contrato');
			redirect('home');
		}
	} 
	
	public function operacion($operacion){
		$this->checkUser();
		
		$idcontrato = $this->input->post('idcontrato');
		
		if($idcontrato){
			$this->load->library('contrato/contrato');
			$contrato = new Contrato();
			if($contrato->cargarContrato($idcontrato)){
				
				/**
				 * Depende de la operacion a realizar
				 */
				if($operacion == 'cancelar'){
					$data['idcontrato'] = $contrato->getId();
					$data['valorCancelacion'] = $contrato->getValorCancelacion();
					$this->load->view('contrato/operaciones/cancelar', $data);
				}else if($operacion == 'anular'){
					$data['idcontrato'] = $contrato->getId();
					$this->load->view('contrato/operaciones/anular', $data);
				}else if($operacion == 'mover'){
					$data['idcontrato'] = $contrato->getId();
					$data['valorCancelacion'] = $contrato->getValorCancelacion();
					$this->load->view('contrato/operaciones/mover', $data);
				}
				
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}
	
	public function removerpresaca(){
		$this->checkUser();
		
		$idcontrato = $this->input->post('idcontrato');
		
		if($idcontrato){
			
			$this->load->library('contrato/contrato');
			$contrato = new Contrato();
			if($contrato->cargarContrato($idcontrato)){
				$contrato->removerPresaca();
				$this->session->set_flashdata('idcontrato', $idcontrato);
				redirect('contrato/ver');
			}else{
				transfer_message('error', 'No existe el contrato seleccionado');
				redirect('home');	
			}

		}else{
			transfer_message('error', 'No se han ingresado los datos necesarios para la acci&oacute;n');
			redirect('home');
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */