<?php 


$folder    = "./20546439268";


$files      = array_diff(scandir($folder), array('.', '..'));


 ?>

 <!DOCTYPE html>
 <html lang="es">
 <head>
 	<meta charset="UTF-8">
 	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
 	<title>Documentos</title>

<!-- Css -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">


<!-- Css Datatable -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">

<!-- Css FontAwesome -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- Sweet Alert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<!-- JS Datatable -->

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<!-- DataTables Export -->
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

 </head>
 <body>

<div class="container">
	
<div class="row">
	
<div class="col-md-12">
	
<div class="card">
	
<div class="card-header">
	
Documentos

</div>


<div class="card-body">
	
<div class="table-responsive">
	
<table id="consulta"  class="table">
	
<thead>
<tr>
<th>Documento</th>
</tr>
</thead>

<tbody>
	
<?php foreach ($files as $key => $value): ?>
<tr>
<td><?= $value ?></td>
</tr>	
<?php endforeach ?>

</tbody>


</table>


</div>


</div>


</div>



</div>


</div>

</div>

 	<script>
 	$(document).ready( function () {
    $('#consulta').DataTable({
     
     "language":{

"url":"https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"


}


    });
} );
 	</script>
 </body>
 </html>