var BookingForm = function () {

return {
        init: function ( city) {
            
            $( "#from0" ).autocomplete({
                    source: city,
                    minLength: 3,
                    select: function( event, ui ) {
                        $("#from0").val(ui.item.label);
                        $("#from_code0").val(ui.item.id);
                    }
            });
            $( "#to0" ).autocomplete({
                    source: city,
                    minLength: 3,
                    select: function( event, ui ) {
                        $("#to0").val(ui.item.label);
                        $("#to_code0").val(ui.item.id);
                    }
            });
			$( "#from1" ).autocomplete({
                    source: city,
                    minLength: 3,
                    select: function( event, ui ) {
                        $("#from1").val(ui.item.label);
                        $("#from_code1").val(ui.item.id);
                    }
            });
            $( "#to1" ).autocomplete({
                    source: city,
                    minLength: 3,
                    select: function( event, ui ) {
                        $("#to1").val(ui.item.label);
                        $("#to_code1").val(ui.item.id);
                    }
            });
			$( "#from2" ).autocomplete({
                    source: city,
                    minLength: 3,
                    select: function( event, ui ) {
                        $("#from2").val(ui.item.label);
                        $("#from_code2").val(ui.item.id);
                    }
            });
            $( "#to2" ).autocomplete({
                    source: city,
                    minLength: 3,
                    select: function( event, ui ) {
                        $("#to2").val(ui.item.label);
                        $("#to_code2").val(ui.item.id);
                    }
            });
			
			$( "#ret_from0" ).autocomplete({
                    source: city,
                    minLength: 3,
                    select: function( event, ui ) {
                        $("#ret_from0").val(ui.item.label);
                        $("#ret_from_code0").val(ui.item.id);
                    }
            });
            $( "#ret_to0" ).autocomplete({
                    source: city,
                    minLength: 3,
                    select: function( event, ui ) {
                        $("#ret_to0").val(ui.item.label);
                        $("#ret_to_code0").val(ui.item.id);
                    }
            });
			$( "#ret_from1" ).autocomplete({
                    source: city,
                    minLength: 3,
                    select: function( event, ui ) {
                        $("#ret_from1").val(ui.item.label);
                        $("#ret_from_code1").val(ui.item.id);
                    }
            });
            $( "#ret_to1" ).autocomplete({
                    source: city,
                    minLength: 3,
                    select: function( event, ui ) {
                        $("#ret_to1").val(ui.item.label);
                        $("#ret_to_code1").val(ui.item.id);
                    }
            });
			$( "#ret_from2" ).autocomplete({
                    source: city,
                    minLength: 3,
                    select: function( event, ui ) {
                        $("#ret_from2").val(ui.item.label);
                        $("#ret_from_code2").val(ui.item.id);
                    }
            });
            $( "#ret_to2" ).autocomplete({
                    source: city,
                    minLength: 3,
                    select: function( event, ui ) {
                        $("#ret_to2").val(ui.item.label);
                        $("#ret_to_code2").val(ui.item.id);
                    }
            });
            
			//date of birth picker
			$('.adult_dob_picker').datepicker({
					monthNames: [ "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember" ],
					dayNames: [ "Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu" ],
					dayNamesMin: [ "M", "S", "S", "R", "K", "J", "S" ],
					format: 'yyyy-mm-dd',
					inline: true,
					autoclose: true,
					endDate: "-12y"
				});
			$('.child_dob_picker').datepicker({
					monthNames: [ "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember" ],
					dayNames: [ "Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu" ],
					dayNamesMin: [ "M", "S", "S", "R", "K", "J", "S" ],
					format: 'yyyy-mm-dd',
					inline: true,
					autoclose: true,
					startDate: "-12y",
					endDate:"-2y"
				});
			$('.infant_dob_picker').datepicker({
					monthNames: [ "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember" ],
					dayNames: [ "Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu" ],
					dayNamesMin: [ "M", "S", "S", "R", "K", "J", "S" ],
					format: 'yyyy-mm-dd',
					inline: true,
					autoclose: true,
					startDate: "-2y",
					endDate:"-1d"
				});
			
			// passport expire picker
			$('.passport_expire_picker').datepicker({
					monthNames: [ "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember" ],
					dayNames: [ "Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu" ],
					dayNamesMin: [ "M", "S", "S", "R", "K", "J", "S" ],
					format: 'yyyy-mm-dd',
					inline: true,
					autoclose: true,
					startDate: "+6m",
					endDate:"+5y"
				});
				
			$('.id_created_picker').datepicker({
					monthNames: [ "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember" ],
					dayNames: [ "Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu" ],
					dayNamesMin: [ "M", "S", "S", "R", "K", "J", "S" ],
					format: 'yyyy-mm-dd',
					inline: true,
					autoclose: true,
					endDate:"-1d"
				});
	}
   };
}();