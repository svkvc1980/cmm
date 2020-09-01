var loose_oil_productForm = function() {

    var handlelooseoilproductForm = function() {

        $('#loose_oil_product_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                    name: {
                        required: 'Name is required'
                    }
                },
                rules: {                    
                    loose_oil_product_name: {                                          
                        required: true
                    },
                    code:{
                        required: true
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

        $('#loose_oil_product_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#loose_oil_product_form').validate().form()) {
                    $('#loose_oil_product_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handlelooseoilproductForm();
        }

    };

}();

jQuery(document).ready(function() {
    loose_oil_productForm.init();
});

//validate Uniqueness for product name
$('#productName').blur(function(){
    var product_name = $(this).val();
    var product_id = $('#loose_oil_product_id').val();

    if(product_id=='')
    {
        product_id = 0;
    }
   
    if(product_name!='')
    {
        $("#productnameValidating").removeClass("hidden");
        $("#productError").addClass("hidden");
        
        $.ajax({
        type:"POST",
        url:SITE_URL+'is_productExist',
        data:{product_name:product_name,identity:product_id},
        cache:false,
        success:function(html){ 
        $("#productnameValidating").addClass("hidden");
            if(html==1)
            {
                $('#productName').val('');
                $('#productName').prev('i').removeClass('fa-check').addClass('fa-warning');
                $('#productName').closest('div.form-group').removeClass('has-success').addClass('has-error');
                $('#productError').html('Sorry <b>'+product_name+'</b> has already been taken');
                $("#productError").removeClass("hidden");
                return false;
            }
            else
            {   
                $('#productError').html('');
                $("#productError").addClass("hidden");
                return false;
            }
        }
        });
        
    }
});
