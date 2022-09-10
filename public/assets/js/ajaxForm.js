$(document).ready(function(){
	$('form').submit(function (e) {
        e.preventDefault();

        var form = $(this);
        var response = $('.response');
        var action = form.attr('action');
        var method = form.attr('method');
        var formdata = new FormData(this);
        var loader = '<span class="spinner-border spinner-border-sm loader" role="status"></span>';
        
        $('.sent').attr('disabled', 'true').html(loader);
   
        $.ajax({
            type: method,
            url: action,
            data: formdata ? formdata : form.serialize(),
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
        		$('.sent').removeAttr('disabled').html('Guardar');
                response.html(data);
            },
            error: function (data) {
                $('.sent').removeAttr('disabled').html('Guardar');
                response.html(data);
            }
        });
        return false;
    });
});