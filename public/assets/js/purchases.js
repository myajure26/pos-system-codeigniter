$(document).ready(function(){

    $(document).on('click', '.btn-select-provider', function(){
        $('#providerInput').val($(this).closest('tr').find('td:eq(3)').text());
        $('#provider, #viewProvider').val($(this).closest('tr').find('td:eq(1)').text());
        $('#searchProviderModal').modal('hide');
    });

    $(document).on('click', '.btn-select-product', function(){
        const id = $(this).closest('tr').find('td:eq(1)').text();
        const code = $(this).closest('tr').find('td:eq(2)').text();
        const name = $(this).closest('tr').find('td:eq(3)').text();
        let totalProduct = 0.00;

        $('#list').append(`
            <tr id="${id}">
                <td><input type="hidden" name="productId[]" value="${id}">${id}</td>
                <td>${code}</td>
                <td>${name}</td>
                <td><input type="number" class="form-control form-control-sm productQuantity" name="productQuantity[]" value="1" required></td>
                <td><input type="text" class="form-control form-control-sm price productPrice" name="productPrice[]" value="0.00" required maxlength="10"></td>
                <td class="text-center"><input type="text" class="form-control form-control-sm price totalPriceProduct" value="${totalProduct}" readonly required></td>
                <td>
                    <div class="btn-list"> 
                        <button type="button" class="removeProduct btn btn-sm btn-danger waves-effect d-block mx-auto" data-id="${id}">
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
    
    //Calcular al ingresar la cantidad del producto
    $(document).on('input', '.productPrice, .productQuantity', function(){
        let quantity = $(this).closest('tr').find('.productQuantity').val();
        let price = $(this).closest('tr').find('.productPrice').val();

        //Quitar las comas y puntos
        price = price.replace(/,/g, "");
        price = price.replace('.', "");
        
        //Convertir a números
        price = Number(price);
        quantity = Number(quantity);
        
        //Calcular
        const count = quantity * price;
        
        //Insertar
        $(this).closest('tr').find('td:eq(5) input').val(count);
        
        //Dar formato
        $(".price").priceFormat({
            prefix: ''
        });
        
        //Llamar la función totalCount
        totalCount();
    });
    
    //Llamar a totalCount cuando se seleccione el impuesto
    $(document).on('change', '#tax', function(){
        totalCount();
    });

    //Eliminar producto de la lista
    $(document).on('click', '.removeProduct', function(){
        $(this).closest('tr').remove();
        totalCount();
    });
});

//Calcular el subtotal, impuesto y total
const totalCount = () => {
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

    //Multiplicar por 0.01 para poder agregar los decimales
    subtotal = subtotal*0.01;
    tax = ((subtotal*(Number(taxPercentage)))/100);
    total = subtotal + tax;

    //Dar formato a los números ya que el plugin me da problemas con el cálculo de los porcentajes
    subtotal = subtotal.toLocaleString('en', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    total = total.toLocaleString('en', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    tax = tax.toLocaleString('en', {minimumFractionDigits: 2, maximumFractionDigits: 2})

    //Insertar los valores en los input
    $('.subtotal').val(subtotal);
    $('.tax').val(tax);
    $('.total').val(total);
    
}

