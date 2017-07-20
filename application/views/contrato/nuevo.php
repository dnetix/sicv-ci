<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="Diego Calle">
	<title>Nuevo Contrato -SICV-</title>
	<link rel="stylesheet" href="<?=base_url("assets/css/base.css")?>" />
	<link href="<?=base_url('assets/img/favicon.ico')?>" rel="shortcut icon" />
	<script src="<?=base_url('assets/js/jquery-1.9.1.min.js')?>"></script>
	<script src="<?=base_url('assets/js/base.js')?>"></script>
	<script src="<?=base_url('assets/js/ajax.js')?>"></script>
	<script>
		
		var timer;
	
		function updateVencimiento(){
			var fecha = new Date();
			fecha.setMonth(fecha.getMonth() + parseInt($("#mesescontrato").val()));
			$("#fvencimiento").val(getStringFecha(fecha));
		}
		
		function updateProrroga(){
			if($("#showvalor").val() != ""){
				setMoneyValue("showvalor", "valor");
				
				var valor = parseInt($("#valor").val());
				var porcentaje = parseFloat($("#show_porcentaje").val());
				porcentaje = porcentaje / 100;
				
				$("#prorroga").val(parseInt(valor * porcentaje));
				
				setMoneyValue("prorroga", "");
			}
		}
		
		function updatePeso(){
			temp = parseFloat($("#peso").val());
			if(isNaN(temp)){
				alert("El peso debe ser un valor númerico");
				$("#peso").focus();
			}else{
				$("#peso").val(temp);
			}
		}
		
		function buscarCliente(q){
			clearTimeout(timer);
			timer = setTimeout(function () {
				$("#ajax_cliente").slideDown('fast');
				doSearchCliente(q.value);
			}, 1000);
		}
		
		function seleccionarCliente(idcliente, nombre, telefono){
			$("#txt_client_q").val("");
			$("#buscarcliente").slideUp("fast");
			$("#idcliente").val(idcliente);
			$("#q_idcliente").val(idcliente);
			$("#nombre").val(nombre);
			$("#telefono").val(telefono);
			$("#infocliente").slideDown("fast");
			$("#ajax_cliente").slideUp("fast");
			$("#articulo")[0].focus();
		}
		
		function removeCliente(){
			$("#buscarcliente").slideDown("fast");
			$("#idcliente").val("");
			$("#q_idcliente").val("");
			$("#nombre").val("");
			$("#telefono").val("");
			$("#infocliente").slideUp("fast");
		}
		
		function historiaCliente(){
			$("#frm_ver").submit();
		}
		
		function validar(){
			var temp;
			temp = parseInt($("#mesescontrato").val())
			if(isNaN(temp)){
				alert("El numero de meses debe ser un numero entero");
				$("#mesescontrato").focus();
				return 0;
			}
			$("#nromeses").val(temp);
			
			temp = parseFloat($("#show_porcentaje").val());
			if(isNaN(temp)){
				alert("El porcentaje debe ser un numero decimal o entero");
				$("#show_porcentaje").focus();
				return 0;
			}
			$("#porcentaje").val(temp);
			
			if($("#idcliente").val() == ""){
				alert("Debe seleccionar un cliente para realizar el contrato");
				$("#showid").focus();
				return 0;
			}
			
			if($("#tipoarticulo").val() == ""){
				alert("Debe seleccionar un tipo de articulo");
				$("#tipoarticulo").focus();
				return 0;
			}else if($("#tipoarticulo").val() == "2"){
				temp = parseFloat($("#peso").val());
				if(isNaN(temp)){
					alert("Debe ingresar un peso para el oro");
					$("#peso").focus();
					return 0;
				}else{
					$("#peso").val(temp);
				}
			}
			
			document.frm_nuevocontrato.submit();
		}
		
	</script>
	
	<style>
		#tipocontrato table {
			width: 190px;
			margin: auto;
		}
		
		#tipocontrato tr td:first-child {
			padding-right: 15px;
		}
		
		.big_wrap {
			margin-left: 0;
			margin-right: 10px;
		}
		
		#botonescontrato {
			margin-top: 20px;
		}
		
		#botonescontrato input {
			width: 180px;
		}
		
			#infocliente table .buttons {
				text-align: right;
			}
			
		tr td:first-child label {
			display: inline-block;
			width: 120px;
		}
	</style>
	
