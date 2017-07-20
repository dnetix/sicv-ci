<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="Diego Calle">
	<title>Informe de presacas -SICV-</title>
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
			var input = selected.getElementsByTagName('input')[0];
			if(input.checked){
				$("#"+input.value).removeClass("selected");
				input.checked = false;
			}else{
				$("#"+input.value).addClass("selected");
				input.checked = true;
			}
			
		}
		
		function operacionForm(op){
			var sw = false;
			if(op == "sacar"){
				sw = confirm("Se dispone a mover al almacen los articulos seleccionados, ya no serán contratos vencidos, desea continuar?");
			}else if(op == 'remover'){
				sw = confirm("Se dispone a remover de listado los articulos seleccionados, seguirán siendo contratos vencidos, desea continuar?");
			}
			if(sw){
				$("#operacion").val(op);
				$("#frm_presaca").submit();
			}
		}
	</script>
	
</head>
<body>
	
	<?=$this->load->view('ads/header')?>
	
	<div id="main_container">
		
		<div id="informe" class="presaca">
			
			<h2>Contratos en Presaca (<?=$results->num_rows()?>)</h2>
			
			<form name="frm_presaca" id="frm_presaca" method="post" action="<?=site_url('operacion/sacar')?>">
				
				<label>Acción a realizar con el oro</label>
				<select name="chatarrizar">
					<option value="1">Chatarrizar</option>
					<option value="0">Mover al almacen</option>
				</select>
								
				<table class="format" cellspacing="0">
					<tr>
						<th class="contrato">Contrato</th>
						<th class="small_c_a">Cliente / Articulo</th>
						<th class="fecha">Fecha</th>
						<th class="contrato">Nro Meses</th>
						<th class="valor">Valor Con.</th>
						<th class="fecha">Ultima Pr.</th>
						<th class="valor">Total Prorrogas</th>
						<th class="option">Valor Venta</th>
						<th class="option">Saca?</th>
					</tr>
					<?php
						$i = 0;
						foreach($results->result_array() as $result){
							if($i % 2 == 0){$class = ' class="even"';}else{$class = '';}
							$prorroga = $result['valor'] * ($result['porcentaje'] / 100);
							$faltante = ($result['mesesactuales'] - $result['mesesprorrogados']) * $prorroga;
							?>
						<tr<?=$class?> id="<?=$result['idcontrato']?>">
							<td class="contrato"><a target="_blank" href="<?=site_url('contrato/ver/'.$result['idcontrato'])?>"><?=$result['idcontrato']?></a></td>
							<td class="small_c_a">
								<p><a target="_blank" href="<?=site_url('cliente/ver/'.$result['idcliente'])?>"><?=$result['nombre']?> - <?=$result['telefono']?></a></p>
								<p><?=$result['articulo']?></p>
							</td>
							<td class="fecha"><?=$result['fechaingreso']?></td>
							<td class="contrato"><?=$result['mesesactuales']?></td>
							<td class="valor">$ <?=number_format($result['valor'])?></td>
							<td class="fecha"><?=$result['ultimaprorroga']?></td>
							<td class="valor">
								<p>$ <?=number_format($result['mesesactuales'] * $prorroga)?></p>
								<p>$ <?=number_format($result['mesesprorrogados'] * $prorroga)?></p>
								<p>$ <?=number_format($faltante)?></p>
							</td>
							<td>
								<input type="text" onchange="setMoneyValue('show_vc_<?=$result['idcontrato']?>', 'vc_<?=$result['idcontrato']?>')" name="show_vc_<?=$result['idcontrato']?>" id="show_vc_<?=$result['idcontrato']?>" value="$ <?=number_format($result['valor'])?>" class="s_valor" />
								<input type="hidden" id="vc_<?=$result['idcontrato']?>" name="vc_<?=$result['idcontrato']?>" value="<?=$result['valor']?>" />
							</td>
							<td class="option"><input type="checkbox" name="seleccion[]" checked="checked" onchange="checkClass(this)" value="<?=$result['idcontrato']?>" /></td>
						</tr>
							<?php
							$i++;
						}
					?>
				</table>
				
				<div class="buttons">
					<input type="hidden" name="operacion" id="operacion" />
					<input type="button" class="blue_button" value="Sacar Contratos" onclick="operacionForm('sacar')" />
					<input type="button" class="red_button" value="Remover del Listado" onclick="operacionForm('remover')" />
				</div>
				
			</form>
		</div>
	</div>
	
	<?=read_message()?>
	
</body>