<!-- viatmc styles -->
<link rel="stylesheet" href="<?php echo base_url() . 'css/viatmc/viatmc.css'; ?>">

<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!--div class="page-breadcrumb">
		<div class="row align-items-center">
			<div class="col-5">
				<h4 class="page-title">Compras</h4>
				<div class="d-flex align-items-center">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#">Compras</a></li>
							<li class="breadcrumb-item active" aria-current="page">Registrar compra</li>
						</ol>
					</nav>
				</div>
			</div>
			<div class="col-7">
				<div class="text-right upgrade-btn">
				</div>
			</div>
		</div>
	</div-->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <!-- Row -->

        <div class="row">
            <!-- Column -->
            <div class="col-lg-12 col-xlg-12 col-md-12">
                <form action="" id="form_nota_credito" method="post">
                    <div class="card">
                        <div class="card-body">
                            <!-- title -->
                            <div class="d-md-flex align-items-center">
                                <div>
                                    <h4 class="card-title">Registrar Nota de credito</h4>
                                    <h5 class="card-subtitle" hidden>Overview of Top Selling Items</h5>
                                </div>
                                <div class="ml-auto">
                                    <div class="dl">
                                        <h4 class="m-b-0 font-16"></h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end title -->

                            <!-- body -->
                            <div class="row">
                                <div hidden class="col-md-2 form-group">
                                    <label for="serie">ID</label>
                                    <input type="text" id="id_nota_credito" name="id_nota_credito" value="<?= $id ?>" class="form-control form-control-line" maxlength="4" required readonly>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label for="serie">Serie de comp.</label>
                                    <input type="text" id="serie_nota_credito" name="serie_nota_credito" value="FC01" class="form-control form-control-line" maxlength="4" required readonly>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="numero">Número de comprobante</label>
                                    <input type="number" id="numero_nota_credito" name="numero_nota_credito" value="<?= $numeros[2]->numero ?>" class="form-control form-control-line" min="1" max="999999" required readonly>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="fecha">Fecha de Emisión</label>
                                    <input type="date" id="fecha_nota_credito" name="fecha_nota_credito" value="<?php echo date('Y-m-d'); ?>" class="form-control form-control-line" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="motivo_nota_credito">Motivo</label>
                                    <!-- data-placeholder="Escriba el nombre o número del documento del cliente" -->
                                    <select name="motivo_nota_credito" id="motivo_nota_credito" class="form-control" required>
                                        <option value="01">ANULACION DE LA OPERACION</option>
                                        <option value="02">ANULACION POR ERROR EN EL RUC</option>
                                        <option value="03">CORRECCION POR ERROR EN LA DESCRIPCION</option>
                                        <option value="04">DESCUENTO GLOBAL</option>
                                        <option value="05">DESCUENTO POR ITEM</option>
                                        <option value="06">DEVOLUCION TOTAL</option>
                                        <option value="07">DEVOLUCION POR ITEM</option>
                                        <option value="08">BONIFICACION</option>
                                        <option value="09">DISMINUCION EN EL VALOR</option>
                                    </select>
                                    <!-- <?php #echo form_dropdown(['name'=>'', 'class'=>'form-control proveedor_select2', 'required'=>'required', 'id'=>'proveedor'],[''=>'(SELECCIONAR)']+$proveedores); 
                                            ?> -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="serie">Descripcion</label>
                                    <input type="text" id="descripcion_nota_credito" name="descripcion_nota_credito" value="" class="form-control form-control-line" required>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-2 form-group">
                                    <label for="serie">Serie modificado</label>
                                    <input type="text" id="serie_nota_credito_modificado" name="serie_nota_credito_modificado" value="<?= $data_venta->serie ?>" class="form-control form-control-line" maxlength="4" required readonly>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label for="numero">Número modificado</label>
                                    <input type="number" id="numero_nota_credito_modificado" name="numero_nota_credito_modificado" value="<?= str_pad($data_venta->numero, 8, "0", STR_PAD_LEFT) ?>" class="form-control form-control-line" min="1" max="999999" required readonly>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="serie">Cliente</label>
                                    <input type="text" id="cliente_nota_credito" name="cliente_nota_credito" value="<?= $data_venta->cliente ?>" class="form-control form-control-line" maxlength="4" required readonly>
                                </div>

                                <div class="col-md-2 form-group text-center">
                                    <label for="">&nbsp;</label><br>
                                    <button class="btn btn-info" data-toggle="modal" data-target="#modal_form_add_producto_nota_credito" type="button"><i class="fa fa-plus"></i> Agregar Producto</button>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <!-- <div class="col-md-12 form-group">
									<label for="moneda">Moneda</label>
									<select name="moneda" value="" id="moneda" class="form-control form-control-line" required>
											<option value="SOLES">SOLES</option>
											<option value="DOLARES">DOLARES</option>
									</select>
								</div> -->
                            <div class="col-md-4 form-group" id="div_tipo_cambio" hidden>
                                <label for="tipocambio">Tipo de cambio</label>
                                <input type="number" name="tipocambio" id="tipocambio" value="" class="form-control" step=".0001" min="0.0001" max="9999999" />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="table_nota_credito">
                                    <thead class="thead-light">
                                        <tr>

                                            <th width="20%">Codigo</th>
                                            <th>Descripcion</th>
                                            <th>Und/Medida</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Sub. Total</th>
                                            <th>Igv</th>
                                            <th>Importe</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_nota_credito_body">
                                        <?php foreach ($detalle_venta as $vp) :   ?>
                                            <?php $igv = 0;
                                            $total = 0;
                                            $igv = ($vp->precio_unidad * $vp->cantidad) - $vp->subtotal;
                                            $total = $vp->precio_unidad * $vp->cantidad;
                                            $igv = number_format($igv, 2, '.', '');
                                            $total = number_format($total, 2 ,'.', '');
                                            ?>
                                            <tr>
                                                <td><?= $vp->producto_id ?></td>
                                                <td><?= $vp->texto_ref ?></td>
                                                <td><?= $vp->unidad_medidad_descripcion ?></td>
                                                <td><?= number_format($vp->precio_unidad, 2,'.', '') ?></td>
                                                <td><?= number_format($vp->cantidad, 2,'.', '') ?></td>
                                                <td><?= number_format($vp->subtotal, 2,'.', '') ?></td>
                                                <td><?= $igv  ?></td>
                                                <td><?= $total ?></td>

                                                <td><a href="" class="delete"> Eliminar</a></td>
                                                <td hidden>
                                                <div class="form-group">
                                                    <input name="producto_id_detalle[]" value="<?= $vp->producto_id ?>" >
                                                    <input name="texto_ref_detalle[]" value="<?= $vp->texto_ref ?>" >
                                                    <input name="precio_unidad_detalle[]" value="<?= $vp->precio_unidad ?>" >
                                                    <input name="cantidad_detalle[]" value="<?= $vp->cantidad ?>" >
                                                    <input name="subtotal_detalle[]" value="<?= $vp->subtotal ?>" >
                                                    <input name="igv_detalle[]" value="<?= $igv ?>" >
                                                    <input name="importe_detalle[]" value="<?= $total ?>" >

                                                </div>
                                                </td>
                                            <?php endforeach;
                                            ?>
                                            </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="subtotal_nota_credito">Sub total.</label>
                                <input type="text" id="subtotal_nota_credito" name="subtotal_nota_credito" value="0" class="form-control form-control-line" required readonly>
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="igv_nota_credito">IGV.</label>
                                <input type="text" id="igv_nota_credito" name="igv_nota_credito" value="0" class="form-control form-control-line" required readonly>
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="total_nota_credito">Total.</label>
                                <input type="text" id="total_nota_credito" name="total_nota_credito" value="0" class="form-control form-control-line" required readonly>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-12 form-group">
                                <label for="total_letras_nota_credito">Total letras</label>
                                <input type="text" id="total_letras_nota_credito" name="total_letras_nota_credito" value="" class="form-control form-control-line" required readonly>
                            </div>

                        </div>

                        <div class="form-group text-right">
                            <div class="col-sm-12">
                                <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Guardar Nota de crédito</button>
                            </div>
                        </div>
                    </div>
            </div>
            </form>
        </div>
        <!-- Column -->
    </div>

