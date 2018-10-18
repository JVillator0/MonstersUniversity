function initTabla(id){
    initDatatable(id);
    MoverAbajoInputBusqueda();
    PantallaCambio();
};

function initDatatable(id) {
    var table = $("#"+id).DataTable({
        language: {
            "decimal": "",
            "emptyTable": "No hay datos disponibles",
            "info": "Mostrando _START_ hasta _END_ de _TOTAL_ registros",
            "infoEmpty": "Mostrando 0 hasta 0 de 0 entries",
            "infoFiltered": "(filtrando de _MAX_ registros totales)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ registros",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "No se encontraron coincidencias",
            "paginate": {
                "first": "Primera",
                "last": "Ultima",
                "next": '<span class="fa fa-chevron-right"></span>',
                "previous": '<span class="fa fa-chevron-left"></span>'
            },
            "aria": {
                "sortAscending": ": activar para ordenar de forma ascendente",
                "sortDescending": ": activar para ordenar de forma descendente"
            }
        },
        responsive: true,
        ordering: true,
        retrieve: true,
    });
}

function PantallaCambio() {
    $(window).resize(function () {
        if ($(window).width() <= 750) {
            $(".dataTables_filter").addClass('pull-left');
        } else {
            $(".dataTables_filter").removeClass('pull-left');
        }
    });
}

function MoverAbajoInputBusqueda() {
    if ($(window).width() <= 750) {
        $(".dataTables_filter").addClass('pull-left');
    } else {
        $(".dataTables_filter").removeClass('pull-left');
    }
}