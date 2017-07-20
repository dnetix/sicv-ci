<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="Diego Calle">
	<title>Men&uacute; Principal -SICV-</title>
	<link rel="stylesheet" href="<?=base_url("assets/css/base.css")?>" />
	<link href="<?=base_url('assets/img/favicon.ico')?>" rel="shortcut icon" />
	<script src="<?=base_url('assets/js/jquery-1.9.1.min.js')?>"></script>
	<script src="<?=base_url('assets/js/base.js')?>"></script>
	
	<script>
		var t;
		var del = 20000; 
		$(document).mousemove(function(){
			clearTimeout(t);
			//when the mouse is moved
			t = setTimeout(function(){
				//If the mouse is not moved
				$('#qsearch').focus();
			}, del);
		});
		
		function validar(){
			
			if($("#nombre").val().length < 5){
				alert("Debe ingresar un nombre valido");
				return false;
			}
			
			if($("#newpass").val() != ""){
				if($("#newpass").val().length < 5){
					alert("La contraseña debe de ser de al menos 6 caracteres");
					return false;
				}
				if($("#newpass").val() != $("#newpass_check").val()){
					alert("Las contraseñas no coinciden");
					return false;
				}
			}
			
			$("#frm_editar").submit();
		}
	</script>
	
</head>
<body>
	
	<?=$this->load->view('ads/header')?>
	
	<div id="main_container">
		
		<div id="left_container">
			<h1>Edicion de Datos de Usuario</h1>
			<form name="frm_editar" id="frm_editar" method="post" action="<?=site_url('usuario/editar')?>">
				
				<table class="form">
					<tr>
						<td><label>Id Usuario</label></td>
						<td>
							<input type="text" readonly="readonly" value="<?=$idusuario?>" />
						</td>
					</tr>
					<tr>
						<td><label>Nombre</label></td>
						<td>
							<input type="text" name="nombre" class="s_nombre" id="nombre" value="<?=$nombre?>" />
						</td>
					</tr>
					<tr>
						<td><label>Telefono</label></td>
						<td>
							<input type="text" name="telefono" class="s_telefono" value="<?=$telefono?>" />
						</td>
					</tr>
					<tr>
						<td><label>Email</label></td>
						<td>
							<input type="text" name="email" class="s_email" value="<?=$email?>" />
						</td>
					</tr>
				</table>
				
				<h2>Cambio de contrase&ntilde;a</h2>
				
				<table class="form">
					<tr>
						<td><label>Contrase&ntilde;a Actual</label></td>
						<td>
							<input type="password" name="oldpass" id="oldpass" />
						</td>
					</tr>
					<tr>
						<td><label>Contrase&ntilde;a Nueva</label></td>
						<td>
							<input type="password" name="newpass" id="newpass" />
						</td>
					</tr>
					<tr>
						<td><label>Confirma Contrase&ntilde;a</label></td>
						<td>
							<input type="password" name="newpass_check" id="newpass_check" />
						</td>
					</tr>
					<tr>
						<td colspan="4" class="buttons">
							<input type="hidden" name="editar" value="1" />
							<input type="button" value="Editar" onclick="validar()" />
						</td>
					</tr>
				</table>
				
			</form>
		</div>
		<div id="right_container">
			
		</div>
		
	</div>
	
	<?=read_message()?>
	
</body>