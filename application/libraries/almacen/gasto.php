<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gasto {
	
	private $idgasto;
	private $usuario;
	private $fecha;
	private $valor;
	private $concepto;
	private $tipogasto;
		
	private $_tiposgasto;
	
	public function __construct(){
		$this->fecha = date('Y-m-d H:i:s');
	}
	
	public function setUsuario($usuario){
		$this->usuario = $usuario;
	}
	
	public function setFecha($fecha){
		$this->fecha = $fecha;
	}
	
	public function setValor($valor){
		$this->valor = $valor;
	}
	
	public function setConcepto($concepto){
		$this->concepto = $concepto;
	}
	
	public function setTipoGasto($tipo){
		$this->tipogasto = $tipo;
	}
	
	public function getTiposGasto(){
		$this->cargarTiposGasto();
		return $this->_tiposgasto;
	}
	
	private function cargarTiposGasto(){
		
		if(!is_array($this->_tiposgasto)){
			$CI =& get_instance();
			$query = 'SELECT * FROM tipogasto';
			$tg = $CI->db->query($query);
			
			foreach($tg->result_array() as $tipo){
				$this->_tiposgasto[$tipo['idtipogasto']] = $tipo['descripcion'];
			}
		}
	}
	
	public function guardar(){
		
		$CI =& get_instance();
		$fields = array('usuario', 'fecha', 'valor', 'concepto', 'tipogasto');
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
		$query = 'INSERT INTO gasto ('.implode(', ', $fields).') VALUES ('.implode(', ', $values).')';
		$CI->db->query($query);
		if($CI->db->affected_rows() >= 1){
			$this->idgasto = $CI->db->insert_id();
			return TRUE;
		}else{
			return FALSE;
		}
	
	}
	
	public function informeGastos($finicial, $ffinal, $tipogasto){
		$CI =& get_instance();
		
		$query = 'SELECT idgasto, usuario, nombre, fecha, valor, concepto, gasto.tipogasto AS idtipogasto, tipogasto.descripcion AS tipogasto 
			FROM gasto JOIN tipogasto ON gasto.tipogasto = tipogasto.idtipogasto 
			JOIN usuario ON gasto.usuario = usuario.idusuario 
			WHERE fecha BETWEEN '.$CI->db->escape($finicial).' AND '.$CI->db->escape($ffinal);
		
		if($tipogasto !== FALSE && $tipogasto != ''){
			$query .= ' AND gasto.tipogasto = '.$CI->db->escape($tipogasto);
		}
			
		return $CI->db->query($query);
	}
	
}
