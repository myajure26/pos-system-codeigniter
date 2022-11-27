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
                        <div class="row">
                            <div class="col-md-6 mt-2 mb-4">
                                <label class="form-label">Filtros</label>
                                <select class="form-select" id="status_db">
                                    <option value="">Todas las compras</option>
                                    <option value="1">Compras procesadas</option>
                                    <option value="0">Compras anuladas</option>
                                </select>
                            </div>
                            <div class="col-md-6 mt-2 mb-4">
                                <label class="form-label">Rango de fecha</label>
                                <input type="text" class="form-control range" placeholder="Selecciona una fecha" id="range" data-type="general_purchase_reports">
                            </div>
                            <div class="col-md-6 mt-2 mb-4 d-block mx-auto">
                                <button class="btn btn-success w-100" id="btn-report">Generar reporte de compras</button>
                            </div>
                        </div>
                        <table class="table datatable text-nowrap table-striped nowrap w-100 dt-responsive">
                            <thead>
                                <tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Proveedor</th>
                                        <th>Fecha</th>
                                        <th>Referencia</th>
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
                <h5 class="modal-title" id="myLargeModalLabel">Ver detalles de la compra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="custom-form viewForm">
                <div class="modal-body">
                    <div class="response"></div>
                    <div class="row">                       
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="date">Fecha de la compra</label>
                                <input type="date" class="form-control" id="viewDate" disabled> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="provider">Proveedor</label>
                                <input type="text" id="viewProvider" class="form-control" disabled>
                            </div>
                        </div>
                    </div>    
                    <div class="row">                       
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tipo de comprobante</label>
                                <select class="form-select" id="viewReceipt" disabled>
                                    <?php foreach($receipt as $row)
                                        echo '<option value="'.$row->identificacion.'">'.$row->nombre.'</option>';
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="reference">Número de referencia</label>
                                <input type="number" class="form-control" id="viewReference" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="coin">Moneda</label>
                                <select class="form-select" id="viewCoin" disabled>
                                    <?php foreach($coins as $row)
                                        echo '<option value="'.$row->identificacion.'">'.$row->moneda.'</option>';
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Usuario que registró la compra</label>
                                <input type="text" class="form-control viewDisabled" id="viewUser" disabled>
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
    tableConfig('/purchases/get', '.datatable');

    function viewPurchase(data){
        $('#viewDate').val(data[0].fecha);
        $('#viewProvider').val(data[0].proveedor);
        $('#viewReceipt').val(data[0].tipo_documento);
        $('#viewReference').val(data[0].referencia);
        $('#viewCoin').val(data[0].moneda);
        $('#viewCreated').val(data[0].creado_en);
        $('#viewUpdated').val(data[0].actualizado_en);
        $('#viewUser').val(data[0].usuario);

        // Para los productos
        data.forEach(element => {

            // Tenemos que quitarle los decimales para que el plugin haga su trabajo
            element.precio = element.precio.replace('.', "");

            const totalProduct = (element.cantidad * element.precio);

            $('#list').append(`
                <tr id="${element.producto}">
                    <td>${element.codigo}</td>
                    <td>${element.nombre}</td>
                    <td>
                        <input type="number" class="form-control form-control-sm productQuantity" value="${element.cantidad}" disabled>
                    </td>
                    <td><input type="text" class="form-control form-control-sm price productPrice" value="${element.precio}"  disabled></td>
                    <td class="text-center"><input type="text" class="form-control form-control-sm price totalPriceProduct" value="${totalProduct}" disabled></td>
                </tr>
            `);
        });

        $(".price").priceFormat({
            prefix: ''
        });
        totalCount();
    }
    $("#range").flatpickr({
        locale: 'es',
        mode: 'range',
        maxDate: 'today'
    });
</script>
