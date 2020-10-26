<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<div class="page-wrapper" style="background-color: #D2E0F0;">
	<!-- ============================================================== -->
	<!-- Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	<div class="page-breadcrumb">
		<div class="row align-items-center">
			<div class="col-5">
				<h4 class="page-title">Gestión</h4>
				<div class="d-flex align-items-center">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#">Gestión</a></li>
							<li class="breadcrumb-item active" aria-current="page">Meta Trimestral / Anual</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			<!-- column -->
			<div class="col-6">
				<div class="col-7">
					<div class="text-right upgrade-btn">
						<button type="button" class="btn btn-danger text-white" data-target="#meta_trimestre" data-toggle="modal">Registrar metas trimestrales</button>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<!-- title -->
						<div class="d-md-flex align-items-center">
							<div>
								<h4 class="card-title">Meta Trimestral <?php echo date('Y'); ?></h4>
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
					<div class="card-body">
						<div class="row">
							<div id="columnchart_material" style="width: 800px; height: 500px;"></div>
						</div>
					</div>
				</div>
			</div>
			<!-- column -->
			<div class="col-6">
				<div class="col-7">
					<div class="text-right upgrade-btn">
						<button type="button" class="btn btn-danger text-white" data-target="#meta_anual" data-toggle="modal">Registrar metas anual</button>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<!-- title -->
						<div class="d-md-flex align-items-center">
							<div>
								<h4 class="card-title">Meta Anual <?php echo date('Y'); ?></h4>
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
					<div class="card-body">
						<div class="row">
							<div class="col-sm-12">
								<div id="columnchart_values"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="meta_trimestre" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title-trimestre">Metas trimestrales <?php echo date('Y'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php echo form_open((sizeof($existe_meta_trimestral) > 0 ? 'gestion/editar_meta_trimestral' : 'gestion/agregar_meta_trimestral')); ?>
				<div class="modal-body">
					<div class="row">
						<div class="form-group col-sm-4">
							<label>Ene-Mar</label>
							<input type="text" name="trimestre[]" class="form-control" placeholder="Meta" required="required" value="<?php echo (sizeof($existe_meta_trimestral) > 0 ? $existe_meta_trimestral[0]->meta : '') ?>">
							<input type="hidden" name="i[]" value="<?php echo (sizeof($existe_meta_trimestral) > 0 ? $existe_meta_trimestral[0]->id : '') ?>">
						</div>
						<div class="form-group col-sm-4">
							<label>Abr-Jun</label>
							<input type="text" name="trimestre[]" class="form-control" placeholder="Meta" required="required" value="<?php echo (sizeof($existe_meta_trimestral) > 0 ? $existe_meta_trimestral[1]->meta : '') ?>">
							<input type="hidden" name="i[]" value="<?php echo (sizeof($existe_meta_trimestral) > 0 ? $existe_meta_trimestral[1]->id : '') ?>">
						</div>
						<div class="form-group col-sm-4">
							<label>Jul-Sep</label>
							<input type="text" name="trimestre[]" class="form-control" placeholder="Meta" required="required" value="<?php echo (sizeof($existe_meta_trimestral) > 0 ? $existe_meta_trimestral[2]->meta : '') ?>">
							<input type="hidden" name="i[]" value="<?php echo (sizeof($existe_meta_trimestral) > 0 ? $existe_meta_trimestral[2]->id : '') ?>">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-4">
							<label>Oct-Dic</label>
							<input type="text" name="trimestre[]" class="form-control" placeholder="Meta" required="required" value="<?php echo (sizeof($existe_meta_trimestral) > 0 ? $existe_meta_trimestral[3]->meta : '') ?>">
							<input type="hidden" name="i[]" value="<?php echo (sizeof($existe_meta_trimestral) > 0 ? $existe_meta_trimestral[3]->id : '') ?>">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="Submit" class="btn btn-primary">Guardar</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="meta_anual" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title-anual">Meta anual <?php echo date('Y'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php echo form_open((sizeof($existe_meta_anual) > 0 ? 'gestion/editar_meta_anual' : 'gestion/agregar_meta_anual')); ?>
				<div class="modal-body">
					<div class="row">
						<div class="form-group col-sm-4">
							<label>Año</label>
							<input type="text" name="meta_anio" class="form-control" placeholder="Meta" required="required" value="<?php echo (sizeof($existe_meta_anual) > 0 ? $existe_meta_anual[0]->meta : '') ?>">
							<input type="hidden" name="i" value="<?php echo (sizeof($existe_meta_anual) > 0 ? $existe_meta_anual[0]->id : '') ?>">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="Submit" class="btn btn-primary">Guardar</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<script type="text/javascript">
	let grafica = <?php echo $grafica_trimestral; ?>;
	let grafica2 = <?php echo $grafica_anual; ?>;
</script>
