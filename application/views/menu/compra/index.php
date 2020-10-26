<!-- viatmc styles -->
<link rel="stylesheet" href="<?php echo base_url().'css/viatmc/viatmc.css'; ?>">

<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-5">
                <h4 class="page-title">Compras</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Compras</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Lista de compras</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-7">
                <div class="text-right upgrade-btn">
                    <a href="<?= base_url('compra/create') ?>" class="btn btn-danger text-white">Registrar nueva compra</a>
                </div>
            </div>
        </div>
    </div>
    <div id="vm_ver_productos" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title" style="color:white">Productos de la compra</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="col-md-12">
                        <div hidden class="alert alert-success alert-styled-left alert-arrow-left alert-bordered">
                            Agregue la serie del producto comprado.
                        </div>
                    </div>
                    <table class="table v-middle" id="body_tbl">
                        <thead>
                            <tr class="bg-light">
                                <th class="border-top-0">Codigo Producto</th>
                                <th class="border-top-0">Proveedor</th>
                                <th class="border-top-0">Producto</th>
                                <th class="border-top-0">Serie</th>
                                <th class="border-top-0">Garantia</th>
                                <th class="border-top-0">Precio de compra local </th>
                                <th class="border-top-0">Precio de compra extranjero </th>
                                <th class="border-top-0">Estado</th>
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
            <div class="col-md-12">
                <div class="card">
                <div class="card-body">
                        <!-- title -->
                        <div class="d-md-flex align-items-center">
                            <div>
                                <h4 class="card-title">Lista de Compras</h4>
                                <h5 class="card-subtitle" hidden>Overview of Top Selling Items</h5>
                            </div>
                            <div class="ml-auto">
                                <button href="#" class="btn btn-success btn-reporte-compra" type="button" data-toggle="modal">REPORTE</button>

                            </div>
                        </div>
                        <!-- title -->
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tabla_lista_compras">
                                <thead>
                                    <tr>
                                        <th>Serie</th>
                                        <th>Número</th>
                                        <th>Proveedor</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Monto total</th>
                                        <th>Tipo cambio</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($compras->result() as $c): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="m-r-10"><a class="btn btn-circle btn-orange text-white">C</a></div>
                                                    <div class="">
                                                        <h4 class="m-b-0 font-16">
                                                            <?= $c->serie ?>
                                                        </h4>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= $c->numero ?></td>
                                            <td><?= $c->proveedor ?></td>
                                            <td><?= date('d/m/Y', strtotime($c->fecha)); ?></td>
                                            <td>
                                                <label class="label label-info">
                                                    <?php echo ($c->estado) ? "Habilitado":"Inhabilitado" ?>
                                                </label>
                                            </td>
                                            <td>
                                                <strong>
                                                    <?php echo ($c->moneda == "SOLES") ? "S/":"$/"; ?>
                                                    <?= $c->total ?>
                                                </strong>
                                            </td>
                                            <td><?= $c->tipocambio ?></td>
                                            <td>
                                                <a href="#" compra_id="<?= $c->id ?>" class="ver-productos">
                                                    <i class="ti-menu"></i> Ver Productos
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>