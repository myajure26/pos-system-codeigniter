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
                    <h4 class="mb-sm-0 font-size-18">Nueva compra</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:
                                    void(0);">Administrar compras</a></li>
                            <li class="breadcrumb-item active">Nueva compra</li>
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
                        <h4 class="card-title">Registrar nueva compra</h4>
                        <p class="card-title-desc">En este módulo solamente podrás registrar nuevas compras</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div>
                                    <form>
                                        <div class="row">                       
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="date">Fecha de la compra</label>
                                                    <input type="date" class="form-control" id="date" name="date"> 
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="provider">Proveedor</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="provider" placeholder="Por favor, busque al proveedor" readonly>
                                                        <div class="input-group-btn"><button type="button" class="btn btn-primary"><i class="fas fa-search"></i></button></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    
                                        <div class="row">                       
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Tipo de comprobante</label>
                                                    <select class="form-select" name="receipt" id="receipt" required>
                                                        <option value="">Seleccione el comprobante</option>
                                                        <option value="invoice">Factura</option>
                                                        <option value="deliveryNote">Nota de entrega</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="reference">Número de referencia</label>
                                                    <input type="number" class="form-control" id="reference" placeholder="Ingresa el número de referencia" name="reference" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="tax">Impuesto</label>
                                                    <select class="form-select" name="tax" id="tax" required>
                                                        <option value="">Seleccione el impuesto</option>
                                                        <?php foreach($taxes as $row)
                                                            echo '<option value="'.$row->id.'">'.$row->tax.'</option>';
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="tax">Productos</label>
                                                    <button type="button" class="btn btn-primary d-block w-100">Buscar productos</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <button type="submit" class="btn btn-primary w-md">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->