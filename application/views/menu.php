<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="Diego Calle">
	<title>Men&uacute; Principal -SICV-</title>
	<link rel="stylesheet" href="<?=base_url("assets/css/base.css")?>" />
	<link href="<?=base_url('assets/img/favicon.ico')?>" rel="shortcut icon" />
	<script src="<?=base_url('assets/js/jquery-1.9.1.min.js')?>"></script>
	<script src="<?=base_url('assets/js/base.js')?>"></script>
	<script src="<?=base_url('assets/js/ajax.js')?>"></script>
	
	<script>
		var timer;
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
		
		function obtenerValorOro(){
			doGetOroPrice();
			$("#ajax_oro").slideDown('fast');
			$("#ajax_oro").html("<h2>Cargando datos del precio del oro de un servidor externo, por favor espere.</h2>");
		}
		
		function buscarCliente(q){
			clearTimeout(timer);
			timer = setTimeout(function(){
				if(q.value.length == 0){
					$("#ajax_cliente").slideUp('fast');
				}else{
					$("#ajax_cliente").slideDown('fast');
					doSearchCliente(q.value);
				}
			}, 1000);
		}
		
		function seleccionarCliente(idcliente, nombre, telefono){
			$("#showid").val(idcliente);
			$("#idcliente").val(idcliente);
			$("#frm_cliente").submit();
		}
	</script>
	
	<style>
		#ajax_oro {
			display: none;
		}
		
		#ajax_oro tr:hover {
			background-color: #F5911E;
		}
		
		#ajax_oro table {
			text-align: center;
		}
		
		.module {
			margin-bottom: 10px;
		}
		
		.header {
			font-family: 'Open Sans';
			color: #555555;
			font-size: 18px;
			font-weight: bold;
		}
		
		.serving {
			text-align: right;
			padding-right: 60px;
		}
		
		#today_contracts .contrato {
			text-align: center;
			width: 120px;
		}
		
		#today_contracts .articulo {
			width: 380px;
		}
		
		#today_contracts .valor {
			text-align: center;
			width: 160px;
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
				<a class="small_box purple newcontract" href="<?=site_url('contrato/nuevo')?>"><h2>Nuevo Contrato</h2></a>
			</div>
			
			<div class="module">
				<a class="small_box yellow goldprice" href="javascript:void(0)" onclick="obtenerValorOro()"><h2>Precio del oro</h2></a>
			</div>
			
		</div>
		
		<div class="big_wrap">
			
			<div id="jx_content">
				
				<div id="ajax_cliente" class="big_box blue"></div>
				<div id="ajax_oro" class="big_box yellow"></div>
				
				<div id="today_contracts" class="big_box purple">
					<h2>Contratos Hoy</h2>
					<?php
						if($contratos->num_rows() >= 1){
					?>
					<table class="format" cellspacing="0">
					<thead>
						<tr>
							<th class="contrato">Contrato</th>
							<th class="articulo">Cliente / Art&iacute;culo</th>
							<th class="valor">Valor</th>
						</tr>
					</thead>
					<tbody>
					<?php
							$i = 1;
							$total = 0;
							foreach($contratos->result_array() as $c){
								if($i % 2 == 0){
									$class = ' class="even"';
								}else{
									$class = '';
								}
								$total += $c['valor'];
					?>
						<tr<?=$class?>>
							<td class="contrato"><a href="<?=site_url('contrato/ver/'.$c['idcontrato'])?>"><?=$c['idcontrato']?></a></td>
							<td class="articulo">
								<p><a href="<?=site_url('cliente/ver/'.$c['idcliente'])?>"><?=$c['nombre']?></a></p>
								<p><?=$c['articulo']?></p>
							</td>
							<td class="valor">$ <?=number_format($c['valor'])?></td>
						</tr>
					<?php
							}
					?>
						<tr>
							<th colspan="2" class="total">Total</th>
							<th class="valortotal">$ <?=number_format($total)?></th>
						</tr>
						</tbody>
					</table>	
					<?php
						}else{
					?>
						<h3>No se han realizado contratos el d&iacute;a de hoy</h3>
					<?php
						}
					?>
				</div>
				
				
			</div>
			
		</div>
	</div>
	
	<?=read_message()?>
	
</body>