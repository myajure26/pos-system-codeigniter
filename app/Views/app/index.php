<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title><?=$title?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="favicon.ico">
        <!-- preloader css -->
        <link rel="stylesheet" href="assets/css/preloader.min.css"
            type="text/css" />
        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style"
            rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet"
            type="text/css" />
        <!-- Custom Css -->
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />
    
    </head>

    <body data-layout="vertical" data-layout-mode="light" data-sidebar="light" data-sidebar-size="lg" data-layout-size="fluid">

        <!-- Begin page -->
        <div id="layout-wrapper">

            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="/" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="assets/images/brands/logo.png" alt=""
                                        height="24">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/brands/logo.png" alt=""
                                        height="24"> <span class="logo-txt">POS System</span>
                                </span>
                            </a>

                            <a href="index.html" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="assets/images/brands/logo.png" alt=""
                                        height="24">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/brands/logo.png" alt=""
                                        height="24"> <span class="logo-txt">POS System</span>
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
                                    src="assets/images/users/avatar-1.jpg"
                                    alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ms-1
                                    fw-medium">Shawn L.</span>
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
                                <a class="dropdown-item" href="app/logout"><i class="mdi
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
                                <a href="/">
                                    <i data-feather="home"></i>
                                    <span data-key="t-dashboard">Inicio</span>
                                </a>
                            </li>
                            <li>
                                <a href="app/audit">
                                    <i data-feather="bar-chart-2"></i>
                                    <span data-key="t-audit">Auditoría</span>
                                </a>
                            </li>

                            <li class="menu-title" data-key="t-menu">Administrar ventas</li>
                            <li>
                                <a href="/app/newSale">
                                    <i data-feather="plus"></i>
                                    <span data-key="t-newSale">Nueva Venta</span>
                                </a>
                            </li>
                            <li>
                                <a href="/app/sales">
                                    <i data-feather="shopping-bag"></i>
                                    <span data-key="t-sales">Ventas</span>
                                </a>
                            </li>
                            <li>
                                <a href="/app/reports">
                                    <i data-feather="pie-chart"></i>
                                    <span data-key="t-reports">Reportes</span>
                                </a>
                            </li>

                            <li class="menu-title" data-key="t-menu">Administrar inventario</li>
                            <li>
                                <a href="/app/products">
                                    <i data-feather="shopping-cart"></i>
                                    <span data-key="t-products">Productos</span>
                                </a>
                            </li>
                            <li>
                                <a href="/app/categories">
                                    <i data-feather="tag"></i>
                                    <span data-key="t-categories">Categorías</span>
                                </a>
                            </li>

                            <li class="menu-title" data-key="t-menu">Administrar usuarios</li>
                            <li>
                                <a href="/app/customers">
                                    <i data-feather="user"></i>
                                    <span data-key="t-customers">Clientes</span>
                                </a>
                            </li>
                            <li>
                                <a href="/app/users">
                                    <i data-feather="users"></i>
                                    <span data-key="t-users">Usuarios</span>
                                </a>
                            </li>

                            <li class="menu-title" data-key="t-menu">Cofiguraciones del sistema</li>
                            <li>
                                <a href="/app/settings">
                                    <i data-feather="settings"></i>
                                    <span data-key="t-settings">Configuración general</span>
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
                            <a href="/">POS System</a>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Developed with <span class="fa fa-heart text-danger"></span> by <a href="https://github.com/DramaQueeen26/pos-system-php" target="_blank"> DramaQueeen26 </a> All rights reserved.
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- JAVASCRIPT -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>
        <script src="assets/libs/feather-icons/feather.min.js"></script>
        <!-- pace js -->
        <script src="assets/libs/pace-js/pace.min.js"></script>
        <!-- DOCUMENT -->
        <script src="assets/js/app.js"></script>
        <script src="assets/js/ajax.js"></script>

    </body>
</html>