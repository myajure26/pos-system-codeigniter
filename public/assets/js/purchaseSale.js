$(document).ready(function(){

    /**
     * COMPRAS y VENTAS
     */

    // Imprimir facturas
    $(document).on('click', '.btnPrint', function(){

        const id = $(this).attr('data-id');
        const type = $(this).attr('data-type');

        if(type === 'sales'){
            
            window.open(url + '/invoice/sale/' + id, '_blank');
        }

    });

    // Seleccionar al proveedor
    $(document).on('click', '.btn-select-provider', function(){
        $('#providerInput').val($(this).closest('tr').find('td:eq(2)').text());
        $('#provider, #viewProvider').val($(this).closest('tr').find('td:eq(1)').text());
        $('#searchProviderModal').modal('hide');
    });

    // Seleccionar el producto en la compra
    $(document).on('click', '.btn-select-product', function(){
        const code = $(this).closest('tr').find('td:eq(1)').text();
        const name = $(this).closest('tr').find('td:eq(2)').text();

        let totalProduct = 0.00;

        $('#list').append(`
            <tr id="${code}">
                <td><input type="hidden" name="productCode[]" value="${code}">${code}</td>
                <td>${name}</td>
                <td><input type="number" class="form-control form-control-sm productQuantity" name="productQuantity[]" value="1" min="1" required></td>
                <td><input type="text" class="form-control form-control-sm price productPrice" name="productPrice[]" value="0.00" required maxlength="10"></td>
                <td class="text-center"><input type="text" class="form-control form-control-sm price totalPriceProduct" value="${totalProduct}" readonly required></td>
                <td>
                    <div class="btn-list"> 
                        <button type="button" class="removeProduct btn btn-sm btn-danger waves-effect d-block mx-auto" data-id="${code}">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `);

        $(".price").priceFormat({
            prefix: ''
        });
    });

    //Eliminar producto de la lista en las compras
    $(document).on('click', '.removeProduct', function(){
        $(this).closest('tr').remove();
        totalCount();
    });
    
    //Calcular al ingresar la cantidad o el precio del producto tanto en venta como en compra
    $(document).on('input', '.productPrice, .productQuantity', function(){
        $(this).closest('tr').find('.productQuantity').removeClass('is-invalid');
        $('#productsNext').slideDown();
        let quantity = $(this).closest('tr').find('.productQuantity').val();
        let price = $(this).closest('tr').find('.productPrice').val();

        //Quitar las comas y puntos
        price = price.replace(/,/g, "");
        price = price.replace('.', "");
        
        //Convertir a números
        price = Number(price);
        quantity = Number(quantity);

        // Validar que la cantidad no sobrepase el stock
        if($(this).closest('tr').find('.productQuantity').attr('data-type') === 'sale'){
            if(quantity > Number($(this).closest('tr').find('.productQuantity').attr('max')) || quantity < 1){
                $(this).closest('tr').find('.productQuantity').addClass('is-invalid');
                $(this).closest('tr').find('.totalPriceProduct').val('0');
                totalSaleCount();
                $('#productsNext').slideUp();
                return false;
            }
        }
        
        //Calcular
        const count = quantity * price;
        
        //Insertar
        $(this).closest('tr').find('.totalPriceProduct').val(count);
        
        //Dar formato
        $(".price").priceFormat({
            prefix: ''
        });
        
        // Si es venta llamar a totalSaleCount y si es compra llamar a totalCount
        ($(this).closest('tr').find('.productQuantity').attr('data-type') === 'sale')
                                                                                    ? totalSaleCount()
                                                                                    : totalCount();

    });
    
    

    // Seleccionar producto en la venta
    $(document).on('click', '.btn-select-sale-product', function(){
        const code = $(this).closest('tr').find('td:eq(1)').text();
        const name = $(this).closest('tr').find('td:eq(2)').text();
        let stock = Number($(this).closest('tr').find('td:eq(6)').text());
        let price = $(this).closest('tr').find('td:eq(5)').text();
        
        // Tenemos que quitarle el simbolo de la moneda que trae el precio
        price = price.slice(1);
        
        // Sacamos la cuenta
        // Multiplicar por 100 para quitarle los decimales y que el plugin haga su trabajo
        const totalProduct = ( 1 * Number(price) ) * 100;

        $('#list').append(`
            <tr id="${code}">
                <td>
                    <input type="hidden" name="productStock[]" value="${stock}">
                    <input type="hidden" name="productCode[]" value="${code}">${code}</td>
                <td>${name}</td>
                <td><input type="number" class="form-control form-control-sm productQuantity" name="productQuantity[]" value="1" min="1" max="${stock}" required data-type="sale" ></td>
                <td><input type="text" class="form-control form-control-sm price productPrice" name="productPrice[]" value="${price}" required maxlength="10" readonly></td>
                <td class="text-center"><input type="text" class="form-control form-control-sm price totalPriceProduct" value="${totalProduct}" readonly required></td>
                <td>
                    <div class="btn-list"> 
                        <button type="button" class="removeSaleProduct btn btn-sm btn-danger waves-effect d-block mx-auto" data-id="${code}">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `);

        totalSaleCount();

        $(".price").priceFormat({
            prefix: ''
        });

        // Mostrar botón
        $('#productsNext').slideDown();

    });

    //Llamar a totalCount cuando se seleccione el impuesto
    $(document).on('change', '#tax', function(){
        
        let subtotal = Number($('.subtotal').val().replace(/,/g, "").replace('.', ""));
        
        //Obtener el impuesto seleccionado
        const taxPercentage = $('#tax option:selected').attr('percentage');

        subtotal = subtotal*0.01;
        let tax = ((subtotal*(Number(taxPercentage)))/100);
        let total = subtotal + tax;
    
        subtotal = subtotal.toLocaleString('en', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        total = total.toLocaleString('en', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        tax = tax.toLocaleString('en', {minimumFractionDigits: 2, maximumFractionDigits: 2})

        //Insertar los valores en los input
        $('.subtotal').val(subtotal);
        $('.tax').val(tax);
        $('.total').val(total);

    });

    //Eliminar producto de la lista
    $(document).on('click', '.removeSaleProduct', function(){
        $(this).closest('tr').remove();
        
        if($("#list tr").length === 0) $('#productsNext').slideUp();
        
        totalSaleCount();
    });
    
});

//Calcular el total
const totalCount = () => {
    let total = 0;
    
    //Sumar todas las columnas de 'total'
    $('.totalPriceProduct').each(function(){
        let price = $(this).val();
        price = price.replace(/,/g, "");
        price = price.replace('.', "");
        total += Number(price);
    });

    //Multiplicar por 0.01 para poder agregar los decimales
    total = total*0.01;

    //Dar formato a los números ya que el plugin me da problemas con el cálculo de los porcentajes
    total = total.toLocaleString('en', {minimumFractionDigits: 2, maximumFractionDigits: 2});

    //Insertar los valores en los input
    $('.total').val(total);
    
}

const totalSaleCount = () => {
    let subtotal = 0;
    let tax = 0;
    let total = 0;
    
    //Obtener el impuesto seleccionado
    const taxPercentage = $('#tax option:selected').attr('percentage');
    
    //Sumar todas las columnas de 'total'
    $('.totalPriceProduct').each(function(){
        let price = $(this).val();
        price = price.replace(/,/g, "");
        price = price.replace('.', "");
        subtotal += Number(price);
    });


    //Multiplicar por 0.01 para poder agregar los decimales ya que le quitamos el formato para evitar errores de cálculo
    subtotal = subtotal*0.01;
    tax = ((subtotal*(Number(taxPercentage)))/100);
    total = subtotal + tax;
    
    //Dar formato a los números porque el cálculo de los porcentajes agrega muchos decimales
    // De esta manera solo lo redondeamos a dos decimales
    subtotal = subtotal.toLocaleString('en', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    total = total.toLocaleString('en', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    tax = tax.toLocaleString('en', {minimumFractionDigits: 2, maximumFractionDigits: 2})

    //Insertar los valores en los input
    $('.subtotal').val(subtotal);
    $('.tax').val(tax);
    $('.total').val(total);

}

