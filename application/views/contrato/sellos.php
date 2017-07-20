<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="Diego Calle">
	<title>Sellos de contratos -SICV-</title>
	<link href="<?=base_url('assets/img/favicon.ico')?>" rel="shortcut icon" />
	
	<script src="<?=base_url('assets/js/jquery-1.9.1.min.js')?>"></script>
	<link rel="stylesheet" href="<?=base_url("assets/css/base.css")?>" />
	<link rel="stylesheet" href="<?=base_url("assets/css/imprimir.css")?>" />
	
	<!-- SCRIPTS PARA JSCAL Calendario Javascript -->
	<link type="text/css" rel="stylesheet" href="<?=base_url("assets/jscal/css/jscal2.css")?>" />
	<script src="<?=base_url("assets/jscal/js/jscal2.js")?>"></script>
	<script src="<?=base_url("assets/jscal/js/lang/es.js")?>"></script>
	
</head>
<body>
	
	<?=$this->load->view('ads/header')?>
	
	<div id="main_container">
		
		<div id="filtros">
			<form name="frm_filter" method="post" action="<?=site_url('operacion/sellos')?>">
				<span>Nro de Sellos <strong>(<?=$sellos->num_rows()?>)</strong></span> | 
				Filtrar por Fecha Inicial
				<input type="text" readonly="readonly" name="inicial" id="inicial" value="<?=$inicial?>" />
				<input type="button" value="" class="btn_calendar" id="f_inicial" />
				<script type="text/javascript" language="javascript">//<![CDATA[
                      var cal = Calendar.setup({
                          onSelect: function(cal) { cal.hide() },
                          showTime: false
                      });
                      cal.manageFields("f_inicial", "inicial", "%Y-%m-%d");
                //]]></script>
                
				Fecha Final
				<input type="text" readonly="readonly" name="final" id="final" value="<?=$final?>" />
				<input type="button" value="" class="btn_calendar" id="f_final" />
				<script type="text/javascript" language="javascript">
                      cal.manageFields("f_final", "final", "%Y-%m-%d");
                </script>
                
				<input type="submit" class="blue_button" name="filter" value="Filtrar" />
			</form>
		</div>
		
		<div id="sellos_container">
		<?php
			foreach($sellos->result_array() as $sello){
		?>
			<div class="c_sello">
				<p class="barcode"><?=utf8_encode($coder->getBarCode($sello['idcontrato']))?></p>
				<h3><?=$sello['idcontrato']?></h3>
				<p class="sello_fecha"><?=$sello['fechaingreso']?></p>
				<p class="sello_articulo"><?=substr($sello['articulo'], 0, 100)?></p>
				<p class="sello_valor">$ <?=number_format($sello['valor'])?></p>
			</div>
		<?php	
			}
		?>
	</div>
	
</body>