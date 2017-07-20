<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="Diego Calle">
	<title>Nueva venta -SICV-</title>
	<link href="<?=base_url('assets/img/favicon.ico')?>" rel="shortcut icon" />
	
	<link rel="stylesheet" href="<?=base_url("assets/css/base.css")?>" />
	
	<script src="<?=base_url('assets/js/jquery-1.9.1.min.js')?>"></script>
	<script src="<?=base_url('assets/js/base.js')?>"></script>
	<script src="<?=base_url('assets/js/ajax.js')?>"></script>
	<script>
		function imprimir(){
			$("#frm_router").submit();
		}
	</script>
	<style>
		#infocliente table .buttons {
				text-align: right;
			}
			
		#infocliente tr td:first-child label {
			display: inline-block;
			width: 120px;
		}
	
		#buscarcliente label, #buscarproducto label, #wrp_garantia label {
			display: inline-block;
			width: 120px;
		}
		
		#q_articulo {
			width: 340px;
		}
	
		.big_wrap {
			margin-left: 0;
			margin-right: 10px;
		}
		
		#select_articulo .format tbody tr:hover {
			cursor: pointer;
		}
		
		.module {
			margin-bottom: 10px;
		}
		
		#buscarproducto .idarticulo, #productos .idarticulo {
			text-align: center;
			width: 50px;
		}
		
		#buscarproducto .contrato, #productos .contrato {
			text-align: center;
			width: 70px;
		}
		
		#buscarproducto .articulo, #productos .articulo {
			width: 340px;
		}
		
		#buscarproducto .valor, #productos .valor {
			text-align: center;
			width: 90px;
		}
		
		#buscarproducto .cantidad {
			text-align: center;
			width: 60px;
		}
		
		.inp_venta {
			width: 70px;
		}
	</style>
</head>
<body>
	
	<?=$this->load->view('ads/header')?>
	
	<div id="main_container">
		
		<h1>Nota Cobro Nro. <?= $idnotacobro ?></h1>
		
		<div class="big_wrap">
			<form name="frm_nuevaventa" id="frm_nuevaventa" method="post" onsubmit="return validar()" onreset="removeCliente()" action="<?=site_url('almacen/checkout')?>">
				
				<div class="module">
					<div id="infocliente" class="big_box blue">
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
								<td><input type="text" name="nombre" id="nombre" class="s_nombre" readonly="readonly" value="<?= $nombreCliente ?>" /></td>
								<td class="space"><label>Tel&eacute;fono</label></td>
								<td><input type="text" id="telefono" class="s_telefono" readonly="readonly" value="<?= $telefonoCliente ?>" /></td>
							</tr>
						</table>
					</div>
				</div>
				
				<div class="module">
					<div id="articulos" class="big_box orange">
						<h2>Productos facturados (<?= $detalles->num_rows() ?>)</h2>
						<table id="productos" class="format" cellspacing="0">
							<thead>
								<tr>
									<th class="idarticulo">Id</th>
									<th class="contrato">Contrato</th>
									<th class="articulo">Art&iacute;culo</th>
									<th class="valor">V. Compra</th>
									<th class="valor">V. Venta</th>
								</tr>
							</thead>
							<tbody id="productos"></tbody>
							<?php
								$total = 0;
								foreach($detalles->result_array() as $detalle){
									$total += $detalle['valor'];
							?>
								<tr>
									<td class="idarticulo"><?=$detalle['idarticulo']?></td>
									<td class="contrato"><a href="<?=site_url('contrato/ver/'.$detalle['contrato'])?>"><?=$detalle['contrato']?></a></td>
									<td class="descripcion"><?=$detalle['articulo']?></td>
									<td class="valor">$ <?=number_format($detalle['valorcompra'])?></td>
									<td class="valor">$ <?=number_format($detalle['valor'])?></td>
								</tr>
							<?php
								}
							?>
							<tfoot>
								<th colspan="4">Total</th>
								<th id="total">$ <?=number_format($total)?></th>
							</tfoot>
						</table>
					</div>
				</div>
				
				<div id="botones" class="module">
					<div class="buttons">
						<form name="frm_router" id="frm_router" method="post" action="<?=site_url('almacen/imprimir')?>">
							<input type="hidden" name="idnotacobro" value="<?=$idnotacobro?>" />
							<input name="guardar" type="button" class="blue_button" value="Imprimir" onclick="imprimir()" />
						</form>
					</div>
				</div>
				
			</form>
		</div>
		
		
		<div class="small_wrap">
			<div class="module">
				<div id="wrp_garantia" class="small_box purple">
					<h2>Garant&iacute;a</h2>
					<label>Garant&iacute;a</label>
					<input type="text" class="s_meses" id="show_garantia" readonly="readonly" value="<?= $garantia ?>" /> d&iacute;as
				</div>
			</div>
		</div>

	</div>
	
	<?=read_message()?>
	
</body>