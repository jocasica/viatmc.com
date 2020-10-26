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
                            <li class="breadcrumb-item active" aria-current="page"> Compra de productos</li>
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
                                <h4 class="card-title">Generar reporte de turnos</h4>
                                <h5 class="card-subtitle" hidden>Overview of Top Selling Items</h5>
                            </div>
                            <div class="ml-auto">
                                <div class="dl">
                                    <h4 class="m-b-0 font-16" style="visibility:hidden">moneda slessdsadsads
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <!-- title -->
                        <form class="form-horizontal form-material" id="frm" method="post" action="">
                            <div class="form-group">
                                <div class="form-group">
                                    <label class="col-md-12">Fecha</label>
                                    <div class="col-sm-12">
                                        <input type="date" class="form-control form-control-line" id="date_turno">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button class="btn btn-success" id="btn-venta-reporte-turno"
                                            type="button">Generar Reporte</button>
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