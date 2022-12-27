<script>
    document.title = "<?= $title ?>";
</script>
<div class="page-content">
    <div class="container-fluid">

        <button class="float-btn waves-effect" data-bs-toggle="modal" data-bs-target="#createModal" >
          <span>+</span>
        </button>

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center
                    justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Inventario</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:
                                    void(0);">Administrar inventario</a></li>
                            <li class="breadcrumb-item active">Inventario</li>
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
                        <h4 class="card-title">Administrar inventario</h4>
                        <p class="card-title-desc">En este módulo podrás ver la cantidad de produtos que hay en stock.</p>
                    </div>
                    <div class="card-body">
                    <div class="row">
                            <div class="col-md-3 mb-4">
                                <label class="form-label">Ancho</label>
                                <select class="form-select" id="wideFilter">
                                    <option value="">Seleccione el ancho del caucho</option>
                                    <?php foreach($wide as $row)
                                        echo '<option value="'.$row->id_ancho_caucho.'">'.$row->ancho_numero.'</option>';
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-4">
                                <label class="form-label">Alto</label>
                                <select class="form-control" id="highFilter">
                                    <option value="">Seleccione el alto del caucho</option>
                                    <?php foreach($high as $row)
                                        echo '<option value="'.$row->id_alto_caucho.'">'.$row->alto_numero.'</option>';
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-4">
                                <label class="form-label">Categoría</label>
                                <select class="form-select" id="categoryFilter">
                                    <option value="">Seleccione le categoría</option>
                                    <?php foreach($categories as $row)
                                        echo '<option value="'.$row->identificacion.'">'.$row->categoria.'</option>';
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-4">
                                <label class="form-label">Marca</label>
                                <select class="form-control" id="brandFilter">
                                    <option value="">Seleccione la marca</option>
                                    <?php foreach($brands as $row)
                                        echo '<option value="'.$row->identificacion.'">'.$row->marca.'</option>';
                                    ?>
                                </select>
                            </div>
                        </div>
                        <table class="table datatable text-nowrap table-striped nowrap w-100 dt-responsive">
                            <thead>
                                <tr>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Categoría</th>
                                        <th>Marca</th>
                                        <th>Stock</th>
                                        <th>Stock mínimo</th>
                                        <th>Stock máximo</th>
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
    tableConfig('/inventory', '.datatable');
</script>

