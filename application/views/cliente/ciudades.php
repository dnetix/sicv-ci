<table>
<?php
	foreach($ciudades->result_array() as $ciudad){
?>
		<tr><td><a href="javascript:void(0)" onclick="selectCiudad('<?=$ciudad['ciudad']?>', '<?=$field?>')"><?=$ciudad['ciudad']?></a></td></tr>
<?php
	}
?>
</table>
