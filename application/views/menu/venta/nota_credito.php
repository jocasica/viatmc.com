<div class="page-wrapper">
	<!-- ============================================================== -->
	<!-- Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	<div class="page-breadcrumb">
		<div class="row align-items-center">
			<div class="col-5">
				<h4 class="page-title">Notas de Credito</h4>
				<div class="d-flex align-items-center">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#">Notas de Credito</a></li>
							<li class="breadcrumb-item active" aria-current="page">Lista de Notas de Credito</li>
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
	<div class="container-fluid">
		<div class="row">
			<!-- column -->
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<!-- title -->
						<div class="d-md-flex align-items-center">
							<div>
								<h4 class="card-title">Lista de Notas de Credito</h4>
								<h5 class="card-subtitle" hidden>Overview of Top Selling Items</h5>
							</div>
							<div class="ml-auto">
								<div class="dl">
									<h4 class="m-b-0 font-16">Moneda: SOLES</h4>
								</div>
							</div>
						</div>
						<!-- title -->
					</div>
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table v-middle" id="tabla_principal_notas_credito">
								<thead>
									<tr class="bg-light">
										<th class="border-top-0">Serie</th>
										<th class="border-top-0">Número</th>
										<th class="border-top-0" width="30%">Cliente</th>
										<th class="border-top-0" width="10%">Fecha</th>
										<th class="border-top-0" width="15%">Personal</th>
										<th class="border-top-0">Guía de remisión</th>
										<th class="border-top-0">Estado API</th>
										<th class="border-top-0">SUNAT</th>
										<th class="border-top-0">Monto total</th>
										<!-- <th class="border-top-0">Acciones</th> -->
									</tr>
								</thead>
								<tbody>
									<?php foreach($data_notas_credito as $n): ?>
										<?php
											$num_digitos = 8;
											$numero_nota_credito = str_repeat('0', $num_digitos-strlen($n->id)).$n->id;
										?>
										<tr>
											<td><strong><?= $n->serie_nota; ?></strong></td>
											<td><?= $numero_nota_credito; ?></td>
											<td><?= $n->cliente; ?> <small><?= $n->ruc; ?></small></td>
											<td><?= $n->fecha; ?></td>
											<td><?= $n->vendedor_name; ?></td>
											<td><?= $n->guia_remision; ?></td>
											<td>
											<?php
													switch ($n->estado_api) {
														case 'Registrado':
															echo '<label '
																. ' data-cpe="estado_cpe" '
																. ' data-id="' . $n->id . '"'
																. ' data-serie="' . $n->serie . '"'
																. ' data-numero="' . $n->numero . '"'
																. ' data-tipo="' . $n->tipo . '"'
																. ' class="badge badge-info"><i class="fa fa-sync"></i> Registrado</label>';
															break;
														case 'Enviado':
															echo '<label class="badge badge-primary">Enviado</label>';
															break;
														case 'Aceptado':
															echo '<label class="badge badge-success">Aceptado</label>';
															$fecha_limite = date('Y-m-d', strtotime("+ 7 days", strtotime($n->fecha)));
															//echo $fecha_limite;
															if ($fecha_limite >= date('Y-m-d')) {
																echo '<label '
																	. ' data-cpe="anular"'
																	. ' data-id="' . $n->id . '"'
																	. ' data-serie="' . $n->serie . '"'
																	. ' data-numero="' . $n->numero . '"'
																	. ' data-tipo="' . $n->tipo . '"'
																	. ' class="badge badge-danger"><i class="fa fa-trash"></i> Anular</label>';
															} else {
																echo '<label class="badge badge-danger">Fecha límite excedida</label>';
															}
															break;
														case 'Observado':
															echo '<label class="badge badge-warning">Observado</label>';
															break;
														case 'Rechazado':
															echo '<label class="badge badge-light">Rechazado</label>';
															break;
														case 'Anulado':
															echo '<label class="badge badge-danger">Anulado</label>';
															break;
														case 'Por Anular':
															echo '<label class="badge badge-info">Por Anular</label>';
															break;
														default:
															echo ''
																. ' data-cpe="enviar" '
																. ' data-id="' . $n->id . '"'
																. ' data-serie="' . $n->serie . '"'
																. ' data-numero="' . $n->numero . '"'
																. ' data-tipo="' . $n->tipo . '"'
																. ' class="badge badge-dark"><i class="fa fa-paper-plane"></i> Pendiente</label>';
															break;
													} ?>
											</td>
											<td>
											<label class="label label-<?php if (strtoupper($n->estado_sunat) == "ACEPTADO") {
															echo "success";
														} else {
															if (strtoupper($n->estado_sunat) == "ANULADO") {
																echo "danger";
															} else {
																echo "warning";
															}
														} ?>"><?= $n->estado_sunat ?></label>
											</td>
											<td><h5 class="m-b-0"><?php echo $n->total . ' ' . $n->codigo_moneda; ?></h5></td>
											<!-- <td>
												<a target="_blank" href="<?= base_url('prueba?tipo=' . 'factura_nota_credito' . 'A4&id=' . $n->venta_id) ?>" class="btn btn-warning btn-xs">Ver nota</a>
										</tr> -->
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
