$.extend($.fn.dataTableExt.oStdClasses, {
    "sWrapper": $.fn.dataTableExt.oStdClasses.sWrapper + " dataTables_extended_wrapper",
    "sFilterInput": "form-control input-small input-sm input-inline",
    "sLengthSelect": "form-control input-xsmall input-sm input-inline"
});
$.extend($.fn.dataTable.defaults, {
    "processing": true,
    "serverSide": true,
    "lengthMenu": [
        [10, 20, 50, 100, 150, -1],
        [10, 20, 50, 100, 150, "All"]
    ],
    "pageLength": 10,
//    "bStateSave": true,
    "dom": "r<'table-scrollable't><'row'<'col-md-7 col-sm-12'li><'col-md-5 col-sm-12'p>>",
    "language": {
        "metronicGroupActions": "_TOTAL_ records selected:  ",
        "metronicAjaxRequestGeneralError": "Could not complete request. Please check your internet connection",
        "lengthMenu": "View _MENU_ records",
        "info": "<span class='seperator'>|</span>Total _TOTAL_ records",
        "infoEmpty": "<span class='seperator'>|</span>No records found to show",
        "emptyTable": "No records found to show",
        "zeroRecords": "No matching records found",
        "paginate": {
            "previous": "Prev",
            "next": "Next",
            "last": "Last",
            "first": "First",
            "page": "Page",
            "pageOf": "of"
        }
    },
    "pagingType": "bootstrap_full_number",
//    "drawCallback": function(oSettings) {
//        $('input[type="checkbox"]').uniform();
//    }
});
$('body').on('click', 'input[name="checkAll"]', function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
    $.uniform.update( $('input:checkbox') );
});
