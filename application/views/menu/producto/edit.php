<!-- viatmc styles -->
<link rel="stylesheet" href="<?php echo base_url().'css/viatmc/viatmc.css'; ?>">

<div class="page-wrapper">
	<!-- ============================================================== -->
	<!-- Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->

	<div class="container-fluid">
		<!-- ============================================================== -->
		<!-- Start Page Content -->
		<!-- ============================================================== -->
		<!-- Row -->
		<div class="row">
			<!-- Column -->
			<div class="col-lg-12 col-xlg-12 col-md-12">
				<div class="card">
					<div class="card-body">

						<!-- title -->
						<div class="d-md-flex align-items-center">
							<div>
								<h4 class="card-title">Editar Producto</h4>
								<h5 class="card-subtitle" hidden>Overview of Top Selling Items</h5>
							</div>
						</div>
						<!-- title -->

						<form id="form_registrar_producto" class="form-horizontal form-material" method="post" action="/">
							<input type="text" name="id" value="<?= $data_producto->id ?>" class="form-control form-control-line" hidden>
							<div class="form-group row">
								<div class="col-md-4">
									<label for="codigo_referencia">Código de referencia</label>
									<input type="text" id="codigo_referencia" name="codigo_referencia" value="<?= $data_producto->codigo_referencia ?>" class="form-control form-control-line" maxlength="300" placeholder="Ingrese el código de referencia" required>
								</div>
								<div class="col-md-4">
									<label for="nombre">Accesorios/Equipo/Mobiliario/Instrumental</label>
									<input type="text" id="nombre" name="nombre" value="<?= $data_producto->nombre ?>" class="form-control form-control-line" maxlength="300" placeholder="Ingrese el nombre del producto" required>
								</div>
								<div class="col-md-4">
									<label for="marca">Marca</label>
									<input type="text" id="marca" name="marca" value="<?= $data_producto->marca ?>" class="form-control form-control-line" maxlength="300" placeholder="Ingrese la marca del producto" required>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-md-3">
									<label for="modelo">Modelo</label>
									<input type="text" id="modelo" name="modelo" value="<?= $data_producto->modelo ?>" class="form-control form-control-line" maxlength="300" placeholder="Ingrese el modelo" required>
								</div>
								<div class="col-md-3">
									<label for="stock">Stock</label>
									<input type="number" id="stock" name="stock" value="<?= $data_producto->stock > 0 ? $data_producto->stock : 0 ?>" class="form-control form-control-line" min="0" max="999999" placeholder="Ingrese el stock" required>
								</div>
								<div class="col-md-3">
									<label for="nro_seccion">Nro Seccion</label>
									<input type="number" id="nro_seccion" name="nro_seccion" value="<?= $data_producto->nro_seccion ?>" class="form-control form-control-line" min="0" max="999999" placeholder="Ingrese el nro de sección" required>
								</div>
								<div class="col-md-3">
									<label for="procedencia">Procedencia</label>
									<input type="text" id="procedencia" name="procedencia" value="<?= $data_producto->procedencia ?>" class="form-control form-control-line" placeholder="Ingrese la procedencia" maxlength="300">
								</div>
							</div>

							<div class="form-group row">
								<div class="col-md-4">
									<label for="fabricante" class="col-md-12">Fabricante</label>
									<input type="text" id="fabricante" name="fabricante"  value="<?= $data_producto->fabricante ?>" class="form-control form-control-line" placeholder="Ingrese el fabricante del producto" required>
								</div>
								<div class="col-md-4">
									<label for="codigo_barra" class="col-md-12">Código barra</label>
									<input type="text" id="codigo_barra" name="codigo_barra"  value="<?= $data_producto->codigo_barra ?>" class="form-control form-control-line" placeholder="Ingrese el código de barra" required>
								</div>
								<div class="col-md-4">
									<label for="precio_venta">Precio de venta particular (S/. X UNIDAD)</label>
									<input type="number" id="precio_venta" name="precio_venta" value="<?= $data_producto->precio_venta ?>" class="form-control form-control-line" min="0.01" max="9999999" step=".01" placeholder="Ingrese el precio particular" required>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-md-4">
									<label for="precio_institucional">Precio de venta institucional (S/. X UNIDAD)</label>
									<input type="number" id="precio_institucional" name="precio_institucional" value="<?= $data_producto->precio_institucional ?>" class="form-control form-control-line" min="0.01" max="9999999" step=".01" placeholder="Ingrese el precio institucional" required>
								</div>
								<div class="col-md-4">
									<label for="precio_compra">Precio de compra local (S/. x UND)</label>
									<input type="number" id="precio_compra" name="precio_compra" value="<?= $data_producto->precio_compra ?>" class="form-control form-control-line" min="0.01" max="999999" step=".01" placeholder="Ingrese el precio de la compra local" required>
								</div>
								<div class="col-md-4">
									<label for="precio_compra_extranjero">Precio de compra extranjero ($. x UND)</label>
									<input type="number" id="precio_compra_extranjero" name="precio_compra_extranjero" value="<?= $data_producto->precio_compra_extranjero ?>" class="form-control form-control-line" min="0.01" max="999999" step=".01" placeholder="Ingrese el precio de la compra extranjero" required>
								</div>
							</div>

							<!-- <div class="form-group">
								<label for="example-email" class="col-md-12">Tipo de producto</label>
								<div class="col-md-12">
									<input type="email" name="tipo" readonly value="<?= $data_producto->tipo ?>" class="form-control form-control-line" name="example-email" id="example-email">
								</div>
							</div>
							<div class="form-group" hidden>
								<label class="col-md-12">Unidad de medida</label>
								<div class="col-md-12">
									<input type="text" name="unidad_medida" value="<?= $data_producto->unidad_medida_id ?>" readonly class="form-control form-control-line">
								</div>
							</div> -->

							<div class="form-group row">
								<div class="col-md-3">
									<label for="numero_dua">Nro dua</label>
									<input type="number" id="numero_dua" name="numero_dua" value="<?= $data_producto->numero_dua ?>" class="form-control form-control-line" min="0" max="999999" placeholder="Ingrese el número dua">
								</div>
								<div class="col-md-3">
									<label for="presentacion">Presentacion</label>
									<input type="text" id="presentacion" name="presentacion" value="<?= $data_producto->presentacion ?>" class="form-control form-control-line" maxlength="300" placeholder="Ingrese la presentación del producto">
								</div>
								<div class="col-md-3">
									<label for="ubicacion">Ubicacion</label>
									<input type="text" id="ubicacion" name="ubicacion" value="<?= $data_producto->ubicacion ?>" class="form-control form-control-line" placeholder="Ingrese la ubicación del producto">
								</div>
								<div class="col-md-3">
									<label for="tipo_compra">Tipo compra</label>
									<input type="text" id="tipo_compra" name="tipo_compra" value="<?= $data_producto->tipo_compra ?>" class="form-control form-control-line" maxlength="300" placeholder="Ingrese el tipo de compra del producto">
								</div>
							</div>

							<div class="form-group row">
								<div class="col-md-3">
									<label for="registro_sanitario">Registro sanitario</label>
									<input type="text" id="registro_sanitario" name="registro_sanitario" value="<?= $data_producto->registro_sanitario ?>" class="form-control form-control-line" maxlength="300" placeholder="Ingrese el registro sanitario del producto">
								</div>
								<div class="col-md-3">
									<label for="tipo_registro_producto">Tipo de Registro de Producto</label>
									<input type="hidden" value="<?php echo $data_producto->tipo_registro_producto; ?>" name="tipo_registro_producto">
									<select name="tipo_registro_producto" id="tipo_registro_producto" class="form-control form-control-line" readonly disabled required>
										<option value="">(SELECCIONAR)</option>
										<option value="1" <?php echo ($data_producto->tipo_registro_producto == 1)?'selected':''?>>Con Series</option>
										<option value="2" <?php echo ($data_producto->tipo_registro_producto == 2)?'selected':''?>>Con Código de Lote</option>
										<option value="3" <?php echo ($data_producto->tipo_registro_producto == 3)?'selected':''?>>Con Código de Lote y Series</option>
										<option value="4" <?php echo ($data_producto->tipo_registro_producto == 4)?'selected':''?>>Sin Código de Lote y sin Series</option>
									</select>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="estado">
											<span>Estado</span><br>
											<input type="checkbox" value="1" id="estado" name="estado" class="mt-3 cursor_pointer" <?php echo ($data_producto->estado == "1") ? "checked" : "" ?>>
											<span class="cursor_pointer"><?php echo ($data_producto->estado == "1") ? "Activado" : "Desactivado" ?></span>
									</label>
									</div>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-md-6">
									<div id="con_codigo_lote"></div>
									<div id="con_series" class="mt-2"></div>
								</div>
								<div class="col-md-6 text-center">
									<label for="example-email" class="col-md-12">Imagen del producto: </label>
									<img id="placeholderImage" src="<?php echo $data_producto->image ? base_url('').$data_producto->image: base_url('images/placeholder.png') ?>" alt="Producto" width="320" class="pb-2"/>
									<div class="custom-file col-md-6">
										<input type="file" name="productImage" id="imgInp" class="custom-file-input" accept="image/*">
										<label class="custom-file-label text-left" for="validatedCustomFile">Seleccione una imagen</label>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-12 text-center">
									<button class="btn btn-success" type="submit">Actualizar</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- Column -->
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
	const data_producto 				= <?php echo json_encode($data_producto); ?>;
	const data_series_producto	= <?php echo json_encode($data_series_producto); ?>;

	/* Actualizar Producto */
	$('#form_registrar_producto').submit(function (e) {
		e.preventDefault();
		const data_form     = $('#form_registrar_producto').serializeArray();
		let data_form_send  = {};
		data_form.forEach((item) => {
				data_form_send[item.name] = item.value;
		});

		// verificar checkbox, estado.
		data_form_send.estado = 0;
		if( $('#estado').prop('checked') ) {
			data_form_send.estado = 1;
		}

		var formData = new FormData();
		var image = $('#imgInp')[0].files[0];
    formData.append('image', image);
		formData.append('data', JSON.stringify(data_form_send));

		// Recolección de las series de los productos
		let series_producto = [];
		$('.series_producto').each(function() {
			series_producto.push($(this).val())
		})
		formData.append('data_series', JSON.stringify(series_producto));

		$.ajax({
			type: "post",
			url: "<?php echo base_url('producto/update'); ?>",
			data: formData,
			//dataType: "json",
			contentType: false,
      processData: false,
			success: function (response) {
				msg_confirmation('warning', '¿Está seguro?', 'No podrá revertir los cambios.')
				.then((res) => {
					if(res) {
						time_alert('success', 'Producto actualizado!', 'El producto se actualizó correctamente.', 2000)
						.then(() => { window.location = '<?php echo base_url('producto/menu');?>' });
					}
				});
			}
		});
	});
	// Agregar campo para el ingreso del codigo de lote
	function adicionar_codigo_lote_html() {
		$('#con_codigo_lote').html('');
		const lote_html = `
			<label for="lote">Lote</label>
			<input type="number" id="lote" name="lote" value="${data_producto.lote}" class="form-control form-control-line" placeholder="Ingrese el lote del producto" required>
		`;
		$('#con_codigo_lote').append(lote_html);
	}
	// Agregar campos para el ingreso de las series
	function adicionar_series_html() {
		const cantidad = $('#stock').val();
			$('#con_series').html('');
			let series_html = '';
			for (let i=0; i<cantidad; i++) {
				series_html += `
					<div class="form-group row ml-1">
						<label class="col-sm-3 col-form-label col-form-label" style="background: #F2F2F2">#${((i + 1) + "").padStart(2, "0")} Serie: </label>
						<div class="col-sm-9">
							<input type="text" class="form-control series_producto" value="${(data_series_producto.length > i) ? data_series_producto[i].serie : ''}" required>
						</div>
					</div>
				`;
			}
			$('#con_series').append(series_html);
	}
	// Adicion de campos de lote y/o series
	function adicionar_campos_correspondientes() {
		const tipo_reg_producto = $('#tipo_registro_producto').val();
		if(tipo_reg_producto == 1) { 				// SERIES
			adicionar_series_html();
			$('#con_codigo_lote').html('');
		} else if(tipo_reg_producto == 2) { // CODIGO DE LOTE
			adicionar_codigo_lote_html();
			$('#con_series').html('');
		} else if(tipo_reg_producto == 3) { // CODIGO DE LOTE Y SERIES
			adicionar_codigo_lote_html();
			adicionar_series_html();
		} else {
			$('#con_series').html('');
			$('#con_codigo_lote').html('');
		}
	}
	$('#tipo_registro_producto').on('change', function () {
		adicionar_campos_correspondientes();
	});
	$('#stock').on('change', function () {
		adicionar_campos_correspondientes();
	});
	adicionar_campos_correspondientes();
</script>