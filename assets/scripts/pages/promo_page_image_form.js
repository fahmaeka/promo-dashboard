$('#img_promo_page_image').prependTo($('#promo_page_image').parent());
$('#img_promo_page_thumbnail').prependTo($('#promo_page_thumbnail').parent());

/* $("#promo_page_thumbnail").change(function(){
	var reader = new FileReader();
	//Read the contents of Image File.
	reader.readAsDataURL($(this)[0].files[0]);
	reader.onload = function (e) {
		//Initiate the JavaScript Image object.
		var image = new Image();

		//Set the Base64 string return from FileReader as source.
		image.src = e.target.result;
			   
		//Validate the File Height and Width.
		image.onload = function () {
			var height = this.height;
			var width = this.width;
			if (height > 283 || width > 205) {
				alert("Width must be 283px and height must be 205px.");
				return false;
			}
			return true;
		};
	}
});

$("#promo_page_image").change(function(){
	var reader = new FileReader();
	//Read the contents of Image File.
	reader.readAsDataURL($(this)[0].files[0]);
	reader.onload = function (e) {
		//Initiate the JavaScript Image object.
		var image = new Image();

		//Set the Base64 string return from FileReader as source.
		image.src = e.target.result;
			   
		//Validate the File Height and Width.
		image.onload = function () {
			var height = this.height;
			var width = this.width;
			if (height > 930 || width > 264) {
				alert("Width must be 930px and height must be 264px.");
				return false;
			}
			return true;
		};
	}
});
 */

jQuery.validator.addMethod("cek_image",function(value) {
	if($("#promo_page_image")[0].files[0])
	{
		var reader = new FileReader();
		//Read the contents of Image File.
		reader.readAsDataURL($("#promo_page_image")[0].files[0]);
		reader.onload = function (e) {
			//Initiate the JavaScript Image object.
			var image = new Image();

			//Set the Base64 string return from FileReader as source.
			image.src = e.target.result;
				   
			//Validate the File Height and Width.
			image.onload = function () {
				var height = this.height;
				var width = this.width;
				if (height > 930 || width > 264) {
					return false;
				}
				else
				{
					return true;
				}
				
			};
		}
	}
	else
	{
		return true;
	}
	
}, "Width must be 930px and height must be 264px.");

jQuery.validator.addMethod("cek_thumbnail",function(value) {
	if($("#promo_page_thumbnail")[0].files[0])
	{
		var reader = new FileReader();
		//Read the contents of Image File.
		reader.readAsDataURL($("#promo_page_thumbnail")[0].files[0]);
		reader.onload = function (e) {
			//Initiate the JavaScript Image object.
			var image = new Image();

			//Set the Base64 string return from FileReader as source.
			image.src = e.target.result;
				   
			//Validate the File Height and Width.
			image.onload = function () {
				var height = this.height;
				var width = this.width;
				if (height > 283 || width > 205) {
					return false;
				}
				else
				{
					return true;
				}
				
			};
		}
	}
	else
	{
		return true;
	}
	
}, "Width must be 283px and height must be 205px.");

$('#form_promo_page').validate({
	errorElement: 'span',
	errorClass: 'help-block help-block-error',
	invalidHandler: function (event, validator) {
	},
	highlight: function (element) {
		$(element).closest('.form-group').addClass('has-error');
	},
	unhighlight: function (element) {
		$(element).closest('.form-group').removeClass('has-error');
	},
	success: function (label) {
		label.closest('.form-group').removeClass('has-error');
	},
	errorPlacement: function (error, element) {
		if (element.parent(".input-group").size() > 0) {
			error.insertAfter(element.parent(".input-group"));
		} else if (element.attr("data-error-container")) { 
			error.appendTo(element.attr("data-error-container"));
		} else if (element.parents('.radio-list').size() > 0) { 
			error.appendTo(element.parents('.radio-list').attr("data-error-container"));
		} else if (element.parents('.radio-inline').size() > 0) { 
			error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
		} else if (element.parents('.checkbox-list').size() > 0) {
			error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
		} else if (element.parents('.checkbox-inline').size() > 0) { 
			error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
		} else {
			error.insertAfter(element);
		}
	},
	submitHandler: function (form) {
		for (instance in CKEDITOR.instances) {
			CKEDITOR.instances[instance].updateElement();
		}
		$(form).ajaxSubmit({
			target: '#info-message'
		});
	}
});
//    $('.select2').select2();
//    $('.make-switch').bootstrapSwitch();
$('.datepicker').datepicker({
	format: "yyyy-mm-dd",
	orientation: "left",
	autoclose: true
});
$('.datetimepicker').datetimepicker({
	format: "yyyy-mm-dd hh:ii",
	orientation: "left",
	autoclose: true
});