function getBaseUrl() {
    var l = window.location;
    var base_url = l.protocol + "//" + l.host + "/" + l.pathname.split('/')[1];
    return base_url;
}

$(document).ready(function(){
	jQuery.validator.addMethod("check_confirm_password",function(value) {
        if($("#new_password").val() != $("#confirm_password").val())
		{
			return false;
		}
		else
		{
			return true;
		}
    }, "Confirm Password must be match with the New Password.");
	
	$('#form_change_password').validate({
            errorElement: 'span', 
            errorClass: 'help-block', 
            focusInvalid: false, 
            ignore: "",
            rules: {
				old_password : {
					required : true,
					remote: {
						url: base_url + "profile/check_password/",
						type: "post",
						data:{},
						error: function(data){
							location.href = getBaseUrl()+"/login"
						}
                    }
				},
                new_password :{
                    required : true,
                    check_confirm_password : true
                },
				confirm_password :{
                    required : true,
                    check_confirm_password : true
                }
            },
            messages: { 
				old_password : {
					remote : "Wrong Password"
				}
            },
            invalidHandler: function (event, validator) { //display error alert on form submit   
            },
            highlight: function (element) { // hightlight error inputs
               $(element)
                     .closest('.form-group').addClass('has-error'); // set error class to the control group
             },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },
            submitHandler: function (form) {
                /* for (instance in CKEDITOR.instances) {
					CKEDITOR.instances[instance].updateElement();
				}
				$(form).ajaxSubmit({
					target: '#info-message'
				}); */
				form.submit();
            }
    });
});