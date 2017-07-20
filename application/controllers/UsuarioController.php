<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UsuarioController extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function login(){
		
		$username = $this->input->post('username', TRUE);
		$password = $this->input->post('password', TRUE);
		
		if($username && $password){
			
			$this->load->database();
			
			$this->load->library('usuario/UsuarioFactory');
			
			$uf = new UsuarioFactory();
			$usr = $uf->autenteticarUsuario($username, $password);
			
			if($usr){
				$this->session->set_userdata('usr', $usr->getArraySession());
				redirect('home');
			}else{
				$this->session->unset_userdata('usr');
				transfer_message('error', 'El nombre de usuario o contraseña no coinciden');
				redirect('init/index');
			}
			
		}else{
			$this->session->unset_userdata('usr');
			transfer_message('error', 'No se han ingresado los datos necesarios para el login');
			redirect('init/index');
		}
		
	}
	
	public function cerrarsesion(){
		$this->session->unset_userdata('usr');
		transfer_message('info', 'Ha cerrado sesión exitosamente');
		redirect('init/index');
	}
	
	public function editar(){
		$this->checkUser();
		
		$s_usr = $this->session->userdata('usr');
		
		$this->load->library('usuario/usuario');
		$usr = new Usuario();
		
		if($usr->cargarUsuario($s_usr['idusuario'])){
			
			if($this->input->post('editar')){
				
				$usr->setNombre($this->input->post('nombre'));
				$usr->setTelefono($this->input->post('telefono'));
				$usr->setEmail($this->input->post('email'));
				
				$newpass = $this->input->post('newpass');
				
				$cambio = FALSE;
				
				if($newpass && $newpass != ''){
					if($usr->cambiarContrasena($this->input->post('oldpass'), $this->input->post('newpass'))){
						$cambio = TRUE;
					}
				}

				if($usr->editarUsuario()){
					$cambio = TRUE;
				}
				
				if($cambio){
					transfer_message('info', 'Se han editado los datos de usuario');
					redirect('home');
				}else{
					transfer_message('info', 'No se ha realizado ningun cambio');
					redirect('home');
				}
				
			}
			
			$data['idusuario'] = $usr->getUsername();
			$data['nombre'] = $usr->getNombre();
			$data['email'] = $usr->getEmail();
			$data['telefono'] = $usr->getTelefono();
			
		}else{
			transfer_message('error', 'No existe el usuario a editar');
			redirect('home');
		}
		
		$this->load->view('usuario/editar', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */