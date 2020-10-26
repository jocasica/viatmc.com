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
                            <li class="breadcrumb-item active" aria-current="page"> Documentos</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <br>
    </div>
    <div class="container-fluid">
   <div class="row">
       
     <div class="col-12">


     <div class="card">
                <div class="card-body">
                        <!-- title -->
                        <div class="d-md-flex align-items-center">
                            <div>
                               <strong>Documentos</strong>
                            </div>
                            <div class="ml-auto">
                                <div class="dl">
                                    <h4 class="m-b-0 font-16">Moneda: SOLES</h4>
                                </div>
                            </div>
                        </div>
                        <!-- title -->

                 


                    </div>
                    <div class="table-responsive col-sm-12">
                        <table class="table v-middle" id="consulta_resumen_ventas" style="font-size: 12px">
                            <thead>
                                <tr class="bg-light">
                                    <th class="border-top-0">Fecha</th>
                                    <th class="border-top-0">Número</th>
                                    <th class="border-top-0">Cliente</th>
                                    <th class="border-top-0">Nro de Documento</th>
                                    <th class="border-top-0">Sub Total</th>
                                    <th class="border-top-0">IGV</th>
                                    <th class="border-top-0">Total</th>
                                     <th class="border-top-0">Metódo de Pago</th>
                                    
                                </tr>
                            </thead>
                  
                        </table>
                    </div>
       
              
                </div>

    
    </div>


   </div>




    </div>
</div>

<!-- Modal Resumen Ventas -->
<form id="form-resumen-ventas" autocomplete="off">
    
<div class="modal fade" id="modal-resumen-ventas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Resumen Ventas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
    <div class="form-group">
    <label>Período</label>
    <input type="month" name="periodo" class="form-control periodo" required value="<?=  date('Y-m') ?>">
    </div>

    <div class="form-group">
    <label>Tipo</label>
    <select name="tipo"  class="form-control tipo" required>
    <option value="boleta">Boleta</option>
    <option value="factura">Factura</option>
    <option value="facturaboleta">Factura + Boleta</option>
    </select>
    </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Consultar</button>
      </div>
    </div>
  </div>
</div>



</form>
