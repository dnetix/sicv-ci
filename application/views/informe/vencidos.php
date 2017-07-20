<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="Diego Calle">
	<title>Informe Contratos Vencidos -SICV-</title>
	<link href="<?=base_url('assets/img/favicon.ico')?>" rel="shortcut icon" />
	
	<link rel="stylesheet" href="<?=base_url("assets/css/base.css")?>" />
	
	<script src="<?=base_url('assets/js/jquery-1.9.1.min.js')?>"></script>
	<script src="<?=base_url('assets/js/base.js')?>"></script>
	
	<script>
		function checkClass(input){
			if(input.checked){
				$("#"+input.value).addClass("selected");
			}else{
				$("#"+input.value).removeClass("selected");
			}
		}
		
		function selectThis(selected){
			console.log($("#saca_"+selected).prop('checked'));
			if($("#saca_"+selected).prop('checked')){
				$("#saca_"+selected).prop('checked', false);
				$("#"+selected).removeClass('selected');
			}else{
				$("#saca_"+selected).prop('checked', true);
				$("#"+selected).addClass('selected');
			}
		}
	</script>
	
	<style>
		.item:hover {
			background: #F0F0F0;
			cursor: pointer;
		}
		
		.selected {
			background: #4D90FE !important;
		}
		
		.fechahora {
			width: 100px;
			text-align: center;
		}
		
		.buttons {
			margin: 20px 0;
		}
		
		.meses {
			text-align: center;
		}
	</style>
	
</head>
<body>
	
	<?=$this->load->view('ads/header')?>
	
	<div id="main_container">
		
		<div id="filtros">
			<form name="frm_filter" method="post" action="<?=site_url('informe/vencidos')?>">
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
					<option value="mesesactuales">Meses actuales</option>
					<option value="mesesvencidos">Meses vencidos</option>
					<option value="ultimaprorroga">Ultima prorroga</option>
					<option value="nombre">Cliente</option>
					<option value="valor">Valor</option>
					<option value="idcontrato">Contrato</option>
				</select>
				
				<select name="orden">
					<option value="ASC">Ascendente</option>
					<option value="DESC">Descendente</option>
				</select>
				
				<input type="submit" class="blue_button" name="filter" value="Filtrar" />
			</form>
		</div>
		
		<div id="informe" class="vencidos">
			
			<h2>Contratos Vencidos (<?=$results->num_rows()?>)</h2>
			
			<form name="frm_presaca" method="post" action="<?=site_url('operacion/presacar')?>">
				<table class="format" cellspacing="0">
					<tr>
						<th class="contrato">Contrato</th>
						<th class="small_c_a">Cliente / Articulo</th>
						<th class="fechahora">Fecha</th>
						<th>M.A. / M.V.</th>
						<th class="valor">Valor Con.</th>
						<th class="fecha">Ultima Pr.</th>
						<th class="valor">Total Prorrogas</th>
						<th class="valor">Faltante</th>
						<th class="valor">A pagar</th>
					</tr>
					<?php
						$i = 0;
						foreach($results->result_array() as $result){
							if($i % 2 == 0){$class = ' even';}else{$class = '';}
								$prorroga = $result['valor'] * ($result['porcentaje'] / 100);
								$faltante = ($result['mesesactuales'] - $result['mesesprorrogados']) * $prorroga;
							?>
						<tr class="item <?=$class?>" id="<?=$result['idcontrato']?>" onclick="selectThis(<?=$result['idcontrato']?>)">
							<td class="contrato">
								<a target="_blank" href="<?=site_url('contrato/ver/'.$result['idcontrato'])?>"><?=$result['idcontrato']?></a>
								<input type="checkbox" class="off" name="saca[]" id="saca_<?=$result['idcontrato']?>" value="<?=$result['idcontrato']?>" />
							</td>
							<td class="small_c_a">
								<p><a target="_blank" href="<?=site_url('cliente/ver/'.$result['idcliente'])?>"><?=$result['nombre']?> - <?=$result['telefono']?></a></p>
								<p><?=$result['articulo']?></p>
							</td>
							<td class="fechahora"><?=$result['fechaingreso']?></td>
							<td class="meses"><?= $result['mesesactuales'] ?> / <?= number_format($result['mesesactuales'] - $result['mesesprorrogados'], 1) ?></td>
							<td class="valor">$ <?=number_format($result['valor'])?></td>
							<td class="fecha"><?=$result['ultimaprorroga']?></td>
							<td class="valor">$ <?=number_format($result['mesesprorrogados'] * $prorroga)?></td>
							<td class="valor">$ <?=number_format($faltante)?></td>
							<td class="valor">$ <?=number_format($result['valor'] + $faltante)?></td>
							
						</tr>
							<?php
							$i++;
						}
					?>
				</table>
				
				<div class="buttons">
					<input type="submit" value="Presacar" class="blue_button" name="presacar" />
				</div>
				
			</form>
		</div>
	</div>
	
	<?=read_message()?>
	
</body>