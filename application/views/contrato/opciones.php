<div class="estadocontrato">

<?php
	if($estado == Contrato::ACTIVO){
		if($presaca === FALSE){
?>
	<div class="wrp_estado">
		<h2><?= $info['descEstado'] ?></h2>
		<img src="<?= base_url('assets/img/estado_'.$estado.'.png') ?>" alt="<?= $info['descEstado'] ?>" />
	</div>
	<div class="wrp_opciones">
		<h2>Operaciones</h2>
		<table class="format">
			<tbody>
				<tr onclick="operacion('cancelar')">
					<td>Cancelar Contrato</td>
				</tr>
				<tr onclick="operacion('mover')">
					<td>Mover a Almacen</td>
				</tr>
				<tr onclick="operacion('anular')">
					<td>Anular Contrato</td>
				</tr>
				<tr onclick="imprimir()">
					<td>Imprimir Copia</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="wrp_operaciones off" id="operaciones">
		
	</div>
<?php
		}else{
?>
	<div class="wrp_estado">
		<h2><?= $info['descEstado'] ?></h2>
		<img src="<?= base_url('assets/img/estado_'.$estado.'.png') ?>" alt="<?= $info['descEstado'] ?>" />
	</div>
	<div class="wrp_info">
		<h2>En presaca</h2>
		<table class="format" cellspacing="0">
			<tbody>
				<tr>
					<th>Fecha Presaca</th>
					<td class="s_fecha"><?=$presaca[0]['fecha']?></td>
					<th>Usuario</th>
					<td class="s_usuario"><?=$presaca[0]['usuario']?></td>
					<td><a href="javascript:void(0)" onclick="removerPresaca()">Remover de la Pre-Saca</a></td>
				</tr>
			</tbody>
		</table>
	</div>
<?php
		}
	}else if($estado == Contrato::CANCELADO){
?>
	<div class="wrp_estado">
		<img src="<?= base_url('assets/img/estado_'.$estado.'.png') ?>" alt="<?= $info['descEstado'] ?>" />
	</div>
	<div class="wrp_info">
		<h2><?= $info['descEstado'] ?></h2>
		<table class="format fullwidth" cellspacing="0">
			<tbody>
				<tr>
					<th>Fecha Cancelaci&oacute;n</th>
					<td class="fecha"><?=$info['fechaSalida']?></td>
					<th>Meses</th>
					<td class="meses"><?=month_diff($info['fechaContrato'], $info['fechaSalida']) + 1?></td>
					<th>Valor Cancelado</th>
					<td class="valor">$ <?=number_format($info['valorCancelado'])?></td>
				</tr>
			</tbody>
		</table>
	</div>
<?php
	}else if($estado == Contrato::ANULADO){
?>
	<div class="wrp_estado">
		<img src="<?= base_url('assets/img/estado_'.$estado.'.png') ?>" alt="<?= $info['descEstado'] ?>" />
	</div>
	<div class="wrp_info anulado">
		<h2><?= $info['descEstado'] ?></h2>
		<table class="format" cellspacing="0">
			<tbody>
				<tr>
					<th>Fecha Anulaci&oacute;n</th>
					<td class="fecha"><?= $info['fechaAnulacion'] ?></td>
					<th>Usuario</th>
					<td class="usuario"><?= $info['usuario'] ?></td>
				</tr>
				<tr>
					<th>Motivo</th>
					<td colspan="3"><?= $info['motivo'] ?></td>
				</tr>
			</tbody>
		</table>
	</div>
<?php
	}else if($estado == Contrato::ALMACEN){
?>
	<div class="wrp_estado">
		<img src="<?= base_url('assets/img/estado_'.$estado.'.png') ?>" alt="<?= $info['descEstado'] ?>" />
	</div>
	<div class="wrp_info">
		<h2><?= $info['descEstado'] ?></h2>
		<table class="format" cellspacing="0">
			<tbody>
				<tr>
					<th>Fecha de env&iacute;o a almacen</th>
					<td><?=$info['fechaSalida']?></td>
				</tr>
			</tbody>
		</table>
	</div>
<?php
	}else if($estado == Contrato::VENDIDO){
?>
	<div class="wrp_estado">
		<img src="<?= base_url('assets/img/estado_'.$estado.'.png') ?>" alt="<?= $info['descEstado'] ?>" />
	</div>
	<div class="wrp_info vendido">
		<h2><?= $info['descEstado'] ?></h2>
		<table>
			<tbody>
				<tr>
					<th>Fecha de venta</th>
					<td class="fecha"><?= $info['fechaVenta'] ?></td>
					<th>Valor Venta</th>
					<td class="valor">$ <?= number_format($info['valorVenta']) ?></td>
				</tr>
				<tr>
					<th>Cliente</th>
					<td><a href="<?= site_url('cliente/ver/'.$info['idclienteVenta']) ?>">Ver Cliente</a></td>
					<th>Nota Cobro</th>
					<td><a href="<?= site_url('almacen/ver/'.$info['idnotacobro']) ?>">Ver Nota</a></td>
				</tr>
			</tbody>
		</table>
	</div>
<?php
	}else if($estado == Contrato::CHATARRIZADO){
?>
	<div class="wrp_estado">
		<img src="<?= base_url('assets/img/estado_'.$estado.'.png') ?>" alt="<?= $info['descEstado'] ?>" />
	</div>
	<div class="wrp_info vendido">
		<h2><?= $info['descEstado'] ?></h2>
		<table>
			<tbody>
				<tr>
					<th>Fecha de chatarrizaci&oacute;n</th>
					<td><?=$info['fechaSalida']?></td>
				</tr>
			</tbody>
		</table>
	</div>
<?php
	}else if($estado == Contrato::PROBLEMALEGAL){
?>
	<div class="wrp_estado">
		<img src="<?= base_url('assets/img/estado_'.$estado.'.png') ?>" alt="<?= $info['descEstado'] ?>" />
	</div>
	<div class="wrp_info vendido">
		<h2><?= $info['descEstado'] ?></h2>
		<table class="format fullwidth" cellspacing="0">
			<tbody>
				<tr>
					<th>Fecha de salida</th>
					<td class="s_fecha"><?=$info['fechaSalida']?></td>
				</tr>
			</tbody>
		</table>
	</div>
<?php
	}
?>
</div>