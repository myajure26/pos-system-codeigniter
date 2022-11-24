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
                    <h4 class="mb-sm-0 font-size-18">Reportes generales de compras</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:
                                    void(0);">Administrar ventas</a></li>
                            <li class="breadcrumb-item active">Reportes generales de compras</li>
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
                        <p class="card-title-desc">En este módulo podrás ver todos los reportes de toma de decisión de las compras.</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mt-2 mb-4">
                                <input type="text" class="form-control" placeholder="Selecciona una fecha" id="reports-range" data-type="general_purchase_reports">
                            </div>
                            <div class="col-md-6 mt-2 mb-4">
                                <button class="btn btn-primary w-100" id="report-chart-submit">Buscar</button>
                            </div>
                            <div class="col-md-6 mt-2 mb-4 d-block mx-auto">
                                <button class="btn btn-success w-100" id="purchase-report" style="display: none">Generar reporte de compras</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Gráfico de compras</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="spline_area" class="apex-charts"></div>                      
                                    </div>
                                </div><!--end card-->
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Proveedores más comprados</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="donut" class="apex-charts"></div>                      
                                    </div>
                                </div><!--end card-->
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Proveedores menos comprados</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="donut2" class="apex-charts"></div>                      
                                    </div>
                                </div><!--end card-->
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
    tableConfig('/detailed_sales', '.datatable');
    $("#reports-range").flatpickr({
        locale: 'es',
        mode: 'range',
        maxDate: 'today'
    });

    var options = {
        series: [],
        chart: {
            height: 350,
            type: 'area'
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        xaxis: {
            type: 'dateFormat',
            categories: [],
        },
        tooltip: {
            x: {
            format: 'dd/MM/yy HH:mm'
            },
        },
        noData: {
            text: 'Esperando a que selecciones un rango de fecha'
        }
    }

    var donutChartOption = {
        series: [],
        labels: [],
        chart: {
            height: 350,
            type: 'donut'
        },
        noData: {
            text: 'Esperando a que selecciones un rango de fecha'
        }
    }

    var chart = new ApexCharts(document.querySelector("#spline_area"), options);
    chart.render();

    var donutChart = new ApexCharts(document.querySelector("#donut"), donutChartOption);
    donutChart.render();

    var donutChart2 = new ApexCharts(document.querySelector("#donut2"), donutChartOption);
    donutChart2.render();
</script>


