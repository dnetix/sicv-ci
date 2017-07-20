
/**
 * Pure Ajax 
 */

var SITE_URL = "/";

/** CREACION DE UN NUEVO CLIENTE EN AJAX **/

function nuevoCliente(){
	$.ajax({ 
		url: SITE_URL + "cliente/nuevo",
		type: "post",
		dataType: 'html',
		success: function(data){
			$("#ajax_cliente").html(data);
		}
	});
}

function guardarCliente(){
	
	var idcliente = $("#cl_idcliente").val();
	var tipoid = $("#cl_tipoid").val();
	var lugarexpedicion = $("#cl_lugarexpedicion").val();
	var nombre = $("#cl_nombre").val();
	var direccion = $("#cl_direccion").val();
	var telefono = $("#cl_telefono").val();
	var celular = $("#cl_celular").val();
	var ciudad = $("#cl_ciudad").val();
	var email = $("#cl_email").val();
	
	if(idcliente.length < 3){
		alert("La identificación es necesaria para guardar el cliente");
		return false;
	}else if(idcliente.match(/\./) != null){
		alert("La identificacion no debe contener puntos");
		return false;
	}else if(tipoid.length < 1){
		alert("Debe seleccionar el tipo de identificación");
		return false;
	}else if(lugarexpedicion.length < 1){
		alert("Debe ingresar el lugar de expedición del documento");
		return false;
	}else if(nombre.length < 3){
		alert("Debe ingresar el nombre del cliente");
		return false;
	}else if(ciudad.length < 3){
		alert("Debe ingresar la ciudad de residencia del cliente");
		return false;
	}
	
	$.ajax({ 
		url: SITE_URL + "cliente/guardar",
		type: "post",
		data: 	"idcliente=" + idcliente + 
				"&tipoid=" + tipoid +
				"&lugarexpedicion=" + lugarexpedicion +
				"&nombre=" + nombre +
				"&direccion=" + direccion +
				"&telefono=" + telefono +
				"&celular=" + celular +
				"&ciudad=" + ciudad +
				"&email=" + email,
		dataType: 'json',
		success: function(data){
			if(data.creado == 1){
				if(data.existe == 1){
					alert("El cliente que ha intentado crear ya existe, se ha seleccionado el existente");
				}
				seleccionarCliente(data.idcliente, data.nombre, data.telefono);
			}else{
				alert("Ha ocurrido un error al crear el cliente, por favor verifique los datos e intente de nuevo");
			}
		}
	});
}

function cancelarCliente(){
	$("#ajax_cliente").slideUp("fast").html("");
}

var clock;

function buscarCiudad(field){
	clearTimeout(clock);
	clock = setTimeout(function () {
		$("#ajax_"+field).slideDown('fast');
		doBuscarCiudad($("#cl_"+field).val(), field);
	}, 1000);
}

function selectCiudad(nombre, field){
	$("#ajax_"+field).slideUp('fast');
	$("#cl_"+field).val(nombre);
}

/** FIN CREACION DE UN NUEVO CLIENTE EN AJAX **/

function doSearchCliente(client_q){
	$.ajax({ 
		url: SITE_URL + "cliente/buscar",
		type: "post",
		data: "client_q="+client_q,
		dataType: 'html',
		success: function(data){
			$("#ajax_cliente").html(data);
		}
	});
}

function operacionContrato(operacion, idcontrato){
	$.ajax({ 
		url: SITE_URL + "contrato/operacion/"+operacion,
		type: "post",
		data: "idcontrato="+idcontrato,
		dataType: 'html',
		success: function(data){
			$("#operaciones").html(data);
		}
	});
}

function doBuscarCiudad(nombre, field){
	$.ajax({ 
		url: SITE_URL + "cliente/buscarciudad",
		type: "post",
		data: "nombre="+nombre+"&field="+field,
		dataType: 'html',
		success: function(data){
			$("#ajax_"+field).html(data);
		}
	});
}

function doBuscarArticulo(q){
	$.ajax({ 
		url: SITE_URL + "almacen/buscar",
		type: "post",
		data: "q="+q,
		dataType: 'html',
		success: function(data){
			$("#ajax_articulo").html(data);
		}
	});
}

function doSeleccionarArticulo(idarticulo, i){
	$.ajax({ 
		url: SITE_URL + "almacen/insertar",
		type: "post",
		data: "idarticulo="+idarticulo+"&i="+i,
		dataType: 'html',
		success: function(data){
			$("#productos").append(data);
			totalizar();
		}
	});
}

function doGetOroPrice(){
	$.ajax({ 
		url: SITE_URL + "sistema/getpreciooro",
		type: "post",
		dataType: 'html',
		success: function(data){
			$("#ajax_oro").html(data);
		}
	});
}