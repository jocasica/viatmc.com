<!-- viatmc styles -->
<link rel="stylesheet" href="<?php echo base_url().'css/viatmc/viatmc.css'; ?>">

<div class="page-wrapper" style="background-color: #D2E0F0;">
	<!-- ============================================================== -->
	<!-- Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	<div class="page-breadcrumb">
		<div class="row align-items-center">
			<div class="col-5">
				<h4 class="page-title">Cotizaciones</h4>
				<div class="d-flex align-items-center">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#">Cotizaciones  </a></li>
							<li class="breadcrumb-item active" aria-current="page">Verificar Productos</li>
						</ol>
					</nav>
				</div>
			</div>
			<div class="col-7">
				<div class="text-right upgrade-btn">
				</div>
			</div>
		</div>
	</div>
	<?php $i = $data_cotizacion->id?>
	<form id="form_verificar_productos_cotizacion" method="post" action="/">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<h4 class="card-title">Verificar Productos</h4>
							<div class="row list-style-none text-left m-t-10">
								<div class="col-lg-3">
									<label for="fecha">Fecha</label>
									<input type="date" name="fecha" id="fecha" class="form-control" value="<?= $data_cotizacion->fecha ?>" readonly required/>
								</div>
								<div class="col-lg-3">
									<label for="moneda">Moneda</label>
									<input type="text" name="moneda" id="moneda" class="form-control" value="<?= ($data_cotizacion->moneda == "S/") ? 'SOLES (S/)':'DOLARES ($)' ?>" readonly required/>
								</div>
								<div class="col-lg-3">
									<label for="cliente_id">Cliente</label>
									<input type="text" name="cliente_id" id="cliente_id" class="form-control" value="<?= $data_cotizacion->nombre_cliente ?>" readonly required/>
								</div>
								<div class="col-lg-3">
									<label for="vendedor_id">Vendedor</label>
									<input type="text" name="vendedor_id" id="vendedor_id" class="form-control" value="<?= $data_cotizacion->nombre_vendedor ?>" readonly required/>
								</div>
							</div>

							<div class="row m-t-10">
								<div class="col-md-12">
									<div class="table-responsive">
										<table class="table table-striped table-bordered" style="width:100%;" id="tabla_verificar_productos_cotizacion">
											<thead>
												<tr>
													<th width="15%">Nombre</th>
													<th>Detalles Producto</th>
													<th>Precio U.</th>
													<th>Cantidad</th>
													<th>Detalles Cotización</th>
													<th>Monto</th>
													<th width="17%">Serie/Lote</th>
													<!-- <th>Estado</th> -->
												</tr>
											</thead>
											<?php $montoProducto = 0; ?>
											<tbody id="tbody_productos_cotizacion">
												<!-- dinámico - js -->
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<div class="row justify-content-end text-right m-t-10">
								<div class="col-lg-4">
									<label for="montototal"><strong>Monto Total</strong></label>
									<input type="number" name="montototal" id="montototal" class="form-control" min="0" readonly/>
								</div>
							</div>

							<div class="row justify-content-end text-right m-t-10">
								<div class="col-lg-4">
									<button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Productos Verificados</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>

	<div id="modal_add_producto" class="modal fade" data-backdrop="static" data-keyboard="false"> <!-- id="vm_add_producto" -->
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header bg-primary">
					<h6 class="modal-title" style="color:white"><span id="titulo_modal_producto"></span> Producto</h6>
					<button type="button" class="close" id="button_cerrar_modal_add_producto" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body">
					<form class="form-horizontal form-material" id="form_add_producto" method="post"> <!-- id="frm-add-producto" -->
						<input type="hidden" id="cotizacion_id" name="cotizacion_id" value="<?php echo $data_cotizacion->id; ?>">
						<input type="hidden" id="id" name="id" value="">
						<div class="row">
							<div class="col-md-6">
								<label for="producto_id">Producto</label>
								<?php echo form_dropdown(['name' => 'producto_id', 'id' => 'producto_id', 'class' => 'form-control select2', 'required' => 'required', 'onchange'=>'colocar_series(this)'],['' => '(SELECCIONAR)']+$data_productos) ?>
							</div>
						</div>

						<div class="row m-t-10">
							<!-- Serie -->
							<div class="col-md-6">
								<div class="form-check form-check-inline">
									<input class="form-check-input cursor_pointer" type="checkbox" id="toggleSerie">
									<label class="form-check-label cursor_pointer" for="toggleSerie">Serie</label>
								</div>
								<div id="serieToggleObjet" >
									<input type="hidden" id="serie" name="serie[]" class="form-control"  />
									<select class="form-control select2" name="seriess[]" id="series"></select>
								</div>
							</div>
							<!-- Marca -->
							<div class="col-md-6">
								<div class="form-check form-check-inline">
									<input class="form-check-input cursor_pointer" type="checkbox" id="toggleMarca">
									<label class="form-check-label cursor_pointer" for="toggleMarca">Marca</label>
								</div>
								<div id="marcaToggleObjet" >
									<input type="text" id="marcaproducto" name="marcaproducto" class="form-control"/>
								</div>
							</div>
						</div>
						<div class="row m-t-10">
							<!-- Procedencia -->
							<div class="col-md-6">
								<div class="form-check form-check-inline">
									<input class="form-check-input cursor_pointer" type="checkbox" id="toggleProcedencia">
									<label class="form-check-label cursor_pointer" for="toggleProcedencia">Procedencia</label>
								</div>
								<div id="procedenciaToggleObjet">
									<input type="text"  id="procedenciaproducto" name="procedenciaproducto" class="form-control"  />
								</div>
							</div>
							<!-- Agregar Imagenes -->
							<div class="col-md-6">
								<div class="form-check form-check-inline">
									<input class="form-check-input cursor_pointer" type="checkbox" id="toggleImagenes">
									<label class="form-check-label cursor_pointer" for="toggleImagenes">Agregar imagenes</label>
								</div>
								<div id="imagenesToggleObjet">
									<input type="hidden" name="size" value="1000000">
									<input type="hidden" name="image1Set" id="image1Set" value="1000000">
									<div class="row">
										<div class="col-md-6">
											<img id="imagen1" style="width:100px;"  alt="" srcset="">
											<div class="custom-file">
												<input type="file" name="image1" id="imageUploaded1" class="custom-file-input" accept="image/*">
												<label class="custom-file-label" for="validatedCustomFile">Seleccione imagen</label>
											</div>
										</div>
										<div class="col-md-6">
											<img id="imagen2" style="width:100px;"  alt="" srcset="">
											<div class="custom-file">
												<input type="file" name="image2" id="imageUploaded2" class="custom-file-input" accept="image/*">
												<label class="custom-file-label" for="validatedCustomFile">Seleccione imagen</label>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row m-t-10">
							<!-- Agregar caracteristicas -->
							<div class="col-md-6">
								<div class="form-check form-check-inline">
									<input class="form-check-input cursor_pointer" type="checkbox" id="toggleCaracteristicas">
									<label class="form-check-label cursor_pointer" for="toggleCaracteristicas">Agregar caracteristicas </label>
								</div>
								<div id="caracteristicasToggleObjet">
									<div class="text-right">
										<button id="btn_agregar_caracteristica" type="button" class="btn btn-primary" data-toggle="tooltip" data-original-title="Add more controls"><i class="fas fa-plus"></i> Agregar característica</button></th>
									</div>
									<div class="form-group">
										<label for="">Caracteristica 1</label>
										<input type="text" name="caracteristica[]" class="form-control" class="caract"/>
									</div>
								</div>
							</div>
						</div>

						<div class="row m-t-10">
							<!-- Precio -->
							<div class="col-md-6">
								<label for="precioproducto">Precio</label>
								<input type="number"  id="precioproducto" name="precioproducto" class="form-control" required/>
							</div>
							<!-- Cantidad -->
							<div class="col-md-6">
								<label for="cantidad">Cantidad</label>
									<input type="number" id="cantidad" name="cantidad" class="form-control form-control-line" min="0" required>
							</div>
						</div>

						<div class="row m-t-10">
							<!-- Validez Oferta -->
							<div class="col-md-6">
								<div class="form-check form-check-inline">
									<input class="form-check-input cursor_pointer" type="checkbox" id="toggleValidez">
									<label class="form-check-label cursor_pointer" for="toggleValidez">Validez oferta</label>
								</div>
								<div id="validezToggleObjet">
									<input type="text" id="validezOferta" name="validezOferta" class="form-control form-control-line" min="0">
								</div>
							</div>
							<!-- Entrega -->
							<div class="col-md-6">
								<div class="form-check form-check-inline">
									<input class="form-check-input cursor_pointer" type="checkbox" id="toggleEntrega">
									<label class="form-check-label cursor_pointer" for="toggleEntrega">Entrega</label>
									</div>
								<div id="entregaToggleObjet">
									<input type="text" id="entrega" name="entrega" class="form-control form-control-line" min="0">
								</div>
							</div>
						</div>
						<div class="row m-t-10">
							<!-- Forma de Pago -->
							<div class="col-md-6">
								<div class="form-check form-check-inline">
									<input class="form-check-input cursor_pointer" type="checkbox" id="toggleFormaPago">
									<label class="form-check-label cursor_pointer" for="toggleFormaPago">Forma de pago</label>
									</div>
								<div class="col-md-12" id="formaPagoToggleObjet">
									<input type="text" id="formaPago" name="formaPago" class="form-control form-control-line" min="0">
								</div>
							</div>
							<!-- Garantía mes -->
							<div class="col-md-6">
								<div class="form-check form-check-inline">
									<input class="form-check-input cursor_pointer" type="checkbox" id="toggleGarantia">
									<label class="form-check-label cursor_pointer" for="toggleGarantia">Garantia mes</label>
									</div>
								<div class="col-md-12" id="garantiaToggleObjet">
									<input type="text" id="garantiaMeses" name="garantiaMeses" class="form-control form-control-line" min="0">
								</div>
							</div>
						</div>

						<div class="row m-t-10">
							<!-- Descripción General -->
							<div class="col-md-12">
								<label for="producto_descripcion">Descripción general</label>
								<textarea id="producto_descripcion" name="producto_descripcion"></textarea>
							</div>
						</div>

						<div class="row justify-content-end text-right m-t-10">
							<div class="col-lg-4">
								<label for="montoproducto"><strong>Monto Total Producto</strong></label>
								<input type="number" value="0.00" id="montoproducto" name="montoproducto" class="form-control" readonly/>
							</div>
						</div>
						<div class="row justify-content-end text-right m-t-10">
							<div class="col-lg-4">
								<button class="btn btn-success" type="submit">Agregar</button>
							</div>
						</div>
					</form>
				</div> <!-- end modal-body -->
			</div>
	</div>
