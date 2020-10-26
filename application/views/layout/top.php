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
  <title>TMC</title>
  <!-- Custom CSS -->
  <link href="<?= base_url() ?>panel/assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link href="<?= base_url() ?>panel/dist/css/style.min.css" rel="stylesheet">
  <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"> -->
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote.min.css" rel="stylesheet">

  <link href="<?= base_url('') ?>plantilla/select2.min.css" rel="stylesheet" type="text/css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">

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

    .btn2:hover {
      background-color: green;
    }

    .btn2:active {
      background-color: red;
    }

    .btn2:focus {
      background-color: white;
    }

    .div {
        text-align: right !important;
        margin: 5px 5px 10px 0px;
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

    .turno {
      background-color: gray !important;
    }

    .tool {
      visibility: hidden;
    }

    .tooltiptext {
      color: red;
      /* If you want dots under the hoverable text */
    }

    .tooltip {
      position: relative;
      display: inline-block;
      border-bottom: 1px dotted black;
      /* If you want dots under the hoverable text */
    }

    /* Tooltip text */
    .tooltip .tooltiptext {
      visibility: hidden;
      width: 120px;
      background-color: black;
      color: #fff;
      text-align: center;
      padding: 5px 0;
      border-radius: 6px;

      /* Position the tooltip text - see examples below! */
      position: absolute;
      z-index: 1;
    }

    /* Show the tooltip text when you mouse over the tooltip container */
    .tooltip:hover .tooltiptext {
      visibility: visible;
    }

    .turnoId {
      display: none;
    }

    .box {
      color: white;
      text-align: center;
      border: 1px solid #888888;
      padding: 15px 10px 0px 10px;
      margin: 15px;
      box-shadow: 5px 10px 8px 10px #888888;
      border-radius: 20px;
    }

    .box1 {
      background-color: #36bea6;
    }

    .box2 {
      background-color: #7460ee;
    }

    .box3 {
      background-color: #f62d51;
    }

    .box4 {
      background-color: #2962FF;
    }

    .acceso {
      color: white;
    }

    .acceso:hover {
      color: #888888;
    }

    table tr:nth-child(even) {
      background-color: #eef5f9
    }

    .pagination li:hover {
      cursor: pointer;
    }

    .pagination {
      display: inline-block;
    }

    .pagination a {
      color: black;
      float: left;
      padding: 8px 16px;
      text-decoration: none;
    }

    .pagination a.active {
      background-color: #4CAF50;
      color: white;
      border-radius: 5px;
    }

    .pagination a:hover:not(.active) {
      background-color: #ddd;
      border-radius: 5px;
    }

    .space {
      white-space: inherit !important;
    }

    .color {
      color: #f8a059
    }

    .color:hover {
      color: #59f85e
    }

    .close-btn {
      background: #36bea6;
      padding: 0 6px;
      position: absolute;
      left: 0;
      border-radius: 50%;
      color: white;
      cursor: pointer;
      margin-top: 8px;
      line-height: 1.3;
    }

    .pagination {
      display: inline-block;
      width: 100%;
      padding: 20px 0px;
    }


    .dataTables_wrapper {
      overflow-x: hidden;
    }

    #PrincipalSectionTable_info,
    #seaceTable_info,
    #PrincipalSectionTableProducto_info {
      padding: 25px 0px;
    }

    #PrincipalSectionTable_filter label,
    #seaceTable_filter label,
    #PrincipalSectionTableProducto_filter label {
      width: 50%;
      float: right;
    }

    .padd-l-0 {
      padding-left: 0 !important;
    }

    #PrincipalSectionTable_wrapper,
    #seaceTable_wrapper,
    #PrincipalSectionTableProducto_wrapper {
      padding: 10px 0;
      border-top: 1px solid rgba(0, 0, 0, 0.06);
      margin-top: 15px;
      border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    }

    #PrincipalSectionTableProducto_length label {
      display: inline-flex;
      margin-top: 15px;
      padding: 0 10px;
      line-height: 2;
    }

    #PrincipalSectionTableProducto_length select {
      margin: 0 10px;
    }

    .dataTables_wrapper>.row:first-child {
      background: #f2f2f2;
      padding: 10px;
    }

    #buttonsTableContainer {
      display: flex !important;
      justify-content: flex-end;
    }

    /* MENÚ */
    .sidebar-nav ul .sidebar-item .sidebar-link.active,
    .sidebar-nav ul .sidebar-item .sidebar-link:hover,
    .sidebar-nav ul .sidebar-item .sidebar-link.active i,
    .sidebar-nav ul .sidebar-item a.sidebar-link:hover i {
      opacity: 1;
      background-color: #2b6fc5;
      color: white !important;
    }
  </style>
</head>

