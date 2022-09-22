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
                                    void(0);">Administrar compras</a></li>
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
                        <table class="table text-nowrap table-striped nowrap w-100" id="datatable">
                            <thead>
                                <tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>RIF</th>
                                        <th>Dirección</th>
                                        <th>Teléfonos</th>
                                        <th>Tipo</th>
                                        <th>Creado en</th>
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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Nuevo proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="custom-form" action="<?=base_url('providers/create')?>" method="POST">
                <div class="modal-body">
                    <div class="response"></div>
                    <div class="mb-3">
                        <label class="form-label">Código</label>
                        <input type="text" class="form-control" id="code" placeholder="Introduce el código del proveedor" name="code" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">RIF</label>
                        <div class="row">
                            <div class="col-sm-2">
                                <select class="form-select" name="rifLetter" id="rifLetter">
                                    <option value="V">V</option>
                                    <option value="J">J</option>
                                    <option value="E">E</option>
                                    <option value="P">P</option>
                                    <option value="G">G</option>
                                </select>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="rif" placeholder="Introduce el número de rif" name="rif" required maxlength="10" minlength="7">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" placeholder="Introduce el nombre del proveedor" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dirección</label>
                        <textarea class="form-control" id="address" placeholder="Introduce la dirección del proveedor" name="address" required cols="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="phone" placeholder="Introduce el teléfono del proveedor" name="phone" required maxlength="11" minlength="11">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Teléfono (opcional)</label>
                        <input type="text" class="form-control" id="phone2" placeholder="Se puede dejar en blanco" name="phone2" maxlength="11" minlength="11">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo de proveedor</label>
                        <select class="form-select" name="providerType" id="providerType" required>
                            <option value="">Selecciona el tipo</option>
                            <option value="normal">Normal</option>
                        </select>
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

<!-- update provider -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Actualizar categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="custom-form" action="<?=base_url('providers/update')?>" method="POST">
                <div class="modal-body">
                    <div class="response"></div>
                    <input type="hidden" id="updateId" name="id" value="">
                    <div class="mb-3">
                        <label class="form-label">Código</label>
                        <input type="text" class="form-control" id="updateCode" placeholder="Introduce el código del proveedor" name="code" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">RIF</label>
                        <div class="row">
                            <div class="col-sm-2">
                                <select class="form-select" name="rifLetter" id="updateRifLetter">
                                    <option value="V">V</option>
                                    <option value="J">J</option>
                                    <option value="E">E</option>
                                    <option value="P">P</option>
                                    <option value="G">G</option>
                                </select>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="updateRif" placeholder="Introduce el número de rif" name="rif" required maxlength="10" minlength="7">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="updateName" placeholder="Introduce el nombre del proveedor" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dirección</label>
                        <textarea class="form-control" id="updateAddress" placeholder="Introduce la dirección del proveedor" name="address" required cols="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="updatePhone" placeholder="Introduce el teléfono del proveedor" name="phone" required maxlength="11" minlength="11">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Teléfono (opcional)</label>
                        <input type="text" class="form-control" id="updatePhone2" placeholder="Se puede dejar en blanco" name="phone2" maxlength="11" minlength="11">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo de proveedor</label>
                        <select class="form-select" name="providerType" id="updateProviderType" required>
                            <option value="">Selecciona el tipo</option>
                            <option value="normal">Normal</option>
                        </select>
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
    tableConfig('/providers/get');

    function updateProvider(data){
        $('#updateId').val(data[0].id);
        $('#updateCode').val(data[0].code);
        $('#updateName').val(data[0].name);
        $('#updateRifLetter').val(data[0].rifLetter);
        $('#updateRif').val(data[0].rif);
        $('#updateAddress').val(data[0].address);
        $('#updatePhone').val(data[0].phone);
        $('#updatePhone2').val(data[0].phone2);
        $('#updateProviderType').val(data[0].type);
    }
</script>

