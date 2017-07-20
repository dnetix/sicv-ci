<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="Diego Calle">
	<title>Informe Financiero Totalizado -SICV-</title>
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
			<form name="frm_filter" method="post" action="<?=site_url('informe/financiero')?>">
				Filtrar por Fecha Inicial
				<input type="text" readonly="readonly" name="inicial" id="inicial" class="s_fecha" value="<?=$inicial?>" />
				<input type="button" value="" class="btn_calendar" id="f_inicial" />
				<script type="text/javascript" language="javascript">//<![CDATA[
                      var cal = Calendar.setup({
                          onSelect: function(cal) { cal.hide() },
                          showTime: false
                      });
                      cal.manageFields("f_inicial", "inicial", "%Y-%m-%d 00:00:00");
                //]]></script>
                
				Fecha Final
				<input type="text" readonly="readonly" name="final" id="final" class="s_fecha" value="<?=$final?>" />
				<input type="button" value="" class="btn_calendar" id="f_final" />
				<script type="text/javascript" language="javascript">//<![CDATA[
                      var cal = Calendar.setup({
                          onSelect: function(cal) { cal.hide() },
                          showTime: false
                      });
                      cal.manageFields("f_final", "final", "%Y-%m-%d 23:59:59");
                //]]></script>
                
				<input type="submit" class="blue_button" name="filter" value="Filtrar" />
			</form>
		</div>

		<div id="informe" class="vencidos">
			
			<h2>Reporte Totalizado desde <?=$inicial?> hasta <?=$final?></h2>
			
			<div class="inline" style="width: 500px;">
				<table class="form">
					<tr>
						<th colspan="2">
							<h2>Salidas</h2>
						</th>
					</tr>
					<tr>
						<td>Prestado en Contratos:</td>
						<td><strong>$ <?=number_format($contratos)?></strong></td>
					</tr>
					<tr>
						<td>Gastos ingresados:</td>
						<td><strong>$ <?=number_format($gastos)?></strong></td>
					</tr>
					<tr>
						<td>Compras de Articulos:</td>
						<td><strong>$ <?=number_format($compras)?></strong></td>
					</tr>
					<tr>
						<td>Total</td>
						<td><strong>$ <?=number_format($contratos + $gastos + $compras)?></strong></td>
					</tr>
				</table>
			</div>
			
			<div class="inline" style="width: 500px;">
				<table class="form">
					<tr>
						<th colspan="2">
							<h2>Ingresos</h2>
						</th>
					</tr>
					<tr>
						<td>Prorrogas pagadas:</td>
						<td><strong>$ <?=number_format($prorrogas)?></strong></td>
					</tr>
					<tr>
						<td>Articulos Vendidos:</td>
						<td><strong>$ <?=number_format($ventas)?></strong></td>
					</tr>
					<tr>
						<td>Contratos Cancelados:</td>
						<td><strong>$ <?=number_format($cancelaciones['cancelado'])?></strong></td>
					</tr>
					<tr>
						<td>Capital:</td>
						<td><strong>$ <?=number_format($cancelaciones['capital'])?></strong></td>
					</tr>
					<tr>
						<td>Utilidad:</td>
						<td><strong>$ <?=number_format($cancelaciones['cancelado'] - $cancelaciones['capital'])?></strong></td>
					</tr>
					<tr>
						<td>Total</td>
						<td><strong>$ <?=number_format($prorrogas + $ventas + $cancelaciones['cancelado'])?></strong></td>
					</tr>
				</table>
			</div>
		</div>
		
		
	</div>
	
	<?=read_message()?>
	
</body>