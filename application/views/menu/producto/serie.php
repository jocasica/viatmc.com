<div class="page-wrapper">
  <!-- ============================================================== -->
  <!-- Bread crumb and right sidebar toggle -->
  <!-- ============================================================== -->
  <div class="page-breadcrumb">
    <div class="row align-items-center">
      <div class="col-5">
        <h4 class="page-title">Productos</h4>
        <div class="d-flex align-items-center">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Productos</a></li>
              <li class="breadcrumb-item active" aria-current="page">Lista de series del producto</li>
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
          <div class="card-body">
            <?php echo form_open('',['id'=>'form-serie']); ?>
              <div class="row">
                <div class="form-group col-sm-4">
                  <label>Producto</label>
                  <?php echo form_dropdown(['name'=>'id_producto', 'class'=>'form-control', 'required'=>'required', 'id'=>'id_producto'],$productos); ?>
                </div>
                <div class="form-group col-sm-4">
                  <label for=""></label>
                  <button type="submit" class="btn btn-info" style="margin-top: 10px"><i class="fas fa-search"></i> Buscar</button>                
                </div>
              </div>
            <?php echo form_close(); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <!-- column -->
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <!-- title -->
            <div class="d-md-flex align-items-center">
              <div>
                <h4 class="card-title">Lista de Series</h4>
                <h5 class="card-subtitle" hidden>Overview of Top Selling Items</h5>
              </div>
              <div class="ml-auto">
                <div class="dl">
                  <h4 class="m-b-0 font-16">Moneda: SOLES</h4>
                </div>
              </div>
            </div>
            <!-- title -->
          </div>
          <div class="table-responsive">
            <table class="table v-middle">
              <thead>
                <tr class="bg-light">
                  <th class="border-top-0">#</th>
                  <th class="border-top-0">Serie</th>
                  <th class="border-top-0">Estado</th>
                </tr>
              </thead>
              <tbody id="series-table">
                <tr align="center">
                  <td colspan="3">Este producto no cuenta con series</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  window.onload = function () {
    $("#form-serie").on("submit", function(event){
      event.preventDefault();
      let id = document.getElementById('id_producto').value;
      let html = '';
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          let series = JSON.parse(xhttp.responseText);
          if(parseInt(series.length) == 0) {
            html = `
              <tr align="center">
                <td colspan="3">Este producto no cuenta con series</td>
              </tr>
            `;
          }//end if
          else {
            let count = 0;
            for (let i = 0; i < series.length; i++) {
              html += `
                <tr>
                  <td>${++count}</td>
                  <td>${series[i].serie}</td>
                  <td>${(parseInt(series[i].estado) == 1 ? 'Disponible' : 'Vendido')}</td>
                </tr>
              `;
            }//end for
          }//end else
          document.getElementById('series-table').innerHTML = html;
        }//end if
      };
      xhttp.open("GET", "obtener_series/"+id, true);
      xhttp.send();
    });
  };
</script>