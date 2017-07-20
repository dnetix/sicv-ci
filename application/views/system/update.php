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
	</script>
	
</head>
<body>
	
	<?=$this->load->view('ads/header')?>
	
	
	
	<div id="main_container">
		
		<?=var_dump($info)?>
		
	</div>
	
	<?=read_message()?>
	
</body>