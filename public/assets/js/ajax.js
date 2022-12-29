const url = $(location).attr('origin');

// ? NAVEGACIÓN CON AJAX
$(window).on("hashchange", function(e) {
	e.preventDefault();
	// var page = $(this).attr("href").split('/')[3];
	
	if ($(this).attr("target") == "_self") {window.location.href= page; return true};
	if ($(this).attr("target") == "_blank") window.open(page, "_blank");

	page = window.location.hash;
	if (page == "javascript: void(0);") return false;
    if (page == undefined) return false;
	call_ajax_page(page);


	// $(".metismenu li, .metismenu li a").removeClass("active");
	// $(".metismenu ul").removeClass("in");

	// $(".metismenu a").each(function() {
	// 	var pageUrl = window.location.hash.substr(1);
	// 	if ($(this).attr("href") == pageUrl) {
	// 		$(this).addClass("active");
	// 		$(this).parent().addClass("mm-active"); // add active to li of the current link
	// 		$(this).parent().parent().addClass("mm-show");
	// 		$(this).parent().parent().prev().addClass("mm-active"); // add active class to an anchor
	// 		$(this).parent().parent().parent().addClass("mm-active");
	// 		$(this).parent().parent().parent().parent().addClass("mm-show"); // add active to li of the current link
	// 		$(this).parent().parent().parent().parent().parent().addClass("mm-active");
	// 	}
	// });

	// $(".navbar-nav a").removeClass("active"); 
	// $(".navbar-nav li").removeClass("active"); 
	// $(".navbar-nav a").each(function () {
	// 	var pageUrl = window.location.hash.substr(1);
	// 	if ( $(this).attr('href') == pageUrl) {
	// 		$(this).addClass("active");
	// 		$(this).parent().addClass("active");
	// 		$(this).parent().parent().addClass("active");
	// 		$(this).parent().parent().parent().addClass("active");
	// 		$(this).parent().parent().parent().parent().addClass("active");
	// 		$(this).parent().parent().parent().parent().parent().addClass("active");
	// 	}
	// });

	 
});

function call_ajax_page(page) {

	page = page.split('#')[1];
	var path = url + "/app/" + page;
	
	$.ajax({
		url: path,
		cache: false,
		contentType: false,
        processData: false,
		dataType: "html",
		type: "GET",
		success: function(data) {
			$("#miniaresult").empty();
			$("#miniaresult").html(data);
			if($('body').attr('data-layout-mode') == 'dark'){
		        $('.page-content').css("background", "#313533");
			}
			window.location.hash = page;
			$(window).scrollTop(0);
		}
	});
}

