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
							<li class="breadcrumb-item active" aria-current="page">Lista de Cotizaciones</li>
						</ol>
					</nav>
				</div>
			</div>
			<div class="col-7">
				<div class="text-right upgrade-btn">
					<a href="<?= base_url('cotizacion/createservicio') ?>" class="btn btn-danger text-white">Registrar Cotizacion</a>
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
								<h4 class="card-title">Lista de Cotizaciones</h4>
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
					<div class="table-responsive">
						<table class="table v-middle">
							<thead>
								<tr class="bg-light">
									<!--<th class="border-top-0">Serie</th>-->
									<th class="border-top-0">Numero</th>
									<th class="border-top-0">Fecha</th>
									<th class="border-top-0">Monto total</th>
									<th class="border-top-0">Estado</th>
									<th class="border-top-0">Detalle</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($cots->result() as $c){
								if($c->estado == 1) {
							?>
								<tr>
									<!--<td>
										<h5 class="m-b-0"><?= $c->serie ?></h5>
									</td>-->
									<td>
										<h5 class="m-b-0"><?= $c->id ?></h5>
									</td>
									<td><?= $c->created_at ?></td>
									<td>
										<h5 class="m-b-0">S/<?= $c->montototal ?></h5>
									</td>
									<td>
										<label class="label label-info"><?php if($c->estado){echo("Habilitado");}else{echo("Inhabilitado");} ?></label>
									</td>
									
									<td >
										<?php $tipo=""; ?>
											<a target="_blank" href="<?= base_url('prueba?tipo=cotizacionServA4&idcotizacion='.$c->id) ?>" >
											<i class="ti-pencil-alt"></i> A4
										</a>
										
										
										<!-- - <a href="<?= base_url('cotizacion/edit/'.$c->id) ?>">
											<i class="ti-pencil"></i> Editar
										</a> -->
										- <a href="<?= base_url('cotizacion/deleteServicio/'.$c->id) ?>" >
											<i class="ti-trash"></i> Eliminar
										</a>
									</td>
								</tr>
							<?php 
							}	}
							?>
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
