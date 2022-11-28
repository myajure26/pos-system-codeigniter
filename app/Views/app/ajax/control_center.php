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
                    <h4 class="mb-sm-0 font-size-18">Precio de monedas</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:
                                    void(0);">Panel de control</a></li>
                            <li class="breadcrumb-item active">Precio de monedas</li>
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
                        <h4 class="card-title">Administrar configuraciones del sistema</h4>
                        <p class="card-title-desc">En este módulo podrás hacer algunos ajustes menores al sistema.</p>
                    </div>
                    <div class="response"></div>
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#price" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cogs"></i></span>
                                    <span class="d-none d-sm-block">Lista de precios</span> 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#addListCoin" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-coins"></i></span>
                                    <span class="d-none d-sm-block">Agregar precios de monedas</span> 
                                </a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="price" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mt-2 mb-4">
                                        <label class="form-label">Filtros</label>
                                        <select class="form-select" id="status_db">
                                            <option value="">Todos los precios</option>
                                            <option value="1">Precios activados</option>
                                            <option value="0">Precios desactivados</option>
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
                                                <th>Moneda principal</th>
                                                <th>Moneda secundaria</th>
                                                <th>Precio</th>
                                                <th>Estado</th>
                                                <th>Fecha de actualización</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="tab-pane" id="addListCoin" role="tabpanel">
                                <h5 class="font-size-14 mb-4 mt-2"><i class="mdi mdi-arrow-right text-primary me-1"></i> Agregar los precios de las monedas</h5>
                                <form class="custom-form" action="<?=base_url('coinPrices/createCoinPrice')?>" method="POST">
                                    <div class="row">                       
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="principal-coin">Moneda principal</label>
                                                <select class="form-select" name="principalCoin" id="principal-coin" required disabled>
                                                    <?php foreach($coins as $row)
                                                        echo '<option value="'.$row->identificacion.'">'.$row->moneda.'</option>';
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="secondary-coin">Moneda secundaria</label>
                                                <select class="form-select" name="secondaryCoin" id="secondary-coin" required>
                                                    <?php foreach($coins as $row)
                                                       if($row->identificacion != $principalCoin){
                                                            echo '<option value="'.$row->identificacion.'">'.$row->moneda.'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">                       
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="unit-coin">Unidad</label>
                                                <input type="text" class="form-control" id="unit-coin" disabled value="1.00">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="price-coin">Precio de la unidad</label>
                                                <input type="text" class="form-control price" name="price" id="price-coin" value="0.00" maxlength="10">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary w-md">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->
<!-- view coin prices -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Ver detalles de precio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="custom-form viewForm" action="<?=base_url('coinPrices/update')?>" method="POST">
                <div class="modal-body">
                    <div class="response"></div>
                    <input type="hidden" id="viewIdentification" name="identification" value="">
                    <div class="row">                       
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="viewPrincipalCoin">Moneda principal</label>
                                <select class="form-select viewDisabled" id="viewPrincipalCoin" required disabled>
                                    <?php foreach($coins as $row)
                                        echo '<option value="'.$row->identificacion.'">'.$row->moneda.'</option>';
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="viewSecondaryCoin">Moneda secundaria</label>
                                <select class="form-select" name="secondaryCoin" id="viewSecondaryCoin" required disabled>
                                    <?php foreach($coins as $row)
                                        if($row->identificacion != $principalCoin){
                                            echo '<option value="'.$row->identificacion.'">'.$row->moneda.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">                       
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="unit-coin">Unidad</label>
                                <input type="text" class="form-control viewDisabled" id="unit-coin" disabled value="1.00">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="viewCoinPrice">Precio de la unidad</label>
                                <input type="text" class="form-control price" name="price" id="viewCoinPrice" value="0.00" maxlength="10" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Fecha de creación</label>
                                <input type="text" class="form-control" name="date" id="viewCreated" readonly disabled>
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
    tableConfig('/coinPrices/getCoinPrices', '.datatable');
    $(".price").priceFormat({
        prefix: ''
    });
    function viewCoinPrices(data){
        $('#viewIdentification').val(data[0].identificacion);
        $('#viewPrincipalCoin').val(data[0].moneda_principal);
        $('#viewSecondaryCoin').val(data[0].moneda_secundaria);
        $('#viewCoinPrice').val(data[0].precio);
        $('#viewCreated').val(data[0].creado_en);
        $('#viewUpdated').val(data[0].actualizado_en);
    }
    $("#range").flatpickr({
        locale: 'es',
        mode: 'range',
        maxDate: 'today'
    });
    var coin = <?=$principalCoin?>;
    $('#principal-coin').val(coin);
</script>