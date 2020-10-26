<div class="page-wrapper">
	<!-- ============================================================== -->
	<!-- Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	<div class="page-breadcrumb">
		<div class="row align-items-center">
			<div class="col-5">
				<h4 class="page-title">Notas de Debito</h4>
				<div class="d-flex align-items-center">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#">Notas de Debito</a></li>
							<li class="breadcrumb-item active" aria-current="page">Lista de Notas de Debito</li>
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
								<h4 class="card-title">Lista de Notas de Debito</h4>
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
					<div class="table-responsive">
						<table class="table v-middle">
							<thead>
								<tr class="bg-light">
									<th class="border-top-0">Serie</th>
									<th class="border-top-0">Número</th>
									<th class="border-top-0">Fecha</th>
									<th class="border-top-0">Estado</th>
									<th class="border-top-0">Monto total</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($ventas->result() as $v){
								
							?>
								<tr>
									<td>
										<div class="d-flex align-items-center">
											<div class="m-r-10"><a class="btn btn-circle btn-orange text-white">C</a></div>
											<div class="">
												<h4 class="m-b-0 font-16">
													<?= $v->serie ?>
												</h4>
											</div>
										</div>
									</td>
									<td>
										<?= $v->numero ?>
									</td>
									<td>
										<?= $v->fecha ?>
									</td>
									<td>
										<label class="label label-info">
											<?php if($v->estado){echo("Habilitado");}else{echo("Inhabilitado");} ?></label>
									</td>
									<td>
										<h5 class="m-b-0">S/<?= $v->total ?></h5>
									</td>
									<td>
										<?php 
										$tipo="notadebito";
										?>
										<a target="_blank" href="<?= base_url('prueba?tipo='.$tipo.'&id='.$v->id) ?>" >
											<i class="ti-pencil-alt"></i> Ticket
										</a>

									</td>
								</tr>
								<?php 
								}
							?>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
