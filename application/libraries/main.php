<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main {
	
	private $razonsocial;
	private $nit;
	private $nombre;
	private $direccion;
	private $telefono;
	private $ciudad;
	private $logo;
	
	public function __construct(){
		$CI =& get_instance();
		$query = 'SELECT * FROM config WHERE idconfig = "1"';
		$config = $CI->db->query($query);
		
		if($config->num_rows() >= 1){
			
			$ct = $config->row_array();
			foreach($ct as $key => $value){
				$this->$key = $value;
			}
			return TRUE;
			
		}else{
			return FALSE;
		}
	}
	
	public function getRazonSocial(){
		return $this->razonsocial;
	}
	
	public function getNit(){
		return $this->nit;
	}
	
	public function getNombre(){
		return $this->nombre;
	}
	
	public function getDireccion(){
		return $this->direccion;
	}
	
	public function getTelefono(){
		return $this->telefono;
	}
	
	public function getCiudad(){
		return $this->ciudad;
	}
	
	public function getLogoImg(){
		return $this->logo;
	}
	
	public function setRazonSocial($rz){
		$this->razonsocial = $rz;
	}
	
	public function setNombre($nombre){
		$this->nombre = $nombre;
	}
	
	public function setDireccion($direccion){
		$this->direccion = $direccion;
	}
	
	public function setNit($nit){
		$this->nit = $nit;
	}
	
	public function setTelefono($telefono){
		$this->telefono = $telefono;
	}
	
	public function setCiudad($ciudad){
		$this->ciudad = $ciudad;
	}
	
	public function setLogo($logo){
		$this->logo = $logo;
	}
	
	public function actualizar(){
		$CI =& get_instance();
		
		$fields = array('razonsocial', 'nit', 'nombre', 'direccion', 'telefono', 'ciudad', 'logo');
		$noescape = array();
		$values = array();
		
		foreach($fields as $campo){
			if($this->$campo != ''){
				if(!in_array($campo, $noescape)){
					$values[] = $campo.' = '.$CI->db->escape($this->$campo);
				}else{
					$values[] = $campo.' = '.$this->$campo;
				}
			}
		}
		
		$query = 'UPDATE config SET '.implode(', ', $values).' WHERE idconfig = '.$CI->db->escape('1');
		
		$CI->db->query($query);
		
		if($CI->db->affected_rows() >= 1){
			return TRUE;
		}else{
			return FALSE;
		}
	}
}
