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
                        <div class="row">
                            <div class="col-md-6 mt-2 mb-4">
                                <label class="form-label">Filtros</label>
                                <select class="form-select" id="status_db">
                                    <option value="">Todos los usuarios</option>
                                    <option value="1">Usuarios activados</option>
                                    <option value="0">Usuarios desactivados</option>
                                </select>
                            </div>
                            <div class="col-md-6 mt-2 mb-4">
                                <label class="form-label">Rango de fecha</label>
                                <input type="text" class="form-control" placeholder="Selecciona una fecha" id="range">
                            </div>
                        </div>
                        <table class="table datatable text-nowrap table-striped nowrap w-100 dt-responsive">
                            <thead>
                                <tr>
                                    <tr>
                                        <th>Cédula</th>
                                        <th>Nombre</th>
                                        <th>Privilegio</th>
                                        <th>Foto</th>
                                        <th>Estado</th>
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
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Nuevo usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="custom-form" action="<?=base_url('users/create')?>" method="POST">
                <div class="modal-body">
                    <div class="response"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Cédula</label>
                                <input type="number" class="form-control userIdentification" id="identification" placeholder="Introduce el número de cédula" name="identification" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" class="form-control name" id="name" placeholder="Introduce el nombre del usuario" name="name" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Privilegio</label>
                                <select class="form-select" name="privilege" required>
                                    <option value="">Seleccione el perfil</option>
                                    <?php foreach($privileges as $row)
                                        echo '<option value="'.$row->identificacion.'">'.$row->nombre.'</option>';
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Introduce la contraseña</label>
                                <div class="input-group auth-pass-inputgroup">
                                    <input type="password" class="form-control password" placeholder="Introduce la contraseña" aria-label="Password" aria-describedby="password-addon" name="password" required>
                                    <button class="btn btn-light ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="mb-0">
                                <label class="form-label">Seleccione una foto de perfil</label>
                                <input class="form-control photo" type="file" name="photo"> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <img src="<?=base_url('assets/images/users/anonymous.png')?>" class="rounded-circle img d-block mx-auto" id="newPhoto" width="150px">
                            <div class="badge text-info mt-2 d-block mx-auto">Tamaño máximo: 3MB</div>
                            <button type="button" class="btn btn-danger btn-sm mt-2 d-block mx-auto deletePhoto">Eliminar foto</button>
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

<!-- view user -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Ver detalles del usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="custom-form viewForm" action="<?=base_url('users/update')?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="identification" id="viewIdentificationPreview">
                    <div class="response"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Cédula</label>
                                <input type="number" class="form-control userIdentification viewReadonly" id="viewIdentification" placeholder="Introduce el número de cédula" disabled required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" class="form-control name" id="viewName" placeholder="Introduce el nombre del usuario" name="name" disabled required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Privilegio</label>
                                <select class="form-select" name="privilege" id="viewPrivilege" disabled required>
                                    <option value="">Seleccione el perfil</option>
                                    <?php foreach($privileges as $row)
                                        echo '<option value="'.$row->identificacion.'">'.$row->nombre.'</option>';
                                    ?>>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="viewPasswordPreview" name="viewPasswordPreview" value="">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Contraseña</label>
                                <div class="input-group auth-pass-inputgroup">
                                    <input type="password" class="form-control password" placeholder="Dejar en blanco si no va a actualizar la contraseña" aria-label="Password" aria-describedby="password-addon" name="password" id="viewPassword" disabled>
                                    <button class="btn btn-light ms-0" type="button" id="password-addon2"><i class="mdi mdi-eye-outline"></i></button>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="mb-0">
                                <label class="form-label">Seleccione una foto de perfil</label>
                                <input type="hidden" name="viewPhotoPreview" id="viewPhotoPreview" value="">
                                <input class="form-control photo" type="file" name="photo" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <img src="<?=base_url('assets/images/users/anonymous.png')?>" class="rounded-circle img d-block mx-auto" width="150px" id="viewPhoto">
                                <span class="badge text-info mt-2 d-block mx-auto">Tamaño máximo: 3MB</span>
                                <button type="button" class="btn btn-danger btn-sm mt-2 d-block mx-auto deletePhoto btn-disabled" disabled>Eliminar foto</button>
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Última sesión</label>
                                <input type="text" class="form-control viewDisabled" id="viewLastSession" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Fecha de creación</label>
                                <input type="text" class="form-control viewDisabled" id="viewCreated" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Fecha de actualización</label>
                                <input type="text" class="form-control viewDisabled" id="viewUpdated" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btnClose btn-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btnUpdate btn-primary waves-effect waves-light">Editar</button>
                    <button type="submit" class="btn btnSubmit btn-primary waves-effect waves-light" style="display: none;">Guardar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>
    tableConfig('/users/get', '.datatable');

    function viewUser(data){
        $('.photo').val('');
        $('#viewIdentificationPreview').val(data[0].identificacion);
        $('#viewIdentification').val(data[0].identificacion);
        $('#viewName').val(data[0].nombre);
        $('#viewEmail').val(data[0].correo);
        $('#viewPasswordPreview').val(data[0].clave);
        $('#viewLastSession').val(data[0].ultima_sesion);
        $('#viewPrivilege').val(data[0].privilegio);
        $('#viewPhotoPreview').val(data[0].foto);
        $('#viewPhoto').attr('src', url + "/assets/images/users/anonymous.png");
        if(data[0].foto != null && data[0].foto != ''){
            $('#viewPhoto').attr('src', data[0].foto);
        }
        $('#viewCreated').val(data[0].creado_en);
        $('#viewUpdated').val(data[0].actualizado_en);
    }
    $("#range").flatpickr({
        locale: 'es',
        mode: 'range',
        maxDate: 'today'
    });
</script>
<!-- password addon init -->
<script src="<?=base_url('assets/js/pages/pass-addon.init.js')?>"></script>
<!-- image validation -->
<script src="<?=base_url('assets/js/imageValidation.js')?>"></script>