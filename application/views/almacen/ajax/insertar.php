
<tr id="articulo_<?= $i ?>" class="articulo">
	<td class="v_idarticulo"><?= $idarticulo ?></td>
	<td class="v_contrato"><?= $contrato ?></td>
	<td class="v_articulo"><?= $articulo ?> </td>
	<td class="v_valor">
		$ <?= number_format($valorcompra) ?>
	</td>
	<td class="v_valor">
		<input type="text" id="showvalorventa_<?= $i ?>" class="inp_venta" value="$ <?= number_format($valorventa) ?>" onchange="setMoneyValueTOT('showvalorventa_<?= $i ?>', 'valorventa_<?= $i ?>')" />
		<input type="hidden" name="valorventa_<?= $i ?>" id="valorventa_<?= $i ?>" value="<?= $valorventa ?>" />
		<input type="hidden" name="idarticulo_<?= $i ?>" id="idarticulo_<?= $i ?>" value="<?= $idarticulo ?>" readonly="readonly" />
	</td>
	<td class="v_options">
		<input type="button" class="btn_remove" onclick="deleteArticulo(<?= $i ?>)" />
	</td>
</tr>