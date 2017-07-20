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
		
		.sub_content {
			margin-top: 10px;
		}
		
		.sub_content .big_wrap {
			margin-left: 0;
			margin-right: 10px;
		}
		
		#contratos, #notas {
			font-size: 12px;
		}
		
		#contratos .contrato {
			text-align: center;
			width: 65px;
		}
		
		#contratos .fecha {
			width: 65px;
		}
		
		#contratos .articulo {
			width: 240px;
		}
		
		#contratos .valor {
			text-align: center;
			width: 80px;
		}
		
		#contratos .estado {
			text-align: center;
			width: 110px;
		}
		
		#notas .notacobro {
			text-align: center;
			width: 80px;
		}
		
		#notas .fecha {
			width: 65px;
		}
		
		#notas .valor {
			text-align: center;
			width: 85px;
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
			
			<div class="module">
				<a class="small_box purple newcontract" href="<?=site_url('contrato/nuevo/'.$cliente->getId())?>"><h2>Nuevo Contrato</h2></a>
			</div>
			
		</div>
		
		<div class="big_wrap">
			
			<div id="ajax_cliente" class="big_box blue off"></div>
			
			<div class="module datoscliente">
				<div class="big_box blue">
					<h2>Datos de Cliente</h2>
					<form name="frm_editar" method="post" action="<?=site_url('cliente/editar')?>">
						
						<table class="form">
							<tr>
								<td><label>Nro Identificacion *</label></td>
								<td><input type="text" required="required" name="idcliente" id="cl_idcliente" class="s_idcliente" placeholder="Nro Identificaci&oacute;n" value="<?=$cliente->getId()?>" /></td>
								<td class="space"><label>Tipo Documento *</label></td>
								<td>
									<select name="tipoid">
										<?php
											foreach($tipos as $key => $value){
												if($cliente->getTipoId() == $key){
													echo '<option value="'.$key.'" selected="selected">'.$value.'</option>';
												}else{
													echo '<option value="'.$key.'">'.$value.'</option>';
												}
											}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td><label>Lugar Expedici&oacute;n *</label></td>
								<td>
									<input type="text" required="required" name="lugarexpedicion" id="cl_lugarexpedicion" class="s_ciudad" placeholder="Lugar Expedicion" onkeyup="buscarCiudad('lugarexpedicion')" value="<?=$cliente->getLugarExpedicion()?>" />
								</td>
								<td colspan="2">
									<div id="ajax_lugarexpedicion"></div>
								</td>
							</tr>
							<tr>
								<td><label>Nombre *</label></td>
								<td colspan="3"><input type="text" required="required" name="nombre" id="cl_nombre" class="s_nombre" placeholder="Nombre del cliente" value="<?=$cliente->getNombre()?>" /></td>
							</tr>
							<tr>
								<td><label>Direcci&oacute;n</label></td>
								<td colspan="3"><input type="text" name="direccion" id="cl_direccion" class="s_direccion" placeholder="Direcci&oacute;n" value="<?=$cliente->getDireccion()?>" /></td>
							</tr>
							<tr>
								<td><label>Telefono</label></td>
								<td><input type="text" name="telefono" id="cl_telefono" class="s_telefono" placeholder="Telefono" value="<?=$cliente->getTelefono()?>" /></td>
								<td class="space"><label>Celular</label></td>
								<td><input type="text" name="celular" id="cl_celular" class="s_telefono" placeholder="Celular" value="<?=$cliente->getCelular()?>" /></td>
							</tr>
							<tr>
								<td><label>Ciudad Domicilio *</label></td>
								<td>
									<input type="text" required="required" name="ciudad" id="cl_ciudad" class="s_ciudad" placeholder="Ciudad" onkeyup="buscarCiudad('ciudad')" value="<?=$cliente->getCiudad()?>" />
								</td>
								<td colspan="2">
									<div id="ajax_ciudad"></div>
								</td>
							</tr>
							<tr>
								<td><label>Email</label></td>
								<td colspan="3"><input type="text" name="email" id="cl_email" class="s_email" placeholder="Correo Electronico" value="<?=$cliente->getEmail()?>" /></td>
							</tr>
							<tr>
								<td colspan="4" class="buttons">
									<input type="submit" class="green_button" name="editar" value="Editar" />
								</td>
							</tr>
						</table>
						
					</form>
				</div>
			</div>
			
			
		</div>
		
	</div>
	
	<div class="sub_content">
		
		<div class="big_wrap">
			
			<div class="module">
				<div id="contratos" class="big_box purple">
					<h2>Contratos (<?=$contratos->num_rows()?>)</h2>
					<?php
						if($contratos->num_rows() >= 1){
					?>
					<table class="format" cellspacing="0">
						<thead>
							<tr>
								<th class="contrato">Contrato</th>
								<th class="fecha">Fecha</th>
								<th class="articulo">Art&iacute;culo</th>
								<th class="valor">Valor</th>
								<th class="estado">Estado</th>
								<th class="valor">Prorrogas</th>
							</tr>
						</thead>
						<tbody>
						<?php
								$total = 0;
								$totalprorrogas = 0;
								$i = 1;
								
								foreach($contratos->result_array() as $c){
									if($c['estado'] == Contrato::CANCELADO){
										$estado = $c['descripcion'].'<p><strong>$ '.number_format($c['valorcancelado']).'</strong></p>';
									}else{
										$estado = $c['descripcion'];
									}
									$total += $c['valor'];
									$totalprorrogas += $c['prorrogas'];
									if($i % 2 == 0){$class=' class="even"';}else{$class='';}
						?>
									<tr<?=$class?>>
										<td class="contrato"><a href="<?=site_url('contrato/ver/'.$c['idcontrato'])?>"><?=$c['idcontrato']?></a></td>
										<td class="fecha"><?=$c['fechaingreso']?></td>
										<td class="articulo"><?=$c['articulo']?></td>
										<td class="valor">$ <?=number_format($c['valor'])?></td>
										<td class="estado"><?=$estado?></td>
										<td class="valor">$ <?=number_format($c['prorrogas'])?></td>
									</tr>
						<?php
									$i++;
								}
						?>
								<tr>
									<th colspan="3">Totales</th>
									<th class="valor">$ <?=number_format($total)?></th>
									<th class="estado">&nbsp;</th>
									<th class="valor">$ <?=number_format($totalprorrogas)?></th>
								</tr>
							</tbody>
						</table>
					<?php
						}else{
					?>
							<div class="buttons"><h3>El cliente no ha realizado ning&uacute;n contrato</h3></div>
					<?php	
						}
					?>
				</div>
			</div>
			
		</div>
		
		<div class="small_wrap">
			<div class="module">
				<div id="notas" class="small_box orange">
					<h2>Compras (<?=$compras->num_rows()?>)</h2>
					<?php
						if($compras->num_rows() >= 1){
					?>
					<table class="format" cellspacing="0">
						<thead>
							<tr>
								<th class="notacobro">Nota Cobro</th>
								<th class="fecha">Fecha</th>
								<th class="valor">Valor</th>
							</tr>
						</thead>
						<tbody>
					<?php
							$total = 0;
							$i = 1;
						
							foreach($compras->result_array() as $c){
								$total += $c['total'];
								if($i % 2 == 0){$class=' class="even"';}else{$class='';}
					?>
						<tr<?=$class?>>
							<td class="notacobro"><a href="<?=site_url('almacen/ver/'.$c['idnotacobro'])?>"><?=$c['idnotacobro']?></a></td>
							<td class="fecha"><?=$c['fecha']?></td>
							<td class="valor">$ <?=number_format($c['total'])?></td>
						</tr>
					<?php
								$i++;
							}
					?>
						<tr>
							<th colspan="2">Totales</th>
							<th class="valor">$ <?=number_format($total)?></th>
						</tr>
						</tbody>
					</table>
					<?php
						}else{
					?>
						<div class="buttons"><h3>El cliente no ha realizado ning&uacute;na compra</h3></div>
					<?php	
						}
					?>
				</div>
			</div>
		</div>
		
	</div>
	
	<form name="frm_ver" id="frm_ver" method="post" action="<?= site_url('cliente/ver') ?>">
		<input type="hidden" name="idcliente" id="q_idcliente" value="" />
	</form>
	
	<?=read_message()?>
	
</body>