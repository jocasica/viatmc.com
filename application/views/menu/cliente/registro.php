<!-- viatmc styles -->
<link rel="stylesheet" href="<?php echo base_url().'css/viatmc/viatmc.css'; ?>">

<div class="page-wrapper" style="background-color: #D2E0F0;">
  <!-- ============================================================== -->
  <!-- Bread crumb and right sidebar toggle -->
  <!-- ============================================================== -->
  <div class="page-breadcrumb">
    <div class="row align-items-center">
      <div class="col-12">
        <h4 class="page-title">Clientes</h4>
        <div class="d-flex align-items-center">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?php echo base_url('cliente'); ?>">Clientes</a></li>
              <li class="breadcrumb-item active" aria-current="page">Registor de clientes</li>
            </ol>
          </nav>
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
            <div class="d-md-flex align-items-center">
              <div>
                <h4 class="card-title">Registro de cliente</h4>
                <h5 class="card-subtitle">Los campos marcados con (<span class="text-danger">*</span>) son obligatorios</h5>
              </div>
            </div>
            <?php echo form_open('cliente/agregar', array('id' => 'form_agregar_cliente')); ?>
              <div class="row">
                <div class="form-group col-sm-2">
                  <label for="cliente_tipo_documento">Tipo Doc. Identidad <span class="text-danger">*</span></label>
                  <?php echo form_dropdown(['name'=>'tipo_documento', 'class'=>'form-control', 'id'=>'cliente_tipo_documento', 'required'=>'required'],['6'=>'RUC','1'=>'DNI']); ?>
                </div>
                <div class="form-group col-sm-2">
                  <label for="cliente_numero_documento">Número <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="numero_sunat" id="cliente_numero_documento" placeholder="###########" maxlength="11" required>
                </div>
                <div class="form-group col-sm-2">
                  <label for="">&nbsp;</label>
                  <button type="button" id="btn_buscar_cliente" class="btn btn-default btn-block" style="width: 100%;"><i class="fa fa-search"></i> Buscar</button>
                </div>
                <div class="form-group col-sm-6">
                  <label for="cliente_nombre">Nombre <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="nombre_cliente" id="cliente_nombre" placeholder="Nombre" required>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-sm-3">
                  <label for="segmento">Segmento <span class="text-danger">*</span></label>
                  <?php echo form_dropdown(['name'=>'segmento', 'class'=>'form-control', 'required'=>'required', 'id'=>'segmento'],[''=>'(SELECCIONAR)']+$this->constantes->SEGMENTOS); ?>
                </div>
                <div class="form-group col-sm-5">
                  <label for="cliente_cotizacion">Nombre cotización <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="nombre_cotizacion" id="cliente_cotizacion" placeholder="Nombre cotización" required>
                </div>
                <div class="form-group col-sm-4">
                  <label for="departamento">Departamento <span class="text-danger">*</span></label>
                  <input type="text" name="departamento" class="form-control" placeholder="Departamento" id="departamento" required>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-sm-4">
                  <label for="providencia">Providencia <span class="text-danger">*</span></label>
                  <input type="text" name="providencia" placeholder="Providencia" class="form-control" id="providencia" required>
                </div>
                <div class="form-group col-sm-4">
                  <label for="distrito">Distrito <span class="text-danger">*</span></label>
                  <input type="text" name="distrito" class="form-control" placeholder="Distrito" id="distrito" required>
                </div>
                <div class="form-group col-sm-4">
                  <label for="direccion">Dirección <span class="text-danger">*</span></label>
                  <input type="text" name="direccion" id="direccion" placeholder="Dirección" class="form-control">
                </div>
              </div>

              <div class="row">
                <div class="form-group col-sm-4">
                  <label for="telefono">Teléfono <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="telefono" placeholder="Teléfono" id="telefono">
                </div>
                <div class="form-group col-sm-4">
                  <label for="email">Correo electrónico <span class="text-danger">*</span></label>
                  <input type="email" name="email" id="email" placeholder="ejemplo@mail.com" class="form-control">
                </div>
                <div class="form-group col-sm-4">
                  <label for="id_vendedor">Vendedor <span class="text-danger">*</span></label>
                  <select class="form-control select2" name="id_vendedor" id="id_vendedor" required>
                    <option value="">(SELECCIONAR)</option>
                    <?php foreach($data_vendedores as $v): ?>
                      <option value="<?= $v->id; ?>"><?= $v->nombre_vendedor; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <div class="row">
                  <div class="form-group col-sm-5"></div>
                  <div class="form-group col-sm-2">
                    <button type="button" class="btn btn-outline-info waves-effect" id="btnAdd"><i class="fas fa-plus"></i> Agregar dirección</button>
                  </div>
                  <div class="form-group col-sm-5"></div>
              </div>

              <h6>Dirección principal</h6>
              <div class="row">
                  <div class="form-group col-sm-2">
                    <label>Ubigeo <span class="text-danger">*</span></label>
                    <input type="text" name="ubigeo[]" reuired class="form-control" placeholder="xxxx">
                  </div>
                  <div class="form-group col-sm-5">
                    <label>Dirección <span class="text-danger">*</span></label>
                    <input type="text" name="direccion2[]" class="form-control" placeholder="Dirección">
                  </div>
                  <div class="form-group col-sm-2">
                    <label>Teléfono <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="telefono2[]" placeholder="Teléfono">
                  </div>
                  <div class="form-group col-sm-3">
                    <label for="email">Correo electrónico <span class="text-danger">*</span></label>
                    <input type="email" name="email2[]" placeholder="ejemplo@mail.com" class="form-control">
                  </div>
              </div>
              <div id="TextBoxContainer">
                <!-- mas direcciones -->
              </div>
              <div class="row text-center">
                <div class="form-group col-sm-12">
                  <button type="submit" class="btn btn-primary">Guardar</button>
                  <a type="button" href="<?php echo base_url('cliente') ?>" class="btn btn-danger">Cancelar</a>
                </div>
              </div>
            <?php echo form_close(); ?>
          </div>
        </div>
      </div>
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
  let count = 0;
  $("#btnAdd").bind("click", function () {
    var div = $("<div />");
    div.html(GetDynamicTextBox(++count));
    $("#TextBoxContainer").append(div);
  });

  $("body").on("click", ".remove", function () {
    count--;
    $(this).closest("div").remove();
  });

  function GetDynamicTextBox(num) {
    return `
      <h6>Dirección secundaria #${num} <a type="button"><i class="fas fa-trash text-danger remove"></i></a></h6>
      <div class="row">
        <div class="form-group col-sm-2">
          <label>Ubigeo <span class="text-danger">*</span></label>
          <input type="text" name="ubigeo[]" required class="form-control" placeholder="xxxx">
        </div>
        <div class="form-group col-sm-5">
          <label>Dirección <span class="text-danger">*</span></label>
          <input type="text" name="direccion2[]" class="form-control" placeholder="Dirección">
        </div>
        <div class="form-group col-sm-2">
          <label>Teléfono <span class="text-danger">*</span></label>
          <input type="text" name="telefono2[]" class="form-control" placeholder="Teléfono">
        </div>
        <div class="form-group col-sm-3">
          <label for="email">Correo electrónico <span class="text-danger">*</span></label>
          <input type="email" name="email2[]" placeholder="ejemplo@mail.com" class="form-control">
        </div>
      </div>
    `;
  }
  // Registrar Cliente
  $('#form_agregar_cliente').submit(function (e) {
    e.preventDefault();
    msg_confirmation('warning', '¿Está seguro?', 'No podrá revertir los cambios.')
    .then((res) => {
      if(res) {
        $.ajax({
          type: $('#form_agregar_cliente').attr('method'),
          url: $('#form_agregar_cliente').attr('action'),
          data: $('#form_agregar_cliente').serialize(),
          success: function (data) {
            time_alert('success', 'Cliente registrado!', 'El cliente se registró correctamente.', 2000)
            .then(() => {
              window.location = '<?= base_url('cliente')?>';
            })
          }
        });
      }
    });
  });
</script>