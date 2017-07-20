<div id="wrp_nuevocliente">
<h2>Nuevo Cliente</h2>
<table class="form">
	<tr>
		<td><label>Nro Identificacion *</label></td>
		<td><input type="text" name="idcliente" id="cl_idcliente" class="s_idcliente" placeholder="Nro Identificaci&oacute;n" /></td>
		<td class="space"><label>Tipo Documento *</label></td>
		<td>
			<select id="cl_tipoid" name="tipoid">
				<?php
					foreach($tipos as $key => $value){
						echo '<option value="'.$key.'">'.$value.'</option>';
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td><label>Lugar Expedici&oacute;n *</label></td>
		<td>
			<input type="text" name="lugarexpedicion" id="cl_lugarexpedicion" class="s_ciudad" placeholder="Lugar Expedicion" onkeyup="buscarCiudad('lugarexpedicion')" />
		</td>
		<td colspan="2">
			<div id="ajax_lugarexpedicion"></div>
		</td>
	</tr>
	<tr>
		<td><label>Nombre *</label></td>
		<td colspan="3"><input type="text" name="nombre" id="cl_nombre" class="s_nombre" placeholder="Nombre del cliente" /></td>
	</tr>
	<tr>
		<td><label>Direcci&oacute;n</label></td>
		<td colspan="3"><input type="text" name="direccion" id="cl_direccion" class="s_direccion" placeholder="Direcci&oacute;n" /></td>
	</tr>
	<tr>
		<td><label>Telefono</label></td>
		<td><input type="text" name="telefono" id="cl_telefono" class="s_telefono" placeholder="Telefono" /></td>
		<td class="space"><label>Celular</label></td>
		<td><input type="text" name="celular" id="cl_celular" class="s_telefono" placeholder="Celular" /></td>
	</tr>
	<tr>
		<td><label>Ciudad Domicilio *</label></td>
		<td>
			<input type="text" name="ciudad" id="cl_ciudad" class="s_ciudad" placeholder="Ciudad" onkeyup="buscarCiudad('ciudad')" />
		</td>
		<td colspan="2">
			<div id="ajax_ciudad"></div>
		</td>
	</tr>
	<tr>
		<td><label>Email</label></td>
		<td colspan="3"><input type="text" name="email" id="cl_email" class="s_email" placeholder="Correo Electronico" /></td>
	</tr>
	<tr>
		<td colspan="4" class="buttons">
			<a href="javascript:void(0)" onclick="guardarCliente()" class="green_button">Guardar Cliente</a>
			<a href="javascript:void(0)" onclick="cancelarCliente()" class="red_button">Cancelar</a>
		</td>
	</tr>
</table>
</div>	