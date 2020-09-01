var category = function() {

    var handlecategory = function() {

        $('#category_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                material_name: {
                    required: true
                },
                type: {
                    required: true
                },
                unit: {
                    required: true
                }
            },

            messages: {
                material_name: {
                    required: "Name can not be empty."
                },
                type: {
                    required: "Packing Type can not be empty."
                },
                unit: {
                    required: "Unit Can not be empty"
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   
                //$('.alert-danger', $('.reset-form')).show();
            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("fa-warning").addClass("fa-check");
            },

            errorPlacement: function(error, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    icon.removeClass('fa-check').addClass("fa-warning");  
                    icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
            },


            submitHandler: function(form) {
                form.submit(); // form validation success, call ajax form submit
            }
        });

        $('#category_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#category_form').validate().form()) {
                    $('#category_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handlecategory();
        }

    };

}();

jQuery(document).ready(function() {
    category.init();
});


//validate Uniqueness for Tank name


$('#material_name').blur(function(){
    var material_name = $(this).val();
    var category_id = $('#category_id').val();
    if(category_id=='')
    {
        category_id = 0;
    }
    if(material_name!='')
    {
        $("#material_nameValidating").removeClass("hidden");
        $("#materialError").addClass("hidden");
        
        $.ajax({
        type:"POST",
        url:SITE_URL+'is_categoryExist',
        data:{material_name:material_name,category_id:category_id},
        cache:false,
        success:function(html){ 
        $("#material_nameValidating").addClass("hidden");
            if(html==1)
            {
                $('#material_name').val('');
                $('#material_name').prev('i').removeClass('fa-check').addClass('fa-warning');
                $('#material_name').closest('div.form-group').removeClass('has-success').addClass('has-error');
                $('#materialError').html('Sorry <b>'+material_name+'</b> has already been taken');
                $("#materialError").removeClass("hidden");
                return false;
            }
            else
            {   
                $('#materialError').html('');
                $("#materialError").addClass("hidden");
                return false;
            }
        }
        });
        
    }
});