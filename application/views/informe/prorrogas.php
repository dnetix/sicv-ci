<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="Diego Calle">
	<title>Informe Contratos Vencidos -SICV-</title>
	<link href="<?=base_url('assets/img/favicon.ico')?>" rel="shortcut icon" />
	
	<link rel="stylesheet" href="<?=base_url("assets/css/base.css")?>" />
	
	<script src="<?=base_url('assets/js/jquery-1.9.1.min.js')?>"></script>
	<script src="<?=base_url('assets/js/base.js')?>"></script>
	
	<!-- SCRIPTS PARA JSCAL Calendario Javascript -->
	<link type="text/css" rel="stylesheet" href="<?=base_url("assets/jscal/css/jscal2.css")?>" />
	<script src="<?=base_url("assets/jscal/js/jscal2.js")?>"></script>
	<script src="<?=base_url("assets/jscal/js/lang/es.js")?>"></script>
	
	<style>
		#informe {
			margin-bottom: 25px;
		}
	</style>
</head>
<body>
	
	<?=$this->load->view('ads/header')?>
	
	<div id="main_container">
		
		<div id="filtros">
			<form name="frm_filter" method="get" action="<?=site_url('informe/prorroga')?>">
				Filtrar por Fecha Inicial
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
		
		<div id="informe" class="vencidos">
			
			<h2>Prorrogas Ingresadas (<?=$results->num_rows()?>)</h2>
			
			<?php
			if($results->num_rows() >= 1){
			?>
			<table align="center">
				<thead>
					<tr>
						<th>Fecha</th>
						<th>Contrato</th>
						<th>Cliente / Articulo</th>
						<th>Valor Contrato</th>
						<th>Abonado</th>
					</tr>
				</thead>
				<tbody>
			<?php	
				$total = 0;
				foreach($results->result_array() as $prorroga){
					$total += $prorroga['valorprorroga'];
			?>
				<tr>
					<td class="centered"><?= $prorroga['fecha'] ?></td>
					<td class="centered"><a href="<?= site_url('contrato/ver/'.$prorroga['contrato']) ?>"><?= $prorroga['contrato'] ?></a></td>
					<td><a href="<?= site_url('cliente/ver/'.$prorroga['cliente']) ?>"><?= $prorroga['nombrecliente'] ?></a><br /><?= $prorroga['articulo'] ?></td>
					<td class="centered">$ <?= number_format($prorroga['valorcontrato']) ?></td>
					<td class="centered">$ <?= number_format($prorroga['valorprorroga']) ?></td>
				</tr>
			<?php
				}
			?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="4">Total</th>
						<th>$ <?= number_format($total) ?></th>
					</tr>
				</tfoot>
			</table>
			<?php
			}else{
			?>
			<p class="centered">No hay abonos que coincidan con este filtro</p>
			<?php
			}
			?>
			
		</div>
	</div>
	
	<?=read_message()?>
	
</body>