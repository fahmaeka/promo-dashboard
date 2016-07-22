$(document).ready(function(){
//    $('#btn-submit').click(function(){
//        $('#form').submit();
//    });
    $('#form').validate({
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

    //text editor
    /*$('.editor').tinymce({
        theme: "modern",
        skin: "flat",
        relative_urls: false,
        remove_script_host: false,
        plugins: [
             "advlist autolink link image lists charmap print preview hr anchor pagebreak",
             "searchreplace wordcount visualblocks visualchars code insertdatetime media nonbreaking",
             "table contextmenu directionality emoticons paste textcolor responsivefilemanager"
        ],
        toolbar: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect forecolor backcolor | link unlink anchor | responsivefilemanager image media | print preview code",
        menubar : false,
        image_advtab: true,
        verify_html: false,
        inline_styles : true,
        valid_elements : "@[id|class|style|title|dir<ltr?rtl|lang|xml::lang],"
        + "a[rel|rev|charset|hreflang|tabindex|accesskey|type|name|href|target|title|class|style],"
        + "strong/b,em/i,strike,u,"
        + "#p[style],-ol[type|compact],-ul[type|compact],-li,br,img[longdesc|usemap|"
        + "src|border|alt=|title|hspace|vspace|width|height|align],-sub,-sup,"
        + "-blockquote,-table[border=0|cellspacing|cellpadding|width|frame|rules|"
        + "height|align|summary|bgcolor|background|bordercolor|style],-tr[rowspan|width|"
        + "height|align|valign|bgcolor|background|bordercolor|style],tbody,thead,tfoot,"
        + "#td[colspan|rowspan|width|height|align|valign|bgcolor|background|bordercolor"
        + "|scope|style],#th[colspan|rowspan|width|height|align|valign|scope|style],caption,-div,"
        + "-span,-code,-pre,address,-h1,-h2,-h3,-h4,-h5,-h6,hr[size|noshade],-font[face"
        + "|size|color],dd,dl,dt,cite,abbr,acronym,del[datetime|cite],ins[datetime|cite],"
        + "object[classid|width|height|codebase|*],param[name|value|_value],embed[type|width"
        + "|height|src|*],map[name],area[shape|coords|href|alt|target],bdo,"
        + "button,col[align|char|charoff|span|valign|width],colgroup[align|char|charoff|span|"
        + "valign|width],dfn,fieldset,form[action|accept|accept-charset|enctype|method],"
        + "input[accept|alt|checked|disabled|maxlength|name|readonly|size|src|type|value],"
        + "kbd,label[for],legend,noscript,optgroup[label|disabled],option[disabled|label|selected|value],"
        + "q[cite],samp,select[disabled|multiple|name|size],small,"
        + "textarea[cols|rows|disabled|name|readonly],tt,var,big",
        extended_valid_elements : "p[style]",
        external_filemanager_path: base_url + "filemanager/",
        filemanager_title:"File Manager",
        external_plugins: { "filemanager" : base_url + "filemanager/plugin.min.js" }
    });*/
});