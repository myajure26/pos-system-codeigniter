$(document).ready(function(){

	$('.photo').on('change', function(){

        var img = $(this).prop('files')[0]

        console.log(img);

        if($(this).val() == ''){
            $('.img').attr('src', '../../assets/images/users/anonymous.png');
        }

        if(img['type'] != 'image/jpg' && img['type'] != 'image/jpeg' && img['type'] != 'image/png'){

            $(this).val('');
			      $('.img').attr('src', '../../assets/images/users/anonymous.png');

            Swal.fire({
               title: 'Error al subir la imagen',
               text: 'El formato solo puede ser .png, .jpg o .jpeg',
               icon: 'error'
            });

        }else if(img['size'] > 3000000){
            
			$(this).val('');
			$('.img').attr('src', '../../assets/images/users/anonymous.png');
			
            Swal.fire({
               title: 'Error al subir la imagen',
               text: 'El tamaño no puede ser mayor a 3MB',
               icon: 'error'
            });

        }else{

			var data = new FileReader;
			data.readAsDataURL(img);

			$(data).on('load', function(e){

				var route = e.target.result;
				$('.img').attr('src', route);

			});

        }
    });

});