
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
							<li class="breadcrumb-item"><a href="#">Cotizaciones </a></li>
							<li class="breadcrumb-item active" aria-current="page">Editar Cotizacion</li>
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
	<?php $i = $cotizacion->id?>
	<form id="frm-cot" method="post" action="<?= base_url('cotizacion/update/'.$i) ?>">
    	<div class="container-fluid">
    	    <div class="row">
        		<div class="col-lg-8">
        			<div class="card">
        					<div class="card-body">
        						<h4 class="card-title">Editar Cotizacion</h4>
        
        						<ul class="row list-style-none text-left m-t-30">
        							
        							<li class="col-lg-4">
        								<span class="">Fecha</span>
        								<input type="date" value="<?= $cotizacion->fecha ?>" readonly name="fecha" class="form-control" required />
        							</li>
        							<li class="col-lg-3">
        								<span class="">Moneda</span>
        								<select type="text" name="moneda" class="form-control">
        								    <?php if($cotizacion->moneda == "S/") {?>
        									<option value="S/">SOLES (S/)</option>
        									<option value="$">DOLARES ($)</option>
        									<?php }else { ?>
        										<option value="$">DOLARES ($)</option>
        										<option value="S/">SOLES (S/)</option>
        										<?php }?>
        								</select>
        							</li>
        						</ul>
        						<hr>
        						<ul class="row list-style-none text-left m-t-30">
        							
        							<li class="col-lg-6">
        							    
        								<span class="">Cliente</span>
        								<input type="text" name="cliente_id" id="cliente_id"  style="width:100%" required>
        							</li>
        							<li class="col-lg-2">
        							    <span class="">.</span>
        							    <button type="button" class="btn btn-primary" id="add_producto" >Agregar producto</button>
        							</li>
        						</ul>
        						<ul class="row list-style-none text-left m-t-30">
        						    <table class="table table-striped">
            					    <thead class="thead-dark">
            					        <tr>
            					            <th>Nombre</th>
            					            <th>Medidas</th>
            					            <th>Cantidad</th>
											<th>Validez Oferta</th>
            					            <th>Entrega</th>
            					            <th>Forma Pago</th>
            					            <th>Garantia Meses</th>
            					            <th>Precio Uni.</th>
            					            <th>Monto</th>
            					            <th id="detalle">Detalle</th>
            					        </tr>
            					    </thead>
            					    <tbody id="tbody_producto">
            					        <?php foreach($cot_prod->result() as $c){
								            if($c->cotizacion_id == $cotizacion->id) {
							            ?>
								        <tr>
        									<td>
        										<h5 class="m-b-0"><?= $c->nombre ?></h5>
        									</td>
        									<td>
        										<h5 class="m-b-0"><?= $c->medida ?></h5>
        									</td>
        									<td>
        										<h5 class="m-b-0"><?= $c->cantidad ?></h5>
        									</td>
        									<td>
        										<h5 class="m-b-0"><?= $c->validezOferta ?></h5>
        									</td>
        									<td>
        										<h5 class="m-b-0"><?= $c->entrega ?></h5>
        									</td>
        									<td>
        										<h5 class="m-b-0"><?= $c->formaPago ?></h5>
        									</td>
        									<td>
        										<h5 class="m-b-0"><?= $c->garantiaMeses ?></h5>
        									</td>
        									<td>
        										<h5 class="m-b-0"><?= $c->precio ?></h5>
        									</td>
        									<td>
        										<h5 class="m-b-0"><?= $c->monto ?></h5>
        									</td>
        									<td>
        									    <?php $pId = $c->pId ?>
        									    <?php $created_at = $c->created_at;
        									        $dt = new DateTime($created_at);
                                                    $date = $dt->format('Y-m-d');
                                                    $time = $dt->format('H:i:s'); ?>
        										<h5 class="m-b-0"><a href="<?= base_url('cotizacion/deleteCotizacion_Producto/'.$i.'/'.$pId.'/'.$date.'/'.$time) ?>" id="deleteRow"> Eliminar</a></h5>
        									</td>
        								</tr>
        								<?php } }?>
            					    </tbody>
            					</table>
        						</ul>
        						
        					
        						<hr>
        						<ul class="row list-style-none text-left m-t-30">
        							<li class="col-lg-3">
        								<span class=""><b>Monto Total</b> </span>
        								<input type="number" style="background-color: #E5F18F;" name="montototal" id="montototal" readonly
        									value="<?= $cotizacion->montototal?>" min="0" class="form-control" />
        							</li>
        						
        							
        						</ul>
        						
        						
        					
        						<ul class="row list-style-none text-left m-t-30">
        							<li class="col-lg-4">
        								<button type="submit" class="btn btn-success">Actualizar</button>
        							</li>
        						</ul>
        					</div>
        			</div>
        		</div>
        	</div>
    	</div>
	</form>

	
	<div id="vm_add_producto" class="modal fade" style="display:none">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-primary">
					<h6 class="modal-title" style="color:white">Agregar Producto</h6>
					<button type="button"  class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body">

					<form class="form-horizontal form-material" id="frm-add-producto" method="post" enctype="multipart/form-data">

						<div class="form-group">
							<div class="form-group">
								<label class="col-md-12">Producto</label>
								<div class="col-md-12">
									<?php echo form_dropdown(['name' => 'producto_id', 'id' => 'producto_id', 'class' => 'form-control', 'required' => 'required', 'onchange'=>''],['' => '(SELECCIONAR)']+$productos) ?>
								</div>
							</div>
							<div class="form-group">
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="checkbox" id="toggleSerie">
									<label class="form-check-label" for="inlineChec">Serie</label>
								</div>

								<div class="col-md-12" id="serieToggleObjet" >
									<input type="text" id="serie" name="serie" class="form-control"  />
								</div>
							</div>
							<div class="form-group">

								<div class="form-check form-check-inline">
									<input class="form-check-input" type="checkbox" id="toggleMarca">
									<label class="form-check-label" for="inlineCheckbox1">Marca</label>
								</div>

								<div class="col-md-12" id="marcaToggleObjet" >
									<input type="text" id="marcaproducto" name="marcaproducto" class="form-control"  />
								</div>
							</div>
							<div class="form-group">
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="checkbox" id="toggleProcedencia">
									<label class="form-check-label" for="inlineCheckbox1">Procedencia</label>
								</div>
								<div class="col-md-12" id="procedenciaToggleObjet">
									<input type="text"  id="procedenciaproducto" name="procedenciaproducto" class="form-control"  />
								</div>
							</div>
							<div class="form-group">
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="checkbox" id="toggleImagenes">
									<label class="form-check-label" for="inlineCheckbox1">Agregar imagenes</label>
								</div>
								<div class="col-md-12" id="imagenesToggleObjet">
									<input type="hidden" name="size" value="1000000">
									<input type="hidden" name="image1Set" id="image1Set" value="1000000">
									<div>
										<img id="imagen1" style="width:100px;"  alt="" srcset="">
										<input type="file" name="image1" id="imageUploaded1" accept="image/*">
										<img id="imagen2" style="width:100px;"  alt="" srcset="">
										<input type="file" name="image2" id="imageUploaded2" accept="image/*">

									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="checkbox" id="toggleCaracteristicas">
									<label class="form-check-label" for="inlineCheckbox1">Agregar caracteristicas </label>
								</div>
								<div id="caracteristicasToggleObjet">
									<div class="col-md-6">
										<button id="btnAdd" type="button" class="btn btn-primary" data-toggle="tooltip" data-original-title="Add more controls"><i class="fas fa-plus"></i>Agregar característica</button></th>
									</div>
									<br>
									<div>
										<div class="form-group">
											<label class="col-md-12">Caracteristica 1</label>
											<div class="col-md-12">
												<input type="text" name="caracteristica[]" class="form-control"  class="caract"/>
											</div>
										</div>
									</div>
								</div>


								<div class="form-group">
									<label class="col-md-12">Precio</label>


									<input type="number"  id="precioproducto" name="precioproducto" class="form-control" required />
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-12">Cantidad</label>
								<div class="col-md-12">
									<input type="number" id="cantidad" name="cantidad" class="form-control form-control-line" min="0" required>
								</div>
							</div>
							<div class="form-group">
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="checkbox" id="toggleValidez">
									<label class="form-check-label" for="inlineCheckbox1">Validez oferta</label>
								</div>
								<div class="col-md-12" id="validezToggleObjet">
									<input type="text" id="validezOferta" name="validezOferta" class="form-control form-control-line" min="0">
								</div>
							</div>
							<div class="form-group">
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="checkbox" id="toggleEntrega">
									<label class="form-check-label" for="inlineCheckbox1">Entrega</label>
								</div>
								<div class="col-md-12" id="entregaToggleObjet">
									<input type="text" id="entrega" name="entrega" class="form-control form-control-line" min="0">
								</div>
							</div>
							<div class="form-group">
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="checkbox" id="toggleFormaPago">
									<label class="form-check-label" for="inlineCheckbox1">Forma de pago</label>
								</div>
								<div class="col-md-12" id="formaPagoToggleObjet">
									<input type="text" id="formaPago" name="formaPago" class="form-control form-control-line" min="0">
								</div>
							</div>
							<div class="form-group">
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="checkbox" id="toggleGarantia">
									<label class="form-check-label" for="inlineCheckbox1">Garantia mes</label>
								</div>
								<div class="col-md-12" id="garantiaToggleObjet">
									<input type="text" id="garantiaMeses" name="garantiaMeses" class="form-control form-control-line" min="0">
								</div>
							</div>

							<hr>
							<div class="form-group">
								<label class="col-md-12">Monto Total Producto</label>
								<div class="col-md-12">
									<input type="number" style="background-color: #E5F18F;" readonly value="0.00"
										   id="montoproducto" name="montoproducto" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<button class="btn btn-success" type="submit">Agregar</button>
								</div>
							</div>
					</form>

					<form class="form-horizontal form-material" id="frm-add-producto" method="post" action="<?= base_url('cliente/postCliente') ?>">
						<div class="form-group">
							<div class="form-group">
								<label class="col-md-12">Producto</label>
								<div class="col-md-12">
									<select type="text" id="producto_id" style="width: 100%" class="select2" required>
    									<option value="">--Escoge un producto--</option>
    									<?php foreach($productos->result() as $p){
    									    if($p->eliminado == 0) {
    										?>
    									<option value="<?= $p->id ?>" normal="<?= $p->precio_venta ?>"
    										 tipo="<?= $p->tipo ?>">
    										<?= $p->nombre.' - '.$p->caracteristica1 ?>
    									</option>
    									<?php 
    										}} 
    										?>
    								</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-12">Precio</label>
								<div class="col-md-12">
									<input type="number" readonly id="precioproducto" class="form-control" required />
								</div>
							</div>	
							<div class="form-group">
								<label class="col-md-12">Cantidad</label>
								<div class="col-md-12">
									<input type="number" id="cantidad" class="form-control form-control-line" min="0">
								</div>
							</div>	
							<div class="form-group">
								<label class="col-md-12">Validez Oferta</label>
								<div class="col-md-12">
									<input type="number" id="validezOferta" class="form-control form-control-line" min="0">
								</div>
							</div>	
							<div class="form-group">
								<label class="col-md-12">Entrega</label>
								<div class="col-md-12">
									<input type="number" id="entrega" class="form-control form-control-line" min="0">
								</div>
							</div>	
							<div class="form-group">
								<label class="col-md-12">Forma Pago</label>
								<div class="col-md-12">
									<input type="text" id="formaPago" class="form-control form-control-line" min="0">
								</div>
							</div>	
							<div class="form-group">
								<label class="col-md-12">Garantia Meses</label>
								<div class="col-md-12">
									<input type="number" id="garantiaMeses" class="form-control form-control-line" min="0">
								</div>
							</div>	
							<div id="tipo_datos">
    							<div class="form-group">
    								<label class="col-md-12">Largo (cm)</label>
    								<div class="col-md-12">
    									<input type="number" id="largo" step=".001" min="0" class="form-control" />
    								</div>
    							</div>	
    							<div class="form-group">
    								<label class="col-md-12">Ancho (cm)</label>
    								<div class="col-md-12">
            							<input type="number" id="ancho" step=".001" min="0" class="form-control"  />
    								</div>
    							</div>	
    							<div class="form-group">
    								<label class="col-md-12">Area total (m2)</label>
    								<div class="col-md-12">
    									<input type="number" readonly step=".001" value="0.000" id="area" class="form-control"
            									 />
    								</div>
    							</div>
							</div>
							<div class="form-group">
								<label class="col-md-12">Monto Producto</label>
								<div class="col-md-12">
									<input type="number" style="background-color: #ECB4A8;" readonly value="0.00"
        									id="montoproducto" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<button class="btn btn-success" type="submit">Agregar</button>
								</div>
							</div>
						</div>
					</form>
                </div>
		    </div>
    	</div>
	</div>
	
    <div id="vm_registrar_cliente" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-primary">

					<h6 class="modal-title" style="color:white">Registrar Cliente</h6>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body">
					<form class="form-horizontal form-material" id="frm-cliente-coti" method="post" action="<?= base_url('cliente/postCliente') ?>">
						<div class="form-group">
								<label class="col-md-12">Tipo de documento</label>
								<div class="col-md-12">
									<select name="tipo_doc" id="tipo_doc" class="form-control form-control-line" required>
										<option value="DNI">DNI</option>
										<option value="RUC">RUC</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-12">Numero de documento</label>
								<div class="col-md-12">
									<input type="number" onkeydown="return event.keyCode !== 69"
    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
    type = "number"
    maxlength = "8" name="numero_doc" id="numero_doc" class="form-control form-control-line" required>
								</div>
							</div>
							<div class="form-group">
    							<button class="form-control btn btn-primary" id="buscar_doc" type="button">
    							    <span id="textobut">Buscar</span>
    							    <i class="mdi mdi-magnify"></i>
    							</button>
							</div>
							<div class="form-group">
								<label class="col-md-12">Nombre</label>
								<div class="col-md-12">
									<input type="text" name="nombre" id="nombre" class="form-control form-control-line" required>
								</div>
							</div>
							<div class="form-group">
								<label for="caracteristica" class="col-md-12">Nombre comercial</label>
								<div class="col-md-12">
								<input type="text" name="nombre_comercial" class="form-control form-control-line" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-12">Direccion</label>
								<div class="col-md-12">
									<input type="text" name="direccion" id="direccion" class="form-control form-control-line" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-12">Tipo de cliente</label>
								<div class="col-md-12">
									<select name="tipo" class="form-control form-control-line" required>
										<option value="Cliente Normal">Cliente Normal</option>
										<option value="Cliente Distribuidor">Cliente Distribuidor</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-12">Telefono</label>
								<div class="col-md-12">
									<input name="telefono" id="telefono" class="form-control form-control-line"
									onkeydown="return event.keyCode !== 69"
    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
    type = "number"
    maxlength = "9" required
 />
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-12">Correo</label>
								<div class="col-md-12">
									<input type="email" name="correo" id="correo" class="form-control form-control-line">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-12">Telefono referencia</label>
								<div class="col-md-12">
									<input type="number" name="telefono_ref" id="telefono_ref" onkeydown="return event.keyCode !== 69" class="form-control form-control-line" >
								</div>
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
	</div>
	
