<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="Diego Calle">
	<title>Informe Contratos Activos -SICV-</title>
	<link href="<?=base_url('assets/img/favicon.ico')?>" rel="shortcut icon" />
	
	<link rel="stylesheet" href="<?=base_url("assets/css/base.css")?>" />
	
	<script src="<?=base_url('assets/js/jquery-1.9.1.min.js')?>"></script>
	<script src="<?=base_url('assets/js/base.js')?>"></script>
	
	<!-- SCRIPTS PARA JSCAL Calendario Javascript -->
	<link type="text/css" rel="stylesheet" href="<?=base_url("assets/jscal/css/jscal2.css")?>" />
	<script src="<?=base_url("assets/jscal/js/jscal2.js")?>"></script>
	<script src="<?=base_url("assets/jscal/js/lang/es.js")?>"></script>
	
</head>
<body>
	
	<?=$this->load->view('ads/header')?>
	
	<div id="main_container">
		
		<div id="filtros">
			<form name="frm_filter" method="post" action="<?=site_url('informe/activos')?>">
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
					<option value="idcontrato">Contrato</option>
					<option value="mesesactuales">Nro Meses</option>
					<option value="ultimaprorroga">Ultima prorroga</option>
					<option value="nombre">Cliente</option>
					<option value="valor">Valor</option>
					<option value="fechaingreso">Fecha</option>
				</select>
				
				<select name="orden">
					<option value="ASC">Ascendente</option>
					<option value="DESC">Descendente</option>
				</select>
				
				Fecha Inicial
				<input type="text" readonly="readonly" name="inicial" id="inicial" class="s_fecha" value="<?=$inicial?>" />
				<input type="button" value="" class="btn_calendar" id="f_inicial" />
				<script type="text/javascript" language="javascript">//<![CDATA[
                      var cal = Calendar.setup({
                          onSelect: function(cal) { cal.hide() },
                          showTime: false
                      });
                      cal.manageFields("f_inicial", "inicial", "%Y-%m-%d");
                //]]></script>
                
				Fecha Final
				<input type="text" readonly="readonly" name="final" id="final" class="s_fecha" value="<?=$final?>" />
				<input type="button" value="" class="btn_calendar" id="f_final" />
				<script type="text/javascript" language="javascript">//<![CDATA[
                      var cal = Calendar.setup({
                          onSelect: function(cal) { cal.hide() },
                          showTime: false
                      });
                      cal.manageFields("f_final", "final", "%Y-%m-%d");
                //]]></script>
				
				<input type="submit" class="blue_button" name="filter" value="Filtrar" />
			</form>
		</div>
		
		<div id="totalizado">
			<h2>Total de Contratos Activos</h2>
			<p>N&uacute;mero de Contratos: <strong><?=$totales['nrocontratos']?></strong></p>
			<p>Total Prestado: <strong>$ <?=number_format($totales['totalprestado'])?></strong></p>
		</div>
		
		
		<?php
			if($contratos){
		?>
		<div id="informe" class="activos">
			
			<h2>Resultados de Filtro (<?=$results->num_rows()?>) Contratos</h2>
			
			<table class="format" cellspacing="0">
				<tr>
					<th class="contrato">Contrato</th>
					<th class="small_c_a">Cliente / Articulo</th>
					<th class="telefono">Telefono</th>
					<th class="fecha">Fecha</th>
					<th class="valor">Valor Con.</th>
					<th class="fecha">Ultima Pr.</th>
					<th class="valor">Total Prorrogas</th>
					<th class="valor">Faltante</th>
					<th class="valor">A pagar</th>
				</tr>					
				<?php
					$i = 0;
					
					$totalfiltro = 0;
					$prorrogas = 0;
					$faltantes = 0;
					$totalcancelar = 0;
					
					foreach($results->result_array() as $result){
						if($i % 2 == 0){$class = ' class="even"';}else{$class = '';}
						
						$prorroga = $result['valor'] * ($result['porcentaje'] / 100);
						$faltante = ($result['mesesactuales'] - $result['mesesprorrogados']) * $prorroga;
						
						$totalfiltro += $result['valor'];
						$prorrogas += $result['mesesprorrogados'] * $prorroga;
						$faltantes += $faltante;
						$totalcancelar += $result['valor'] + $faltante;
						?>
					<tr<?=$class?>>
						<td class="contrato"><a target="_blank" href="<?=site_url('contrato/ver/'.$result['idcontrato'])?>"><?=$result['idcontrato']?></a></td>
						<td class="small_c_a">
							<p><a target="_blank" href="<?=site_url('cliente/ver/'.$result['idcliente'])?>"><?=$result['nombre']?></a></p>
							<p><?=$result['articulo']?></p>
						</td>
						<td class="telefono"><?=$result['telefono']?></td>
						<td class="fecha"><?=$result['fechaingreso']?></td>
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
				<tr>
					<th colspan="4">Totales FILTRADOS</th>
					<th>$ <?=number_format($totalfiltro)?></th>
					<th>&nbsp;</th>
					<th>$ <?=number_format($prorrogas)?></th>
					<th>$ <?=number_format($faltantes)?></th>
					<th>$ <?=number_format($totalcancelar)?></th>
				</tr>
			</table>
			
		</div>
		<?php
			}
		?>
				
	</div>
	
	<?=read_message()?>
	
</body>