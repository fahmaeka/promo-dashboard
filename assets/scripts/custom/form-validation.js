var FormValidation = function () {


    var handleValidationEditDetailHotelMap = function() 
    {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
            
            var form3 = $('#edit_detail_hotel_map');
            
            //IMPORTANT: update CKEDITOR textarea with actual content before submit
            form3.on('submit', function() {
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            })
            
            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                
                rules: {
                    hotel_name :{
                        required:true,
                        remote: 
                        {	
                            
                            url: base_url+"hotel_manage_mapping/hotel_mapping/check_available_hotel_detail",
                            type: "post",
                            data: {
                              nama_hotel : $( ".hotel_name" ).attr("value")
                            },
                            complete: function(done) {
                                //console.log(done.responseText);
                            }
                        }
                    },
                    
                    id_supplier : {
                        required : true,
                        number: true
                    },
                    
                    hotel_mapping_code : {
                        required : true
                    }
                },

                messages: { // custom messages for radio buttons and checkboxes
                    hotel_name : {
                        remote: "Hotel Name not exist in database"
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
                    form.submit();
                    
                }

            });
            
             //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
            $('.select2me', form3).change(function () {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
            
            
    }

    
    
    
    var handleValidationAddDetailHotelMap = function() 
    {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
            
            var form3 = $('#add_detail_hotel_map');
            
            //IMPORTANT: update CKEDITOR textarea with actual content before submit
            form3.on('submit', function() {
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            })
            
            jQuery.validator.addMethod("cek_same_hotel_name",function(value) {
                if($(".hotel_name_check").val() != $(".hotel_name").val())
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }, "Hotel Name not exist in database");
            
            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                
                rules: {
                    hotel_name :{
                        required:true,
                        cek_same_hotel_name : true
                        
                    },
                    
                    id_supplier : {
                        required : true,
                        number: true
                    },
                    
                    hotel_mapping_code : {
                        required : true
                    }
                    
                },

                messages: { // custom messages for radio buttons and checkboxes
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
                    form.submit();
                    
                }

            });
            
             //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
            $('.select2me', form3).change(function () {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
            
            
    }




    var handleValidationAddHotelImage = function() 
    {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
            
            var form3 = $('#add_hotel_image');
            
            //IMPORTANT: update CKEDITOR textarea with actual content before submit
            form3.on('submit', function() {
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            })
            
             jQuery.validator.addMethod("cek_same_hotel_name",function(value) {
                if($(".hotel_name_check").val() != $(".hotel_name").val())
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }, "Hotel Name not exist in database");
            
            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                
                rules: {
                    hotel_name :{
                        required:true,
                        cek_same_hotel_name : false
                    },
                    
                    caption : {
                        required : true
                    },
                    
                    height : {
                        required : true,
                        number : true
                    },

                    width : {
                        required : true,
                        number : true
                    },
                    
                    byte_size : {
                        number : true
                    }
                    

                },

                messages: { // custom messages for radio buttons and checkboxes
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
                    form.submit();
                    
                }

            });
            
             //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
            $('.select2me', form3).change(function () {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
            
            
    }
    
    
    
    
    
    
    
    
    var handleValidationEditHotelImage = function() 
    {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
            
            var form3 = $('#edit_hotel_master_image');
            
            //IMPORTANT: update CKEDITOR textarea with actual content before submit
            form3.on('submit', function() {
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            })
            
            jQuery.validator.addMethod("cek_same_hotel_name",function(value) {
                if($(".hotel_name_check").val() != $(".hotel_name").val())
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }, "Hotel Name not exist in database");
            
            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                
                rules: {
                    hotel_name :{
                        required:true,
                        cek_same_hotel_name : true
                    },
                    
                    caption : {
                        required : true
                    },
                    
                    height : {
                        required : true,
                        number : true
                    },

                    width : {
                        required : true,
                        number : true
                    },
                    
                    
                    byte_size : {
                        number : true
                    }
                    

                },

                messages: { // custom messages for radio buttons and checkboxes
                    
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
                    form.submit();
                    
                }

            });
            
             //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
            $('.select2me', form3).change(function () {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
            
            
    }
    
    
    
    
    var handleValidationAddRegionHotel = function() 
    {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
            
            var form3 = $('#add_region_hotel');
            
            //IMPORTANT: update CKEDITOR textarea with actual content before submit
            form3.on('submit', function() {
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            })
            
            
            jQuery.validator.addMethod("cek_same_parent_region",function(value) {
                if($("#parent_name").val() != $("#region_parent_hid").val())
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }, "Region Name not exist in database");
            
            
            
            // region_name, region_name_long, region_parent, latitude, longitude, 
            
            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                
                rules: {
                    region_name :{
                        required:true
                    },
                    
                    region_name_long : {
                        required : true
                    },
                    
                    region_parent : {
                        cek_same_parent_region : true
                    }
                    
                    
                },

                messages: { // custom messages for radio buttons and checkboxes
                    
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
                    form.submit();
                    
                }

            });
            
             //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
            $('.select2me', form3).change(function () {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
            
            
    }
    
    
    
    
    
    
    var handleValidationEditRegionHotel = function() 
    {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
            
            var form3 = $('#edit_hotel_region');
            
            //IMPORTANT: update CKEDITOR textarea with actual content before submit
            form3.on('submit', function() {
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            })
            
            
            jQuery.validator.addMethod("cek_same_parent_region",function(value) {
                if($("#parent_name").val() != $("#region_parent_hid").val())
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }, "Region Name not exist in database");
            
            
            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                
                rules: {
                    region_name :{
                        required:true
                    },
                    
                    region_name_long : {
                        required : true
                    },
                    
                    region_parent : {
                        cek_same_parent_region : true
                    }
                    
                },

                messages: { // custom messages for radio buttons and checkboxes
                    
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
                    form.submit();
                    
                }

            });
            
             //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
            $('.select2me', form3).change(function () {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
            
            
    }
    
    
    
    
    
    var handleValidationAddHotelMaster = function() 
    {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
            
            var form3 = $('#add_hotel_master');
            
            //IMPORTANT: update CKEDITOR textarea with actual content before submit
            form3.on('submit', function() {
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            })
            
            
            jQuery.validator.addMethod("cek_same_country_name",function(value) {
                if($(".hotel_country_check").val() != $(".hotel_country").val())
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }, "Country not exist");
            
            jQuery.validator.addMethod("cek_same_city_name",function(value) {
                if($(".hotel_city_check").val() != $(".hotel_city").val())
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }, "City not exist");
            
            
            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                
                // 	hotel_name, hotel_star, hotel_address_1, hotel_address_2, 
                //	postal_code, hotel_city, hotel_country, currency_code, latitude, longitude, 
                //	check_in, check_out

                
                rules: {
                    hotel_name :{
                        required : true
                    },
                    
                    
                    hotel_address_1 : {
                        required : true
                    },
                    
                    postal_code : {
                        required : true,
                        number : true
                    },
                    
                    hotel_city : {
                        required : true,
                        cek_same_city_name : true
                    },
                    
                    hotel_country : {
                        required : true,
                        cek_same_country_name : true
                    },
                    
                    hotel_phone : {
                        required : true,
                    },

                    hotel_email : {
                        required : true,
                    },
                    
                    latitude : {
                        required : true
                    },
                    
                    longitude : {
                        required : true
                    }
                    
                    
                },

                messages: { // custom messages for radio buttons and checkboxes
                    
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
                    form.submit();
                    
                }

            });
            
             //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
            $('.select2me', form3).change(function () {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
            
            
    }
    
    
    
    
    
    
    
    
    var handleValidationEditHotelMaster = function() 
    {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
            
            var form3 = $('#edit_hotel_master');
            
            //IMPORTANT: update CKEDITOR textarea with actual content before submit
            form3.on('submit', function() {
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            })
            
            jQuery.validator.addMethod("cek_same_country_name",function(value) {
                if($(".hotel_country_check").val() != $(".hotel_country").val())
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }, "Country not exist");
            
            jQuery.validator.addMethod("cek_same_city_name",function(value) {
                if($(".hotel_city_check").val() != $(".hotel_city").val())
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }, "City not exist");
            
            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                
                // 	hotel_name, hotel_star, hotel_address_1, hotel_address_2, 
                //	postal_code, hotel_city, hotel_country, currency_code, latitude, longitude, 
                //	check_in, check_out

                
                rules: {
                    hotel_name :{
                        required : true
                    },
                    
                    
                    hotel_address_1 : {
                        required : true
                    },
                    
                    postal_code : {
                        required : true,
                        number : true
                    },
                    
                    hotel_city : {
                        required : true,
                        cek_same_city_name : true
                    },
                    
                    hotel_country : {
                        required : true,
                        cek_same_country_name : true
                    },
                    
                    latitude : {
                        required : true
                    },
                    
                    longitude : {
                        required : true
                    },
                    
                    hotel_phone : {
                        required : true,
                    },

                    hotel_email : {
                        required : true,
                    }
                    
                },

                messages: { // custom messages for radio buttons and checkboxes
                    
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
                    form.submit();
                    
                }

            });
            
             //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
            $('.select2me', form3).change(function () {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
            
            
    }
    
    
    
    
    
    var handleValidationAddHotelFacilities = function() 
    {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
            
            var form3 = $('#add_hotel_facilities');
            
            //IMPORTANT: update CKEDITOR textarea with actual content before submit
            form3.on('submit', function() {
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            })
            
            
            jQuery.validator.addMethod("cek_same_hotel_name",function(value) {
                if($(".hotel_name_check").val() != $(".hotel_name").val())
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }, "Hotel Name not exist in database");
            
            
            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                
                rules: {
                    hotel_name :{
                        required : true,
                        cek_same_hotel_name : true
                    }
                    
                },

                messages: { // custom messages for radio buttons and checkboxes
                    
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
                    form.submit();
                    
                }

            });
            
             //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
            $('.select2me', form3).change(function () {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
            
            
    }
    
    
    
    
    
    var handleValidationEditHotelFacilities = function() 
    {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
            
            var form3 = $('#edit_hotel_master_facilities');
            
            //IMPORTANT: update CKEDITOR textarea with actual content before submit
            form3.on('submit', function() {
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            })
            
            
            jQuery.validator.addMethod("cek_same_hotel_name",function(value) {
                if($(".hotel_name_check").val() != $(".hotel_name").val())
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }, "Hotel Name not exist in database");
            
            
            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                
                rules: {
                    hotel_name :{
                        required : true,
                        cek_same_hotel_name : true
                    }
                    
                },

                messages: { // custom messages for radio buttons and checkboxes
                    
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
                    form.submit();
                    
                }

            });
            
             //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
            $('.select2me', form3).change(function () {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
            
            
    }
    
    
    
    var handleValidationAddHotelAttrList = function() 
    {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
            
            var form3 = $('#add_hotel_attribute_list');
            
            //IMPORTANT: update CKEDITOR textarea with actual content before submit
            form3.on('submit', function() {
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            })
            
            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                
                rules: {
                    attribute_descripiton :{
                        required : true
                    },
                    
                    type : { 
                        required : true
                    },

                    sub_type : { 
                        required : true
                    }
                    
                    
                },

                messages: { // custom messages for radio buttons and checkboxes
                    
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
                    form.submit();
                    
                }

            });
            
             //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
            $('.select2me', form3).change(function () {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
            
            
    }
    
    
    
    
    var handleValidationEditHotelAttrList = function() 
    {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
            
            var form3 = $('#edit_hotel_attribute_list');
            
            //IMPORTANT: update CKEDITOR textarea with actual content before submit
            form3.on('submit', function() {
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            })
            
            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                
                rules: {
                    attribute_descripiton :{
                        required : true
                    },
                    
                    type : { 
                        required : true
                    },

                    sub_type : { 
                        required : true
                    }
                    
                    
                },

                messages: { // custom messages for radio buttons and checkboxes
                    
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
                    form.submit();
                    
                }

            });
            
             //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
            $('.select2me', form3).change(function () {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
            
            
    }


    var handleValidationAddHotelAttrList = function() 
    {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
            
            var form3 = $('#add_hotel_attribute_list');
            
            //IMPORTANT: update CKEDITOR textarea with actual content before submit
            form3.on('submit', function() {
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            })
            
            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                
                rules: {
                    attribute_descripiton :{
                        required : true
                    },
                    
                    type : { 
                        required : true
                    },

                    sub_type : { 
                        required : true
                    }
                    
                    
                },

                messages: { // custom messages for radio buttons and checkboxes
                    
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
                    form.submit();
                    
                }

            });
            
             //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
            $('.select2me', form3).change(function () {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
            
            
    }
    




    var handleValidationAddHotelPropertyLink = function() 
    {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
            
            var form3 = $('#add_hotel_property_attribute_link');
            
            //IMPORTANT: update CKEDITOR textarea with actual content before submit
            form3.on('submit', function() {
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            })
            
            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                
                rules: {
                    hotel_name :{
                        required : true
                    }
                    
                    
                },

                messages: { // custom messages for radio buttons and checkboxes
                    
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
                    form.submit();
                    
                }

            });
            
             //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
            $('.select2me', form3).change(function () {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
            
            
    }
    
    
    
    var handleValidationEditHotelPropertyLink = function() 
    {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
            
            var form3 = $('#edit_property_attribute_link');
            
            //IMPORTANT: update CKEDITOR textarea with actual content before submit
            form3.on('submit', function() {
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            })
            
            jQuery.validator.addMethod("cek_same_hotel_name",function(value) {
                if($(".hotel_name_check").val() != $(".hotel_name").val())
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }, "Hotel Name not exist in database");
            
            jQuery.validator.addMethod("cek_same_attribute_list",function(value) {
                if($(".attribute_name").val() != $(".attr_name_data").val())
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }, "Attribute list name is not exist in database");
            
            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                
                rules: {
                    hotel_name :{
                        required : true,
                        cek_same_hotel_name : true
                    },
                    attribute_name :{
                        required : true,
                        cek_same_attribute_list : true
                    }
                    
                    
                },

                messages: { // custom messages for radio buttons and checkboxes
                    
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
                    form.submit();
                    
                }

            });
            
             //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
            $('.select2me', form3).change(function () {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
            
            
    }
    
    
    
    var handleValidationAddRegionalEan = function() 
    {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
            
            var form3 = $('#add_regional_ean');
            
            //IMPORTANT: update CKEDITOR textarea with actual content before submit
            form3.on('submit', function() {
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            })
            
            jQuery.validator.addMethod("cek_same_hotel_name",function(value) {
                if($(".hotel_name_check").val() != $(".hotel_name").val())
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }, "Hotel Name not exist in database");
            
            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                
                rules: {
                    hotel_name :{
                        required : true,
                        cek_same_hotel_name : true
                    }
                    
                    
                },

                messages: { // custom messages for radio buttons and checkboxes
                    
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
                    form.submit();
                    
                }

            });
            
             //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
            $('.select2me', form3).change(function () {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
            
            
    }
    
    
    
    
    var handleValidationEditRegionalEan = function() 
    {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
            
            var form3 = $('#edit_regional_ean_hotel');
            
            //IMPORTANT: update CKEDITOR textarea with actual content before submit
            form3.on('submit', function() {
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            })
            
            jQuery.validator.addMethod("cek_same_hotel_name",function(value) {
                if($(".hotel_name_check").val() != $(".hotel_name").val())
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }, "Hotel Name not exist in database");
            
            
            jQuery.validator.addMethod("cek_same_region_name",function(value) {
                if($(".region_name_check").val() != $(".region_name").val())
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }, "Region Name not exist in database");
            
            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                
                rules: {
                    hotel_name :{
                        required : true,
                        cek_same_hotel_name : true
                    },
                    
                    region_name :{
                        required : true,
                        cek_same_region_name : true
                    }
                    
                },

                messages: { // custom messages for radio buttons and checkboxes
                    
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
                    form.submit();
                    
                }

            });
            
             //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
            $('.select2me', form3).change(function () {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
            
            
    }
    
    
    
    
    var handleValidationAddHotelCity = function() 
    {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
            
            var form3 = $('#add_hotel_city');
            
            //IMPORTANT: update CKEDITOR textarea with actual content before submit
            form3.on('submit', function() {
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            })
            
            
            jQuery.validator.addMethod("cek_same_country",function(value) {
                if($(".country_name_check").val() != $(".country").val() && $(".country").val().length > 0)
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }, "Country not exist in database");
            
            jQuery.validator.addMethod("cek_same_region",function(value) {
                if($(".region_name_check").val() != $(".region_name").val() && $(".region_name").val().length > 0)
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }, "Region Name not exist in database");
            
            
            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                
                // 	hotel_name, hotel_star, hotel_address_1, hotel_address_2, 
                //	postal_code, hotel_city, hotel_country, currency_code, latitude, longitude, 
                //	check_in, check_out

                
                rules: {
                    
                    country : {
                        required : true,
                        cek_same_country : true
                    },
                    
                    city_name : {
                        required : true
                    },
                    
                    region_name : {
                        required : true,
                        cek_same_region : true
                    }
                    
                },

                messages: { // custom messages for radio buttons and checkboxes
                    
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
                    form.submit();
                    
                }

            });
            
             //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
            $('.select2me', form3).change(function () {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
            
            
    }
    
    
    
    
        var handleValidationEditHotelCity = function() 
    {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
            
            var form3 = $('#edit_hotel_city');
            
            //IMPORTANT: update CKEDITOR textarea with actual content before submit
            form3.on('submit', function() {
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            })
            
            
            jQuery.validator.addMethod("cek_same_country",function(value) {
                if($(".country_name_check").val() != $(".country").val() && $(".country").val().length > 0)
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }, "Country not exist in database");
            
            jQuery.validator.addMethod("cek_same_region",function(value) {
                if($(".region_name_check").val() != $(".region_name").val() && $(".region_name").val().length > 0)
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }, "Region Name not exist in database");
            
            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                
                // 	hotel_name, hotel_star, hotel_address_1, hotel_address_2, 
                //	postal_code, hotel_city, hotel_country, currency_code, latitude, longitude, 
                //	check_in, check_out

                
                rules: {
                    
                    country : {
                        required : true,
                        cek_same_country : true
                    },
                    
                    city_name : {
                        required : true
                    },
                    
                    region_name : {
                        required : true,
                        cek_same_region : true
                    }
                    
                },

                messages: { // custom messages for radio buttons and checkboxes
                    
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
                    form.submit();
                    
                }

            });
            
             //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
            $('.select2me', form3).change(function () {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
            
            
    }
    

        var handleValidationAddRegionType = function() 
    {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
            
            var form3 = $('#add_region_type');
            
            //IMPORTANT: update CKEDITOR textarea with actual content before submit
            form3.on('submit', function() {
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            })
            
            
            
            
            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                
                // 	hotel_name, hotel_star, hotel_address_1, hotel_address_2, 
                //	postal_code, hotel_city, hotel_country, currency_code, latitude, longitude, 
                //	check_in, check_out

                
                rules: {
                    
                    region_type_name : {
                        required : true
                    }
                    
                },

                messages: { // custom messages for radio buttons and checkboxes
                    
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
                    form.submit();
                    
                }

            });
            
             //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
            $('.select2me', form3).change(function () {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
            
            
    }
    

    
    
    
    
        var handleValidationEditRegionType = function() 
    {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
            
            var form3 = $('#edit_hotel_type');
            
            //IMPORTANT: update CKEDITOR textarea with actual content before submit
            form3.on('submit', function() {
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            })
            
            
            
            
            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                
                // 	hotel_name, hotel_star, hotel_address_1, hotel_address_2, 
                //	postal_code, hotel_city, hotel_country, currency_code, latitude, longitude, 
                //	check_in, check_out

                
                rules: {
                    
                    region_type_name : {
                        required : true
                    }
                    
                },

                messages: { // custom messages for radio buttons and checkboxes
                    
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
                    form.submit();
                    
                }

            });
            
             //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
            $('.select2me', form3).change(function () {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
            
            
    }
    
    
    var handleValidationAddHotelCountry = function() 
    {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
            
            var form3 = $('#add_hotel_country');
            
            //IMPORTANT: update CKEDITOR textarea with actual content before submit
            form3.on('submit', function() {
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            })
            
            
            jQuery.validator.addMethod("cek_same_region",function(value) {
                if($(".region_name_check").val() != $(".region_name").val())
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }, "Region Name not exist in database");
            
            
            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                
                // 	hotel_name, hotel_star, hotel_address_1, hotel_address_2, 
                //	postal_code, hotel_city, hotel_country, currency_code, latitude, longitude, 
                //	check_in, check_out

                
                rules: {
                    
                    country_name : {
                        required : true
                    },
                    
                    country_code : {
                        required : true
                    },
                    
                    region_name : {
                        required : true,
                        cek_same_region : true
                    }
                    
                },

                messages: { // custom messages for radio buttons and checkboxes
                    
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
                    form.submit();
                    
                }

            });
            
             //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
            $('.select2me', form3).change(function () {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
            
            
    }
    
    
    
    var handleValidationEditHotelCountry = function() 
    {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
            
            var form3 = $('#edit_hotel_country');
            
            //IMPORTANT: update CKEDITOR textarea with actual content before submit
            form3.on('submit', function() {
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            })
            
            
            jQuery.validator.addMethod("cek_same_region",function(value) {
                if($(".region_name_check").val() != $(".region_name").val())
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }, "Region Name not exist in database");
            
            
            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                
                // 	hotel_name, hotel_star, hotel_address_1, hotel_address_2, 
                //	postal_code, hotel_city, hotel_country, currency_code, latitude, longitude, 
                //	check_in, check_out

                
                rules: {
                    
                    country_name : {
                        required : true
                    },
                    
                    country_code : {
                        required : true
                    },
                    
                    region_name : {
                        required : true,
                        cek_same_region : true
                    }
                    
                },

                messages: { // custom messages for radio buttons and checkboxes
                    
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
                    form.submit();
                    
                }

            });
            
             //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
            $('.select2me', form3).change(function () {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
            
            
    }
    
    
    
    
    return {
        //main function to initiate the module
        init: function () {
            handleValidationEditDetailHotelMap();
            handleValidationAddDetailHotelMap();
            handleValidationAddHotelImage();
            handleValidationEditHotelImage();
            handleValidationAddRegionHotel();
            handleValidationEditRegionHotel();
            handleValidationAddHotelMaster();
            handleValidationEditHotelMaster();
            handleValidationAddHotelFacilities();
            handleValidationEditHotelFacilities();
            handleValidationAddHotelAttrList();
            handleValidationEditHotelAttrList();
            handleValidationAddHotelPropertyLink();
            handleValidationEditHotelPropertyLink();
            handleValidationAddRegionalEan();
            handleValidationEditRegionalEan();
            handleValidationAddHotelCity();
            handleValidationEditHotelCity();
            handleValidationAddRegionType();
            handleValidationEditRegionType();
            handleValidationAddHotelCountry();
            handleValidationEditHotelCountry();
            
        }

    };

}();