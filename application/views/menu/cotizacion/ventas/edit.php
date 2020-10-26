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
							<li class="breadcrumb-item"><a href="#">Cotizaciones</a></li>
							<li class="breadcrumb-item active" aria-current="page">Editar Cotización</li>
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
	<?php $i = $data_cotizacion->id; ?>
	<form id="form_cotizacion" method="post" action="/">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<h4 class="card-title">Editar Cotización</h4>
							<div class="row m-t-10">
								<div class="col-md-3">
									<label for="fecha">Fecha</label>
									<input type="date" name="fecha" id="fecha" class="form-control" value="<?= $data_cotizacion->fecha ?>" readonly required/>
								</div>
								<div class="col-md-2">
									<label for="moneda">Moneda</label>
									<select type="text" name="moneda" id="moneda" class="form-control">
										<option value="S/" <?= ($data_cotizacion->moneda == "S/")?'selected':''; ?>>SOLES (S/)</option>
										<option value="$" <?= ($data_cotizacion->moneda == "$")?'selected':''; ?>>DOLARES ($)</option>
									</select>
								</div>
								<div class="col-md-4">
									<label for="cliente_id">Cliente</label>
									<select name="cliente_id" class="form-control" id="cliente_id" required="required">
										<option value="<?= $data_cotizacion->cliente_id; ?>" selected><?= $data_cotizacion->nombre_cliente; ?></option>
									</select>
								</div>
								<div class="col-md-3">
									<label for="vendedor_id">Vendedor</label>
									<select name="vendedor_id" id="vendedor_id" class="form-control"required>
										<option value="<?= $data_cotizacion->vendedor_id; ?>"><?= $data_cotizacion->nombre_vendedor; ?></option>
									</select>
								</div>
							</div>
								<div class="row m-t-10">
									<div class="col-lg-12">
										<button type="button" class="btn btn-primary" id="add_producto" ><i class="fa fa-plus"></i> Agregar producto</button>
									</div>
								</div>
								<div class="row m-t-10">
									<div class="col-lg-12">
										<div class="table-responsive">
											<table class="table table-striped table-bordered" style="width:100%;" id="tabla_productos_registrar_cotizacion">
												<thead class="">
													<tr>
														<th>Nombre</th>
														<th>Marca</th>
														<th>Procedencia</th>
														<th>Precio U.</th>
														<th>Cantidad</th>
														<th>Entrega</th>
														<th>Validez</th>
														<th>Garantia</th>
														<th>Forma Pago</th>
														<th>Monto</th>
														<th width="15%">Acciones</th>
													</tr>
												</thead>
												<?php $montoProducto = 0; ?>
												<tbody id="tbody_productos_cotizacion">
													<?php foreach($cotizacion_detalle_productos as $cdp): ?>
														<?php $montoProducto += (float) $cdp->montoproducto; ?>
														<tr>
															<td><strong><?= $cdp->nombre; ?></strong></td>
															<td><?= $cdp->marca; ?></td>
															<td><?= $cdp->procedencia; ?></td>
															<td><?= $cdp->precioproducto; ?></td>
															<td><?= $cdp->cantidad; ?></td>
															<td><?= $cdp->entrega; ?></td>
															<td><?= $cdp->validezOferta; ?></td>
															<td><?= $cdp->garantiaMeses; ?></td>
															<td><?= $cdp->formaPago; ?></td>
															<td><strong><?= $cdp->montoproducto; ?></strong></td>
															<td class="text-center">
																<button type="button" class="btn btn-warning btn-xs eliminar_fila" title="Editar registro" onclick="editar_producto(this)">Editar</button>
																<button type="button" class="btn btn-danger btn-xs eliminar_fila" title="Eliminar registro">Eliminar</button>
																<input type="text" value="<?= $cdp->id_producto; ?>" hidden/>
															</td>
														</tr>
													<?php endforeach; ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>

								<div class="row justify-content-end text-right m-t-10">
									<div class="col-md-4">
									<label for="montototal"><strong>Monto Total</strong></label>
									<input type="number" name="montototal" id="montototal" class="form-control" value="<?php echo $montoProducto; ?>" min="0" readonly/>
								</div>
							</div>
								<div class="row justify-content-end text-right m-t-10">
								<div class="col-md-4">
									<button type="submit" class="btn btn-success">Actualizar</button>
									<a href="<?= base_url('cotizacion'); ?>" class="btn btn-danger">Cancelar</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<!-- Modal agregar producto -->
