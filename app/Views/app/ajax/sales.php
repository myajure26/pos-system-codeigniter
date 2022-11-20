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
                    <h4 class="mb-sm-0 font-size-18">Ventas</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:
                                    void(0);">Administrar ventas</a></li>
                            <li class="breadcrumb-item active">Ventas</li>
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
                        <h4 class="card-title">Administrar ventas</h4>
                        <p class="card-title-desc">En este módulo podrás ver y anular ventas.</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mt-2 mb-4">
                                <label class="form-label">Filtros</label>
                                <select class="form-select" id="status_db">
                                    <option value="">Todas las ventas</option>
                                    <option value="1">Ventas procesadas</option>
                                    <option value="0">Ventas anuladas</option>
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
                                        <th>#</th>
                                        <th>Cliente</th>
                                        <th>Vendedor</th>
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
                <h5 class="modal-title" id="myLargeModalLabel">Ver detalles de la venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="custom-form viewForm">
                <div class="modal-body">
                    <div class="response"></div>
                    <div class="row">                       
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="date">Número de venta</label>
                                <input type="text" class="form-control" id="viewIdentification" disabled> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="viewCustomer">Cliente</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="viewCustomer" disabled>
                                </div>
                            </div>
                        </div>
                    </div>    
                    <div class="row">                       
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tipo de comprobante</label>
                                <select class="form-select" name="receipt" id="viewReceipt" required disabled>
                                    <?php foreach($receipt as $row)
                                        echo '<option value="'.$row->identificacion.'">'.$row->nombre.'</option>';
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Método de pago</label>
                                <select class="form-select" id="viewPaymentMethod" disabled>
                                    <?php foreach($paymentMethod as $row)
                                        echo '<option value="'.$row->id_metodo_pago.'">'.$row->nombre.'</option>';
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="viewCoin">Moneda</label>
                                <select class="form-select" id="viewCoin" disabled>
                                    <?php foreach($coins as $row)
                                        echo '<option value="'.$row->identificacion.'">'.$row->moneda.'</option>';
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="rate">Tasa</label>
                                <input type="text" class="form-control" id="viewRate" value="0.00" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="tax">Impuesto</label>
                                <select class="form-select taxSelect" name="tax" id="tax" disabled>
                                    <?php foreach($taxes as $row)
                                        echo '<option value="'.$row->identificacion.'" percentage="'.$row->porcentaje.'">'.$row->impuesto.'</option>';
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Vendedor</label>
                                <input type="text" class="form-control" id="viewSeller" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Fecha de creación</label>
                                <input type="text" class="form-control" id="viewCreated" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Fecha de actualización</label>
                                <input type="text" class="form-control" id="viewUpdated" disabled>
                            </div>
                        </div>
                        
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
                                </tr>
                            </thead>
                            <tbody id="list">
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mt-2 d-block mx-auto">
                            <div class="input-group">
                                <div class="input-group-text border-primary">Subtotal</div>
                                <input type="text" class="form-control border-primary subtotal" readonly value="0.00">
                            </div>
                        </div>
                        <div class="col-md-4 mt-2 d-block mx-auto">
                            <div class="input-group">
                                <div class="input-group-text border-primary">Impuesto</div>
                                <input type="text" class="form-control border-primary tax" readonly value="0.00">
                            </div>
                        </div>
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
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    tableConfig('/sales/get', '.datatable');

    function viewSale(data){
        console.log(data);
        $('#viewIdentification').val(data[0].idVenta);
        $('#viewCustomer').val(data[0].clienteId);
        $('#viewReceipt').val(data[0].tipo_documento);
        $('#viewPaymentMethod').val(data[0].metodoPago);
        $('#viewCoin').val(data[0].moneda);
        $('#viewRate').val(data[0].tasa);
        $('#tax').val(data[0].impuesto);
        $('#viewSeller').val(data[0].vendedor);
        $('#viewCreated').val(data[0].creado_en);
        $('#viewUpdated').val(data[0].actualizado_en);

        // Para los productos
        data.forEach(element => {

            // Tenemos que quitarle los decimales para que el plugin haga su trabajo
            element.precio = element.precio.replace('.', "");

            let totalProduct = (element.cantidad * element.precio);

            $('#list').append(`
                <tr id="${element.producto}">
                    <td>${element.codigo}</td>
                    <td>${element.nombre}</td>
                    <td>
                        <input type="number" class="form-control form-control-sm productQuantity" value="${element.cantidad}" disabled>
                    </td>
                    <td><input type="text" class="form-control form-control-sm price productPrice" value="${element.precio}" disabled></td>
                    <td class="text-center"><input type="text" class="form-control form-control-sm price totalPriceProduct" value="${totalProduct}" disabled></td>
                </tr>
            `);
        });

        totalSaleCount();

        let rate = Number(data[0].tasa.replace('.', ""));
        let subtotal = Number($('.subtotal').val().replace(/,/g, "").replace('.', ""));
        let tax = Number($('.tax').val().replace(/,/g, "").replace('.', ""));
        let total = Number($('.total').val().replace(/,/g, "").replace('.', ""));

        
        rate = rate * 0.01;
        subtotal = (subtotal * 0.01) * rate;
        total = (total * 0.01) * rate;
        tax = (tax * 0.01) * rate;

        // Para enseñar el error
        // console.log({rate, subtotal, total, tax});

        subtotal = subtotal.toLocaleString('en', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        total = total.toLocaleString('en', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        tax = tax.toLocaleString('en', {minimumFractionDigits: 2, maximumFractionDigits: 2})


        $('.subtotal').val(subtotal);
        $('.tax').val(tax);
        $('.total').val(total);

        $(".price").priceFormat({
            prefix: ''
        });
    }

    $("#range").flatpickr({
        locale: 'es',
        mode: 'range',
        maxDate: 'today'
    });
    
</script>
