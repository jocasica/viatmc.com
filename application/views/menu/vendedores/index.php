<!-- viatmc styles -->
<link rel="stylesheet" href="<?php echo base_url().'css/viatmc/viatmc.css'; ?>">

<div class="page-wrapper" style="background-color: #D2E0F0;">
	<!-- ============================================================== -->
	<!-- Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	<div class="page-breadcrumb">
		<div class="row align-items-center">
			<div class="col-5">
				<h4 class="page-title">Vendedores</h4>
				<div class="d-flex align-items-center">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#">Vendedores</a></li>
							<li class="breadcrumb-item active" aria-current="page">Lista de vendedores</li>
						</ol>
					</nav>
				</div>
			</div>
			<div class="col-7">
				<div class="text-right upgrade-btn">
					<button type="button" class="btn btn-info text-white" data-target="#agregar_vendedor" data-toggle="modal"><i class="fas fa-plus"></i> Registrar vendedor</button>
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
								<h4 class="card-title text-white">Lista de vendedores</h4>
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
							<table class="table table-bordered" id="tabla_lista_vendedores">
								<thead>
									<tr>
										<th>Nro.</th>
										<th>Nombre</th>
										<th>Correo electrónico</th>
										<th>Número</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(sizeof($vendedores) > 0): ?>
										<?php $count = 0; ?>
										<?php foreach ($vendedores as $vendedor): ?>
											<tr>
												<td><?= ++$count ?></td>
												<td><?= $vendedor->nombre_vendedor ?></td>
												<td><?= $vendedor->email ?></td>
												<td><?= $vendedor->telefono ?></td>
												<td>
													<button type="button" data-target="#editar_vendedor" data-toggle="modal" class="btn btn-warning btn-xs" onclick="editar('<?= $vendedor->id ?>', '<?= $vendedor->nombre_vendedor ?>', '<?= $vendedor->email ?>', '<?= $vendedor->telefono ?>');">
														<i class="fas fa-edit"></i> Editar
													</button>
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

<!-- Modal Registrar Vendedor -->
<div class="modal fade" id="agregar_vendedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="titulo">Nuevo vendedor</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php echo form_open('vendedor/agregar'); ?>
				<div class="modal-body">
					<h6 class="card-subtitle">Los campos marcados con (<span class="text-danger">*</span>) son obligatorios</h6>
					<br>
					<div class="row">
						<div class="form-group col-sm-6">
							<label>Nombre <span class="text-danger">*</span></label>
							<input type="text" class="form-control" placeholder="Nombre" name="nombre" required>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-4">
							<label>Teléfono <span class="text-danger">*</span></label>
							<input type="text" class="form-control" placeholder="Teléfono" name="telefono" required>
						</div>
						<div class="form-group col-sm-4">
							<label>Correo electrónico <span class="text-danger">*</span></label>
							<input type="email" class="form-control" placeholder="ejemplo@mail.com" name="email" required>
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

<!-- Modal Editar Vendedor-->
<div class="modal fade" id="editar_vendedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="titulo-vendedor"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php echo form_open('vendedor/editar'); ?>
				<div class="modal-body">
					<h6 class="card-subtitle">Los campos marcados con (<span class="text-danger">*</span>) son obligatorios</h6>
					<br>
					<div class="row">
						<div class="form-group col-sm-6">
							<label>Nombre <span class="text-danger">*</span></label>
							<input type="text" class="form-control" placeholder="Nombre" name="nombre" required id="nombre">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-4">
							<label>Teléfono <span class="text-danger">*</span></label>
							<input type="text" class="form-control" placeholder="Teléfono" name="telefono" required id="tel">
						</div>
						<div class="form-group col-sm-4">
							<label>Correo electrónico <span class="text-danger">*</span></label>
							<input type="email" class="form-control" placeholder="ejemplo@mail.com" name="email" required id="email">
						</div>
					</div>
				</div>
				<input type="hidden" name="id" id="idv">
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Actualizar</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<script>
	const editar = (id, nombre, email, tel) => {
		document.getElementById('nombre').value = nombre;
		document.getElementById('email').value = email;
		document.getElementById('tel').value = tel;
		document.getElementById('titulo-vendedor').innerHTML = 'Vendedor: '+nombre;
		document.getElementById('idv').value = id;
	};
</script>