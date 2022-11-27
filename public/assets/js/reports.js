$(document).ready(function(){

    // Generar xls
    $(document).on('click', '#btn-report', function(){
        
        let range = $(this).attr('range');
        const type = $('#reports-range, #range').attr('data-type');
        
        // * Quitar los espacios
        // ? / significa el inicio de una expresión regular y g de global
        
        if (range) range = range.replace(/ /g, '');

        
        if (type === 'general_purchase_reports'){
            
            window.open(url + '/reports/purchase/' + range, '_blank');
            
        }

        if (type === 'general_sale_reports'){
            
            window.open(url + '/reports/sale/' + range, '_blank');
            
        }

        if (type === 'sales_per_customer'){
            const customer = $('#searchById').val();
            if(range){
                window.open(url + '/reports/sales_per_customer/' + customer + '/' + range, '_blank');
            }else{
                window.open(url + '/reports/sales_per_customer/' + customer, '_blank');
            }

        }

        if (type === 'sales_per_product'){
            const product = $('#searchById').val();
            if(range){
                window.open(url + '/reports/sales_per_product/' + product + '/' + range, '_blank');
            }else{
                window.open(url + '/reports/sales_per_product/' + product, '_blank');
            }

        }

        if (type === 'purchases_per_provider'){
            const provider = $('#searchById').val();
            if(range){
                window.open(url + '/reports/purchases_per_provider/' + provider + '/' + range, '_blank');
            }else{
                window.open(url + '/reports/purchases_per_provider/' + provider, '_blank');
            }

        }

    });

    $(document).on('change', '.range', function(){
        $('.report-date').text($(this).val());
    });

    // * Seleccionar al cliente
    $(document).on('click', '.btn-select-customer', function(){
        $('#searchById').val($(this).closest('tr').find('td:eq(1)').text());
        $('#searchCustomerModal').modal('hide');
        $('.table-report').show();

        $('#identification-report').text($(this).closest('tr').find('td:eq(1)').text());
        $('#name-report').text($(this).closest('tr').find('td:eq(2)').text());
        $('#address-report').text($(this).closest('tr').find('td:eq(3)').text());
        $('#phone-report').text($(this).closest('tr').find('td:eq(4)').text());
        
        $('#btn-report').slideDown();
    });

    // * Seleccionar el producto
    $(document).on('click', '.btn-select-product', function(){
        $('#searchById').val($(this).closest('tr').find('td:eq(1)').text());
        $('#searchProductModal').modal('hide');
        $('.table-report').show();

        $('#identification-report').text($(this).closest('tr').find('td:eq(1)').text());
        $('#name-report').text($(this).closest('tr').find('td:eq(2)').text());
        $('#brand-report').text($(this).closest('tr').find('td:eq(3)').text());
        $('#category-report').text($(this).closest('tr').find('td:eq(4)').text());

        $('#btn-report').slideDown();
    });

    // * Seleccionar el proveedor
    $(document).on('click', '.btn-select-prov', function(){
        $('#searchById').val($(this).closest('tr').find('td:eq(5)').text());
        $('#searchProviderModal').modal('hide');
        $('.table-report').show();

        $('#identification-report').text($(this).closest('tr').find('td:eq(1)').text());
        $('#name-report').text($(this).closest('tr').find('td:eq(2)').text());
        $('#address-report').text($(this).closest('tr').find('td:eq(3)').text());
        $('#phone-report').text($(this).closest('tr').find('td:eq(4)').text());

        $('#btn-report').slideDown();
    });

    // * Guardar el rango cada vez que se seleccione
    $(document).on('change', '.range', function(){
        $('#btn-report').attr('range', $(this).val());
    });

    $(document).on('click', '#report-chart-submit', function(){

        const range = $('#reports-range').val();
        const type = $('#reports-range').attr('data-type');

        $('#btn-report').attr('range', range);
        $('#btn-report').slideDown();
    

        if(range == ''){
            
            Swal.fire({
                icon: 'error',
                title: 'Oops',
                text: 'Tienes que seleccionar una fecha'
            });
            $('#btn-report').slideUp();
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
                    $('#btn-report').slideUp();
                    return false;
                }
                
                data = $.parseJSON(data);

                console.log(data)
                
                if(type == 'general_purchase_reports'){

                    generalPurchases(data[0]);
                    generalProviders(data[1]);
                    generalNegativeProviders(data[2]);

                }

                if(type == 'general_sale_reports'){

                    generalSales(data[0]);
                    generalProducts(data[1]);
                    generalNegativeProducts(data[2]);

                }

            },
            error: function (data) {
                $('#btn-report').slideUp();
                Swal.close();
            }
        });
        return false;

    });

    const generalPurchases = (data) => {

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

    const generalSales= (data) => {

        const ventas = [];
        const fechas = [];

        data.forEach(element => {
            ventas.push(element.total);
            fechas.push(element.fecha);
        });

        // Actualizar la gráfica
        chart.updateOptions({
            series: [{
                name: 'Ventas',
                data: ventas,
                color: '#5156be'
            }],
            xaxis: {
              categories: fechas
            }
        });
    }

    const generalProducts = (data) => {

        const productos = [];
        const total = [];

        data.forEach(element => {
            total.push(Number(element.total));
            productos.push(element.producto);
        });

        // Actualizar la gráfica
        donutChart.updateOptions({
            series: total,
            labels: productos,
        });
    }

    const generalNegativeProducts = (data) => {

        const productos = [];
        const total = [];

        data.forEach(element => {
            total.push(Number(element.total));
            productos.push(element.producto);
        });

        // Actualizar la gráfica
        donutChart2.updateOptions({
            series: total,
            labels: productos,
        });
    }

});

