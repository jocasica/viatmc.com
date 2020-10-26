<div class="page-wrapper" style="background-color: #D2E0F0;">
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-5">
                <h4 class="page-title">Guía de Remisión</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Guía de Remisión</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Crear</li>
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
    <form id="frm_guia" method="post" action="<?= base_url('remision/post') ?>">
        <input type="hidden" name="hid_motivo_traslado_codigo">
        <input type="hidden" name="hid_modalidad_transporte_codigo">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-11">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Registrar Guía de Remisión</h4>
                            <ul class="row list-style-none text-left m-t-30">
                                <li class="col-lg-2">
                                    <span>Serie</span>
                                    <select name="serie" class="form-control" required >
                                        <?php foreach ($serie as $item){
                                            echo '<option value="'.$item.'">'.$item.'</option>';
                                        } ?>
                                    </select>
                                </li>
                                <li class="col-lg-2">
                                    <span>Numero</span>
                                    <input type="text" value="<?php echo $correlativo; ?>" readonly name="numero"
                                           class="form-control" required />
                                </li>
                                <li class="col-lg-4">
                                    <span>Fecha Emisión</span>
                                    <input type="date" value="<?php echo date('Y-m-d'); ?>" name="fecha"
                                           placeholder="yyyy-mm-dd" class="form-control" required />
                                </li>
                                <li class="col-lg-4">
                                    <span>Fecha Inicio traslado</span>
                                    <input type="date" value="<?php echo date('Y-m-d'); ?>" id="fecha_inicio_traslado"
                                           name="fecha_inicio_traslado" placeholder="yyyy-mm-dd" class="form-control"
                                           required />
                                </li>
                            </ul>
                            <hr>
                            <label class="card-subtitle ">DATOS DEL TRASLADO</label>
                            <ul class="row list-style-none text-left m-t-5">
                                <li class="col-lg-6">
                                    <span class="">Motivo traslado</span>
                                    <select type="text" name="motivo_traslado" id="motivo_traslado"
                                            class="form-control">
                                        <option data-codigo_sunat="01" selected="selected" value="Venta">Venta</option>
                                        <option data-codigo_sunat="02" value="Compra">Compra</option>
                                        <option data-codigo_sunat="04"
                                                value="Traslado entre establecimientos de la misma empresa">Traslado entre
                                            establecimientos de la misma empresa</option>
                                        <option data-codigo_sunat="14"
                                                value="VENTA SUJETA A CONFIRMACION DEL COMPRADOR">VENTA SUJETA A
                                            CONFIRMACION DEL COMPRADOR</option>
                                        <option data-codigo_sunat="18"
                                                value="Traslado emisor itinerante de comprobantes de pago">Traslado emisor
                                            itinerante de comprobantes de pago</option>
                                        <option data-codigo_sunat="19" value="Traslado a zona primaria">Traslado zona
                                            primaria</option>
                                        <option data-codigo_sunat="08" value="Importacion">Importacion</option>
                                        <option data-codigo_sunat="09" value="Exportacion">Exportacion</option>
                                        <option data-codigo_sunat="13" value="Otros motivos">Otros motivos</option>
                                    </select>
                                </li>


                                <li class="col-lg-6">
                                    <span class="">Peso Bruto Total de la Guia (KGM)</span>
                                    <input type="number" name="peso_bruto" id="peso_bruto" style="width:100%" required>
                                </li>
                                <li class="col-lg-6">
                                    <span class="">Observaciones</span>
                                    <input type="text" name="observacion" id="observacion" style="width:100%" required>
                                </li>
                            </ul>
                            <hr>
                            <label class="card-subtitle ">DATOS DEL CLIENTE</label>
                            <ul class="row list-style-none text-left m-t-5">
                                <li class="col-lg-6">
                                    <div class="form-group has-feedback has-feedback-left">
                                        <label><i class="icon-user position-left"></i> Tipo de Documento: <span
                                                class="text-danger">*</span></label>
                                        <select name="cliente_tipo_documento" id="cliente_tipo_documento"
                                                title="Selecciona el Tipo de Documento" class="form-control" required>
                                            <option value='6'>RUC</option>
                                            <option value='1'>DNI</option>
                                        </select>
                                    </div>
                                </li>

                                <li class="col-lg-6">
                                    <label><i class="icon-user position-left"></i> &nbsp;</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" aria-describedby="basic-addon2"
                                               name="cliente_numero_documento" id="cliente_numero_documento"
                                               placeholder="###########" maxlength="11">
                                        <div class="input-group-append">
                                            <button type="button" id="btn_buscar_cliente" class="btn btn-default"><i
                                                    class="fa fa-search"></i> Buscar</button> </div>
                                    </div>
                                </li>
                                <li class="col-lg-6 ">
                                    <span class="">Razon social/Nombre</span>
                                    <input type="text" name="cliente_nombre" id="cliente_nombre" class="form-control"
                                           style="width:100%" required>
                                </li>
                            </ul>
                            <hr>
                            <label class="card-subtitle ">DATOS TRANSPORTISTA</label>
                            <ul class="row list-style-none text-left m-t-5">
                                <li class="col-lg-6">
                                    <span class="">Modalidad de transporte</span>
                                    <select type="text" name="modalidad_transporte" id="modalidad_transporte"
                                            class="form-control">
                                        <option data-codigo_sunat="02" selected="selected" value="Transporte privado">
                                            Transporte privado</option>
                                        <option data-codigo_sunat="01" value="Transporte publico">Transporte publico
                                        </option>
                                    </select>
                                </li>
                                <li class="col-lg-6">
                                    <span class="">RUC</span>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" aria-describedby="basic-addon2"
                                               name="transportista_ruc" id="transportista_ruc" placeholder="###########"
                                               maxlength="11">
                                        <div class="input-group-append">
                                            <button type="button" id="btn_buscar_transportista"
                                                    class="btn btn-default"><i class="fa fa-search"></i> Buscar</button>
                                        </div>
                                    </div>
                                </li>
                                <li class="col-lg-6">
                                    <div class="form-group has-feedback has-feedback-left">
                                        <span class="">Razón Social</span>
                                        <input type="text" name="transportista_nombre" id="transportista_nombre"
                                               class="form-control" style="width:100%" required>
                                    </div>
                                </li>
                                <li class="col-lg-6">
                                    <div class="form-group has-feedback has-feedback-left">
                                        <span class="">Dirección</span>
                                        <input type="text" name="transportista_direccion" id="transportista_direccion"
                                               class="form-control" style="width:100%" required>
                                    </div>
                                </li>
                            </ul>
                            <hr>
                            <label class="card-subtitle ">DATOS CONDUCTOR</label>
                            <ul class="row list-style-none text-left m-t-5">
                                <li class="col-lg-6">
                                    <div class="form-group has-feedback has-feedback-left">
                                        <label><i class="icon-user position-left"></i> Tipo de Documento: <span
                                                class="text-danger">*</span></label>
                                        <select name="conductor_tipo_documento" id="conductor_tipo_documento"
                                                class="form-control">
                                            <option value="1">DNI</option>
                                            <option value="4">CARNET DE EXTRANJERIA</option>
                                            <option value="7">PASAPORTE</option>
                                        </select>
                                    </div>
                                </li>
                                <li class="col-lg-6">
                                    <label>
                                        Documento del chofer
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="conductor_documento" id="conductor_documento"
                                           class="form-control" style="width:100%" required>
                                </li>
                                <li class="col-lg-6">
                                    <span class="">Nombre del chofer</span>
                                    <input type="text" name="conductor_nombre" id="conductor_nombre"
                                           class="form-control" style="width:100%" value="-">
                                </li>
                                <li class="col-lg-6">
                                    <span class="">Licencia</span>
                                    <input type="text" name="conductor_licencia" id="conductor_licencia"
                                           class="form-control" style="width:100%" value="-">
                                </li>
                            </ul>
                            <hr>
                            <label class="card-subtitle ">PUNTO DE PARTIDA:</label>
                            <ul class="row list-style-none text-left m-t-5">
                                <li class="col-lg-6">
                                    <span class="">Punto de partida</span>
                                    <input type="hidden" name="departamento_partida" id="departamento_partida">
                                    <input type="hidden" name="provincia_partida" id="provincia_partida">
                                    <input type="hidden" name="distrito_partida" id="distrito_partida">
                                    <input type="text" name="ubigeo_partida" id="ubigeo_partida" style="width:100%"
                                           placeholder="Ubigeo" readonly="">
                                    <select name="sel_departamento_partida" id="sel_departamento_partida"
                                            class="form-control input-sm" required>
                                        <option>Seleccione</option>
                                    </select>
                                    <select name="sel_provincia_partida" id="sel_provincia_partida"
                                            class="form-control input-sm" required>
                                    </select>
                                    <select name="sel_distrito_partida" id="sel_distrito_partida"
                                            class="form-control input-sm" required>
                                    </select>
                                </li>
                                <li class="col-lg-6">
                                    <span class="">Direccion de partida</span>
                                    <input type="text" name="direccion_partida" id="direccion_partida"
                                           style="width:100%" placeholder="Dirección de partida" required>
                                </li>
                            </ul>
                            <hr>
                            <label class="card-subtitle ">PUNTO DE LLEGADA:</label>
                            <ul class="row list-style-none text-left m-t-5">
                                <li class="col-lg-6">
                                    <span class="">Punto de llegada</span>
                                    <input type="hidden" name="departamento_llegada" id="departamento_llegada">
                                    <input type="hidden" name="provincia_llegada" id="provincia_llegada">
                                    <input type="hidden" name="distrito_llegada" id="distrito_llegada">
                                    <input type="text" name="ubigeo_llegada" id="ubigeo_llegada" style="width:100%"
                                           placeholder="Ubigeo" readonly="">
                                    <select name="sel_departamento_llegada" id="sel_departamento_llegada"
                                            class="form-control input-sm" required>
                                        <option>Seleccione</option>
                                    </select>
                                    <select name="sel_provincia_llegada" id="sel_provincia_llegada"
                                            class="form-control input-sm" required>
                                    </select>
                                    <select name="sel_distrito_llegada" id="sel_distrito_llegada"
                                            class="form-control input-sm" required>
                                    </select>
                                </li>
                                <li class="col-lg-6">
                                    <span class="">Direccion de llegada</span>
                                    <input type="text" name="direccion_llegada" id="direccion_llegada"
                                           style="width:100%" placeholder="Dirección de llegada" required>
                                </li>
                            </ul>
                            <hr>
                            <label class="card-subtitle ">DATOS DE VEHICULO:</label>
                            <ul class="row list-style-none text-left m-t-5">
                                <li class="col-lg-6">
                                    <span class="">Descripción del vehiculo</span>
                                    <input type="text" name="vehiculo_descripcion" id="vehiculo_descripcion"
                                           style="width:100%" value="-">
                                </li>
                                <li class="col-lg-6">
                                    <span class="">Placa del vehiculo</span>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="vehiculo_placa" id="vehiculo_placa" style="width:100%"
                                           required>
                                </li>
                                <li class="col-lg-6">
                                    <span class="">Certif. Inscripción</span>
                                    <input type="text" name="vehiculo_certificado" id="vehiculo_certificado"
                                           style="width:100%" value="-">
                                </li>
                                <li class="col-lg-6">
                                    <span class="">Conf. Vehicular</span>
                                    <input type="text" name="vehiculo_configuracion" id="vehiculo_configuracion"
                                           style="width:100%" value="-">
                                </li>
                                <li class="col-lg-2">
                                    <span class="">.</span>
                                    <button type="button" class="btn btn-primary" id="add_producto" data-toggle="modal" data-target="#vm_add_producto">Agregar
                                        producto</button>
                                </li>
                            </ul>
                            <ul class="row list-style-none text-left m-t-30">
                                <table class="table table-striped table-responsive">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Cod. bien</th>
                                            <th>Descripcion</th>
                                            <th>Unidad medida</th>
                                            <th>Cantidad</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody_producto_remision"></tbody>
                                </table>
                            </ul>
                            <!--
    <hr>

