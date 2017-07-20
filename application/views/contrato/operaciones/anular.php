	
	<h2>Anular Contrato</h2>
	<form name="frm_anular" id="frm_anular" method="post" action="<?= site_url('contrato/anular') ?>">
		<table>
			<tr>
				<td><label>Motivo Anulaci&oacute;n</label></td>
				<td><textarea name="motivo" class="s_anulacion"></textarea></td>
			</tr>
			<tr>
				<td class="buttons" colspan="2">
					<input type="hidden" name="idcontrato" value="<?= $idcontrato ?>" />
					<input type="button" class="red_button" value="Anular" onclick="anularContrato()" />
				</td>
			</tr>
		</table>
	</form>