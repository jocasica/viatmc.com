<!-- viatmc styles -->
<link rel="stylesheet" href="<?php echo base_url().'css/viatmc/viatmc.css'; ?>">

<div class="page-wrapper">
  <!-- ============================================================== -->
  <!-- Bread crumb and right sidebar toggle -->
  <!-- ============================================================== -->
  <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-3">
                <h4 class="page-title">Facturas</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Facturas</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Lista de facturas</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-3">
                <div class="text-right upgrade-btn">
                    <a href="<?= base_url('venta/nota_credito') ?>" class="btn btn-info btn-block text-white">Ver Notas de Credito</a>
                </div>
            </div>
            <div class="col-3">
                <div class="text-right upgrade-btn">        
                    <a href="<?= base_url('venta/anulaciones') ?>" class="btn btn-warning btn-block text-white">Ver Anulaciones</a>
                </div>
            </div>
            <div class="col-3">
                <div class="text-right upgrade-btn">
                    <a href="<?= base_url('venta/create') ?>" class="btn btn-danger  btn-block text-white">Registrar nueva factura</a>
                </div>
            </div>
        </div>
    </div>
  <div id="vm_enviar_correo" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h6 class="modal-title" style="color:white">Enviar Correo</h6>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
          <div class="col-md-12">
            <div class="alert alert-success alert-styled-left alert-arrow-left alert-bordered">
              Envíe el .xml y el comprobante a un correo.
            </div>
          </div>
          <form action="/" id="frm-correo" method="post" accept-charset="utf-8">
            <div class="row">
              <div class="form-group col-md-12">
                <label for="producto_serie">Comprobante</label>
                <input class=" form-control valid" id="comprobante" name="comprobante" readonly>
              </div>
              <div class="form-group col-md-12">
                <label for="producto_serie">Correo</label>
                <input class=" form-control valid" id="correo" type="email" name="correo" required>
              </div>
              <input hidden id="serie" name="serie" />
              <input hidden id="numero" name="numero" />
              <input hidden id="venta_id" name="venta_id" />
              <div class="form-group col-md-12">
                <button type="submit" class="btn btn-success" id="btn_enviar_correo">Enviar</button>
                <button type="button" style="float:right" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
              </div>
            </div>
          </form>
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
                <h4 class="card-title">Lista de Facturas</h4>
                <h5 class="card-subtitle" hidden>Overview of Top Selling Items</h5>
              </div>
              <div class="ml-auto">
                <div class="dl">
                  <h4 class="m-b-0 font-16">Moneda: SOLES</h4>
                </div>
              </div>
            </div>
            <!-- title -->
            <div class="table-responsive">
              <div class="col-sm-12 padd-l-0">
                <?php $tipoComprobante = ($_COOKIE['tipoComprobante'] ?? '');
                $serieNumber = ($_COOKIE['serieNumber'] ?? 'all'); ?>
                <div class="col-sm-6 padd-l-0">
                  <div class="row">
                    <div class="col-sm-4">
                      <label for="table-filter">Tipo de comprobante:</label>
                      <select id="table-filter" class="select2">
                        <option value="all" <?php echo ($tipoComprobante === 'all' ? 'selected' : ''); ?>>TODOS</option>
                        <option value="factura" <?php echo ($tipoComprobante === 'factura' ? 'selected' : ''); ?>>
                          FACTURA</option>
                        <option value="boleta" <?php echo ($tipoComprobante === 'boleta' ? 'selected' : ''); ?>>BOLETA
                        </option>
                      </select>
                    </div>
                    <div class="col-sm-4">
                      <label>Número de serie:</label>
                      <input type="hidden" value="<?php echo $serieNumber; ?>" id="serieNumber">
                      <input type="hidden" value="<?php echo $tipoComprobante; ?>" id="tipoComprobante">
                      <select id="table-serie" class="form-inline select2" data-series='<?php echo json_encode($seriesNumbers); ?>'></select>
                    </div>
                    <div class="col-sm-2">
                      <label>&nbsp;</label>
                      <button class="btn btn-primary btn-sm btn-rounded" onclick="searchInSalesTable()"><i class="fa fa-search"></i> &nbsp; Buscar</button>
                    </div>
                  </div>
                </div>
              </div>

              <table class="table table-responsive v-middle" id="PrincipalSectionTable" data-order='[[3, "desc"]]'>
                <thead>
                  <tr class="bg-light">
                    <th class="border-top-0">Serie</th>
                    <th class="border-top-0">Número</th>
                    <th class="border-top-0" width="30%">Cliente</th>
                    <th class="border-top-0" width="10%">Fecha</th>
                    <th class="border-top-0" width="15%">Personal</th>
                    <th class="border-top-0">Guía de remisión</th>
                    <th class="border-top-0">Estado API</th>
                    <th class="border-top-0">SUNAT</th>
                    <th class="border-top-0">Monto total</th>
                    <th class="border-top-0">Opciones</th>
                    <th class="border-top-0">Descarga</th>
                    <th class="border-top-0">Acciones</th>
                    <th class="border-top-0"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($row = mysqli_fetch_array($ventas)) { ?>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <div class="m-r-10">
                            <a class="btn btn-circle btn-orange text-white">
                              <?php if ($row['serie'][0] == "F") {
                              ?>
                                F
                              <?php } else { ?>
                                B
                              <?php } ?>
                            </a>
                          </div>
                          <div class="">
                            <h4 class="m-b-0 font-16"><?php echo $row['serie']; ?></h4>
                          </div>
                        </div>
                      </td>
                      <td>
                        <?php echo $row['numero'] ?>
                      </td>
                      <td>
                        <?php echo $row['cliente'] ?><br>
                        <small><?php echo $row['ruc'] ?></small>
                      </td>
                      <td>
                        <?php echo $row['fecha_emision'] ?>
                      </td>
                      <td>
                        <?php echo $row['vendedor_name'] ?>
                      </td>
                      <td>
                        <?php echo $row['guia_remision']; ?>
                      </td>
                      <td>
                        <?php
                        switch ($row['estado_api']) {
                          case 'Registrado':
                            echo '<label '
                              . ' data-cpe="estado_cpe" '
                              . ' data-id="' . $row['id_doc'] . '"'
                              . ' data-serie="' . $row['serie'] . '"'
                              . ' data-numero="' . $row['numero'] . '"'
                              . ' data-tipo="' . $row['tipo'] . '"'
                              . ' class="badge badge-info"><i class="fa fa-sync"></i> Registrado</label>';
                            break;
                          case 'Enviado':
                            echo '<label class="badge badge-primary">Enviado</label>';
                            break;
                          case 'Aceptado':
                            echo '<label class="badge badge-success">Aceptado</label>';
                            $fecha_limite = date('Y-m-d', strtotime("+ 7 days", strtotime($row['fecha_emision'])));
                            //echo $fecha_limite;
                            if ($fecha_limite >= date('Y-m-d')) {
                              echo '<label '
                                . ' data-cpe="anular"'
                                . ' data-id="' . $row['id_doc'] . '"'
                                . ' data-serie="' . $row['serie'] . '"'
                                . ' data-numero="' . $row['numero'] . '"'
                                . ' data-tipo="' . $row['tipo'] . '"'
                                . ' class="badge badge-danger"><i class="fa fa-trash"></i> Anular</label>';
                            } else {
                              echo '<label class="badge badge-danger">Fecha límite excedida</label>';
                            }
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
                              . ' data-cpe="enviar" '
                              . ' data-id="' . $row['id_doc'] . '"'
                              . ' data-serie="' . $row['serie'] . '"'
                              . ' data-numero="' . $row['numero'] . '"'
                              . ' data-tipo="' . $row['tipo'] . '"'
                              . ' class="badge badge-dark"><i class="fa fa-paper-plane"></i> Pendiente</label>';
                            break;
                        } ?>
                      <td>
                        <label class="label label-<?php if (strtoupper($row['estado_sunat']) == "ACEPTADO") {
                            echo "success";
                          } else {
                            if (strtoupper($row['estado_sunat']) == "ANULADO") {
                              echo "danger";
                            } else {
                              echo "warning";
                            }
                          } ?>"><?= $row['estado_sunat'] ?></label>
                        <label class="label label-primary btn_estado_sunat" data-facturaid="<?= $row['factura_id'] ?>" data-serie="<?= $row['serie'] ?>" data-tipo="<?php if ($row['serie'][0] == "F") { ?>01<?php } else { ?>03<?php } ?>" data-numero="<?= $row['numero'] ?>" data-fecha="<?php echo $row['fecha_sunat'] ?>" data-total="<?php echo $row['total'] ?>">Buscar</label>
                      </td>
                      <td>
                        <h5 class="m-b-0"><?php echo $row['total'] . ' ' . $row['codigo_moneda']; ?></h5>
                      </td>
                      <td>
                        <?php
                        $tipo = "";
                        if ($row['serie'][0] == "F") {
                          $tipo = "factura";
                        } else if ($row['serie'][0] == "B") {
                          $tipo = "boleta";
                        }
                        ?>
                        <a target="_blank" href="<?= base_url('prueba?tipo=' . $tipo . 'A4&id=' . $row['id']) ?>">
                          <i class="fas fa-file-alt"></i> A4
                        </a>
                        <br>
                        <a data-toggle="modal" data-target="#vm_enviar_correo" href="#" class="a-correo" data-venta_id="<?= $row['id'] ?>" data-serie="<?= $row['serie'] ?>" data-numero="<?= $row['numero'] ?>">
                          <i class="ti-email"></i> Enviar
                        </a>
                      </td>
                      <td>
                        <?php
                        $tipo = "";
                        if ($row['serie'][0] == "F") {
                          $tipo = "factura";
                        } else if ($row['serie'][0] == "B") {
                          $tipo = "boleta";
                        }
                        ?>
                        <a target="_blank" href="<?= $row['xml_link'] ?>">
                          <i class="fas fa-cloud-download-alt"></i> XML
                        </a>
                        <br>
                        <a target="_blank" href="<?= $row['cdr_link'] ?>">
                          <i class="fas fa-cloud-download-alt"></i> CDR
                        </a>
                        <br>
                        <a hidden target="_blank" href="<?= $row['pdf_link'] ?>">
                          <i class="fas fa-cloud-download-alt"></i> PDF
                        </a>
                      </td>
                      <td>
                        <a type="button" href="<?= base_url('venta/create_nota_credito/'. $row['id'])?>" class="btn btn-warning btn-xs">Generar nota</a>
                      </td>
                      <td hidden>
                        <?php
                        $tipo = "";
                        if ($row['serie'][0] == "F") {
                          $tipo = "factura";
                        } else if ($row['serie'][0] == "B") {
                          $tipo = "boleta";
                        }
                        if ($row['envio'] == 'enviado') {
                          echo '<label  class="label label-danger btn_anular_comprobante"  data-id="' . $row['id_doc'] . '" data-serie="' . $row['serie'] . '" data-numero="' . $row['numero'] . '" data-tipo="' . $row['tipo'] . '">Anular</label>';
                        }
                        ?>
                      </td>
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

