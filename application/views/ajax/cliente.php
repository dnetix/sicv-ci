<div id="client_selector">
<?php

	if($clientes->num_rows() >= 1){
?>
	<h2>Seleccione Cliente</h2>
	<table class="format" cellspacing="0">
		<thead>
			<tr>
				<th class="nombre">Nombre del Cliente</th>
				<th class="identificacion">Nro Identificaci&oacute;n</th>
				<th>Tel&eacute;fono</th>
				<th>Opciones</th>
			</tr>
		</thead>
		<tbody>
<?php
		foreach ($clientes->result_array() as $cliente) {
?>
			<tr onclick="seleccionarCliente('<?= $cliente['idcliente'] ?>', '<?= $cliente['nombre'] ?>', '<?= $cliente['telefono'] ?>')">
				<td class="nombre"><?= $cliente['nombre'] ?></td>
				<td class="identificacion"><?= $cliente['idcliente'] ?></td>
				<td class="telefono"><?= $cliente['telefono'] ?></td>
				<td class="opcion">
					<a class="select" href="javascript:void(0)"></a>
				</td>
			</tr>
<?php
		}
?>
		</tbody>
	</table>
<?php
	}else{
?>
	<h2>No existe ning&uacute;n cliente con ese criterio</h2>
	<div class="buttons">
		<a href="javascript:void(0)" onclick="nuevoCliente()" id="btn_nuevocliente" class="green_button">Ingresar un nuevo cliente</a>
	</div>
<?php
	}
?>
</div>