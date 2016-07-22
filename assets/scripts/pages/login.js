$('.login-form').validate({
	errorElement: 'span', //default input error message container
	errorClass: 'help-block', // default input error message class
	focusInvalid: false, // do not focus the last invalid input
	rules: {
		login_username: {
			required: true
		},
		login_password: {
			required: true
		}
	},
	messages: {
		login_username: {
			required: "Username is required."
		},
		login_password: {
			required: "Password is required."
		}
	},
	invalidHandler: function (event, validator) { //display error alert on form submit   
		$('.alert-danger', $('.login-form')).show();
	},
	highlight: function (element) { // hightlight error inputs
		$(element).closest('.form-group').addClass('has-error'); // set error class to the control group
	},
	success: function (label) {
		label.closest('.form-group').removeClass('has-error');
		label.remove();
	},
	errorPlacement: function (error, element) {
		error.insertAfter(element.closest('.input-icon'));
	},
	submitHandler: function (form) {
		$(form).ajaxSubmit({
			target: '#message'
		});
	}
});

$('.login-form input').keypress(function (e) {
	if (e.which == 13) {
		if ($('.login-form').validate().form()) {
			$('.login-form').submit(); //form validation success, call ajax form submit
		}
		return false;
	}
});