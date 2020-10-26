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
							<li class="breadcrumb-item active" aria-current="page">Registrar Cotizacion</li>
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
	<!-- Formulario de cotización -->
	<form id="form_cotizacion" method="post" action="#">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<h4 class="card-title">Registrar Cotización</h4>
							<div class="row">
								<div class="col-md-2">
									<label for="fecha">Fecha</label>
									<input type="date" id="fecha" name="fecha" class="form-control" value="<?= date('Y-m-d')?>" readonly required/>
								</div>
								<div class="col-md-2">
									<label for="moneda">Moneda</label>
									<select type="text" id="moneda" name="moneda" class="form-control">
										<option value="S/">SOLES (S/)</option>
										<option value="$">DOLARES ($)</option>
									</select>
								</div>
								<div class="col-md-2">
									<label for="tipo_cotizacion">Tipo cotización</label>
									<?php echo form_dropdown(['id' => 'tipo_cotizacion', 'name' => 'tipo_cotizacion', 'class' => 'form-control', 'required' => 'required', 'onchange'=>'tipo_formulario(this);'],['' => '(SELECCIONAR)']+$this->constantes->TIPO_COTIZACION) ?>
								</div>
								<div class="col-md-3">
									<label for="cliente_id">Cliente</label>
									<select name="cliente_id" id="cliente_id" onchange="filtrar_vendedores()" class="form-control select2" required>
										<option value="">(SELECCIONAR)</option>
										<?php foreach($data_clientes as $c): ?>
											<option value="<?= $c->id; ?>"><?= $c->numero_documento.' - '.$c->nombre_cotizacion;?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-md-3">
									<label for="vendedor_id">Vendedor</label>
									<select name="vendedor_id" id="vendedor_id" class="form-control select2" placeholder="fff" required>
										<option value="">(SELECCIONAR)</option>
										<!-- dinámico - js -->
									</select>
								</div>
							</div>
							<hr>

							<!-- Cotización Tipo Productos -->
							<div id="cotizacion_producto" style="display: none">
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
												<tbody id="tbody_productos_cotizacion">
													<!-- js -->
												</tbody>
											</table>
										</div>
									</div>
								</div>

								<div class="row justify-content-end text-right m-t-10">
									<div class="col-lg-4">
										<label for="montototal"><strong>Monto Total</strong> </label>
										<input type="number" id="montototal" name="montototal" value="0.00" min="0" class="form-control" readonly/>
									</div>
								</div>
								<div class="row justify-content-end text-right m-t-10">
									<div class="col-md-12">
										<button type="submit" class="btn btn-success">Guardar</button>
										<a href="<?= base_url('cotizacion'); ?>" class="btn btn-danger">Cancelar</a>
									</div>
								</div>
							</div>

							<!-- Cotización Tipo Servicios -->
							<div style="display: none" id="cotizacion_servicio">
								<hr>
								<ul class="row list-style-none text-left m-t-30">
									<li class="col-lg-6">
										<span class="">Servicio</span>
										<input type="text" id="servicio_id" style="width: 100%" name="servicio_id">
									</li >
								</ul>
								<ul class="row list-style-none text-left m-t-30">
									<li class="col-lg-6">
										<span class="">Referencia</span>
										<input type="text" id="referencia" style="width: 100%" name="referencia">
									</li >
								</ul>
								<div class="form-group">
									<label class="col-md-12">Caracteristicas</label>
									<ul class="row list-style-none text-left m-t-30">
										<li class="col-lg-6">
											<span class="">Equipo</span>
											<input type="text" name="equipoTitulo" id="equipoTitulo" value="Equipo" style="width:100%; font-weight: bold;" >
											<input type="text" name="equipoDetalle" id="equipoDetalle"  style="width:100%" >
										</li>
										<li class="col-lg-6">
											<span class="">Marca</span>
											<input type="text" name="MarcaTitulo" id="MarcaTitulo" value="Marca" style="width:100%; font-weight: bold;" >
										<input type="text" name="MarcaDetalle" id="MarcaDetalle"  style="width:100%" >
										</li>
										<li class="col-lg-6">
											<span class="">Modelo</span>
											<input type="text" name="ModeloTitulo" id="ModeloTitulo" value="Modelo" style="width:100%; font-weight: bold;" >
											<input type="text" name="ModeloDetalle" id="ModeloDetalle"  style="width:100%" >
										</li>
										<li class="col-lg-6">
											<span class="">Nro Serie</span>
											<input type="text" name="NroSerieTitulo" id="NroSerieTitulo" value="Nro Serie" style="width:100%; font-weight: bold;" >
											<input type="text" name="NroSerieDetalle" id="NroSerieDetalle"  style="width:100%" >
										</li>
										<li class="col-lg-6">
											<span class="">Cod. inv</span>
											<input type="text" name="CodInvTitulo" id="CodInvTitulo" value="Cod. inv" style="width:100%; font-weight: bold;" >
											<input type="text" name="CodInvDetalle" id="CodInvDetalle"  style="width:100%" >
										</li>
									</ul>
								</div>
								<hr>
								<div class="form-group">
									<ul class="row list-style-none text-left m-t-30">
										<li class="col-lg-6">
											<span class="">MANTENIMIENTO</span>
											<input type="text" name="MantenimientoTitulo"   id="MantenimientoTitulo" value="MANTENIMIENTO" style="width:100%; font-weight: bold;" >
											<input type="text" name="MantenimientoDetalle1" id="MantenimientoDetalle1"  style="width:100%" >
											<input type="text" name="MantenimientoDetalle2" id="MantenimientoDetalle2"  style="width:100%" >
											<input type="text" name="MantenimientoDetalle3" id="MantenimientoDetalle3"  style="width:100%" >
											<input type="text" name="MantenimientoDetalle4" id="MantenimientoDetalle4"  style="width:100%" >
											<input type="text" name="MantenimientoDetalle5" id="MantenimientoDetalle5"  style="width:100%" >
										</li>
										<li class="col-lg-6">
											<span class="">CAMBIO DE PARTES Y PIEZAS DE REPUESTO</span>
											<input type="text" name="CambioPartesTitulo"  id="CambioPartesTitulo" value="CAMBIO DE PARTES Y PIEZAS DE REPUESTO" style="width:100%; font-weight: bold;" >
											<input type="text" name="CambioPartesDetalle" id="CambioPartesDetalle"  style="width:100%" >
										</li>
										<li class="col-lg-6">
											<span class="">VERIFICACIÓN DE PARAMETROS DE DESEMPEÑO</span>
											<input type="text" name="VerificacionTitulo"  id="VerificacionTitulo" value="VERIFICACIÓN DE PARAMETROS DE DESEMPEÑO" style="width:100%; font-weight: bold;" >
											<input type="text" name="VerificacionDetalle" id="VerificacionDetalle"  style="width:100%" >
										</li>
										<li class="col-lg-6">
											<span class="">TERMINOS COMERCIALES</span>
											<input type="text" name="TerminosComercialesTitulo"  id="TerminosComercialesTitulo" value="TERMINOS COMERCIALES" style="width:100%; font-weight: bold;" >
											<input type="text" name="TerminosComercialesDetalle1" id="TerminosComercialesDetalle1"  style="width:100%" >
											<input type="text" name="TerminosComercialesDetalle2" id="TerminosComercialesDetalle2"  style="width:100%" >
											<input type="text" name="TerminosComercialesDetalle3" id="TerminosComercialesDetalle3"  style="width:100%" >
										</li>
									</ul>
								</div>
								<hr>
								<ul class="row list-style-none text-left m-t-30">
									<li class="col-lg-3">
										<span class=""><b>Monto Total</b> </span>
										<input type="number" style="background-color: #E5F18F;" step="0.01" name="montototals" id="montotota"
											value="0.00" min="0" class="form-control" />
									</li>
								</ul>
								<ul class="row list-style-none text-left m-t-30">
									<li class="col-lg-4">
										<button type="submit" class="btn btn-success">Guardar</button>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Start Page Content -->
			<div class="col-lg-4" hidden>
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Productos </h4>
						<button type="button" class="btn btn-primary" id="add_proucto" >Agregar producto</button>
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Nombre</th>
									<th>Cantidad</th>
									<th>Precio Uni.</th>
									<th>Monto</th>
									<th></th>
								</tr>
							</thead>
						</table>
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
	let data_lista_productos_cotizacion = [];
	let cargar_data_producto 						= true; /* caso registrar y editar */
	const data_vendedores								= <?php echo json_encode($data_vendedores); ?>;
	const data_clientes									= <?php echo json_encode($data_clientes); ?>;
	const tipo_formulario = (e) => {
		if(e.value !== ''){
			const valor = parseInt(e.value);
			switch (valor) {
				case 1:
					document.getElementById('cotizacion_servicio').style.display = 'none';
					document.getElementById('cotizacion_producto').style.display = 'block';
					document.getElementById('servicio_id').removeAttribute('required','required');
					document.getElementById('referencia').removeAttribute('required','required');
					break;
				case 2:
					document.getElementById('servicio_id').setAttribute('required','required');
					document.getElementById('referencia').setAttribute('required','required');
					document.getElementById('cotizacion_producto').style.display = 'none';
					document.getElementById('cotizacion_servicio').style.display = 'block';
					break;
				default:
					document.getElementById('cotizacion_producto').style.display = 'none';
					document.getElementById('cotizacion_servicio').style.display = 'none';
					break;
			} // end switch
		} else {
			document.getElementById('cotizacion_producto').style.display = 'none';
			document.getElementById('cotizacion_servicio').style.display = 'none';
		}
	};
	/* Relación cliente - vendedor */
	function filtrar_vendedores() {
		const cliente_id = $('#cliente_id').val();
		$('#vendedor_id').empty();
		if(cliente_id == '') return;
		const data_cliente = data_clientes.find((item) => item.id == cliente_id);
		const data_vendedores_cliente = data_vendedores.filter((item) => item.id == data_cliente.id_vendedor);
		data_vendedores_cliente.forEach((item) => {
			$('#vendedor_id').append(`<option value="${item.id}">${item.nombre_vendedor}</option>`);
		});
	}
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
					<button type="button" class="btn btn-warning btn-xs" title="Editar registro" onclick="editar_producto(this)">Editar</button>
					<button class=" btn btn-danger btn-xs eliminar_fila" title="Eliminar registro"> Eliminar</button>
					<input type="text" value="${data_producto_cotizacion.id_producto}" hidden/>
				</td>
			</tr>`
		);
		$('#modal_add_producto').modal('toggle');		// cerra modal 'agregar producto'
		sumar_total(); 															// suma total de la cotización
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
		const producto_cotizacion_id = $(element).parent().find('input').val();
		const producto_detalle = data_lista_productos_cotizacion.find((p) => p.id_producto == producto_cotizacion_id);
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
		/* Eliminamos la fila a editar */
		$(element).parents('tr').detach();
		eliminarProductoListaCotizacion(producto_cotizacion_id);
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
			'totalpagar':				'', // ?
			'estado':  					'1',
			//'tipo_cotizacion':	'PRODUCTO',
			'vendedor_id':			$("#vendedor_id").val(),
		}
		// Data lista de productos, validación lista de productos
		if(data_lista_productos_cotizacion.length == 0) {
			time_alert('error', 'Lista de Productos!', 'Debe agregar por lo menos un porducto.', 1500)
			return;
		}
		// Registro de datos
		msg_confirmation('warning', '¿Está seguro?', 'Se registrará una nueva cotización.')
		.then((res) => {
			if(res) {
				$.ajax({
					type: "post",
					url: "<?php echo base_url('cotizacion/post'); ?>",
					data: {tc: tipo_cotizacion, dc: data_cotizacion, dcd: data_lista_productos_cotizacion},
					dataType: "json",
					success: function (response) {
						ok_alert('success', 'Registrado', 'La cotización se registró correctamente.')
						.then(() => {
							window.location = '<?php echo base_url('cotizacion'); ?>';
						})
					}
				});
			}
		})
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