typeof $.fn.dataTable != "undefined" && $.extend(true, $.fn.dataTable.defaults, {
    processing: false,
    serverSide: false,
    language: {
        url: "/plugins/datatable-pt-br.json",
    },
    responsive:true,
    ordering:true,
    columnDefs: [
        {targets:  0, responsivePriority: 1},
        {targets: -1, responsivePriority: 2, orderable: false}
    ]
})
typeof $.fn.dataTable != "undefined" && $.fn.dataTable.Api.register( 'sum()', function ( ) {
    return this.flatten().reduce( function ( a, b ) {
        var x = parseFloat(a) || 0;
        var y = parseFloat($(b).attr('data-order')) || 0;
        return x + y
    }, 0 );
} );

$(function(){
    window.dataTable = $(".table__app").DataTable();
})
