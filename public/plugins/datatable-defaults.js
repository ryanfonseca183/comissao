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
$(function(){
    const dataTable = $(".table__app").DataTable();
})