$(document).ready(function() {

	const path = window.location.hash.substr(0);
	if(path == ""){
		call_ajax_page("#dashboard");
	}else{
		call_ajax_page(path);
	}

    // AJAX FORM
    $(document).on('submit', 'form', function (e) {
        e.preventDefault();

        const form = $(this);
        const response = $('.response');
        const action = form.attr('action');
        const method = form.attr('method');
        const type = form.attr('type');
        const formdata = new FormData(this);

        if(formdata.get('legalIdentification')){
            const identification = formdata.get('letter') + '-' + formdata.get('legalIdentification');
            formdata.append('identification', identification);
        }

        if( type === 'saveCustomerSale' ){
            formdata.append('saveCustomerSale', type);
        }


        $.ajax({
            type: method,
            url: action,
            data: formdata ? formdata : form.serialize(),
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
                
                // if( type === 'saveCustomerSale' ){
                //     $('#name, #phone, #address').attr('disabled', 'disabled');
                //     $('.saveCustomer').removeClass('saveCustomer').addClass('addCustomer').attr('type', 'button');
                //     $('.addCustomer i').removeClass('fas fa-user-check').addClass('fas fa-user-plus');
                //     $('#customerNext').slideDown();
                //     $('#hiddenCustomer').val(formdata.get('identification'));

                // }

                response.html(data);
            },
            error: function (data) {
                response.html(data);
            }
        });
        return false;
    });

    $(document).on('click', '.btnUpdate', function(){
        $('.btnSubmit').show();
        $('.btnUpdate').hide();
        $('.viewForm input, .viewForm textarea, .viewForm select, .viewForm .btn-disabled').removeAttr('disabled');

        $('.viewDisabled').attr('disabled', 'true');
        $('.viewReadonly').attr('readonly', 'readonly');   

        $("#viewModal").on('hidden.bs.modal', function () {
            $('.btnSubmit').hide();
            $('.btnUpdate').show();
            $('.viewForm input, .viewForm textarea, .viewForm select, .viewForm .btn-disabled').attr('disabled', 'true');
            $('#newPhoto').attr('src', url + "/assets/images/users/anonymous.png");
            $('.invalid-feedback').hide();
            $('input').removeClass('is-invalid');
        });
    });

    // AJAX UPDATE
    $(document).on('click', '.btnView', function(){

        //Vaciar form
        $('form')[1].reset();
        $('#list tr').each(function(){
            $(this).remove();
        });

        const id = $(this).attr('data-id');
        const type = $(this).attr('data-type');

        $.ajax({
            url: url + '/' + type + '/getById/' + id,
            method: "GET",
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
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
                view(data, type);
                Swal.close();

            },
            error: function (data) {
                
                Swal.fire({
                    title: 'Alerta',
                    text: 'Ocurrió un error',
                    icon: 'error'
                });
                $('#viewModal').modal('hide');
            }
        });
        return false;
    });

    

    function view(data, type){

        switch(type){
            case 'categories':
               return viewCategory(data);
            case 'brands':
               return viewBrand(data);
            case 'highRubber':
                return viewHighRubber(data);
            case 'wideRubber':
                return viewWideRubber(data);
            case 'coins':
               return viewCoin(data);
            case 'taxes':
               return viewTax(data);
            case 'document_type':
                return viewDocumentType(data);
            case 'payment_method':
                    return viewPaymentMethod(data);
            case 'privileges':
                return viewPrivileges(data);
            case 'products':
               return viewProduct(data);
            case 'customers':
                return viewCustomer(data);
            case 'providers':
               return viewProvider(data);
            case 'users':
               return viewUser(data);
            case 'sales':
                return viewSale(data);
            case 'purchases':
                return viewPurchase(data);
            case 'orders':
                    return viewOrder(data);
            case 'coinPrices':
               return viewCoinPrices(data);
        }
            
    }

    // AJAX DELETE
    $(document).on('click', '.btnDelete', function(){ 
        
        const response = $('.response');
        const id = $(this).attr('data-id');
        const type = $(this).attr('data-type');
        
        const data = new FormData();
        data.append('identification', id);
        
        if(type == 'users'){
            data.append('photo', $(this).attr('photo'));
        }
        
        Swal.fire({
           
           title: '¿Está seguro de eliminar la fila con identificación '+id+'?',
           text: 'Si no está seguro, puede cancelar la operación',
           icon: 'warning',
           showCancelButton: true,
           cancelButtonColor: '#D33',
           confirmButtonText: 'Sí',
           cancelButtonText: 'Cancelar'

        }).then((result) => {
            if(result.value){

                //AJAX
                $.ajax({
                    url: url + '/' + type + '/delete',
                    method: "POST",
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
                        response.html(data);
                    },
                    error: function (data) {
                        Swal.fire({
                           title: 'Ha ocurrido un error',
                           text: 'Intente nuevamente',
                           icon: 'error'
                        });

                    }
                });
            }
        });
    });    

    // AJAX RECOVER
    $(document).on('click', '.btnRecover', function(){ 
        
        const response = $('.response');
        const id = $(this).attr('data-id');
        const type = $(this).attr('data-type');
        
        const data = new FormData();
        data.append('identification', id);
        
        Swal.fire({
           
           title: '¿Está seguro de recuperar la fila con identificación '+id+'?',
           text: 'Si no está seguro, puede cancelar la operación',
           icon: 'warning',
           showCancelButton: true,
           cancelButtonColor: '#D33',
           confirmButtonText: 'Sí',
           cancelButtonText: 'Cancelar'

        }).then((result) => {
            if(result.value){

                //AJAX
                $.ajax({
                    url: url + '/' + type + '/recover',
                    method: "POST",
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
                        response.html(data);
                    },
                    error: function (data) {
                        Swal.fire({
                           title: 'Ha ocurrido un error',
                           text: 'Intente nuevamente',
                           icon: 'error'
                        });

                    }
                });
            }
        });
    });    

    /**
     * AJAX SALES
     */

    // SEARCH CUSTOMER
    $(document).on('click', '.searchCustomer', function(){ 

        $('#name').attr('disabled', 'disabled');
        $('#phone').attr('disabled', 'disabled');
        $('#address').attr('disabled', 'disabled');
        
        $('.saveCustomer, .addCustomer').removeClass('saveCustomer').addClass('addCustomer').attr('type', 'submit');
        $('.addCustomer i').removeClass('fas fa-user-check').addClass('fas fa-user-plus');


        const letter = $('.letter').val();
        const numIdentification = $('.identification').val();
        const identification = letter + '-' + numIdentification;

        if(numIdentification === ''){
            $('.identification').addClass('is-invalid');
            return false;
        }
        $('.identification').removeClass('is-invalid');
        
        $.ajax({
            url: url + '/customers/getById/' + identification,
            method: "GET",
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
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

                $('#name').val(data[0].nombre);
                $('#phone').val(data[0].telefono);
                $('#address').val(data[0].direccion);
                $('#hiddenCustomer').val(identification);
                $('#customerNext').slideDown();
                

                Swal.close();
            },
            error: function () {

                $('#name').val('');
                $('#phone').val('');
                $('#address').val('');
                $('#customerNext').slideUp();
                $('.addCustomer').removeAttr('disabled');

                Swal.fire({
                title: 'El usuario no existe',
                text: 'Haz click en agregar nuevo usuario',
                icon: 'warning'
                });

            }
        });
    });

    $(document).on('click', '.addCustomer', function(){
        $('#name, #phone, #address').removeAttr('disabled');
        $('.addCustomer i').removeClass('fas fa-user-plus').addClass('fas fa-user-check');
        $(this).removeClass('addCustomer').addClass('saveCustomer').attr('type', 'submit');
    });

    // Buscar la tasa de cambio
    $(document).on('change', '#coinSale', function(){ 
        totalSaleCount();
        const identification = $(this).val();

        if(identification === '') return false;
        
        $.ajax({
            url: url + '/sales/getRate/' + identification,
            method: "GET",
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
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

                let rate = Number(data[0].precio.replace('.', ""));
                
                let subtotal = Number($('.subtotal').val().replace(/,/g, "").replace('.', ""));
                let tax = Number($('.tax').val().replace(/,/g, "").replace('.', ""));
                let total = Number($('.total').val().replace(/,/g, "").replace('.', ""));

                $('#rate').val(data[0].precio);
                
                rate = rate * 0.01;
                subtotal = (subtotal * 0.01) * rate;
                total = (total * 0.01) * rate;
                tax = (tax * 0.01) * rate;

                subtotal = subtotal.toLocaleString('en', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                total = total.toLocaleString('en', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                tax = tax.toLocaleString('en', {minimumFractionDigits: 2, maximumFractionDigits: 2})

                $('.subtotal').val(subtotal);
                $('.tax').val(tax);
                $('.total').val(total);
                

                Swal.close();
            },
            error: function () {

                Swal.fire({
                    title: 'Alerta',
                    text: 'No ha actualizado los precios de las monedas de hoy',
                    icon: 'warning'
                });
                $('#rate').val('');
                totalSaleCount();

            }
        });

        if(identification == $(this).attr('principalCoin')){
            $('#rate').val('1.00');
            return false;
        }
        
    });

    // AJAX FORM
    $(document).on('click', '#processSale', function (e) {
        e.preventDefault();

        let data = new FormData($('#productForm')[0]);
        let data2 = new FormData($('#saleForm')[0]);

        // Obtienes las entradas del formulario X para meterlos al fomulario Y.
        for (let [key, value] of data2.entries()) {
            data.append(key, value);
        }

        const response = $('.response');
        const action = $('#productForm').attr('action');
        const method = $('#productForm').attr('method');


        $.ajax({
            type: method,
            url: action,
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

                response.html(data);

            },
            error: function (data) {
                response.html(data);
            }
        });
        return false;
    });

    // * Seleccionar proveedor para asignar
    $(document).on('click', '.btn-select-provider-to-assign', function(){
        $('#list tr').each(function(){
            $(this).remove();
        });
        $('#providerInput').val($(this).closest('tr').find('td:eq(2)').text());
        $('#provider, #viewProvider').val($(this).closest('tr').find('td:eq(1)').text());

        const identification = $(this).closest('tr').find('td:eq(1)').text();


        $.ajax({
            url: url + '/products/getProviderAssignInfo/' + identification,
            method: "GET",
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
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
 

                data.map( data => {

                    $('#list').append(`
                        <tr id="${data.codigo}">
                            <td>${data.codigo}</td>
                            <td>${data.nombre} ${data.ancho_numero}/${data.alto_numero}</td>
                            <td>${data.categoria}</td>
                            <td>${data.marca}</td>
                            <td>
                                <div class="btn-list"> 
                                    <button type="button" class="removeAssignProduct btn btn-sm btn-danger waves-effect d-block mx-auto" data-id="${data.codigo}">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                    `);

                });

                Swal.close();
            },
            error: function () {

                Swal.fire({
                title: 'Error',
                text: 'Ha ocurrido un error al obtener la información',
                icon: 'error'
                });

            }
        });


        $('#searchProviderModal').modal('hide');
    });

    // * Seleccionar el producto para asignar
    $(document).on('click', '.btn-select-product-to-assign', function(){

        const code = $(this).closest('tr').find('td:eq(1)').text();
        const name = $(this).closest('tr').find('td:eq(2)').text();
        const category = $(this).closest('tr').find('td:eq(3)').text();
        const brand = $(this).closest('tr').find('td:eq(4)').text();

        const provider = $("#provider").val();
        const data = new FormData();
        data.append('provider', provider);
        data.append('product', code);

        $.ajax({
            url: url + '/products/setProviderAssignInfo',
            method: "POST",
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

                if($('#'+code).length > 0){
                    Swal.fire({
                        icon: 'info',
                        title: 'Alerta',
                        text: 'Ya el producto se encuentra asignado',
                    });
                    return false;
                }

                $('#list').append(`
                    <tr id="${code}">
                        <td>${code}</td>
                        <td>${name}</td>
                        <td>${category}</td>
                        <td>${brand}</td>
                        <td>
                            <div class="btn-list"> 
                                <button type="button" class="removeAssignProduct btn btn-sm btn-danger waves-effect d-block mx-auto" data-id="${code}">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `);

                Swal.close();
            },
            error: function () {

                Swal.fire({
                title: 'Error',
                text: 'Ha ocurrido un error inesperado',
                icon: 'error'
                });

            }
        });

        
    });

    //Eliminar producto de la lista
    $(document).on('click', '.removeAssignProduct', function(){
        
        const tr = $(this).closest('tr');
        const product = $(this).attr('data-id');
        const provider = $('#provider').val();

        const data = new FormData();
        
        data.append('product', product);
        data.append('provider', provider);

        $.ajax({
            url: url + '/products/deleteProviderAssignInfo',
            method: "POST",
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
                
                tr.remove();
                Swal.close();

            },
            error: function () {

                Swal.fire({
                title: 'Error',
                text: 'Ha ocurrido un error al eliminar el producto',
                icon: 'error'
                });

            }
        });

    });

    // * PEDIDOS

    //Eliminar producto de la lista de pedidos
    $(document).on('click', '.removeProductOrder', function(){
        
        const tr = $(this).closest('tr');
        const order = $(this).attr('data-id');
        const product = $(this).attr('product');

        if( $('#list tr').length == 1 ){
            Swal.fire({
                title: 'Alerta',
                text: 'El pedido no puede quedar sin productos',
                icon: 'warning'
            });
            return false;
        }

        const data = new FormData();
        
        data.append('product', product);
        data.append('order', order);

        Swal.fire({
           
            title: '¿Está seguro de eliminar el producto con código #'+product+'?',
            text: 'Si no está seguro, puede cancelar la operación',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#D33',
            confirmButtonText: 'Sí',
            cancelButtonText: 'Cancelar'
 
         }).then((result) => {
             if(result.value){

                $.ajax({
                    url: url + '/orders/deleteProductOrder',
                    method: "POST",
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
                        
                        tr.remove();
                        Swal.close();

                    },
                    error: function () {

                        Swal.fire({
                        title: 'Alerta',
                        text: 'Ha ocurrido un error al eliminar el producto',
                        icon: 'error'
                        });

                    }
                });
            }
        });

    });

    //Aceptar pedido
    $(document).on('click', '.acceptOrder', function(){

        const order = $(this).attr('data-id');
        const response = $('.response');

        const data = new FormData();
        data.append('order', order);

        Swal.fire({
           
            title: '¿Está seguro de aceptar el pedido con identificación #'+order+'?',
            text: 'Si no está seguro, puede cancelar la operación',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#D33',
            confirmButtonText: 'Sí',
            cancelButtonText: 'Cancelar'
 
         }).then((result) => {
             if(result.value){

                $.ajax({
                    url: url + '/orders/acceptOrder',
                    method: "POST",
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
                        
                        response.html(data);

                    },
                    error: function (error) {

                        Swal.fire({
                            title: 'Alerta',
                            text: 'Ha ocurrido un error al aceptar el pedido',
                            icon: 'error'
                        });

                    }
                });
            }
        });
    });


});