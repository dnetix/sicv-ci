<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="Diego Calle">
	<title>Men&uacute; Principal -SICV-</title>
	<link rel="stylesheet" href="<?=base_url("assets/css/base.css")?>" />
	<link href="<?=base_url('assets/img/favicon.ico')?>" rel="shortcut icon" />
	<script src="<?=base_url('assets/js/jquery-1.9.1.min.js')?>"></script>
	<script src="<?=base_url('assets/js/base.js')?>"></script>
	
	<link rel="stylesheet" href="<?=base_url("assets/css/imprimir.css")?>" />
	
	<style>
		h1 {
			margin-bottom: 20px;
		}
	</style>
	
</head>
<body>
	
	<?=$this->load->view('ads/header')?>
	
	
	
	<div id="main_container">
		
		<div id="left_container">
			
			<h1>Editar Datos Compraventa</h1>
			
			<form name="frm_editar" id="frm_editar" method="post" enctype="multipart/form-data" action="<?=site_url('sistema/cambiardatos')?>">
				
				<table class="form">
					<tr>
						<td><label>Raz&oacute;n Social</label></td>
						<td>
							<input type="text" name="razonsocial" class="s_nombre" value="<?=$razonsocial?>" />
						</td>
					</tr>
					<tr>
						<td><label>Nombre Empresa</label></td>
						<td>
							<input type="text" name="nombre" class="s_nombre" id="nombre" value="<?=$nombreEmpresa?>" />
						</td>
					</tr>
					<tr>
						<td><label>Nit</label></td>
						<td>
							<input type="text" name="nit" class="s_telefono" value="<?=$nitEmpresa?>" />
						</td>
					</tr>
					<tr>
						<td><label>Direcci&oacute;n</label></td>
						<td>
							<input type="text" name="direccion" class="s_email" value="<?=$direccionEmpresa?>" />
						</td>
					</tr>
					<tr>
						<td><label>Tel&eacute;fono</label></td>
						<td>
							<input type="text" name="telefono" class="s_telefono" value="<?=$telefonoEmpresa?>" />
						</td>
					</tr>
					<tr>
						<td><label>Ciudad</label></td>
						<td>
							<input type="text" name="ciudad" class="s_nombre" value="<?=$ciudadEmpresa?>" />
						</td>
					</tr>
					<tr>
						<td>
							<label>Logotipo</label>
							<p class="small_hint">La imagen no debe exceder los 2048x2048</p>
						</td>
						<td>
							<input type="file" name="logotipo" />
							<p><img alt="Logo Empresa" src="<?=base_url('assets/img/'.$logo)?>" /></p>
						</td>
					</tr>
					<tr>
						<td colspan="4" class="buttons">
							<input type="hidden" name="actualizar" value="1" />
							<input type="submit" value="Editar" />
						</td>
					</tr>
				</table>
				
			</form>
		</div>
		<div id="right_container">
			
		</div>
		
		<h2>Vista Previa en Contrato</h2>
		
		<div id="contrato_wrapper_prev">
			<h2 class="titulo">Contrato de Compraventa</h2>
			
			<div id="datoscompraventa">
				<p><img alt="Logo Empresa" src="<?=base_url('assets/img/'.$logo)?>" /></p>
				<p>Contrato de compraventa con pacto de retroventa, Art&iacute;culo 1939 del C&oacute;digo Civil Colombiano</p>
				<p><strong><?=$direccionEmpresa.' - '.$ciudadEmpresa.' - '.' Tel. '.$telefonoEmpresa?></strong></p>
			</div>
			
			<div id="serial">
				<p class="barcode"><?=utf8_encode($coder->getBarCode('00000'))?></p>
				<h3>Contrato No. 00000</h3>
			</div>
		</div>
		
	</div>
	
	<?=read_message()?>
	
</body>