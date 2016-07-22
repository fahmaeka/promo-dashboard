function getURLparameter(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

var table = $('#table_grid').DataTable({
	"ajax": current_url + '/get_json?promo=' + getURLparameter('promo'),
	"columns": [
		{"data":"promo_code_id"},
		{"data":"promo_name", "name":"promo_code.promo_id"},
		{"data":"promo_code_value"},
		{"data":"promo_code_count"},
		{"data":"promo_code_max_count"},
		{"data":"promo_code_created_date"},
		{"data":"created_by", "name":"c.customer_firstname"},
		{"data":"promo_code_updated_date"},
		{"data":"updated_by", "name":"u.customer_firstname"},
		{"data":"actions"}
	],
	"columnDefs": [ { orderable: false, targets: [0,9] } ],
	"order": [[ 0, "DESC" ]],
    "autoWidth": false
});

function confirmDialog() {
    return confirm("Are you sure you want to delete this record?")
}

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