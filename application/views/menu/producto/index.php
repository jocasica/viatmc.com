<!-- viatmc styles -->
<link rel="stylesheet" href="<?php echo base_url().'css/viatmc/viatmc.css'; ?>">

<div class="page-wrapper" style="background-color:#BED7EE;">
	<!-- ============================================================== -->
	<!-- Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	<div class="page-breadcrumb">
		<div class="row align-items-center">
			<div class="col-5">
				<h4 class="page-title">Productos</h4>
				<div class="d-flex align-items-center">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#">Productos</a></li>
							<li class="breadcrumb-item active" aria-current="page">Lista de productos</li>
						</ol>
					</nav>
				</div>
			</div>
			<div class="col-7">
				<div class="text-right upgrade-btn">
					<a href="<?= base_url('producto/create') ?>" class="btn btn-danger text-white">Registrar nuevo producto</a>
					<a href="<?= base_url('producto/series_de_producto') ?>" class="btn btn-info text-white">Ver series</a>
					<button type="button" class="btn btn-success text-white" data-target="#importar" data-toggle="modal"><i class="fas fa-plus"></i> Importar</button>
				</div>
			</div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row">
			<!-- column -->
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<!-- title -->
						<div class="d-md-flex align-items-center">
							<div>
								<h4 class="card-title">Lista de Productos</h4>
								<h5 class="card-subtitle" hidden>Overview of Top Selling Items</h5>
							</div>
							<div class="ml-auto">
								<div class="dl">
									<h4 class="m-b-0 font-16">Moneda: SOLES (S/)</h4>
								</div>
							</div>
						</div>
						<!-- title -->
						<div class="table-responsive table-sm">
							<div id="buttonsTableContainer">
							</div>
							<table class="table table-responsive mb-0  mr-20" cellspacing="0" width="100%" id="tabla_productos">
								<thead>
									<tr>
										<th>Nro.</th>
										<th>Codigo referencia</th>
										<th>Producto</ths=>
										<th>Marca</th>
										<th>Modelo</th>
										<th>Stock</thclass=>
										<th>Nro Seccion (caja)</ths=>
										<th>Lote</thass=>
										<th>PV particular</th>
										<th>PV institucional</th>
										<th>PC local</th>
										<th>PC extranjero</th>
										<th>Producto</th>
										<th width="5%">Opciones</th>
										<th width="5%"></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($data_productos as $i => $p): ?>
										<?php
											$defaultImage	= $p->image ? base_url('/images/placeholder.png') : base_url('/images/no-placeholder.png');
											$p->image			= $p->image ? $p->image : '/images/no-placeholder.png';
										?>
										<tr>
											<td><?= ($i + 1)?></td>
											<td><?= $p->codigo_referencia?></td>
											<td><?= $p->nombre?></td>
											<td><?= substr($p->marca,0,20)?></td>
											<td><?= $p->modelo?></td>
											<td><?= $p->stock?></td>
											<td><?= $p->nro_seccion?></td>
											<td><?= $p->lote?></td>
											<td><?= $p->precio_venta?></td>
											<td><?= $p->precio_institucional?></td>
											<td><?= $p->precio_compra?></td>
											<td><?= $p->precio_compra_extranjero?></td>
											<td>
												<?php if($p->tipo_registro_producto == 1): ?>
													<label class="label label-success">Con Series</label>
												<?php elseif ($p->tipo_registro_producto == 2): ?>
													<label class="label label-primary">Con Código de Lote</label>
												<?php elseif ($p->tipo_registro_producto == 3): ?>
													<label class="label label-info">Con Series y Código de Lote</label>
												<?php elseif ($p->tipo_registro_producto == 4): ?>
													<label class="label label-danger">Sin Series y Sin Código de Lote</label>
												<?php endif; ?>
											</td>
											<td>
												<a class="btn btn-warning btn-xs" href="<?= base_url('producto/edit/'.$p->id); ?>"><i class="ti-pencil"></i> Editar</a>
											</td>
											<td>
												<span data-image="<?= base_url($p->image); ?>" data-name="<?= $p->nombre; ?>" onclick="mostrarModalImagen(this)">
													<img src="<?= base_url($p->image); ?>" width="48">
												</span>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="mostrarImagen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xs">
		<div class="modal-content">
			<div class="modal-header" style="background: #414755; color: white">
				<h5 class="modal-title" id="exampleModalScrollableTitle">Imagen de: ( <span id="titleProductName">asd</span> )</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white">
					<span aria-hidden="true">&times;</span>
					<input type="hidden" id="pid">
				</button>
			</div>
			<div style="width: 100%; text-align: center; padding: 20px; margin-bottom: 20px">
				<img src="<?= base_url('images/no-placeholder.png'); ?>" id="imagenModalProducto" width="80%">
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="serie-producto" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalScrollableTitle">Series</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<input type="hidden" id="pid">
				</button>
			</div>
			<div class="modal-body">
				<div clas="table-responsive">
					<button class="btn-info" data-target="#agregar-serie" data-toggle="modal" type="button" onclick="eliminar_rows();"><i class="fas fa-plus"></i> Agregar serie</button>
					<table class="table v-middle" width="100%">
						<thead>
							<tr>
								<th>#</th>
								<th>Serie</th>
								<th>Estado</th>
							</tr>
						</thead>
						<tbody id="series-table">
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="agregar-serie" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title">Agregar serie</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php echo form_open('', ['id' => 'serie-form']); ?>
			<div class="modal-body">
				<div class="row">
					<div class="form-group col-sm-4">
						<button id="btnAdd" type="button" class="btn btn-secondary" data-toggle="tooltip" data-original-title="Add more controls"><i class="fas fa-plus"></i> Agregar</button></th>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-12">
						<label class="col-md-12">Serie</label>
						<input type="text" name="serie[]" value="" class="form-control form-control-line" maxlength="300" required>
					</div>
					<div id="serie">

					</div>
				</div>
			</div>
			<input type="hidden" name="producto_id" id="idp">
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Agregar</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="importar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xs" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="titulo">Importar Productos</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php echo form_open('producto/importar', ['id' => 'form_importar']); ?>
			<div class="modal-body">
				<div class="row">
					<div class="form-group col-sm-12">
						<label>Archivo <font color="red">*</font></label>
						<input type="file" class="form-control" placeholder="archivo" name="archivo" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				<button type="submit" class="btn btn-primary">Procesar</button>
			</div>
			<?php echo form_close(); ?>
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
	$(function() {
		$(document).on('submit', '#serie-form', function(event) {
			event.preventDefault();
			$.ajax({
				url: 'agregar_serie',
				method: 'POST',
				data: new FormData(this),
				contentType: false,
				processData: false,
				success: function(data) {
					series(data);
					$('#agregar-serie').modal('hide');
					document.getElementById("serie-form").reset();
				}
			});
		});

		$(document).on('submit', '#form_importar', function(event) {
			event.preventDefault();
			$.ajax({
				url: 'importar',
				method: 'POST',
				data: new FormData(this),
				contentType: false,
				processData: false,
				dataType: "json",
				success: function(data) {
					alert(data.msg);
					if (data.status) {
						if (data.redirect) {
							$(location).attr("href", data.redirect);
						}
					}
				}
			});
		});

		$("#btnAdd").bind("click", function() {
			var div = $("<div />");
			div.html(GetDynamicTextBox());
			$("#serie").append(div);
		});

		$("body").on("click", ".remove", function() {
			$(this).closest("div").remove();
		});
	});

	function GetDynamicTextBox() {
		return `
			<div class="form-group col-sm-12">
				<label class="col-md-12">Serie <a type="button"><i class="fas fa-trash text-danger remove"></i></a></label>
				<input type="text" name="serie[]" value="" class="form-control form-control-line" maxlength="300" required>
			</div>
		`;
	}

	const series = (id) => {
		document.getElementById('idp').value = id;
		let html = '';
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				let series = JSON.parse(xhttp.responseText);
				if (parseInt(series.length) == 0) {
					html = `
						<tr align="center">
							<td colspan="3">Este producto no cuenta con series</td>
						</tr>
					`;
				} //end if
				else {
					let count = 0;
					for (let i = 0; i < series.length; i++) {
						html += `
							<tr>
								<td>${++count}</td>
								<td>${series[i].serie}</td>
								<td>${(parseInt(series[i].estado) == 1 ? 'Disponible' : 'Vendido')}</td>
							</tr>
						`;
					} //end for
				} //end else
				document.getElementById('series-table').innerHTML = html;
			} //end if
		};
		xhttp.open("GET", "obtener_series/" + id, true);
		xhttp.send();
	};

	const eliminar_rows = () => {
		document.getElementById('serie').innerHTML = '';
	};

	var spanishTableInfo = {
		"sProcessing": "Procesando...",
		"sLengthMenu": "Mostrar _MENU_ registros",
		"sZeroRecords": "No se encontraron resultados",
		"sEmptyTable": "Ningún dato disponible en esta tabla",
		"sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
		"sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
		"sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
		"sInfoPostFix": "",
		"sSearch": "Buscar:",
		"sUrl": "",
		"sInfoThousands": ",",
		"sLoadingRecords": "Cargando...",
		"oPaginate": {
			"sFirst": "Primero",
			"sLast": "Último",
			"sNext": "Siguiente",
			"sPrevious": "Anterior"
		},
		"oAria": {
			"sSortAscending": ": Activar para ordenar la columna de manera ascendente",
			"sSortDescending": ": Activar para ordenar la columna de manera descendente"
		},
		"buttons": {
			"copy": "Copiar",
			"colvis": "Visibilidad"
		}
  };

	$(document).ready(function () {
		var labelProductos = 'Listado de productos';
		var productosTable = $('#tabla_productos').DataTable({
			buttons: [
				{
					extend: 'excelHtml5',
					titleAttr: labelProductos,
					title: labelProductos,
					sheetName: labelProductos,
				},
				{
					extend: 'pdfHtml5',
					titleAttr: labelProductos,
					title: labelProductos,
					orientation: 'landscape',
					pageSize: 'LEGAL'
				}
			],
			language: spanishTableInfo
		});

		productosTable.buttons().container().appendTo('#buttonsTableContainer').css({
			'text-align': 'right',
			'padding': '10px 0',
			'display': 'flex'
		}).find('button').addClass('btn btn-default').attr('style', "width:70px; text-align: center !important; margin-right: 10px").removeClass('dt-button');

	});
</script>