<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cliente {
	
	private $idcliente = '';
	private $tipoid = '';
	private $nombre = '';
	private $direccion = '';
	private $telefono = '';
	private $celular = '';
	private $email = '';
	private $lugarexpedicion = '';
	private $ciudad = '';
	
	private $_tipos;
	
	public function __construct(){
		$this->_tipos = array('CC' => 'Cédula de ciudadania', 'CE' => 'Cédula de extranjeria');
	}
	
	public function setId($idcliente){
		$this->idcliente = $idcliente;
	}
	
	public function setTipoId($tipoid){
		$this->tipoid = $tipoid;
	}
	
	public function setNombre($nombre){
		$this->nombre = $nombre;
	}
	
	public function setDireccion($direccion){
		$this->direccion = $direccion;
	}
	
	public function setLugarExpedicion($lugarexpedicion){
		$this->lugarexpedicion = $lugarexpedicion;
	}
	
	public function setTelefono($telefono){
		$this->telefono = $telefono;
	}
	
	public function setCelular($celular){
		$this->celular = $celular;
	}
	
	public function setCiudad($ciudad){
		$this->ciudad = $ciudad;
	}
	
	public function setEmail($email){
		$this->email = $email;
	}
	
	public function getId(){
		return $this->idcliente;
	}
	
	public function getTipoId(){
		return $this->tipoid;
	}
	
	public function getNombre(){
		return $this->nombre;
	}
	
	public function getDireccion(){
		return $this->direccion;
	}
	
	public function getLugarExpedicion(){
		return $this->lugarexpedicion;
	}
	
	public function getTelefono(){
		return $this->telefono;
	}
	
	public function getCelular(){
		return $this->celular;
	}
	
	public function getCiudad(){
		return $this->ciudad;
	}
	
	public function getEmail(){
		return $this->email;
	}
	
	public function cargarCliente($idcliente){
		$CI =& get_instance();
		
		$query = 'SELECT * FROM cliente WHERE idcliente = '.$CI->db->escape($idcliente);
		
		$cliente = $CI->db->query($query);
		
		if($cliente->num_rows() >= 1){
			
			$ct = $cliente->row_array();
			
			foreach($ct as $key => $value){
				$this->$key = $value;
			}
			return TRUE;
			
		}else{
			return FALSE;
		}
	}
	
	public function buscarCliente($client_q){
		
		$CI =& get_instance();
		
		if($client_q != ''){
			$q = explode(' ', $client_q);
			$qs = array();
			foreach($q as $value) {
				$qs[] = '(idcliente LIKE '.$CI->db->escape($value.'%').' OR nombre LIKE '.$CI->db->escape('%'.$value.'%').')';
			}
		}
		
		$query = 'SELECT idcliente, nombre, telefono FROM cliente WHERE '.implode(' AND ', $qs).' LIMIT 15';
		
		return $CI->db->query($query);
		
	}
	
	public function getTipoIdNombre(){
		return $this->_tipos[$this->tipoid];
	}
	
	public function getTiposId(){
		return $this->_tipos;
	}
	
	public function buscarCiudad($nombre){
		$CI =& get_instance();
		$query = 'SELECT DISTINCT lugarexpedicion AS ciudad FROM cliente WHERE lugarexpedicion LIKE '.$CI->db->escape('%'.$nombre.'%').' LIMIT 15';
		return $CI->db->query($query);
	}
	
	public function guardarCliente(){
		$CI =& get_instance();
		
		$fields = array('idcliente', 'tipoid', 'nombre', 'direccion', 'telefono', 'celular', 'email', 'lugarexpedicion', 'ciudad');
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
		
		$query = 'INSERT INTO cliente ('.implode(', ', $fields).') VALUES ('.implode(', ', $values).')';
		
		$CI->db->query($query);
		
		if($CI->db->affected_rows() >= 1){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	public function editarCliente(){
		$CI =& get_instance();
		
		$fields = array('tipoid', 'nombre', 'direccion', 'telefono', 'celular', 'email', 'lugarexpedicion', 'ciudad');
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
		
		$query = 'UPDATE cliente SET '.implode(', ', $values).' WHERE idcliente = '.$CI->db->escape($this->getId());
		
		$CI->db->query($query);
		
		if($CI->db->affected_rows() >= 1){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
}
