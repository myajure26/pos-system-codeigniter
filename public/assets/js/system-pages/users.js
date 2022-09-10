$(document).ready(function(){

	const path = $(location).attr('origin');

	// AJAX UPDATE USER
	$(document).on('click', '.btnUpdateUser', function(){ //De esta manera se ejecutará así la clase no se haya cargado aún

        //Vaciar el input file
        $('.photo').val('');
        //Vaciar form
        $('form')[1].reset();

        var id = $(this).attr('user-id');
        var action = $('form').attr('action');

        $.ajax({
            url: path + '/users/getById/' + id,
            method: "GET",
            dataType: "json",
            success: function (data) {
                
                $('#updateCi').val(data[0].ci);
                $('#updateName').val(data[0].name);
                $('#updateEmail').val(data[0].email);
                $('#updatePasswordPreview').val(data[0].password);
                $('#updatePrivilege').val(data[0].privilege);
                $('#updatePhotoPreview').val(data[0].photo);
                $('#updatePhoto').attr('src', path + "/assets/images/users/anonymous.png");
                if(data[0].photo != ''){
                    $('#updatePhoto').attr('src', data[0].photo);
                }

            },
            error: function (data) {
                
                console.log(data);
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


});