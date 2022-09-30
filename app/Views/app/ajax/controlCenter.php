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
                                <a class="nav-link" data-bs-toggle="tab" href="#coins" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-coins"></i></span>
                                    <span class="d-none d-sm-block">Monedas</span> 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#messages" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">Mensajes</span>   
                                </a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="price" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div>
                                            <h5 class="font-size-14 mb-4 mt-2"><i class="mdi mdi-arrow-right text-primary me-1"></i> Ajustar el precio de la moneda principal en base a la moneda secundaria</h5>
                                            <form>
                                                <div class="row">                       
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="principal-coin-price">Moneda principal</label>
                                                            <div class="input-group">
                                                                <div class="input-group-text">$</div>
                                                                <input type="text" class="form-control" id="principal-coin-price" readonly value="1.00"> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="secondary-coin-price">Precio de la moneda secundaria</label>
                                                            <div class="input-group">
                                                                <div class="input-group-text">Bs.</div>
                                                                <input type="text" class="form-control price" id="secondary-coin-price" placeholder="Ingresa el precio" value="0.00">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>    
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="api">
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
                            <div class="tab-pane" id="coins" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div>
                                            <h5 class="font-size-14 mt-2"><i class="mdi mdi-arrow-right text-primary me-1"></i> Actualmente las monedas son:</h5>
                                            <h5 class="font-size-14 mt-2"><i class="mdi mdi-check text-primary me-1"></i> Moneda principal: <?=$settings[0]->value?></h5>
                                            <h5 class="font-size-14 mb-4 mt-1"><i class="mdi mdi-check text-primary me-1"></i> Moneda secundaria: <?=$settings[1]->value?></h5>
                                            <form class="custom-form" action="<?=base_url('settings/setCoins')?>" method="POST">
                                                <div class="row">       
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Moneda principal</label>
                                                            <select class="form-select" name="setPrincipalCoin" id="setPrincipalCoin" required>
                                                                <option value="">Seleccione la moneda principal</option>
                                                                <?php foreach($coins as $row)
                                                                    echo '<option value="'.$row->coin.'">'.$row->coin.'</option>';
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Moneda secundaria</label>
                                                            <select class="form-select" name="setSecondaryCoin" id="setSecondaryCoin" required>
                                                                <option value="">Seleccione la moneda secundaria</option>
                                                                <?php foreach($coins as $row)
                                                                    echo '<option value="'.$row->coin.'">'.$row->coin.'</option>';
                                                                ?>
                                                            </select>
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
                            <div class="tab-pane" id="messages" role="tabpanel">
                                <p class="mb-0">
                                    TODO: pensar que hacer aqui.
                                </p>
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
    $(".price").priceFormat({
        prefix: ''
    });
</script>