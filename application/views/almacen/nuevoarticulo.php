<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="Diego Calle">
	<title>Ingreso de articulos al Almacen -SICV-</title>
	<link href="<?=base_url('assets/img/favicon.ico')?>" rel="shortcut icon" />
	
	<link rel="stylesheet" href="<?=base_url("assets/css/base.css")?>" />
	
	<script src="<?=base_url('assets/js/jquery-1.9.1.min.js')?>"></script>
	<script src="<?=base_url('assets/js/base.js')?>"></script>
	<script src="<?=base_url('assets/js/ajax.js')?>"></script>
	<script>
		
		function updateValor(field){
			setMoneyValue('show'+field, field);
		}
		
		function validar(){
			
		}
	</script>
	
</head>
<body>
	
	<?=$this->load->view('ads/header')?>
	
	<div id="main_container">
		
		<div id="left_container">
			
			<h1>Nuevo Articulo para venta</h1>
			<form name="frm_nuevoarticulo" method="post" action="<?=site_url('almacen/guardar')?>">
				
				<table class="form">
					<tr>
						<td><label>Articulo</label></td>
						<td>
							<input type="text" name="articulo" id="articulo" class="s_articulo" required="required" />
						</td>
					</tr>
					<tr>
						<td><label>Tipo de Articulo</label></td>
						<td>
							<select name="tipoarticulo" id="tipoarticulo" class="s_tipoarticulo" required="required">
								<option value="">Tipo de articulo</option>
								<?php
									foreach($tiposarticulo as $tipo){
										echo '<option value="'.$tipo['idtipoarticulo'].'">'.$tipo['tipoarticulo'].'</option>';
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td><label>Precio Compra</label></td>
						<td>
							<input type="text" id="showvalor" class="s_valor" onchange="updateValor('valor')" required="required" />
							<input type="hidden" name="valor" id="valor" />
						</td>
					</tr>
					<tr>
						<td><label>Precio Venta</label></td>
						<td>
							<input type="text" id="showvalorventa" class="s_valor" onchange="updateValor('valorventa')" />
							<input type="hidden" name="valorventa" id="valorventa" />
						</td>
					</tr>
					<tr>
						<td><label>Cantidad</label></td>
						<td>
							<input type="text" name="disponible" class="s_meses" value="1" required="required" />
						</td>
					</tr>
					<tr>
						<td colspan="2" class="buttons">
							<input name="guardar" type="submit" value="Guardar" />
							<input type="reset" value="Cancelar" />
						</td>
					</tr>
				</table>
				
			</form>
		</div>
		<div id="right_container">
			
		</div>
		
	</div>
	
	<?=read_message()?>
	
</body>