</div>

<!-- jquery -->
<script src="https://code.jquery.com/jquery-3.5.0.min.js" charset="utf-8"></script>
<!-- Sweet Alert 2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Plugin texto con formato -->
<script src="https://cdn.tiny.cloud/1/mrz5mvxfh0p1w1ds1tfnq2uhl2aqiou30m6e5taunn061lme/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<!-- viatmc scripts -->
<script src="<?php echo base_url().'js/viatmc/viatmc.js'; ?>"></script>

<script>
	const data_cotizacion								= <?= json_encode($data_cotizacion); ?>;
	const cotizacion_detalle_productos	= <?= json_encode($cotizacion_detalle_productos); ?>;
	let data_series_productos = [];
	let data_codigo_lote_productos = [];
	$(document).ready(async function () {
		let montoProductoTotal = 0;
		await cotizacion_detalle_productos.forEach(async (producto) => {
			const tipo_reg = producto.tipo_registro_producto;
			let serie_lote = '';
			/* Código Lote */
			if(tipo_reg == '2' || tipo_reg == '3') {
				console.log('get cod lote');
				const codigo_lote_producto = await $.ajax({
					type: "post",
					url: "<?= base_url('cotizacion/obtenerCodigoLoteProducto'); ?>",
					data: {id: producto.id_producto},
					dataType: "json",
					success: function (response) {
						return response;
					}
				});
				// Cómo verificar productos con código de lote ?
			}
			/* Series */
			if(tipo_reg == '1' || tipo_reg == '3') {
				const series_producto = await $.ajax({
					type: "post",
					url: "<?= base_url('cotizacion/obtenerSeriesProducto'); ?>",
					data: {id: producto.id_producto},
					dataType: "json",
					success: function (response) {
						return response;
					}
				});
				serie_lote += '<select class="select2_series_verificar" multiple="multiple" style="width: 100%;">';
				series_producto.forEach((item) => {
					serie_lote += `<option value="${item.id}">${item.serie}</option>`;
				});
				serie_lote += `</select>`;
			}
			/* Agregar data columna */
			montoProductoTotal += parseFloat(producto.montoproducto);
			const fila = `
				<tr>
					<td><strong>${producto.nombre}</strong></td>
					<td>
						${(producto.marca != '') ? `<strong>Marca: </strong>${producto.marca}<br>`:''}
						${(producto.procedencia != '') ? `<strong>Procedencia: </strong>${producto.procedencia}<br>`:''}
						${(producto.modelo != '') ? `<strong>Modelo: </strong>${producto.modelo}<br>`:''}
					</td>
					<td>${producto.precioproducto}</td>
					<td>${producto.cantidad}</td>
					<td>
						${(producto.entrega != '') ? `<strong>Entrega: </strong>${producto.entrega}<br>`:''}
						${(producto.validezOferta != '') ? `<strong>Validez: </strong>${producto.validezOferta}<br>`:''}
						${(producto.garantiaMeses != '') ? `<strong>Garantia: </strong>${producto.garantiaMeses}<br>`:''}
						${(producto.formaPago != '') ? `<strong>Forma pago: </strong>${producto.formaPago}<br>`:''}
					</td>
					<td><strong>${producto.montoproducto}</strong></td>
					<td class="text-center">
						<input type="text" name="tipo_registro_producto" value="${producto.tipo_registro_producto}" hidden>
						<input type="text" name="id_producto" value="${producto.id_producto}" hidden>
						${serie_lote}
					</td>
					<!--td>Existe</td-->
				</tr>`;
			$('#tbody_productos_cotizacion').append(fila);
			$('#montototal').val(montoProductoTotal);

			/* modulo cotizacion -> verificar cotizacion */
			$('.select2_series_verificar').select2({
				placeholder: "Seleccione las series",
				allowClear: true
			});
		});
		$('#form_verificar_productos_cotizacion').submit(function (e) {
			e.preventDefault();
			let aux = 0;
			$('#tbody_productos_cotizacion tr').each(function() {
				const tipo_registro_producto	= $(this).find('input[name="tipo_registro_producto"]').val();
				const id_producto							= $(this).find('input[name="id_producto"]').val();
				const nombre_producto					= $(this).find('td').eq(0).text();
				if(tipo_registro_producto==1 || tipo_registro_producto==3) {
					// Verificar las series del producto
					const cantidad_producto			= $(this).find('td').eq(3).text();
					const series_producto				= $(this).find('.select2_series_verificar').val();
					if(cantidad_producto != series_producto.length) {
						time_alert('error', 'Error en la series!', 'La cantidad de series seleccionadas no coincide con la cantidad del producto.<br><b>Producto:</b> '+nombre_producto, 3000)
						aux++;
						return;
					} else {
						const data_serie = {
							id_producto:	id_producto,
							series:				series_producto.join(',')
						}
						data_series_productos.push(data_serie);
					}
				}
				if(tipo_registro_producto==2 || tipo_registro_producto==3) {
					// Verificar código de lote del producto
					const codigo_lote = '';
					if(false) {
						time_alert('error', 'Error en la series!', 'La cantidad de series seleccionadas no coincide con la cantidad del producto.<br><b>Producto:</b> '+nombre_producto, 3000)
						aux++;
						return;
					} else {
						const data_codigo_lote = {
							id_producto:	id_producto,
							codigo_lote:	codigo_lote
						}
						data_codigo_lote_productos.push(data_codigo_lote);
					}
				}
			});
			if(aux <= 0) {
				msg_confirmation('warning', '¿Está seguro?', 'No podrá revertir los cambios. La cotización pasará al <b>area de ventas</b> para la entrega de productos.')
				.then((res) => {
					if(res) {
						$.ajax({
							type: "post",
							url: "<?= base_url('cotizacion/marcarCotizacionVerificada'); ?>",
							data: {id: data_cotizacion.id, dsp: data_series_productos, dclp: data_codigo_lote_productos},
							dataType: "json",
							success: function (response) {
								ok_alert('success', 'Cotización verificada!', 'La cotización se verificó correctamente.')
								.then(() => {
									window.location = '<?= base_url('cotizacion/logistica'); ?>'
								});
							}
						});
					}
				});
			}
		});
	});

</script>