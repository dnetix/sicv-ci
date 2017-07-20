<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="Diego Calle">
	<title>Vista de Contrato -SICV-</title>
	<link rel="stylesheet" href="<?=base_url("assets/css/base.css")?>" />
	<link href="<?=base_url('assets/img/favicon.ico')?>" rel="shortcut icon" />
	<script src="<?=base_url('assets/js/jquery-1.9.1.min.js')?>"></script>
	<script src="<?=base_url('assets/js/base.js')?>"></script>
	<script src="<?=base_url('assets/js/ajax.js')?>"></script>
	<script>
		
		function guardarProrroga(){
			setMoneyValue('show_prorroga_valor', 'valorProrroga');
			var valor = $("#valorProrroga").val();
			if(isNaN(valor) || valor == ""){
				alert("Debe ingresar un valor de prorroga");
				$("#show_prorroga_valor").focus();
				$("#show_prorroga_valor").val("");
				$("#valorProrroga").val("");
				return 0;
			}
			if(valor == 0){
				alert("No se pueden generar prorrogas por $ 0 pesos");
				return 0
			}
			var totalprorrogas = moneyToNumber("prorroga");
			totalprorrogas = totalprorrogas * (parseInt($("#mesestranscurridos").val()) - parseInt($("#mesesprorrogados").val()));
			if(valor > totalprorrogas){
				if(!confirm("Se dispone a cobrar meses adelantados de prorrogas, desea continuar?")){
					return 0;
				}
			}
			if(confirm("Desea guardar el abono?")){
				$("#frm_nuevaprorroga").submit();
			}
		}
		
		function totalProrrogas(){
			var totalprorrogas = moneyToNumber("prorroga");
			totalprorrogas = totalprorrogas * (parseInt($("#mesestranscurridos").val())) - parseInt($("#totalabonado").val());
			$("#show_prorroga_valor").val(totalprorrogas);
			setMoneyValue('show_prorroga_valor', 'valorProrroga');
		}
		
		function cancelarContrato(){
			setMoneyValue("showvalorcancelar", "valorcancelar");
			var valor = $("#valorcancelar").val();
			if(isNaN(valor) || valor == ""){
				alert("Debe ingresar el valor a cancelar");
				$("#showvalorcancelar").focus();
				$("#showvalorcancelar").val("");
				$("#valorcancelar").val("");
				return 0;
			}
			
			if(confirm("Desea cancelar el contrato?")){
				$("#frm_cancelar").submit();
			}
		}
		
		function anularContrato(){
			if(confirm("¿Desea anular el contrato? Este proceso no se puede cancelar")){
				$("#frm_anular").submit();
			}
		}
		
		function moverContrato(){
			if(confirm("¿Desea mover el contrato? Este proceso no se puede cancelar")){
				$("#frm_mover").submit();
			}
		}
		
		function operacion(operacion){
			var idcontrato = $("#idcontrato").val();
			operacionContrato(operacion, idcontrato);
			$("#operacion").slideDown("fast");
		}
		
		function removerPresaca(){
			$("#frm_imprimir").attr('action', SITE_URL+'contrato/removerpresaca');
			$("#frm_imprimir").submit();
		}
		
		function imprimir(){
			$("#frm_imprimir").submit();
		}
		
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
		
			#infocliente table .buttons {
				text-align: right;
			}
			
		tr td:first-child label {
			display: inline-block;
			width: 155px;
		}
		
		.module {
			margin-bottom: 10px;
		}
		
		.wrp_estado {
			width: 120px;
			display: inline-block;
			vertical-align: top;
		}
		
		.wrp_opciones {
			display: inline-block;
			vertical-align: top;
			width: 160px;
		}
		
			.wrp_opciones .format tbody tr:hover {
				cursor: pointer;
			}
			
		.wrp_operaciones {
			display: inline-block;
			vertical-align: top;
			width: 415px;
		}
		
		.wrp_info {
			display: inline-block;
			vertical-align: top;
			width: 575px;
		}
		
		#abonos .fecha {
			width: 270px;
		}
		
		#abonos .valor {
			text-align: center;
			width: 147px;
		}
		
		#abonos input[type="button"] {
			width: 100px;
		}
		
		.vendido th, .anulado th {
			text-align: left;
		}
		
		.vendido td, .anulado td {
			padding: 2px 40px 2px 20px;
		}
		
		.buttons {
			padding-top: 20px;
		}
	</style>
	
