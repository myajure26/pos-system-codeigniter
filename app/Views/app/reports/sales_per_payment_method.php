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
                    <h4 class="mb-sm-0 font-size-18">Reportes de ventas por método de pago</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:
                                    void(0);">Administrar ventas</a></li>
                            <li class="breadcrumb-item active">Reportes de ventas por método de pago</li>
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
                        <p class="card-title-desc">En este módulo podrás ver todas las ventas realizadas por método de pago.</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Método de pago</label>
                                    <select class="form-select" name="paymentMethod" id="payment-method" required>
                                        <option value="">Seleccione el método de pago</option>
                                        <?php foreach($paymentMethod as $row)
                                            echo '<option value="'.$row->id_metodo_pago.'">'.$row->nombre.'</option>';
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="coin">Moneda</label>
                                    <select class="form-select" name="coin" id="coin" required>
                                        <option value="">Seleccione la moneda</option>
                                        <?php foreach($coins as $row)
                                            echo '<option value="'.$row->identificacion.'">'.$row->moneda.'</option>';
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mt-2 mb-4 col-md-6">
                                <input type="text" class="form-control range" placeholder="Selecciona una fecha" id="range" data-type="sales_per_payment_method">
                            </div>
                            <div class="col-md-6 mt-2 mb-4 d-block mx-auto">
                                <button class="btn btn-success w-100" id="btn-report" style="display: none">Generar reporte por método de pago</button>
                            </div>
                        </div>
                        <table class="table-report" style="display: none">
                            <tr>

                                <td style='background-color:white; width:350px'>
                                    
                                    <div style='font-size:14px; text-align:left; line-height:15px; margin-left: 20px'>
                                        
                                        <br><br>
                                        <strong style='font-size: 23px'>Reporte de ventas por método de pago</strong>
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

                        <table class="table-report" style="display: none">
		
                            <tr>
                                
                                <td style='width:350px; margin-left: 20px'>

                                </td>

                                <td style='background-color:white; width:250px'>
                                    
                                    <div style='font-size:14px; text-align:right; line-height:23px;'>
                                        
                                        <br>
                                        <strong>Método de pago:</strong> <span id="payment-method-report"></span>
                                        <br>

                                    </div>

                                </td>

                                <td style='background-color:white; width:250px'>

                                    <div style='font-size:14px; text-align:right; line-height:23px; margin-left: 50px'>
                                        
                                        <br>
                                        <strong>Moneda:</strong> <span id="coin-report"></span>
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
                                        <th>Factura</th>
                                        <th>Fecha</th>
                                        <th>Usuario</th>
                                        <th>Cliente</th>
                                        <th>Total</th>
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

    $(document).on('change', '#coin, #payment-method', function(){

        if($('#coin option:selected').val() != '' && $('#payment-method option:selected').val() != ''){
            if(!$.fn.dataTable.isDataTable( '.datatable' )){
                tableConfig('/sales_per_payment_method', '.datatable');
            }
            $('.datatable').DataTable().ajax.reload();
        }
    });

    $("#range").flatpickr({
        locale: 'es',
        mode: 'range',
        maxDate: 'today'
    });
</script>

