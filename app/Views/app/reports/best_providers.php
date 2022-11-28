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
                    <h4 class="mb-sm-0 font-size-18">Reporte de mejores proveedores</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:
                                    void(0);">Administrar compras</a></li>
                            <li class="breadcrumb-item active">Reporte de mejores proveedores</li>
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
                        <p class="card-title-desc">En este módulo podrás ver los mejores proveedores.</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="mt-2 mb-4 col-md-6">
                                <input type="text" class="form-control range" placeholder="Selecciona una fecha" id="range" data-type="best_providers">
                            </div>
                            <div class="col-md-6 mt-2 mb-4 d-block mx-auto">
                                <button class="btn btn-success w-100" id="btn-report">Generar reporte de los mejores proveedores</button>
                            </div>
                        </div>


                        <table class="table-report">
                            <tr>

                                <td style='background-color:white; width:400px'>
                                    
                                    <div style='font-size:14px; text-align:left; line-height:15px; margin-left: 20px'>
                                        
                                        <br><br>
                                        <strong style='font-size: 23px'>Reporte de mejores proveedores</strong>
                                        <br><br>
                                        <p class="report-date"></p>

                                    </div>

                                </td>

                                <td style='width:150px;'>
                                    
                                </td>

                                <td style='background-color:white; width:500px'>

                                
                                    
                                </td>

                                <td style='background-color:white; width:180px'>

                                    <div style='font-size:14px; text-align:right; margin-left: 50px'>
                                        <br>
                                        <strong style='font-size: 23px'>Generado:</strong>
                                        <br>
                                        <?= date('d-m-Y H:i')?>

                                    </div>
                                    
                                </td>

                            </tr>
                        </table>

                        <table class="table-report">
		
                            <tr>
                                
                                <td style='width:350px; margin-left: 20px'>
                                    <div style='font-size:14px; text-align:left; line-height:15px; margin-left: 120px'>
                                        
                                        <br><br>
                                        <img src="<?=base_url('assets/images/brands/logo_digenca.jpg')?>" width="150px">
                                        
                                        <br><br>

                                    </div>

                                </td>

                                <td style='background-color:white; width:250px'>
                                    
                                    <div style='font-size:14px; text-align:right; line-height:23px;'>
                                        
                                        <br>
                                        <strong>RIF:</strong> <?=$businessIdentification?>

                                        <br>
                                        <strong>Dirección:</strong> <?=$businessAddress?>

                                    </div>

                                </td>

                                <td style='background-color:white; width:250px'>

                                    <div style='font-size:14px; text-align:right; line-height:23px; margin-left: 50px'>
                                        
                                        <br>
                                        <strong>Teléfono:</strong> <?=$businessPhone?>
                                        
                                        <br>
                                        

                                    </div>
                                    
                                </td>

                            </tr>

                        </table>

                        <br>
                        <hr>
                        <table class="table datatable text-nowrap table-striped nowrap w-100 dt-responsive">
                            <thead>
                                <tr>
                                    <tr>
                                        <th>Identificación</th>
                                        <th>Nombre</th>
                                        <th>Teléfono</th>
                                        <th>Dirección</th>
                                        <th>Cantidad de productos</th>
                                        <th>Total pagado</th>
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

<script>
    tableConfig('/best_providers', '.datatable');

    $("#range").flatpickr({
        locale: 'es',
        mode: 'range',
        maxDate: 'today'
        // TODO: dateFormat: 'd-m-Y'
    });
</script>

