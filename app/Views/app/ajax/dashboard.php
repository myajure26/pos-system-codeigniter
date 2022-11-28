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
                    <h4 class="mb-sm-0 font-size-18">Inicio</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:
                                    void(0);">Panel de control</a></li>
                            <li class="breadcrumb-item active">Inicio</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Ventas del mes en curso</h4>
                    </div>
                    <div class="card-body">
                        <div id="spline_area" class="apex-charts"></div>                      
                    </div>
                </div><!--end card-->
            </div>
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

<script>
    var data = <?=json_encode($chart)?>;

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

    var chart = new ApexCharts(document.querySelector("#spline_area"), options);
    chart.render();

    generalSales(data);
</script>