<!DOCTYPE html>
<head>
	
	<meta charset="UTF-8">
	<meta name="author" content="Diego Calle">
	<title>Impresi&oacute;n de Contrato -SICV-</title>
	<link href="<?=base_url('assets/img/favicon.ico')?>" rel="shortcut icon" />
	<link rel="stylesheet" href="<?=base_url("assets/css/base.css")?>" />
	<link rel="stylesheet" href="<?=base_url("assets/css/imprimir.css")?>" />
	
	<script src="<?=base_url('assets/js/jquery-1.9.1.min.js')?>"></script>
	
	<style>
		th {
			text-align: center;
		}
	</style>
	
</head>
<body>
	
	<?=$this->load->view('ads/header')?>
	
	<div id="main_container">
		<div id="contrato_page">
			<div id="contrato_wrapper">
				<h2 class="titulo">Nota de Cobro</h2>
				
				<div id="datoscompraventa">
					<p>Emitida por:</p>
					<p><img alt="Logo Empresa" src="<?=base_url('assets/img/'.$logo)?>" /></p>
					<p><strong><?=$direccionEmpresa.' - '.$ciudadEmpresa.' - '.' Tel. '.$telefonoEmpresa?></strong></p>
				</div>
				
				<div id="serial">
					<p class="barcode"><?=utf8_encode($coder->getBarCode('NC'.$idnotacobro))?></p>
					<h3>Nota Cobro No. <span><?=$idnotacobro?></span></h3>
				</div>
				
				<div id="contrato">
					<div id="partes">
						<p>Yo, <strong><?=strtoupper($nombreCliente)?></strong> identificado con <?=strtolower($tipoidCliente)?> No. <strong><?=$idcliente?></strong>, expedida en <strong><?=$lugarExpedicion?></strong> domiciliado
							en <strong><?=$ciudadDomicilio?></strong> Tel: <strong><?=$telefonoCliente?></strong>, en calidad de COMPRADOR(A), del producto(s) que a continuaci&oacute;n se describe(n):
					</div>
					
					<div id="articulo">
						<h4>Descripci&oacute;n detallada de articulo</h4>
						<table>
							<tr>
								<th>Articulo</th>
								<th>Descripcion</th>
								<th>Cantidad</th>
								<th>Precio</th>
							</tr>
						<?php
							$total = 0;
							foreach($detalles->result_array() as $detalle){
								$total += $detalle['valor'];
						?>
							<tr>
								<td class="n_idarticulo"><?=$detalle['idarticulo']?></td>
								<td class="n_descripcion"><?=$detalle['articulo']?></td>
								<td class="n_cantidad"><?=$detalle['cantidad']?></td>
								<td class="n_precio">$ <?=number_format($detalle['valor'])?></td>
							</tr>
						<?php
							}
						?>
							<tr>
								<th colspan="3">Total</th>
								<th>$ <?=number_format($total)?></th>
							</tr>
						</table>
					</div>
					
					<div id="legal">
						<p>Soy consciente y plenamente capaz del negocio jur&iacute;dico que he realizado, naturaleza, consecuencias, caracter&iacute;sticas, condiciones, calidad entre otras; Se me han explicado
							satisfactoriamente las obligaciones y derechos, que poseo</p>
						<p>No opera el derecho de retracto, ya que no se realiz&oacute; el negocio bajo la figura de sistema de financiaci&oacute;n o venta a distancia. (Art. 47 Ley 1480 de 2011)</p>
					</div>
					
					<div id="firma">
						<?php
							if($garantia == 0){
						?>
							<p>Acepto en calidad de COMPRADOR. Que este art&iacute;culo usado o de segunda, antes descrito NO tiene garant&iacute;a. Ya que ha expirado el t&eacute;rmino de garant&iacute;a legal.</p>
						<?php
							}else{
						?>
							<p>Acepto en calidad de COMPRADOR. Que este art&iacute;culo usado o de segunda, antes descrito tiene una garant&iacute;a de <?=$garantia?> d&iacute;as. No opera la garant&iacute;a
								por mal uso, manejo o maltrato al producto por parte del consumidor.</p>
						<?php
							}
						?>
						<p>TANTO VENDEDOR COMO COMPRADOR HAN LE&Iacute;DO, COMPRENDIDO Y ACEPTADO EL TEXTO DE ESTE CONTRATO.</p>
						<p>En constancia de lo anterior lo firman las partes en <?=$ciudadEmpresa?> a los <strong><?=date_contract_format($fecha)?></strong></p>
					</div>
					
					<div id="firmacomprador">
						<p>EL COMPRADOR</p>
						<p>CC</p>
					</div>
					<div class="huella">&nbsp;</div>
					<div id="firmavendedor">
						<p>EL VENDEDOR</p>
						<p><?=$tipoid?></p>
					</div>
					
				</div>
				
			</div>
		</div>
		
		<div class="buttons">
			<a href="javascript:void(0)" onclick="print()" class="abutton btn_print">Imprimir</a>
			<a href="<?=site_url('init/menu')?>" class="abutton btn_end">Finalizar</a>
		</div>
		
	</div>
	
</body>