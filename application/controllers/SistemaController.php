<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SistemaController extends CI_Controller {

	public function qsearch(){
		$q = $this->input->post('qsearch');
		if($to = strstr($q, 'NC')){
			redirect('almacen/ver/'.substr($to, 2));
		}else if($to = strstr($q, 'CL')){
			redirect('cliente/ver/'.substr($to, 2));
		}else{
			redirect('contrato/ver/'.$q);
		}
		
	}
	
	public function menu(){
		$this->checkUser();
		
		$usr = $this->session->userdata('usr');
		
		$this->load->library('usuario/usuario');
		
		$data['rol'] = $usr['rol'];
		
		$this->load->view('system/menu', $data);
	}
	
	public function datos(){
		$this->checkUser(6);
		
		$usr = $this->session->userdata('usr');
		
		$this->load->library('usuario/usuario');
		
		$this->load->library('main');
		$main = new Main();
		
		$this->load->library('utils/code128');
		$code = new Code128();
		$data['coder'] = $code;
		
		$data['nombreEmpresa'] = $main->getNombre();
		$data['nitEmpresa'] = $main->getNit();
		$data['direccionEmpresa'] = $main->getDireccion();
		$data['ciudadEmpresa'] = $main->getCiudad();
		$data['telefonoEmpresa'] = $main->getTelefono();
		$data['razonsocial'] = $main->getRazonSocial();
		$data['logo'] = $main->getLogoImg();
		
		$this->load->view('system/datos', $data);
	}
	
	public function cambiardatos(){
		$this->checkUser(6);
		
		$this->load->library('main');
		$main = new Main();
		
		if($this->input->post('actualizar')){
			$main->setRazonSocial($this->input->post('razonsocial'));
			$main->setNombre($this->input->post('nombre'));
			$main->setNit($this->input->post('nit'));
			$main->setDireccion($this->input->post('direccion'));
			$main->setTelefono($this->input->post('telefono'));
			$main->setCiudad($this->input->post('ciudad'));
			
			$config['upload_path'] = './assets/img/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '1024';
			$config['max_width']  = '2048';
			$config['max_height']  = '2048';
			
			$image = FALSE;
			
			$this->load->library('upload', $config);
			if($this->upload->do_upload('logotipo')){
				unset($config);
				
				$img = $this->upload->data();
				
				$config['image_library'] = 'gd2';
				$config['source_image'] = $img['full_path'];
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 200;
				$config['height'] = 100;
				
				$this->load->library('image_lib', $config);
				if($this->image_lib->resize()){
					$image = TRUE;
				}else{
					transfer_message('error', 'Error al redimensionar la imagen: '.$this->image_lib->display_errors());
					redirect('sistema/datos');
				}
			}
			
			if($image){
				$main->setLogo($img['file_name']);
			}
			
			if($main->actualizar()){
				transfer_message('info', 'Se han actualizado los datos');
				redirect('sistema/datos');
			}else{
				transfer_message('info', 'No se ha actualizado ningun dato');
				redirect('home');
			}

		}
	}
	
	public function checkupdate(){
		$this->checkUser(6);
		
		$appinfo = simplexml_load_file(SYSDIR.'/config.xml');
		$version = simplexml_load_file(SYSDIR.'/version.xml');

		$respuesta = file_get_contents('http://sicvcontrol.construccioncreativa.cc/checkupdate.php?id='.$appinfo->idbuyer.'&version='.$version->version);
		$datos = simplexml_load_string($respuesta);
		
		if($datos->update == '1'){
			
			/** EN CASO DE REALIZAR UN UPDATE **/
			$external_zip = $datos->zip_url;
			$destination_zip = 'assets/update/'.$datos->updatename;
			
			if(copy($external_zip, $destination_zip)){
				/* CARGA EL ARCHIVO DE SU RUTA DE ORIGEN Y LO EXTRAE A PARTIR DEL DIRECTORIO ACTUAL */
				$zip = new ZipArchive;
				if ($zip->open($destination_zip) === TRUE) {
					$zip->extractTo('./');
					$zip->close();
					$upg_sw = 1;
				} else {
					$upg_sw = 0;
				}
				
				if($datos->dophp != 0){
					$this->session->set_flashdata('phpfile', $datos->dophp);
					redirect('sistema/dophp');
				}else{
					transfer_message('info', 'Se ha actualizado la aplicaci&oacute;n');
					redirect('home');
				}
				
			}else{
				transfer_message('error', 'Ha ocurrido un error al copiar el archivo zip');
				redirect('home');
			}
			
		}else{
			transfer_message('info', 'No hay actualizaciones por realizar, su aplicaci&oacute;n ya se encuentra actualizada');
			redirect('home');
		}
		
	}

	public function dophp(){
		require('assets/update/'.$this->session->flashdata('phpfile'));
		redirect('home');
	}
	
	public function getpreciooro(){
		$datos = file_get_contents('http://www.goldpricerate.com/spanish/gold-price-in-colombia.php');
		$datos = preg_replace('/[\s]?\n[\s]?/', '', $datos);
		preg_match('/<div id="gold_today">.*<\/table>.*\*/', $datos, $matches);
		$datos = trim($matches[0], "*"); 
		print_r('<div class="module">'.$datos.'</div></div>');
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