<!-- Modal Generar nota de crédito -->
<div class="modal fade" id="moda_generar_nota_credito" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Generar Nota de Crédito</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form_reg_nota_credito" action="#" method="POST">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-3">
              <label for="nc_tipo_comprobante">Tipo Comprobante</label>
              <select name="nc_tipo_comprobante" id="nc_tipo_comprobante" class="form-control" disabled>
                <option value="1">Nota de Crédito</option>
              </select>
            </div>
            <div class="col-md-2">
              <label for="nc_serie">Serie</label>
              <select name="nc_serie" id="nc_serie" class="form-control" disabled>
                <option value="FC01">FC01</option>
              </select>
            </div>
            <div class="col-md-4">
              <label for="nc_tipo_nota">Tipo Nota</label>
              <input type="text" name="nc_tipo_nota" id="nc_tipo_nota" class="form-control" value="Anulación de la operación" disabled>
            </div>
            <div class="col-md-3">
              <label for="nc_descripcion">Descripción</label>
              <input type="text" name="nc_descripcion" id="nc_descripcion" class="form-control" value="Anulación" disabled>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-md-8">
              <label for="nc_cliente">Cliente</label>
              <input type="text" name="nc_cliente" id="nc_cliente" class="form-control" disabled>
            </div>
            <div class="col-md-4">
              <label for="nc_fecha_emision">Fecha Emisión</label>
              <input type="date" name="nc_fecha_emision" id="nc_fecha_emision" class="form-control" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-xs" id="btn_generar_nota_credito">Generar</button>
          <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- jquery -->
