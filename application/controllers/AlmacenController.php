<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AlmacenController extends CI_Controller {

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
		
		$this->load->library('almacen/articulo');
		$art = new Articulo();
		$data['tiposarticulo'] = $art->getTiposArticulo();
		
		$this->load->view('almacen/nuevoarticulo', $data);
		
	}
	
	public function guardar(){
		
		$this->checkUser();
		
		if($this->input->post('guardar')){
			
			$this->load->library('almacen/articulo');
			$art = new Articulo();
			
			$art->setArticulo($this->input->post('articulo'));
			$art->setTipoArticulo($this->input->post('tipoarticulo'));
			$art->setValorCompra($this->input->post('valor'));
			$art->setValorVenta($this->input->post('valorventa'));
			$art->setDisponibilidad($this->input->post('disponible'));
			
			if($art->guardarArticulo()){
				transfer_message('info', 'Se ha ingresado correctamente el articulo <strong>'.$art->getId().'</strong>');
				redirect('almacen/nuevo');
			}else{
				transfer_message('error', 'No se han ingresado los datos necesarios para crear el articulo');
				redirect('almacen/nuevo');
			}
			
		}else{
			transfer_message('error', 'No se han ingresado los datos necesarios para crear el articulo');
			redirect('home');
		}
		
	}
	
	public function venta($idcliente = ''){
		
		$this->checkUser();
		
		$data['buscar'] = '';
		$data['ver'] = 'off';
		$data['idcliente'] = '';
		$data['nombre'] = '';
		$data['telefono'] = '';
		
		$this->load->view('almacen/venta', $data);
		
	}
	
	public function buscar(){
		$this->checkUser();
		
		$q = $this->input->post('q');
		
		$this->load->library('almacen/almacen');
		$almacen = new Almacen();
		
		$data['results'] = $almacen->buscarArticulo($q);
		
		$this->load->view('almacen/ajax/busqueda', $data);
		
	}
	
	public function insertar(){
		$this->checkUser();
		
		$idarticulo = $this->input->post('idarticulo');
		$data['i'] = $this->input->post('i');
		
		$this->load->library('almacen/articulo');
		$articulo = new Articulo();
		
		if($articulo->cargarArticulo($idarticulo)){
			$data['idarticulo'] = $articulo->getId();
			$data['contrato'] = $articulo->getContrato();
			$data['articulo'] = $articulo->getArticulo();
			$data['valorcompra'] = $articulo->getValorCompra();
			$data['valorventa'] = $articulo->getValorVenta();
			$data['cantidad'] = $articulo->getDisponibilidad();
			
			$this->load->view('almacen/ajax/insertar', $data);
		}else{
			return '';
		}
		
	}
	
	public function gasto(){
		$this->checkUser();
		
		$this->load->library('almacen/gasto');
		$gasto = new Gasto();
		
		$inicial = date('Y-m-').'01';
		$final = date('Y-m-d');
		
		$data['tiposgasto'] = $gasto->getTiposGasto();
		$data['gastos'] = $gasto->informeGastos($inicial, $final, '');
		
		$this->load->view('almacen/gasto', $data);
	}

	public function guardargasto(){
		$this->checkUser();
		
		if($this->input->post('guardar')){
			
			$usr = $this->session->userdata('usr');
			
			$this->load->library('almacen/gasto');
			$gasto = new Gasto();
			
			$gasto->setValor($this->input->post('valor'));
			$gasto->setTipoGasto($this->input->post('tipogasto'));
			$gasto->setConcepto($this->input->post('concepto'));
			$gasto->setUsuario($usr['idusuario']);
			
			if($gasto->guardar()){
				transfer_message('info', 'Se ha guardado el gasto exitosamente');
				redirect('home');
			}else{
				transfer_message('error', 'Ocurrio un error al guardar el gasto');
				redirect('almacen/gasto');
			}
			
		}else{
			transfer_message('error', 'No se han ingresado los datos necesarios');
			redirect('almacen/gasto');
		}
	}
	
	public function checkout(){
		$this->checkUser();
		
		if($nroproductos = $this->input->post('nroproductos')){
			
			$this->load->library('cliente/cliente');
			$cliente = new Cliente();
			
			if(!$cliente->cargarCliente($this->input->post('idcliente'))){
				transfer_message('error', 'El cliente ingresado no existe');
				redirect('almacen/venta');
			}
			
			$this->load->library('almacen/articulo');
			$articulos = array();
			$total = 0;
			
			for($i = 1; $i <= $nroproductos; $i++){
				if($id = $this->input->post('idarticulo_'.$i)){
					$articulo = new Articulo();
					if($articulo->cargarArticulo($id)){
						if($articulo->getDisponibilidad() > 0){
							$articulo->setValorVendido($this->input->post('valorventa_'.$i));
							$articulo->setCantidad('1');
							$total += $articulo->getValorVendido();
							$articulos[] = $articulo;
						}
					}
				}
			}
			
			if(sizeof($articulos) > 0){
				$usr = $this->session->userdata('usr');
				$this->load->library('almacen/notacobro');
				$this->load->library('contrato/contrato');
				$nc = new NotaCobro();
				$nc->setCliente($cliente->getId());
				$nc->setUsuario($usr['idusuario']);
				$nc->setTotal($total);
				$nc->setGarantia($this->input->post('garantia'));
				if($nc->guardarNota()){
					foreach($articulos as $articulo){
						$nc->guardarDetalle($articulo);
						$articulo->disminuirCantidad('1');
						if($articulo->getContrato() != ''){
							$contrato = new Contrato();
							$contrato->cargarContrato($articulo->getContrato());
							$contrato->setVendido();
						}
					}
					// Ha terminado de ingresar todo a la base de datos
					$this->session->set_flashdata('idnotacobro', $nc->getId());
					redirect('almacen/imprimir');
					
				}
			}
			
		}else{
			transfer_message('error', 'Es necesario que ingrese los productos a vender');
			redirect('almacen/venta');
		}
	}

	function imprimir($idnota = ''){
		$this->checkUser();
		
		if($idnota == ''){
			$id = $this->input->post('idnotacobro');
			
			if($id){
				$idnotacobro = $id;
			}else if($id = $this->session->flashdata('idnotacobro')){
				$idnotacobro = $id;
			}else{
				transfer_message('error', 'No se ha ingresado una nota para imprimir');
				redirect('home');
			}
		}else{
			$idnotacobro = $idnota;
		}
		
		$this->load->library('almacen/notacobro');
		$nc = new NotaCobro();
		
		if($nc->cargarNotaCobro($idnotacobro)){
			
			$this->load->library('utils/code128');
			$code = new Code128();
			$data['coder'] = $code;
			
			$data['idnotacobro'] = $nc->getId();
			$data['fecha'] = $nc->getFecha();
			$data['garantia'] = $nc->getGarantia();
			
			$this->load->library('main');
			$main = new Main();
			
			$data['nombreEmpresa'] = $main->getNombre();
			$data['nitEmpresa'] = $main->getNit();
			$data['direccionEmpresa'] = $main->getDireccion();
			$data['ciudadEmpresa'] = $main->getCiudad();
			$data['telefonoEmpresa'] = $main->getTelefono();
			$data['razonsocial'] = $main->getRazonSocial();
			$data['logo'] = $main->getLogoImg();
			
			$this->load->library('cliente/cliente');
			$cliente = new Cliente();
			$cliente->cargarCliente($nc->getCliente());
			
			$data['idcliente'] = $cliente->getId();
			$data['nombreCliente'] = $cliente->getNombre();
			$data['tipoidCliente'] = $cliente->getTipoIdNombre();
			$data['lugarExpedicion'] = $cliente->getLugarExpedicion();
			$data['ciudadDomicilio'] = $cliente->getCiudad();
			$data['telefonoCliente'] = $cliente->getTelefono();
			$data['tipoid'] = $cliente->getTipoId();
			
			$data['detalles'] = $nc->getDetalles();
			
			$this->load->view('almacen/imprimir', $data);
			
		}else{
			transfer_message('error', 'No se ha ingresado ninguna nota para imprimir');
			redirect('home');
		}
	}

	function ver($idnota = ''){
		$this->checkUser();
		
		if($idnota == ''){
			$id = $this->input->post('idnotacobro');
			
			if($id){
				$idnotacobro = $id;
			}else if($id = $this->session->flashdata('idnotacobro')){
				$idnotacobro = $id;
			}else{
				transfer_message('error', 'No se ha ingresado una nota para imprimir');
				redirect('home');
			}
		}else{
			$idnotacobro = $idnota;
		}
		
		$this->load->library('almacen/notacobro');
		$nc = new NotaCobro();
		
		if($nc->cargarNotaCobro($idnotacobro)){
			
			$this->load->library('utils/code128');
			$code = new Code128();
			$data['coder'] = $code;
			
			$data['idnotacobro'] = $nc->getId();
			$data['fecha'] = $nc->getFecha();
			$data['garantia'] = $nc->getGarantia();
			
			$this->load->library('main');
			$main = new Main();
			
			$data['nombreEmpresa'] = $main->getNombre();
			$data['nitEmpresa'] = $main->getNit();
			$data['direccionEmpresa'] = $main->getDireccion();
			$data['ciudadEmpresa'] = $main->getCiudad();
			$data['telefonoEmpresa'] = $main->getTelefono();
			$data['razonsocial'] = $main->getRazonSocial();
			$data['logo'] = $main->getLogoImg();
			
			$this->load->library('cliente/cliente');
			$cliente = new Cliente();
			$cliente->cargarCliente($nc->getCliente());
			
			$data['idcliente'] = $cliente->getId();
			$data['nombreCliente'] = $cliente->getNombre();
			$data['telefonoCliente'] = $cliente->getTelefono();
			
			$data['detalles'] = $nc->getDetalles();
			
			$this->load->view('almacen/ver', $data);
			
		}else{
			transfer_message('error', 'No se ha ingresado ninguna nota para imprimir');
			redirect('home');
		}
	}
		
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */