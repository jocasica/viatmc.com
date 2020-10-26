<div class="page-wrapper">
	<!-- ============================================================== -->
	<!-- Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	<div class="page-breadcrumb">
		<div class="row align-items-center">
			<div class="col-5">
				<h4 class="page-title">Servicio</h4>
				<div class="d-flex align-items-center">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#">Servicio</a></li>
							<li class="breadcrumb-item active" aria-current="page">Registrar Servicio</li>
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
		<!-- ============================================================== -->
		<!-- Start Page Content -->
		<!-- ============================================================== -->
		<!-- Row -->
		<div class="row">
			<!-- Column -->

			<!-- Column -->
			<!-- Column -->
			<div class="col-lg-8 col-xlg-8 col-md-8">
				<div class="card">
					<div class="card-body">

						<!-- title -->
						<div class="d-md-flex align-items-center">
							<div>
								<h4 class="card-title">Registrar Servicio</h4>
								<h5 class="card-subtitle" hidden>Overview of Top Selling Items</h5>
							</div>
							<div class="ml-auto">
								<div class="dl">
									<h4 class="m-b-0 font-16">Moneda: SOLES</h4>
								</div>
							</div>
						</div>
						<!-- title -->

						<form class="form-horizontal form-material" id="frm-servicio" method="post" action="<?= base_url('servicio/post') ?>">
							
							<div class="form-group">
								<label class="col-md-12">Descripcion</label>
								<div class="col-md-12">
									<input type="text" name="descripcion" value="" class="form-control form-control-line" maxlength="300" required>
								</div>
							</div>
							<div class="form-group">

								<h4 class="m-b-0 font-16" style="float:right">Moneda: SOLES</h4>

							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<button class="btn btn-success" type="submit">Guardar</button>
								</div>
							</div>

						</form>
					</div>
				</div>
			</div>
			<!-- Column -->
		</div>
	</div>
