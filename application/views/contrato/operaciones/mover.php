	
	<h2>Mover Articulo al Almacen</h2>
	<form name="frm_mover" id="frm_mover" method="post" action="<?= site_url('contrato/mover') ?>">
		<table>
			<tr>
				<td><label>Valor de Venta</label></td>
				<td><input type="text" id="showvalorcancelar" class="s_valor" value="$ <?= number_format($valorCancelacion) ?>" /></td>
			</tr>
			<tr>
				<td class="buttons" colspan="2">
					<input type="hidden" name="idcontrato" value="<?= $idcontrato ?>" />
					<input type="hidden" name="valorventa" id="valorventa" value="<?= $valorCancelacion ?>" />
					<input type="button" class="blue_button" value="Mover" onclick="moverContrato()" />
				</td>
			</tr>
		</table>
	</form>