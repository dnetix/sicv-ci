<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="Diego Calle">
	<title>Impresi&oacute;n de Contrato -SICV-</title>
	<link href="<?=base_url('assets/img/favicon.ico')?>" rel="shortcut icon" />
	
	<link rel="stylesheet" href="<?=base_url("assets/css/base.css")?>" />
	<link rel="stylesheet" href="<?=base_url("assets/css/imprimir.css")?>" />
	
	<script src="<?=base_url('assets/js/jquery-1.9.1.min.js')?>"></script>
	
	<script>
		
		
		
	</script>
	
</head>
<body>
	
	<?=$this->load->view('ads/header')?>
	
	<div id="main_container">
		
		<div id="contrato_wrapper">
			<div id="c_logo">
				<img alt="Logo Empresa" src="<?=base_url('assets/img/'.$logo)?>" />
			</div>
			
			<div id="c_emitidopor">
				<h1><?=$nombreEmpresa?></h1>
				<h2><?=$nitEmpresa?></h2>
				<h3><?=$direccionEmpresa.' - '.$ciudadEmpresa.' - '.' Tel. '.$telefonoEmpresa?></h3>
			</div>
			
			<div id="c_codigo">
				
			</div>
			
			<div id="c_contrato">
				<p class="c_ubicacion"><?=$ciudadEmpresa?>, <?=date_print_format($fechaingreso)?></p>
				
				<p class="c_clausula">Yo, <strong><?=$nombreCliente?></strong>, mayor de edad con <?=strtolower($tipoidCliente)?> n&uacute;mero <strong><?=$idcliente?></strong> de <strong><?=$lugarExpedicion?></strong>, vendo a <strong><?=$razonsocial?></strong> el art&iacute;culo(s)</p>
				
				<p class="c_articulo"><?=$articulo?></p>
				
				<p class="c_valor">Por un valor de <strong>$ <?=number_format($valorContrato)?></strong></p>
				
				<p class="c_legal">
					Declaro que los bienes que vendo son de mi exclusiva propiedad, tienen procedencia l&iacute;cita y sobre ellos no existe ning&uacute;n gravamen, pignoraci&oacute;n o limitaci&oacute;n de dominio. Me comprometo adem&aacute;s a responder ante el comprador por los perjucios que se deriven de cualquier reclamo respecto a la legitimidad de los objetos vendidos. Este contrato de compraventa queda sometido al pacto de retroventa seg&uacute;n el art&iacute;culo 1939 del C&oacute;digo Civil, en virtud del cual me reservo la facultad de recobrar los bienes vendidos reembolsando al comprador la cantidad de: <strong>$ <?=number_format($retroventa)?></strong> 
				</p>
				
				<p class="c_legal2">
					Facultad que ejerceré durante un término de <strong><?=$nromeses * 30?></strong> días. Si transcurrido este plazo, no hago uso de la acción de retroventa, la venta se considera pura y simple en consecuencia el comprador puede disponer libremente de los objetos.
				</p>
				
				<p class="c_fecha_vencimiento">
					Fecha Vencimiento: <strong><?=date_print_format($fechavencimiento)?></strong>
				</p>
				
				<p class="c_firma">
					Firma Vendedor
				</p>
				
				<p class="c_nota">
					Nota: No respondemos por la pérdida del presente contrato. No somos responsables por robo o hurto, atraco, incendio, fuerza mayor o cualquier otro caso fortuito.
				</p>
				
			</div>
		</div>
		
		<div class="buttons">
			<a href="javascript:void(0)" onclick="print()" class="abutton btn_print">Imprimir</a>
			<a href="<?=site_url('init/menu')?>" class="abutton btn_end">Finalizar</a>
		</div>
		
	</div>
	
</body>