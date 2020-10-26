<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-12">
                <h4 class="page-title">Reporte</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?=base_url('reportes')?>">Lista de Reportes</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> Comprobantes</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <br>
    </div>
    <div class="container-fluid">
        <div class="row">
            <!-- column -->
            <div class="col-lg-6 col-xlg-6 col-md-6">
                <div class="card">
                    <div class="card-body">

                        <!-- title -->
                        <div class="d-md-flex align-items-center">
                            <div>
                                <h4 class="card-title">Generar lista de reportes</h4>
                                <h5 class="card-subtitle" hidden>Overview of Top Selling Items</h5>
                            </div>
                            <div class="ml-auto">
                                <div class="dl">
                                    <h4 class="m-b-0 font-16">Moneda: SOLES</h4>
                                </div>
                            </div>
                        </div>
                        <!-- title -->

                        <form class="form-horizontal form-material" id="frm" method="post" action="">
                            <div class="form-group">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-6">Desde: </label>
                                        <label class="col-md-6">Hasta: </label>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="date" class="form-control form-control-line" id="date1">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="date" class="form-control form-control-line" id="date2">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Comprobante</label>
                                    <div class="col-sm-12">
                                        <select name="" class="form-control form-control-line" id="doc_report">
                                            <option value="BOLETA">BOLETA</option>
                                            <option value="FACTURA">FACTURA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button class="btn btn-success" id="btn-comprobantes-reporte" type="button">Generar
                                            Reporte</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>