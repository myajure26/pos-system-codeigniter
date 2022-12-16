$(document).on('input', '.userIdentification', function(){

    if($(this).val().length > 8){
        $(this).val($(this).val().slice(0,8));
    }

    let patternInput = new RegExp('^(([1-9]){1}[0-9]{6,7})$');
    let feedback = $(this).next();

    if( !$(this).val().match(patternInput) || $(this).val() == ''){
        $(this).addClass('is-invalid');
        feedback.text('Introduce una cédula válida. Ejemplo: 22374834');
        feedback.show();
        return false;

    }

    $(this).removeClass('is-invalid');
    feedback.hide();

});

$(document).on('input', '.password', function(){

    let feedback = $(this).parent().children('.invalid-feedback');
    
    if($(this).val().length < 8){
        $(this).addClass('is-invalid');
        feedback.text('La contraseña debe contener más de 8 carácteres');
        feedback.show();
        return false;
    }
    $(this).removeClass('is-invalid');
    feedback.hide();

});

$(document).on('input', '.ci-rif', function(){

    if($(this).val().length > 9){
        $(this).val($(this).val().slice(0,9));
    }

    let patternInput = new RegExp('^(([1-9]){1}[0-9]{6,8})$');
    let feedback =  $(this).parent().children('.invalid-feedback');

    if( !$(this).val().match(patternInput) || $(this).val() == ''){
        $(this).addClass('is-invalid');
        feedback.text('Introduce una cédula/rif válida. Ejemplo: 22374834');
        feedback.show();
        return false;

    }

    $(this).removeClass('is-invalid');
    feedback.hide();

});

$(document).on('input', '.rif', function(){

    if($(this).val().length > 9){
        $(this).val($(this).val().slice(0,9));
    }

    let patternInput = new RegExp('^(([1-9]){1}[0-9]{8})$');
    let feedback =  $(this).parent().children('.invalid-feedback');

    if( !$(this).val().match(patternInput) || $(this).val() == ''){
        $(this).addClass('is-invalid');
        feedback.text('Introduce un rif válido. Ejemplo: J-284567534');
        feedback.show();
        return false;

    }

    $(this).removeClass('is-invalid');
    feedback.hide();

});

$(document).on('input', '.name', function(){
    
    let patternInput = new RegExp('^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$');
    let feedback =  $(this).parent().children('.invalid-feedback');
    
    if($(this).val().length > 50){
        $(this).val($(this).val().slice(0,50));
        $(this).addClass('is-invalid');
        feedback.text('El nombre no debe contener más de 50 carácteres');
        feedback.show();
        return false;
    }

    if( !$(this).val().match(patternInput) || $(this).val() == ''){
        $(this).addClass('is-invalid');
        feedback.text('El nombre no debe ir vacío, ni contener números o carácteres especiales');
        feedback.show();
        return false;

    }

    $(this).removeClass('is-invalid');
    feedback.hide();

});

$(document).on('input', '.phone', function(){

    if($(this).val().length > 11){
        $(this).val($(this).val().slice(0,11));
    }

    let patternInput = new RegExp('^(0414|0424|0412|0416|0426|0251)[0-9]{7}$');
    let feedback =  $(this).parent().children('.invalid-feedback');

    if( !$(this).val().match(patternInput) || $(this).val() == ''){
        $(this).addClass('is-invalid');
        feedback.text('Introduce un teléfono válido. Ejemplo: 04121534253');
        feedback.show();
        return false;

    }

    $(this).removeClass('is-invalid');
    feedback.hide();

});

$(document).on('input', '.address', function(){

    let patternInput = new RegExp('^[a-z0-9ñáéíóúüA-ZÑÁÉÍÓÚÜ .,-]*$');
    let feedback =  $(this).parent().children('.invalid-feedback');

    if( !$(this).val().match(patternInput)){
        $(this).addClass('is-invalid');
        feedback.text('Para la dirección sólo se permiten carácteres alfabéticos y guiones');
        feedback.show();
        return false;

    }

    if( $(this).val() == '' ){
        $(this).addClass('is-invalid');
        feedback.text('La dirección no puede estar vacia');
        feedback.show();
        return false;

    }

    $(this).removeClass('is-invalid');
    feedback.hide();

});

$(document).on('input', '.ref', function(){

    if($(this).val().length > 10){
        $(this).val($(this).val().slice(0,10));
    }

    let feedback = $(this).parent().children('.invalid-feedback');
    
    if( $(this).val().length < 5 || $(this).val().length > 10){
        $(this).addClass('is-invalid');
        feedback.text('La referencia debe estar conformada entre 5 y 10 números');
        feedback.show();
        return false;
    }
    $(this).removeClass('is-invalid');
    feedback.hide();

});

