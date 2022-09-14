const path = $(location).attr('origin');
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

	var path = window.location.hash.substr(0);
	if(path == ""){
		call_ajax_page("#dashboard");
	}else{
		call_ajax_page(path);
	}
});

// AJAX FORM
$(document).on('submit', 'form', function (e) {
    e.preventDefault();

    var form = $(this);
    var response = $('.response');
    var action = form.attr('action');
    var method = form.attr('method');
    var formdata = new FormData(this);

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

// USERS

// AJAX UPDATE USER
$(document).on('click', '.btnUpdateUser', function(){ //De esta manera se ejecutará así la clase no se haya cargado aún

    //Vaciar el input file
    $('.photo').val('');
    //Vaciar form
    $('form')[1].reset();

    const id = $(this).attr('user-id');

    $.ajax({
        url: path + '/users/getById/' + id,
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
            $('#updateId').val(data[0].id);
            $('#updateCi').val(data[0].ci);
            $('#updateName').val(data[0].name);
            $('#updateEmail').val(data[0].email);
            $('#updatePasswordPreview').val(data[0].password);
            $('#updatePrivilege').val(data[0].privilege);
            $('#updatePhotoPreview').val(data[0].photo);
            $('#updatePhoto').attr('src', path + "/assets/images/users/anonymous.png");
            if(data[0].photo != null && data[0].photo != ''){
                $('#updatePhoto').attr('src', data[0].photo);
            }
            Swal.close();

        },
        error: function (data) {
            console.log(data);
            Swal.close();
            $('#updateUserModal').modal('hide');
            
            Swal.fire({
               title: '¡Oops!',
               text: 'Ocurrió un error',
               icon: 'error'
            });
        }
    });
    return false;
});

// AJAX DELETE USER
$(document).on('click', '.btnDeleteUser', function(){ 
    
    var response = $('.response');
    var id = $(this).attr('user-id');
    var photo = $(this).attr('photo');
    var data = new FormData();
    data.append('id', id);
    data.append('ci', ci);
    
    Swal.fire({
       
       title: '¿Está seguro de eliminar el usuario #'+id+'?',
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
                url: path + '/users/delete',
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

// CATEGORIES


// AJAX UPDATE CATEGORY
$(document).on('click', '.btnUpdateCategory', function(){ 

    //Vaciar form
    $('form')[1].reset();

    const id = $(this).attr('category-id');

    $.ajax({
        url: path + '/categories/getById/' + id,
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
            $('#updateId').val(data[0].id);
            $('#updateName').val(data[0].category);
            Swal.close();

        },
        error: function (data) {
            console.log(data);
            Swal.close();
            $('#updateCategoryModal').modal('hide');
            
            Swal.fire({
               title: '¡Oops!',
               text: 'Ocurrió un error',
               icon: 'error'
            });
        }
    });
    return false;
});

// AJAX DELETE CATEGORY
$(document).on('click', '.btnDeleteCategory', function(){ 
    
    var response = $('.response');
    var id = $(this).attr('category-id');
    var data = new FormData();
    data.append('id', id);
    
    Swal.fire({
       
       title: '¿Está seguro de eliminar la categoría #'+id+'?',
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
                url: path + '/categories/delete',
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

// BRANDS

// AJAX UPDATE CATEGORY
$(document).on('click', '.btnUpdateBrand', function(){ 

    //Vaciar form
    $('form')[1].reset();

    const id = $(this).attr('brand-id');

    $.ajax({
        url: path + '/brands/getById/' + id,
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
            $('#updateId').val(data[0].id);
            $('#updateName').val(data[0].brand);
            Swal.close();

        },
        error: function (data) {
            console.log(data);
            Swal.close();
            $('#updateBrandModal').modal('hide');
            
            Swal.fire({
               title: '¡Oops!',
               text: 'Ocurrió un error',
               icon: 'error'
            });
        }
    });
    return false;
});

// AJAX DELETE CATEGORY
$(document).on('click', '.btnDeleteBrand', function(){ 
    
    var response = $('.response');
    var id = $(this).attr('brand-id');
    var data = new FormData();
    data.append('id', id);
    
    Swal.fire({
       
       title: '¿Está seguro de eliminar la marca #'+id+'?',
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
                url: path + '/brands/delete',
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

