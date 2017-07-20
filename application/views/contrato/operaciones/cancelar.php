	
	<h2>Cancelar Contrato</h2>
	<form name="frm_cancelar" id="frm_cancelar" method="post" action="<?= site_url('contrato/cancelar') ?>">
		<table>
			<tr>
				<td><label>Valor a Cancelar</label></td>
				<td><input type="text" id="showvalorcancelar" class="s_valor" value="$ <?= number_format($valorCancelacion) ?>" /></td>
			</tr>
			<tr>
				<td class="buttons" colspan="2">
					<input type="hidden" name="idcontrato" value="<?= $idcontrato ?>" />
					<input type="hidden" name="valorcancelar" id="valorcancelar" value="<?= $valorCancelacion ?>" />
					<input type="button" class="blue_button" value="Cancelar" onclick="cancelarContrato()" />
				</td>
			</tr>
		</table>
	</form>