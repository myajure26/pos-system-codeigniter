<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title><?=$title?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?=base_url()?>/favicon.ico">
        <!-- Datatables -->
        <link href="<?=base_url('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')?>" rel="stylesheet" type="text/css" />
        <link href="<?=base_url('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')?>" rel="stylesheet" type="text/css" />
        <link href="<?=base_url('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')?>" rel="stylesheet" type="text/css" />
        <!-- Sweet Alert -->
        <link href="<?=base_url('assets/libs/sweetalert2/sweetalert2.min.css')?>" rel="stylesheet" type="text/css" />
        <!-- preloader css -->
        <link href="<?=base_url('assets/css/preloader.min.css')?>" rel="stylesheet" type="text/css" />
        <!-- Bootstrap Css -->
        <link href="<?=base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?=base_url('assets/css/icons.min.css')?>" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?=base_url('assets/css/app.min.css')?>" rel="stylesheet" type="text/css" />
        <!-- Custom Css -->
        <link href="<?=base_url('assets/css/custom.css')?>" rel="stylesheet" type="text/css" />
    
    </head>

    <body data-layout="vertical" data-layout-mode="light" data-sidebar="light" data-sidebar-size="lg" data-layout-size="fluid">

        <!-- Begin page -->
        <div id="layout-wrapper">

            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="<?=base_url('#dashboard')?>" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="<?=base_url('assets/images/brands/logo.png')?>"
                                        height="24">
                                </span>
                                <span class="logo-lg">
                                    <img src="<?=base_url('assets/images/brands/logo.png')?>"
                                        height="24"> <span class="logo-txt"><?=$system?></span>
                                </span>
                            </a>

                            <a href="<?=base_url('#dashboard')?>" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="<?=base_url('assets/images/brands/logo.png')?>"
                                        height="24">
                                </span>
                                <span class="logo-lg">
                                    <img src="<?=base_url('assets/images/brands/logo.png')?>"
                                        height="24"> <span class="logo-txt"><?=$system?></span>
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3
                            font-size-16 header-item" id="vertical-menu-btn">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>

                    </div>

                    <div class="d-flex">

                        <div class="dropdown d-none d-sm-inline-block">
                            <button type="button" class="btn header-item"
                                id="mode-setting-btn">
                                <i data-feather="moon" class="icon-lg
                                    layout-mode-dark"></i>
                                <i data-feather="sun" class="icon-lg
                                    layout-mode-light"></i>
                            </button>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item
                                bg-soft-light border-start border-end"
                                id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <img class="rounded-circle header-profile-user"
                                    src="<?php if($photo != ''){
                                        echo $photo;
                                    }else{
                                        echo base_url('assets/images/users/anonymous.png');
                                    }
                                    ?>"
                                    alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ms-1
                                    fw-medium"><?=$name?></span>
                                <i class="mdi mdi-chevron-down d-none
                                    d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item" href="#"><i class="mdi
                                        mdi-face-profile font-size-16
                                        align-middle me-1"></i> Perfil</a>
                                <a class="dropdown-item" href="#"><i class="mdi
                                        mdi-account-settings font-size-16
                                        align-middle me-1"></i> Opciones</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?=base_url('app/logout')?>"><i class="mdi
                                        mdi-logout font-size-16 align-middle
                                        me-1"></i> Cerrar sesión</a>
                            </div>
                        </div>

                    </div>
                </div>
            </header>

            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <div data-simplebar class="h-100">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title" data-key="t-menu">Panel de control</li>
                            <li>
                                <a href="<?=base_url('#dashboard')?>">
                                    <i data-feather="home"></i>
                                    <span data-key="t-dashboard">Inicio</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=base_url('#audits')?>">
                                    <i data-feather="bar-chart-2"></i>
                                    <span data-key="t-audit">Auditoría</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=base_url('#controlCenter')?>">
                                    <i data-feather="tool"></i>
                                    <span data-key="t-control">Centro de control</span>
                                </a>
                            </li>
                            <li class="menu-title" data-key="t-menu">Administrar ventas</li>
                            <li>
                                <a href="<?=base_url('#newSale')?>">
                                    <i data-feather="plus"></i>
                                    <span data-key="t-newSale">Nueva venta</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=base_url('#sales')?>">
                                    <i data-feather="shopping-bag"></i>
                                    <span data-key="t-sales">Ventas</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=base_url('#reports')?>">
                                    <i data-feather="pie-chart"></i>
                                    <span data-key="t-reports">Reportes</span>
                                </a>
                            </li>

                            <li class="menu-title" data-key="t-menu">Administrar compras</li>
                            <li>
                                <a href="<?=base_url('#newPurchase')?>">
                                    <i data-feather="plus"></i>
                                    <span data-key="t-newPurchase">Nueva compra</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=base_url('#purchases')?>">
                                    <i data-feather="credit-card"></i>
                                    <span data-key="t-purchases">Compras</span>
                                </a>
                            </li>

                            <li class="menu-title" data-key="t-menu">Administrar inventario</li>
                            <li>
                                <a href="<?=base_url('#store')?>">
                                    <i data-feather="database"></i>
                                    <span data-key="t-store">Almacén</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=base_url('#products')?>">
                                    <i data-feather="shopping-cart"></i>
                                    <span data-key="t-products">Productos</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=base_url('#categories')?>">
                                    <i data-feather="tag"></i>
                                    <span data-key="t-categories">Categorías</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=base_url('#brands')?>">
                                    <i data-feather="hash"></i>
                                    <span data-key="t-brand">Marcas</span>
                                </a>
                            </li>

                            <li class="menu-title" data-key="t-menu">Administrar usuarios</li>
                            <li>
                                <a href="<?=base_url('#customers')?>">
                                    <i data-feather="user"></i>
                                    <span data-key="t-customers">Clientes</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=base_url('#providers')?>">
                                    <i data-feather="user-check"></i>
                                    <span data-key="t-providers">Proveedores</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=base_url('#users')?>">
                                    <i data-feather="user-plus"></i>
                                    <span data-key="t-users">Usuarios</span>
                                </a>
                            </li>

                            <li class="menu-title" data-key="t-menu">Configuraciones del sistema</li>
                            <li>
                                <a href="<?=base_url('#settings')?>">
                                    <i data-feather="settings"></i>
                                    <span data-key="t-settings">Configuración general</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=base_url('#coins')?>">
                                    <i data-feather="dollar-sign"></i>
                                    <span data-key="t-coins">Monedas</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=base_url('#taxes')?>">
                                    <i data-feather="file-text"></i>
                                    <span data-key="t-taxes">Impuesto</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content" id="miniaresult"></div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script>
                            ©
                            <a href="<?=base_url()?>"><?=$system?></a>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Desarrollado con <span class="fa fa-heart text-danger"></span> por <a href="https://github.com/DramaQueeen26" target="_blank"> DramaQueeen26 </a> | Todos los derechos reservados
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- JAVASCRIPT -->
        <script src="<?=base_url('assets/libs/jquery/jquery.min.js')?>"></script>
        <script src="<?=base_url('assets/libs/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
        <script src="<?=base_url('assets/libs/metismenu/metisMenu.min.js')?>"></script>
        <script src="<?=base_url('assets/libs/simplebar/simplebar.min.js')?>"></script>
        <script src="<?=base_url('assets/libs/node-waves/waves.min.js')?>"></script>
        <script src="<?=base_url('assets/libs/feather-icons/feather.min.js')?>"></script>
        <!-- Sweet Alert -->
        <script src="<?=base_url('assets/libs/sweetalert2/sweetalert2.min.js')?>"></script>
        <!-- pace js -->
        <script src="<?=base_url('assets/libs/pace-js/pace.min.js')?>"></script>
        <!-- datatables -->
        <!-- Required datatable js -->
        <script src="<?=base_url('assets/libs/datatables.net/js/jquery.dataTables.min.js')?>"></script>
        <script src="<?=base_url('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')?>"></script>
        <!-- buttton datatable -->
        <script src="<?=base_url('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')?>"></script>
        <script src="<?=base_url('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')?>"></script>
        <script src="<?=base_url('assets/libs/jszip/jszip.min.js')?>"></script>
        <script src="<?=base_url('assets/libs/pdfmake/build/pdfmake.min.js')?>"></script>
        <script src="<?=base_url('assets/libs/pdfmake/build/vfs_fonts.js')?>"></script>
        <script src="<?=base_url('assets/libs/datatables.net-buttons/js/buttons.html5.min.js')?>"></script>
        <script src="<?=base_url('assets/libs/datatables.net-buttons/js/buttons.print.min.js')?>"></script>
        <script src="<?=base_url('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js')?>"></script>
        <!-- responsive datatables -->
        <script src="<?=base_url('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')?>"></script>
        <script src="<?=base_url('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')?>"></script>
        <!-- table config -->
        <script src="<?=base_url('assets/js/tableConfig.js')?>"></script>
        <!-- price format -->
        <script src="<?=base_url('assets/libs/price-format/priceformat.min.js')?>"></script>
        <!-- DOCUMENT -->
        <script src="<?=base_url('assets/js/app.js')?>"></script>
        <script src="<?=base_url('assets/js/ajax.js')?>"></script>

    </body>
</html>