<script src="https://code.jquery.com/jquery-3.5.0.min.js" charset="utf-8"></script>
<!-- Sweet Alert 2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- viatmc scripts -->
<script src="<?php echo base_url().'js/viatmc/viatmc.js'; ?>"></script>
<script>
  let data_factura = null;
  function generarNotaDeCredito(id_factura) {
    $.ajax({
      type: "post",
      url: "<?= base_url('venta/getDataVenta'); ?>",
      data: {id: id_factura},
      dataType: "json",
      success: function (response) {
        data_factura = response.data_venta;
        if(response.factura_nota_credito == null) {
          $('#nc_cliente').val(response.data_venta.cliente+' - '+response.data_venta.ruc);
          $('#nc_fecha_emision').val(response.data_venta.fecha);
          $('#moda_generar_nota_credito').modal('show');
        } else {
          const url = '<?= base_url('prueba?tipo=' . 'factura_nota_credito' . 'A4&id='); ?>'+response.factura_nota_credito.venta_id;
          window.open(url);
        }
      }
    });
  }
  $('#form_reg_nota_credito').submit(function (e) {
    e.preventDefault();
    data_factura.serie_nota         = $('#nc_serie').val();
    data_factura.fecha_nota_credito = $('#nc_fecha_emision').val();
    data_factura.tipo_nota          = $('#nc_tipo_nota').val();
    data_factura.descripcion_nota   = $('#nc_descripcion').val();
    msg_confirmation('warning', '¿Está seguro?', 'Va a generar una nota de credito, no podrá revertir los cambios.')
    .then((res) => {
      if(res) {
        $.ajax({
          type: "post",
          url: "<?= base_url('venta/registraNotaDeCredito'); ?>",
          data: {dnc: data_factura},
          dataType: "json",
          success: function (response) {
            const url = '<?= base_url('prueba?tipo=' . 'factura_nota_credito' . 'A4&id='); ?>'+response.venta_id;
            window.open(url);
            $('#moda_generar_nota_credito').modal('hide');
          }
        });
      }
    });
  });
</script>