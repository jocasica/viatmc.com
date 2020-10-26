<div class="page-wrapper">
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
							<li class="breadcrumb-item active" aria-current="page">SEACE</li>
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
			<div class="col-lg-12 col-xlg-12 col-md-12">
				<div class="card">
					<div class="card-body">

						<!-- title -->
						<div class="d-md-flex align-items-center">
							<div>
								<h4 class="card-title">Generar SEACE</h4>
								<h5 class="card-subtitle" hidden>Overview of Top Selling Items</h5>
							</div>
							<div class="ml-auto">
								<div class="dl">
									<h4 class="m-b-0 font-16">Moneda: SOLES</h4>
								</div>
							</div>
						</div>
						<!-- title -->

						<?php echo form_open('', ['id'=>'reporte-formulario']); ?>
							<div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Fecha Inicio</label>
                                    <input type="date" name="fecha_inicio" value="" class="form-control" required>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Fecha Fin</label>
                                    <input type="date" name="fecha_fin" value="" class="form-control" required>
                                </div>
                            </div>
							<div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Rubro</label>
                                    <?php echo form_dropdown(['name'=>'rubro', 'class'=>'form-control', 'required'=>'required'],$this->constantes->SEGMENTOS+['todos'=>'Todos']); ?>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Producto</label>
                                    <?php echo form_dropdown(['name'=>'id_producto', 'class'=>'form-control', 'required'=>'required'],$productos); ?>
                                </div>
                            </div>
							<div class="form-group">
								<div class="col-sm-12">
									<button class="btn btn-success" type="submit">Buscar</button>
								</div>
							</div>

						</form>

						<div class="table-responsive">
							<table class="table v-middle" style="font-size: 12px" id="seaceTable">
								<thead>
									<tr class="bg-light">
										<th class="border-top-0">Serie</th>
										<th class="border-top-0">N. Factura</th>
										<th class="border-top-0">Cliente</th>
										<th class="border-top-0">Fecha</th>
										<th class="border-top-0">RUC</th>
										<th class="border-top-0">Documentos</th>
									</tr>
								</thead>
								<tbody id="data-datos"></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
