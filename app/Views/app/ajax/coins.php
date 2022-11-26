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
                    <h4 class="mb-sm-0 font-size-18">Monedas</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:
                                    void(0);">Configuraciones del sistema</a></li>
                            <li class="breadcrumb-item active">Monedas</li>
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
                        <h4 class="card-title">Administrar monedas</h4>
                        <p class="card-title-desc">En este módulo podrás ver, agregar, actualizar y eliminar monedas.</p>
                    </div>
                    <div class="card-body">
                        <div class="mt-2 mb-4">
                            <label class="form-label">Filtros</label>
                            <select class="form-select" id="status_db">
                                <option value="">Todas las monedas</option>
                                <option value="1">Monedas activadas</option>
                                <option value="0">Monedas desactivadas</option>
                            </select>
                        </div>
                        <table class="table datatable text-nowrap table-striped nowrap w-100 dt-responsive">
                            <thead>
                                <tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Símbolo</th>
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

<!--  add coin -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Nueva moneda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="custom-form" action="<?=base_url('coins/create')?>" method="POST">
                <div class="modal-body">
                    <div class="response"></div>
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control name" id="name" placeholder="Introduce el nombre de la moneda" name="name" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Símbolo</label>
                        <input type="text" class="form-control symbol" id="symbol" placeholder="Introduce el símbolo de la moneda" name="symbol" required>
                        <div class="invalid-feedback"></div>
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

<!-- view coin -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Ver detalles de moneda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="custom-form viewForm" action="<?=base_url('coins/update')?>" method="POST">
                <div class="modal-body">
                    <div class="response"></div>
                    <input type="hidden" id="viewIdentification" name="identification" value="">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control name" id="viewName" name="name" disabled required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Símbolo</label>
                        <input type="text" class="form-control symbol" id="viewSymbol" name="symbol" maxlength="5" disabled required>
                        <div class="invalid-feedback"></div>
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
    tableConfig('/coins/get', '.datatable');

    function viewCoin(data){
        $('#viewIdentification').val(data[0].identificacion);
        $('#viewName').val(data[0].moneda);
        $('#viewSymbol').val(data[0].simbolo);
        $('#viewCreated').val(data[0].creado_en);
        $('#viewUpdated').val(data[0].actualizado_en);
    }
</script>

