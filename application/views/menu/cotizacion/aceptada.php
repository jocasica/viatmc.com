<div class="page-wrapper" style="background-color: #D2E0F0;">
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-5">
                <h4 class="page-title">Cotizaciones</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Cotizaciones</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Lista de Cotizaciones aceptadas</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Lista de Cotizaciones aceptadas</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-md-flex align-items-center">
                            <div class="table-responsive">
                                <table class="table v-middle" id="tabla-cotizaciones-aceptadas">
                                    <thead>
                                        <th>#</th>
                                        <th>Fecha</th>
                                        <th>Usuario creador</th>
                                        <th>Vendedor</th>
                                        <th>Monto total</th>
                                        <th>Tipo cotización</th>
                                    </thead>
                                    <tbody>
                                        <?php $count = 0;
                                        foreach ($cots->result() as $c) { ?>
                                            <tr>
                                                <td>
                                                    <h5 class="m-b-0"><?= ++$count ?></h5>
                                                </td>
                                                <td><?php echo $c->created_at; ?></td>
                                                <td><?php echo $c->user_name; ?></td>
                                                <td><?php echo $c->nombre_vendedor; ?></td>
                                                <td><?php echo $c->montototal; ?></td>
                                                <td><?php echo $c->tipo_cotizacion; ?></td>
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
</div>