<div id="modal_add_producto" class="modal fade" data-backdrop="static" data-keyboard="false"> <!-- id="vm_add_producto" -->
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h6 class="modal-title" style="color:white"><span id="titulo_modal_producto"></span> Producto</h6>
				<button type="button" class="close" id="button_cerrar_modal_add_producto" data-dismiss="modal">&times;</button>
			</div>

			<div class="modal-body">
				<form class="form-horizontal form-material" id="form_add_producto" method="post">
					<div class="row">
						<!-- Producto -->
						<div class="col-md-4">
							<label for="producto_id">Producto</label>
							<?php echo form_dropdown(['name' => 'producto_id', 'id' => 'producto_id', 'class' => 'form-control select2', 'required' => 'required', 'onchange'=>'get_data_producto(this)'],['' => '(SELECCIONAR)']+$data_productos) ?>
						</div>
						<!-- Precio -->
						<div class="col-md-4">
							<label for="precioproducto">Precio</label>
							<input type="number"  id="precioproducto" name="precioproducto" step="0.01" class="form-control" required/>
						</div>
						<!-- Cantidad -->
						<div class="col-md-4">
							<label for="cantidad">Cantidad</label>
								<input type="number" id="cantidad" name="cantidad" class="form-control form-control-line" min="0" required>
						</div>
					</div>

					<div class="row m-t-10">
						<!-- Marca -->
						<div class="col-md-4">
							<div class="form-check form-check-inline">
								<input class="form-check-input cursor_pointer toggle_check" type="checkbox" id="toggleMarca">
								<label class="form-check-label cursor_pointer" for="toggleMarca">Marca</label>
							</div>
							<div id="marcaToggleObjet" class="toggle_object">
								<input type="text" id="marcaproducto" name="marcaproducto" class="form-control"/>
							</div>
						</div>
						<!-- Modelo -->
						<div class="col-md-4">
							<div class="form-check form-check-inline">
								<input class="form-check-input cursor_pointer toggle_check" type="checkbox" id="toggleModelo">
								<label class="form-check-label cursor_pointer" for="toggleModelo">Modelo</label>
							</div>
							<div id="modeloToggleObjet" class="toggle_object">
								<input type="text" id="modeloproducto" name="modeloproducto" class="form-control"/>
							</div>
						</div>
						<!-- Procedencia -->
						<div class="col-md-4">
							<div class="form-check form-check-inline">
								<input class="form-check-input cursor_pointer toggle_check" type="checkbox" id="toggleProcedencia">
								<label class="form-check-label cursor_pointer" for="toggleProcedencia">Procedencia</label>
							</div>
							<div id="procedenciaToggleObjet" class="toggle_object">
								<input type="text"  id="procedenciaproducto" name="procedenciaproducto" class="form-control"  />
							</div>
						</div>
					</div>
					<div class="row m-t-10">
						<!-- Agregar Imagenes -->
						<div class="col-md-12">
							<div class="form-check form-check-inline">
								<input class="form-check-input cursor_pointer toggle_check" type="checkbox" id="toggleImagenes">
								<label class="form-check-label cursor_pointer" for="toggleImagenes">Agregar imagenes</label>
							</div>
							<div id="imagenesToggleObjet" class="toggle_object">
								<input type="hidden" name="size" value="1000000">
								<input type="hidden" name="image1Set" id="image1Set" value="1000000">
								<div class="row text-center">
									<div class="col-md-6">
										<img id="imagen1" style="width:100px;"  alt="" srcset="">
										<div class="custom-file mt-2">
											<input type="file" name="image1" id="imageUploaded1" class="custom-file-input" accept="image/*">
											<label class="custom-file-label" for="validatedCustomFile">Seleccione una imagen</label>
										</div>
									</div>
									<div class="col-md-6">
										<img id="imagen2" style="width:100px;"  alt="" srcset="">
										<div class="custom-file mt-2">
											<input type="file" name="image2" id="imageUploaded2" class="custom-file-input" accept="image/*">
											<label class="custom-file-label" for="validatedCustomFile">Seleccione una imagen</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row m-t-10">
						<!-- Validez Oferta -->
						<div class="col-md-3">
							<div class="form-check form-check-inline">
								<input class="form-check-input cursor_pointer toggle_check" type="checkbox" id="toggleValidez">
								<label class="form-check-label cursor_pointer" for="toggleValidez">Validez oferta</label>
							</div>
							<div id="validezToggleObjet" class="toggle_object">
								<input type="text" id="validezOferta" name="validezOferta" class="form-control form-control-line" min="0">
							</div>
						</div>
						<!-- Entrega -->
						<div class="col-md-3">
							<div class="form-check form-check-inline">
								<input class="form-check-input cursor_pointer toggle_check" type="checkbox" id="toggleEntrega">
								<label class="form-check-label cursor_pointer" for="toggleEntrega">Entrega</label>
								</div>
							<div id="entregaToggleObjet" class="toggle_object">
								<input type="text" id="entrega" name="entrega" class="form-control form-control-line" min="0">
							</div>
						</div>
						<!-- Forma de Pago -->
						<div class="col-md-3">
							<div class="form-check form-check-inline">
								<input class="form-check-input cursor_pointer toggle_check" type="checkbox" id="toggleFormaPago">
								<label class="form-check-label cursor_pointer" for="toggleFormaPago">Forma de pago</label>
								</div>
							<div id="formaPagoToggleObjet" class="toggle_object">
								<input type="text" id="formaPago" name="formaPago" class="form-control form-control-line" min="0">
							</div>
						</div>
						<!-- Garantía mes -->
						<div class="col-md-3">
							<div class="form-check form-check-inline">
								<input class="form-check-input cursor_pointer toggle_check" type="checkbox" id="toggleGarantia">
								<label class="form-check-label cursor_pointer" for="toggleGarantia">Garantia mes</label>
								</div>
							<div id="garantiaToggleObjet" class="toggle_object">
								<input type="text" id="garantiaMeses" name="garantiaMeses" class="form-control form-control-line" min="0">
							</div>
						</div>
					</div>

					<div class="row m-t-10">
						<!-- Descripción General -->
						<div class="col-md-12">
							<label for="producto_descripcion">Descripción general</label>
							<textarea id="producto_descripcion" name="producto_descripcion"></textarea>
							<input type="text" id="producto_descripcion_aux" name="producto_descripcion_aux" hidden/>
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
<!-- modulo cotizaciones scripts -->
<script src="<?php echo base_url().'js/viatmc/modulo_cotizacion.js'; ?>"></script>

