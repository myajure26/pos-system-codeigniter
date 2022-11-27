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
                    <h4 class="mb-sm-0 font-size-18">Reportes de compras por proveedor</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:
                                    void(0);">Administrar compras</a></li>
                            <li class="breadcrumb-item active">Reportes de compras por proveedor</li>
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
                        <p class="card-title-desc">En este módulo podrás ver todas las compras realizadas por proveedor.</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="mt-2 mb-4 col-md-6">
                                <label class="form-label">Proveedor</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="searchById" placeholder="Por favor, busque al proveedor" readonly required>
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-primary waves-effect" data-bs-toggle="modal" data-bs-target="#searchProviderModal"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2 mb-4 col-md-6">
                                <label class="form-label">Rango de fecha</label>
                                <input type="text" class="form-control range" placeholder="Selecciona una fecha" id="range" data-type="purchases_per_provider">
                            </div>
                            <div class="col-md-6 mt-2 mb-4 d-block mx-auto">
                                <button class="btn btn-success w-100" id="btn-report" style="display: none">Generar reporte de compras por proveedor</button>
                            </div>
                        </div>

                        <table class="table-report" style="display: none">
                            <tr>

                                <td style='background-color:white; width:400px'>
                                    
                                    <div style='font-size:14px; text-align:left; line-height:15px; margin-left: 20px'>
                                        
                                        <br><br>
                                        <strong style='font-size: 23px'>Reporte de compras por proveedor</strong>
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

                        <table class="table-report" style="display: none">
		
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
                                        <strong>RIF:</strong> J-285346256

                                        <br>
                                        <strong>Dirección:</strong> Av. Venezuela con calle 37

                                    </div>

                                </td>

                                <td style='background-color:white; width:250px'>

                                    <div style='font-size:14px; text-align:right; line-height:23px; margin-left: 50px'>
                                        
                                        <br>
                                        <strong>Teléfono:</strong> 02512736478
                                        
                                        <br>
                                        digencacom@example.com

                                    </div>
                                    
                                </td>

                            </tr>

                        </table>

                        <table class="table-report" style="display: none">
		
                            <tr>
                                
                                <td style='width:350px; margin-left: 20px'>
                                    <div style='font-size:14px; text-align:center; line-height:15px; margin-left: 20px'>
                                        
                                        <br><br>
                                        <strong style='font-size: 23px'>Proveedor</strong>                                   

                                        <br><br>

                                    </div>

                                </td>

                                <td style='background-color:white; width:250px'>
                                    
                                    <div style='font-size:14px; text-align:right; line-height:23px;'>
                                        
                                        <br>
                                        <strong>Identificación:</strong> <span id="identification-report"></span>

                                        <br>
                                        <strong>Nombre:</strong> <span id="name-report"></span></td>

                                    </div>

                                </td>

                                <td style='background-color:white; width:250px'>

                                    <div style='font-size:14px; text-align:right; line-height:23px; margin-left: 50px'>
                                        
                                        <br>
                                        <strong>Teléfono:</strong> <span id="phone-report"></span>

                                        <br>
                                        <strong>Dirección:</strong> <span id="address-report"></span></td>

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
                                        <th>Factura</th>
                                        <th>Fecha</th>
                                        <th>Usuario</th>
                                        <th>Productos</th>
                                        <th>Cantidad</th>
                                        <th>Precio producto</th>
                                        <th>Total compra</th>
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
                    <table class="table getProvider text-nowrap table-striped nowrap w-100 responsive">
                        <thead>
                            <tr>
                                <tr>
                                    <th>Seleccionar</th>
                                    <th>Cédula/Rif</th>
                                    <th>Nombre</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th>Código</th>
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
    tableConfig('/purchases_provider', '.getProvider');

    $("#range").flatpickr({
        locale: 'es',
        mode: 'range',
        maxDate: 'today'
    });
</script>

