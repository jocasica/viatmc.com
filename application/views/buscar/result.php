<!DOCTYPE html>
<html dir="ltr" lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>panel/assets/images/favicon.png">
    <title>Grifo | LK Combustibles</title>
    <!-- Custom CSS -->
    <link href="<?= base_url() ?>panel/assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url() ?>panel/dist/css/style.min.css" rel="stylesheet">

    <style>
    .div {
        text-align: right !important;
        margin: 0px !important;
    }

    .buscar {
        color: white;
        border: 1px solid #888888;
        padding: 25px;
        margin: 40px;
        box-shadow: 5px 10px 8px 10px #888888;
        border-radius: 20px;
        background-color: #36bea6;
    }

    .btn_buscar {
        text-align: center;
    }

    .acc_busc {
        text-align: right;
    }

    .span{
        color: darkslategrey !important;
    }

    .card-footer {
        font-size: 12px;
        padding: 6px;
        margin: 0px;
        background-color: #36bea6;
        color: white;
    }

    .card-footer-a:hover {
        font-size: 14px;
        color: white;
    }
    </style>
</head>

<body>

    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-3 col-sm-12"></div>
                            <div class="col-md-6 col-sm-12">
                                <div class="buscar">
                                    <div class="row">
                                        <div class="col-md-8 col-sm-12">
                                            <h3 class="card-title">Comprobante Electrónico</h3>
                                        </div>
                                        <div class="col-md-4 col-sm-12 acc_busc">
                                            <a class="btn_buscar btn-success" href="<?= base_url('buscar')?>">BUSCAR</a>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col">
                                            <?php if ($data != null) { ?>
                                            <p class="card-title span">Documento electrónico N° :
                                                <?=$data->serie?>-<?=$data->numero?></p>
                                            <p class="card-title span">Cliente: <?=$data->cliente?> </p>
                                            <p class="card-title span">Total: <?=$data->total?> </p>
                                            <hr>
                                            <div class="">
                                                <?php 
                                                    $tipo="";
                                                    if($data->serie[0]=="F"){$tipo="factura";}
                                                    else if ($data->serie[0]=="B"){$tipo="boleta";} 
                                                ?>
                                                <a class="card-footer">XML </a> |
                                                <a class="card-footer card-footer-a" target="_blank"
                                                    href="<?= base_url('prueba?tipo='.$tipo.'A4&id='.$data->venta_id) ?>">PDF
                                                </a>
                                            </div>
                                            <?php }else { ?>
                                                <p class="card-title span"> NO SE ENCONTRARON RESULTADOS</p>
                                    <?php }?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="div">
                                        <p class="card-footer">Grifo | LK Combustibles</p>
                                        <a href="https://escienza.net/" class="card-footer card-footer-a"
                                            target="_blank">Desarrollado por Escienza E.I.R.L.</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


</body>

</html>