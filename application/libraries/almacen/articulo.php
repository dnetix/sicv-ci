<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articulo {
	
	private $idarticulo;
	private $contrato = '';
	private $articulo;
	private $tipoarticulo;
	private $fechaingreso;
	private $valorcompra;
	private $valorventa;
	private $disponible;
	
	private $_valorvendido;
	private $_cantidad;
	
	public function __construct(){
		$this->valorcompra = 10;
		$this->fechaingreso = date('Y-m-d');
	}
	
	public function setContrato($contrato){
		$this->contrato = $contrato;
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
	
	public function setValorCompra($valor){
		$this->valorcompra = $valor;
	}
	
	public function setValorVenta($valor){
		$this->valorventa = $valor;
	}
	
	public function setDisponibilidad($disponibilidad){
		$this->disponible = $disponibilidad;
	}
	
	public function setValorVendido($valor){
		$this->_valorvendido = $valor;
	}
	
	public function getId(){
		return $this->idarticulo;
	}
	
	public function getContrato(){
		return $this->contrato;
	}
	
	public function getArticulo(){
		return $this->articulo;
	}
	
	public function getValorCompra(){
		return $this->valorcompra;
	}
	
	public function getValorVenta(){
		return $this->valorventa;
	}
	
	public function getDisponibilidad(){
		return $this->disponible;
	}
	
	public function getValorVendido(){
		return $this->_valorvendido;
	}
	
	public function setCantidad($cantidad){
		$this->_cantidad = $cantidad;
	}
	
	public function getCantidad(){
		return $this->_cantidad;
	}
	
	public function guardarArticulo(){
		$CI =& get_instance();
		
		$fields = array('contrato', 'articulo', 'tipoarticulo', 'fechaingreso', 'valorcompra', 'valorventa', 'disponible');
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
		
		$query = 'INSERT INTO articulo ('.implode(', ', $fields).') VALUES ('.implode(', ', $values).')';
		
		$CI->db->query($query);
		
		if($CI->db->affected_rows() >= 1){
			$this->idarticulo = $CI->db->insert_id();
			return $this->idarticulo;
		}else{
			return FALSE;
		}
	}
	
	public function cargarArticulo($idarticulo){
		$CI =& get_instance();
		
		$query = 'SELECT * FROM (SELECT idarticulo, contrato, articulo, tipoarticulo, fechaingreso, valorcompra, valorventa, disponible 
			FROM articulosventa WHERE contrato IS NULL
			UNION ALL
			SELECT idarticulo, contrato, articulosventa.articulo, articulosventa.tipoarticulo, articulosventa.fechaingreso, contrato.valor AS valorcompra, valorventa, disponible 
			FROM articulosventa JOIN contrato ON articulosventa.contrato = contrato.idcontrato 
			WHERE articulosventa.contrato IS NOT NULL) AS pv WHERE idarticulo = '.$CI->db->escape($idarticulo);
		print_r($query);
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
	
	public function disminuirCantidad($nrovendidos){
		
		$CI =& get_instance();
		$query = 'UPDATE articulo SET disponible = '.$CI->db->escape($this->getDisponibilidad() - $nrovendidos).' WHERE idarticulo = '.$CI->db->escape($this->getId()).' LIMIT 1';
		$CI->db->query($query);
		
		if($CI->db->affected_rows() >= 1){
			return TRUE;
		}else{
			return FALSE;
		}
		
	}
	
	public function getTiposArticulo(){
		$CI =& get_instance();
		
		$query = "SELECT * FROM tipoarticulo ORDER BY tipoarticulo ASC";
		$ta = $CI->db->query($query);
		
		foreach($ta->result_array() as $tipo){
			$tipos[] = array('idtipoarticulo' => $tipo['idtipoarticulo'], 'tipoarticulo' => $tipo['tipoarticulo']);
		}
		
		return $tipos;
	}
	
	public function getNombreTipo($idtipoarticulo){
		$CI =& get_instance();
		
		$query = "SELECT * FROM tipoarticulo WHERE idtipoarticulo = ".$CI->db->escape($idtipoarticulo);
		$ta = $CI->db->query($query);
		
		$tipo = $ta->row_array();
		
		return $tipo['tipoarticulo'];
	}
	
}
