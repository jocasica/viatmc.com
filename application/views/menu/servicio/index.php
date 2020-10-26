<div class="page-wrapper">
	<!-- ============================================================== -->
	<!-- Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	<div class="page-breadcrumb">
		<div class="row align-items-center">
			<div class="col-5">
				<h4 class="page-title">Servicios</h4>
				<div class="d-flex align-items-center">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#">Servicios</a></li>
							<li class="breadcrumb-item active" aria-current="page">Lista de Servicios</li>
						</ol>
					</nav>
				</div>
			</div>
			<div class="col-7">
				<div class="text-right upgrade-btn">
					<a href="<?= base_url('servicio/create') ?>" class="btn btn-danger text-white">Registrar nuevo servicios</a>
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
								<h4 class="card-title">Lista de Servicios</h4>
								<h5 class="card-subtitle" hidden >Overview of Top Selling Items</h5>
							</div>
							<div class="ml-auto" >
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
									<th class="border-top-0">Descripcion</th>
									<th class="border-top-0">Estado</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($servicios->result() as $p){ ?>
							
							    <tr>
									<td>
										<div class="d-flex align-items-center">
											
											<div class="">
												<h4 class="m-b-0 font-16"><?= $p->descripcion ?></h4>
											</div>
										</div>
									</td>
									<td>
                                      <?php if($p->estado == 1){ ?>
                                        <label class="label label-info">Activo</label>
                                      <?php }else
                                      { ?>
                                        <label class="label label-warning">Inactivo</label>
                                      <?php } ?>
                                    </td>
									<td>
  									<a href="<?= base_url('servicio/edit/'.$p->id) ?>">
  										<i class="ti-pencil-alt"></i> Editar
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
