<div class="page-wrapper" style="background-color: #D2E0F0;">
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-5">
                <h4 class="page-title">Documentos rechazados</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Documentos</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Rechazados</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Boletas -->
                <div class="card">
                    <div class="card-body">
                        <!-- title -->
                        <div class="d-md-flex align-items-center">
                            <div>
                                <strong>Boletas</strong>
                            </div>
                        </div>
                        <!-- title -->
                    </div>
                    <div class="table-responsive col-sm-12">
                        <table class="table v-middle" id="boletas_anuladas" style="font-size: 12px">
                            <thead>
                                <tr class="bg-light">
                                    <th class="border-top-0">Serie</th>
                                    <th class="border-top-0">Número</th>
                                    <th class="border-top-0">N de Dni</th>
                                    <th class="border-top-0">Cliente</th>
                                    <th class="border-top-0">Fecha</th>
                                    <th class="border-top-0">Total</th>
                                    <th class="border-top-0">Estado Api</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($boletas->result() as $boleta) { ?>
                                        <tr>
                                            <td><?php echo $boleta->serie; ?></td>
                                            <td><?php echo $boleta->numero; ?></td>
                                            <td><?php echo $boleta->dni; ?></td>
                                            <td><?php echo $boleta->cliente; ?></td>
                                            <td><?php echo $boleta->fecha; ?></td>
                                            <td><?php echo $boleta->total; ?></td>
                                            <td><?php echo $boleta->estado_api; ?></td>
                                        </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Facturas -->
                <div class="card">
                    <div class="card-body">
                        <!-- title -->
                        <div class="d-md-flex align-items-center">
                            <div>
                                <strong>Facturas</strong>
                            </div>
                        </div>
                        <!-- title -->
                    </div>
                    <div class="table-responsive col-sm-12">
                        <table class="table v-middle" id="facturas_anuladas" style="font-size: 12px">
                            <thead>
                                <tr class="bg-light">
                                    <th class="border-top-0">Serie</th>
                                    <th class="border-top-0">Número</th>
                                    <th class="border-top-0">Ruc</th>
                                    <th class="border-top-0">Cliente</th>
                                    <th class="border-top-0">Fecha</th>
                                    <th class="border-top-0">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($facturas->result() as $factura) { ?>
                                        <tr>
                                            <td><?php echo $factura->serie; ?></td>
                                            <td><?php echo $factura->numero; ?></td>
                                            <td><?php echo $factura->ruc; ?></td>
                                            <td><?php echo $factura->cliente; ?></td>
                                            <td><?php echo $factura->fecha; ?></td>
                                            <td><?php echo $factura->total; ?></td>
                                        </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
