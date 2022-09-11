$(document).ready(function(){
	$('form').submit(function (e) {
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
});