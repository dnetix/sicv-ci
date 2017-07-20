<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="Diego Calle">
	<title>Informe de Articulos a la Venta -SICV-</title>
	<link href="<?=base_url('assets/img/favicon.ico')?>" rel="shortcut icon" />
	
	<link rel="stylesheet" href="<?=base_url("assets/css/base.css")?>" />
	
	<script src="<?=base_url('assets/js/jquery-1.9.1.min.js')?>"></script>
	<script src="<?=base_url('assets/js/base.js')?>"></script>
		
</head>
<body>
	
	<?=$this->load->view('ads/header')?>
	
	<div id="main_container">
		
		<div id="filtros">
			<form name="frm_filter" method="post" action="<?=site_url('informe/articulosventa')?>">
				Filtrar por
				
				<select name="tipoarticulo">
					<option value="">Ninguno</option>
					<?php
						foreach($tiposarticulo as $tipo){
							echo '<option value="'.$tipo['idtipoarticulo'].'">'.$tipo['tipoarticulo'].'</option>';
						}
					?>
				</select>
				
				Ordenar por
				<select name="ordenarpor">
					<option value="idarticulo">Nro. Articulo</option>
					<option value="contrato">Contrato</option>
					<option value="articulo">Nombre Articulo</option>
					<option value="fechaingreso">Fecha Ingreso</option>
				</select>
				
				<select name="orden">
					<option value="ASC">Ascendente</option>
					<option value="DESC">Descendente</option>
				</select>
				
				<input type="submit" class="blue_button" name="filter" value="Filtrar" />
			</form>
		</div>
		
		<div id="informe" class="vencidos">
			
			<h2>Total de Articulos a la Venta (<?=$results->num_rows()?>)</h2>
			<table class="format" cellspacing="0">
				<thead>
					<tr>
						<th class="idarticulo">Articulo ID</th>
						<th class="contrato">Contrato</th>
						<th class="articulo">Articulo</th>
						<th class="tipoarticulo">Tipo Articulo</th>
						<th class="fecha">Fecha</th>
						<th class="valor">Valor Compra</th>
						<th class="valor">Valor Venta</th>
						<th class="cantidad">Cantidad</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$i = 0;
						$totalcompra = 0;
						$totalventa = 0;
						$cantidad = 0;
						foreach($results->result_array() as $result){
							if($i % 2 == 0){$class = ' class="even"';}else{$class = '';}
							$totalcompra += $result['valorcompra'];
							$totalventa += $result['valorventa'];
							$cantidad += $result['disponible'];
							?>
						<tr<?=$class?>>
							<td class="idarticulo"><?=$result['idarticulo']?></td>
							<td class="contrato"><?=$result['contrato']?></td>
							<td class="articulo"><?=$result['articulo']?></td>
							<td class="tipoarticulo"><?=$result['tipoarticulo']?></td>
							<td class="fecha"><?=$result['fechaingreso']?></td>
							<td class="valor">$ <?=number_format($result['valorcompra'])?></td>
							<td class="valor">$ <?=number_format($result['valorventa'])?></td>
							<td class="cantidad"><?=$result['disponible']?></td>
						</tr>
							<?php
							$i++;
						}
					?>
					<tr>
						<th colspan="5">Total</th>
						<th>$ <?=number_format($totalcompra)?></th>
						<th>$ <?=number_format($totalventa)?></th>
						<th><?=$cantidad?></th>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	
	<?=read_message()?>
	
</body>