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
                    <h4 class="mb-sm-0 font-size-18">Configuración general</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:
                                    void(0);">Configuraciones del sistema</a></li>
                            <li class="breadcrumb-item active">Configuración general</li>
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
                            <div class="tab-pane" id="addListCoin" role="tabpanel">
                                <form class="custom-form" action="<?=base_url('settings/update')?>" method="POST">
                                    <div class="row">  
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="systemName">Nombre del sistema</label>
                                                <input type="text" class="form-control name" name="systemName" value="<?=$systemName?>">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>                     
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="principal-coin">Moneda principal</label>
                                                <select class="form-select" name="principalCoin" id="principal-coin" required>
                                                    <?php foreach($coins as $row)
                                                        echo '<option value="'.$row->identificacion.'">'.$row->moneda.'</option>';
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="national-coin">Moneda nacional</label>
                                                <select class="form-select" name="nationalCoin" id="national-coin" required>
                                                    <?php foreach($coins as $row)
                                                        echo '<option value="'.$row->identificacion.'">'.$row->moneda.'</option>';
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">                       
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="businessName">Nombre de la empresa</label>
                                                <input type="text" class="form-control name" name="name" value="<?=$name?>">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="rif">RIF de la empresa</label>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <select class="form-select" id="letter" name="letter">
                                                            <option value="V">V</option>
                                                            <option value="J">J</option>
                                                            <option value="E">E</option>
                                                            <option value="P">P</option>
                                                            <option value="G">G</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="number" class="form-control rif" id="identification" name="legalIdentification">
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="address">Dirección de la empresa</label>
                                                <textarea class="form-control address" name="address" id="address"></textarea>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="businessName">Teléfono de la empresa</label>
                                                <input type="number" class="form-control phone" name="phone" value="<?=$phone?>">
                                                <div class="invalid-feedback"></div>
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
<script>
    let id = '<?=$identification?>';
    let address = '<?=$address?>';
    let coin = <?=$principalCoin?>;
    let nationalCoin = <?=$nationalCoin?>;

    $('#letter').val(id.split('-')[0]);
    $('#identification').val(id.split('-')[1]);
    $('#address').val(address);
    $('#principal-coin').val(coin);
    $('#national-coin').val(nationalCoin);
</script>