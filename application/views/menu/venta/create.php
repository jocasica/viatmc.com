<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> TMC - Facturación Electrónica </title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?= base_url('') ?>plantilla/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url('') ?>plantilla/assets/css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url('') ?>plantilla/assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url('') ?>plantilla/assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url('') ?>plantilla/assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url('') ?>plantilla/assets/css/colors.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url('') ?>plantilla/select2.min.css" rel="stylesheet" type="text/css">
	<!-- viatmc styles -->
	<link rel="stylesheet" href="<?php echo base_url().'css/viatmc/viatmc.css'; ?>">
	<!-- /global stylesheets -->
	<?php
	// if (isset($direcciones)) print_r($direcciones);
	// die;
	?>

</head>

<body class="navbar-bottom">
	<style type="text/css" media="screen">
		.stepy-header {
			margin: 0 auto;
			max-width: 500px;
		}

		.stepy-navigator {
			text-align: center;
		}

		.custom-textarea:focus {
			/* outline: 0; */
			/* border-color: transparent; */
			border-bottom-color: #009688;
			-webkit-box-shadow: 0 1px 0 #009688;
			box-shadow: 0 1px 0 #009688;
			border-color: #ddd;
			outline: 0;
			-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(221, 221, 221, 0.6);
			box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(221, 221, 221, 0.6);
		}

		.custom-textarea {
			display: block;
			width: 100%;
			padding: 8px 16px;
			font-size: 13px;
			line-height: 1.5384616;
			color: #333333;
			background-color: transparent;
			background-image: none;
			border: 1px solid #ddd;
			border-radius: 3px;
			-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
			box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
			-webkit-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
			-o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
			transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
		}

		.panel-factura {
			margin-bottom: 20px;
			background-color: #eeeded;
			border: 1px solid transparent;
			border-radius: 0px;
			-webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
			box-shadow: 0 0px 0px rgba(0, 0, 0, 0.05);
		}

		.form-control {
			display: block !important;
			width: 100% !important;
			height: 38px !important;
			padding: 8px 16px !important;
			font-size: 13px !important;
			line-height: 1.5384616 !important;
			color: #333333 !important;
			background-color: transparent !important;
			background-image: none !important;
			border: 1px solid #ddd !important;
			border-radius: 3px !important;
			-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075) !important;
			box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075) !important;
			-webkit-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s !important;
			-o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s !important;
			transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s !important;
		}
	</style>
	<!-- Page header -->
	<!-- /Page header -->
	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">
			<!-- Main content -->
			<div class="content-wrapper">
				<!-- content -->
				<div class="row">
					<!-- Documento Electrónico -->
					<form name="frm_comprobanteelectronico" id="frm_comprobanteelectronico" action="#" method="post" accept-charset="utf-8">
						<div class="row">
							<div class="col-md-12 text-center">
								<a href="<?= base_url('venta') ?>" class="btn btn-warning btn-block btn-labeled btn-xs legitRipple">
									IR A LISTADO DE FACTURAS</a>
							</div>
							<div class="col-md-12" style="margin-bottom: 15px;">
								<div class="panel" style="max-width: 1100px; margin: 0 auto;">
									<div class="panel-body" id="cuerpo_comprobante">
										<fieldset class="content-group">
											<legend class="text-bold">Tipo de Comprobante: </legend>
											<div class="row">
												<div class="col-md-6">
													<div class="radio">
														<label class="btn btn-primary btn-lg btn-block lbl-factura">
															<!-- <input num="<?php #echo $numeros->result()[0]->numero ?>" >	 -->
															<input type="radio" value="01" id="factura" data-tipo="factura" name="tipo_comprobante" style="display: none;" checked>
															Factura
														</label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="radio">
														<label class="btn btn-default btn-lg btn-block lbl-boleta lbl-active">
														<!-- <input num="<?php #echo $numeros->result()[1]->numero ?>" > -->
															<input type="radio" value="03" id="boleta" data-tipo="boleta" name="tipo_comprobante" style="display: none;">
															Boleta
														</label>
													</div>
												</div>
											</div>
										</fieldset>
										<a href="#" class="btn btn-default btn-sm btn-show-factura"><i class="icon-circle-down2"></i> detalles</a>
										<div class="ct-factura-datos" style="display:none; margin-top: 10px;">
											<fieldset class="content-group">
												<legend class="text-bold">Factura: </legend>
												<div class="form-group col-md-3">
													<label><i class="icon-barcode2 position-left"></i> Serie:</label>
													<select class="form-control" name="serie_comprobante" id="serie_comprobante" required="">
														<option value="F001">F001</option>
														<option value="F002">F002</option>
													</select>
												</div>
												<div class="form-group col-md-3">
													<label><i class="icon-file-text2 position-left"></i> Número:</label>
													<input type="text" name="numero_comprobante" id="numero_comprobante" class="form-control" readonly="readonly">
												</div>
												<div class="form-group col-md-3">
													<label><i class="icon-calendar2 position-left"></i> Fecha de emisión:</label>
													<input type="text" name="fecha_comprobante" id="fecha_comprobante" value="<?php echo date('Y-m-d'); ?>" placeholder="" class="form-control">
												</div>

												<div class="form-group col-md-3">
													<div class="form-group has-feedback has-feedback-left">
														<label><i class="icon-cash2 position-left"></i>Moneda <span class="text-danger">*</span></label>
														<select title="Selecciona el Tipo de Moneda" data-placeholder="Selecciona Tu Moneda" class="form-control codmoneda_comprobante" name="codmoneda_comprobante" id="codmoneda_comprobante" required>
															<option value='PEN'>Soles</option>
															<option value='USD'>Dólares</option>
														</select>
													</div>
												</div>

												<div class="form-group col-md-3">
													<label><i class="icon-calendar2 position-left"></i> Fecha de vencimiento:</label>
													<input type="date" name="fecha_vencimiento" id="fecha_vencimiento" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" placeholder="" class="form-control">
												</div>

												<div class="content_debito_credito" style="display: none;">
													<div class="form-group col-md-4">
														<div class="form-group has-feedback has-feedback-left">
															<label><i class="icon-file-text position-left"></i> Documento Modificado <span class="text-danger">*</span></label>
															<select title="Documento Modificado" data-placeholder="Selecciona el Documento" class="form-control tipo_comprobante_modificado" name="tipo_comprobante_modificado" id="tipo_comprobante_modificado" required>
																<option value='01'>Factura</option>
																<option value='03'>Boleta</option>
															</select>
														</div>
													</div>

													<div class="form-group col-md-4">
														<label><i class="icon-file-text position-left"></i> N° Doc. Modificado:</label>
														<input type="text" name="num_comprobante_modificado" id="num_comprobante_modificado" placeholder="856887" class="form-control">
													</div>
													<div class="form-group col-md-4 notadebito_motivo" style="display: none;">
														<div class="form-group has-feedback has-feedback-left">
															<label><i class="icon-profile position-left"></i>Motivo <span class="text-danger">*</span></label>
															<select title="Selecciona el Motivo" data-placeholder="Selecciona el Motivo" class="form-control notadebito_motivo_id" name="notadebito_motivo_id" id="notadebito_motivo_id" required>
																<option value="01">INTERES POR MORA</option>
																<option value="02">AUMENTO EN EL VALOR</option>
																<option value="03">PENALIDADES</option>
															</select>
														</div>
													</div>
													<div class="form-group col-md-4 notacredito_motivo" style="display: none;">
														<div class="form-group has-feedback has-feedback-left">
															<label><i class="icon-profile position-left"></i>Motivo <span class="text-danger">*</span></label>
															<select title="Selecciona el Motivo" data-placeholder="Selecciona el Motivo" class="form-control notacredito_motivo_id" name="notacredito_motivo_id" id="notacredito_motivo_id" required>
																<option value="01">ANULACION DE LA OPERACION</option>
																<option value="02">ANULACION POR ERROR EN EL RUC</option>
																<option value="03">CORRECION POR ERROR EN LA DESCRIPCION</option>
																<option value="04">DESCUENTO GLOBAL</option>
																<option value="05">DESCUENTO POR ITEM</option>
																<option value="06">DEVOLUCION TOTAL</option>
																<option value="07">DEVOLUCION POR ITEM</option>
																<option value="08">BONIFICACION</option>
																<option value="09">DISMINUCION EN EL VALOR</option>
															</select>
														</div>
													</div>
												</div>
											</fieldset>
										</div>

										<fieldset class="content-group">
											<legend class="text-bold">Cliente: </legend>
											<div class="col-md-12">
												<div class="form-group col-md-3">
													<div class="form-group has-feedback has-feedback-left">
														<label><i class="icon-user position-left"></i> Tipo de Documento: <span class="text-danger">*</span></label>
														<select title="Selecciona el Tipo de Documento" data-placeholder="Tipo de Documento" class="form-control cliente_tipodocumento" name="cliente_tipodocumento" id="cliente_tipodocumento" required>
															<option value='6'>RUC</option>
														</select>
													</div>
												</div>
												<div class="form-group col-md-4">
													<button type="button" style="float: right; margin-top: 27px; display: none;" class="btn btn-primary btn-icon legitRipple search_document"><i class="icon-search4" id="icon_search_document"></i><i class="icon-spinner10 spinner position-left" style="display: none;" id="icon_searching_document"></i></button>
													<div style="overflow: hidden; padding-right: .5em;">
														<label>
															<i class="icon-pencil position-left"></i>
															<span id="titulo_numerodocumento">N° de RUC</span>: <span class="text-danger">*</span>
															<a class="control-label font-weight-bold text-info" id="abrir_modal_nuevo_cliente"> [+ Nuevo]</a>
														</label>
														<!-- <input type="text" title="Número de RUC" pattern=".{11,11}" name="cliente_numerodocumento" id="cliente_numerodocumento" placeholder="Número de Ruc Aquí!" class="form-control cliente_numerodocumento" required value="<?php echo (isset($numero_documento) ? $numero_documento : ''); ?>"> -->
														<select class="form-control select2 cliente_numerodocumento" name="cliente_numerodocumento" id="cliente_numerodocumento" required data-placeholder="Escriba el nombre o número del documento del cliente">
															<!-- <option value=""></option> -->
															<!-- Llenado dinamico -->
															<!-- <?php #foreach ($clientes->result() as $cliente) { ?>
																	<option value="<?php echo $cliente->id; ?>" data-type="<?php echo $cliente->tipo_documento; ?>"><?php echo $cliente->numero_documento." - ".$cliente->nombre_cliente; ?></option>
															<?php #} ?> -->
														</select>
													</div>
												</div>
												<div class="form-group col-md-5">
													<label><i class="icon-vcard position-left"></i> <span id="titulo_nombrecliente">Razón
															Social</span>: <span class="text-danger">*</span></label>
													<input type="text" title="Ingresa la Razón Social o Nombre" name="cliente_nombre" id="cliente_nombre" placeholder="Razón Social Aquí" class="form-control cliente_nombre" required value="<?php echo (isset($nombre_cliente) ? $nombre_cliente : ''); ?>">
												</div>
											</div>

											<div class="col-md-12" style="display: none;">
												<div class="col-md-6">
													<div class="form-group has-feedback has-feedback-left">
														<label><i class="icon-user position-left"></i> País: <span class="text-danger">*</span></label>
														<select title="Selecciona el País" data-placeholder="País" class="select cliente_pais" name="cliente_pais" id="cliente_pais" required>
															<option value='PE'>Perú</option>
														</select>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group has-feedback has-feedback-left">
														<label><i class="icon-user position-left"></i> Ciudad: <span class="text-danger">*</span></label>
														<select title="Selecciona la Ciudad" data-placeholder="Ciudad" class="select cliente_ciudad" name="cliente_ciudad" id="cliente_ciudad" required>
															<option value='Lima'>Lima</option>
														</select>
													</div>
												</div>
											</div>

											<div class="col-md-12">
												<div class="col-md-4">
													<div class="form-group">
														<label><i class="icon-home2 position-left"></i> Dirección: <span class="text-danger">*</span></label>
														<select name="cliente_direccion" id="cliente_direccion" class="form-control select2">

														</select>
														<!-- <input type="text" title="Ingresa la dirección completa"  name="cliente_direccion" id="cliente_direccion"
														placeholder="Escribe aquí la dirección completa" class="form-control cliente_direccion" required> -->
													</div>
												</div>
												<?php
												/*if (isset($direcciones)) {
													echo '
															<div class="col-md-4">
																<div class="form-group has-feedback has-feedback-left">
																	<label><i class="icon-home2 position-left"></i> Dirección: <span class="text-danger">*</span></label>
																	' . form_dropdown(['name' => 'cliente_direccion', 'id' => 'cliente_direccio', 'class' => 'form-control cliente_direccion', 'required' => 'required'], ['' => '(SELECCIONAR)'] + $direcciones) . '
																</div>
															</div>

														';
												} else {
													echo '
															<div class="col-md-4">
																<div class="form-group has-feedback has-feedback-left">
																	<label><i class="icon-home2 position-left"></i> Dirección: <span class="text-danger">*</span></label>
																	<input type="text" title="Ingresa la dirección completa"  name="cliente_direccion" id="cliente_direccion"
																	placeholder="Escribe aquí la dirección completa" class="form-control cliente_direccion" required value="">
																</div>
															</div>
														';
												}*/
												?>
												<div class="col-md-4">
													<div class="form-group has-feedback has-feedback-left">
														<label><i class="icon-home2 position-left"></i> Tipo de Venta: <span class="text-danger"></span></label>
														<select name="tipo_venta" id="tipo_venta" class="form-control">
															<option value="PRODUCTOS">PRODUCTOS</option>
															<option value="SERVICIOS">SERVICIOS</option>
														</select>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group has-feedback has-feedback-left">
														<label><i class="icon-home2 position-left"></i> Método de pago: <span class="text-danger">*</span></label>
														<select name="metodo_pago" id="metodo_pago" class="form-control">
															<option value="CONTADO">CONTADO</option>
															<option value="CREDITO">CREDITO</option>
															<option value="-">-</option>
															<!-- <option value="IZIPAY">IZIPAY</option> -->
														</select>
													</div>
												</div>

											</div>

											<div class="col-md-12">
												<div class="col-md-4">
													<div class="form-group has-feedback has-feedback-left">
														<label>
															<i class="icon-home2 position-left"></i>
															<span id="LabelID"> Orden de compra:</span><span class="text-danger">*</span>
														</label>
														<input type="text" title="Ingresa la dirección completa" value="<?php echo (isset($correlativo) ? $correlativo : ''); ?>" name="orden_servicio" id="orden_servicio" placeholder="Escribe aquí la orden de servicio" class="form-control " required>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group has-feedback has-feedback-left">
														<label><i class="icon-home2 position-left"></i> Guia de remision: <span class="text-danger"></span></label>
														<!-- <input type="text" title="Ingresa la dirección completa" value="<?php echo (isset($serie_numero_remision) ? $serie_numero_remision : ''); ?>" name="guia_remision" id="guia_remision"
														placeholder="Escribe aquí la gia de remision" class="form-control " required> -->
														<select name="remision_id[]" id="remision_id[]" class="form-control select2" multiple required>
															<option selected value="0">No guia de remision</option>
															<?php
															$option = '';
															if (isset($remision_id_factura)) {
																$option = '<option value="' . $remision_id_factura[0]->id . ','.$remision_id_factura[0]->guia.'" selected>' . $remision_id_factura[0]->guia . '</option>';
															} else {
																foreach ($consulta_guias_disponibles as $dato) {
																	$option .= '<option value="' . $dato->id . ','.$dato->serie . ' - ' . $dato->numero .'">
																			' . $dato->serie . ' - ' . $dato->numero . '</option>';
																}
															}
															echo $option;
															?>
														</select>
													</div>
												</div>
											</div>

										</fieldset>
					</form>
					<fieldset class="content-group">
						<legend class="text-bold">Detalle Documento: </legend>
						<div>
							<div class="col-md-8" style="padding-bottom: 4px;">
								<button type="button" style="margin-right: 10px;" class="btn btn-success btn-labeled btn-xs legitRipple btn_agregarproducto"><b><i class="icon-plus-circle2"></i></b> Agregar producto</button>
								<button type="button" style="margin-right: 10px;" class="btn btn-info btn-labeled btn-xs legitRipple btn_agregarservicio"><b><i class="icon-plus-circle2"></i></b> Agregar servicio</button>
								<label class="alert alert-info" style="text-align: left; ">
									<span>Para borrar un producto de doble click en la fila.</span>
								</label>
								<!-- <form action="#" id="frm_producto_outside" method="get" accept-charset="utf-8">
									<div class="row">
										<div class="form-group col-md-6">
											<label for="producto_codigo">Codigo</label>
											<input type="text" class="form-control" value="" name="producto_codigo" id="producto_codigo2"  required>
										</div>
										<div class="form-group col-md-6">
											<label for="producto_unidadmedida">Und/Medida</label>
											<input type="text" class="form-control" value="" name="producto_unidadmedida" id="producto_unidadmedida2"  required>
										</div>
										<div class="form-group col-md-12">
											<label for="producto_descripcion">Producto</label>
											<input class="form-control valid" type="text" name="producto_descripcion" id="producto_descripcion2" required>
										</div>
										<div class="form-group col-md-12">
											<label for="producto_descripcion">Serie</label>
											<select class="buscar form-control valid" name="producto_serie_id" id="producto_serie_id2" >
												<option value="">-- SELECCIONE --</option>
											</select>
										</div>
										<div class="form-group col-md-6">
											<label for="producto_preciounidad">Precio/Uni(Inc.IGV)</label>
											<input type="text" class="form-control" value="" name="producto_preciounidad" id="producto_preciounidad2" required>
										</div>
										<div class="form-group col-md-6">
											<label for="producto_cantidad">Cantidad</label>
											<input type="text" class="form-control" value="1" name="producto_cantidad" id="producto_cantidad2"  required readonly>
										</div>
										<div class="form-group col-md-4">
											<label for="producto_subtotal">Sub.Total</label>
											<input type="text" class="form-control" value="" name="producto_subtotal" id="producto_subtotal2"  required>
										</div>
										<div class="form-group col-md-4">
											<label for="producto_igv">IGV (18%)</label>
											<input type="text" class="form-control" value="" name="producto_igv" id="producto_igv2"  required>
										</div>
										<div class="form-group col-md-4">
											<label for="producto_total">Total</label>
											<input type="text" class="form-control" value="" name="producto_total" id="producto_total2"  required>
										</div>

										<div class="form-group col-md-12">
											<button type="submit" class="btn btn-success ">Agregar</button>
											<button type="submit" onclick="enviar()" class="btn btn-danger" >Cerrar</button>
										</div>
										<script>
											function enviar(){
												$('#frm_producto_outside').submit();
											}
										</script>
									</div>
								</form> -->
								<div class="table-responsive">
									<div class="jqGrid">
										<table id="detalle_documento" class="scroll">
										</table>
									</div>
								</div>
							</div>

							<div class="col-sm-4">
								<div class="content-group">
									<h6>Resumen:</h6>
									<div class="table-responsive no-border">
										<table class="table">
											<tbody>
												<tr>
													<th>Subtotal:</th>
													<td class="text-right"><span data-moneda_nombre>PEN</span>
														<span id="subtotal_documento">0.0</span>
														<input type="hidden" name="txt_subtotal_comprobante" id="txt_subtotal_comprobante" value="0">
													</td>
												</tr>
												<tr>
													<th>IGV: <span class="text-regular">(18%)</span></th>
													<td class="text-right">
														<span data-moneda_nombre>PEN</span>
														<span id="igv_documento">0.0</span>
														<input type="hidden" name="txt_igv_comprobante" id="txt_igv_comprobante" value="0">
													</td>
												</tr>
												<tr>
													<th>Total:</th>
													<td class="text-right text-primary">
														<h5 class="text-semibold">
															<span data-moneda_nombre>PEN</span>
															<span id="total_documento">0.0</span></h5>
														<input type="hidden" name="txt_total_comprobante" id="txt_total_comprobante" value="0">
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									<input type="hidden" name="txt_total_letras" id="txt_total_letras" value="" />
								</div>
							</div>

						</div>

						<!-- Observaciones del documento NO VISIBLE -->
						<div class="col-sm-12">
							<div class="content-group">
								<h6><i class="icon-notebook position-left"></i> Observación:</h6>
								<div class="mb-15 mt-15">
									<textarea rows="2" cols="5" name="observacion_documento" class="custom-textarea" placeholder="Escribe aquí una observación"></textarea>
								</div>
							</div>
						</div>

						<div class="col-md-12" id="respuesta_proceso">
						</div>

						<div class="col-md-12 text-center" style="margin-top: 25px;">
							<button id="btn_guardar_doc_electronic" type="submit" class="btn btn-primary btn-labeled btn-xs legitRipple">
								<b><i class="icon-floppy-disk"></i></b> Guardar Documento Electrónico
							</button>
						</div>

					</fieldset>
				</div>
			</div>
		</div>
	</div>

	<!-- /Documento Electrónico -->

	</div>
	<!-- /content -->

	</div>
	<!-- /main content -->

	</div>
	<!-- /page content -->

	</div>
	<!-- /page container -->
	<!-- vm_agregar_articulo -->
	<div id="vm_agregar_articulo" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-primary">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h6 class="modal-title">Agregar Artículo</h6>
				</div>
				<div class="modal-body">
					<div class="col-md-12">
						<div class="alert alert-success alert-styled-left alert-arrow-left alert-bordered">
							Elige el producto y escribe la cantidad o el monto final.
						</div>
					</div>
					<form action="#" id="frm_producto" method="get" accept-charset="utf-8">
						<div class="row">
							<div class="form-group col-md-6">
								<label for="producto_codigo">Codigo</label>
								<input type="text" class="form-control" value="" name="producto_codigo" id="producto_codigo" disabled="disabled" required>
							</div>
							<div class="form-group col-md-6">
								<label for="producto_unidadmedida">Und/Medida</label>
								<input type="text" class="form-control" value="" name="producto_unidadmedida" id="producto_unidadmedida" disabled="disabled" required>
							</div>
							<div class="form-group col-md-12">
								<label>Producto</label>
								<select class="buscar form-control valid select2" name="producto_descripcion" id="producto_descripcion" required>
									<option selected disabled>-- SELECCIONE --</option>
									<?php foreach ($prods as $p) { ?>
										<option value="<?= $p->contador ?>">
											<?= $p->nombre . ' - ' . $p->codigo_barra ?>
										</option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group col-md-12" id="descripcionExtra">
								<label for="producto_unidadmedida">Detalle</label>
								<textarea name="producto_descripcionExtra" id="producto_descripcionExtra" class="form-control"></textarea>
								<!-- <input type="text" class="form-control" value="" name="producto_descripcionExtra" id="producto_descripcionExtra"  required> -->
							</div>
							<div class="form-group col-md-6">
								<label for="producto_preciounidad">Precio U.(Inc.IGV)</label>
								<input type="number" class="form-control" step="0.00001" name="producto_preciounidad" id="producto_preciounidad" readonly="true" placeholder="0.00" required>
							</div>
							<div class="form-group col-md-6">
								<label for="producto_cantidad">Cantidad</label>
								<input type="text" class="form-control" value="1" name="producto_cantidad" id="producto_cantidad" readonly="true" required>
							</div>
							<div class="form-group col-md-4">
								<label for="producto_subtotal">Sub.Total</label>
								<input type="text" class="form-control" value="" name="producto_subtotal" id="producto_subtotal" disabled="disabled" required>
							</div>
							<div class="form-group col-md-4">
								<label for="producto_igv">IGV (18%)</label>
								<input type="text" class="form-control" value="" name="producto_igv" id="producto_igv" disabled="disabled" required>
							</div>
							<div class="form-group col-md-4">
								<label for="producto_total">Total</label>
								<input type="text" class="form-control" value="" name="producto_total" id="producto_total" disabled="disabled" required>
							</div>
							<div class="form-group col-md-12">
								<button type="submit" class="btn btn-success ">Agregar</button>
								<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- /primary modal -->

	<div class="modal" id="modal-nuevo-cliente" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Nuevo cliente</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="/" id="form_registrar_cliente">
					<div class="modal-body">
						<div class="row">
							<div class="col-md-6">
									<div class="form-group">
											<label>Tipo Doc. Identidad *</label>
											<select class="form-control tipo_doc_cliente" required>
												<!-- dinamico js -->
											</select>
									</div>
							</div>
							<div class="col-md-6">
								<button type="button" style="float: right; margin-top: 27px;" class="btn btn-primary btn-icon search_ruc_sunat"><i class="icon-search4" id="icon_search_document"></i><i class="icon-spinner10 spinner position-left" style="display: none;" id="icon_searching_document"></i></button>
								<div style="overflow: hidden; padding-right: .5em;">
									<label>Número *</label>
									<input class="form-control num_doc" required>
									<span class="form_error error_numero"></span>
								</div>​
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Nombre *</label>
									<input class="form-control nombre_cliente" required>
									<span class="form_error error_nombre"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Nombre comercial</label>
									<input class="form-control nombre_comercial_cliente" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Dirección</label>
									<input class="form-control direccion_cliente" required>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Teléfono</label>
									<input class="form-control telefono_cliente">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Correo</label>
									<input type="email" class="form-control correo_cliente">
								</div>
							</div>
						</div>
						<div class="row ct-contribuyente" style="display: none;">
							<div class="col-md-6">
								<div class="form-group">
									<label>Estado del contribuyente</label>
									<input class="form-control estado_contribuyente" readonly>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Condición del contribuyente</label>
									<input class="form-control condicion_contribuyente" readonly>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary btn-guardar-cliente">Guardar</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- vm_agregar_servicio -->
	<div id="vm_agregar_servicio" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-primary">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h6 class="modal-title">Agregar Servicio</h6>
				</div>

				<div class="modal-body">
					<div class="col-md-12">
						<div class="alert alert-success alert-styled-left alert-arrow-left alert-bordered">
							Elige el servicio y escribe el precio.
						</div>
					</div>
					<form action="#" id="frm_servicio" method="get" accept-charset="utf-8">
						<div class="row">
							<div class="form-group col-md-6">
								<label for="servicio_unidadmedida">Und/Medida</label>
								<input type="text" class="form-control" value="UND" name="servicio_unidadmedida" id="servicio_unidadmedida" disabled="disabled" required>
							</div>
							<div class="form-group col-md-12">
								<label for="servicio_descripcion">Servicio</label>
								<input type="text" class=" form-control valid" name="servicio_descripcion" id="servicio_descripcion" required>
							</div>
							<div class="form-group col-md-6">
								<label for="servicio_preciounidad">Precio U.(Inc.IGV)</label>
								<input type="text" class="form-control" name="servicio_preciounidad" id="servicio_preciounidad" step="0.00001" placeholder="0.00" required>
							</div>
							<div class="form-group col-md-6">
								<label for="servicio_cantidad">Cantidad</label>
								<input type="text" class="form-control" value="1" name="servicio_cantidad" id="servicio_cantidad" disabled="disabled" readonly>
							</div>
							<div class="form-group col-md-4">
								<label for="servicio_subtotal">Sub.Total</label>
								<input type="text" class="form-control" value="" name="servicio_subtotal" id="servicio_subtotal" disabled="disabled" required>
							</div>
							<div class="form-group col-md-4">
								<label for="servicio_igv">IGV (18%)</label>
								<input type="text" class="form-control" value="" name="servicio_igv" id="servicio_igv" disabled="disabled" required>
							</div>
							<div class="form-group col-md-4">
								<label for="servicio_total">Total</label>
								<input type="text" class="form-control" value="" name="servicio_total" id="servicio_total" disabled="disabled" required>
							</div>

							<div class="form-group col-md-12">
								<button type="submit" class="btn btn-success ">Agregar</button>
								<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- /primary modal -->

</body>
<!-- Core JS files -->

<script type="text/javascript" src="<?= base_url('') ?>plantilla/assets/js/plugins/loaders/pace.min.js"></script>
<script type="text/javascript" src="<?= base_url('') ?>plantilla/assets/js/core/libraries/jquery.min.js"></script>
<script type="text/javascript" src="<?= base_url('') ?>plantilla/assets/js/core/libraries/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= base_url('') ?>plantilla/assets/js/plugins/loaders/blockui.min.js"></script>
<script type="text/javascript" src="<?= base_url('') ?>plantilla/assets/js/plugins/ui/nicescroll.min.js"></script>
<script type="text/javascript" src="<?= base_url('') ?>plantilla/assets/js/plugins/ui/drilldown.js"></script>
<script type="text/javascript" src="<?= base_url('') ?>plantilla/assets/js/plugins/ui/fab.min.js"></script>
<!-- /core JS files -->

<!-- Theme JS files -->
<script type="text/javascript" src="<?= base_url('') ?>plantilla/assets/js/plugins/notifications/bootbox.min.js"></script>
<script type="text/javascript" src="<?= base_url('') ?>plantilla/assets/js/plugins/notifications/sweet_alert.min.js"></script>
<script type="text/javascript" src="<?= base_url('') ?>plantilla/assets/js/plugins/forms/selects/select2.min.js"></script>

<script type="text/javascript" src="<?= base_url('') ?>plantilla/assets/js/core/app.js"></script>

<script type="text/javascript" src="<?= base_url('') ?>plantilla/select2.min.js"></script>
<script type="text/javascript" src="<?= base_url('') ?>plantilla/assets/js/plugins/forms/styling/uniform.min.js"></script>
<script type="text/javascript" src="<?= base_url('') ?>plantilla/assets/js/plugins/forms/validation/validate.min.js"></script>
<script type="text/javascript" src="<?= base_url('') ?>plantilla/assets/js/plugins/forms/inputs/touchspin.min.js"></script>
<!-- /theme JS files -->

<script src="<?= base_url('') ?>plantilla/assets/js/plugins/jqgrid/js/i18n/grid.locale-es.js" type="text/javascript"></script>
<script src="<?= base_url('') ?>plantilla/assets/js/plugins/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>


<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url('') ?>plantilla/assets/js/plugins/jqgrid/css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url('') ?>plantilla/assets/js/plugins/jqgrid/css/custom.css" />

<script>
	let productos = <?php echo (isset($cotizacion_productos) ? $cotizacion_productos : 0); ?>;
</script>
<script type="text/javascript" src="<?= base_url('') ?>plantilla/js/numeros_a_letras.js?v=<?php echo strtotime("now"); ?>"></script>
<script type="text/javascript" src="<?= base_url('') ?>plantilla/js/documentoelectronico_interaccion.js?v=<?php echo strtotime("now"); ?>"></script>

<!-- Sweet Alert 2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- viatmc scripts -->
<script src="<?php echo base_url().'js/viatmc/viatmc.js'; ?>"></script>

<script type="text/javascript">
	let data_clientes = <?php echo json_encode($clientes->result()); ?>;
	const data_all_direcciones = <?php echo json_encode($all_direcciones->result()); ?>;
	// let remisionId = $('#remision_id').val();
	// if (remisionId == '') {
	// 	$('#remision_id').val(null);
	// }
	// if ($('#remision_id').val() === '') {
	// 	$('#remision_id').val(null);
	// }
	// console.log($('#remision_id').val());
	$(function() {
		$('.buscar').select2();
		$('.select2').select2();
		$("#frm_comprobanteelectronico").submit(function(e) {
			e.preventDefault();

			if ($('#remision_id').val() == 0) {
				swal({
						title: "¿Quieres agregar una guía de remisión?",
						text: "No podrás agregarlo después...",
						type: "warning",
						showCancelButton: true,
						cancelButtonText: "No",
						confirmButtonColor: "#DD6B55",
						confirmButtonText: "Sí",
						closeOnConfirm: false
					},
					function(isConfirm) {
						if (!isConfirm) {
							// $('#remision_id').val(NULL);
							procesar_documento_electronico();
						}
						if (isConfirm) {
							swal.close();
						}
					}
				);
			} else {
				procesar_documento_electronico();
			}
		});
		$('#vm_agregar_articulo').on('hidden.bs.modal', function() {
			$('#producto_cantidad').val(0);
			$('#producto_cantidad').attr('readonly', true);
			$('#producto_preciounidad').val(0);
			$('#producto_preciounidad').attr('readonly', true);


		})
		$('#servicio_preciounidad').on('input', function() {
			var igv_percent = parseFloat((18 / 100) + 1);
			var precioarticulo = 0;
			var cantidad = 0;
			if ($('#servicio_preciounidad').val() == '' || $('#servicio_preciounidad').val() <= 0 || isNaN($('#servicio_preciounidad').val())) {
				precioarticulo = 0;
			} else {
				precioarticulo = parseFloat($('#servicio_preciounidad').val());
			}
			if ($('#servicio_cantidad').val() == '' || $('#servicio_cantidad').val() <= 0 || isNaN($('#servicio_cantidad').val())) {
				cantidad = 0;
			} else {
				cantidad = parseFloat($('#servicio_cantidad').val());
			}
			var total = round_math(parseFloat(precioarticulo) * parseFloat(cantidad), 2);
			var subtotal = parseFloat(total) / parseFloat(igv_percent);
			var igv = parseFloat(total) - parseFloat(subtotal);
			$('#servicio_subtotal').val(round_math(subtotal, 2));
			$('#servicio_igv').val(round_math(igv, 2));
			$('#servicio_total').val(round_math(total, 2));
		});

		$('#producto_descripcion').on('change', function() {
			var i = $(this).val();
			if (i != "") {
				//REVISAR BIEN ESTE CAMBIO PORQUE GENERO ERROR
				/*
            var prods = <?php echo json_encode($prods[0]); ?>;
						console.log(prods);
            $("#producto_codigo").val(prods["producto_id"]);
            $("#producto_unidadmedida").val(prods["unidad_medida"]);
			$("#producto_preciounidad").val(prods["precio_venta"]);
			*/
				var prods = <?php echo json_encode($prods) ?>;
				$("#producto_codigo").val(prods[i]["producto_id"]);
				$("#codigo_producto").val(prods[i]["codigo_producto"]);
				$("#producto_unidadmedida").val(prods[i]["unidad_medida"]);
				$("#producto_preciounidad").val(prods[i]["precio_venta"]);
				calcular_totales_producto();
				$('#producto_igv').val(0);
				$('#producto_subtotal').val(0);
				$('#producto_cantidad').val(0);
				$('#producto_total').val(0);
				$('#producto_cantidad').attr('readonly', false);
				$('#producto_preciounidad').attr('readonly', false);
			} else {
				$("#producto_codigo").val("");
				$("#producto_unidadmedida").val("");
				$("#producto_preciounidad").val("");
				$("#producto_subtotal").val("");
				$("#producto_igv").val("");
				$("#producto_total").val("");
			}
		});
	});

	function procesar_documento_electronico() {
		var light = $('#cuerpo_comprobante').parent();
		$(light).block({
			message: '<div class="loader"></div> <p><br />Enviando data, espera un momento!...</p>',
			overlayCSS: {
				backgroundColor: '#fff',
				opacity: 0.8,
				cursor: 'wait'
			},
			css: {
				border: 0,
				padding: 0,
				backgroundColor: 'none'
			}
		});

		var datastring = $("#frm_comprobanteelectronico").serializeArray();
		//console.log(datastring);
		var i = 0;
		var rowData;
		var datadetalle = [];
		var lista_productos = jQuery('#detalle_documento').getDataIDs();
		if (lista_productos.length <= 0) {
			swal({
				title: 'ERROR',
				text: 'Usted debe agregar un producto como mínimo!...',
				html: true,
				type: "error",
				confirmButtonText: "Ok",
				confirmButtonColor: "#2196F3"
			}, function() {
				$(light).unblock();
			});
			return false;
		}
		for (i = 0; i < lista_productos.length; i++) {
			var detalle = {};
			rowData = jQuery('#detalle_documento').getRowData(lista_productos[i]);
			detalle["txtITEM"] = i + 1;
			detalle["txtUNIDAD_MEDIDA_DET"] = rowData.idunidadmedida;
			detalle["txtCANTIDAD_DET"] = rowData.cantidad;
			detalle["txtPRECIO_DET"] = rowData.precio;
			detalle["txtSUB_TOTAL_DET"] = rowData.subtotal;
			detalle["txtPRECIO_TIPO_CODIGO"] = "01";
			detalle["txtIGV"] = rowData.igv;
			detalle["txtPRODUCTOSERIE"] = rowData.productoserieid;
			detalle["txtSERVICIOID"] = '';
			detalle["txtREF"] = rowData.texto_referencial;
			detalle["txtISC"] = "0";
			detalle["txtIMPORTE_DET"] = rowData.subtotal; //rowData.IMPORTE; //SUB_TOTAL + IGV
			detalle["txtCOD_TIPO_OPERACION"] = "10";
			detalle["txtCODIGO_DET"] = rowData.codigo;
			detalle["txtDESCRIPCION_DET"] = rowData.descripcion;
			detalle["txtPRECIO_SIN_IGV_DET"] = round_math(parseFloat(rowData.precio) / parseFloat(1.18), 2);
			detalle["txtTOTAL_DET"] = rowData.igv + rowData.subtotal;
			datadetalle.push(detalle);
		}
		datastring.push({
			name: 'datadetalle',
			value: JSON.stringify(datadetalle)
		});
		datastring.push({
			name: 'motivo_nombre_nota_credito',
			value: $("#notacredito_motivo_id option:selected").text()
		});
		datastring.push({
			name: 'motivo_nombre_nota_debito',
			value: $("#notadebito_motivo_id option:selected").text()
		});
		datastring.push({
			name: 'nombre_doc_modificado',
			value: $("#tipo_comprobante_modificado option:selected").text()
		});
		// console.log($('#remision_id').val());

		datastring.push({
			name: 'guia_remision',
			value: $('#remision_id option:selected').text()
		});

		// console.log(datastring);
		// console.log($('#guia_remision').val());
		//return;
		$.ajax({
			url: '<?= base_url('venta/post') ?>',
			method: 'POST',
			dataType: "json",
			data: datastring,
			error: function(error) {
				console.log(error);
			
			}
		}).then(function(data) {
			console.log(data);
			if (data.respuesta == 'ok') {
				datastring.push({
					name: 'venta_id',
					value: data.venta_id
				});
				console.log(datastring);
				MensajeFactura(datastring, data, {
					mensaje: ''
				});
			} else {
				swal({
					title: 'ERROR',
					text: data.mensaje,
					html: true,
					type: "error",
					confirmButtonText: "Ok",
					confirmButtonColor: "#2196F3"
				}, function() {
					$(light).unblock();
					$("#respuesta_proceso").html('<div class="alert alert-danger alert-styled-left alert-bordered">\
                                        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>\
                                        ' + data.mensaje + '.\
                                    </div>');

				});
			}
			$(light).unblock();
		}, function(reason) {});
	}

	function MensajeFactura(datastring, data, r) {
		var base_url_ticket = data.ruta_pdf;
		var base_url_A4 = "";
		var info_envio = (typeof data.info_envio !== 'undefined') ? data.info_envio : "";
		var xml = (typeof data.link_xml !== 'undefined') ? data.link_xml : "";
		var cdr = (typeof data.link_cdr !== 'undefined') ? data.link_cdr : "";
		var mensaje_envio = "";
		if (info_envio == "") {
			mensaje_envio = "Recuerde enviar su comprobante";
		} else {
			mensaje_envio = '<div class="row"><div class="form-group col-md-12"><a target="_blank" href="' + xml + '" class="btn btn-warning legitRipple"">Descargue su XML</a></div><hr>' +
				'<div class="form-group col-md-12"><a target="_blank" href="' + cdr + '" class="btn btn-warning legitRipple"">Descargue su CDR</a></div></div><hr>';
		}
		if (datastring[0].value == "01") {
			base_url_A4 = <?php echo "'" . base_url("prueba?tipo=facturaA4&id=") . "'" ?>;
		} else {
			if (datastring[0].value == "03") {
				base_url_A4 = <?php echo "'" . base_url("prueba?tipo=boletaA4&id=") . "'" ?>;
			}
		}

		Swal.fire({
			title: 'Se guardó correctamente<hr>',
			html: '<div class="form-group col-md-12" hidden><a  target="_blank" href="' + base_url_ticket + '" class="btn btn-danger legitRipple">Imprimir ticket</a></div><hr>' +
				'<div class="form-group col-md-12"><a target="_blank" href="' + base_url_A4 + data.venta_id + '" class="btn btn-danger legitRipple">Imprimir A4</a><hr></div>' + mensaje_envio +
				'<div class="row"><div class="form-group col-md-6"><input type="text" class="form-control" value="" name="telefono_whatsapp" id="telefono_whatsapp" placeholder="Ingrese celular"></div>' +
				'<div class="form-group col-md-6"><a  onclick="enviarWhatsapp(\'' + data.ruta_pdf + '\')" class="btn btn-success legitRipple">Enviar a Whatsapp</a></div></div><hr>' +
				r.mensaje,
		
			input: 'text',
			type: "success",
			showCancelButton: true,
			focusConfirm: true,
			confirmButtonText: "Crear otro registro",
			confirmButtonColor: "#2196F3",
			cancelButtonText: "Visualizar listado de ventas",
			cancelButtonColor: '#2196F3',
			allowOutsideClick: false
		}).then((result) => {
			if (result.isConfirmed) {


				window.location.reload();
			} else {
				window.history.go(-1);
			}

			$("#btn_guardar_doc_electronic").prop("disabled", true);
			$("#respuesta_proceso").html('<div class="alert alert-success alert-styled-left alert-arrow-left alert-bordered">\
                                        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>\
                                        Su Comprobante electrónico se ha procesado correctamente...<br><br>\
                                        HASH: ' + data.hash_cpe + ' \
                                        <br /><br /> \
                                        <div class="btn-group">\
                                            <a target="_blank" href="' + data.ruta_xml + '" class="btn btn-primary legitRipple" style="display: none;">xml</a>\
                                            <a target="_blank" href="' + data.ruta_cdr + '" class="btn btn-primary legitRipple" style="display: none;">cdr</a>\
                                            <a target="_blank" href="' + data.ruta_pdf + '" class="btn btn-primary legitRipple">pdf</a>\
                                        </div>\
                                    </div>');

			if (datastring[0].value == "01") {
				$("#factura").attr("num", data.numero);
			} else if (datastring[0].value == "03") {
				$("#boleta").attr("num", data.numero);
			} else if (datastring[0].value == "07") {
				$("#notacredito").attr("num", data.numero);
			} else if (datastring[0].value == "08") {
				$("#notadebito").attr("num", data.numero);
			}
			$("#numero_comprobante").val(data.numero);
		});
	}


	function enviarWhatsapp(ruta) {
		var number = $("#telefono_whatsapp").val();
		var whatsappURL = ruta;
		var whatsappURLEncoded = encodeURIComponent(whatsappURL)
		if (number != "") {
			var win = window.open("https://wa.me/+51" + number + "/?text=" + whatsappURLEncoded, '_blank');
		}
	}

	function rellenar_tipo_documento(codigo_sunat, tipo) {
		$("#cliente_tipodocumento").empty();
		$(".content_debito_credito").hide();
		if (codigo_sunat == '01') { //Factura Electrónica
			$('#cliente_tipodocumento').append($("<option></option>")
				.attr("value", '6')
				.text('RUC'));
			$('#cliente_tipodocumento').trigger("change");
			$("#serie_comprobante").html('<option value="F001">F001</option><option value="F002">F002</option>');
			// $(".search_document").show(); // Ya no en factura
			$('#cliente_numerodocumento').attr('pattern', '.{11,11}');
			$('#cliente_numerodocumento').attr('title', 'Número de RUC');
		}
		if (codigo_sunat == '07') { //Nota de Crédito
			$(".content_debito_credito").show();
			$(".notadebito_motivo").hide();
			$(".notacredito_motivo").show();
			$('#cliente_tipodocumento').append($("<option></option>")
				.attr("value", '6')
				.text('RUC'));
			$('#cliente_tipodocumento').trigger("change");
			$("#serie_comprobante").html('<option value="FC01">FC01</option><option value="FC02">FC02</option>');
			$(".search_document").show();
		}
		if (codigo_sunat == '08') { //Nota de Débito
			$(".content_debito_credito").show();
			$(".notadebito_motivo").show();
			$(".notacredito_motivo").hide();
			$('#cliente_tipodocumento').append($("<option></option>")
				.attr("value", '6')
				.text('RUC'));
			$('#cliente_tipodocumento').trigger("change");
			$("#serie_comprobante").html('<option value="FD01">FD01</option><option value="FD02">FD02</option>');
			$(".search_document").show();
		}
		if (codigo_sunat == '03') { //Boleta
			$('#cliente_tipodocumento').append($("<option></option>")
				.attr("value", '1')
				.text('DNI'));
			$('#cliente_tipodocumento').append($("<option></option>")
				.attr("value", '0')
				.text('Doc.Trib.NO.Dom.Sin.RUC'));
			$('#cliente_tipodocumento').append($("<option></option>")
				.attr("value", '4')
				.text('Carné de Extranjería'));
			$('#cliente_tipodocumento').append($("<option></option>")
				.attr("value", '7')
				.text('Pasaporte'));
			$('#cliente_tipodocumento').append($("<option></option>")
				.attr("value", 'A')
				.text('Ced. Diplomática de Identidad'));
			$('#cliente_tipodocumento').trigger("change");
			$('#cliente_numerodocumento').attr('pattern', '.{8,8}');
			$('#cliente_numerodocumento').attr('title', 'Número de DNI');
			$("#serie_comprobante").html('<option value="B001">B001</option><option value="B002">B002</option>');
			// $(".search_document").show(); // Ya no en boleta
		}
		getNumeroComprobante();
	}
	$(document).on('change', '#serie_comprobante', function() {
		getNumeroComprobante();
	});

	function getNumeroComprobante() {
		var tipo = $('input[name="tipo_comprobante"]:checked').data('tipo');
		if (tipo == undefined || tipo == '') {
			alert('Seleccione tipo de comprobante.');
			return false;
		}
		var serie = $('#serie_comprobante').val();
		if (serie == '' || serie.length < 4) {
			alert('Ingrese serie del comprobante');
			$('#serie_comprobante').focus();
			return false;
		}
		$.post('<?= base_url('venta/numero') ?>', {
			tipo: tipo,
			serie: serie
		}, function(res) {
			if (res.success) {
				$("#numero_comprobante").val(res.numero);
			}
		}, 'json');
	}

	$(document).on('change', '#codmoneda_comprobante', function(e) {
		var nombre = $(this).val();
		$('[data-moneda_nombre]').text(nombre);
	});

	$('.btn-show-factura').on('click', function () {
		$(this).find('i').toggleClass('icon-circle-up2').toggleClass('icon-circle-down2');
		$(".ct-factura-datos").toggle();
	});
	$('#factura').on('click', function () {
		$('#factura').parent().attr('class', 'btn btn-primary btn-lg btn-block lbl-factura');
		$('#boleta').parent().attr('class', 'btn btn-default btn-lg btn-block lbl-boleta');
	});
	$('#boleta').on('click', function () {
		$('#boleta').parent().attr('class', 'btn btn-primary btn-lg btn-block lbl-boleta');
		$('#factura').parent().attr('class', 'btn btn-default btn-lg btn-block lbl-factura');
	});
	function detectRucChanges() {
		$('#modal-nuevo-cliente .num_doc').eq(0).val('');
		if ($('#modal-nuevo-cliente select.tipo_doc_cliente').eq(0).val() === "6") {
			$('#modal-nuevo-cliente .num_doc').eq(0).attr('maxlength', 11);
		} else {
			$('#modal-nuevo-cliente .num_doc').eq(0).attr('maxlength', 8);
		}
	}
	function detectTipoComprobante() {
		const tipodoc = $('input[name=tipo_comprobante]:checked').val();
    $('select.tipo_doc_cliente').html('');
    if (tipodoc === "03") {
			$('select.tipo_doc_cliente').append($("<option></option>").attr("value", '1').text('DNI'));
			//$('select.tipo_doc_cliente').append($("<option></option>").attr("value", '6').text('RUC'));
		} else if (tipodoc === "01") {
			$('select.tipo_doc_cliente').append($("<option></option>").attr("value", '6').text('RUC'));
		}
	}
	$('#modal-nuevo-cliente .tipo_doc_cliente').on('change', function() {
    detectRucChanges();
  });
	$('#abrir_modal_nuevo_cliente').on('click', function () {
		detectTipoComprobante();
		detectRucChanges();
		$('#modal-nuevo-cliente').modal('show');
	});

	// completar datos del cliente seleccionado
	$('#cliente_numerodocumento').on('change', function () {
		const id_cliente_seleccionado = $('#cliente_numerodocumento').val();
		const datos_cliente	= data_clientes.find((cli) => cli.numero_documento == id_cliente_seleccionado);
		$('#cliente_nombre').val(datos_cliente.nombre_cliente);

		// Cargar las diferentes direcciones que tiene registrado el cliente
		$('#cliente_direccion').empty();	// limpiar select
		let options								= `<option value="${datos_cliente.direccion_principal}">${datos_cliente.direccion_principal}</option>`; // Dirección princial
		const direcciones_cliente	= data_all_direcciones.filter((item)=> item.numero_documento == id_cliente_seleccionado);
		direcciones_cliente.forEach((item) => {
			options += `<option value="${item.direccion}">${item.tipo_direccion} : ${item.direccion}</option>`; // Direcciones secundarias
		});
		$('#cliente_direccion').append(options);
		//$('#cliente_direccion').val(datos_cliente.direccion_principal);
		//$('#cliente_direccion').val(datos_cliente.departamento+', '+datos_cliente.distrito+', '+datos_cliente.direccion_principal);
	});
	function llenarSelectClientes() {
		$('#cliente_numerodocumento').empty();
		let options = '<option value=""></option>';
		data_clientes.forEach((dc) => {
			options += `
				<option value="${dc.numero_documento}" data-type="${dc.tipo_documento}">${dc.numero_documento+' - '+dc.nombre_cliente}</option>
			`;
		});
		$('#cliente_numerodocumento').append(options);
	}
	llenarSelectClientes();

	$('#form_registrar_cliente').submit(function (e) {
		e.preventDefault();
		const data_form = {
			tipo_documento:				$('.tipo_doc_cliente').val(),
			numero_documento:			$('.num_doc').val(),
			nombre_cliente:				$('.nombre_cliente').val(),
			nombre_cotizacion:		$('.nombre_comercial_cliente').val(),
			direccion_principal:	$('.direccion_cliente').val(),
			telefono_principal: 	$('.telefono_cliente').val(),
			email_principal:			$('.correo_cliente').val()
		}
		msg_confirmation('warning', '¿Está seguro?', 'Registrará un nuevo cliente.')
		.then((res) => {
			if(res) {
				$.ajax({
					type: "post",
					url: "<?= base_url('venta/registrarCliente'); ?>",
					data: {df: data_form},
					dataType: "json",
					success: function (response) {
						time_alert('success', 'Registrado!', 'Cliente registrado correctamente.', 2000)
						.then(() => {
							data_clientes.push(response);
							llenarSelectClientes();
							$('#form_registrar_cliente')[0].reset();
							$('#modal-nuevo-cliente').modal('hide');
						})
					}
				});
			}
		})
	});
	// para cargar numero desde el inicio
	rellenar_tipo_documento('01', 'factura');

	$(".search_ruc_sunat").on('click', function() {
		var tipo_doc = $(".tipo_doc_cliente").val();
		switch (tipo_doc) {
			case "6": // RUC
				// Obtener numero de documento del cliente
				var num_doc = $(".num_doc").val();
				// Petición ajax para obtener los datos del cliente
				$.ajax({
					url: "<?php echo base_url('venta/consulta_sunat'); ?>",
					type: 'POST',
					data: {num_doc: num_doc, isDni: false},
					error: function() {
						alert('ha ocurrido un error al buscar la información del cliente en SUNAT');
					},
					success: function(data) {
						//console.log(data)
						if (data) {
							const nombre									= data.data.nombre_o_razon_social;
							const direccion								= data.data.direccion_completa;
							const estado_contribuyente		= data.data.estado;
							const condicion_contribuyente	= data.data.condicion;

							$(".nombre_cliente").val(nombre);
							$(".nombre_comercial_cliente").val(nombre);
							$(".direccion_cliente").val(direccion);
							$(".estado_contribuyente").val(estado_contribuyente);
							$(".condicion_contribuyente").val(condicion_contribuyente);

							$(".ct-contribuyente").show();
						}
					}
				});
				break;
			case "1":
				// Obtener numero de documento del cliente
				var num_doc = $(".num_doc").val();

				var url = "https://consulta.api-peru.com/api/dni/" + num_doc;

				// Petición ajax para obtener los datos del cliente
				$.ajax({
					url: "<?php echo base_url('venta/consulta_sunat'); ?>",
					type: 'POST',
					data: {num_doc: num_doc, isDni: true},
					error: function() {
						alert('ha ocurrido un error al buscar la información del cliente en SUNAT');
					},
					success: function(data) {
						if (data) {
							var nombres = data.data.nombres;
							var primer_apellido = data.data.apellido_paterno;
							var segundo_apellido = data.data.apellido_materno;
							var nombre_completo = nombres + " " + primer_apellido + " " + segundo_apellido;

							$(".nombre_cliente").val(nombre_completo);
							$(".direccion_cliente").val("--");
							$(".nombre_comercial_cliente").val(nombre_completo);
						}
					}
				});
				break;
			default:
		}
	});
	$(document).ready(function () {
		// Botón REGISTRAR DOCUMENTO ELECTRONICO -> OCULTO
		$('#btn_guardar_doc_electronic').hide();
	});
</script>
</html>