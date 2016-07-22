var table = $('#table_grid').DataTable({
	"ajax": current_url + '/get_json',
	"columns": [
		{"data":"promo_name"},
		{"data":"promo_created_date"},
		{"data":"customer_firstname"},
		{"data":"promo_status"},
		{"data":"actions"}
	],
	"columnDefs": [ { orderable: false, targets: [0,4] } ],
	"order": [[ 1, "DESC" ]],
    "autoWidth": false
});
table.columns().every( function() {
	var that = this;
	$( 'input', this.footer() ).on( 'keyup change', function () {
		that.search( this.value );
	});
	$( 'select', this.footer() ).on( 'change', function () {
		that.search( this.value );
	});
});
$('#search_datatable').click(function () {  
    table.draw();
});