<ul class="row list-style-none text-left m-t-30">
        <li class="col-lg-8">
            <span class=""><b>DISENO</b></span>
            <select type="text" name="diseno" id="diseno" class="form-control">
                <option value="NO">NO</option>
                <option value="SI">SI</option>
            </select>
        </li>
        <li class="col-lg-4">
            <span class="">Monto x Diseno</span>
            <input type="number" value="0.00" style="background-color: #ECB4A8;" name="montodiseno" id="montodiseno"
                readonly min="0" class="form-control" />
        </li>
    </ul>
    <hr>-->
                            <!--                  -->
                            <hr>



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
                            <button type="button" class="btn btn-primary" id="add_proucto">Agregar producto</button>
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
</div>
<div id="vm_add_producto" class="modal fade" style="display:none">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h6 class="modal-title" style="color:white">Agregar Producto</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-material" id="frm-add-producto-remision" method="post"
                      enctype="multipart/form-data">
                    <input type="hidden" id="productId" value="0" name="productId">
                    <div class="form-group">
                        <label class="col-md-12">Codigo bien</label>
                        <div class="col-md-12">
                            <input type="text" id="cod" style="width: 100%" name="cod" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">Descripcion</label>
                        <div class="col-md-12">
                            <textarea name="descripcion" id="descripcion" cols="58" rows="3"></textarea>
                            <!-- <input type="text" id="descripcion" style="width: 100%" name="descripcion" class="form-control" required /> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">Cantidad</label>
                        <div class="col-md-12">
                            <input type="number" id="cantidad" name="cantidad" class="form-control form-control-line"
                                   min="0" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">Unidad Medida</label>
                        <div class="col-md-12">
                            <select type="text" id="unidad_medida" name="unidad_medida" class="form-control">
                                <option value="Kilogramos">Kilogramos</option>
                                <option value="Litros">Litros</option>
                                <option value="Galones">Galones</option>
                                <option value="NIU" selected="selected">NIU</option>
                            </select>
                            <!-- <input type="text" id="unidad_medida" name="unidad_medida" class="form-control form-control-line"  required> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button class="btn btn-success" type="submit">Agregar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