<body>
  <!-- ============================================================== -->
  <!-- Preloader - style you can find in spinners.css -->
  <!-- ============================================================== -->
  <div class="preloader">
    <div class="lds-ripple">
      <div class="lds-pos"></div>
      <div class="lds-pos"></div>
    </div>
  </div>
  <!-- ============================================================== -->
  <!-- Main wrapper - style you can find in pages.scss -->
  <!-- ============================================================== -->
  <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <header class="topbar" data-navbarbg="skin5">
      <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header" data-logobg="skin5">
          <!-- ============================================================== -->
          <!-- Logo -->
          <!-- ============================================================== -->
          <a class="navbar-brand" href="menu">
            <!-- Logo icon -->
            <b class="logo-icon">
              <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
              <!-- Dark Logo icon -->
              <img src="<?= base_url() ?>images/solo-logo-dr-1.png" alt="homepage" class="dark-logo" />
              <!-- Light Logo icon -->
              <img src="<?= base_url() ?>images/solo-logo-dr-1.png" alt="homepage" class="light-logo" />
            </b>

            <!--End Logo icon -->
            <!-- Logo text -->
            <span class="logo-text" style="">
              <!-- dark Logo text -->
              <img src="<?= base_url() ?>images/solo-texto-dr-2.png" alt="homepage" class="dark-logo" />
              <!-- Light Logo text -->
              <img src="<?= base_url() ?>images/solo-texto-dr-2.png" class="light-logo" alt="homepage" />
            </span>
          </a>
          <!-- ============================================================== -->
          <!-- End Logo -->
          <!-- ============================================================== -->
          <!-- This is for the sidebar toggle which is visible on mobile only -->
          <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
          <!-- ============================================================== -->
          <!-- toggle and nav items -->
          <!-- ============================================================== -->
          <ul class="navbar-nav float-left mr-auto">
            <!-- ============================================================== -->
            <!-- Search -->
            <!-- ============================================================== -->
          </ul>
          <!-- ============================================================== -->
          <!-- Right side toggle and nav items -->
          <!-- ============================================================== -->
          <ul class="navbar-nav float-right">
            <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?= base_url() ?>panel/assets/images/users/1.jpg" alt="user" class="rounded-circle" width="31"></a>
              <div class="dropdown-menu dropdown-menu-right user-dd animated">
                <a class="dropdown-item" href="javascript:void(0)" hidden><i class="ti-user m-r-5 m-l-5"></i> My Profile</a>
                <a class="dropdown-item" href="<?= base_url('auth/logout') ?>"><i class="fa fa-power-off m-r-5 m-l-5"></i> Cerrar Sesión</a>
              </div>
            </li>
            <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
          </ul>
        </div>
      </nav>
    </header>
    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <aside class="left-sidebar" data-sidebarbg="skin6">
      <!-- Sidebar scroll-->
      <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
          <ul id="sidebarnav">
            <!-- User Profile-->
            <li>
              <!-- User Profile-->
              <div class="user-profile d-flex no-block dropdown m-t-20">
                <div class="user-pic"><img src="<?= base_url('') ?>panel/assets/images/users/1.jpg" alt="users" class="rounded-circle" width="40" /></div>
                <div class="user-content hide-menu m-l-10">
                  <a href="javascript:void(0)" class="" id="Userdd" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <h5 class="m-b-0 user-name font-medium"><?php echo ($this->ion_auth->user()->row()->first_name . ' ' . $this->ion_auth->user()->row()->last_name) ?></h5>
                    <span class="op-5 user-email"><?php echo ($this->ion_auth->user()->row()->email) ?></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Userdd" hidden>
                    <a class="dropdown-item" href="javascript:void(0)"><i class="ti-wallet m-r-5 m-l-5"></i> My Balance</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="javascript:void(0)"><i class="ti-settings m-r-5 m-l-5"></i> Account Setting</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                  </div>
                </div>
              </div>
              <!-- End User Profile-->
            </li>
            <!--li class="p-15 m-t-10"><a href="javascript:void(0)" class="btn btn-block create-btn text-white no-block d-flex align-items-center"><i class="fa fa-plus-square"></i> <span class="hide-menu m-l-5">Create New</span> </a></li-->
            <!-- User Profile-->
            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('dashboard') ?>" aria-expanded="false"><i class="fas fa-toggle-on"></i><span class="hide-menu">DASHBOARD</span></a></li>
            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('remision') ?>" aria-expanded="false"><i class="fas fa-keyboard"></i><span class="hide-menu">GUIA DE REMISION</span></a></li>
            <!-- MENU COTIZACIONES -->
            <li class="sidebar-item">
              <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                <i class="mdi mdi-cart-outline"></i>
                <span class="hide-menu">COTIZACIONES</span>
              </a>
              <ul aria-expanded="false" class="collapse first-level" style="margin-left: 15px">
                <li class="">
                  <a href="<?= base_url('cotizacion') ?>" class="sidebar-link">
                    <i class="mdi mdi-account"></i>
                    <span class="hide-menu">Cotizaciones (Ventas)</span>
                  </a>
                </li>
                <li class="">
                  <a href="<?= base_url('cotizacion/aprobadas') ?>" class="sidebar-link">
                    <i class="mdi mdi-account"></i>
                    <span class="hide-menu">Cotizaciones Aprobadas (V)</span>
                  </a>
                </li>
                <li class="">
                  <a href="<?= base_url('cotizacion/verificadas') ?>" class="sidebar-link">
                    <i class="mdi mdi-account"></i>
                    <span class="hide-menu">Cotizaciones Verificadas (V)</span>
                  </a>
                </li>
                <li class="">
                  <a href="<?= base_url('cotizacion/logistica') ?>" class="sidebar-link">
                    <i class="mdi mdi-cart-plus"></i>
                    <span class="hide-menu">Cotizaciones (Logistica)</span>
                  </a>
                </li>
              </ul>
            </li>

            <!-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('cotizacion/servicio') ?>" aria-expanded="false"><i class="mdi mdi-cash-usd"></i><span class="hide-menu">COTIZACION SERVICIOS</span></a></li> -->
            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('producto/menu') ?>" aria-expanded="false"><i class="fa fa-list-alt"></i><span class="hide-menu">PRODUCTOS</span></a></li>
            <!-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('servicio') ?>" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">SERVICIOS</span></a></li> -->
            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('venta') ?>" aria-expanded="false"><i class="fas fa-donate"></i><span class="hide-menu">FACTURA</span></a></li>
            <li class="sidebar-item">
              <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                <i class="mdi mdi-cart-outline"></i>
                <span class="hide-menu">COMPRAS</span>
              </a>
              <ul aria-expanded="false" class="collapse first-level" style="margin-left: 15px">
                <li class="">
                  <a href="<?= base_url('proveedor') ?>" class="sidebar-link">
                    <i class="mdi mdi-account"></i>
                    <span class="hide-menu">PROVEEDORES</span>
                  </a>
                </li>
                <li class="">
                  <a href="<?= base_url('compra') ?>" class="sidebar-link">
                    <i class="mdi mdi-cart-plus"></i>
                    <span class="hide-menu">COMPRAS</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                <i class="fas fa-chart-pie"></i>
                <span class="hide-menu">CONTABILIDAD</span>
              </a>
              <ul aria-expanded="false" class="collapse first-level" style="margin-left: 15px">
                <li class="">
                  <a href="<?= base_url('kardex') ?>" class="sidebar-link">
                    <i class="fas fa-check"></i>
                    <span class="hide-menu">KARDEX</span>
                  </a>
                </li>
                <li class="">
                  <a href="<?= base_url('concar') ?>" class="sidebar-link">
                    <i class="fas fa-chart-line"></i>
                    <span class="hide-menu">CONCAR</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('reportes') ?>" aria-expanded="false">
                <i class="fa fa-clipboard"></i>
                <span class="hide-menu">REPORTES</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                <i class="	fas fa-lightbulb"></i>
                <span class="hide-menu">GESTIÓN</span>
              </a>
              <ul aria-expanded="false" class="collapse first-level" style="margin-left: 15px">
                <li class="">
                  <a href="<?= base_url('gestion/efectividad') ?>" class="sidebar-link">
                    <i class="fas fa-check"></i>
                    <span class="hide-menu">EFECTIVIDAD</span>
                  </a>
                </li>
                <li class="">
                  <a href="<?= base_url('gestion/meta') ?>" class="sidebar-link">
                    <i class="fas fa-chart-line"></i>
                    <span class="hide-menu">METAS</span>
                  </a>
                </li>
                <li class="">
                  <a href="<?= base_url('gestion/seace') ?>" class="sidebar-link">
                    <i class="	fas fa-file"></i>
                    <span class="hide-menu">SEACE</span>
                  </a>
                </li>
                <li class="">
                  <a href="<?= base_url('gestion/digemid') ?>" class="sidebar-link">
                    <i class="fas fa-donate"></i>
                    <span class="hide-menu">DIGEMID</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('cliente') ?>" aria-expanded="false">
                <i class="fas fa-user-circle"></i>
                <span class="hide-menu">CLIENTES</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('vendedor') ?>" aria-expanded="false">
                <i class="fas fa-child"></i>
                <span class="hide-menu">VENDEDORES</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('auth') ?>" aria-expanded="false">
                <i class="fa fa-id-badge"></i>
                <span class="hide-menu">USUARIOS</span>
              </a>
            </li>
            <li class="text-center p-40 upgrade-btn"></li>
          </ul>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!-- Tomar desde page-wraper-->