$(document).on('input', '.name-with-number', function(){
    
    let patternInput = new RegExp('^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ0-9 ]*$');
    let feedback =  $(this).parent().children('.invalid-feedback');
    
    if($(this).val().length > 50){
        $(this).val($(this).val().slice(0,50));
        $(this).addClass('is-invalid');
        feedback.text('El nombre no debe contener más de 50 carácteres');
        feedback.show();
        return false;
    }

    if( !$(this).val().match(patternInput) || $(this).val() == ''){
        $(this).addClass('is-invalid');
        feedback.text('Para el nombre sólo se permiten carácteres alfanuméricos');
        feedback.show();
        return false;

    }

    $(this).removeClass('is-invalid');
    feedback.hide();

});

$(document).on('input', '.name-tax', function(){
    
    let patternInput = new RegExp('^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ0-9 %]*$');
    let feedback =  $(this).parent().children('.invalid-feedback');
    
    if($(this).val().length > 50){
        $(this).val($(this).val().slice(0,50));
        $(this).addClass('is-invalid');
        feedback.text('El nombre no debe contener más de 50 carácteres');
        feedback.show();
        return false;
    }

    if( !$(this).val().match(patternInput) || $(this).val() == ''){
        $(this).addClass('is-invalid');
        feedback.text('Para el nombre sólo se permiten carácteres alfanuméricos y el símbolo de porcentaje (%)');
        feedback.show();
        return false;

    }

    $(this).removeClass('is-invalid');
    feedback.hide();

});

$(document).on('input', '.symbol', function(){
    
    let patternInput = new RegExp('^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ $€¥.,]*$');
    let feedback =  $(this).parent().children('.invalid-feedback');
    
    if($(this).val().length > 5){
        $(this).val($(this).val().slice(0,5));
        $(this).addClass('is-invalid');
        feedback.text('El simbolo no debe contener más de 5 carácteres');
        feedback.show();
        return false;
    }

    if( !$(this).val().match(patternInput) || $(this).val() == ''){
        $(this).addClass('is-invalid');
        feedback.text('El símbolo no debe ir vacío, ni contener números o carácteres especiales');
        feedback.show();
        return false;

    }

    $(this).removeClass('is-invalid');
    feedback.hide();

});

$(document).on('input', '.percentaje', function(){
    
    let patternInput = new RegExp('^[0-9]*$');
    let feedback =  $(this).parent().children('.invalid-feedback');
    
    if($(this).val().length > 2){
        $(this).val($(this).val().slice(0,2));
        $(this).addClass('is-invalid');
        feedback.text('El porcentaje no debe contener más de 2 carácteres');
        feedback.show();
        return false;
    }

    if( !$(this).val().match(patternInput) || $(this).val() == ''){
        $(this).addClass('is-invalid');
        feedback.text('El porcentaje no debe ir vacío ni contener carácteres especiales o letras');
        feedback.show();
        return false;

    }

    $(this).removeClass('is-invalid');
    feedback.hide();

});

$(document).on('input', '.number', function(){
    
    let patternInput = new RegExp('^[0-9]*$');
    let feedback =  $(this).parent().children('.invalid-feedback');
    
    if($(this).val().length > 3){
        $(this).val($(this).val().slice(0,3));
        $(this).addClass('is-invalid');
        feedback.text('El número no debe contener más de 3 carácteres');
        feedback.show();
        return false;
    }

    if( !$(this).val().match(patternInput) || $(this).val() == ''){
        $(this).addClass('is-invalid');
        feedback.text('El número no debe ir vacío ni contener carácteres especiales o letras');
        feedback.show();
        return false;

    }

    $(this).removeClass('is-invalid');
    feedback.hide();

});

$(document).on('input', '.stock', function(){
    
    let patternInput = new RegExp('^[0-9]*$');
    let feedback =  $(this).parent().children('.invalid-feedback');
    
    if($(this).val().length > 5){
        $(this).val($(this).val().slice(0,5));
        $(this).addClass('is-invalid');
        feedback.text('El número no debe contener más de 5 carácteres');
        feedback.show();
        return false;
    }

    if( !$(this).val().match(patternInput) || $(this).val() == ''){
        $(this).addClass('is-invalid');
        feedback.text('El número no debe ir vacío ni contener carácteres especiales o letras');
        feedback.show();
        return false;

    }

    $(this).removeClass('is-invalid');
    feedback.hide();

});