</div>
<!-- Modal adicionar producto -->
<div id="modal_form_add_producto_nota_credito" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Agregar Artículo</h6>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="alert alert-success alert-styled-left alert-arrow-left alert-bordered">
                        Elige el producto y escribe la cantidad o el monto final.
                    </div>
                </div>
                <form action="#" id="frm_producto_nota_credito" method="get" accept-charset="utf-8">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="producto_codigo_nota_credito">Codigo</label>
                            <input type="text" class="form-control" value="" name="producto_codigo_nota_credito" id="producto_codigo_nota_credito" disabled="disabled" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="producto_unidadmedida">Und/Medida</label>
                            <input type="text" class="form-control" value="" name="producto_unidadmedida_nota_credito" id="producto_unidadmedida_nota_credito" disabled="disabled" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Producto</label>
                            <select class="buscar form-control valid select2" name="producto_descripcion_nota_credito" id="producto_descripcion_nota_credito" required>
                                <option selected disabled>-- SELECCIONE --</option>
                                <?php foreach ($prods as $p) { ?>
                                    <option value="<?= $p->contador ?>">
                                        <?= $p->nombre . ' - ' . $p->codigo_barra ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-12" id="descripcionExtra">
                            <label for="producto_unidadmedida">Detalle</label>
                            <textarea name="producto_descripcionExtra_nota_credito" id="producto_descripcionExtra_nota_credito" class="form-control"></textarea>
                            <!-- <input type="text" class="form-control" value="" name="producto_descripcionExtra" id="producto_descripcionExtra"  required> -->
                        </div>
                        <div class="form-group col-md-6">
                            <label for="producto_preciounidad">Precio U.(Inc.IGV)</label>
                            <input type="number" class="form-control" step="0.00001" name="producto_preciounidad_nota_credito" id="producto_preciounidad_nota_credito" readonly="true" placeholder="0.00" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="producto_cantidad">Cantidad</label>
                            <input type="text" class="form-control" value="1" name="producto_cantidad_nota_credito" id="producto_cantidad_nota_credito" readonly="true" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="producto_subtotal">Sub.Total</label>
                            <input type="text" class="form-control" value="" name="producto_subtotal_nota_credito" id="producto_subtotal_nota_credito" disabled="disabled" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="producto_igv">IGV (18%)</label>
                            <input type="text" class="form-control" value="" name="producto_igv_nota_credito" id="producto_igv_nota_credito" disabled="disabled" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="producto_total">Total</label>
                            <input type="text" class="form-control" value="" name="producto_total_nota_credito" id="producto_total_nota_credito" disabled="disabled" required>
                        </div>
                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-success ">Agregar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<!-- jquery -->
<script src="https://code.jquery.com/jquery-3.5.0.min.js" charset="utf-8"></script>
<!-- Sweet Alert 2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script type="text/javascript" src="<?= base_url('') ?>plantilla/js/numeros_a_letras.js?v=<?php echo strtotime("now"); ?>"></script>
<!-- viatmc scripts -->
<script src="<?php echo base_url() . 'js/viatmc/viatmc.js'; ?>"></script>

<script>
$('document').ready(function(){
    $(function() {
        calcular_totales_documento_nota_credito();
        $('#producto_descripcion_nota_credito').on('change', function() {
            var i = $(this).val();
            if (i != "") {

                var prods = <?php echo json_encode($prods) ?>;
                console.log(prods[i]);
                $("#producto_codigo_nota_credito").val(prods[i]["producto_id"]);
                $("#codigo_producto_nota_credito").val(prods[i]["codigo_producto"]);
                $("#producto_unidadmedida_nota_credito").val(prods[i]["unidad_medida"]);
                $("#producto_preciounidad_nota_credito").val(prods[i]["precio_venta"]);
                calcular_totales_producto_nota_credito();
                $('#producto_igv_nota_credito').val(0);
                $('#producto_subtotal_nota_credito').val(0);
                $('#producto_cantidad_nota_credito').val(0);
                $('#producto_total_nota_credito').val(0);
                $('#producto_cantidad_nota_credito').attr('readonly', false);
                $('#producto_preciounidad_nota_credito').attr('readonly', false);
            } else {
                $("#producto_codigo_nota_credito").val("");
                $("#producto_unidadmedida_nota_credito").val("");
                $("#producto_preciounidad_nota_credito").val("");
                $("#producto_subtotal_nota_credito").val("");
                $("#producto_igv_nota_credito").val("");
                $("#producto_total_nota_credito").val("");
            }
        });

        function calcular_totales_producto_nota_credito() {
            var igv_percent = parseFloat((18 / 100) + 1);
            var precioarticulo = 0;
            var cantidad = 0;

            if ($('#producto_preciounidad_nota_credito').val() == '' || $('#producto_preciounidad_nota_credito').val() <= 0 || isNaN($('#producto_preciounidad_nota_credito').val())) {
                precioarticulo = 0;
            } else {
                precioarticulo = parseFloat($('#producto_preciounidad_nota_credito').val());
            }

            if ($('#producto_cantidad_nota_credito').val() == '' || $('#producto_cantidad_nota_credito').val() <= 0 || isNaN($('#producto_cantidad_nota_credito').val())) {
                cantidad = 0;
            } else {
                cantidad = parseFloat($('#producto_cantidad_nota_credito').val());
            }

            var total = round_math(parseFloat(precioarticulo) * parseFloat(cantidad), 2);
            var subtotal = parseFloat(total) / parseFloat(igv_percent);
            var igv = parseFloat(total) - parseFloat(subtotal);

            $('#producto_subtotal_nota_credito').val(round_math(subtotal, 2));
            $('#producto_igv_nota_credito').val(round_math(igv, 2));
            $('#producto_total_nota_credito').val(round_math(total, 2));
        }

        function round_math(numero, decimales) {
            var flotante = parseFloat(numero);
            var resultado = Math.round(flotante * Math.pow(10, decimales)) / Math.pow(10, decimales);
            return resultado;
        }
        $('#modal_form_add_producto_nota_credito').on('hidden.bs.modal', function() {
            $('#producto_cantidad_nota_credito').val(0);
            $('#producto_cantidad_nota_credito').attr('readonly', true);
            $('#producto_preciounidad_nota_credito').val(0);
            $('#producto_preciounidad_nota_credito').attr('readonly', true);
            $('#producto_unidadmedida_nota_credito').val("");
            $('#producto_codigo_nota_credito').val("");
            $('#producto_descripcionExtra_nota_credito').val("");
            $('#producto_preciounidad_nota_credito').val("");
            $('#producto_cantidad_nota_credito').val("");
            $('#producto_subtotal_nota_credito').val("");
            $('#producto_igv_nota_credito').val("");
            $('#producto_total_nota_credito').val("");

        })
        $("#producto_preciounidad_nota_credito").on('input', function() {
            calcular_totales_producto_nota_credito();
        }).on('change', function() {
            calcular_totales_producto_nota_credito();
        });

        $("#producto_cantidad_nota_credito").on('input', function() {
            calcular_totales_producto_nota_credito();
        }).on('change', function() {
            calcular_totales_producto_nota_credito();
        });

        $("#frm_producto_nota_credito").submit(function(e) {
            e.preventDefault();
            add_to_detalle_nota_credito();
            $('#producto_subtotal_nota_credito').val(0);
            $('#producto_cantidad_nota_credito').val(0);
            $('#producto_total_nota_credito').val(0);
            $('#producto_cantidad_nota_credito').attr('readonly', true);
            $('#producto_preciounidad_nota_credito').attr('readonly', true);
        });

        $("#form_nota_credito").submit(function(e) {
            e.preventDefault();
            var datastring = $("#form_nota_credito").serializeArray();
            var i = 0;
            var rowData;
            var datadetalle = [];
            var rows = document.getElementById('table_nota_credito_body').rows.length;
            if ($("#total_nota_credito").val() == 0 || $("#subtotal_nota_credito").val() == 0 || $("#igv_nota_credito").val() == 0) {
                mensajeDeError('Corriga los totales');
                return false;
            }
            if (rows <= 0) {
                mensajeDeError('Debe insertar un detalle al producto como mínimo.');
                return false;
            } else {
                var table = document.getElementById('table_nota_credito_body');
                detalle = {};

                datastring.push({
                    name: 'datadetalle',
                    value: JSON.stringify(datadetalle)
                });
                $.ajax({
                    url: "<?php echo base_url('venta/post_nota_credito'); ?>",
                    method: 'POST',
                    dataType: "json",
                    data: datastring,
                    beforeSend: function() {
                        $.blockUI({
                            css: {
                                border: 'none',
                                padding: '15px',
                                backgroundColor: '#000',
                                '-webkit-border-radius': '10px',
                                '-moz-border-radius': '10px',
                                opacity: .5,
                                color: '#fff'
                            }
                        });
                    },
                    complete: function(data) {
                        $.unblockUI();
                        console.log(data);
                    },
                    error: function(xhr, textStatus, error) {
                        console.log(xhr.statusText);
                        console.log(textStatus);
                        console.log(error);
                        mensajeDeError('Hubo un error');
                    },
                }).then(function(data) {

                    mensajeSuccess('Se guardó correctamente.');
                    console.log(data);

                });
            }
        });


        function add_to_detalle_nota_credito() {
            if ($("#producto_subtotal_nota_credito").val() == 0 || $("#producto_igv_nota_credito").val() == 0 || $("#producto_total_nota_credito").val() == 0 || $("#producto_cantidad_nota_credito").val() == 0) {
                mensajeDeError('No puede agregar totales de valor 0');
                return false;
            }
            var table = document.getElementById("table_nota_credito_body");

            for (var i = 0; i < table.rows.length; i++) {
                if ($("#producto_codigo_nota_credito").val() == table.rows[i].cells[0].innerHTML) {
                    mensajeDeError('No puedes agregar dos productos con el mismo id');

                    $('#producto_unidadmedida_nota_credito').val("");
                    $('#producto_codigo_nota_credito').val("");
                    $('#producto_descripcionExtra_nota_credito').val("");
                    $('#producto_preciounidad_nota_credito').val("");
                    $('#producto_cantidad_nota_credito').val("");
                    $('#producto_subtotal_nota_credito').val("");
                    $('#producto_igv_nota_credito').val("");
                    $('#producto_total_nota_credito').val("");
                    return false;
                }
            }

            $('#table_nota_credito_body').append(
                '<tr>' +
                '<td>' + $("#producto_codigo_nota_credito").val() + '</td>' +
                '<td>' + $("#producto_descripcionExtra_nota_credito").val() + '</td>' +
                '<td>' + $("#producto_unidadmedida_nota_credito").val() + '</td>' +
                '<td>' + $("#producto_preciounidad_nota_credito").val() + '</td>' +
                '<td>' + $("#producto_cantidad_nota_credito").val() + '</td>' +
                '<td>' + $("#producto_subtotal_nota_credito").val() + '</td>' +
                '<td>' + $("#producto_igv_nota_credito").val() + '</td>' +
                '<td>' + $("#producto_total_nota_credito").val() + '</td>' +

                '<td>' +
                '<a href="" class="delete"> Eliminar</a>' +
                '<div class="form-group"></div>' +
                '<input name="producto_id_detalle[]" value="' + $('#producto_codigo_nota_credito').val() + '" hidden>' +
                '<input name="texto_ref_detalle[]" value="' + $('#producto_descripcionExtra_nota_credito').val() + '" hidden>' +
                '<input name="precio_unidad_detalle[]" value="' + $('#producto_preciounidad_nota_credito').val() + '" hidden>' +
                '<input name="cantidad_detalle[]" value="' + $('#producto_cantidad_nota_credito').val() + '"hidden >' +
                '<input name="subtotal_detalle[]" value="' + $('#producto_subtotal_nota_credito').val() + '" hidden>' +
                '<input name="igv_detalle[]" value="' + $('#producto_igv_nota_credito').val() + '" hidden>' +
                '<input name="importe_detalle[]" value="' + $('#producto_total_nota_credito').val() + '" hidden>' +

                '</div></td>' +
                '</tr>');

            $('#producto_unidadmedida_nota_credito').val("");
            $('#producto_codigo_nota_credito').val("");
            $('#producto_descripcionExtra_nota_credito').val("");
            $('#producto_preciounidad_nota_credito').val("");
            $('#producto_cantidad_nota_credito').val("");
            $('#producto_subtotal_nota_credito').val("");
            $('#producto_igv_nota_credito').val("");
            $('#producto_total_nota_credito').val("");
            calcular_totales_documento_nota_credito();
            $("#modal_form_add_producto_nota_credito").modal("hide");
        }

        function calcular_totales_documento_nota_credito() {
            var table = document.getElementById("table_nota_credito_body"),
                sumVal = 0;


            for (var i = 0; i < table.rows.length; i++) {
                sumVal = sumVal + parseFloat(table.rows[i].cells[7].innerHTML);
            }
            $('#total_nota_credito').val(round_math(sumVal, 2));
            var igv = sumVal * 18 / 118;
            $('#igv_nota_credito').val(round_math(igv, 2));
            var subTotal = sumVal - igv;
            $('#subtotal_nota_credito').val(round_math(subTotal, 2));
            var numletras = NumeroALetras(sumVal);
            $("#total_letras_nota_credito").val(numletras);

        }
        $('#table_nota_credito_body').on('click', '.delete', function(e) {
            e.preventDefault();
            $(this).parents('tr').remove();
            calcular_totales_documento_nota_credito()
        });
        //Mensajes de advertencia
        function mensajeDeError(mensaje) {
            Swal.fire({
                title: 'ERROR',
                text: mensaje,
                type: "error",
                confirmButtonText: "Ok",
                confirmButtonColor: "#2196F3"
            }, function() {
                // $("#icon_search_document").show();
                //  $("#icon_searching_document").hide();
                //  $(".search_document").prop('disabled', false);
            });
        }


        function mensajeSuccess(mensaje) {
            Swal.fire({
                title: 'CORRECTO',
                text: mensaje,
                type: "success",
                showCancelButton: true,
                focusConfirm: true,
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#2196F3",
                cancelButtonText: "Volver a pagina anterior",
                cancelButtonColor: '#d33',
                allowOutsideClick: false
            }).then((result) => {
                if (result.value) {
                    window.history.go(-1);
                } else if (
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    window.history.go(-1);
                }

            });
        }

       
    });});
</script>