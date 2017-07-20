<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Anulacion {
	
	private $idanulacion;
	private $motivo;
	private $fecha;
	private $usuario;
	
	public function __construct(){
		$this->fecha = date('Y-m-d');
	}
	
	public function getId(){
		return $this->idanulacion;
	}
	
	public function getMotivo(){
		return $this->motivo;
	}
	
	public function getFecha(){
		return $this->fecha;
	}
	
	public function getUsuario(){
		return $this->usuario;
	}
	
	public function setMotivo($motivo){
		$this->motivo = $motivo;
	}
	
	public function setUsuario($usuario){
		$this->usuario = $usuario;
	}
	
	public function cargarAnulacion($idanulacion){
		$CI =& get_instance();
		$query = 'SELECT * FROM anulacion WHERE idanulacion = '.$CI->db->escape($idanulacion);
		
		$result = $CI->db->query($query);
		
		if($result->num_rows() >= 1){
			
			$rs = $result->row_array();
			foreach($rs as $key => $value){
				$this->$key = $value;
			}
			return TRUE;
			
		}else{
			return FALSE;
		}
	}

	public function guardarAnulacion(){
		$CI =& get_instance();
		
		$fields = array('motivo', 'fecha', 'usuario');
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
		
		$query = 'INSERT INTO anulacion ('.implode(', ', $fields).') VALUES ('.implode(', ', $values).')';
		
		$CI->db->query($query);
		
		if($CI->db->affected_rows() >= 1){
			$this->idanulacion = $CI->db->insert_id();
			return TRUE; 
		}else{
			return FALSE;
		}
	}
	
}
