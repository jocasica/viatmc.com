<!-- viatmc styles -->
<link rel="stylesheet" href="<?php echo base_url().'css/viatmc/viatmc.css'; ?>">

<div class="page-wrapper" style="background-color: #D2E0F0;">
	<!-- ============================================================== -->
	<!-- Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	<div class="page-breadcrumb">
		<div class="row align-items-center">
			<div class="col-5">
				<h4 class="page-title">Proveedores</h4>
				<div class="d-flex align-items-center">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#">Proveedores</a></li>
							<li class="breadcrumb-item active" aria-current="page">Lista de proveedores</li>
						</ol>
					</nav>
				</div>
			</div>
			<div class="col-7">
				<div class="text-right upgrade-btn">
					<button type="button" class="btn btn-info text-white" data-target="#nuevo_proveedor" data-toggle="modal"><i class="fas fa-plus"></i> Registrar proveedor</button>
					<a href="<?php echo base_url('proveedor/pago_proveedor') ?>" class="btn btn-dark text-white"><i class=""></i> Pago a proveedor</a>
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
								<h4 class="card-title text-white">Lista de proveedores</h4>
								<h5 class="card-subtitle" hidden >Overview of Top Selling Items</h5>
							</div>
							<div class="ml-auto" >
								<div class="dl">
									<h4 class="m-b-0 font-16"></h4>
								</div>
							</div>
						</div>
						<!-- title -->
					</div>
					<div class="col-md-12 mt-2">
						<div class="table-responsive">
							<table class="table table-bordered" id="tabla_lista_proveedores">
								<thead>
									<tr>
										<th>Nro.</th>
										<th>RUC</th>
										<th>Nombre</th>
										<th>Teléfono</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(sizeof($proveedores) > 0): ?>
										<?php foreach ($proveedores as $count => $proveedor): ?>
											<tr>
												<td><?= ($count+1) ?></td>
												<td><?= $proveedor->ruc ?></td>
												<td><?= $proveedor->nombre_proveedor ?></td>
												<td><?= $proveedor->telefono ?></td>
												<td>
													<a href="#" class="btn btn-warning btn-xs" data-target="#editar" data-toggle="modal" onclick="editar('<?= $proveedor->id ?>', '<?= $proveedor->ruc ?>', '<?= $proveedor->nombre_proveedor ?>', '<?= $proveedor->telefono ?>');">
														<i class="fas fa-edit"></i> Editar
													</a>
												</td>
											</tr>
										<?php endforeach; ?>
									<?php else: ?>
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


<!-- Modal -->
<div class="modal fade" id="nuevo_proveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="titulo-proveedor">Nuevo proveedor</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php echo form_open('proveedor/agregar'); ?>
				<div class="modal-body">
					<h6 class="card-subtitle">Los campos marcados con (<span class="text-danger">*</span>) son obligatorios</h6>
					<br>
					<div class="row">
						<div class="form-group col-sm-4">
							<label>RUC <span class="text-danger">*</span></label>
							<input type="text" name="ruc" required class="form-control" placeholder="###########">
						</div>
						<div class="form-group col-sm-4">
							<label>Nombre <span class="text-danger">*</span></label>
							<input type="text" name="nombre_proveedor" required class="form-control" placeholder="Nombre proveedor">
						</div>
						<div class="form-group col-sm-4">
							<label>Teléfono <span class="text-danger">*</span></label>
							<input type="text" name="telefono" required class="form-control" placeholder="Teléfono">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Guardar</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="titulo-editar"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php echo form_open('proveedor/editar'); ?>
				<div class="modal-body">
					<h6 class="card-subtitle">Los campos marcados con (<span class="text-danger">*</span>) son obligatorios</h6>
					<br>
					<div class="row">
						<div class="form-group col-sm-4">
							<label>RUC <span class="text-danger">*</span></label>
							<input type="text" name="ruc" required class="form-control" placeholder="###########" id="ruc">
						</div>
						<div class="form-group col-sm-4">
							<label>Nombre <span class="text-danger">*</span></label>
							<input type="text" name="nombre_proveedor" required class="form-control" placeholder="Nombre proveedor" id="nombre">
						</div>
						<div class="form-group col-sm-4">
							<label>Teléfono <span class="text-danger">*</span></label>
							<input type="text" name="telefono" required class="form-control" placeholder="Teléfono" id="tel">
						</div>
					</div>
				</div>
				<input type="hidden" name="id" id="idp">
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Guardar</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<script>
	const editar = (id, ruc, nombre, tel) => {
		document.getElementById('ruc').value = ruc;
		document.getElementById('nombre').value = nombre;
		document.getElementById('tel').value = tel;
		document.getElementById('idp').value = id;
		document.getElementById('titulo-editar').innerHTML = 'Proveedor: '+nombre;
	};
</script>