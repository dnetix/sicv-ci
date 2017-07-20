<!DOCTYPE html>
<head>
	
	<meta charset="UTF-8">
	<meta name="author" content="Diego Calle">
	<title>Impresi&oacute;n de Contrato -SICV-</title>
	<link href="<?=base_url('assets/img/favicon.ico')?>" rel="shortcut icon" />
	<link rel="stylesheet" href="<?=base_url("assets/css/base.css")?>" />
	<link rel="stylesheet" href="<?=base_url("assets/css/imprimir.css")?>" />
	
	<script src="<?=base_url('assets/js/jquery-1.9.1.min.js')?>"></script>
	
</head>
<body>
	
	<?=$this->load->view('ads/header')?>
	
	<div id="main_container">
		<div id="contrato_page">
			<div id="contrato_wrapper">
				<?php
				if($copia){
				?>
					<div class="copia">DUPLICADO</div>
				<?php
				}
				?>
				<h2 class="titulo">Contrato de Compraventa</h2>
				
				<div id="datoscompraventa">
					<p><img alt="Logo Empresa" src="<?=base_url('assets/img/'.$logo)?>" /></p>
					<p>Contrato de compraventa con pacto de retroventa, Art&iacute;culo 1939 del C&oacute;digo Civil Colombiano</p>
					<p><strong><?=$direccionEmpresa.' - '.$ciudadEmpresa.' - '.' Tel. '.$telefonoEmpresa?></strong></p>
				</div>
				
				<div id="serial">
					<p class="barcode"><?=utf8_encode($coder->getBarCode($idcontrato))?></p>
					<h3>Contrato No. <span><?=$idcontrato?></span></h3>
				</div>
				
				<div id="contrato">
					<div id="fechas">
						<div class="fi">Fecha Contrato: <strong><?= dmy_date($fechaingreso) ?></strong></div>
						<div class="fv">Fecha Vencimiento: <strong><?= dmy_date($fechavencimiento) ?></strong></div>
					</div>
					<div id="partes">
						<p>Entre los suscritos <strong><?=strtoupper($nombreCliente)?></strong> identificado con <?=strtolower($tipoidCliente)?> No. <strong><?=$idcliente?></strong>, expedida en <strong><?=$lugarExpedicion?></strong> domiciliado
							en <strong><?=$ciudadDomicilio?></strong> Tel: <strong><?=$telefonoCliente?></strong>, mayor de edad quien obra en nombre propio y se denomina para efectos del presente contrato EL VENDEDOR de una parte; Y por otra parte
							quien para los efectos del presente contrato se denominar&aacute; EL COMPRADOR en representaci&oacute;n del establecimiento de comercio denominado <strong><?=$nombreEmpresa?></strong> Raz&oacute;n 
							Social <strong><?=$razonsocial?></strong> NIT <strong><?=$nitEmpresa?></strong> Ubicado en la <strong><?=$direccionEmpresa.' - '.$ciudadEmpresa.' - '.' Tel. '.$telefonoEmpresa?></strong> Manifestamos que hemos
							celebrado un contrato de compraventa sobre el(los) siguiente(s) bien(es) mueble(s) que a continuaci&oacute;n se identifica(n)</p>
					</div>
					<div id="articulo">
						<h4>Descripci&oacute;n detallada de articulo objeto de esta compraventa</h4>
						<p><?=$articulo?></p>
						<p id="valor">El precio de la compraventa es la suma de: <strong>$ <?=number_format($valorContrato)?></strong></p>
					</div>
					
					<div id="legal">
						<p>EL VENDEDOR transfiere al COMPRADOR a t&iacute;tulo de compraventa el derecho de dominio y posesi&oacute;n que tiene y ejerce sobre los anteriores art&iacute;culos y declara que los bienes que
							transfiere, los adquiri&oacute; l&iacute;citamente, no fue su importador, son de su exclusiva propiedad, los posee de manera regular, p&uacute;blica y pacifica, est&aacute;n libres de gravamen,
							limitaci&oacute;n al dominio, pleitos pendientes y embargos, con la obligaci&oacute;n de salir al saneamiento en casos de ley.</p>
					</div>
					
					<div id="clausulas">
						<h4>Clausulas accesorias que rigen el presente contrato</h4>
						<p><strong>Primera:</strong> Los contratantes de conformidad con el articulo 1939 del C&oacute;digo Civil Colombiano, EL VENDEDOR se reserva la facultad de recobrar los articulos vendidos por 
							medio de este contrato, pagando al COMPRADOR como Precio de retroventa la suma de: <strong>$ <?=number_format($retroventa)?></strong></p>
						<p><strong>Segunda:</strong> El derecho que nace del pacto de retroventa del presente contrato, no podr&aacute; cederse a ning&uacute;n titulo. En caso de perdida de este contrato EL VENDEDOR 
							se obliga a dar noticia inmediata al COMPRADOR y &eacute;ste, s&oacute;lo exhibir&aacute; el articulo descrito para la terminaci&oacute;n del presente contrato.</p>
						<p><strong>Tercera:</strong> EL VENDEDOR y EL COMPRADOR pactan que la facultad de retroventa del presente contrato la podrá ejercer EL VENDEDOR dentro del t&eacute;rmino de <strong><?=$nromeses * 30?> d&iacute;as</strong>
							contados a partir de la firma del presente documento.</p>
						<p><strong>Cuarta:</strong> Las partes aqu&iacute; firmantes, hemos establecido que en caso de deterioro o p&eacute;rdida de los articulos descritos, ocasionada por fuerza mayor o caso fortuito, 
							se exonerar&aacute; de cualquier responsabilidad AL COMPRADOR.</p>
						<p><strong>Quinta:</strong> Las controversias relativas al presente contrato, se resolver&aacute;n por un tribunal de arbitramiento de conformidad con las disposiciones que rigen la materia
							nombrado por la C&aacute;mara de Comercio de esta ciudad.</p>
					</div>
					
					<div id="firma">
						<p>TANTO VENDEDOR COMO COMPRADOR HAN LE&Iacute;DO, COMPRENDIDO Y ACEPTADO EL TEXTO DE ESTE CONTRATO.</p>
						<p>En constancia de lo anterior lo firman las partes en <?=$ciudadEmpresa?> a los <strong><?=date_contract_format($fechaingreso)?></strong></p>
					</div>
					
					<div id="firmavendedor">
						<p>EL VENDEDOR</p>
						<p><?=$tipoid?></p>
					</div>
					
					<div class="huella">&nbsp;</div>
					
					<div id="firmacomprador">
						<p>EL COMPRADOR</p>
						<p>CC</p>
					</div>
					
				</div>
				
				<div class="buttons">
					<a href="javascript:void(0)" onclick="print()" class="blue_button btn_print">Imprimir</a>
					<a href="<?=site_url('init/menu')?>" class="blue_button btn_end">Finalizar</a>
				</div>
				
			</div>
		</div>
		
	</div>
	
</body>