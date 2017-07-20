
<div id="select_articulo">
	<h2>Seleccione Art&iacute;culo</h2>
	<table class="format" cellspacing="0">
		<thead>
			<tr>
				<th class="idarticulo">Id</th>
				<th class="contrato">Contrato</th>
				<th class="articulo">Articulo</th>
				<th class="valor">V. Compra</th>
				<th class="valor">V. Venta</th>
				<th class="cantidad">Cantidad</th>
			</tr>
		</thead>
		<tbody>
		<?php
			$i = 0;
			foreach($results->result_array() as $result){
				if($i % 2 == 0){$class = ' class="even"';}else{$class = '';}
				?>
			<tr onclick="seleccionarArticulo('<?=$result['idarticulo']?>')"<?=$class?>>
				<td class="idarticulo"><?=$result['idarticulo']?></td>
				<td class="contrato"><?=$result['contrato']?></td>
				<td class="articulo"><?=$result['articulo']?></td>
				<td class="valor">$ <?=number_format($result['valorcompra'])?></td>
				<td class="valor">$ <?=number_format($result['valorventa'])?></td>
				<td class="cantidad"><?=$result['disponible']?></td>
			</tr>
				<?php
				$i++;
			}
		?>
		</tbody>
	</table>
</div>