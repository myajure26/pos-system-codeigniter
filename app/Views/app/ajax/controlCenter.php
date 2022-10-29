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
                    <h4 class="mb-sm-0 font-size-18">Centro de control</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:
                                    void(0);">Panel de control</a></li>
                            <li class="breadcrumb-item active">Centro de control</li>
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
                                    <span class="d-none d-sm-block">Ajustes de precio</span> 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#addListCoin" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-coins"></i></span>
                                    <span class="d-none d-sm-block">Agregar monedas a la lista</span> 
                                </a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="price" role="tabpanel">
                                <table class="table datatable text-nowrap table-striped nowrap w-100 dt-responsive">
                                    <thead>
                                        <tr>
                                            <tr>
                                                <th>#</th>
                                                <th>Moneda principal</th>
                                                <th>Moneda secundaria</th>
                                                <th>Precio</th>
                                                <th>Api</th>
                                                <th>Fecha de actualización</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="tab-pane" id="addListCoin" role="tabpanel">
                                <h5 class="font-size-14 mb-4 mt-2"><i class="mdi mdi-arrow-right text-primary me-1"></i> Primero tienes que agregar las monedas para luego ajustar el precio</h5>
                                <form class="custom-form" action="<?=base_url('settings/createCoinPrice')?>" method="POST">
                                    <div class="row">                       
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="principal-coin">Moneda principal</label>
                                                <select class="form-select" name="coin" id="principal-coin" required>
                                                    <option value="">Selecciona la moneda</option>
                                                    <?php foreach($coins as $row)
                                                        echo '<option value="'.$row->id.'">'.$row->coin.'</option>';
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="secondary-coin">Moneda secundaria</label>
                                                <select class="form-select" name="coin" id="secondary-coin" required>
                                                    <option value="">Selecciona la moneda</option>
                                                    <?php foreach($coins as $row)
                                                        echo '<option value="'.$row->id.'">'.$row->coin.'</option>';
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>    
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="api" name="api">
                                            <label class="form-check-label" for="api">Usar la API para ajustar automáticamente el precio</label>
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
<script>
    tableConfig('/settings/getCoinPrices', '.datatable');
    $(".price").priceFormat({
        prefix: ''
    });
</script>