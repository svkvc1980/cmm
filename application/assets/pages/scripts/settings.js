var generalsettings_Form = function() {

    var handlegeneralsettingsForm = function() {

        $('#general_settings_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
                 messages: {
                        name: {
                            required: 'Name is required'
                        }
                    },           
                rules: { 
                     section:{
                        required:true
                     },                   
                  name: {                                         
                        required: true
                    },
                    value:{
                        required: true
                    },
                    lable:{
                        required:true
                    },
                    type:{
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

        $('#general_settings_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#general_settings_form').validate().form()) {
                    $('#general_settings_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }
    return {
        //main function to initiate the module
        init: function() {
            handlegeneralsettingsForm();
        }

    };

}();

jQuery(document).ready(function() {
    generalsettings_Form.init();
});
$('#preferenceSection').change(function(){
    $('#preferenceName').prev('i').removeClass('fa-check fa-warning').addClass('fa');
    $('#preferenceName').closest('div.form-group').removeClass('has-success has-error');
    $("#preferenceError").addClass("hidden");
    $('#preferenceName').val('');
})
//validate Uniqueness for preference name
$('#preferenceName').blur(function(){
    var preference_name = $(this).val();
    var preference_id = $('#preference_id').val();
    var preference_section =$('#preferenceSection').val();
    if(preference_id=='')
    {
        preference_id = 0;
    }   
    if(preference_name!='')
    {
        $("#preferencenameValidating").removeClass("hidden");
        
        $("#preferenceError").addClass("hidden");
        
        $.ajax({
        type:"POST",
        url:SITE_URL+'is_nameExist',
        data:{preference_name:preference_name,identity:preference_id,preference_section:preference_section},
        cache:false,
        success:function(html){ 
        $("#preferencenameValidating").addClass("hidden");
            if(html==1)
            {
                $('#preferenceName').val('');
                $('#preferenceName').prev('i').removeClass('fa-check').addClass('fa-warning');
                $('#preferenceName').closest('div.form-group').removeClass('has-success').addClass('has-error');
                $('#preferenceError').html('Sorry <b>'+preference_name+'</b> has already been taken');
                $("#preferenceError").removeClass("hidden");
                return false;
            }
            else
            {   
                $('#preferenceError').html('');
                $("#preferenceError").addClass("hidden");
                return false;
            }
        }
        });        
    }
});
