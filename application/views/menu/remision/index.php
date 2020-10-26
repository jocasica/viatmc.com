<div class="page-wrapper" style="background-color: #D2E0F0;">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-5">
                <h4 class="page-title">Remisiones</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Remisiones</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Lista de Remisiones</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-7">
                <div class="text-right upgrade-btn">
                    <a href="<?= base_url('remision/create') ?>" class="btn btn-danger text-white">Registrar Remision</a>
                </div>
            </div>
        </div>
    </div>
    <div id="vm_ver_productos_remision" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title" style="color:white">Productos de la remision</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="col-md-12">
                        <div hidden class="alert alert-success alert-styled-left alert-arrow-left alert-bordered">
                            Agregue la serie del producto comprado.
                        </div>
                    </div>
                    <table class="table v-middle" id="body_tbl_remision">
                        <thead>
                            <tr class="bg-light">
                                <th class="border-top-0">ID</th>
                                <th class="border-top-0">Codigo Producto</th>
                                <th class="border-top-0">Descripcion</th>
                                <th class="border-top-0">Unidad medida</th>
                                <th class="border-top-0">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
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
                                <h4 class="card-title">Lista de Remisiones</h4>
                                <h5 class="card-subtitle" hidden>Overview of Top Selling Items</h5>
                            </div>
                            <div class="ml-auto">
                                <div class="dl">
                                    <h4 class="m-b-0 font-16"></h4>
                                </div>
                            </div>
                        </div>
                        <!-- title -->
                        <div class="table-responsive">
                            <table class="table v-middle" id="tabla_lista_guias_remision">
                                <thead>
                                    <tr class="bg-light">
                                        <!--<th class="border-top-0">Serie</th>-->
                                        <th class="border-top-0" hidden>Id</th>
                                        <th class="border-top-0">Serie</th>
                                        <th class="border-top-0">Numero</th>
                                        <th class="border-top-0" width="10%">Fecha remision</th>
                                        <th class="border-top-0">Destinatario</th>
                                        <th>Factura</th>
                                        <th class="border-top-0">RUC</th>
                                        <th class="border-top-0">Opciones</th>
                                        <th class="border-top-0" width="15%">Subida de documentos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // print_r($cots);
                                    // die;
                                    ?>
                                    <?php
                                    foreach ($cots as $c) {
                                        if ($c->estado == 1) {
                                    ?>
                                            <tr>
                                                <td hidden>
                                                    <h5 class="m-b-0"><?= $c->id ?></h5>
                                                </td>
                                                <td>
                                                    <h5 class="m-b-0"><?= $c->serie ?></h5>
                                                </td>
                                                <td>
                                                    <h5 class="m-b-0"><?= $c->numero ?></h5>
                                                </td>
                                                <td><?= $c->fecha_remision ?></td>
                                                <td>
                                                    <h5 class="m-b-0"><?= $c->destinatario_nombre ?></h5>
                                                </td>
                                                <td>
                                                    <h5 class="m-b-0"><?= $c->factura ?? '<span class="font-italic font-weight-light">Sin factura</span>'; ?></h5>
                                                </td>
                                                <td>
                                                    <h5 class="m-b-0"><?= $c->destinatario_identidad_numero ?></h5>
                                                </td>
                                                <td>
                                                    <a target="_blank" href="<?= base_url('prueba?tipo=remisionA4&idcotizacion=' . $c->id) ?>">
                                                        <i class="ti-pencil-alt"></i> A4
                                                    </a>
                                                    <br />
                                                    <?php
                                                    switch ($c->estado_api) {
                                                        case 'Registrado':
                                                            echo '<label '
                                                                . ' data-cpe="estado_guia" '
                                                                . ' data-id="' . $c->id . '"'
                                                                . ' data-serie="' . $c->serie . '"'
                                                                . ' data-numero="' . $c->numero . '"'
                                                                . ' class="badge badge-info"><i class="fa fa-sync"></i> Registrado</label>';
                                                            break;
                                                        case 'Enviado':
                                                            echo '<label class="badge badge-primary">Enviado</label>';
                                                            break;
                                                        case 'Aceptado':
                                                            echo '<label class="badge badge-success">Aceptado</label>';
                                                            echo '<label '
                                                                . ' data-cpe="anular_guia"'
                                                                . ' data-id="' . $c->id . '"'
                                                                . ' data-serie="' . $c->serie . '"'
                                                                . ' data-numero="' . $c->numero . '"'
                                                                . ' class="badge badge-danger"><i class="fa fa-trash"></i> Anular</label>';
                                                            break;
                                                        case 'Observado':
                                                            echo '<label class="badge badge-warning">Observado</label>';
                                                            break;
                                                        case 'Rechazado':
                                                            echo '<label class="badge badge-light">Rechazado</label>';
                                                            break;
                                                        case 'Anulado':
                                                            echo '<label class="badge badge-danger">Anulado</label>';
                                                            break;
                                                        case 'Por Anular':
                                                            echo '<label class="badge badge-info">Por Anular</label>';
                                                            break;
                                                        default:
                                                            echo '<label '
                                                                . ' data-cpe="enviar_guia" '
                                                                . ' data-id="' . $c->id . '"'
                                                                . ' data-serie="' . $c->serie . '"'
                                                                . ' data-numero="' . $c->numero . '"'
                                                                . ' class="badge badge-dark"><i class="fa fa-paper-plane"></i> Pendiente</label>';
                                                            break;
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    echo $c->documento_conformidad ?
                                                        '<span style="color: gray !important; cursor: default"><i class="fas fa-plus"></i> Subir Conformidad</span><br>' :
                                                        '<a href="" onclick="documento_conformidad(' . $c->id . ')" data-target="#documento_conformidad" data-toggle="modal" ><i class="fas fa-plus"></i> Subir Conformidad</a><br>';
                                                    ?>

                                                    <!-- - <a href="<?= base_url('cotizacion/edit/' . $c->id) ?>">
                                                                                                <i class="ti-pencil"></i> Editar
                                                                                        </a> -->
                                                    <a href="" data-target="#subir_orden" data-toggle="modal" onclick="subir_orden(<?php echo $c->id; ?>, `<?php echo $c->documento_orden; ?>`, `<?php echo $c->correlativo; ?>`);">
                                                        <i class="fas fa-plus"></i> Subir Orden
                                                    </a><br>

                                                    <a href="<?= base_url('cotizacion/factura/' . $c->id) . '?remision=true' ?>" target="_blank">
                                                        <i class="far fa-file-alt"></i> &nbsp;Factura
                                                    </a>
                                                    <!-- - <a href="<?= base_url('remision/delete/' . $c->id) ?>" >
                                            <i class="ti-trash"></i> Eliminar
                                    </a> -->	<br >
													<a href="#" remision_id="<?= $c->id ?>" class="ver-productos-remision">
														<i class="ti-menu"></i> Ver Productos
													</a>
                                                </td>
                                            </tr>
                                    <?php
                                        }
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
</div>



<!-- Modal -->
<div class="modal fade" id="subir_orden" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" id="header">
                <h5 class="modal-title" id="titulo">Subir orden</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open_multipart('remision/subir_orden'); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label>Corelativo </label>
                        <input type="text" name="correlativo" class="form-control" id="correlativo" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label>Orden <span class="text-muted">(.JPEG, .PNG, .JPG, .PDF)</span></label>
                        <input type="file" name="documento" class="form-control" accept="image/png, .jpeg, .jpg, .pdf" id="file" required>
                    </div>
                </div>
            </div>
            <input type="hidden" name="id" id="idr">
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="subir">Subir</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="">Cerrar</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="documento_conformidad" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" id="header2">
                <h5 class="modal-title" id="titulo2">Subir documento de conformidad</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open_multipart('remision/subir_documento_conformidad'); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label>Documento <span class="text-muted">(.PDF)</span></label>
                        <input type="file" name="documento" class="form-control" accept=".pdf" id="file2" required>
                    </div>
                </div>
            </div>
            <input type="hidden" name="id" id="idr2">
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="subir2">Subir</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="">Cerrar</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<script>
    const subir_orden = (id, doc, corr) => {
        document.getElementById('idr').value = id;
        if (doc !== '') {
            document.getElementById('titulo').innerHTML = 'Documento subido correctamente';
            document.getElementById('correlativo').value = corr;
            document.getElementById('correlativo').setAttribute('disabled', 'disabled');
            document.getElementById('subir').setAttribute('disabled', 'disabled');
            document.getElementById('file').setAttribute('disabled', 'disabled');
            document.getElementById('header').setAttribute('class', 'modal-header bg-success');
            document.getElementById('titulo').setAttribute('class', 'modal-title text-white');
        } //en if
        else {
            document.getElementById('titulo').innerHTML = 'Subir orden';
            document.getElementById('header').setAttribute('class', 'modal-header');
            document.getElementById('correlativo').value = '';
            document.getElementById('titulo').setAttribute('class', 'modal-title');
            document.getElementById('subir').removeAttribute('disabled', 'disabled');
            document.getElementById('file').removeAttribute('disabled', 'disabled');
            document.getElementById('correlativo').removeAttribute('disabled', 'disabled');
        } //end else
    };

    const documento_conformidad = (id) => {
        document.getElementById('idr2').value = id;
    };
</script>