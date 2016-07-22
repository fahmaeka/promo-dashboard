$('#promo_code_time').daterangepicker({
    timePicker: true,
    timePicker24Hour: true,
    timePickerIncrement: 5,
    minDate: "today",
    locale: {
        format: 'YYYY/MM/DD HH:mm'
    }
});

$(document).ready(function(){
    $('#promo_code_prefix_input').blur(checkAvailability);
    $('#promo_code_repeat').blur(checkRepeat);
});

function confirm_send() {
	var prefix = $('#promo_code_prefix_input').val();
    var repeated = $('#promo_code_repeat').val();
  	//var promodate : $("#promo_code_time").val(),

  	return confirm("Sure this prefix code = '" + prefix + "' , repeated = '" + repeated + "'");
}

function checkAvailability(){
    var prefix = $('#promo_code_prefix_input').val();
    var repeated = $('#promo_code_repeat').val();
    
    if(prefix.length > 4){      
        alert("There are code Prefix more than 4 character.");  
        this.value = '';     
    }
} 

function checkRepeat(){
    var prefix = $('#promo_code_prefix_input').val();
    var repeated = $('#promo_code_repeat').val();
    
    if(repeated > 10000){      
        alert("There are Generate Repeated more than 10000x.");  
    }
    else if(repeated == 0){
        alert("There are Generate Repeated 0x. Insert Generate Value");
        this.value = '1';
    }
} 