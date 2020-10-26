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
							<li class="breadcrumb-item active" aria-current="page">Lista de Cotizaciones Verificadas</li>
						</ol>
					</nav>
				</div>
			</div>
			<div class="col-7">
				<div class="text-right upgrade-btn">
					<!-- <a href="<?= base_url('cotizacion/create') ?>" class="btn btn-danger"><i class="fa fa-plus"></i> Registrar Cotización</a> -->
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
								<h4 class="card-title">Lista de Cotizaciones Verificadas</h4>
								<h5 class="card-subtitle" hidden >Overview of Top Selling Items</h5>
							</div>
							<div class="ml-auto" >
								<div class="dl">
									<h4 class="m-b-0 font-16"></h4>
								</div>
							</div>
						</div>
						<!-- title -->
						<div class="table-responsive">
							<table class="table table-striped table-bordered" id="tabla_cotizaciones" style="width:100%;">
								<thead>
									<tr>
										<th>#</th>
										<th>Fecha</th>
										<th>Usuario creador</th>
										<th>Vendedor</th>
										<th>Monto total</th>
										<th>Tipo cotizacion</th>
										<th>Estado</th>
										<th width="15%">Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach($data_cotizaciones as $count => $c):
										$fecha_actual = explode(' ', $c->created_at);
										$fecha_fin = date("d-m-Y", strtotime($fecha_actual[0]."+ 45 days"));
									?>
										<tr>
											<td><?= ($count+1) ?></td>
											<td><?= date('d/m/Y H:i:s', strtotime($c->created_at)) ?></td>
											<td><?= $c->user_name; ?></td>
											<td><?= $c->nombre_vendedor; ?></td>
											<td><strong>S/ <?= $c->montototal ?></strong></td>
											<td><strong><?= $c->tipo_cotizacion ?></strong></td>
											<td><label class="label label-primary" title="Cotización verificada">VERIFICADO</label></td>
											<td>
												<!-- Imprimir -->
												<?php $tipo=""; ?>
												<a target="_blank" href="<?= base_url(($c->tipo_cotizacion == 'PRODUCTO' ? 'prueba?tipo=cotizacionA4&idcotizacion='.$c->id : 'prueba?tipo=cotizacionServA4&idcotizacion='.$c->id)) ?>" class="btn btn-info btn-xs" title="Imprimir registro">
													<i class="ti-printer"></i>
												</a>
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

<!-- jquery -->
<script src="https://code.jquery.com/jquery-3.5.0.min.js" charset="utf-8"></script>
<!-- Sweet Alert 2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- viatmc scripts -->
<script src="<?php echo base_url().'js/viatmc/viatmc.js'; ?>"></script>

<script>
	$(document).ready(function () {
		$('#tabla_cotizaciones').DataTable({
			language: spanishTableInfo,
			"order": [[ 1, "desc" ]]
		});
	});
</script>