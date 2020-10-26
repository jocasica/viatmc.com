<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb18030">
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

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#tablaVentas').DataTable();
    });
    </script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <style>
    .btn {
        width: 100%;
        text-align: left !important;
    }

    .btn2 {
        text-align: center !important;
        color: black !important;
        border: 1px solid #888888;
        padding: 1px 8px 1px 10px;
        margin: 10px;
        box-shadow: 0px 0px 5px 2px #2962ff70;
        border-radius: 20px;
        background-color: #2962ffdb;
    }

    .div {
        text-align: right !important;
        margin: 0px !important;
    }

    .container {
        position: relative;
        background-color: #ffffffe0;
    }

    .vertical-center {
        margin: 0;
        position: absolute;
        top: 50%;
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
    }

    .box {
        color: white;
        border: 1px solid #888888;
        padding: 15px 10px 0px 10px;
        margin: 15px;
        box-shadow: 5px 10px 8px 10px #888888;
        border-radius: 20px;
        background-color: #36bea6;
    }

    .buscar {
        color: white;
        border: 1px solid #888888;
        padding: 25px;
        margin: 40px;
        box-shadow: 5px 10px 8px 10px #888888;
        border-radius: 20px;
        padding-bottom: 0px;
    }

    .btn_buscar {
        text-align: center;
        color: white;
        border: 1px solid #888888;
        padding: 5px;
        margin: 10px;
        box-shadow: 2px 2px 2px 2px #888888;
        border-radius: 20px;
        background-color: #36bea6;
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
                            <div class="col-md-2 col-sm-12"></div>
                            <div class="col-md-8 col-sm-12">
                                <div class="buscar box">
                                    <form action="" method="post">
                                        <h4 class="card-title">Buscar Comprobante Electrónico</h4>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-8 col-sm-12">
                                                <div class="form-group">
                                                    <label class="col-md-12">Comprobante</label>
                                                    <div class="col-sm-12">
                                                        <select name="" class="form-control form-control-line"
                                                            id="doc_buscar">
                                                            <option value="FACTURA">FACTURA</option>
                                                            <option value="BOLETA">BOLETA</option>
                                                            <option value="NOTA_CREDITO">NOTA DE CREDITO
                                                            </option>
                                                            <option value="NOTA_DEBITO">NOTA DE DEBITO</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label class="col-md-12">Fecha</label>
                                                    <div class="col-sm-12">
                                                        <input type="date" class="form-control form-control-line"
                                                            id="fecha_buscar" name="fecha_buscar" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="col-md-12">Serie</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control form-control-line"
                                                            id="serie_buscar" name="serie_buscar" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="col-md-12">Número</label>
                                                    <div class="col-sm-12">
                                                        <input type="number" class="form-control form-control-line"
                                                            id="numero_buscar" name="numero_buscar" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="col-md-12">Número Cliente (RUC/DNI/CE)</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control form-control-line"
                                                            id="cliente_buscar" name="cliente_buscar" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="col-md-12">Monto total</label>
                                                    <div class="col-sm-12">
                                                        <input type="number" class="form-control form-control-line"
                                                            id="monto_buscar" name="monto_buscar" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12">
                                                    <?php  
                                                    if(isset($_POST['buscar']))
                                                    {
                                                        $fecha=$_POST['fecha_buscar'];
                                                        $serie=$_POST['serie_buscar'];
                                                        $numero=$_POST['numero_buscar'];
                                                        $cliente=$_POST['cliente_buscar'];
                                                        $monto=$_POST['monto_buscar'];
                                                        $base = base_url('buscar');
                                                        header("Location: $base/result/$fecha/$serie/$numero/$cliente/$monto");
                                                        exit;                                                        
                                                    }  
                                                ?>
                                                    <button type="submit" id="boton" class="btn_buscar"
                                                        name="buscar">BUSCAR</button>

                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="div">
                                                        <p class="card-footer">Grifo | LK Combustibles</p>
                                                        <a href="https://escienza.net/"
                                                            class="card-footer card-footer-a"
                                                            target="_blank">Desarrollado por Escienza E.I.R.L.</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>