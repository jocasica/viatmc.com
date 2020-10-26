<!-- viatmc styles -->
<link rel="stylesheet" href="<?php echo base_url().'css/viatmc/viatmc.css'; ?>">

<div class="page-wrapper">
	<!-- ============================================================== -->
	<!-- Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	<!--div class="page-breadcrumb">
		<div class="row align-items-center">
			<div class="col-5">
				<h4 class="page-title">Compras</h4>
				<div class="d-flex align-items-center">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#">Compras</a></li>
							<li class="breadcrumb-item active" aria-current="page">Registrar compra</li>
						</ol>
					</nav>
				</div>
			</div>
			<div class="col-7">
				<div class="text-right upgrade-btn">
				</div>
			</div>
		</div>
	</div-->
	<div class="container-fluid">
		<!-- ============================================================== -->
		<!-- Start Page Content -->
		<!-- ============================================================== -->
		<!-- Row -->

		<div class="row">
			<!-- Column -->
			<div class="col-lg-12 col-xlg-12 col-md-12">
				<form action="/" id="form_compra" method="post">
					<div class="card">
						<div class="card-body">
							<!-- title -->
							<div class="d-md-flex align-items-center">
								<div>
									<h4 class="card-title">Registrar Compra</h4>
									<h5 class="card-subtitle" hidden>Overview of Top Selling Items</h5>
								</div>
								<div class="ml-auto">
									<div class="dl">
										<h4 class="m-b-0 font-16"></h4>
									</div>
								</div>
							</div>
							<!-- end title -->

							<!-- body -->
							<div class="row">
								<div class="col-md-2 form-group">
									<label for="serie">Serie de comp.</label>
									<input type="text" id="serie" name="serie" value="" class="form-control form-control-line" maxlength="4" required>
								</div>
								<div class="col-md-3 form-group">
										<label for="numero">Número de comprobante</label>
										<input type="number" id="numero" name="numero" value="" class="form-control form-control-line" min="1" max="999999" required>
								</div>
								<div class="col-md-2 form-group">
										<label for="fecha">Fecha de Compra</label>
										<input type="date" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" class="form-control form-control-line" required>
								</div>
								<div class="col-md-3 form-group">
									<label for="proveedor">Proveedor</label>
									<!-- data-placeholder="Escriba el nombre o número del documento del cliente" -->
									<select name="proveedor" id="proveedor" class="form-control select2" required>
										<option value="">(SELECCIONAR)</option>
										<?php foreach($proveedores as $index => $pro): ?>
											<option value="<?= $index; ?>"><?= $pro; ?></option>
										<?php endforeach; ?>
									</select>
									<!-- <?php #echo form_dropdown(['name'=>'', 'class'=>'form-control proveedor_select2', 'required'=>'required', 'id'=>'proveedor'],[''=>'(SELECCIONAR)']+$proveedores); ?> -->
								</div>
								<div class="col-md-2 form-group text-center">
									<label for="">&nbsp;</label><br>
									<button class="btn btn-info" data-toggle="modal" data-target="#modal_form_add_producto" type="button"><i class="fa fa-plus"></i> Agregar Producto</button>
								</div>
							</div>
							<div class="row">
								<!-- <div class="col-md-12 form-group">
									<label for="moneda">Moneda</label>
									<select name="moneda" value="" id="moneda" class="form-control form-control-line" required>
											<option value="SOLES">SOLES</option>
											<option value="DOLARES">DOLARES</option>
									</select>
								</div> -->
								<div class="col-md-4 form-group" id="div_tipo_cambio" hidden>
									<label for="tipocambio">Tipo de cambio</label>
									<input type="number" name="tipocambio" id="tipocambio" value="" class="form-control"  step=".0001" min="0.0001" max="9999999"/>
								</div>
							</div>

							<div class="form-group">
								<div class="table-responsive">
									<table class="table table-bordered" id="tabla_productos_compra">
										<thead class="thead-light">
											<tr>
												<th>Nro</th>
												<th width="20%">Producto</th>
												<th>Cantidad</th>
												<th>Precio S/</th>
												<th>Precio $/</th>
												<th>Lote</th>
												<th>Serie</th>
												<th>Sub Total S/</th>
												<th>Acciones</th>
											</tr>
										</thead>
										<tbody id="table_compra">
											<!-- llenado js -->
										</tbody>
									</table>
								</div>
							</div>
							<div class="form-group text-right">
								<div class="col-sm-12">
									<button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Guardar Compra</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<!-- Column -->
		</div>

	</div>
	<!-- Modal adicionar producto -->
	<div id="modal_form_add_producto" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<h6 class="modal-title">Agregar Producto (Moneda: SOLES)</h6>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					<!-- <div class="col-md-12">
						<div class="alert alert-success alert-styled-left alert-arrow-left alert-bordered">
							Agregue la serie del producto comprado.
						</div>
					</div> -->
					<form id="form_add_producto" action="/" method="post" accept-charset="utf-8">
						<div class="row">
							<!-- Tipo registro producto -->
							<input type="text" id="tipo_registro_producto" hidden>
							<!-- Producto -->
							<div class="col-md-12 form-group">
								<label for="producto_id">Producto</label>
								<select type="text" name="producto_id" id="producto_id" class="select2 form-control" maxlength="50" onchange="verificar_codigo_lote_serie_producto(this);" required>
									<option value="">(SELECCIONAR)</option>
									<?php foreach($data_productos as $p): ?>
										<option value="<?= $p->id ?>"><?= $p->nombre.' - '.$p->serie ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<!-- Garantía -->
							<div class="col-md-6 form-group">
								<label for="garantia">Garantia</label>
								<input type="text" name="garantia[]" value="" class="form-control form-control-line" maxlength="250" id="garantia" required>
							</div>
							<!-- Precio de compra local -->
							<div class="col-md-6 form-group">
								<label for="precio_unidad">Precio de compra local</label>
								<input type="number" name="precio_unidad" value="" id="precio_unidad" class="form-control form-control-line" min="0.01" max="9999999" step=".01" required>
							</div>
							<!-- Precio de compra extranjero -->
							<div class="col-md-6 form-group">
								<label for="precio_unidad_extranjero">Precio de compra extranjero</label>
								<input type="number" name="precio_unidad_extranjero" value="" id="precio_unidad_extranjero" class="form-control form-control-line" min="0.01" max="9999999" step=".01" required>
							</div>
							<!-- Cantidad -->
							<div class="col-md-6 form-group">
								<label for="cantidad">Cantidad</label>
								<input type="number" class="form-control" value="1" name="cantidad" id="cantidad" min="1" max="9999999">
							</div>
							<!-- Código Lote -->
							<div class="col-md-6 form-group">
								<div id="con_codigo_lote"></div>
							</div>
							<!-- Series -->
							<div class="col-md-12">
								<div id="con_series" class="mt-2"></div>
							</div>
							<div class="form-group col-md-12" hidden>
								<label for="producto_total">Total</label>
								<input type="number" class="form-control" value="" id="producto_total" disabled="disabled" required>
							</div>
						</div>
						<div class="row mt-4">
							<div class="form-group col-md-12 text-center">
								<button class="btn btn-info" type="submit"><i class="fa fa-check"></i> Agregar</button>
							</div>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
