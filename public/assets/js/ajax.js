const url = $(location).attr('origin');

// MENU
$(document).on("click", ".metismenu li a, .navbar-nav  li a", function(e) {
	e.preventDefault();

	var page = $(this).attr("href").split('/')[3];
	
	if ($(this).attr("target") == "_self") {window.location.href= page; return true};
	if ($(this).attr("target") == "_blank") window.open(page, "_blank");

	 if (page == "javascript: void(0);") return false;

	window.location.hash = page;

	$(".metismenu li, .metismenu li a").removeClass("active");
	$(".metismenu ul").removeClass("in");

	$(".metismenu a").each(function() {
		var pageUrl = window.location.hash.substr(1);
		if ($(this).attr("href") == pageUrl) {
			$(this).addClass("active");
			$(this).parent().addClass("mm-active"); // add active to li of the current link
			$(this).parent().parent().addClass("mm-show");
			$(this).parent().parent().prev().addClass("mm-active"); // add active class to an anchor
			$(this).parent().parent().parent().addClass("mm-active");
			$(this).parent().parent().parent().parent().addClass("mm-show"); // add active to li of the current link
			$(this).parent().parent().parent().parent().parent().addClass("mm-active");
		}
	});

	$(".navbar-nav a").removeClass("active"); 
	$(".navbar-nav li").removeClass("active"); 
	$(".navbar-nav a").each(function () {
		var pageUrl = window.location.hash.substr(1);
		if ( $(this).attr('href') == pageUrl) {
			$(this).addClass("active");
			$(this).parent().addClass("active");
			$(this).parent().parent().addClass("active");
			$(this).parent().parent().parent().addClass("active");
			$(this).parent().parent().parent().parent().addClass("active");
			$(this).parent().parent().parent().parent().parent().addClass("active");
		}
	});

	 if (page == "javascript: void(0);") return false;
	call_ajax_page(page);
});

function call_ajax_page(page) {

	page = page.split('#')[1];
	var origin = $(location).attr('origin');
	var path = origin + "/app/" + page;
	
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
        const formdata = new FormData(this);

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
                response.html(data);
            },
            error: function (data) {
                response.html(data);
            }
        });
        return false;
    });

    // AJAX UPDATE
    $(document).on('click', '.btnUpdate', function(){

        //Vaciar form
        $('form')[1].reset();

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
                update(data, type);
                Swal.close();

            },
            error: function (data) {
                console.log(data);
                Swal.close();
                $('#updateModal').modal('hide');
                
                Swal.fire({
                   title: '¡Oops!',
                   text: 'Ocurrió un error',
                   icon: 'error'
                });
            }
        });
        return false;
    });

    

    function update(data, type){

        switch(type){
            case 'users':
               return updateUser(data);
            case 'categories':
               return updateCategory(data);
            case 'brands':
               return updateBrand(data);
            case 'coins':
               return updateCoin(data);
            case 'taxes':
               return updateTax(data);
            case 'products':
               return updateProduct(data);
            case 'providers':
               return updateProvider(data);
            case 'configCoin':
               return updateConfigCoin(data);
        }
            
    }

    // AJAX DELETE
    $(document).on('click', '.btnDelete', function(){ 
        
        const response = $('.response');
        const id = $(this).attr('data-id');
        const type = $(this).attr('data-type');
        
        const data = new FormData();
        data.append('id', id);
        
        if(type == 'users'){
            data.append('photo', $(this).attr('photo'));
        }
        
        Swal.fire({
           
           title: '¿Está seguro de eliminar la fila #'+id+'?',
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
                        
                        console.log(data);
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
});
