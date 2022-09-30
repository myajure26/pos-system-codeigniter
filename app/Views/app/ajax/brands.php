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
                    <h4 class="mb-sm-0 font-size-18">Marcas</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:
                                    void(0);">Administrar inventario</a></li>
                            <li class="breadcrumb-item active">Marcas</li>
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
                        <h4 class="card-title">Administrar marcas</h4>
                        <p class="card-title-desc">En este módulo podrás ver, agregar, actualizar y eliminar marcas.</p>
                    </div>
                    <div class="card-body">
                        <table class="table text-nowrap table-striped nowrap w-100" id="datatable">
                            <thead>
                                <tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
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

<!--  add brand -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Nueva marca</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="custom-form" action="<?=base_url('brands/create')?>" method="POST">
                <div class="modal-body">
                    <div class="response"></div>
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" placeholder="Introduce el nombre de la marca" name="name" required>
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

<!-- view brand -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Ver detalles de marca</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="custom-form viewForm" action="<?=base_url('brands/update')?>" method="POST">
                <div class="modal-body">
                    <div class="response"></div>
                    <input type="hidden" id="viewId" name="id" value="">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="viewName" name="name" disabled required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Fecha de creación</label>
                                <input type="text" class="form-control viewDisabled" id="viewCreated" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
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
    tableConfig('/brands/get');

    function viewBrand(data){
        $('#viewId').val(data[0].id);
        $('#viewName').val(data[0].brand);
        $('#viewCreated').val(data[0].created_at);
        $('#viewUpdated').val(data[0].updated_at);
    }
</script>
