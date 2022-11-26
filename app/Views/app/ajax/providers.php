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
                    <h4 class="mb-sm-0 font-size-18">Proveedores</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:
                                    void(0);">Administrar usuarios</a></li>
                            <li class="breadcrumb-item active">Proveedores</li>
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
                        <h4 class="card-title">Administrar proveedores</h4>
                        <p class="card-title-desc">En este módulo podrás ver, agregar, actualizar y eliminar proveedores.</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mt-2 mb-4">
                                <label class="form-label">Filtros</label>
                                <select class="form-select" id="status_db">
                                    <option value="">Todos los proveedores</option>
                                    <option value="1">Proveedores activados</option>
                                    <option value="0">Proveedores desactivados</option>
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
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Cédula/Rif</th>
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

<!--  add provider -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Nuevo proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="custom-form" action="<?=base_url('providers/create')?>" method="POST">
                <div class="modal-body">
                    <div class="response"></div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label class="form-label">Código</label>
                                <input type="text" class="form-control" id="code" placeholder="Introduce el código del proveedor" name="code" id="name" required>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label class="form-label">Cédula/Rif</label>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <select class="form-select" name="letter">
                                            <option value="V">V</option>
                                            <option value="J">J</option>
                                            <option value="E">E</option>
                                            <option value="P">P</option>
                                            <option value="G">G</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control ci-rif" placeholder="Introduce el número de cédula/rif" name="legalIdentification" id="legalIdentification" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" class="form-control name" id="name" placeholder="Introduce el nombre del proveedor" name="name" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Teléfono</label>
                                <input type="numer" class="form-control phone" id="phone" placeholder="Introduce el teléfono del proveedor" name="phone" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dirección</label>
                        <textarea class="form-control address" id="address" placeholder="Introduce la dirección del proveedor" name="address" required cols="2"></textarea>
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

<!-- view provider -->
<div id="viewModal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ver detalles del proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="custom-form viewForm" action="<?=base_url('providers/update')?>" method="POST">
                <div class="modal-body">
                    <div class="response"></div>
                    <input type="hidden" id="viewCodePreview" name="code" value="">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label class="form-label">Código</label>
                                <input type="text" class="form-control viewDisabled" id="viewCode" disabled>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label class="form-label">Cédula/Rif</label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <select class="form-select" name="letter" id="viewLetter" disabled>
                                            <option value="V">V</option>
                                            <option value="J">J</option>
                                            <option value="E">E</option>
                                            <option value="P">P</option>
                                            <option value="G">G</option>
                                        </select>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control ci-rif" id="viewIdentification" name="legalIdentification" disabled>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" class="form-control name" id="viewName" name="name" disabled>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Teléfono</label>
                                <input type="number" class="form-control phone" id="viewPhone" name="phone" disabled>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Dirección</label>
                        <textarea class="form-control address" id="viewAddress" name="address" disabled></textarea>
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
    tableConfig('/providers/get', '.datatable');

    function viewProvider(data){
        $('#viewCodePreview').val(data[0].codigo);
        $('#viewCode').val(data[0].codigo);
        $('#viewName').val(data[0].nombre);
        $('#viewLetter').val(data[0].identificacion.split('-')[0]);
        $('#viewIdentification').val(data[0].identificacion.split('-')[1]);
        $('#viewAddress').val(data[0].direccion);
        $('#viewPhone').val(data[0].telefono);
        $('#viewCreated').val(data[0].creado_en);
        $('#viewUpdated').val(data[0].actualizado_en);
    }
    $("#range").flatpickr({
        locale: 'es',
        mode: 'range',
        maxDate: 'today'
    });
</script>

