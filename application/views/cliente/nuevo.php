<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="Diego Calle">
	<title>Vista de Cliente -SICV-</title>
	<link href="<?=base_url('assets/img/favicon.ico')?>" rel="shortcut icon" />
	
	<link rel="stylesheet" href="<?=base_url("assets/css/base.css")?>" />
	
	<script src="<?=base_url('assets/js/jquery-1.9.1.min.js')?>"></script>
	<script src="<?=base_url('assets/js/base.js')?>"></script>
	<script src="<?=base_url('assets/js/ajax.js')?>"></script>
	<script>
		var timer;
		function buscarCiudad(field){
			clearTimeout(timer);
			timer = setTimeout(function () {
				$("#ajax_"+field).slideDown('fast');
				doBuscarCiudad($("#"+field).val(), field);
			}, 1000);
		}
		
		function selectCiudad(nombre, field){
			$("#ajax_"+field).slideUp('fast');
			$("#"+field).val(nombre);
		}
		
		function buscarCliente(q){
			clearTimeout(timer);
			timer = setTimeout(function () {
				if(q.value.length == 0){
					$("#ajax_cliente").slideUp('fast');
				}else{
					$("#ajax_cliente").slideDown('fast');
					doSearchCliente(q.value);
				}
			}, 1000);
		}
		
		function seleccionarCliente(idcliente, nombre, telefono){
			$("#q_idcliente").val(idcliente);
			$("#frm_ver").submit();
		}
		
		function validar(){
			
		}
	</script>
	<style>
		.datoscliente .buttons {
			padding-top: 20px;
		}
		
		.datoscliente .buttons input {
			width: 180px;
		}
	</style>
</head>
<body>
	
	<?=$this->load->view('ads/header')?>
	
	<div id="main_container">
		
		<div class="small_wrap">
			
			<div class="module">
				<div class="small_box blue">
					<div class="icon client">
						&nbsp;
					</div>
					<div class="content">
						<h2>Historial de Clientes</h2>
						<input type="text" id="client_q" class="s_idcliente" placeholder="Identificaci&oacute;n o Nombre" autocomplete="off" onkeyup="buscarCliente(this)" />
						<form method="post" action="<?=site_url('cliente/ver')?>" id="frm_cliente">
							<input type="hidden" name="idcliente" id="idcliente" />
						</form>
					</div>
				</div>
			</div>
			
		</div>
		
		<div class="big_wrap">
			
			<div id="ajax_cliente" class="big_box blue off"></div>
			
			<div class="module datoscliente <?= $estado ?>">
				<div class="big_box blue">
					<h2>Datos de Cliente</h2>
					<form name="frm_editar" method="post" action="<?=site_url('cliente/docrear')?>">
						
						<table class="form">
							<tr>
								<td><label>Nro Identificacion *</label></td>
								<td><input type="text" required="required" name="idcliente" id="cl_idcliente" class="s_idcliente" placeholder="Nro Identificaci&oacute;n" /></td>
								<td class="space"><label>Tipo Documento *</label></td>
								<td>
									<select name="tipoid">
										<?php
											foreach($tipos as $key => $value){
												echo '<option value="'.$key.'">'.$value.'</option>';
											}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td><label>Lugar Expedici&oacute;n *</label></td>
								<td>
									<input type="text" required="required" name="lugarexpedicion" id="cl_lugarexpedicion" class="s_ciudad" placeholder="Lugar Expedicion" onkeyup="buscarCiudad('lugarexpedicion')" />
								</td>
								<td colspan="2">
									<div id="ajax_lugarexpedicion"></div>
								</td>
							</tr>
							<tr>
								<td><label>Nombre *</label></td>
								<td colspan="3"><input type="text" required="required" name="nombre" id="cl_nombre" class="s_nombre" placeholder="Nombre del cliente" /></td>
							</tr>
							<tr>
								<td><label>Direcci&oacute;n</label></td>
								<td colspan="3"><input type="text" name="direccion" id="cl_direccion" class="s_direccion" placeholder="Direcci&oacute;n" /></td>
							</tr>
							<tr>
								<td><label>Telefono</label></td>
								<td><input type="text" name="telefono" id="cl_telefono" class="s_telefono" placeholder="Telefono" /></td>
								<td class="space"><label>Celular</label></td>
								<td><input type="text" name="celular" id="cl_celular" class="s_telefono" placeholder="Celular" /></td>
							</tr>
							<tr>
								<td><label>Ciudad Domicilio *</label></td>
								<td>
									<input type="text" required="required" name="ciudad" id="cl_ciudad" class="s_ciudad" placeholder="Ciudad" onkeyup="buscarCiudad('ciudad')" />
								</td>
								<td colspan="2">
									<div id="ajax_ciudad"></div>
								</td>
							</tr>
							<tr>
								<td><label>Email</label></td>
								<td colspan="3"><input type="text" name="email" id="cl_email" class="s_email" placeholder="Correo Electronico" /></td>
							</tr>
							<tr>
								<td colspan="4" class="buttons">
									<input type="submit" class="green_button" name="guardar" value="Guardar" />
								</td>
							</tr>
						</table>
						
					</form>
				</div>
			</div>
			
			
		</div>
		
	</div>
	
	<form name="frm_ver" id="frm_ver" method="post" action="<?= site_url('cliente/ver') ?>">
		<input type="hidden" name="idcliente" id="q_idcliente" value="" />
	</form>
	
	<?=read_message()?>
	
</body>