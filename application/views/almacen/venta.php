<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="Diego Calle">
	<title>Nueva venta -SICV-</title>
	<link href="<?=base_url('assets/img/favicon.ico')?>" rel="shortcut icon" />
	
	<link rel="stylesheet" href="<?=base_url("assets/css/base.css")?>" />
	
	<script src="<?=base_url('assets/js/jquery-1.9.1.min.js')?>"></script>
	<script src="<?=base_url('assets/js/base.js')?>"></script>
	<script src="<?=base_url('assets/js/ajax.js')?>"></script>
	<script>
		
		var timer;
		var ids = new Array();
		var nro = 0;
		
		function updateValor(field){
			setMoneyValue('show'+field, field);
		}
		
		function buscarCliente(q){
			clearTimeout(timer);
			timer = setTimeout(function () {
				$("#ajax_cliente").slideDown('fast');
				doSearchCliente(q.value);
			}, 1000);
		}
		
		function seleccionarCliente(idcliente, nombre, telefono){
			$("#txt_client_q").val("");
			$("#buscarcliente").slideUp("fast");
			$("#idcliente").val(idcliente);
			$("#q_idcliente").val(idcliente);
			$("#nombre").val(nombre);
			$("#telefono").val(telefono);
			$("#infocliente").slideDown("fast");
			$("#ajax_cliente").slideUp("fast");
			$("#articulo")[0].focus();
		}
		
		function removeCliente(){
			$("#buscarcliente").slideDown("fast");
			$("#idcliente").val("");
			$("#q_idcliente").val("");
			$("#nombre").val("");
			$("#telefono").val("");
			$("#infocliente").slideUp("fast");
		}
		
		function historiaCliente(){
			$("#frm_ver").submit();
		}
		
		function buscarArticulo(q){
			clearTimeout(timer);
			timer = setTimeout(function () {
				if(q.value.length > 1){
					$("#ajax_articulo").slideDown('fast');
					doBuscarArticulo(q.value);
				}else{
					$("#ajax_articulo").slideUp('fast');
				}
			}, 1000);
		}
		
		function seleccionarArticulo(idarticulo){
			var i = parseInt($("#nroproductos").val()) + 1;
			$("#nroproductos").val(i);
			
			if($.inArray(idarticulo, ids) != -1){
				alert("Ya ingresó este producto");
			}else{
				ids[i] = idarticulo
				nro++;
				$("#nro").html(nro);
				doSeleccionarArticulo(idarticulo, i);
			}
			$("#ajax_articulo").slideUp("fast");
			$("#q_articulo").val('');
		}
		
		function deleteArticulo(id){
			ids[id] = '';
			nro--;
			$("#nro").html(nro);
			$("#articulo_"+id).remove();
			totalizar();
		}
		
		function totalizar(){
			var total = 0;
			for(var i = 1; i <= nro; i++){
				total += parseInt($("#valorventa_"+i).val());
			}
			$("#total").html(getMoneyValue(total));
		}
		
		function validar(){
			if($("#idcliente").val() == ""){
				alert("Debe seleccionar un cliente para realizar la venta")
			}else if(nro == 0){
				alert("No puede realizar una venta sin articulos");
				return false;
			}
			
			$("#garantia").val($("#show_garantia").val());
			return true;
			
		}
	</script>
	<style>
	
		#infocliente table .buttons {
				text-align: right;
			}
			
		#infocliente tr td:first-child label {
			display: inline-block;
			width: 120px;
		}
	
		#buscarcliente label, #buscarproducto label, #wrp_garantia label {
			display: inline-block;
			width: 120px;
		}
		
		#q_articulo {
			width: 340px;
		}
	
		.big_wrap {
			margin-left: 0;
			margin-right: 10px;
		}
		
		#select_articulo .format tbody tr:hover {
			cursor: pointer;
		}
		
		.module {
			margin-bottom: 10px;
		}
		
		#buscarproducto .idarticulo, #productos .idarticulo {
			text-align: center;
			width: 50px;
		}
		
		#buscarproducto .contrato, #productos .contrato {
			text-align: center;
			width: 70px;
		}
		
		#buscarproducto .articulo, #productos .articulo {
			width: 340px;
		}
		
		#buscarproducto .valor, #productos .valor {
			text-align: center;
			width: 90px;
		}
		
		#buscarproducto .cantidad {
			text-align: center;
			width: 60px;
		}
		
		.inp_venta {
			width: 70px;
		}
	</style>
