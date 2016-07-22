$(".only_number").keydown(function (e) {
	// Allow: backspace, delete, tab, escape, enter and .
	if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
		 // Allow: Ctrl+A
		(e.keyCode == 65 && e.ctrlKey === true) || 
		 // Allow: home, end, left, right
		(e.keyCode >= 35 && e.keyCode <= 39)) {
			 // let it happen, don't do anything
			 return;
	}
	// Ensure that it is a number and stop the keypress
	if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
		e.preventDefault();
	}
});

$(".without_number").keydown(function (e) { //prevent number to be entered
	// Allow: backspace, delete, tab, escape, enter and .
	if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
		 // Allow: Ctrl+A
		(e.keyCode == 65 && e.ctrlKey === true) || 
		 // Allow: home, end, left, right
		(e.keyCode >= 35 && e.keyCode <= 39)) {
			 // let it happen, don't do anything
			 return;
	}
	// validate number
	if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
		
	}
	else
	{
        e.preventDefault();
    }
});

$(".only_letter").keydown(function (e) { //prevent number to be entered
    var regex = new RegExp("^[a-zA-Z \b]+$");
    var key = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (!regex.test(key)) {
        e.preventDefault();
        return false;
    }
});

$(".formatted_number").on('keyup', function(){
    var n = parseInt($(this).val().replace(/\D/g,''),10);
    if($(this).val() != '')
    {
        $(this).val(n.toLocaleString());
    }
});

$(".timepicker").datetimepicker({
    format: 'yyyy-mm-dd hh:ii',
    autoclose: true
});

$.validator.addMethod('letters', function(value) {
	if(value == '') 
	{  
		return true;  
	}  
	else
	{
		return value.match(/^[- a-zA-Z]+$/);
	}        
});

$.validator.addMethod('alphanumeric', function(value) {
	if(value == '') 
	{  
		return true;  
	}  
	else
	{
		return value.match(/^[- a-zA-Z0-9]+$/);
	}        
});


function format_number(num)
{
    num = num.toString();
    var splitter = num.split('.');
    var non_decimal = splitter[0];
    var decimal = '';
    if(splitter[1])
    {
        decimal = splitter[1];
    }
    var j = 0;
    var new_string = '';
    var num_length = non_decimal.length - 1;

    for(var i = num_length; i>= 0; i--)
    {
        if(non_decimal[i])
        {
            if(j == 3)
            {
                new_string = non_decimal[i] + '.' + new_string;
                j = 0;
            }
            else
            {
                new_string =  non_decimal[i] + new_string;
            }
            j++;
        }
    }
    if(decimal != '')
    {
        new_string = new_string + ',' + decimal;
    }
    return new_string;
}