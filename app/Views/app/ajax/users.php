<script>
    document.title = "<?= $title ?>";
</script>
<div class="page-content">
    <div class="container-fluid">

        <button class="float-btn">
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

                        <table class="table text-nowrap table-striped nowrap w-100" id="usersTable">
                            <thead>
                                <tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Usuario</th>
                                        <th>Foto</th>
                                        <th>Rol</th>
                                        <th>Estado</th>
                                        <th>Última sesión</th>
                                        <th>Acciones</th>
                                    </tr>
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-id="1">
                                    <td style="width: 30px">1</td>
                                    <td>David McHenry</td>
                                    <td>David</td>
                                    <td><img src="http://localhost/pos-system-php/assets/images/users/anonymous.png" class="rounded-circle header-profile-user"></td>
                                    <td>Rol</td>
                                    <td><div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-success text-success p-2 px-3 editStatus" user-id="1" status="1">Activado</a></div></td>
                                    <td>Ultima sesion</td>
                                    <td style="width: 100px">
                                        <div class="btn-list"> 
                                            <button type="button" class="btnEditUser btn btn-sm btn-primary" user-id="1" data-bs-effect="effect-scale" data-bs-toggle="modal" data-bs-target="#modalEditUser">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <button id="bDel" type="button" class="btnDeleteUser btn  btn-sm btn-danger" username="admin" photo="">
                                                <i class="fas fa-times-circle"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>        
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

<!-- users page -->
<script src="<?=base_url('assets/js/users.js')?>"></script>