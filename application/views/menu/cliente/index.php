<!-- viatmc styles -->
<link rel="stylesheet" href="<?php echo base_url() . 'css/viatmc/viatmc.css'; ?>">

<div class="page-wrapper" style="background-color: #D2E0F0;">
	<!-- ============================================================== -->
	<!-- Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	<div class="page-breadcrumb">
		<div class="row align-items-center">
			<div class="col-5">
				<h4 class="page-title">Clientes</h4>
				<div class="d-flex align-items-center">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#">Clientes</a></li>
							<li class="breadcrumb-item active" aria-current="page">Lista de clientes</li>
						</ol>
					</nav>
				</div>
			</div>
			<div class="col-7">
				<div class="text-right upgrade-btn">
					<a href="<?= base_url('cliente/registro') ?>" class="btn btn-info text-white"><i class="fas fa-plus"></i> Registrar cliente</a>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			<!-- column -->
			<div class="col-12">
				<div class="card">
					<div class="card-body bg-info">
						<!-- title -->
						<div class="d-md-flex align-items-center">
							<div>
								<h4 class="card-title text-white">Lista de clientes</h4>
								<h5 class="card-subtitle" hidden>Overview of Top Selling Items</h5>
							</div>
						</div>
						<!-- title -->
					</div>
					<div class="col-md-12 mt-2">
						<div class="table-responsive">
							<table class="table table-bordered" id="tabla_lista_clientes">
								<thead>
									<tr class="bg-light">
										<th>#</th>
										<th>Nro. Documento</th>
										<th>Nombre</th>
										<th>Segmento</th>
		
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if (sizeof($clientes) > 0) : ?>
										<?php $count = 0; ?>
										<?php foreach ($clientes as $cliente) : ?>
											<tr>
												<td><?= ++$count ?></td>
												<td><?= $cliente->numero_documento ?></td>
												<td><?= $cliente->nombre_cliente ?></td>
												<td><?= $this->constantes->SEGMENTOS[$cliente->segmento] ?></td>
												
												<td>
													<a href="#" cliente_id="<?= $cliente->id ?>" class="ver-direccionescliente">
														<i class="ti-menu"></i> Ver Direcciones
													</a>
													<br>
													<a href="<?= base_url('cliente/detalles/' . $cliente->id) ?>" class="btn btn-warning btn-xs"><i class="fas fa-edit"></i> Editar</a></td>
											</tr>
										<?php endforeach; ?>
									<?php else : ?>
										<tr>
											<td colspan="5">No hay ningún dato para mostrar</td>
										</tr>
									<?php endif; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="vm_ver_direccionescliente" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h6 class="modal-title" style="color:white">Direcciones del cliente</h6>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<div class="modal-body">

				<table class="table v-middle" id="body_tbl_direccion_cliente">
					<thead>
						<tr class="bg-light">
							<th class="border-top-0">Tipo Direccion</th>
							<th class="border-top-0">Direccion</th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>

		</div>
	</div>
</div>
<!-- jquery -->
<script src="https://code.jquery.com/jquery-3.5.0.min.js" charset="utf-8"></script>
<!-- Sweet Alert 2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- viatmc scripts -->
<script src="<?php echo base_url() . 'js/viatmc/viatmc.js'; ?>"></script>

<script>
	$(document).ready(function() {
		$('#tabla_lista_clientes').DataTable({
			"destroy": true,
			"iDisplayLength": 10,
			"bAutoWidth": false,
			"language": {
				"url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
			},
			"deferRender": true,
			"bProcessing": true,
			"scrollX": true
		});
	});
	
</script>