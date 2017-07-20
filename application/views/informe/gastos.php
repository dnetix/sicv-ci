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
	
	<style>
		h1 {
			margin: 30px 0;
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
		
		

		<div id="informe" class="vencidos">
			<div class="inline" style="width: 320px;">
				
				<h1>B&uacute;squeda Gastos</h1>
				
				<form name="frm_filter" method="post" action="<?=site_url('informe/gastos')?>">
					<table>
						<tr>
							<td>F. Inicial</td>
							<td>
								<input type="text" readonly="readonly" name="inicial" id="inicial" value="<?=$inicial?>" />
								<input type="button" value="" class="btn_calendar" id="f_inicial" />
								<script type="text/javascript" language="javascript">//<![CDATA[
					                  var cal = Calendar.setup({
					                      onSelect: function(cal) { cal.hide() },
					                      showTime: false
					                  });
					                  cal.manageFields("f_inicial", "inicial", "%Y-%m-%d");
					            //]]></script>
							</td>
						</tr>
						<tr>
							<td>Fecha Final</td>
							<td>
								<input type="text" readonly="readonly" name="final" id="final" value="<?=$final?>" />
								<input type="button" value="" class="btn_calendar" id="f_final" />
								<script type="text/javascript" language="javascript">//<![CDATA[
					                  var cal = Calendar.setup({
					                      onSelect: function(cal) { cal.hide() },
					                      showTime: false
					                  });
					                  cal.manageFields("f_final", "final", "%Y-%m-%d");
					            //]]></script>
							</td>
						</tr>
						<tr>
							<td>Tipo Gasto</td>
							<td>
								<select name="tipogasto">
									<option value="">Todos</option>
									<?php
										foreach($tiposgasto as $key => $value){
											if($key == $tipogasto){
												echo '<option selected="selected" value="'.$key.'">'.$value.'</option>';
											}else{
												echo '<option value="'.$key.'">'.$value.'</option>';
											}
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<input type="submit" name="filter" value="Buscar" />								
							</td>
						</tr>
					</table>
				</form>
			</div>
			
			<div class="inline" style="width: 700px;">
				
				<table class="format" cellspacing="0">
					<thead>
						<tr>
							<th class="fecha">Fecha</th>
							<th class="concepto">Concepto</th>
							<th class="valor">Valor</th>
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
							<td class="fecha"><?=$gasto['fecha']?></td>
							<td class="concepto"><?=$gasto['concepto']?></td>
							<td class="valor">$ <?=number_format($gasto['valor'])?></td>
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
		
		
	</div>
	
	<?=read_message()?>
	
</body>