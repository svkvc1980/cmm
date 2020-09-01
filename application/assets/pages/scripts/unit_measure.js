var unitForm = function() {

    var handleunitForm = function() {

        $('#unit_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input           
                rules: {                    
                  name: {                                         
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

        $('#unit_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#unit_form').validate().form()) {
                    $('#unit_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }
    return {
        //main function to initiate the module
        init: function() {
            handleunitForm();
        }

    };

}();

jQuery(document).ready(function() {
    unitForm.init();
});

//validate Uniqueness for product name
$('#unitName').blur(function(){
    var unit_name = $(this).val();
    var unit_id = $('#unit_id').val();

    if(unit_id=='')
    {
        unit_id = 0;
    }
   
    if(unit_name!='')
    {
        $("#unitnameValidating").removeClass("hidden");
        $("#unitError").addClass("hidden");
        
        $.ajax({
        type:"POST",
        url:SITE_URL+'is_unit_measureExist',
        data:{unit_name:unit_name,identity:unit_id},
        cache:false,
        success:function(html){ 
        $("#unitnameValidating").addClass("hidden");
            if(html==1)
            {
                $('#unitName').val('');
                $('#unitName').prev('i').removeClass('fa-check').addClass('fa-warning');
                $('#unitName').closest('div.form-group').removeClass('has-success').addClass('has-error');
                $('#unitError').html('Sorry <b>'+unit_name+'</b> has already been taken');
                $("#unitError").removeClass("hidden");
                return false;
            }
            else
            {   
                $('#unitError').html('');
                $("#unitError").addClass("hidden");
                return false;
            }
        }
        });

    }
});
