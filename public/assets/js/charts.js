$(document).ready(function(){

    // Generar xls
    $(document).on('click', '#purchase-report', function(){

        let range = $(this).attr('range');
        const type = $('#reports-range').attr('data-type');

        // Quitar los espacios
        // / significa el inicio de una expresión regular y g de global
        range = range.replace(/ /g, '');

        if(type === 'general_purchase_reports'){
            
            window.open(url + '/reports/purchase/' + range, '_blank');

        }

    });

    $(document).on('click', '#report-chart-submit', function(){

        const range = $('#reports-range').val();
        const type = $('#reports-range').attr('data-type');

        $('#purchase-report').attr('range', range);
        $('#purchase-report').slideDown();
    

        if(range == ''){
            
            Swal.fire({
                icon: 'error',
                title: 'Oops',
                text: 'Tienes que seleccionar una fecha'
            });
            $('#purchase-report').slideUp();
            return false;

        }

        const data = new FormData();
        data.append('range', range);


        $.ajax({
            type: 'POST',
            url: url + '/' + type,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                Swal.fire({
                    icon: 'info',
                    title: '<strong>Procesando...</strong>',
                    text: 'Por favor, espera unos segundos',
                    showConfirmButton: false,
                    didOpen: function() {
                        Swal.showLoading();
                    }
                });
            },
            success: function (data) {
                Swal.close();
                
                if(data == ''){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops',
                        text: 'Tienes que seleccionar un rango de fecha'
                    });
                    $('#purchase-report').slideUp();
                    return false;
                }
                
                data = $.parseJSON(data);

                console.log(data)
                
                if(type == 'general_purchase_reports'){

                    generalPurchase(data[0]);
                    generalProviders(data[1]);
                    generalNegativeProviders(data[2]);

                }

            },
            error: function (data) {
                $('#purchase-report').slideUp();
                Swal.close();
            }
        });
        return false;

    });

    const generalPurchase = (data) => {

        const compras = [];
        const fechas = [];

        data.forEach(element => {
            compras.push(element.total);
            fechas.push(element.fecha);
        });

        // Actualizar la gráfica
        chart.updateOptions({
            series: [{
                name: 'Compras',
                data: compras,
                color: '#5156be'
            }],
            xaxis: {
              categories: fechas
            }
        });
    }

    const generalProviders = (data) => {

        const proveedor = [];
        const total = [];

        data.forEach(element => {
            total.push(Number(element.total));
            proveedor.push(element.proveedor);
        });

        // Actualizar la gráfica
        donutChart.updateOptions({
            series: total,
            labels: proveedor,
        });
    }

    const generalNegativeProviders = (data) => {

        const proveedor = [];
        const total = [];

        data.forEach(element => {
            total.push(Number(element.total));
            proveedor.push(element.proveedor);
        });

        // Actualizar la gráfica
        donutChart2.updateOptions({
            series: total,
            labels: proveedor,
        });
    }


});

