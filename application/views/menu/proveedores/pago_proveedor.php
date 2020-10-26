<div class="page-wrapper">
	<!-- ============================================================== -->
	<!-- Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	<div class="page-breadcrumb">
		<div class="row align-items-center">
			<div class="col-5">
				<h4 class="page-title">Pago a Proveedores</h4>
				<div class="d-flex align-items-center">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= base_url('socios') ?>">Almacén</a></li>
							<li class="breadcrumb-item active" aria-current="page">Lista de Proveedores</li>
						</ol>
					</nav>
				</div>
			</div>
			<div class="col-7">
				<div class="text-right upgrade-btn">
					<a href="<?= base_url('proveedor/crearProveedor') ?>" class="btn btn-danger text-white">Registrar Proveedor</a>
					<button type="button" class="btn btn-primary text-white" data-target="#pago" data-toggle="modal">Registrar pago</button>
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
								<h4 class="card-title">Lista de pago de proveedores</h4>
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
									<th class="border-top-0">#</th>
									<th class="border-top-0">Proveedor</th>
									<th class="border-top-0">Creación</th>
									<th class="border-top-0">Número</th>
									<th class="border-top-0">Total S/</th>
									<th class="border-top-0">Pagado S/</th>
									<th class="border-top-0">Pagar S/</th>
									<th class="border-top-0">Estado</th>
									<th class="border-top-0">Acciones</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$count = 0;
									foreach ($proveedor_pagos as $pago) {
										echo '<tr>';
											echo '<td>'.++$count.'</td>';
											echo '<td>'.$pago->nombre_proveedor.'</td>';
											echo '<td>'.$pago->fecha_pago.'</td>';
											echo '<td>'.$pago->numero.'</td>';
											echo '<td>'.$pago->total.'</td>';
											echo '<td>'.($pago->pagado != NULL ? $pago->pagado : 00.0).'</td>';
											echo '<td>'.($pago->pagar == 0.0 ? $pago->total : $pago->pagar).'</td>';
											echo '<td>'.($pago->estado == 0 ? '<small class="badge badge-danger">Pendiente</small>' : '<small class="badge badge-success">Pagado</small>').'</td>';
											if($pago->estado ==  0) {
												echo '<td><button type="button" class="btn btn-warning" data-target="#confirmar_pago" data-toggle="modal" onclick="confirmar('.$pago->id.', `'.$pago->numero.'`, '.$pago->total.', '.($pago->pagado != NULL ? $pago->pagado : 00.0).', '.($pago->pagar == 0.0 ? $pago->total : $pago->pagar).',
												`'.$pago->cuenta_bancaria.'`, '.$pago->tipo_pago.', '.$pago->tipo_moneda.');">Confirmar</button></td>';
											}//end else
											else {
												echo '<td><button type="button" class="btn btn-danger" disabled="disabled">Pagado</button></td>';
											}//end else
										echo '</tr>';
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

<div class="modal fade" id="pago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo pago</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  	<?php echo form_open('proveedor/realizarPago') ?>
			<div class="modal-body">
				<div class="row">
					<div class="form-group col-md-3">
						<label for="" class="col-form-label">Número:</label>
						<input type="text" name="numero" value="<?php echo $numero; ?>" class="form-control" readonly="readonly">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<label for="" class="col-form-label">Proveedor:</label>
						<?php echo form_dropdown(['name'=>'id_proveedor', 'class'=>'form-control', 'required'=>'required'],[''=>'(SELECCIONAR)']+$proveedores) ?>
					</div>
					<div class="form-group col-md-4">
						<label for="" class="col-form-label">Total:</label>
						<input type="number" name="total" value="" class="form-control" step="any" placeholder="Total" required>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Guardar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		<?php echo form_close(); ?>
    </div>
  </div>
</div>

<div class="modal fade" id="confirmar_pago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampletitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  	<?php echo form_open('proveedor/confirmarPago') ?>
			<div class="modal-body">
				<div class="row">
					<div class="form-group col-md-6">
						<label for="" class="col-form-label">Cuenta bancaria:</label>
						<input type="text" name="cuenta_bancaria" class="form-control" required id="cb">
					</div>
					<div class="form-group col-md-4">
						<label for="" class="col-form-label">Método de pago:</label>
						<?php echo form_dropdown(['name'=>'tipo_pago', 'class'=>'form-control', 'required'=>'required', 'id'=>'mp'],[''=>'(SELECCIONAR)']+$this->constantes->METODO_PAGO) ?>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<label for="" class="col-form-label">Fecha:</label>
						<input type="date" name="fecha_pago" value="<?php echo date('Y-m-d'); ?>" class="form-control" required>
					</div>
					<div class="form-group col-md-4">
						<label for="" class="col-form-label">Moneda:</label>
						<?php echo form_dropdown(['name'=>'tipo_moneda', 'class'=>'form-control', 'required'=>'required', 'id'=>'mon'],[''=>'(SELECCIONAR)']+$this->constantes->TIPO_MONEDA) ?>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<label for="" class="col-form-label">Total:</label>
						<input type="number" name="total" value="" id="total" class="form-control" step="any" placeholder="Total" readonly="readonly">
					</div>
					<div class="form-group col-md-4">
						<label for="" class="col-form-label">Pagar:</label>
						<input type="number" name="pagado" value="" id="pagado" class="form-control" step="any" placeholder="Pagar" required>
					</div>
					<!-- <div class="form-group col-md-4">
						<label for="" class="col-form-label">Pagar:</label>
						<input type="number" name="pagar" value="" id="pagar" class="form-control" step="any" placeholder="Pagar" required readonly="readonly" >
					</div> -->
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						<label for="" class="col-form-label">Descripcion:</label>
						<textarea name="descripcion" class="form-control" required placeholder="Descripción ..."></textarea>
					</div>
				</div>
			</div>
			<input type="hidden" name="id" value="" id="id_pago">
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Guardar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		<?php echo form_close(); ?>
    </div>
  </div>
</div>

<script type="text/javascript">
	const confirmar = (id, numero, total, pagado, pagar, cp, mp, mon) => {
		document.getElementById('exampletitle').innerHTML = numero;
		document.getElementById('id_pago').value = id;
		document.getElementById('total').value = total;
		if(cp !== null) {
			document.getElementById('cb').value = cp;
		}
		if (mp !== null) {
			document.getElementById('mp').value = mp;
		}
		if (mon !== null) {
			document.getElementById('mon').value = mon;
		}
		// document.getElementById('pagado').value = pagado;
		// document.getElementById('pagar').value = pagar;
	};
</script>
