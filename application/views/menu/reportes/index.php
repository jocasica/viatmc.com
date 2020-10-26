<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-12">
                <h4 class="page-title">Reportes</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?=base_url('reportes')?>">Reportes</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Lista de Reportes </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <br>
    </div>
    <div class="container-fluid">
        <div class="container">
            <br>
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="upgrade-btn">
                        <a href="<?=base_url('reportes/documentos')?>" class="btn btn-primary text-white">Documentos</a>
                    </div>
                </div>
                <div class="col-md-9 col-sm-12">
                    <div class="upgrade-btn">
                        <a class="btn space">Reporte mensual según tipo de registro (BOLETA | FACTURA)</a>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="upgrade-btn">
                        <a href="<?=base_url('reportes/comprobantes')?>"
                            class="btn btn-primary text-white">Comprobantes</a>
                    </div>
                </div>
                <div class="col-md-9 col-sm-12">
                    <div class="upgrade-btn">
                        <a class="btn space">Reporte de comprobantes por fecha específica</a>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="upgrade-btn">
                        <a href="<?=base_url('reportes/compra_productos')?>" class="btn btn-primary text-white">Compra de
                            Productos</a>
                    </div>
                </div>
                <div class="col-md-9 col-sm-12">
                    <div class="upgrade-btn">
                        <a class="btn space">Reporte de compra mensual según tipo de producto</a>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="upgrade-btn">
                        <a href="<?=base_url('reportes/venta_productos')?>" class="btn btn-primary text-white">Ventas de
                            Productos</a>
                    </div>
                </div>
                <div class="col-md-9 col-sm-12">
                    <div class="upgrade-btn">
                        <a class="btn space">Reporte de venta mensual según tipo de producto</a>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="upgrade-btn">
                        <a href="<?=base_url('reportes/ventas')?>" class="btn btn-primary text-white">Ventas</a>
                    </div>
                </div>
                <div class="col-md-9 col-sm-12">
                    <div class="upgrade-btn">
                        <a class="btn space">Reporte de ventas enviadas a SUNAT según fecha específica</a>
                    </div>
                </div>
            </div>
            <br>
        </div>
    </div>
</div>