</div>	

<script src="<?= base_url() ?>panel/assets/libs/jquery/dist/jquery.min.js"></script>
	<script type="text/javascript">
	
     function total(){
            var montoproducto = 0;
            $("#tbody_producto tr td:nth-child(5)").each(function() {
                montoproducto = montoproducto + parseFloat($(this).text());
            });
            
            var montodiseno = $('#montodiseno').val();
            if ($('#montodiseno').val() == null){
                montodiseno = 0;
            }
            var montoacabado = $('#montoacabado').val();
            if ($('#montoacabado').val() == null){
                montoacabado = 0;
            }
            $('#montototal').val(parseFloat(montoproducto+parseFloat(montodiseno)+parseFloat(montoacabado)).toFixed(2));
            $('#totalpagar').val(parseFloat($('#montototal').val()-$('#descuento').val()).toFixed(2));
        }
        
    $(document).ready(function() {
        $('#montoacabado').val(parseFloat($('#precioacabado').val()*$('#cantidadacabado').val()).toFixed(2));
            total();
        $('#acabado').change(function() {
            value = $(this).children("option:selected").val();
            if(value == "8") {
            $('#precioacabado').val("0");
            $('#cantidadacabado').val("0");
            $('#montoacabado').val("0");
            }
        });
        autorizante = $("#autorizante_id").val()
        if(autorizante == "0" || autorizante == ""){
            $("#div_clave").prop('hidden',true);
        }
    });
    
   
</script>
