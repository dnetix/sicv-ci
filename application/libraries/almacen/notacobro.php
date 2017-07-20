<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class NotaCobro {
	
	private $idnotacobro;
	private $cliente;
	private $fecha;
	private $total;
	private $usuario;
	private $garantia;
	
	public function __construct(){
		$this->fecha = date('Y-m-d');
	}
	
	public function getId(){
		return $this->idnotacobro;
	}
	
	public function setCliente($cliente){
		$this->cliente = $cliente;
	}
	
	public function getCliente(){
		return $this->cliente;
	}
	
	public function setFecha($fecha){
		$this->fecha = $fecha;
	}

	public function getFecha(){
		return $this->fecha;
	}
	
	public function setUsuario($usuario){
		$this->usuario = $usuario;
	}

	public function getUsuario(){
		return $this->usuario;
	}
	
	public function setTotal($total){
		$this->total = $total;
	}
	
	public function getTotal(){
		return $this->total;
	}
	
	public function setGarantia($garantia){
		$this->garantia = $garantia;
	}
	
	public function getGarantia(){
		return $this->garantia;
	}
	
	public function guardarNota(){
		$CI =& get_instance();
		
		$fields = array('cliente', 'fecha', 'total', 'usuario', 'garantia');
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
		
		$query = 'INSERT INTO notacobro ('.implode(', ', $fields).') VALUES ('.implode(', ', $values).')';
		$CI->db->query($query);
		if($CI->db->affected_rows() >= 1){
			$this->idnotacobro = $CI->db->insert_id();
			return TRUE;
		}else{
			return FALSE;
		}
		
	}
	
	public function cargarNotaCobro($idnotacobro){
		$CI =& get_instance();
		$query = 'SELECT * FROM notacobro WHERE idnotacobro = '.$CI->db->escape($idnotacobro);
		
		$articulo = $CI->db->query($query);
		if($articulo->num_rows() >= 1){
			
			$ct = $articulo->row_array();
			foreach($ct as $key => $value){
				$this->$key = $value;
			}
			return TRUE;
			
		}else{
			return FALSE;
		}
	}
	
	public function guardarDetalle(Articulo $articulo){
		$CI =& get_instance();
		$query = 'INSERT INTO detalle (articulo, notacobro, valor, cantidad) VALUES ('.$CI->db->escape($articulo->getId()).', '.$CI->db->escape($this->getId()).', '.$CI->db->escape($articulo->getValorVendido()).', '.$CI->db->escape($articulo->getCantidad()).')';
		$CI->db->query($query);
		if($CI->db->affected_rows() >= 1){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	public function getDetalles(){
		$CI =& get_instance();
		$query = 'SELECT idarticulo, articulo.contrato, articulo.articulo, articulo.valorcompra, articulo.valorventa, detalle.valor, detalle.cantidad FROM detalle JOIN articulo ON articulo.idarticulo = detalle.articulo WHERE detalle.notacobro = '.$CI->db->escape($this->getId());
		return $CI->db->query($query);
	}
	
}