</head>
<body>
	
	<?=$this->load->view('ads/header')?>
	
	<div id="main_container">
		
		<h1>Nuevo Contrato</h1>
		
		<div class="big_wrap">
			<form name="frm_nuevocontrato" method="post" onreset="removeCliente()" action="<?=site_url('contrato/guardar')?>">
			
				<div class="module">
					<div id="buscarcliente" class="big_box blue <?= $buscar ?>">
						<table>
							<tr>
								<td><label for="txt_client_q">Buscar Cliente</label></td>
								<td><input type="text" id="txt_client_q" class="s_nombre" placeholder="Identificaci&oacute;n o Nombre" autocomplete="off" onkeyup="buscarCliente(this)" /></td>
							</tr>
						</table>
					</div>
				</div>
				
				<div class="module">
					<div id="infocliente" class="big_box blue <?= $ver ?>">
						<h2>Datos Cliente</h2>
						<table>
							<tr>
								<td><label>Identificaci&oacute;n</label></td>
								<td><input type="text" name="idcliente" id="idcliente" class="s_idcliente" readonly="readonly" value="<?= $idcliente ?>" /></td>
								<td colspan="2" class="buttons">
									<input type="button" onclick="historiaCliente()" class="green_button" value="Historial" />
									<input type="button" onclick="removeCliente()" class="red_button" value="Cambiar" />
								</td>
							</tr>
							<tr>
								<td><label>Nombre</label></td>
								<td><input type="text" name="nombre" id="nombre" class="s_nombre" readonly="readonly" value="<?= $nombre ?>" /></td>
								<td class="space"><label>Tel&eacute;fono</label></td>
								<td><input type="text" id="telefono" class="s_telefono" readonly="readonly" value="<?= $telefono ?>" /></td>
							</tr>
						</table>
					</div>
				</div>
				
				<div class="module">
					<div id="ajax_cliente" class="big_box blue"></div>
				</div>
				
				<div class="module">
					<div id="datoscontrato" class="big_box purple">
						<h2>Informaci&oacute;n Contrato</h2>
						<table class="form">
							<tr>
								<td><label>Articulo</label></td>
								<td colspan="3"><textarea name="articulo" id="articulo" class="s_articulo"></textarea></td>
							</tr>
							<tr>
								<td><label>Tipo de Articulo</label></td>
								<td>
									<select name="tipoarticulo" id="tipoarticulo" class="s_tipoarticulo">
										<option value="">Tipo de articulo</option>
										<?php
											foreach($tiposarticulo as $tipo){
												echo '<option value="'.$tipo['idtipoarticulo'].'">'.$tipo['tipoarticulo'].'</option>';
											}
										?>
									</select>
								</td>
								<td><label>Peso</label></td>
								<td><input type="text" name="peso" id="peso" class="s_peso" onchange="updatePeso()" /> gramos</td>
							</tr>
							<tr>
								<td><label>Valor</label></td>
								<td><input type="text" id="showvalor" onchange="updateProrroga()" class="s_valor" /></td>
								<td><label>Valor Abono</label></td>
								<td><input type="text" name="prorroga" id="prorroga" readonly="readonly" class="s_valor" /></td>
							</tr>
							<tr>
								<td><label>Fecha Contrato</label></td>
								<td><input type="text" name="fecha" readonly="readonly" value="<?=date('Y-m-d H:i:s')?>" class="s_datetime" /></td>
								<td><label>Fecha Venc.</label></td>
								<td><input type="text" name="fvencimiento" id="fvencimiento" readonly="readonly" class="s_fecha" value="<?=date('Y-m-d', strtotime('now +'.$nroMeses.' months'))?>" /></td>
							</tr>
						</table>
					</div>
				</div>
				
				<div id="botonescontrato" class="module">
					<div class="buttons">
						<input type="hidden" name="valor" id="valor" />
						<input type="hidden" name="nromeses" id="nromeses" />
						<input type="hidden" name="porcentaje" id="porcentaje" />
						
						<input type="button" class="blue_button" value="Guardar" onclick="validar()" />
						<input type="reset" class="red_button" value="Cancelar" />
					</div>
				</div>
				
			</form>
		</div>
		
		
		<div class="small_wrap">
			<div class="module">
				<div id="tipocontrato" class="small_box purple">
					<h2>Tipo de Contrato</h2>
					<table class="form">
						<tr>
							<td>Meses Contrato</td>
							<td><input type="text" id="mesescontrato" value="<?=$nroMeses?>"  onchange="updateVencimiento()" class="s_meses" /></td>
						</tr>
						<tr>
							<td>Porcentaje Compra</td>
							<td><input type="text" id="show_porcentaje" value="<?=$porcentaje?>" onchange="updateProrroga()" class="s_porcentaje" /></td>
						</tr>
					</table>
				</div>
			</div>
		</div>

	</div>
	
	<form name="frm_ver" id="frm_ver" method="post" target="_blank" action="<?= site_url('cliente/ver') ?>">
		<input type="hidden" name="idcliente" id="q_idcliente" value="<?= $idcliente ?>" />
	</form>
	
	<?=read_message()?>
	
</body>