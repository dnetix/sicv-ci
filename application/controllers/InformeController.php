<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class InformeController extends CI_Controller {
	
	public function vencidos(){
		
		$this->checkUser();
		
		$this->load->library('contrato/contratoFactory');
		$cf = new ContratoFactory();
		
		if($this->input->post('filter')){
			$data['results'] = $cf->getContratosVencidos($this->input->post('tipoarticulo'), $this->input->post('ordenarpor', TRUE), $this->input->post('orden'));
		}else{
			$data['results'] = $cf->getContratosVencidos();
		}
		
		$this->load->library('almacen/articulo');
		$art = new Articulo();
		$data['tiposarticulo'] = $art->getTiposArticulo();
		
		$this->load->view('informe/vencidos', $data);
		
	}
	
	public function activos(){
		
		$this->checkUser();
		
		$this->load->library('contrato/contratoFactory');
		$cf = new ContratoFactory();
		
		$data['inicial'] = $this->input->post('inicial');
		$data['final'] = $this->input->post('final');
		
		if($this->input->post('filter')){
			$data['results'] = $cf->getContratosActivos($this->input->post('tipoarticulo'), $this->input->post('ordenarpor', TRUE), $this->input->post('orden'), $data['inicial'], $data['final']);
			$data['contratos'] = TRUE;
		}else{
			$data['contratos'] = FALSE;
		}
		
		$data['totales'] = $cf->getTotalesContratosActivos();
		
		$this->load->library('almacen/articulo');
		$art = new Articulo();
		$data['tiposarticulo'] = $art->getTiposArticulo();
		
		$this->load->view('informe/contratosactivos', $data);
		
	}
	
	public function vendidos(){
		$this->checkUser();
		
		$this->load->library('almacen/almacen');
		$almacen = new Almacen();
		
		if($this->input->post('filter')){
			
			$inicial = $this->input->post('inicial');
			$final = $this->input->post('final');
						
		}else{
			$inicial = date('Y-m-').'01';
			$final = date('Y-m-d');
		}
		$data['inicial'] = $inicial;
		$data['final'] = $final;
		
		if($this->input->post('filter')){
			$data['results'] = $almacen->getArticulosVendidos($this->input->post('tipoarticulo'), $this->input->post('ordenarpor', TRUE), $this->input->post('orden'), $data['inicial'], $data['final']);
		}else{
			$data['results'] = $almacen->getArticulosVendidos();
		}
		
		$this->load->library('almacen/articulo');
		$art = new Articulo();
		$data['tiposarticulo'] = $art->getTiposArticulo();
		
		$this->load->view('informe/articulosvendidos', $data);
	}
	
	public function prorroga(){
		$this->checkUser();
		
		require_once(APPPATH.'libraries/contrato/prorrogaFactory.php');
		
		if($this->input->get('filter')){
			
			$inicial = $this->input->get('inicial');
			$final = $this->input->get('final');
						
		}else{
			$inicial = date('Y-m-').'01';
			$final = date('Y-m-d');
		}
		$data['inicial'] = $inicial;
		$data['final'] = $final;
		
		$data['results'] = ProrrogaFactory::informeProrrogas($data);
		
		$this->load->view('informe/prorrogas', $data);
	}
	
	public function presacas(){
		
		$this->checkUser();
		
		$this->load->library('contrato/contratoFactory');
		$cf = new ContratoFactory();
		
		$data['results'] = $cf->getPresacas();
		
		$this->load->view('informe/presacas', $data);
		
	}
	
	public function articulosventa(){
		$this->checkUser();
		
		$this->load->library('almacen/almacen');
		$almacen = new Almacen();
		
		if($this->input->post('filter')){
			$data['results'] = $almacen->getArticulosParaVenta($this->input->post('tipoarticulo'), $this->input->post('ordenarpor', TRUE), $this->input->post('orden'));
		}else{
			$data['results'] = $almacen->getArticulosParaVenta();
		}
		
		$this->load->library('almacen/articulo');
		$art = new Articulo();
		$data['tiposarticulo'] = $art->getTiposArticulo();
		
		$this->load->view('informe/articuloventa', $data);
	}

	public function financiero(){
		
		if($this->input->post('filter')){
			
			$inicial = $this->input->post('inicial');
			$final = $this->input->post('final');
						
		}else{
			$inicial = date('Y-m-d 00:00:00');
			$final = date('Y-m-d 23:59:59');
		}
		
		$this->load->library('almacen/almacen');
		$this->load->library('contrato/contratoFactory');
		
		$almacen = new Almacen();
		$cf = new ContratoFactory();
		
		$data['contratos'] = $cf->getTotalContratos($inicial, $final);
		$data['prorrogas'] = $cf->getTotalProrrogas($inicial, $final);
		$data['cancelaciones'] = $cf->getTotalCancelaciones($inicial, $final);
		$data['gastos'] = $almacen->getTotalGastos($inicial, $final);
		$data['compras'] = $almacen->getTotalCompras($inicial, $final);
		$data['ventas'] = $almacen->getTotalVentas($inicial, $final);
		
		$data['inicial'] = $inicial;
		$data['final'] = $final;
		
		$this->load->view('informe/financiero', $data);
		
	}
	
	public function gastos(){
		
		if($this->input->post('filter')){
			
			$inicial = $this->input->post('inicial');
			$final = $this->input->post('final');
						
		}else{
			$inicial = date('Y-m-').'01';
			$final = date('Y-m-d');
		}
		$data['inicial'] = $inicial;
		$data['final'] = $final;
		
		$this->load->library('almacen/gasto');
		
		$gasto = new Gasto();
		
		$data['tipogasto'] = $this->input->post('tipogasto');
		$data['tiposgasto'] = $gasto->getTiposGasto();
		$data['gastos'] = $gasto->informeGastos($inicial, $final, $data['tipogasto']);
		
		$this->load->view('informe/gastos', $data);
		
	}
	
	public function sacados(){
		
		if($this->input->post('filter')){
			
			$inicial = $this->input->post('inicial');
			$final = $this->input->post('final');
						
		}else{
			$inicial = date('Y-m-').'01';
			$final = date('Y-m-d');
		}
		$data['inicial'] = $inicial;
		$data['final'] = $final;
		
		$this->load->library('almacen/articulo');
		$art = new Articulo();
		$data['tiposarticulo'] = $art->getTiposArticulo();
		
		$this->load->library('contrato/contratoFactory');
		
		$contrato = new ContratoFactory();
		
		$data['results'] = $contrato->contratosSacados($inicial, $final, $this->input->post('tipoarticulo'), $this->input->post('ordenarpor', TRUE), $this->input->post('orden'));
		
		$this->load->view('informe/contratossacados', $data);
		
	}
	
	public function cancelados(){
		
		if($this->input->post('filter')){
			
			$inicial = $this->input->post('inicial');
			$final = $this->input->post('final');
						
		}else{
			$inicial = date('Y-m-').'01';
			$final = date('Y-m-d');
		}
		$data['inicial'] = $inicial;
		$data['final'] = $final;
		
		$this->load->library('almacen/articulo');
		$art = new Articulo();
		$data['tiposarticulo'] = $art->getTiposArticulo();
		
		$this->load->library('contrato/contratoFactory');
		
		$contrato = new ContratoFactory();
		
		$data['results'] = $contrato->contratosCancelados($inicial, $final, $this->input->post('tipoarticulo'), $this->input->post('ordenarpor', TRUE), $this->input->post('orden'));
		
		$this->load->view('informe/contratoscancelados', $data);
		
	}
	
	public function stats_contrato(){
		
		if($this->input->post('filter')){
			$data['ano'] = $this->input->post('ano');
		}else{
			$data['ano'] = date('Y');
		}
		
		$this->load->library('contrato/contratoFactory');
		
		$cf = new ContratoFactory();
		
		$data['results'] = $cf->getEstadisticasXAno($data['ano']);
		
		$xAxis = array();
		$yAxis = array();
		
		foreach($data['results']->result_array() as $mes){
			$xAxis[] = get_month_name($mes['mes'], TRUE, TRUE);
			$yAxis[] = $mes['totalmes'];
		}
		
		$data['xAxis'] = implode('\', \'', $xAxis);
		$data['yAxis'] = implode(', ', $yAxis);
		
		$this->load->view('estadistico/contratosano', $data);
		
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
