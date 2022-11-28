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
                    <h4 class="mb-sm-0 font-size-18">Nueva compra</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:
                                    void(0);">Administrar compras</a></li>
                            <li class="breadcrumb-item active">Nueva compra</li>
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
                        <h4 class="card-title">Registrar nueva compra</h4>
                        <p class="card-title-desc">En este módulo solamente podrás registrar nuevas compras</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div>
                                    <form class="custom-form" action="<?=base_url('purchases/create')?>" method="POST">
                                        <div class="response"></div>
                                        <div class="row">                       
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="date">Fecha de la compra</label>
                                                    <input type="date" class="form-control" id="date" name="date" max="<?= date('Y-m-d')?>" required> 
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="provider">Proveedor</label>
                                                    <div class="input-group">
                                                        <input type="hidden" id="provider" name="provider" value="">
                                                        <input type="text" class="form-control" id="providerInput" placeholder="Por favor, busque al proveedor" readonly required>
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-primary waves-effect" data-bs-toggle="modal" data-bs-target="#searchProviderModal"><i class="fas fa-search"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    
                                        <div class="row">                       
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Tipo de comprobante</label>
                                                    <select class="form-select" name="receipt" id="receipt" required>
                                                        <option value="">Seleccione el comprobante</option>
                                                        <?php foreach($receipt as $row)
                                                            echo '<option value="'.$row->identificacion.'">'.$row->nombre.'</option>';
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="reference">Número de referencia</label>
                                                    <input type="number" class="form-control ref" id="reference" placeholder="Ingresa el número de referencia" name="reference" required>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="coin">Moneda</label>
                                                    <select class="form-select" name="coin" id="coin" required>
                                                        <option value="">Seleccione la moneda</option>
                                                        <?php foreach($coins as $row)
                                                            echo '<option value="'.$row->identificacion.'">'.$row->moneda.'</option>';
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <button type="button" class="btn btn-primary waves-effect d-block w-50 d-block mx-auto" data-bs-toggle="modal" data-bs-target="#searchProductsModal">Buscar productos</button>
                                        </div>
                                        <h5 class="font-size-14 mb-4 mt-2"><i class="mdi mdi-arrow-right text-primary me-1"></i>Lista de compras</h5>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Código</th>
                                                        <th>Nombre</th>
                                                        <th style="width:150px">Cantidad</th>
                                                        <th style="width:150px">Precio</th>
                                                        <th style="width:150px">Total</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="list">
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 mt-2 d-block mx-auto">
                                                <div class="input-group">
                                                    <div class="input-group-text border-primary">Total</div>
                                                    <input type="text" class="form-control border-primary total" readonly value="0.00">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <button type="submit" class="btn btn-primary w-md">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

<!-- provider modal -->
<div class="modal fade" id="searchProviderModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Selecciona el proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table getProviders text-nowrap table-striped nowrap w-100 responsive">
                        <thead>
                            <tr>
                                <tr>
                                    <th>Seleccionar</th>
                                    <th>Cédula/Rif</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
                                </tr>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
            </div>        
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- product modal -->
<div class="modal fade" id="searchProductsModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Selecciona los productos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table getProducts text-nowrap table-striped nowrap w-100 responsive">
                        <thead>
                            <tr>
                                <tr>
                                    <th>Seleccionar</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Categoría</th>
                                    <th>Marca</th>
                                </tr>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
            </div>        
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    tableConfig('/purchases/getProviders', '.getProviders');
    tableConfig('/purchases/getProducts', '.getProducts');

    $(".price").priceFormat({
        prefix: ''
    });
</script>