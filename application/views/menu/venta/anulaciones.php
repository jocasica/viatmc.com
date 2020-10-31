<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-5">
                <h4 class="page-title">Anulaciones</h4>
          
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
                                <h4 class="card-title">Lista de Facturas anuladas</h4>
                            </div>
                           
                        </div>
                        <!-- title -->
                        <div class="table-responsive">
                           

                            <table class="table v-middle" id="PrincipalSectionTable" data-order='[[3, "desc"]]'>
                                <thead>
                                    <tr class="bg-light">
                                    <th class="border-top-0">Serie</th>
                                    <th class="border-top-0">Número</th>
                                    <th class="border-top-0">N de Dni</th>
                                    <th class="border-top-0">Cliente</th>
                                    <th class="border-top-0">Fecha</th>
                                    <th class="border-top-0">Total</th>
                                    <th class="border-top-0">Estado API</th>
                                    <th class="border-top-0">Estado SUNAT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($facturas as $factura) { ?>
                                    <tr>
                                        <td><?php echo $factura->serie?></td>
                                        <td><?php echo $factura->numero?></td>
                                        <td><?php echo $factura->ruc?></td>
                                        <td><?php echo $factura->cliente?></td>
                                        <td><?php echo $factura->fecha?></td>
                                        <td><?php echo $factura->total?></td>
                                        <td><?php echo $factura->estado_api?></td>
                                        <td><?php echo $factura->estado_sunat?></td>
                                    </tr>
                                <?php } ?>
                                   
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
                <div class="card" style="background: #e4eaf2;">
                    <div class="card-body">
                        <!-- title -->
                        <div class="d-md-flex align-items-center">
                            <div>
                                <h4 class="card-title">Lista de Notas de crédito anuladas</h4>
                            </div>
                           
                        </div>
                        <!-- title -->
                        <div class="table-responsive">
                           

                            <table class="table v-middle" id="PrincipalSectionTableAnuladas" data-order='[[3, "desc"]]'>
                                <thead>
                                    <tr class="bg-light">
                                    <th class="border-top-0">Serie</th>
                                    <th class="border-top-0">Número</th>
                                    <th class="border-top-0">N de Dni</th>
                                    <th class="border-top-0">Cliente</th>
                                    <th class="border-top-0">Fecha</th>
                                    <th class="border-top-0">Total</th>
                                    <th class="border-top-0">Estado API</th>
                                    <th class="border-top-0">Estado SUNAT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($nota_credito_factura as $nc) { ?>
                                    <tr>
                                        <td><?php echo $nc->serie?></td>
                                        <td><?php echo $nc->numero?></td>
                                        <td><?php echo $nc->ruc?></td>
                                        <td><?php echo $nc->cliente?></td>
                                        <td><?php echo $nc->fecha?></td>
                                        <td><?php echo $nc->total?></td>
                                        <td><?php echo $nc->estado_api?></td>
                                        <td><?php echo $nc->estado_sunat?></td>
                                    </tr>
                                <?php } ?>
                                   
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
                <div class="card" style="background: #dae6e2;">
                    <div class="card-body">
                        <!-- title -->
                        <div class="d-md-flex align-items-center">
                            <div>
                                <h4 class="card-title">Lista de Boletas anuladas</h4>
                            </div>
                           
                        </div>
                        <!-- title -->
                        <div class="table-responsive">
                           

                            <table class="table v-middle" id="PrincipalSectionTableAnuladasBoletas" data-order='[[3, "desc"]]'>
                                <thead>
                                    <tr class="bg-light">
                                    <th class="border-top-0">Serie</th>
                                    <th class="border-top-0">Número</th>
                                    <th class="border-top-0">N de Dni</th>
                                    <th class="border-top-0">Cliente</th>
                                    <th class="border-top-0">Fecha</th>
                                    <th class="border-top-0">Total</th>
                                    <th class="border-top-0">Estado API</th>
                                    <th class="border-top-0">Estado SUNAT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($boletas as $boleta) { ?>
                                    <tr>
                                        <td><?php echo $boleta->serie?></td>
                                        <td><?php echo $boleta->numero?></td>
                                        <td><?php echo $boleta->dni?></td>
                                        <td><?php echo $boleta->cliente?></td>
                                        <td><?php echo $boleta->fecha?></td>
                                        <td><?php echo $boleta->total?></td>
                                        <td><?php echo $boleta->estado_api?></td>
                                        <td><?php echo $boleta->estado_sunat?></td>
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
</div>
