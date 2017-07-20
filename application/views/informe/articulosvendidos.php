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
			<form name="frm_filter" method="post" action="<?=site_url('informe/vendidos')?>">
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
					<option value="idnotacobro">Nota Cobro</option>
					<option value="fecha">Fecha</option>
					<option value="contrato">Contrato</option>
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

		<div id="informe" class="vendidos">
			
			<h2>Art&iacute;culos Vendidos (<?=$results->num_rows()?>)</h2>
			
			<table class="format" cellspacing="0">
				<tr>
					<th class="notacobro">Nota Cobro</th>
					<th class="fecha">Fecha</th>
					<th class="idarticulo">ID Art</th>
					<th class="contrato">Contrato</th>
					<th class="cliente_articulo">Cliente / Art&iacute;culo</th>
					<th class="cantidad">Cantidad</th>
					<th class="valor">Valor</th>
				</tr>					
				<?php
					$i = 0;
					
					$articulos = 0;
					$total = 0;
					
					foreach($results->result_array() as $result){
						if($i % 2 == 0){$class = ' class="even"';}else{$class = '';}
						
						$articulos += $result['cantidad'];
						$total += $result['valor'];
						?>
					<tr<?=$class?>>
						<td class="notacobro"><a href="<?=site_url('almacen/ver/'.$result['idnotacobro'])?>"><?=$result['idnotacobro']?></a></td>
						<td class="fecha"><?=$result['fecha']?></td>
						<td class="idarticulo"><?=$result['idarticulo']?></td>
						<td class="contrato"><a href="<?=site_url('contrato/ver/'.$result['contrato'])?>"><?=$result['contrato']?></a></td>
						<td class="cliente_articulo">
							<a target="_blank" href="<?=site_url('cliente/ver/'.$result['cliente'])?>"><?=$result['nombre']?></a>
							<p><?=$result['articulo']?></p>
						</td>
						<td class="cantidad"><?=$result['cantidad']?></td>
						<td class="valor">$ <?=number_format($result['valor'])?></td>
					</tr>
						<?php
						$i++;
					}
				?>
				<tr>
					<th colspan="5">Totales FILTRADOS</th>
					<th><?=$articulos?></th>
					<th>$ <?=number_format($total)?></th>
				</tr>
			</table>
			
		</div>
				
	</div>
	
	<?=read_message()?>
	
</body>