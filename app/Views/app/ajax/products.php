<script>
    document.title = "<?= $title ?>";
</script>
<div class="page-content">
    <div class="container-fluid">

        <button class="float-btn waves-effect" data-bs-toggle="modal" data-bs-target="#newProductModal" >
          <span>+</span>
        </button>

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center
                    justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Productos</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:
                                    void(0);">Administrar inventario</a></li>
                            <li class="breadcrumb-item active">Productos</li>
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
                        <h4 class="card-title">Administrar productos</h4>
                        <p class="card-title-desc">En este módulo podrás ver, agregar, actualizar y eliminar productos.</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mt-2 mb-4">
                                <label class="form-label">Filtros</label>
                                <select class="form-select" id="status_db">
                                    <option value="">Todos los productos</option>
                                    <option value="1">Productos activados</option>
                                    <option value="0">Productos desactivados</option>
                                </select>
                            </div>
                            <div class="col-md-6 mt-2 mb-4">
                                <label class="form-label">Rango de fecha</label>
                                <input type="text" class="form-control" placeholder="Selecciona una fecha" id="range">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-4">
                                <label class="form-label">Ancho</label>
                                <select class="form-select" id="wideFilter">
                                    <option value="">Seleccione el ancho del caucho</option>
                                    <?php foreach($wide as $row)
                                        echo '<option value="'.$row->id_ancho_caucho.'">'.$row->ancho_numero.'</option>';
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-4">
                                <label class="form-label">Alto</label>
                                <select class="form-control" id="highFilter">
                                    <option value="">Seleccione el alto del caucho</option>
                                    <?php foreach($high as $row)
                                        echo '<option value="'.$row->id_alto_caucho.'">'.$row->alto_numero.'</option>';
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-4">
                                <label class="form-label">Categoría</label>
                                <select class="form-select" id="categoryFilter">
                                    <option value="">Seleccione le categoría</option>
                                    <?php foreach($categories as $row)
                                        echo '<option value="'.$row->identificacion.'">'.$row->categoria.'</option>';
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-4">
                                <label class="form-label">Marca</label>
                                <select class="form-control" id="brandFilter">
                                    <option value="">Seleccione la marca</option>
                                    <?php foreach($brands as $row)
                                        echo '<option value="'.$row->identificacion.'">'.$row->marca.'</option>';
                                    ?>
                                </select>
                            </div>
                        </div>
                        <table class="table datatable text-nowrap table-striped nowrap w-100 dt-responsive">
                            <thead>
                                <tr>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Categoría</th>
                                        <th>Marca</th>
                                        <th>Precio</th>
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

<!--  add product -->
<div class="modal fade" id="newProductModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Nuevo producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="custom-form" action="<?=base_url('products/create')?>" method="POST">
                <div class="modal-body">
                    <div class="response"></div>
                    <div class="row">
                        <div class="col-md-6">    
                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" class="form-control name" id="name" placeholder="Introduce el nombre del producto" name="name" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Categoría</label>
                                <select class="form-select" name="category" id="category" required>
                                    <option value="">Seleccione le categoría</option>
                                    <?php foreach($categories as $row)
                                        echo '<option value="'.$row->identificacion.'">'.$row->categoria.'</option>';
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Ancho caucho</label>
                                <select class="form-select" name="wide" id="wide" required>
                                    <option value="">Seleccione el ancho del caucho</option>
                                    <?php foreach($wide as $row)
                                        echo '<option value="'.$row->id_ancho_caucho.'">'.$row->ancho_numero.'</option>';
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Alto caucho</label>
                                <select class="form-select" name="high" id="high" required>
                                    <option value="">Seleccione la altura del caucho</option>
                                    <?php foreach($high as $row)
                                        echo '<option value="'.$row->id_alto_caucho.'">'.$row->alto_numero.'</option>';
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Marca</label>
                                <select class="form-select" name="brand" id="brand" required>
                                    <option value="">Seleccione la marca</option>
                                    <?php foreach($brands as $row)
                                        echo '<option value="'.$row->identificacion.'">'.$row->marca.'</option>';
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Precio</label>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" readonly value="<?=$coin?>">
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control price" id="price" placeholder="Introduce el precio del producto" name="price" required value="0.00" maxlength="14">
                                    </div>
                                </div>
                            </div>
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

<!-- view product -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Ver detalles del producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="custom-form viewForm" action="<?=base_url('products/update')?>" method="POST">
                <input type="hidden" id="viewIdentification" name="code" value="">
                <div class="modal-body">
                    <div class="response"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Código</label>
                                <input type="text" class="form-control viewDisabled" id="viewCode" disabled required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" class="form-control name" id="viewName" name="name" disabled required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Ancho caucho</label>
                                <select class="form-select" name="wide" id="viewWide" required disabled>
                                    <option value="">Seleccione el ancho del caucho</option>
                                    <?php foreach($wide as $row)
                                        echo '<option value="'.$row->id_ancho_caucho.'">'.$row->ancho_numero.'</option>';
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Alto caucho</label>
                                <select class="form-select" name="high" id="viewHigh" required disabled>
                                    <option value="">Seleccione la altura del caucho</option>
                                    <?php foreach($high as $row)
                                        echo '<option value="'.$row->id_alto_caucho.'">'.$row->alto_numero.'</option>';
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Categoría</label>
                                <select class="form-select" name="category" id="viewCategory" disabled required>
                                    <option value="">Seleccione la categoría</option>
                                    <?php foreach($categories as $row)
                                        echo '<option value="'.$row->identificacion.'">'.$row->categoria.'</option>';
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Marca</label>
                                <select class="form-select" name="brand" id="viewBrand" disabled required>
                                    <option value="">Seleccione la marca</option>
                                    <?php foreach($brands as $row)
                                        echo '<option value="'.$row->identificacion.'">'.$row->marca.'</option>';
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col -md-6">
                            <div class="mb-3">
                                <label class="form-label">Precio</label>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" readonly value="<?=$coin?>">
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control price" id="viewPrice" name="price" disabled required maxlength="14">
                                    </div>
                                </div>
                            </div>
                        </div>
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
    tableConfig('/products/get', '.datatable');
    $(".price").priceFormat({
        prefix: ''
    });

    function viewProduct(data){
        $('#viewIdentification').val(data[0].codigo);
        $('#viewCode').val(data[0].codigo);
        $('#viewName').val(data[0].nombre);
        $('#viewWide').val(data[0].id_ancho_caucho);
        $('#viewHigh').val(data[0].id_alto_caucho);
        $('#viewBrand').val(data[0].marca);
        $('#viewCategory').val(data[0].categoria);
        $('#viewCoin').val(data[0].moneda);
        $('#viewPrice').val(data[0].precio);
        $('#viewTax').val(data[0].impuesto);
        $('#viewCreated').val(data[0].creado_en);
        $('#viewUpdated').val(data[0].actualizado_en);
    }

    $("#range").flatpickr({
        locale: 'es',
        mode: 'range',
        maxDate: 'today'
    });
</script>