<script>
	let data_lista_productos_cotizacion = <?php echo json_encode($cotizacion_detalle_productos); ?>;
	let cargar_data_producto 						= true; /* caso registrar y editar */
	/* Agregar un producto, validación de datos */
	$('#add_producto').on('click', function(e) {
    if ($("#cliente_id").val() == "") {
			time_alert('error', 'Seleccione un Cliente!', 'Debe elegir a un cliente', 1500)
    } else {
			cargar_data_producto = true; // si cargar información del producto
      $('#modal_add_producto').modal('show');
			$('#button_cerrar_modal_add_producto').show();
    }
	});
	/* Obtener datos del producto seleccionado */
	function get_data_producto() {
		const producto_id	= $('#producto_id').val();
		if(!cargar_data_producto) return;
		// Verificar si no se está duplicando el producto
		const res = data_lista_productos_cotizacion.find((item) => item.id_producto == producto_id)
		if(res) {
			cargar_data_producto = false; // Que no verifique
			time_alert('error', 'Producto agregado!', 'El producto ya ha sido agregado a la cotización.', 2000)
			$('#producto_id').val('').change();
			cargar_data_producto = true; // Que vuelva a verificar
			return;
		}
		// Buscar información producto
		if(producto_id == ''){
			$('#precioproducto').val('');
			$('#marcaproducto').val('');
			$('#modeloproducto').val('');
			$('#procedenciaproducto').val('');
			return;
		}
		// Solicitud obtener datos del producto
		$.ajax({
			url: '<?php echo base_url('producto/getDataProducto'); ?>',
			method: 'post',
			data: {id: producto_id},
			dataType : 'json',
			success: function (response) {
				$('#precioproducto').val(response.precio_venta);
				$('#marcaproducto').val(response.marca);
				$('#modeloproducto').val(response.modelo);
				$('#procedenciaproducto').val(response.procedencia);
			}
		});
	};
	/* Calcular total de la cotización */
	function sumar_total() {
		let montoproducto = 0;
		$("#tbody_productos_cotizacion tr td:nth-child(10)").each(function() {
			montoproducto = montoproducto + parseFloat($(this).text());
		});
		$('#montototal').val(parseFloat(montoproducto).toFixed(2));
  }
	/* Limpiar formulario modal */
	function limpiar_form_add_producto() {
		document.getElementById("form_add_producto").reset();
		$("#producto_id").change();
		$(".toggle_object").slideUp();
		$('#imagen1').attr("src", "#");
		$('#imagen2').attr("src", "#");
	}
	/* Registrar imagenes producto cotización */
	function guardar_imagenes_producto (data_form) {
		const dir_imagenes = $.ajax({
			url: '<?= base_url('producto/guardar_imagenes_cotizacion') ?>',
			method: 'POST',
			data: data_form,
			contentType: false,
			cache: false,
			processData: false,
			async: false,
			success: function(data) {
				return data;
			}
		}).responseText;
		return dir_imagenes;
	}
	/* Registrar iamgenes del producto y adionar a la tabla de cotización */
	$('#form_add_producto').on('submit', function(e) {
    e.preventDefault();
		/* descripción c/formato del producto */
		$('#producto_descripcion').text(tinymce.get('producto_descripcion').getContent());
		/* validar campos seleccionados */
		if(!$('#toggleMarca').prop('checked')) $('#marcaproducto').val('');
		if(!$('#toggleModelo').prop('checked')) $('#modeloproducto').val('');
		if(!$('#toggleProcedencia').prop('checked')) $('#procedenciaproducto').val('');
		if(!$('#toggleValidez').prop('checked')) $('#validezOferta').val('');
		if(!$('#toggleEntrega').prop('checked')) $('#entrega').val('');
		if(!$('#toggleFormaPago').prop('checked')) $('#formaPago').val('');
		if(!$('#toggleGarantia').prop('checked')) $('#garantiaMeses').val('');
		/* obtener datos del producto y validar */
		const nombre_producto					= $("#producto_id option:selected").text();
		let data_producto_cotizacion	= {
			id_producto:						$('#producto_id').val(),
			precioproducto:					$('#precioproducto').val(),
			cantidad:								$('#cantidad').val(),
			marca:									$('#marcaproducto').val(),
			modelo:									$('#modeloproducto').val(),
			procedencia:						$('#procedenciaproducto').val(),
			image1:									'',
			image2:									'',
			validezOferta:					$('#validezOferta').val(),
			entrega:								$('#entrega').val(),
			formaPago:							$('#formaPago').val(),
			garantiaMeses:					$('#garantiaMeses').val(),
			producto_descripcion:		$('#producto_descripcion').text(),
			montoproducto:					$('#montoproducto').val(),
		}
		/* Validación, cantidad > 0 */
		if (cantidad == "" || parseFloat(cantidad)<= 0 ) {
			time_alert('error', 'Error en la cantidad!', 'Ingrese la cantidad, la cantidad debe ser mayor a cero.', 1500)
			return;
		}
		const imagenes = JSON.parse(guardar_imagenes_producto(new FormData(this)));
		data_producto_cotizacion.image1 = imagenes.image1;
		data_producto_cotizacion.image2 = imagenes.image2;

		/* adicionar producto a la tabla */
		$('#tbody_productos_cotizacion').append(
			`<tr>
				<td><strong>${nombre_producto}</strong></td>
				<td>${data_producto_cotizacion.marca}</td>
				<td>${data_producto_cotizacion.procedencia}</td>
				<td>${data_producto_cotizacion.precioproducto}</td>
				<td>${data_producto_cotizacion.cantidad}</td>
				<td>${data_producto_cotizacion.entrega}</td>
				<td>${data_producto_cotizacion.validezOferta}</td>
				<td>${data_producto_cotizacion.garantiaMeses}</td>
				<td>${data_producto_cotizacion.formaPago}</td>
				<td><strong>${data_producto_cotizacion.montoproducto}</strong></td>
				<td class="text-center">
					<button type="button" class="btn btn-warning btn-xs editar_fila" title="Editar registro">Editar</button>
					<button type="button" class=" btn btn-danger btn-xs eliminar_fila" title="Eliminar registro"> Eliminar</button>
					<input type="text" value="${data_producto_cotizacion.id_producto}" hidden/>
				</td>
			</tr>`
		);
		$('#modal_add_producto').modal('toggle');		// cerra modal 'agregar producto'
		sumar_total();															// suma total de la cotización
		limpiar_form_add_producto();								// limpiar form agregar producto 'modal'
		// actualizar la lista que continen los datos del producto agregado (para editar)
		data_lista_productos_cotizacion.push(data_producto_cotizacion);
	});
	function eliminarProductoListaCotizacion(id_eliminar_producto) {
		data_lista_productos_cotizacion = data_lista_productos_cotizacion.filter((item) => item.id_producto != id_eliminar_producto);
	}
	/* Eliminar producto - fila */
	$('#tbody_productos_cotizacion').on('click', '.eliminar_fila', function(){    // eliminar fila
		const id_eliminar = $(this).parent().find('input').val();
		eliminarProductoListaCotizacion(id_eliminar);
		$(this).parents('tr').detach();
		sumar_total(); 															// suma total de la cotización
  });
	/* Editar producto de la cotización */
	function editar_producto(element) {
		limpiar_form_add_producto();
		$('#button_cerrar_modal_add_producto').hide();
		const producto_cotizacion_id	= $(element).parent().find('input').val();
		const producto_detalle 				= data_lista_productos_cotizacion.find((p) => p.id_producto == producto_cotizacion_id);
		/* Eliminamos la fila a editar */
		eliminarProductoListaCotizacion(producto_cotizacion_id);
		$('#titulo_modal_producto').text('Editar');
		// cargar datos -> modal
		/* producto */
		cargar_data_producto = false; // no cargar información del producto
		$('#producto_id').val(producto_detalle.id_producto).change();
		cargar_data_producto = true;	// habilitar para cargar información del producto
		/* marca */
		if(producto_detalle.marca != '')
			$('#toggleMarca').click();
		$('#marcaproducto').val(producto_detalle.marca);
		/* modelo */
		if(producto_detalle.modelo != '')
			$('#toggleModelo').click();
		$('#modeloproducto').val(producto_detalle.modelo);
		/* procedencia */
		if(producto_detalle.procedencia != '')
			$('#toggleProcedencia').click();
		$('#procedenciaproducto').val(producto_detalle.procedencia);
		/* imagenes */
		if(producto_detalle.image1 != null || producto_detalle.image2 != null)
			$('#toggleImagenes').click();
		if(producto_detalle.image1 != null)
			$('#imagen1').attr("src", '<?= base_url()?>'+producto_detalle.image1);
		if(producto_detalle.image2 != null)
			$('#imagen2').attr("src", '<?= base_url()?>'+producto_detalle.image2);
		/* precio */
		$('#precioproducto').val(producto_detalle.precioproducto);
		/* cantidad */
		$('#cantidad').val(producto_detalle.cantidad);
		/* validez oferta */
		if(producto_detalle.validezOferta != '')
			$('#toggleValidez').click();
		$('#validezOferta').val(producto_detalle.validezOferta);
		/* entrega */
		if(producto_detalle.entrega != '')
			$('#toggleEntrega').click();
		$('#entrega').val(producto_detalle.entrega);
		/* forma pago */
		if(producto_detalle.formaPago != '')
			$('#toggleFormaPago').click();
		$('#formaPago').val(producto_detalle.formaPago);
		/* garantia mes */
		if(producto_detalle.garantiaMeses != '')
			$('#toggleGarantia').click();
		$('#garantiaMeses').val(producto_detalle.garantiaMeses);
		/* descripcion del producto */
		//$(tinymce.get('producto_descripcion').getBody()).html(producto_detalle.producto_descripcion);
		tinymce.get('producto_descripcion').setContent(producto_detalle.producto_descripcion);
		/* monto producto */
		$('#montoproducto').val(producto_detalle.montoproducto);

		/* Mostrar modal */
		$('#modal_add_producto').modal('show');
		sumar_total(); 															// suma total de la cotización
	}
	/* Registrar Cotización */
	$('#form_cotizacion').submit(function (e) {
		e.preventDefault();
		const tipo_cotizacion = $('#tipo_cotizacion').val();
		// Data Cotización
		const data_cotizacion = {
			'moneda':						$('#moneda').val(),
			'cliente_id':				$('#cliente_id').val(),
			'montototal':				$('#montototal').val(),
			'vendedor_id':			$("#vendedor_id").val(),
		}
		// Data lista de productos, validación lista de productos
		if(data_lista_productos_cotizacion.length == 0) {
			time_alert('error', 'Lista de Productos!', 'Debe agregar por lo menos un porducto.', 1500)
			return;
		}
		// Registro/Actualización de datos
		const id_cotizacion = '<?= $data_cotizacion->id; ?>';
		msg_confirmation('warning', '¿Está seguro?', 'Se actualizará la cotización.')
		.then((res) => {
			if(res) {
				$.ajax({
					type: "post",
					url: "<?php echo base_url('cotizacion/update'); ?>",
					data: {id: id_cotizacion, dc: data_cotizacion, dcd: data_lista_productos_cotizacion},
					dataType: "json",
					success: function (response) {
						ok_alert('success', 'Actualizado', 'La cotización se actualizó correctamente.')
						.then(() => {
							window.location = '<?php echo base_url('cotizacion'); ?>';
						});
					}
				});
			}
		});
	});
	/* Plugin para texto con formato */
	tinymce.init({
		selector: '#producto_descripcion',
		content_css: '//www.tiny.cloud/css/codepen.min.css',
		height: 300,
		plugins: [
			'advlist autolink link image lists hr anchor',
			'searchreplace visualblocks visualchars insertdatetime nonbreaking',
			'table template paste'
		],
		toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
			'bullist numlist outdent indent | link image | media | ' +
			'forecolor backcolor',
		menubar: 'edit view insert format tools table help'
	});
</script>