</div>

<!-- jquery -->
<script src="https://code.jquery.com/jquery-3.5.0.min.js" charset="utf-8"></script>
<!-- Sweet Alert 2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- viatmc scripts -->
<script src="<?php echo base_url().'js/viatmc/viatmc.js'; ?>"></script>

<script>
	const data_productos = <?php echo json_encode($data_productos); ?>;
	// Registrar Compra
	$('#form_compra').submit(function(e) {
		e.preventDefault();
		// data compra
		const data_form_compra = $('#form_compra').serializeArray();
		let data_compra  = {};
		data_form_compra.forEach((item) => {
			data_compra[item.name] = item.value;
    });
		// verificación detalle compra
		const r = $('#table_compra tr').length;
		if (r == 0) {
			time_alert('error', 'Cantidad de productos!', 'La cantidad de productos de la compra debe ser mayor a cero.', 2000)
			return;
		}
		// data detalle compra
		let data_compra_detalle_mas_lote_serie = [];
		$('#table_compra tr').each(function(){
			const producto_id								= $(this).find('td').eq(1).find('.producto_id').val();
			const garantia									= $(this).find('td').eq(1).find('.garantia').val();
			const cantidad									= $(this).find('td').eq(2).text();
			const precio_unidad							= $(this).find('td').eq(3).text();
			const precio_unidad_extranjero	= $(this).find('td').eq(4).text();
			const total											= $(this).find('td').eq(7).text();

			const	lote											= $(this).find('td').eq(5).text();
			const	series_producto						= $(this).find('td').eq(6).text();
			const tipo_registro_producto		= $(this).find('td').eq(1).find('.tipo_registro_producto').val();

			const fila		= {producto_id, garantia, precio_unidad, precio_unidad_extranjero, cantidad, total, tipo_registro_producto, lote, series_producto};
			data_compra_detalle_mas_lote_serie.push(fila);
		});

		msg_confirmation('warning', '¿Está seguro?', 'No podrá revertir los cambios.')
		.then((res) => {
			if(res) {
				$.ajax({
					type: "post",
					url: "<?php echo base_url('compra/post'); ?>",
					data: {dc: data_compra, ddc: data_compra_detalle_mas_lote_serie},
					dataType: "json",
					success: function (response) {
						ok_alert('success', 'Registrado!', 'Compra registrada satisfactoriamente')
						.then(() => {
							window.location = '<?= base_url('compra'); ?>';
						});
					}
				});
			}
		})
	});

	function agregar_producto_tabla(series_producto) {
		const fila = `
			<tr>
				<td class="nro"></td>
				<td>
					${$("#producto_id option:selected").text()}
					<input class="producto_id" value="${$('#producto_id').val()}" hidden>
					<input class="garantia" value="${$('#garantia').val()}" hidden>
					<input class="tipo_registro_producto" value="${$('#tipo_registro_producto').val()}" hidden>
				</td>
				<td>${$('#cantidad').val()}</td>
				<td>${$("#precio_unidad").val()}</td>
				<td>${$("#precio_unidad_extranjero").val()}</td>
				<td>${($('#lote').val() != undefined) ? $('#lote').val(): ''}</td>
				<td>${series_producto.join(',')}</td>
				<td>${(parseFloat($('#cantidad').val()) * parseFloat($("#precio_unidad").val())).toFixed(2)}</td>
				<td>
					<button class="btn btn-warning delete"><i class="ti-trash"></i> Eliminar</button>
				</td>
			</tr>`;
		$('#table_compra').append(fila);
		// Llenar numero (nro) tabla
		let i = 1;
		$('#table_compra  > tr').each(function() {
			$(this).find(".nro").text(i++);
		});
		// Limpiar formulario add producto
		$('#producto_id').val('').change();
		$('#garantia').val('');
		$("#precio_unidad").val('');
		$("#precio_unidad_extranjero").val('');
		$('#cantidad').val('1');
		$('#lote').val('');
	}

	$('#form_add_producto').on('submit', function(e) {
    e.preventDefault();
		// Identificar producto
		const producto_id				= $('#producto_id').val();
		const producto					= data_productos.find((pro) => pro.id == producto_id);
		let series_producto			= [];

		// Verificar si trabaja con series -> verificar cantidad de series elegidas
		if(producto.tipo_registro_producto == '1' || producto.tipo_registro_producto == '3') { // Producto Con Series
			// Recolección de las series de los productos
			$('.series_producto').each(function() {
				series_producto.push($(this).val())
			});
		}
		agregar_producto_tabla(series_producto);
		$('#modal_form_add_producto').modal('hide');
	});
	// Agregar campo para el ingreso del codigo de lote
	function adicionar_codigo_lote_html() {
		$('#con_codigo_lote').html('');
		const lote_html = `
			<label for="lote">Código Lote</label>
			<input type="number" id="lote" name="lote" value="" class="form-control form-control-line" placeholder="Ingrese el lote del producto" required>`;
		$('#con_codigo_lote').append(lote_html);
	}
	// Agregar campo para el ingreso de las series
	function adicionar_series_html() {
		const cantidad = $('#cantidad').val();
		$('#con_series').html('');
		let series_html = '<label>Ingrese las series</label>';
		for (let i=0; i<cantidad; i++) {
			series_html += `
				<div class="form-group row ml-1">
					<label class="col-sm-3 col-form-label col-form-label" style="background: #F2F2F2">#${((i + 1) + "").padStart(2, "0")} Serie: </label>
					<div class="col-sm-9">
						<input type="text" class="form-control series_producto" required>
					</div>
				</div>
			`;
		}
		$('#con_series').append(series_html);
		// Verificar en tiempo real no duplicar series
		$('.series_producto').on('change', function () {
			const serie_actual = $(this).val();
			let verificar_series_productos = [];
			$('.series_producto').each(function() {
				verificar_series_productos.push($(this).val())
			});
			const series_duplicadas = verificar_series_productos.filter((s) => s == serie_actual);
			if(series_duplicadas.length > 1) {
				time_alert('error', 'Serie duplicada!', 'Ya ingresó esta serie (<b>'+serie_actual+'</b>), ingrese otra serie.', 2000)
				$(this).val('');
			}
		});
	}
	// Verificar si se trabaja con series, lote, ambos o ninguno
	const verificar_codigo_lote_serie_producto = (e) => {
		const producto_id = $('#producto_id').val();
		if(producto_id == '') { // Cuando no eligió algun producto
			$('#con_codigo_lote').html('');
			$('#con_series').html('');
			return;
		}
		const producto = data_productos.find((pro) => pro.id == producto_id);
		$('#tipo_registro_producto').val(producto.tipo_registro_producto);

		if(producto.tipo_registro_producto == '1') {				// Producto Con Series
			$('#con_codigo_lote').html('');
			adicionar_series_html();
		} else if(producto.tipo_registro_producto == '2') {	// Producto Con Código de Lote
			$('#con_series').html('');
			adicionar_codigo_lote_html();
		} else if(producto.tipo_registro_producto == '3') {	// Producto con Código de lote y series
			adicionar_codigo_lote_html();
			adicionar_series_html();
		} else {																						// sin codigo de lote y sin series
			$('#con_codigo_lote').html('');
			$('#con_series').html('');
		}
	};
	$('#cantidad').on('change', function() {
		verificar_codigo_lote_serie_producto();
	});
</script>