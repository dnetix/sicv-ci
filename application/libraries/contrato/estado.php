<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estado {
	
	private $estados;
	
	private $_arrayEstados;
	
	private function cargarEstados(){
		if(!is_object($this->estados)){
			$CI =& get_instance();
			$query = 'SELECT * FROM estado';
			$this->estados = $CI->db->query($query);
			
			foreach($this->estados->result_array() as $estado){
				$this->_arrayEstados[$estado['idestado']] = $estado['descripcion'];
			}
			
		}
	}
	
	public function getNombreEstado($idestado){
		$this->cargarEstados();
		return $this->_arrayEstados[$idestado];
	}
	
}
