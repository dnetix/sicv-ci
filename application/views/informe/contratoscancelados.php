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
	
	<style>
		.nromeses {
			width: 50px;
			text-align: center;
		}
	</style>
	
</head>
<body>
	
	<?=$this->load->view('ads/header')?>
	
	<div id="main_container">
		
		<div id="filtros">
			<form name="frm_filter" method="post" action="<?=site_url('informe/cancelados')?>">
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
					<option value="fechasalida">Fecha</option>
					<option value="idcontrato">Contrato</option>
					<option value="nromeses">Nro Meses</option>
					<option value="nombre">Cliente</option>
					<option value="valor">Valor</option>
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

		<div id="informe" class="activos">
			
			<h2>Resultados de Filtro (<?= $results !== FALSE ? $results->num_rows() : 0; ?>) Contratos</h2>
			
			<table class="format" cellspacing="0">
				<tr>
					<th class="contrato">Contrato</th>
					<th class="small_c_a">Cliente / Articulo</th>
					<th class="fecha">Fecha Ingreso</th>
					<th class="fecha">Fecha Salida</th>
					<th class="valor">Valor</th>
					<th class="nromeses">Nro meses</th>
					<th class="valor">Valor Cancelado</th>
					<th class="valor">Prorrogas Pagadas</th>
				</tr>					
				<?php
					$i = 0;
					$totalcontrato = 0;
					$totalcancelado = 0;
					$totalprorrogas = 0;
					if($results){
						foreach($results->result_array() as $result){
							$totalcontrato += $result['valor'];
							$totalcancelado += $result['valorcancelado'];
							$totalprorrogas += $result['prorrogas'];
							if($i % 2 == 0){$class = ' class="even"';}else{$class = '';}
							?>
						<tr<?=$class?>>
							<td class="contrato"><a target="_blank" href="<?=site_url('contrato/ver/'.$result['idcontrato'])?>"><?=$result['idcontrato']?></a></td>
							<td class="small_c_a">
								<p><a target="_blank" href="<?=site_url('cliente/ver/'.$result['idcliente'])?>"><?=$result['nombre']?></a></p>
								<p><?=$result['articulo']?></p>
							</td>
							<td class="fecha"><?=$result['fechaingreso']?></td>
							<td class="fecha"><?=$result['fechasalida']?></td>
							<td class="valor">$ <?=number_format($result['valor'])?></td>
							<td class="nromeses"><?=$result['nromeses']?></td>
							<td class="valor">$ <?=number_format($result['valorcancelado'])?></td>
							<td class="valor">$ <?=number_format($result['prorrogas'])?></td>
						</tr>
							<?php
							$i++;
						}
					}
				?>
				<tr>
					<th colspan="4">Totales FILTRADOS</th>
					<th>$ <?=number_format($totalcontrato)?></th>
					<th>&nbsp;</th>
					<th>$ <?=number_format($totalcancelado)?></th>
					<th>$ <?=number_format($totalprorrogas)?></th>
				</tr>
			</table>
			
		</div>
				
	</div>
	
	<?=read_message()?>
	
</body>