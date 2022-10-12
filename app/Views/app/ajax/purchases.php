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
                    <h4 class="mb-sm-0 font-size-18">Compras</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:
                                    void(0);">Administrar compras</a></li>
                            <li class="breadcrumb-item active">Compras</li>
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
                        <h4 class="card-title">Administrar compras</h4>
                        <p class="card-title-desc">En este módulo podrás ver, actualizar y eliminar compras.</p>
                    </div>
                    <div class="card-body">
                        <table class="table datatable text-nowrap table-striped nowrap w-100 dt-responsive">
                            <thead>
                                <tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Proveedor</th>
                                        <th>Fecha</th>
                                        <th>Referencia</th>
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

<!-- view brand -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Ver detalles de la compra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="custom-form viewForm" action="<?=base_url('purchases/update')?>" method="POST">
                <div class="modal-body">
                    <div class="response"></div>
                    <input type="hidden" id="viewId" name="id" value="">
                    <div class="row">                       
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="date">Fecha de la compra</label>
                                <input type="date" class="form-control" id="viewDate" name="date" required disabled> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="provider">Proveedor</label>
                                <div class="input-group">
                                    <input type="hidden" id="viewProvider" name="provider" value="">
                                    <input type="text" class="form-control" id="providerInput" placeholder="Por favor, busque al proveedor" readonly required>
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-primary waves-effect btn-disabled" data-bs-toggle="modal" data-bs-target="#searchProviderModal" disabled><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>    
                    <div class="row">                       
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tipo de comprobante</label>
                                <select class="form-select" name="receipt" id="viewReceipt" required disabled>
                                    <option value="">Seleccione el comprobante</option>
                                    <option value="invoice">Factura</option>
                                    <option value="deliveryNote">Nota de entrega</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="reference">Número de referencia</label>
                                <input type="number" class="form-control" id="viewReference" placeholder="Ingresa el número de referencia" name="reference" required disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="tax">Impuesto</label>
                                <select class="form-select" name="tax" id="tax" required disabled>
                                    <option value="" percentage="0">Seleccione el impuesto</option>
                                    <?php foreach($taxes as $row)
                                        echo '<option value="'.$row->id.'" percentage="'.$row->percentage.'">'.$row->tax.'</option>';
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="coin">Moneda</label>
                                <select class="form-select" name="coin" id="viewCoin" required disabled>
                                    <option value="">Seleccione la moneda</option>
                                    <?php foreach($coins as $row)
                                        echo '<option value="'.$row->id.'">'.$row->coin.'</option>';
                                    ?>
                                </select>
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
                    <h5 class="font-size-14 mb-4 mt-2"><i class="mdi mdi-arrow-right text-primary me-1"></i>Lista de compras</h5>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th style="width:150px">Cantidad</th>
                                    <th style="width:150px">Precio</th>
                                    <th style="width:150px">Total</th>
                                </tr>
                            </thead>
                            <tbody id="list">
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mt-2">
                            <div class="input-group">
                                <div class="input-group-text border-primary">Subtotal</div>
                                <input type="text" class="form-control border-primary subtotal" readonly value="0.00">
                            </div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <div class="input-group">
                                <div class="input-group-text border-primary">Impuesto</div>
                                <input type="text" class="form-control border-primary tax" readonly value="0.00">
                            </div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <div class="input-group">
                                <div class="input-group-text border-primary">Total</div>
                                <input type="text" class="form-control border-primary total" readonly value="0.00">
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
                                    <th>#</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>RIF</th>
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
    tableConfig('/purchases/get', '.datatable');

    function viewPurchase(data){
        $('#viewId').val(data[0].purchaseId);
        $('#viewDate').val(data[0].date);
        $('#viewProvider').val(data[0].provider);
        $('#providerInput').val(data[0].providerName);
        $('#viewReceipt').val(data[0].receipt);
        $('#viewReference').val(data[0].reference);
        $('#tax').val(data[0].tax);
        $('#viewCoin').val(data[0].coin);
        $('#viewCreated').val(data[0].created_at);
        $('#viewUpdated').val(data[0].updated_at);
        // Para los productos
        data.forEach(element => {

            const totalProduct = (element.quantity * element.price)*100;

            $('#list').append(`
                <tr id="${element.product}">
                    <td>
                        <input type="hidden" name="purchaseDetailsId[]" value="${element.purchaseDetailsId}">
                        <input type="hidden" name="productId[]" value="${element.product}">
                        ${element.product}
                    </td>
                    <td>${element.code}</td>
                    <td>${element.name}</td>
                    <td><input type="number" class="form-control form-control-sm productQuantity" name="productQuantity[]" value="${element.quantity}" required disabled></td>
                    <td><input type="text" class="form-control form-control-sm price productPrice" name="productPrice[]" value="${element.price}" required maxlength="10" disabled></td>
                    <td class="text-center"><input type="text" class="form-control form-control-sm price totalPriceProduct" value="${totalProduct}" readonly required></td>
                </tr>
            `);
        });

        $(".price").priceFormat({
            prefix: ''
        });
        totalCount();
    }
</script>
