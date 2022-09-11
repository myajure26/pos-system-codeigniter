$(document).ready(function(){

	var path = $(location).attr('origin');

	// AJAX UPDATE CATEGORY
	$(document).on('click', '.btnUpdateCategory', function(){ 

        //Vaciar form
        $('form')[1].reset();

        var id = $(this).attr('category-id');

        $.ajax({
            url: path + '/categories/getById/' + id,
            method: "GET",
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

});