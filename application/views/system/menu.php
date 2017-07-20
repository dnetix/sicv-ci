<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="Diego Calle">
	<title>Men&uacute; Principal -SICV-</title>
	<link rel="stylesheet" href="<?=base_url("assets/css/base.css")?>" />
	<link href="<?=base_url('assets/img/favicon.ico')?>" rel="shortcut icon" />
	<script src="<?=base_url('assets/js/jquery-1.9.1.min.js')?>"></script>
	<script src="<?=base_url('assets/js/base.js')?>"></script>
	
	<script>
		var t;
		var del = 20000; 
		$(document).mousemove(function(){
			clearTimeout(t);
			//when the mouse is moved
			t = setTimeout(function(){
				//If the mouse is not moved
				$('#qsearch').focus();
			}, del);
		});
	</script>
	
</head>
<body>
	
	<?=$this->load->view('ads/header')?>
	
	
	
	<div id="main_container">
		
		<div id="left_container">
			<h1>Configuraciones</h1>
			
			<h2>Usuario</h2>
			<ul class="inner_menu">
				<li><a href="<?=site_url('usuario/editar')?>">Editar mis datos</a></li>
			</ul>
			
			<?php
				if($rol >= Usuario::ADMINISTRADOR){
			?>
			<h2>Sistema</h2>
			<ul class="inner_menu">
				<li><a href="<?=site_url('sistema/datos')?>">Editar datos Compraventa</a></li>
			</ul>
			<?php
				}
			?>
		</div>
		<div id="right_container">
			
		</div>
		
	</div>
	
	<?=read_message()?>
	
</body>