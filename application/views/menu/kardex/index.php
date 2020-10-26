<div class="page-wrapper">
	<!-- ============================================================== -->
	<!-- Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	<div class="page-breadcrumb">
		<div class="row align-items-center">
			<div class="col-5">
				<h4 class="page-title">Kardex</h4>
				<div class="d-flex align-items-center">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#">Kardex</a></li>
							<li class="breadcrumb-item active" aria-current="page">Reporte Kardex</li>
						</ol>
					</nav>
				</div>
			</div>

		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			<!-- column -->
			<div class="col-lg-8 col-xlg-8 col-md-8">
				<div class="card">
					<div class="card-body">

						<!-- title -->
						<div class="d-md-flex align-items-center">
							<div>
								<h4 class="card-title">Generar Kardex</h4>
								<h5 class="card-subtitle" hidden>Overview of Top Selling Items</h5>
							</div>
							<div class="ml-auto">
								<div class="dl">
									<h4 class="m-b-0 font-16">Moneda: SOLES</h4>
								</div>
							</div>
						</div>
						<!-- title -->

						<form class="form-horizontal form-material" id="frm" method="post" action="">
							<div class="form-group">
								<label class="col-md-12">Producto</label>
								<div class="col-sm-12">
									<select name="" class="form-control form-control-line select2" id="producto_kardex" name="producto_kardex">

										<option value="">(SELECCIONAR)</option>
										<?php foreach ($prods->result() as $p) {
										?>
											<option value="<?= $p->id ?>">
												<?= $p->id . ' - ' . $p->nombre . ' - ' . $p->codigo_barra ?>
											</option>
										<?php
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-12">Mes</label>
								<div class="col-sm-12">
									<select name="" class="form-control form-control-line select2" id="mes_kardex" name="mes_kardex">
										<option value="1">ENERO</option>
										<option value="2">FEBRERO</option>
										<option value="3">MARZO</option>
										<option value="4">ABRIL</option>
										<option value="5">MAYO</option>
										<option value="6">JUNIO</option>
										<option value="7">JULIO</option>
										<option value="8">AGOSTO</option>
										<option value="9">SEPTIEMBRE</option>
										<option value="10">OCTUBRE</option>
										<option value="11">NOVIEMBRE</option>
										<option value="12">DICIEMBRE</option>
									</select>
								</div>
							</div>
							<div class="form-group">

								<label class="col-md-12">Año</label>
								<div class="col-sm-12">
									<select name="" class="form-control form-control-line select2" id="ano_kardex">
										<option value="2018">2018</option>
										<option value="2019">2019</option>
										<option value="2020">2020</option>
										<option value="2021">2021</option>
										<option value="2022">2022</option>
										<option value="2023">2023</option>
										<option value="2024">2024</option>
										<option value="2025">2025</option>
										<option value="2026">2026</option>
										<option value="2027">2027</option>
										<option value="2028">2028</option>
										<option value="2029">2029</option>
										<option value="2030">2030</option>
									</select>
								</div>
							</div>

							<div class="form-group">
								<div class="row">

									<div class="col-sm-6 col-6">
										<button class="btn btn-success" id="btn-kardex" type="button">Generar Kardex</button>
									</div>
									<div class="col-sm-6 col-6">
										<button class="btn btn-warning" id="btn-kardex-excel" type="button">Generar Excel Kardex</button>
									</div>
								</div>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://code.jquery.com/jquery-3.5.0.min.js" charset="utf-8"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			var year=new Date().getFullYear();
			var month= new Date().getMonth()+1;
			$("#mes_kardex").val(month);
			$("#ano_kardex").val(year);
		});

	</script>