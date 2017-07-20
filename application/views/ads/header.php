<div id="header">
	<div id="header_wrapper">
		
		<div id="top_logo_container">
			<a href="<?=site_url('init/menu')?>">
				<img src="<?=base_url('assets/img/mainlogo.png')?>" alt="CompraVenta Logo" />
			</a>
		</div>
		
		<div id="topmenu">
			<div class="topmenu">
				<ul>
					<li><a href="<?=site_url('init/menu')?>">Men&uacute;</a>
						<ul>
							<li><a href="<?=site_url('sistema/checkupdate')?>">Comprobar Actualizaci&oacute;n</a></li>
							<li><a href="<?=site_url('usuario/cerrarsesion')?>">Cerrar Sesi&oacute;n</a></li>
						</ul>
					</li>
					<li><a href="#">Operaciones</a>
						<ul>
							<li><a href="<?=site_url('contrato/nuevo')?>">Nuevo Contrato</a></li>
							<li><a href="<?=site_url('almacen/gasto')?>">Nuevo Gasto</a></li>
							<li><a href="<?=site_url('operacion/sellos')?>">Imprimir Sellos</a></li>
						</ul>
					</li>
					<li><a href="javascript:void(0)">Almacen</a>
						<ul>
							<li><a href="<?=site_url('almacen/venta')?>">Nueva Venta</a></li>
							<li><a href="<?=site_url('almacen/nuevo')?>">Nuevo Articulo</a></li>
							<li><a href="<?=site_url('informe/articulosventa')?>">Articulos a la venta</a></li>
						</ul>
					</li>
					<li><a href="javascript:void(0)">Clientes</a>
						<ul>
							<li><a href="<?=site_url('cliente/crear/off')?>">Buscar</a></li>
							<li><a href="<?=site_url('cliente/crear')?>">Nuevo Cliente</a></li>
						</ul>
					</li>
					<li><a href="javascript:void(0)">Informes</a>
						<ul>
							<li><a href="<?=site_url('informe/prorroga')?>">Abonos</a></li>
							<li><a href="<?=site_url('informe/financiero')?>">Reporte Financiero</a></li>
							<li><a href="<?=site_url('informe/gastos')?>">Reporte Gastos</a></li>
							<li><a href="<?=site_url('informe/vendidos')?>">Articulos Vendidos</a></li>
							<li><a href="<?=site_url('informe/activos')?>">Contratos Activos</a></li>
							<li><a href="<?=site_url('informe/vencidos')?>">Contratos Vencidos</a></li>
							<li><a href="<?=site_url('informe/presacas')?>">Contratos Presacados</a></li>
							<li><a href="<?=site_url('informe/sacados')?>">Contratos Sacados</a></li>
							<li><a href="<?=site_url('informe/cancelados')?>">Contratos Cancelados</a></li>
							<li><a href="<?=site_url('informe/stats_contrato')?>">Estadisticas de Contratos</a></li>
						</ul>
					</li>
					<li>
						<a href="<?=site_url('sistema/menu')?>" class="btn_config"></a>
					</li>
				</ul>
			</div>
		</div>
		
		<div id="top_buscador">
			<form method="post" action="<?=site_url('sistema/qsearch')?>">
				<input type="text" name="qsearch" id="qsearch" placeholder="B&uacute;squeda R&aacute;pida" required="required" autocomplete="off" />
				<input type="submit" class="blue_button symbol" value="Ir" />
			</form>
		</div>
		
	</div>
</div>

<div id="subheader_wrapper">
	<div id="subheader">
		<p><span class="top_fecha"><?=date_print_format(date('Y-m-d'))?></span></p>
	</div>
</div>