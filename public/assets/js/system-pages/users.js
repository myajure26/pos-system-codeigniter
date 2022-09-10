$(document).ready(function(){

	// AJAX UPDATE USER
	$(document).on('click', '.btnUpdateUser', function(){ //De esta manera se ejecutará así la clase no se haya cargado aún

        //Vaciar el input file
        $('.photo').val('');

        var id = $(this).attr('user-id');
        var action = $('form').attr('action');
        
        var data = new FormData();
        data.append('id', id);

        $.ajax({
            url: action,
            method: "POST",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (data) {
                
                $('#updateName').val(data['name']);
                $('#updateUsername').val(data['username']);
                $('#updatePass').val(data['password']);
                $('#updateRole').val(data['role']);
                $('#updateStatus').val(data['status']);
                $('#img').val(data['photo']);
                if(data['photo'] != ''){
                    $('#updatePhoto').attr('src', data['photo']);
                    $('#img').val(data['photo']);
                }
            },
            error: function (data) {
                
                console.log(data);
                $('#modalEditUser').modal('hide');
                
                Swal.fire({
                   title: 'Ha ocurrido un error',
                   text: 'Vuelva a intentarlo',
                   icon: 'error'
                });

                loader.hide();
            }
        });
        return false;
    });


});