</head>
<body>
	
	<?=$this->load->view('ads/header')?>
	
	<div id="main_container">
		
		<h1>Datos de contrato # <?=$idcontrato?></h1>
		
		<div class="big_wrap">
			<div class="module">
				<div id="infocliente" class="big_box blue">
					<h2>Datos Cliente</h2>
					<table>
						<tr>
							<td><label>Identificaci&oacute;n</label></td>
							<td colspan="3">
								<input type="text" name="idcliente" id="idcliente" class="s_idcliente" readonly="readonly" value="<?= $idcliente ?>" />
								<a class="green_button" href="<?=site_url('cliente/ver/'.$idcliente)?>">Historial</a>
							</td>
						</tr>
						<tr>
							<td><label>Nombre</label></td>
							<td><input type="text" name="nombre" id="nombre" class="s_nombre" readonly="readonly" value="<?= $nombreCliente ?>" /></td>
							<td class="space"><label>Tel&eacute;fono</label></td>
							<td><input type="text" id="telefono" class="s_telefono" readonly="readonly" value="<?= $telefonoCliente ?>" /></td>
						</tr>
					</table>
				</div>
			</div>
			
			<div class="module">
				<div id="datoscontrato" class="big_box purple">
					<h2>Informaci&oacute;n Contrato</h2>
					<table class="form">
						<tr>
							<td><label>Articulo</label></td>
							<td colspan="3"><textarea name="articulo" id="articulo" class="s_articulo"><?= $articulo ?></textarea></td>
						</tr>
						<tr>
							<td><label>Tipo de Articulo</label></td>
							<td>
								<input type="text" readonly="readonly" value="<?= $tipoArticulo ?>" class="s_tipoarticulo" />
							</td>
							<td><label>Peso</label></td>
							<td><input type="text" name="peso" id="peso" class="s_peso" value="<?= $peso ?>" /> gramos</td>
						</tr>
						<tr>
							<td><label>Valor</label></td>
							<td><input type="text" id="showvalor" class="s_valor" value="<?= '$ '.number_format($valorContrato) ?>" /></td>
							<td><label>Valor Abono</label></td>
							<td><input type="text" name="prorroga" id="prorroga" readonly="readonly" class="s_valor" value="<?= '$ '.number_format($valorProrroga) ?>" /></td>
						</tr>
						<tr>
							<td><label>Fecha Contrato</label></td>
							<td><input type="text" name="fecha" readonly="readonly" value="<?= $fechaIngreso ?>" class="s_datetime" /></td>
							<td><label>Fecha Venc.</label></td>
							<td><input type="text" name="fvencimiento" id="fvencimiento" readonly="readonly" class="s_fecha" value="<?= $fechaVencimiento ?>" /></td>
						</tr>
						<tr>
							<td><label>Meses Transcurridos</label></td>
							<td><input type="text" id="mesestranscurridos" readonly="readonly" class="s_meses" value="<?= $mesesTranscurridos ?>" /></td>
						</tr>
					</table>
				</div>
			</div>
			
			<div class="module">
				<div id="estado" class="big_box green">
					<?php
						$data['estado'] = $estadoContrato;
						$data['info'] = $info;
						$data['presaca'] = $presaca;
						$this->load->view('contrato/opciones', $data);
					?>
				</div>
			</div>
			
		</div>
		
		<div class="small_wrap">
			<div class="module">
				<div id="tipocontrato" class="small_box purple">
					<h2>Tipo de Contrato</h2>
					<table class="form">
						<tr>
							<td>Meses Contrato</td>
							<td><input type="text" readonly="readonly" id="mesescontrato" value="<?= $nroMeses ?>" class="s_meses" /></td>
						</tr>
						<tr>
							<td>Porcentaje Compra</td>
							<td><input type="text" readonly="readonly" id="show_porcentaje" value="<?= $porcentaje ?>" class="s_porcentaje" /></td>
						</tr>
					</table>
				</div>
			</div>
			
			<div class="module">
				<div id="abonos" class="small_box yellow">
					<h2>Abonos</h2>
					<?php
						$totalabonado = 0;
						if($prorrogas->num_rows() >= 1){
							echo '<table class="format" cellspacing="0">';
							echo '<tr><th class="fecha">Fecha / Hora</th><th class="valor">Valor</th><th>&nbsp;</th></tr>';
							
							$i = 0;
							foreach($prorrogas->result_array() as $p){
								
								echo '<tr><td class="fecha">'.$p['fecha'].' '.$p['hora'].'</td><td class="valor">$ '.number_format($p['valor']).'</td><td>'.number_format($p['nromeses'], 1).'</td></tr>';
								$totalabonado += $p['valor'];
							}
							echo '<tr><th>Total</th><th colspan=2>$ '.number_format($totalabonado).'</th></tr>';
							echo '<tr><th>Meses</th><th colspan=2>'.number_format($totalabonado / $valorProrroga, 2).'</th></tr>';
							echo '</table>';
						}else{
							echo '<div class="buttons"><h3>El contrato no tiene abonos</h3></div>';
						}
					?>
					
					<div id="abonar" class="<?= $estadoContrato == Contrato::ACTIVO ? '' : 'off'; ?>">
						<h2>Nuevo Abono</h2>
						<form name="frm_nuevaprorroga" id="frm_nuevaprorroga" method="post" action="<?=site_url('contrato/prorrogar')?>">
							<table class="form">
								<tr>
									<td>Valor Abono</td>
									<td><input type="text" id="show_prorroga_valor" class="s_valor" /></td>
								</tr>
								<tr>
									<td colspan="2" class="buttons">
										<input type="hidden" name="idcontrato" value="<?= $idcontrato ?>" />
										<input type="hidden" name="valorProrroga" id="valorProrroga" />
										
										<input type="button" class="blue_button" value="Total" onclick="totalProrrogas()" />
										<input type="button" class="blue_button" value="Guardar" onclick="guardarProrroga()" />
									</td>
								</tr>
							</table>
						</form>
					</div>
				</div>
			</div>
			
			<div class="off">
				<input id="idcontrato" value="<?= $idcontrato ?>" />
				<input id="totalabonado" value="<?= $totalabonado ?>" />
			</div>
			
		</div>
	</div>
			
			
		</div>
		<div id="right_container">

			
			<?php
				if($estadoContrato == Contrato::ACTIVO && !$presaca){
			?>
			
			<div id="abonar">
			
				
			</div>
			<?php
				}
			?>
			
			<form name="frm_imprimir" id="frm_imprimir" method="post" action="<?=site_url('contrato/imprimir/copia')?>">
				<input type="hidden" name="idcontrato" value="<?=$idcontrato?>" />
			</form>
			
		</div>
		
	</div>
	
	<?=read_message()?>
	
</body>