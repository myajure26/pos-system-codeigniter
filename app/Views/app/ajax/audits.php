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
                    <h4 class="mb-sm-0 font-size-18">Auditoría</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:
                                    void(0);">Configuraciones del sistema</a></li>
                            <li class="breadcrumb-item active">Auditoría</li>
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
                        <h4 class="card-title">Auditoría</h4>
                        <p class="card-title-desc">Aquí podrás ver todos los movimientos realizados en el sistema</p>
                    </div>
                    <div class="card-body">
                        <div class="mt-2 mb-4">
                            <label class="form-label">Rango de fecha</label>
                            <input type="text" class="form-control" placeholder="Selecciona una fecha" id="range">
                        </div>
                        <table class="table datatable text-nowrap table-striped nowrap w-100 dt-responsive">
                            <thead>
                                <tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Usuario</th>
                                        <th>Módulo</th>
                                        <th>Acción</th>
                                        <th>Descripción</th>
                                        <th>Fecha</th>
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
    tableConfig('/audits/get', '.datatable');
    $("#range").flatpickr({
        locale: 'es',
        mode: 'range',
        maxDate: 'today'
    });
</script>
