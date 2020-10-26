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
							<li class="breadcrumb-item active" aria-current="page">Cotizaciones</li>
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
				<div class="card">
					<div class="card-body">
						<!-- title -->
						<div class="d-md-flex align-items-center">
							<div>
								<h4 class="card-title">Cotizaciones <?php echo $this->constantes->MESES[(int)date('m')].' de '.date('Y'); ?></h4>
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
							<tbody>
								<tr>
									<td><strong>Total</strong></td>
									<td><?php echo sizeof($cotizaciones); ?></td>
								</tr>
								<tr>
									<td><strong>Aceptadas</strong></td>
									<td>
										<?php
											$count = 0;
											foreach ($cotizaciones as $cotizacion) {
												if ($cotizacion->estado == 2) {
													$count++;
												}//end if
											}//end foreach
											echo $count;
										?>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-6">
				<div class="card">
					<div class="card-body">
						<!-- title -->
						<div class="d-md-flex align-items-center">
							<div>
								<h4 class="card-title">Cotizaciones <?php echo $this->constantes->MESES[(int)date('m')].' de '.date('Y'); ?></h4>
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
							<div class="col-sm-4">
								<label>Aceptadas</label>
								<h4><?php echo $count; ?></h4>
							</div>
							<div class="col-sm-4">
								<label></label>
								<h4>x</h4>
							</div>
							<div class="col-sm-4">
								<label></label>
								<h4>100 %</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4">
								<label></label>
								<h4><?php echo number_format((float)$count*100, 2); ?></h4>
							</div>
							<div class="col-sm-4">
								<label></label>
								<h4>/</h4>
							</div>
							<div class="col-sm-4">
								<label>Total</label>
								<h4><?php echo sizeof($cotizaciones); ?></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4">
								<h4 class="text-danger">Efectividad: <?php echo (((float)$count*100) / (sizeof($cotizaciones) == 0 ? 1 : sizeof($cotizaciones) )); ?></h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
