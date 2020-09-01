var micron_form = function() {

    var handlemicron_form = function() {

        $('#micron_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                    
                    name: {
                        required: 'micron name is required'
                    }
                },
                rules: {
                    
                   name: {
                        maxlength:255,                        
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

        $('#micron_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#micron_form').validate().form()) {
                    $('#micron_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handlemicron_form();
        }

    };

}();

jQuery(document).ready(function() {
    micron_form.init();
});

//validate Uniqueness for loose oil name
$('#micronName').blur(function(){
    var name = $(this).val();
    var micron_id = $('#micron_id').val();
    if(micron_id=='')
    {
        micron_id = 0;
    }
   
    if(name!='')
    {
        $("#micronnameValidating").removeClass("hidden");
        $("#micronError").addClass("hidden");
        
        $.ajax({
        type:"POST",
        url:SITE_URL+'is_micronExist',
        data:{name:name,identity:micron_id},
        cache:false,
        success:function(html){ 
        $("#micronnameValidating").addClass("hidden");
            if(html==1)
            {
                $('#micronName').val('');
                $('#micronName').prev('i').removeClass('fa-check').addClass('fa-warning');
                $('#micronName').closest('div.form-group').removeClass('has-success').addClass('has-error');
                $('#micronError').html('Sorry <b>'+name+'</b> has already been taken');
                $("#micronError").removeClass("hidden");
                return false;
            }
            else
            {   
                $('#micronError').html('');
                $("#micronError").addClass("hidden");
                return false;
            }
        }
        });
        
    }
});
