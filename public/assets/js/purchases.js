$(document).ready(function(){

    $(document).on('click', '.btn-select-provider', function(){
        $('#providerInput').val($(this).closest('tr').find('td:eq(2)').text());
        $('#provider, #viewProvider').val($(this).closest('tr').find('td:eq(1)').text());
        $('#searchProviderModal').modal('hide');
    });

    $(document).on('click', '.btn-select-product', function(){
        const code = $(this).closest('tr').find('td:eq(1)').text();
        const name = $(this).closest('tr').find('td:eq(2)').text();
        let totalProduct = 0.00;

        $('#list').append(`
            <tr id="${code}">
                <td><input type="hidden" name="productCode[]" value="${code}">${code}</td>
                <td>${name}</td>
                <td><input type="number" class="form-control form-control-sm productQuantity" name="productQuantity[]" value="1" required></td>
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
        $(this).closest('tr').find('.totalPriceProduct').val(count);
        
        //Dar formato
        $(".price").priceFormat({
            prefix: ''
        });
        
        //Llamar la función totalCount
        totalCount();
    });
    
    //Eliminar producto de la lista
    $(document).on('click', '.removeProduct', function(){
        $(this).closest('tr').remove();
        totalCount();
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

