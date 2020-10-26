        <!--Load the AJAX API-->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row align-items-center">
                    <div class="col-5">
                        <h4 class="page-title">Dashboard</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <div class="row">
                    <!-- column -->
                    <div class="col-lg-12 col-xlg-8 col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-group">
                                    <div class="card p-2 p-lg-3">
                                        <div class="p-lg-3 p-2">
                                            <div class="d-flex align-items-center">
                                                <a class="btn btn-circle btn-danger text-white btn-lg" href="<?= base_url('venta') ?>"><i class="far fa-address-book"></i></a>
                                                <div class="ml-4" style="width: 38%;">
                                                    <h4 class="font-light">Ventas totales</h4>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-cyan" role="progressbar" style="width: <?php echo $ventas_totales; ?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="10000"></div>
                                                    </div>
                                                </div>
                                                <div class="ml-auto">
                                                    <h2 class="display-10 mb-0"><?php echo $ventas_totales; ?>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card p-2 p-lg-3">
                                        <div class="p-lg-3 p-2">
                                            <div class="d-flex align-items-center">
                                                <a class="btn btn-circle btn-cyan text-white btn-lg" href="<?= base_url('cotizacion/pendiente') ?>"><i class="ti-wallet"></i></a>
                                                <div class="ml-4" style="width: 38%;">
                                                    <h4 class="font-light">Cotizaciones pendientes </h4>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-cyan" role="progressbar" style="width: <?php echo $pendientes; ?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="10000"></div>
                                                    </div>
                                                </div>
                                                <div class="ml-auto">
                                                    <h2 class="display-7 mb-0"><?php echo $pendientes; ?></h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card p-2 p-lg-3">
                                        <div class="p-lg-3 p-2">
                                            <div class="d-flex align-items-center">
                                                <a class="btn btn-circle btn-cyan text-white btn-lg" href="<?= base_url('cotizacion/aceptada') ?>"><i class="ti-wallet"></i></a>
                                                <div class="ml-4" style="width: 38%;">
                                                    <h4 class="font-light">Cotizaciones aceptadas </h4>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-cyan" role="progressbar" style="width: <?php echo $aceptadas; ?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="10000"></div>
                                                    </div>
                                                </div>
                                                <div class="ml-auto">
                                                    <h2 class="display-7 mb-0"><?php echo $aceptadas; ?></h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ============================================================== -->
                <!-- Sales chart -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <h4 class="card-title">Total de ventas mensuales</h4>
                                        <h5 class="card-subtitle">Año <?php echo date('Y'); ?></h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- column -->
                                    <div class="col-lg-12">
                                        <div id="columnchart_values"></div>
                                    </div>
                                    <!-- column -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Semana <?php echo date("d/m/Y",strtotime($fecha_inicio)).' al '.date("d/m/Y",strtotime($fecha_fin)); ?></h4>
                                <h6 class="text-muted">Total de ventas por semana</h6>
                                <div>
                                    <table class="table">
                                        <thead>
                                            <th>Día</th>
                                            <th>Soles</th>
                                            <th>Dolares</th>
                                        </thead>
                                        <tbody>
                                        <?php
                                            foreach ($datos_semanales as $dia) { ?>
                                                <tr>
                                                    <td><?php echo $this->constantes->DIAS_SEMANA[(int) $dia->dia_semana]; ?></td>
                                                    <td><?php if($dia->total_soles) { echo 'S/ '. $dia->total_soles; } else { echo 'S/ 0'; } ?></td>
                                                    <td><?php if($dia->total_dolares) { echo '$ '. $dia->total_dolares;} else { echo '$ 0'; } ?></td>
                                                </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Sales chart -->
                <!-- ============================================================== -->
                <div class="row">
                    <!-- column -->
                    <div class="col-lg-12 col-xlg-8 col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-group">
                                    <div class="card p-2 p-lg-3">
                                        <div class="p-lg-3 p-2">
                                            <div class="d-flex align-items-center">
                                                <a class="btn btn-circle btn-success text-white btn-lg" href="<?= base_url('dashboard/envios_aceptados') ?>"><i class="far fa-file"></i></a>
                                                <div class="ml-4" style="width: 38%;">
                                                    <h4 class="font-light">Aceptados</h4>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-cyan" role="progressbar" style="width: <?php echo $aceptados; ?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="10000"></div>
                                                    </div>
                                                </div>
                                                <div class="ml-auto">
                                                    <h2 class="display-10 mb-0"><?php  echo $aceptados; ?>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card p-2 p-lg-3">
                                        <div class="p-lg-3 p-2">
                                            <div class="d-flex align-items-center">
                                                <a class="btn btn-circle btn-warning text-white btn-lg" href="<?= base_url('pendientes') ?>"><i class="far fa-file"></i></a>
                                                <div class="ml-4" style="width: 38%;">
                                                    <h4 class="font-light">Pendientes </h4>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-cyan" role="progressbar" style="width: <?php echo $pendiente; ?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="10000"></div>
                                                    </div>
                                                </div>
                                                <div class="ml-auto">
                                                    <h2 class="display-7 mb-0"><?php echo $pendiente; ?></h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card p-2 p-lg-3">
                                        <div class="p-lg-3 p-2">
                                            <div class="d-flex align-items-center">
                                                <a class="btn btn-circle btn-danger text-white btn-lg" href="<?= base_url('dashboard/envios_anulados') ?>"><i class="far fa-file"></i></a>
                                                <div class="ml-4" style="width: 38%;">
                                                    <h4 class="font-light">Anulados </h4>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-cyan" role="progressbar" style="width: <?php echo $anulados; ?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="10000"></div>
                                                    </div>
                                                </div>
                                                <div class="ml-auto">
                                                    <h2 class="display-7 mb-0"><?php  echo $anulados;?></h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<div class="card p-2 p-lg-3">
										<div class="p-lg-3 p-2">
											<div class="d-flex align-items-center">
												<a class="btn btn-circle btn-danger text-white btn-lg" href="<?= base_url('dashboard/envios_rechazados') ?>"><i class="far fa-file"></i></a>
												<div class="ml-4" style="width: 38%;">
													<h4 class="font-light">Rechazados </h4>
													<div class="progress">
														<div class="progress-bar bg-cyan" role="progressbar" style="width: <?php echo $rechazados; ?>%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="10000"></div>
													</div>
												</div>
												<div class="ml-auto">
													<h2 class="display-7 mb-0"><?php echo $rechazados; ?></h2>
												</div>
											</div>
										</div>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>

        <script type="text/javascript">
            let grafica = <?php echo $grafica; ?>;
        </script>
