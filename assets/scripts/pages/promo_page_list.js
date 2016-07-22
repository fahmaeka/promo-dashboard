var table = $('#table_grid').DataTable({
	"ajax": current_url + '/get_json',
	"columns": [
		{"data":"promo_page_id"},
		{"data":"promo_page_name"},
		{"data":"promo_page_thumbnail"},
		{"data":"promo_page_start_date"},
		{"data":"promo_page_end_date"},
		{"data":"customer_username"},
		{"data":"promo_page_status"},
		{"data":"actions"}
	],
	"columnDefs": [
        { orderable: false, targets: [0,7] }
    ],
    "autoWidth": false,
	"order": [[ 0, "asc" ]]
});
table.columns().every( function() {
	var that = this;
	$( 'input', this.footer() ).on( 'keyup change', function () {console.log(this.value);
		that.search( this.value );
	});
	$( 'select', this.footer() ).on( 'change', function () {
		that.search( this.value );
	});
});
$('#search_datatable').click(function () {  
    table.draw();
});