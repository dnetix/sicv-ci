<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario {
	
	private $idusuario;
	private $nombre;
	private $rol;
	private $password;
	private $email;
	private $telefono;
	private $activo;
	
	const ADMINISTRADOR = '6';
	
	public function __construct(){
		$this->idusuario = '';
		$this->nombre = '';
		$this->rol = 0;
	}
	
	public function getRol(){
		return $this->rol;
	}
	
	public function getNombre(){
		return $this->nombre;
	}
	
	public function getUsername(){
		return $this->idusuario;
	}
	
	public function getEmail(){
		return $this->email;
	}
	
	public function getTelefono(){
		return $this->telefono;
	}
	
	public function isActivo(){
		return $this->activo == '1' ? TRUE : FALSE; 
	}
	
	private function getPassword(){
		return $this->password;
	}
	
	public function setRol($rol){
		$this->rol = $rol;
	}
	
	public function setNombre($nombre){
		$this->nombre = $nombre;
	}
	
	public function setTelefono($telefono){
		$this->telefono = $telefono;
	}
	
	public function setEmail($email){
		$this->email = $email;
	}
	
	public function setUsername($username){
		$this->idusuario = $username;
	}
	
	public function getArraySession(){
		return array(
			'idusuario' => $this->idusuario,
			'nombre' => $this->nombre,
			'rol' => $this->rol
		);
	}
	
	public function setFromSession($array){
		$this->idusuario = $array['idusuario'];
		$this->nombre = $array['nombre'];
		$this->rol = $array['rol'];
	}
	
	public function cargarUsuario($idusuario){
		$CI =& get_instance();
		$query = 'SELECT * FROM usuario WHERE idusuario = '.$CI->db->escape($idusuario);
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
	
	public function editarUsuario(){
		$CI =& get_instance();
		
		$fields = array('nombre', 'telefono', 'email');
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
		
		$query = 'UPDATE usuario SET '.implode(', ', $values).' WHERE idusuario = '.$CI->db->escape($this->getUsername());
		
		$CI->db->query($query);
		
		if($CI->db->affected_rows() >= 1){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	public function cambiarContrasena($oldpass, $newpass){
		$CI =& get_instance();
		
		$_oldpass = $CI->security->hashEncrypt($oldpass);
		$_newpass = $CI->security->hashEncrypt($newpass);
		
		if($this->getPassword() == $_oldpass){
			$query = 'UPDATE usuario SET password = '.$CI->db->escape($_newpass).' WHERE idusuario = '.$CI->db->escape($this->getUsername()).' LIMIT 1';
			
			$CI->db->query($query);
			
			if($CI->db->affected_rows() >= 1){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
		
	}
	
}
