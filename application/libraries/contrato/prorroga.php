<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prorroga {
		
	private $contrato;
	private $fecha;
	private $hora;
	private $valor;
	private $nromeses;
	private $usuario;
	
	private $prorrogas;
	/**
	 * Totalizadas
	 */
	private $totalmeses;
	
	public function __construct(){
		$this->fecha = date('Y-m-d');
		$this->hora = date('H:i:s');
	}
	
	public function setContrato($idcontrato){
		$this->contrato = $idcontrato;
	}
	
	public function setValor($valor){
		$this->valor = $valor;
	}
	
	public function setNroMeses($nromeses){
		$this->nromeses = $nromeses;
	}
	
	public function setUsuario($usuario){
		$this->usuario = $usuario;
	}
	
	public function getProrrogasContrato($idcontrato){
		$CI =& get_instance();
		$query = "SELECT * FROM prorroga WHERE contrato = ".$CI->db->escape($idcontrato);
		$this->prorrogas = $CI->db->query($query);
		$this->totalizarProrrogas();
	}
	
	private function totalizarProrrogas(){
		
		$this->totalmeses = 0;
		
		foreach($this->prorrogas->result_array() as $prorroga){
			$this->totalmeses += $prorroga['nromeses'];
		}
		
	}
	
	public function guardarProrroga(){
		
		$CI =& get_instance();
		
		$fields = array('contrato', 'fecha', 'hora', 'valor', 'nromeses', 'usuario');
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
		
		$query = 'INSERT INTO prorroga ('.implode(', ', $fields).') VALUES ('.implode(', ', $values).')';
		
		$CI->db->query($query);
		
		if($CI->db->affected_rows() >= 1){
			return $CI->db->insert_id(); 
		}else{
			return FALSE;
		}
		
	}
	
	public function getTotalMeses(){
		return $this->totalmeses;
	}
	
	public function getProrrogas(){
		return $this->prorrogas;
	}
	
}
