<div class="page-wrapper">
	<!-- ============================================================== -->
	<!-- Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	<div class="page-breadcrumb">
		<div class="row align-items-center">
			<div class="col-5">
				<h4 class="page-title">Reporte</h4>
				<div class="d-flex align-items-center">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#">Reporte</a></li>
							<li class="breadcrumb-item active" aria-current="page">Reporte </li>
						</ol>
					</nav>
				</div>
			</div>
			<!-- <div class="col-7">
				<div class="text-right upgrade-btn">
					<a href="#" class="btn btn-danger text-white">Generar Concar</a>
				</div>
			</div> -->
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			<!-- column -->
			<div class="col-lg-6 col-xlg-6 col-md-6">
				<div class="card">
					<div class="card-body">

						<!-- title -->
						<div class="d-md-flex align-items-center">
							<div>
								<h4 class="card-title">Generar lista de comprobantes</h4>
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
							<div class="form-group">
                <label class="col-md-12">Mes</label>
                <div class="col-sm-12">
									<select name="" class="form-control form-control-line" id="mes_concar">
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
									<select name="" class="form-control form-control-line" id="ano_concar">
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
                <label class="col-md-12">Comprobante</label>
                <div class="col-sm-12">
									<select name="" class="form-control form-control-line" id="doc_concar">
                    <option value="BOLETA">BOLETA</option>
                    <option value="FACTURA">FACTURA</option>
                  </select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<button class="btn btn-success" id="btn-venta-reporte" type="button">Generar Reporte</button>
								</div>
							</div>

						</form>
					</div>
				</div>


			</div>




		</div>
	</div>
</div>
