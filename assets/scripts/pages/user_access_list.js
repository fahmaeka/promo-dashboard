var table = $('#table_grid').DataTable({
	"ajax": current_url + '/get_json',
	"columns": [
		{"data":"customer_type_id"},
		{"data":"customer_type_name"},
		{"data":"actions"}
	],
	"columnDefs": [ { orderable: false, targets: [0,2] } ],
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