<script>
    document.title = "<?= $title ?>";
</script>
<div class="page-content">
    <div class="container-fluid">

        <button class="float-btn waves-effect" data-bs-toggle="modal" data-bs-target="#createModal" >
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

<!--  add user -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
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
                        <input type="text" class="form-control" id="ci" placeholder="Introduce el número de cédula" name="ci" minlength="7" maxlength="8" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" placeholder="Introduce el nombre del usuario" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="email" placeholder="Introduce el correo electrónico" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Introduce la contraseña</label>
                        <div class="input-group auth-pass-inputgroup">
                            <input type="password" class="form-control" placeholder="Introduce la contraseña" aria-label="Password" aria-describedby="password-addon" name="password" required>
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
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Actualizar usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="custom-form" action="<?=base_url('users/update')?>" method="POST">
                <div class="modal-body">
                    <div class="response"></div>
                    <input type="hidden" id="updateId" name="id" value="">
                    <div class="mb-3">
                        <label class="form-label">Cédula</label>
                        <input type="text" class="form-control" id="updateCi" placeholder="Introduce el número de cédula" name="ci" minlength="7" maxlength="8" readonly required>
                        <small class="w-100 text-info mt-1">La cédula no se puede cambiar</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="updateName" placeholder="Introduce el nombre del usuario" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="updateEmail" placeholder="Introduce el correo electrónico" name="email" required>
                    </div>
                    <input type="hidden" id="updatePasswordPreview" name="updatePasswordPreview" value="">
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <div class="input-group auth-pass-inputgroup">
                            <input type="password" class="form-control" placeholder="Dejar en blanco si no va a actualizar la contraseña" aria-label="Password" aria-describedby="password-addon" name="password" id="updatePassword">
                            <button class="btn btn-light ms-0" type="button" id="password-addon2"><i class="mdi mdi-eye-outline"></i></button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Privilegio</label>
                        <select class="form-select" name="privilege" id="updatePrivilege" required>
                            <option value="">Selecciona el perfil</option>
                            <option value="admin">Administrador</option>
                            <option value="special">Especial</option>
                            <option value="seller">Vendedor</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Selecciona una foto de perfil</label>
                        <input type="hidden" name="updatePhotoPreview" id="updatePhotoPreview" value="">
                        <input class="form-control photo" type="file" name="photo">
                        <div class="d-flex align-items-center justify-content-around mt-3">
                            <span class="badge text-info mt-2">Tamaño máximo: 3MB</span>
                            <img src="<?=base_url('assets/images/users/anonymous.png')?>" class="rounded-circle img" width="100px" id="updatePhoto">
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


<script>
    tableConfig('/users/get');

    function updateUser(data){
        $('.photo').val('');
        $('#updateId').val(data[0].id);
        $('#updateCi').val(data[0].ci);
        $('#updateName').val(data[0].name);
        $('#updateEmail').val(data[0].email);
        $('#updatePasswordPreview').val(data[0].password);
        $('#updatePrivilege').val(data[0].privilege);
        $('#updatePhotoPreview').val(data[0].photo);
        $('#updatePhoto').attr('src', url + "/assets/images/users/anonymous.png");
        if(data[0].photo != null && data[0].photo != ''){
            $('#updatePhoto').attr('src', data[0].photo);
        }
    }
</script>
