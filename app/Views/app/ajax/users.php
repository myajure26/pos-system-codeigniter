<script>
    document.title = "<?= $title ?>";
</script>
<div class="page-content">
    <div class="container-fluid">

        <button class="float-btn waves-effect" data-bs-toggle="modal" data-bs-target="#newUserModal" >
          <span>+</span>
        </button>

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center
                    justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Usuarios</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:
                                    void(0);">Administrar usuarios</a></li>
                            <li class="breadcrumb-item active">Usuarios</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Administrar usuarios</h4>
                        <p class="card-title-desc">En este módulo podrás ver, agregar, actualizar y eliminar usuarios.</p>
                    </div>
                    <div class="card-body">
                        <table class="table text-nowrap table-striped nowrap w-100" id="datatable">
                            <thead>
                                <tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Cédula</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Foto</th>
                                        <th>Privilegio</th>
                                        <th>Última sesión</th>
                                        <th>Acciones</th>
                                    </tr>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

<!--  Large modal example -->
<div class="modal fade" id="newUserModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Nuevo usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="custom-form" action="<?=base_url('users/create')?>" method="POST">
                <div class="modal-body">
                    <div class="response"></div>
                    <div class="mb-3">
                        <label class="form-label">Cédula</label>
                        <input type="text" class="form-control" id="ci" placeholder="Introduce el número de cédula" name="ci" minlength="7" maxlength="8">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" placeholder="Introduce el nombre del usuario" name="name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="email" placeholder="Introduce el correo electrónico" name="email">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Introduce la contraseña</label>
                        <div class="input-group auth-pass-inputgroup">
                            <input type="password" class="form-control" placeholder="Introduce la contraseña" aria-label="Password" aria-describedby="password-addon" name="password" >
                            <button class="btn btn-light ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Privilegio</label>
                        <select class="form-select" name="privilege" required>
                            <option value="">Selecciona el perfil</option>
                            <option value="admin">Administrador</option>
                            <option value="special">Especial</option>
                            <option value="seller">Vendedor</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Selecciona una foto de perfil</label>
                        <input class="form-control photo" type="file" name="photo">
                        <div class="d-flex align-items-center justify-content-around mt-3">
                            <span class="badge text-info mt-2">Tamaño máximo: 3MB</span>
                            <img src="<?=base_url('assets/images/users/anonymous.png')?>" class="rounded-circle img" width="100px">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light sent">Guardar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- update user -->
<div class="modal fade" id="updateUserModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Nuevo usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="custom-form" action="<?=base_url('users/create')?>" method="POST">
                <div class="modal-body">
                    <div class="response"></div>
                    <div class="mb-3">
                        <label class="form-label">Cédula</label>
                        <input type="text" class="form-control" id="ci" placeholder="Introduce el número de cédula" name="ci" minlength="7" maxlength="8">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="updateName" placeholder="Introduce el nombre del usuario" name="name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="email" placeholder="Introduce el correo electrónico" name="email">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Introduce la contraseña</label>
                        <div class="input-group auth-pass-inputgroup">
                            <input type="password" class="form-control" placeholder="Introduce la contraseña" aria-label="Password" aria-describedby="password-addon" name="password" >
                            <button class="btn btn-light ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Privilegio</label>
                        <select class="form-select" name="privilege" required>
                            <option value="">Selecciona el perfil</option>
                            <option value="admin">Administrador</option>
                            <option value="special">Especial</option>
                            <option value="seller">Vendedor</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Selecciona una foto de perfil</label>
                        <input class="form-control photo" type="file" name="photo">
                        <div class="d-flex align-items-center justify-content-around mt-3">
                            <span class="badge text-info mt-2">Tamaño máximo: 3MB</span>
                            <img src="<?=base_url('assets/images/users/anonymous.png')?>" class="rounded-circle img" width="100px">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light sent">Guardar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- password addon init -->
<script src="<?=base_url('assets/js/pages/pass-addon.init.js')?>"></script>
<!-- image validation -->
<script src="<?=base_url('assets/js/imageValidation.js')?>"></script>
<!-- table config -->
<script src="<?=base_url('assets/js/tableConfig.js')?>"></script>
<script>
    tableConfig('/users/get');
</script>
<!-- ajax -->
<script src="<?=base_url('assets/js/ajaxForm.js')?>"></script>
<script src="<?=base_url('assets/js/ajaxReload.js')?>"></script>
<script src="<?=base_url('assets/js/users.js')?>"></script>
