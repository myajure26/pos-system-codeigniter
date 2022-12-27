<script>
    document.title = "<?= $title ?>";
    // TODO: Verificar los campos deshabilitados
</script>
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center
                    justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Nueva venta</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:
                                    void(0);">Administrar ventas</a></li>
                            <li class="breadcrumb-item active">Nueva venta</li>
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
                        <p class="card-title-desc">En este módulo podrás agregar nuevas ventas.</p>
                    </div>
                    <div class="card-body">
                        
                        <div class="response"></div>
                        <div id="progrss-wizard" class="twitter-bs-wizard">
                            <ul class="twitter-bs-wizard-nav nav nav-pills nav-justified">
                                <li class="nav-item">
                                    <a href="#progress-seller-details" class="nav-link" data-toggle="tab">
                                        <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Cliente">
                                            <i class="bx bx-list-ul"></i>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#progress-company-document" class="nav-link" data-toggle="tab">
                                        <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Productos">
                                            <i class="bx bx-book-bookmark"></i>
                                        </div>
                                    </a>
                                </li>
                                
                                <li class="nav-item">
                                    <a href="#progress-bank-detail" class="nav-link" data-toggle="tab">
                                        <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Venta">
                                            <i class="bx bxs-bank"></i>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                            <!-- wizard-nav -->

                            <div id="bar" class="progress mt-4">
                                <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated"></div>
                            </div>
                            <div class="tab-content twitter-bs-wizard-tab-content">
                                <div class="tab-pane" id="progress-seller-details">
                                    <div class="text-center mb-4">
                                        <h5>Datos del cliente</h5>
                                        <p class="card-title-desc">Rellena la información abajo</p>
                                    </div>
                                    <form class="custom-form" action="<?=base_url('customers/create')?>" method="POST" type="saveCustomerSale">
                                        <div class="mb-3">
                                            <label class="form-label">Cédula/Rif</label>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <select class="form-select letter" name="letter">
                                                        <option value="V">V</option>
                                                        <option value="J">J</option>
                                                        <option value="E">E</option>
                                                        <option value="P">P</option>
                                                        <option value="G">G</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <input type="number" class="form-control ci-rif identification" placeholder="Introduce el número de cédula/rif" name="legalIdentification" id="legalIdentification" required>
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-primary waves-effect searchCustomer"><i class="fas fa-search"></i></button>
                                                            <button type="button" class="btn btn-primary waves-effect addCustomer" disabled><i class="fas fa-user-plus"></i></button>
                                                        </div>
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Nombre</label>
                                                    <input type="text" class="form-control name" id="name" placeholder="Nombre del cliente" name="name" required disabled>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Teléfono</label>
                                                    <input type="number" class="form-control phone" id="phone" placeholder="Teléfono del cliente" name="phone" required disabled>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Dirección</label>
                                            <textarea class="form-control address" id="address" placeholder="Dirección del cliente" name="address" required cols="2" disabled></textarea>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </form>
                                    <ul class="pager wizard twitter-bs-wizard-pager-link">
                                        <li class="next"><a href="javascript: void(0);" class="btn btn-primary" id="customerNext" style="display:none">Siguiente <i class="bx bx-chevron-right ms-1"></i></a></li>
                                    </ul>
                                </div>
                                <div class="tab-pane" id="progress-company-document">
                                    <div>
                                    <div class="text-center mb-4">
                                        <h5>Productos</h5>
                                        <p class="card-title-desc">Selecciona los productos</p>
                                    </div>
                                    <form class="custom-form" id="productForm" action="<?=base_url('sales/create')?>" method="POST">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="hidden" name="customer" id="hiddenCustomer">
                                                
                                                <h5 class="font-size-14 mb-4 mt-2"><i class="mdi mdi-arrow-right text-primary me-1"></i>Lista de compra</h5>
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
                                                        <tfoot>
                                                            <tr>
                                                                <th style="width:150px; text-align: right" colspan="4">Subtotal</th>
                                                                <th style="width:150px"><input type="text" class="form-control form-control-sm price tfootSubtotal" required disabled></th>
                                                            </tr>
                                                            <tr>
                                                                <th style="width:150px; text-align: right" colspan="4">Impuesto</th>
                                                                <th style="width:150px"><input type="text" class="form-control form-control-sm price tfootTax" required disabled></th>
                                                            </tr>
                                                            <tr>
                                                                <th style="width:150px; text-align: right" colspan="4">Total</th>
                                                                <th style="width:150px"><input type="text" class="form-control form-control-sm price tfootTotal" required disabled></th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <div class="row">
                                                    <h5 class="font-size-14 mb-3 mt-2"><i class="mdi mdi-arrow-right text-primary me-1"></i>Total incluyendo la conversión de moneda</h5>
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
                                            <div class="col-md-6">
                                                <div class="table-responsive">
                                                    <table class="table getProducts text-nowrap table-striped nowrap w-100 responsive">
                                                        <thead>
                                                            <tr>
                                                                <tr>
                                                                    <th>Seleccionar</th>
                                                                    <th>Código</th>
                                                                    <th>Nombre</th>
                                                                    <th>Marca</th>
                                                                    <th>Categoría</th>
                                                                    <th>Precio</th>
                                                                    <th>Stock</th>
                                                                    <th>Stock mínimo</th>
                                                                </tr>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <ul class="pager wizard twitter-bs-wizard-pager-link">
                                        <li class="previous"><a href="javascript: void(0);" class="btn btn-primary"><i
                                                    class="bx bx-chevron-left me-1"></i> Anterior</a></li>
                                        <li class="next"><a href="javascript: void(0);" class="btn btn-primary" id="productsNext" style="display:none">Siguiente <i
                                                    class="bx bx-chevron-right ms-1"></i></a></li>
                                    </ul>
                                    </div>
                                </div>
                                <div class="tab-pane" id="progress-bank-detail">
                                    <div>
                                        <div class="text-center mb-4">
                                            <h5>Venta</h5>
                                            <p class="card-title-desc">Rellena la información para finalizar la venta</p>
                                        </div>
                                        <form class="custom-form" id="saleForm" action="<?=base_url('sales/create')?>" method="POST">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="tax">Impuesto</label>
                                                        <select class="form-select taxSelect" name="tax" id="tax" required>
                                                            <?php foreach($taxes as $row)
                                                                echo '<option value="'.$row->identificacion.'" percentage="'.$row->porcentaje.'">'.$row->impuesto.'</option>';
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Método de pago</label>
                                                        <select class="form-select" name="paymentMethod" required>
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
                                                        <label class="form-label" for="coinSale">Moneda</label>
                                                        <select class="form-select" name="coin" id="coinSale" principalCoin="<?=$principalCoin?>" required>
                                                            <option value="">Seleccione la moneda</option>
                                                            <?php foreach($coins as $row)
                                                                echo '<option value="'.$row->identificacion.'">'.$row->moneda.'</option>';
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="rate">Tasa</label>
                                                        <input type="text" class="form-control" id="rate" name="rate" value="0.00" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Tipo de comprobante</label>
                                                        <select class="form-select" name="receipt" id="receipt" required>
                                                            <?php foreach($receipt as $row)
                                                                echo '<option value="'.$row->identificacion.'">'.$row->nombre.'</option>';
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <h5 class="font-size-14 mb-3 mt-2"><i class="mdi mdi-arrow-right text-primary me-1"></i>Total incluyendo la conversión de moneda</h5>
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
                                            <ul class="pager wizard twitter-bs-wizard-pager-link">
                                                <li class="previous"><a href="javascript: void(0);" class="btn btn-primary"><i
                                                class="bx bx-chevron-left me-1"></i> Anterior</a></li>
                                                <li class="float-end"><button id="processSale" class="btn btn-primary">Procesar</button></li>
                                            </ul>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>   
                <!-- end card body -->
            </div>
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

<script>
    tableConfig('/coins/get', '.datatable');
    tableConfig('/sales/getProducts', '.getProducts');

    $(".price").priceFormat({
        prefix: ''
    });

    function viewCoin(data){
        $('#viewIdentification').val(data[0].identificacion);
        $('#viewName').val(data[0].moneda);
        $('#viewSymbol').val(data[0].simbolo);
        $('#viewCreated').val(data[0].creado_en);
        $('#viewUpdated').val(data[0].actualizado_en);
    }


    $('#progrss-wizard').bootstrapWizard({onTabShow: function(tab, navigation, index) {
        var $total = navigation.find('li').length;
        var $current = index+1;
        var $percent = ($current/$total) * 100;
        $('#progrss-wizard').find('.progress-bar').css({width:$percent+'%'});
    }});
</script>

