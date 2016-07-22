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
    $('#promo_code_max_count').blur(checkValue);
});
function checkValue(){
    var repeated = $('#promo_code_max_count').val();
    
    if(repeated == "0"){
        alert("There are Generate Repeated 0x. Insert Generate Value");
        this.value = '1';
    }
}

var code = $('#promo_code_value').val();
if(code = "" || code.length > 0 ){      
   	$("#promo_code_value").attr("readonly", "readonly");  
 }else{
 	$("#promo_code_value").attr("");
 }

var count = $('#promo_code_count').val();
if(count = "" || count > 0 || count == "0" ){      
   	$("#promo_code_count").attr("readonly", "readonly");  
 }else{
 	$("#promo_code_count").attr("");
 }

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function ValidateAlpha(evt)
    {
        var keyCode = (evt.which) ? evt.which : evt.keyCode
        if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 122))
        return false;
        return true;
    }