<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title><?=$title?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?=base_url('favicon.ico')?>">
        <!-- Sweet Alert -->
        <link href="<?=base_url('assets/libs/sweetalert2/sweetalert2.min.css')?>" rel="stylesheet" type="text/css" />
        <!-- preloader css -->
        <link rel="stylesheet" href="<?=base_url('assets/css/preloader.min.css')?>" type="text/css" />
        <!-- Bootstrap Css -->
        <link href="<?=base_url('assets/css/bootstrap.min.css')?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?=base_url('assets/css/icons.min.css')?>" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?=base_url('assets/css/app.min.css')?>" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    <body>

    <!-- <body data-layout="horizontal"> -->
        <div class="auth-page">
            <div class="container-fluid p-0">
                <div class="row g-0">
                    <div class="col-xxl-3 col-lg-4 col-md-5">
                        <div class="auth-full-page-content d-flex p-sm-5 p-4">
                            <div class="w-100">
                                <div class="d-flex flex-column h-100">
                                    <div class="text-center">
                                        <a href="<?=base_url()?>" class="d-block auth-logo">
                                            <img src="<?=base_url()?>/assets/images/brands/logo.png" alt="" height="28"> <span class="logo-txt"><?=$system?></span>
                                        </a>
                                    </div>
                                    <div class="auth-content my-auto mt-5">
                                        <div class="text-center">
                                            <h5 class="mb-0">¡Bienvenido de vuelta!</h5>
                                            <p class="text-muted mt-2">Inicia sesión para continuar</p>
                                        </div>
                                        <form class="custom-form mt-4 pt-2" action="<?=base_url('app/signin')?>" method="POST">
                                            <div class="response"></div>
                                            <div class="mb-3">
                                                <label class="form-label">Nombre de usuario</label>
                                                <input type="text" class="form-control" id="username" placeholder="Introduce tu nombre de usuario" name="username" >
                                            </div>
                                            <div class="mb-3">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Contraseña</label>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="">
                                                            <a href="<?=base_url('recover')?>" class="text-muted">¿Olvidaste tu contraseña?</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="input-group auth-pass-inputgroup">
                                                    <input type="password" class="form-control" placeholder="Introduce tu contraseña" aria-label="Password" aria-describedby="password-addon" name="password" >
                                                    
                                                    <button class="btn btn-light ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <button class="btn btn-primary w-100 waves-effect waves-light mt-2 sent" type="submit">Iniciar sesión</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="mt-4 mt-md-5 text-center">
                                        <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> <a href="<?=base_url()?>"><?=$system?></a> | Desarrollado con <span class="fa fa-heart text-danger"></span> por <a href="https://github.com/DramaQueeen26" target="_blank"> DramaQueeen26 </a> | Todos los derechos reservados.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end auth full page content -->
                    </div>
                    <!-- end col -->
                    <div class="col-xxl-9 col-lg-8 col-md-7">
                        <div class="auth-bg pt-md-5 p-4 d-flex">
                            <div class="bg-overlay bg-primary"></div>
                            <ul class="bg-bubbles">
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                            </ul>
                            <!-- end bubble effect -->
                            <div class="row justify-content-center align-items-center">
                                <div class="col-xl-7">
                                    <div class="p-0 p-sm-4 px-xl-0">
                                        <div id="reviewcarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-indicators carousel-indicators-rounded justify-content-start ms-0 mb-0">
                                                <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                            </div>
                                            <!-- end carouselIndicators -->
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <div class="testi-contain text-white">
                                                        <i class="bx bxs-quote-alt-left text-success display-6"></i>

                                                        <h4 class="mt-4 fw-medium lh-base text-white">“I feel confident
                                                            imposing change
                                                            on myself. It's a lot more progressing fun than looking back.
                                                            That's why
                                                            I ultricies enim
                                                            at malesuada nibh diam on tortor neaded to throw curve balls.”
                                                        </h4>
                                                        <div class="mt-4 pt-3 pb-5">
                                                            <div class="d-flex align-items-start">
                                                                <div class="flex-shrink-0">
                                                                    <img src="<?=base_url()?>/assets/images/users/avatar-1.jpg" class="avatar-md img-fluid rounded-circle" alt="...">
                                                                </div>
                                                                <div class="flex-grow-1 ms-3 mb-4">
                                                                    <h5 class="font-size-18 text-white">Richard Drews
                                                                    </h5>
                                                                    <p class="mb-0 text-white-50">Web Designer</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="carousel-item">
                                                    <div class="testi-contain text-white">
                                                        <i class="bx bxs-quote-alt-left text-success display-6"></i>

                                                        <h4 class="mt-4 fw-medium lh-base text-white">“Our task must be to
                                                            free ourselves by widening our circle of compassion to embrace
                                                            all living
                                                            creatures and
                                                            the whole of quis consectetur nunc sit amet semper justo. nature
                                                            and its beauty.”</h4>
                                                        <div class="mt-4 pt-3 pb-5">
                                                            <div class="d-flex align-items-start">
                                                                <div class="flex-shrink-0">
                                                                    <img src="<?=base_url()?>/assets/images/users/avatar-2.jpg" class="avatar-md img-fluid rounded-circle" alt="...">
                                                                </div>
                                                                <div class="flex-grow-1 ms-3 mb-4">
                                                                    <h5 class="font-size-18 text-white">Rosanna French
                                                                    </h5>
                                                                    <p class="mb-0 text-white-50">Web Developer</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="carousel-item">
                                                    <div class="testi-contain text-white">
                                                        <i class="bx bxs-quote-alt-left text-success display-6"></i>

                                                        <h4 class="mt-4 fw-medium lh-base text-white">“I've learned that
                                                            people will forget what you said, people will forget what you
                                                            did,
                                                            but people will never forget
                                                            how donec in efficitur lectus, nec lobortis metus you made them
                                                            feel.”</h4>
                                                        <div class="mt-4 pt-3 pb-5">
                                                            <div class="d-flex align-items-start">
                                                                <img src="<?=base_url()?>/assets/images/users/avatar-3.jpg"
                                                                    class="avatar-md img-fluid rounded-circle" alt="...">
                                                                <div class="flex-1 ms-3 mb-4">
                                                                    <h5 class="font-size-18 text-white">Ilse R. Eaton</h5>
                                                                    <p class="mb-0 text-white-50">Manager
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end carousel-inner -->
                                        </div>
                                        <!-- end review carousel -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container fluid -->
        </div>

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
        <!-- password addon init -->
        <script src="<?=base_url('assets/js/pages/pass-addon.init.js')?>"></script>
        <!-- ajax -->
        <script src="<?=base_url('assets/js/signin.js')?>"></script>

    </body>

</html>