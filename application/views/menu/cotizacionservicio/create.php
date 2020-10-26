
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
							<li class="breadcrumb-item"><a href="#">Cotizaciones</a></li>
							<li class="breadcrumb-item active" aria-current="page">Registrar Cotizacion</li>
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
	<form id="frm-cot" method="post" action="<?= base_url('cotizacion/postservicio') ?>" enctype="multipart/form-data">
    	<div class="container-fluid">
    	    <div class="row">
        		<div class="col-lg-11">
        			<div class="card">
        					<div class="card-body">
        						<h4 class="card-title">Registrar Cotizacion</h4>
        
        						<ul class="row list-style-none text-left m-t-30">
        							<!--<li class="col-lg-3 col-md-3">
                                        <span class="">Serie</span>
                                        <input type="text" value="" readonly name="serie" class="form-control" required />
                                    </li>
                                    <li class="col-lg-2">
                                        <span class="">Numero</span>
                                        <input type="text" value="" readonly name="numero" class="form-control" required />
                                    </li>-->
        							<li class="col-lg-4">
        								<span class="">Fecha</span>
        								<input type="date" value="<?= date('Y-m-d')?>" readonly name="fecha" class="form-control" required />
        							</li>
        							<li class="col-lg-3">
                                        <span class="">Moneda</span>
                                        <select type="text" name="moneda" class="form-control">
                                            <option selected="selected" value="S/">SOLES (S/)</option>
                                            <option value="$">DOLARES ($)</option>
                                        </select>
                                    </li>
        						</ul>
        						<hr>
        						<ul class="row list-style-none text-left m-t-30">
        							
        							<li class="col-lg-6">
        							    
        								<span class="">Cliente</span>
        								<input type="text" name="cliente_id" id="cliente_id"  style="width:100%" required>
        									
        								
        							</li>
        							
        							
        						</ul>
        						<ul class="row list-style-none text-left m-t-30">
								<li class="col-lg-6">
        							    
        								<span class="">Servicio</span>
        								<input type="text" id="servicio_id" style="width: 100%" name="servicio_id" required>
    									
        									
								</li >
							</ul>
        						<ul class="row list-style-none text-left m-t-30">
								<li class="col-lg-6">
        							    
        								<span class="">Referencia</span>
        								<input type="text" id="referencia" style="width: 100%" name="referencia" required>
    									
        									
								</li >
							</ul>
							<div class="form-group">
								<label class="col-md-12">Caracteristicas</label>
								<ul class="row list-style-none text-left m-t-30">
        							
        							<li class="col-lg-6">
        							    
        								<span class="">Equipo</span>
        								<input type="text" name="equipoTitulo" id="equipoTitulo" value="Equipo" style="width:100%; font-weight: bold;" >
        								<input type="text" name="equipoDetalle" id="equipoDetalle"  style="width:100%" >
        									
        								
        							</li>
        							<li class="col-lg-6">
        							    
        								<span class="">Marca</span>
        								<input type="text" name="MarcaTitulo" id="MarcaTitulo" value="Marca" style="width:100%; font-weight: bold;" >
        								<input type="text" name="MarcaDetalle" id="MarcaDetalle"  style="width:100%" >
        									
        								
        							</li>
        							<li class="col-lg-6">
        							    
        								<span class="">Modelo</span>
        								<input type="text" name="ModeloTitulo" id="ModeloTitulo" value="Modelo" style="width:100%; font-weight: bold;" >
        								<input type="text" name="ModeloDetalle" id="ModeloDetalle"  style="width:100%" >
        									
        								
        							</li>
        							<li class="col-lg-6">
        							    
        								<span class="">Nro Serie</span>
        								<input type="text" name="NroSerieTitulo" id="NroSerieTitulo" value="Nro Serie" style="width:100%; font-weight: bold;" >
        								<input type="text" name="NroSerieDetalle" id="NroSerieDetalle"  style="width:100%" >
        									
        								
        							</li>
        							<li class="col-lg-6">
        							    
        								<span class="">Cod. inv</span>
        								<input type="text" name="CodInvTitulo" id="CodInvTitulo" value="Cod. inv" style="width:100%; font-weight: bold;" >
        								<input type="text" name="CodInvDetalle" id="CodInvDetalle"  style="width:100%" >
        									
        								
        							</li>
        							
        							
        						</ul>
							</div>	
							
        						<hr>
								<div class="form-group">
								
								<ul class="row list-style-none text-left m-t-30">
        							
        							<li class="col-lg-6">
        							    
        								<span class="">MANTENIMIENTO</span>
        								<input type="text" name="MantenimientoTitulo"   id="MantenimientoTitulo" value="MANTENIMIENTO" style="width:100%; font-weight: bold;" >
        								<input type="text" name="MantenimientoDetalle1" id="MantenimientoDetalle1"  style="width:100%" >
        								<input type="text" name="MantenimientoDetalle2" id="MantenimientoDetalle2"  style="width:100%" >
        								<input type="text" name="MantenimientoDetalle3" id="MantenimientoDetalle3"  style="width:100%" >
        								<input type="text" name="MantenimientoDetalle4" id="MantenimientoDetalle4"  style="width:100%" >
        								<input type="text" name="MantenimientoDetalle5" id="MantenimientoDetalle5"  style="width:100%" >
        									
        								
        							</li>
        							<li class="col-lg-6">
        							    
        								<span class="">CAMBIO DE PARTES Y PIEZAS DE REPUESTO</span>
        								<input type="text" name="CambioPartesTitulo"  id="CambioPartesTitulo" value="CAMBIO DE PARTES Y PIEZAS DE REPUESTO" style="width:100%; font-weight: bold;" >
        								<input type="text" name="CambioPartesDetalle" id="CambioPartesDetalle"  style="width:100%" >
        									
        								
        							</li>
        							<li class="col-lg-6">
        							    
        								<span class="">VERIFICACIÓN DE PARAMETROS DE DESEMPEÑO</span>
        								<input type="text" name="VerificacionTitulo"  id="VerificacionTitulo" value="VERIFICACIÓN DE PARAMETROS DE DESEMPEÑO" style="width:100%; font-weight: bold;" >
        								<input type="text" name="VerificacionDetalle" id="VerificacionDetalle"  style="width:100%" >
        									
        								
        							</li>
        							<li class="col-lg-6">
        							    
        								<span class="">TERMINOS COMERCIALES</span>
        								<input type="text" name="TerminosComercialesTitulo"  id="TerminosComercialesTitulo" value="TERMINOS COMERCIALES" style="width:100%; font-weight: bold;" >
        								<input type="text" name="TerminosComercialesDetalle1" id="TerminosComercialesDetalle"  style="width:100%" >
        								<input type="text" name="TerminosComercialesDetalle2" id="TerminosComercialesDetalle"  style="width:100%" >
        								<input type="text" name="TerminosComercialesDetalle3" id="TerminosComercialesDetalle"  style="width:100%" >
        									
        								
        							</li>
        						</ul>
							</div>	
        						<hr>
                         
        						<ul class="row list-style-none text-left m-t-30">
        							<li class="col-lg-3">
        								<span class=""><b>Monto Total</b> </span>
        								<input type="number" style="background-color: #E5F18F;" step="0.01" name="montototal" id="montototal" 
        									value="0.00" min="0" class="form-control" />
        							</li>


        						
        						</ul>
        						
        						<ul class="row list-style-none text-left m-t-30">
        							<li class="col-lg-4">
        
        								<button type="submit" class="btn btn-success">Guardar</button>
        							</li>
        						</ul>
        
        					</div>
        			</div>
        		</div>
        
        		<!-- Start Page Content -->
                <div class="col-lg-4" hidden>
        			<div class="card">
        			    <div class="card-body">
        					<h4 class="card-title">Productos </h4>
        					<button type="button" class="btn btn-primary" id="add_proucto" >Agregar producto</button>
        					<table class="table table-striped">
        					    <thead>
        					        <tr>
        					            <th>Nombre</th>
        					            <th>Cantidad</th>
        					            <th>Precio Uni.</th>
        					            <th>Monto</th>
        					            <th></th>
        					        </tr>
        					    </thead>
        					</table>
        				</div>
        			</div>
        		</div>
        	</div>
    	</div>
	</form>
    <style type="text/css">
        .modal-dialog{
            overflow-y: initial !important
        }
        .modal-body{
            max-height: calc(100vh - 200px);
            overflow-y: auto;
        }
         #vm_registrar_acabado {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place front is invalid - may break your css so removed */  
            padding-top: 100px; /* Location of the box - don't know what this does?  If it is to move your modal down by 100px, then just change top below to 100px and remove this*/
            left: 0;
            right:0; /* Full width (left and right 0) */
            top: 0;
            bottom: 0; /* Full height top and bottom 0 */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            z-index: 9999; /* Sit on top - higher than any other z-index in your site*/
        }
    </style>

	</div>
	
	</div>
	</div>
