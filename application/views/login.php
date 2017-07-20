<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="Diego Calle">
	<title>Login de Usuarios -SICV-</title>
	<link rel="stylesheet" href="<?=base_url("assets/css/base.css")?>" />
	<link href="<?=base_url('assets/img/favicon.ico')?>" rel="shortcut icon" />
	<script src="<?=base_url('assets/js/jquery-1.9.1.min.js')?>"></script>
	<script src="<?=base_url('assets/js/base.js')?>"></script>
	<style>
		#login_wrapper {
			width: 860px;
			margin: 12% auto;
		}
		
		#logo_container {
			display: inline-block;
			vertical-align: top;
			width: 300px;
			padding: 80px 50px;
		}
		
		#login_container {
			display: inline-block;
			vertical-align: top;
			width: 240px;
			height: 240px;
			padding: 50px;
			background: #FFDD20;
			margin-left: 50px;
		}
		
			#login_container .input_group {
				margin: 15px 0;
			}
		
		.login_input {
			display: block;
			width: 220px;
			padding: 8px;
			font-size: 16px;
			text-align: center;
		}
		
		.login_button {
			display: block;
			width: 238px;
			height: 35px;
			margin: 20px 0 0 0;
			text-align: center;
		}
		
		
	</style>
</head>
<body>
	
	<div id="login">
		<div id="login_wrapper">
			
			<div id="logo_container">
				<img src="<?=base_url("assets/img/logobig.png")?>" alt="Logo SICV" />
			</div>
			
			<div id="login_container">
				<form name="login" method="post" action="<?=site_url("/usuario/login")?>">
					<h1>Inicia sesi&oacute;n</h1>
					<div class="input_group">
						<label for="username">Nombre de usuario</label>
						<input type="text" id="username" class="login_input" name="username" placeholder="Nombre de Usuario" required="required" />
					</div>
					<div class="input_group">
						<label for="password">Contrase&ntilde;a</label>
						<input type="password" id="password" class="login_input" name="password" placeholder="Password" required="required" />
					</div>
					<input type="submit" class="blue_button login_button" value="Acceder" class="submit" />
				</form>
			</div>
		</div>
	</div>
	
	<?=read_message()?>
	
</body>