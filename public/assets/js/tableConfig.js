function tableConfig(ajaxUrl, selector){
    const origin = $(location).attr('origin');
    const path = origin + ajaxUrl;

    $(`${selector}`).DataTable({
        dom: '<"row"<"col-sm-12 col-md-4"l><"col-sm-12 col-md-4"<"d-flex align-items-center justify-content-center"B>><"col-sm-12 col-md-4"f>>tr<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        language: {
            sProcessing:     "Procesando...",
            sLengthMenu:     "Mostrar _MENU_ registros",
            sZeroRecords:    "No se encontraron resultados",
            sEmptyTable:     "Ningún dato disponible en esta tabla",
            sInfo:           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
            sInfoEmpty:      "Mostrando del 0 al 0 de un total de 0 registros",
            sInfoFiltered:   "(filtrado de un total de _MAX_ registros)",
            sInfoPostFix:    "",
            sSearch:         "Buscar:",
            sUrl:            "",
            sInfoThousands:  ",",
            sLoadingRecords: "Cargando...",
            oPaginate: {
            sFirst:    "Primero",
            sLast:     "Último",
            sNext:     "Siguiente",
            sPrevious: "Anterior"
            },
            oAria: {
                sSortAscending:  ": Activar para ordenar la columna de manera ascendente",
                sSortDescending: ": Activar para ordenar la columna de manera descendente"
            }
        },
        processing: true,
        serverSide: true,
        ajax: {
            url: path,
            data: function (d) {
                d.status = $('#status_db').val();
                d.range = $('#range').val();
                d.searchById = $('#searchById').val();
            }
        },
        search: 1000,
        order: [[0, "desc"]],
        columnDefs: [
            { targets: -1, orderable: false}, //target -1 means last column
        ]
    });

    $('#status_db').change(function(event) {
        $(`${selector}`).DataTable().ajax.reload();
    });
    $('#range').change(function(event) {
        $(`${selector}`).DataTable().ajax.reload();
    });
    $(document).on('click', '.btn-select-customer', function(){
        if(!$.fn.dataTable.isDataTable( '.datatable' )){
            tableConfig('/sales_per_customer', '.datatable');
        }
        $(`${selector}`).DataTable().ajax.reload();
    });
    $(document).on('click', '.btn-select-product', function(){
        if(!$.fn.dataTable.isDataTable( '.datatable' )){
            tableConfig('/sales_per_product', '.datatable');
        }
        $(`${selector}`).DataTable().ajax.reload();
    });
    $(document).on('click', '.btn-select-prov', function(){
        if(!$.fn.dataTable.isDataTable( '.datatable' )){
            
            tableConfig('/purchases_per_provider', '.datatable');
        }
        $(`${selector}`).DataTable().ajax.reload();
    });
}

function reloadTable(){
     $('.datatable').DataTable().ajax.reload();
}

