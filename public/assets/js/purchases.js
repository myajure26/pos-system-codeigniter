$(document).ready(function(){

    $(document).on('click', '.btn-select-provider', function(){
        $('#providerInput').val($(this).closest('tr').find('td:eq(3)').text());
        $('#provider').val($(this).closest('tr').find('td:eq(1)').text());
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
                <td><input type="hidden" name="productCode[]" value="${code}">${code}</td>
                <td><input type="hidden" name="productName[]" value="${name}">${name}</td>
                <td><input type="number" class="form-control form-control-sm productQuantity" name="productQuantity[]" value="1"></td>
                <td><input type="text" class="form-control form-control-sm price productPrice" name="productPrice[]" value="0.00"></td>
                <td class="text-center"><input type="text" class="form-control form-control-sm price" value="${totalProduct}" readonly></td>
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

    let total = "";

    $(document).on('input', '.productQuantity', function(){
        const quantity = $(this).val();
        let price = $(this).closest('tr').find('.productPrice').val();

        price = price.replace(',','');
        price = price.replace('.','');

        const count = Number(quantity)*Number(price);

        $(this).closest('tr').find('td:eq(5) input').val(count);
        $(".price").priceFormat({
            prefix: ''
        });
    });

    $(document).on('input', '.productPrice', function(){
        let price = $(this).val();
        const quantity = $(this).closest('tr').find('.productQuantity').val();

        price = price.replace(',','');
        price = price.replace('.','');

        const count = Number(quantity)*Number(price);

        $(this).closest('tr').find('td:eq(5) input').val(count);
        $(".price").priceFormat({
            prefix: ''
        });
    });

    $(document).on('click', '.removeProduct', function(){
        $(this).closest('tr').remove();
    });

    

});