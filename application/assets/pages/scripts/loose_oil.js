var loose_oilForm = function() {

    var handlelooseoilForm = function() {

        $('#loose_oil_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                    name: {
                        required: 'Name is required'
                    }
                },
                rules: {                    
                    name: {                                          
                        required: true
                    },
                    short_name:{
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

        $('#loose_oil_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#loose_oil_form').validate().form()) {
                    $('#loose_oil_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }
    return {
        //main function to initiate the module
        init: function() {
            handlelooseoilForm();
        }

    };

}();

jQuery(document).ready(function() {
    loose_oilForm.init();
});

//validate Uniqueness for product name
$('#looseoilName').blur(function(){
    var looseoil_name = $(this).val();
    var loose_oil_id = $('#loose_oil_id').val();

    if(loose_oil_id=='')
    {
        loose_oil_id = 0;
    }
   
    if(looseoil_name!='')
    {
        $("#looseoilnameValidating").removeClass("hidden");
        $("#looseoilError").addClass("hidden");
        
        $.ajax({
        type:"POST",
        url:SITE_URL+'is_looseoilExist',
        data:{looseoil_name:looseoil_name,identity:loose_oil_id},
        cache:false,
        success:function(html){ 
        $("#looseoilnameValidating").addClass("hidden");
            if(html==1)
            {
                $('#looseoilName').val('');
                $('#looseoilName').prev('i').removeClass('fa-check').addClass('fa-warning');
                $('#looseoilName').closest('div.form-group').removeClass('has-success').addClass('has-error');
                $('#looseoilError').html('Sorry <b>'+looseoil_name+'</b> has already been taken');
                $("#looseoilError").removeClass("hidden");
                return false;
            }
            else
            {   
                $('#looseoilError').html('');
                $("#looseoilError").addClass("hidden");
                return false;
            }
        }
        });
        
    }
});
