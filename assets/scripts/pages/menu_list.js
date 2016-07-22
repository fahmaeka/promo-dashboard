var table = $('#table_grid').DataTable({
	"ajax": current_url + '/get_json',
	"columns": [
		{"data":"menu_id", "name":"menu.menu_id"},
		{"data":"parent_name", "name":"p.menu_name"},
		{"data":"menu_name", "name":"menu.menu_name"},
		{"data":"menu_slug", "name":"menu.menu_slug"},
		{"data":"menu_icon", "name":"menu.menu_icon"},
		{"data":"menu_precedence", "name":"menu.menu_precedence"},
		{"data":"menu_status", "name":"menu.menu_status"},
		{"data":"actions"}
	],
	"columnDefs": [ { orderable: false, targets: [0,7] } ],
	"order": [[ 0, "DESC" ]]
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