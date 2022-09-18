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
                        <table class="table text-nowrap table-striped nowrap w-100" id="datatable">
                            <thead>
                                <tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Marca</th>
                                        <th>Categoría</th>
                                        <th>Precio</th>
                                        <th>Impuesto</th>
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

<!--  add product -->
<div class="modal fade" id="newProductModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Nuevo producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="custom-form" action="<?=base_url('products/create')?>" method="POST">
                <div class="modal-body">
                    <div class="response"></div>
                    <div class="mb-3">
                        <label class="form-label">Código</label>
                        <input type="text" class="form-control" id="code" placeholder="Introduce el código del producto" name="code" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" placeholder="Introduce el nombre del producto" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Marca</label>
                        <select class="form-select" name="brand" id="brand" required>
                            <option value="">Selecciona la marca</option>
                            <?php foreach($brands as $row)
                                echo '<option value="'.$row->id.'">'.$row->brand.'</option>';
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Categoría</label>
                        <select class="form-select" name="category" id="category" required>
                            <option value="">Selecciona la categoría</option>
                            <?php foreach($categories as $row)
                                echo '<option value="'.$row->id.'">'.$row->category.'</option>';
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Precio</label>
                        <div class="row">
                            <div class="col-sm-2">
                                <select class="form-select price" name="coin" id="coin" required>
                                <?php foreach($coins as $row)
                                    echo '<option value="'.$row->id.'">'.$row->symbol.'</option>';
                                ?>
                                </select>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="price" placeholder="Introduce el precio del producto" name="price" required value="0.00">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Impuesto</label>
                        <select class="form-select" name="tax" id="tax" required>
                            <option value="">Selecciona el impuesto</option>
                            <?php foreach($taxes as $row)
                                echo '<option value="'.$row->id.'">'.$row->tax.'</option>';
                            ?>
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

<!-- update category -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Actualizar categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="custom-form" action="<?=base_url('products/update')?>" method="POST">
                <input type="hidden" id="updateId" name="id" value="">
                <div class="modal-body">
                    <div class="response"></div>
                    <div class="mb-3">
                        <label class="form-label">Código</label>
                        <input type="text" class="form-control" id="updateCode" name="code" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="updateName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Marca</label>
                        <select class="form-select" name="brand" id="updateBrand" required>
                            <option value="">Selecciona la marca</option>
                            <?php foreach($brands as $row)
                                echo '<option value="'.$row->id.'">'.$row->brand.'</option>';
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Categoría</label>
                        <select class="form-select" name="category" id="updateCategory" required>
                            <option value="">Selecciona la categoría</option>
                            <?php foreach($categories as $row)
                                echo '<option value="'.$row->id.'">'.$row->category.'</option>';
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Precio</label>
                        <div class="row">
                            <div class="col-sm-2">
                                <select class="form-select" name="coin" id="updateCoin" required>
                                <?php foreach($coins as $row)
                                    echo '<option value="'.$row->id.'">'.$row->symbol.'</option>';
                                ?>
                                </select>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" class="form-control price" id="updatePrice" name="price" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Impuesto</label>
                        <select class="form-select" name="tax" id="updateTax" required>
                            <option value="">Selecciona el impuesto</option>
                            <?php foreach($taxes as $row)
                                echo '<option value="'.$row->id.'">'.$row->tax.'</option>';
                            ?>
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
    tableConfig('/products/get');
    $(".price").priceFormat({
        prefix: ''
    });

    function updateProduct(data){
        $('#updateId').val(data[0].id);
        $('#updateCode').val(data[0].code);
        $('#updateName').val(data[0].name);
        $('#updateBrand').val(data[0].brand);
        $('#updateCategory').val(data[0].category);
        $('#updateCoin').val(data[0].coin);
        $('#updatePrice').val(data[0].price);
        $('#updateTax').val(data[0].tax);
    }
</script>
