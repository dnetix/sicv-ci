<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="Diego Calle">
	<title>Informe de Articulos a la Venta -SICV-</title>
	<link href="<?=base_url('assets/img/favicon.ico')?>" rel="shortcut icon" />
	
	<link rel="stylesheet" href="<?=base_url("assets/css/base.css")?>" />
	
	<script src="<?=base_url('assets/js/jquery-1.9.1.min.js')?>"></script>
	<script src="<?=base_url('assets/js/base.js')?>"></script>
	<script src="<?=base_url('assets/highcharts/js/highcharts.js')?>"></script>
	
	<script>
		$(function () {
		    var chart;
		    $(document).ready(function() {
		        chart = new Highcharts.Chart({
		            chart: {
		                renderTo: 'stats_totales',
		                type: 'line',
		                marginRight: 20,
		                marginBottom: 50
		            },
		            title: {
		                text: 'Prestado en contratos por Mes',
		                x: -20 //center
		            },
		            xAxis: {
		                categories: ['<?=$xAxis?>']
		            },
		            yAxis: {
		                title: {
		                    text: 'Total Prestado ($) Pesos'
		                },
		                plotLines: [{
		                    value: 0,
		                    width: 1,
		                    color: '#808080'
		                }]
		            },
		            tooltip: {
		                formatter: function() {
		                        return '<b>'+ this.series.name +'</b> '+
		                        this.x +': '+ getMoneyValue(this.y);
		                }
		            },
		            legend: {
		                layout: 'vertical',
		                align: 'right',
		                verticalAlign: 'top',
		                x: -10,
		                y: 100,
		                borderWidth: 0
		            },
		            series: [{
		                name: 'Total Prestado',
		                data: [<?=$yAxis?>]
		            }]
		        });
		    });
		    
		});
	</script>
	
</head>
<body>
	
	<?=$this->load->view('ads/header')?>
	
	<div id="main_container">
		
		<div id="estadistico" class="contratos">
			
			<div class="small_wrap">
				<h2>Estadisticas de contratos por a&ntilde;o  (<?=$ano?>)</h2>
				
				<div>
					<form name="frm_filtro" method="post" action="<?= base_url('informe/stats_contrato') ?>">
						<label for="ano">Año</label>
						<input type="text" name="ano" id="ano" class="s_meses" />
						
						<input type="hidden" name="filter" value="1" />
						<input type="submit" value="Filtrar" class="blue_button" />
					</form>
				</div>
				
				<table class="format" cellspacing="0">
					<thead>
						<tr>
							<th class="idarticulo">Mes</th>
							<th class="contrato">Nro. C.</th>
							<th class="articulo">Total</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$i = 0;
							$totalano = 0;
							$cantidad = 0;
							foreach($results->result_array() as $result){
								if($i % 2 == 0){$class = ' class="even"';}else{$class = '';}
								$totalano += $result['totalmes'];
								$cantidad += $result['nrocontratos'];
								?>
							<tr<?=$class?>>
								<td class="mes"><?=get_month_name($result['mes'])?></td>
								<td class="cantidad"><?=$result['nrocontratos']?></td>
								<td class="total">$ <?=number_format($result['totalmes'])?></td>
							</tr>
								<?php
								$i++;
							}
						?>
						<tr>
							<th>Total</th>
							<th><?=$cantidad?></th>
							<th>$ <?=number_format($totalano)?></th>
						</tr>
					</tbody>
				</table>
			</div>
			
			<div class="big_wrap">
				<div id="stats_totales"></div>
			</div>
			
		</div>
	</div>
	
	<?=read_message()?>
	
</body>