</head>
<body>
	
	<?=$this->load->view('ads/header')?>
	
	<div id="main_container">
		
		<h1>Nueva venta</h1>
		
		<div class="big_wrap">
			<form name="frm_nuevaventa" id="frm_nuevaventa" method="post" onsubmit="return validar()" onreset="removeCliente()" action="<?=site_url('almacen/checkout')?>">
			
				<div class="module">
					<div id="buscarcliente" class="big_box blue <?= $buscar ?>">
						<table>
							<tr>
								<td><label for="txt_client_q">Buscar Cliente</label></td>
								<td><input type="text" id="txt_client_q" class="s_nombre" placeholder="Identificaci&oacute;n o Nombre" autocomplete="off" onkeyup="buscarCliente(this)" /></td>
							</tr>
						</table>
					</div>
				</div>
				
				<div class="module">
					<div id="infocliente" class="big_box blue <?= $ver ?>">
						<h2>Datos Cliente</h2>
						<table>
							<tr>
								<td><label>Identificaci&oacute;n</label></td>
								<td><input type="text" name="idcliente" id="idcliente" class="s_idcliente" readonly="readonly" value="<?= $idcliente ?>" /></td>
								<td colspan="2" class="buttons">
									<input type="button" onclick="historiaCliente()" class="green_button" value="Historial" />
									<input type="button" onclick="removeCliente()" class="red_button" value="Cambiar" />
								</td>
							</tr>
							<tr>
								<td><label>Nombre</label></td>
								<td><input type="text" name="nombre" id="nombre" class="s_nombre" readonly="readonly" value="<?= $nombre ?>" /></td>
								<td class="space"><label>Tel&eacute;fono</label></td>
								<td><input type="text" id="telefono" class="s_telefono" readonly="readonly" value="<?= $telefono ?>" /></td>
							</tr>
						</table>
					</div>
				</div>
				
				<div class="module">
					<div id="ajax_cliente" class="big_box blue"></div>
				</div>
				
				<div class="module">
					<div id="buscarproducto" class="big_box orange">
						<label>Buscar Articulo</label>
						<input type="text" id="q_articulo" onkeyup="buscarArticulo(this)" autocomplete="off" placeholder="Nombre, contrato o Id" />
						<div id="ajax_articulo"></div>
					</div>
				</div>
				
				<div class="module">
					<div id="articulos" class="big_box orange">
						<h2>Productos a facturar (<span id="nro">0</span>)</h2>
						<table id="productos" class="format" cellspacing="0">
							<thead>
								<tr>
									<th class="idarticulo">Id</th>
									<th class="contrato">Contrato</th>
									<th class="articulo">Art&iacute;culo</th>
									<th class="valor">V. Compra</th>
									<th class="valor">V. Venta</th>
									<th class="options">Op.</th>
								</tr>
							</thead>
							<tbody id="productos"></tbody>
							<tfoot>
								<th colspan="4">Total</th>
								<th id="total">$ 0</th>
								<th>&nbsp;</th>
							</tfoot>
						</table>
					</div>
				</div>
				
				<div id="botones" class="module">
					<div class="buttons">
						<input type="hidden" name="nroproductos" id="nroproductos" value="0" />
						<input type="hidden" name="garantia" id="garantia" value="0" />
						
						<input type="submit" class="blue_button" value="Guardar" />
						<input type="reset" class="red_button" value="Cancelar" />
					</div>
				</div>
				
			</form>
		</div>
		
		
		<div class="small_wrap">
			<div class="module">
				<div id="wrp_garantia" class="small_box purple">
					<h2>Garant&iacute;a</h2>
					<label>Garant&iacute;a</label>
					<input type="text" class="s_meses" id="show_garantia" value="0" /> d&iacute;as
				</div>
			</div>
		</div>

	</div>
	
	<?=read_message()?>
	
</body>