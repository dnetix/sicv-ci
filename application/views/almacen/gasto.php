<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="Diego Calle">
	<title>Ingresar nuevo Gasto -SICV-</title>
	<link href="<?=base_url('assets/img/favicon.ico')?>" rel="shortcut icon" />
	
	<link rel="stylesheet" href="<?=base_url("assets/css/base.css")?>" />
	
	<script src="<?=base_url('assets/js/jquery-1.9.1.min.js')?>"></script>
	<script src="<?=base_url('assets/js/base.js')?>"></script>
	<style>
		h1 {
			margin: 20px 0;
		}
	
		.concepto {
			width: 200px;
		}
		
		.tipogasto {
			width: 130px;
		}
		
		.empleado {
			width: 150px;
		}
	</style>
	
</head>
<body>
	
	<?=$this->load->view('ads/header')?>
	
	<div id="main_container">
		
		<div class="inline" style="width: 310px;">
			
			<h1>Nuevo Gasto</h1>
			<form name="frm_nuevoarticulo" method="post" action="<?=site_url('almacen/guardargasto')?>">
				
				<table class="form">
					<tr>
						<td><label>Fecha</label></td>
						<td>
							<input type="text" name="fecha" id="fecha" class="s_datetime" readonly="readonly" value="<?=date('Y-m-d')?>" />
						</td>
					</tr>
					<tr>
						<td><label>Valor</label></td>
						<td>
							<input type="text" id="showvalor" class="s_valor" onchange="setMoneyValue('showvalor', 'valor')" required="required" />
							<input type="hidden" name="valor" id="valor" />
						</td>
					</tr>
					<tr>
						<td><label>Tipo Gasto</label></td>
						<td>
							<select name="tipogasto" required="required">
								<option value="">Selecciona el tipo de gasto</option>
								<?php
									foreach($tiposgasto as $key => $value){
										echo '<option value="'.$key.'">'.$value.'</option>';
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td><label>Detalle</label></td>
						<td>
							<textarea name="concepto"></textarea>
						</td>
					</tr>
				</table>

				<div class="buttons">
					<input name="guardar" type="submit" name="guardar" value="Guardar" />
					<input type="reset" value="Cancelar" />
				</div>
				
			</form>
		</div>
		
		<div class="inline" style="width: 700px;">
			
			<h1>Gastos del mes</h1>
			<table class="format" cellspacing="0">
				<thead>
					<tr>
						<th class="s_datetime">Fecha</th>
						<th class="concepto">Concepto</th>
						<th class="s_valor">Valor</th>
						<th class="tipogasto">Tipo Gasto</th>
						<th class="empleado">Empleado</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$total = 0;
						foreach($gastos->result_array() as $gasto){
							$total += $gasto['valor'];
					?>
					<tr>
						<td class="s_fecha"><?=$gasto['fecha']?></td>
						<td class="concepto"><?=$gasto['concepto']?></td>
						<td class="s_valor">$ <?=number_format($gasto['valor'])?></td>
						<td class="tipogasto"><?=$gasto['tipogasto']?></td>
						<td class="empleado"><?=$gasto['nombre']?></td>
					</tr>
					<?php
						}
					?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="2">Total</th>
						<th>$ <?=number_format($total)?></th>
						<th colspan="2">&nbsp;</th>
					</tr>
				</tfoot>
			</table>
			
		</div>
		
	</div>
	
	<?=read_message()?>
	
</body>