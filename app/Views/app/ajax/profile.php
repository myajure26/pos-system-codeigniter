<script>
    document.title = "<?= $title ?>";
</script>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center
                    justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Perfil</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:
                                    void(0);">Configuraciones del sistema</a></li>
                            <li class="breadcrumb-item active">Perfil</li>
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
                        <h4 class="card-title">Administrar perfil</h4>
                        <p class="card-title-desc">En este módulo podrás actualizar tu perfil.</p>
                    </div>
                    <div class="card-body">
                        <form class="custom-form viewForm" action="<?=base_url('users/updateCurrentUser')?>" method="POST">
                            <input type="hidden" name="identification" value="<?= $user->identificacion?>">
                            <div class="response"></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Cédula</label>
                                        <input type="text" class="form-control viewDisabled" id="viewIdentification" minlength="7" maxlength="8" value="<?= $user->identificacion?>" disabled required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="viewName" name="name" value="<?= $user->nombre?>" disabled required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Correo electrónico</label>
                                        <input type="email" class="form-control" id="viewEmail" name="email" value="<?= $user->correo?>" disabled required >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Privilegio</label>
                                        <select class="form-select viewDisabled" id="viewPrivilege" value="<?= $user->privilegio?>" disabled required>
                                            <?php foreach($privileges as $row)
                                                echo '<option value="'.$row->identificacion.'">'.$row->nombre.'</option>';
                                            ?>>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="viewPasswordPreview" name="viewPasswordPreview" value="<?= $user->clave?>">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Contraseña</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control" placeholder="Dejar en blanco si no va a actualizar la contraseña" aria-label="Password" aria-describedby="password-addon" name="password" id="viewPassword" disabled>
                                            <button class="btn btn-light ms-0" type="button" id="password-addon2"><i class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Seleccione una foto de perfil</label>
                                        <input type="hidden" name="viewPhotoPreview" id="viewPhotoPreview" value="<?= $user->foto?>">
                                        <input class="form-control photo" type="file" name="photo" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <img src="<?php
                                        if($user->foto != NULL && $user->foto != ''){
                                            echo $user->foto;
                                        }else{

                                           echo base_url('assets/images/users/anonymous.png');
                                        }
                                        
                                        ?>" class="rounded-circle img d-block mx-auto" width="150px" id="viewPhoto">
                                        <span class="badge text-info mt-2 d-block mx-auto">Tamaño máximo: 3MB</span>
                                        <button type="button" class="btn btn-danger btn-sm mt-2 d-block mx-auto deletePhoto btn-disabled" disabled>Eliminar foto</button>
                                        
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Última sesión</label>
                                        <input type="text" class="form-control viewDisabled" id="viewLastSession"  value="<?= $user->ultima_sesion?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Fecha de creación</label>
                                        <input type="text" class="form-control viewDisabled" id="viewCreated"  value="<?= $user->creado_en?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Fecha de actualización</label>
                                        <input type="text" class="form-control viewDisabled" id="viewUpdated"  value="<?= $user->actualizado_en?>" disabled>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" class="btn btnUpdate btn-primary waves-effect waves-light">Editar</button>
                            <button type="submit" class="btn btnSubmit btn-primary waves-effect waves-light" style="display: none;">Guardar</button>
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

<!-- password addon init -->
<script src="<?=base_url('assets/js/pages/pass-addon.init.js')?>"></script>
<!-- image validation -->
<script src="<?=base_url('assets/js/imageValidation.js')?>"></script>

