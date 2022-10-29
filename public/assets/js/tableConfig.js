function tableConfig(ajaxUrl, selector){
    const origin = $(location).attr('origin');
    const path = origin + ajaxUrl;

    $(`${selector}`).DataTable({
        dom: 'status<"row"<"col-sm-12 col-md-4"l><"col-sm-12 col-md-4"<"d-flex align-items-center justify-content-center"B>><"col-sm-12 col-md-4"f>>tr<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        buttons: [
            {
                //colvis
                extend: 'colvis',
                text: '<i class="fas fa-columns"></i>',
                title: 'Mostrar columnas',
                exportOptions: {
                    columns: [0, 1]
                },
                className: 'btn btn-info btn-sm'
            },
            {
                //copy
                extend: 'copy',
                text: '<i class="fas fa-copy"></i>',
                title: 'Copiar',
                className: 'btn btn-info btn-sm'
            },
            {
                //pdf
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i>',
                title: 'PDF',
                className: 'btn btn-info btn-sm'
            },
            {
                //excel
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i>',
                title: 'Excel',
                className: 'btn btn-info btn-sm'
            },
        ],
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
                d.status = $('#status').val();
            }
        },
        search: 1000,
        order: [[0, "desc"]],
        columnDefs: [
            { targets: -1, orderable: false}, //target -1 means last column
        ]
    });

    $('#status').change(function(event) {
        $(`${selector}`).DataTable().ajax.reload();
    });
}

function reloadTable(){
     $('.datatable').DataTable().ajax.reload();
}

