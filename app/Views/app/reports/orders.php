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
                    <h4 class="mb-sm-0 font-size-18">Pedidos</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:
                                    void(0);">Administrar pedidos</a></li>
                            <li class="breadcrumb-item active">Pedidos</li>
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
                        <h4 class="card-title">Administrar pedidos</h4>
                        <p class="card-title-desc">En este módulo podrás ver, actualizar y eliminar pedidos.</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mt-2 mb-4">
                                <label class="form-label">Filtros</label>
                                <select class="form-select" id="status_db">
                                    <option value="">Todos los pedidos</option>
                                    <option value="2">Pedidos pendientes</option>
                                    <option value="1">Pedidos procesados</option>
                                    <option value="0">Pedidos anulados</option>
                                </select>
                            </div>
                            <div class="col-md-6 mt-2 mb-4">
                                <label class="form-label">Rango de fecha</label>
                                <input type="text" class="form-control range" placeholder="Selecciona una fecha" id="range" data-type="general_order_reports">
                            </div>
                            <div class="col-md-6 mt-2 mb-4 d-block mx-auto">
                                <button class="btn btn-success w-100" id="btn-report">Generar reporte de pedidos</button>
                            </div>
                        </div>
                        <table class="table datatable text-nowrap table-striped nowrap w-100 dt-responsive">
                            <thead>
                                <tr>
                                    <tr>
                                        <th>Número de compra</th>
                                        <th>Proveedor</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Total</th>
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

<!-- view purchase -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Ver detalles del pedido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="custom-form viewForm" action="<?=base_url('orders/update')?>" method="POST">
                <div class="modal-body">
                    <div class="response"></div>
                    <div class="row">
                        <input type="hidden" id="viewIdentification" name="identification" value="">                       
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="provider">Proveedor</label>
                                <input type="text" id="viewProvider" class="form-control viewDisabled" disabled>
                                <input type="hidden" id="provider" name="provider" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="provider">Nombre</label>
                                <input type="text" id="viewProviderName" class="form-control viewDisabled" disabled>
                            </div>
                        </div>
                    </div>    
                    <div class="row">                       
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tipo de comprobante</label>
                                <select class="form-select" id="viewReceipt" name="receipt" disabled>
                                    <?php foreach($receipt as $row)
                                        echo '<option value="'.$row->identificacion.'">'.$row->nombre.'</option>';
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="coin">Moneda</label>
                                <select class="form-select" id="viewCoin" name="coin" disabled>
                                    <?php foreach($coins as $row)
                                        echo '<option value="'.$row->identificacion.'">'.$row->moneda.'</option>';
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Usuario que registró el pedido</label>
                                <input type="text" class="form-control viewDisabled" id="viewUser" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Fecha de creación</label>
                                <input type="text" class="form-control viewDisabled" id="viewCreated" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Fecha de actualización</label>
                                <input type="text" class="form-control viewDisabled" id="viewUpdated" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 mt-3">
                        <button type="button" class="btn btn-primary waves-effect d-block w-50 d-block mx-auto" data-bs-toggle="modal" data-bs-target="#searchProductsModal">Buscar productos</button>
                    </div>
                    <h5 class="font-size-14 mb-4 mt-2"><i class="mdi mdi-arrow-right text-primary me-1"></i>Lista de productos</h5>
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
                                    <th>Stock</th>
                                    <th>Stock máximo</th>
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
    tableConfig('/orders/get', '.datatable');

    function viewOrder(data){
        $('#viewIdentification').val(data[0].id_pedido);
        $('#viewProvider').val(data[0].ci_rif_proveedor);
        $('#provider').val(data[0].ci_rif_proveedor);
        $('#viewProviderName').val(data[0].proveedor_nombre);
        $('#viewReceipt').val(data[0].id_tipo_documento);
        $('#viewCoin').val(data[0].id_moneda);
        $('#viewCreated').val(data[0].creado_en);
        $('#viewUpdated').val(data[0].actualizado_en);
        $('#viewUser').val(data[0].usuario);

        // Para los productos
        data.forEach(element => {

            // Tenemos que quitarle los decimales para que el plugin haga su trabajo
            element.precio_producto = element.precio_producto.replace('.', "");

            const totalProduct = (element.cant_producto * element.precio_producto);

            $('#list').append(`
                <tr id="${element.cod_producto}">
                    <td>
                        <input type="hidden" value="${element.id_detalle_pedido}" name="orderId[]">
                        <input type="hidden" value="${element.cod_producto}" name="productCode[]">
                        ${element.cod_producto}
                    </td>
                    <td>${element.nombre} ${element.ancho_numero}/${element.alto_numero} ${element.categoria} Marca ${element.marca}</td>
                    <td>
                        <input type="number" class="form-control form-control-sm productQuantity" value="${element.cant_producto}" name="productQuantity[]" disabled>
                    </td>
                    <td><input type="text" class="form-control form-control-sm price productPrice" value="${element.precio_producto}" name="productPrice[]" disabled></td>
                    <td class="text-center"><input type="text" class="form-control form-control-sm price totalPriceProduct viewDisabled" value="${totalProduct}" disabled></td>
                    <td>
                        <div class="btn-list"> 
                            <button type="button" class="removeProductOrder btn btn-sm btn-danger waves-effect d-block mx-auto" product="${element.cod_producto}" data-id="${data[0].id_pedido}">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `);
        });

        $(".price").priceFormat({
            prefix: ''
        });
        
        if(!$.fn.dataTable.isDataTable( '.getProducts' )){
            tableConfig('/orders/getProducts', '.getProducts');
        }
        $('.getProducts').DataTable().ajax.reload();

        totalCount();

    }
    $("#range").flatpickr({
        locale: 'es',
        mode: 'range',
        maxDate: 'today'
    });
</script>
