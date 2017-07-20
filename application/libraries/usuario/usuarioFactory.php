<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UsuarioFactory {
	
	public function autenteticarUsuario($username, $password){
		
		$CI = get_instance();
		
		$password = $CI->security->hashEncrypt($password);
		
		$query = 'SELECT * FROM usuario WHERE idusuario = '.$CI->db->escape($username).' AND password = '.$CI->db->escape($password).' AND activo = '.$CI->db->escape('1');
		$usrinfo = $CI->db->query($query);
		
		if($usrinfo->num_rows() == 1){
			
			$usrinfo = $usrinfo->row_array();
			
			$CI->load->library('usuario/Usuario');
			
			$usr = new Usuario();
			$usr->setUsername($username);
			$usr->setNombre($usrinfo['nombre']);
			$usr->setRol($usrinfo['rol']);
			
			return $usr;
			
		}else{
			
			return FALSE;
			
		}
		
	}
	
}
