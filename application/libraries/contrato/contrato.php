<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contrato {
	
	private $idcontrato;
	private $cliente;
	private $articulo;
	private $tipoarticulo;
	private $peso;
	private $fechaingreso;
	private $valor;
	private $estado;
	private $fechasalida;
	private $nromeses = 4;
	private $porcentaje = 10;
	private $valorcancelado = '';
	private $anulacion = '';
	private $usuario = '';
	
	private $prorroga = '';
	
	const ORO = '2';
	
	const ACTIVO = '1';
	const CANCELADO = '2';
	const ALMACEN = '3';
	const VENDIDO = '4';
	const CHATARRIZADO = '5';
	const PROBLEMALEGAL = '6';
	const ANULADO = '7';
	
	public function __construct(){
		$this->estado = Contrato::ACTIVO;
		$this->fechaingreso = date('Y-m-d H:i:s');
	}
	
	public function setId($idcontrato){
		$this->idcontrato = $idcontrato;
	}
	
	public function setCliente($cliente){
		$this->cliente = $cliente;
	}
	
	public function setArticulo($articulo){
		$this->articulo = $articulo;
	}
	
	public function setTipoArticulo($tipoarticulo){
		$this->tipoarticulo = $tipoarticulo;
	}
	
	public function setFechaIngreso($fecha){
		$this->fechaingreso = $fecha;
	}
	
	public function setPeso($peso){
		$this->peso = $peso;
	}
	
	public function setValor($valor){
		$this->valor = $valor;
	}
	
	public function setEstado($estado){
		$this->estado = $estado;
	}
	
	public function setFechaSalida($fecha){
		$this->fechasalida = $fecha;
	}
	
	public function setNroMeses($meses){
		$this->nromeses = $meses;
	}
	
	public function setPorcentaje($porcentaje){
		$this->porcentaje = $porcentaje;
	}
	
	public function setValorCancelado($valor){
		$this->valorcancelado = $valor;
	}
	
	public function setUsuario($usuario){
		$this->usuario = $usuario;
	}
	
	public function getCliente(){
		return $this->cliente;
	}
	
	public function getId(){
		return $this->idcontrato;
	}
	
	public function getArticulo(){
		return $this->articulo;
	}
	
	public function getTipoArticulo(){
		return $this->tipoarticulo;
	}
	
	public function getPeso(){
		return $this->peso;
	}
	
	public function getFechaIngreso(){
		return $this->fechaingreso;
	}
	
	public function getFechaSalida(){
		return $this->fechasalida;
	}
	
	public function getValor(){
		return $this->valor;
	}
	
	public function getValorCancelado(){
		return $this->valorcancelado;
	}
	
	public function getValorProrroga(){
		return floor($this->valor * ($this->porcentaje / 100));
	}
	
	public function getAnulacion(){
		return $this->anulacion;
	}
	
	public function getFechaVencimiento(){
		$this->cargarProrrogas();
		
		$nromesesprorrogados = $this->prorroga->getTotalMeses();
		
		$m = floor($this->nromeses + $nromesesprorrogados);
		
		if($m >= 0){
			$m = '+'.$m;
		}
		
		return date('Y-m-d', strtotime($this->fechaingreso.' '.$m.' months'));
	}
	
	public function getNroMeses(){
		return $this->nromeses;
	}
	
	public function getEstado(){
		return $this->estado;
	}
	
	public function getMesesProrrogados(){
		$this->cargarProrrogas();
		return $this->prorroga->getTotalMeses();
	}
	
	public function getMesesTranscurridos(){
		if($this->getEstado() == Contrato::ACTIVO){
			return (month_diff($this->getFechaIngreso()) + 1);
		}else{
			return (month_diff($this->getFechaIngreso(), $this->getFechaSalida()) + 1);
		}
		
	}
	
	public function getValorCancelacion(){
		return ((($this->getMesesTranscurridos() - $this->getMesesProrrogados()) * $this->getValorProrroga()) + $this->getValor()); 
	}
	
	public function getProrrogas(){
		$this->cargarProrrogas();
		return $this->prorroga->getProrrogas();
	}
	
	public function getPorcentaje(){
		return $this->porcentaje;
	}
	
	public function crearContrato(){
		
		$CI =& get_instance();
		
		$fields = array('cliente', 'articulo', 'tipoarticulo', 'peso', 'fechaingreso', 'valor', 'estado', 'nromeses', 'porcentaje', 'usuario');
		$noescape = array();
		$values = array();
		
		foreach($fields as $campo){
			
			if($this->$campo != ''){
				
				if(!in_array($campo, $noescape)){
					$values[] = $CI->db->escape($this->$campo);
				}else{
					$values[] = $this->$campo;
				}
				
			}else{
				
				$values[] = 'NULL';
				
			}
			
		}
		
		$query = 'INSERT INTO contrato ('.implode(', ', $fields).') VALUES ('.implode(', ', $values).')';
		
		$CI->db->query($query);
		
		if($CI->db->affected_rows() >= 1){
			$this->idcontrato = $CI->db->insert_id();
			return TRUE; 
		}else{
			return FALSE;
		}
				
	}
	
	public function cargarContrato($idcontrato){
		
		$CI =& get_instance();
		
		$query = 'SELECT * FROM contrato WHERE idcontrato = '.$CI->db->escape($idcontrato);
		
		$contrato = $CI->db->query($query);
		
		if($contrato->num_rows() >= 1){
			
			$ct = $contrato->row_array();
			foreach($ct as $key => $value){
				$this->$key = $value;
			}
			return TRUE;
			
		}else{
			return FALSE;
		}
		
	}
	
	private function cargarProrrogas(){
		if(!is_object($this->prorroga)){
			$CI =& get_instance();
			$CI->load->library('contrato/prorroga');
			$this->prorroga = new Prorroga();
			$this->prorroga->getProrrogasContrato($this->getId());
		}
	}
	
	public function cancelarContrato($valorCancelado){
		if($this->getEstado() == Contrato::ACTIVO){
			$CI =& get_instance();
			$query = 'UPDATE contrato SET fechasalida = NOW(), estado = '.$CI->db->escape(Contrato::CANCELADO).', valorcancelado = '.$CI->db->escape($valorCancelado).' WHERE idcontrato = '.$CI->db->escape($this->getId()).' LIMIT 1';
			$CI->db->query($query);
			
			if($CI->db->affected_rows() == 1){
				return TRUE;
			}else{
				return FALSE;
			}
			
		}else{
			return FALSE;
		}
	}
	
	public function anularContrato(Anulacion $anulacion){
		if($this->getEstado() == Contrato::ACTIVO){
			$CI =& get_instance();
			$query = 'UPDATE contrato SET fechasalida = NOW(), estado = '.$CI->db->escape(Contrato::ANULADO).', valor = '.$CI->db->escape('0').', anulacion = '.$CI->db->escape($anulacion->getId()).' WHERE idcontrato = '.$CI->db->escape($this->getId()).' LIMIT 1';
			$CI->db->query($query);
			
			if($CI->db->affected_rows() == 1){
				return TRUE;
			}else{
				return FALSE;
			}
			
		}else{
			return FALSE;
		}
	}
	
	public function moverAlmacen(){
		if($this->getEstado() == Contrato::ACTIVO){
			$CI =& get_instance();
			$query = 'UPDATE contrato SET fechasalida = NOW(), estado = '.$CI->db->escape(Contrato::ALMACEN).', valorcancelado = '.$CI->db->escape('0').' WHERE idcontrato = '.$CI->db->escape($this->getId()).' LIMIT 1';
			$CI->db->query($query);
			
			if($CI->db->affected_rows() == 1){
				return TRUE;
			}else{
				return FALSE;
			}
			
		}else{
			return FALSE;
		}
	}
	
	public function setVendido(){
		$CI =& get_instance();
		
		if($this->getFechaSalida() != ''){
			$query = 'UPDATE contrato SET estado = '.$CI->db->escape(Contrato::VENDIDO).' WHERE idcontrato = '.$CI->db->escape($this->getId()).' LIMIT 1';
		}else{
			$query = 'UPDATE contrato SET fechasalida = NOW(), estado = '.$CI->db->escape(Contrato::VENDIDO).', valorcancelado = '.$CI->db->escape('0').' WHERE idcontrato = '.$CI->db->escape($this->getId()).' LIMIT 1';
		}
		
		$CI->db->query($query);
		
		if($CI->db->affected_rows() == 1){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	public function setChatarra(){
		$CI =& get_instance();
		
		$query = 'UPDATE contrato SET fechasalida = NOW(), estado = '.$CI->db->escape(Contrato::CHATARRIZADO).', valorcancelado = '.$CI->db->escape('0').' WHERE idcontrato = '.$CI->db->escape($this->getId()).' LIMIT 1';
		
		$CI->db->query($query);
		
		if($CI->db->affected_rows() == 1){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	public function esPresaca(){
		$CI =& get_instance();
		$query = 'SELECT * FROM presaca WHERE contrato = '.$CI->db->escape($this->getId());
		$sql = $CI->db->query($query);
		if($sql->num_rows() == 1){
			return $sql->result_array();
		}else{
			return FALSE;
		}
	}

	public function getInfoVenta(){
		$CI =& get_instance();
		$query = 'SELECT idnotacobro, fecha, valor, cliente AS idcliente 
			FROM articulosvendidos WHERE contrato = '.$CI->db->escape($this->getId());
		$sql = $CI->db->query($query);
		if($sql->num_rows() == 1){
			return $sql->row_array();
		}else{
			return FALSE;
		}
	} 

	public function removerPresaca(){
		$CI =& get_instance();
		$query = 'DELETE FROM presaca WHERE contrato = '.$CI->db->escape($this->getId());
		$CI->db->query($query);
		if($CI->db->affected_rows() == 1){
			return TRUE;
		}else{
			return FALSE;
		}
	}
}
