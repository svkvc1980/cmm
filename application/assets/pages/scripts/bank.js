var bank = function() {

    var handlebank = function() {

        $('.bank_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                bank_name: {
                    required: true
                }
            },

            messages: {
                bank_name: {
                    required: "Bank Name can not be empty."
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

        $('.bank_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('.bank_form').validate().form()) {
                    $('.bank_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handlebank();
        }

    };

}();

jQuery(document).ready(function() {
    bank.init();
});


//validate Uniqueness for Bank name

$('#bankName').blur(function(){
    var bank_name = $(this).val();
    var bank_id = $('#bank_id').val();
    if(bank_id=='')
    {
        bank_id = 0;
    }
    if(bank_name!='')
    {
        $("#banknameValidating").removeClass("hidden");
        $("#bankError").addClass("hidden");
        
        $.ajax({
        type:"POST",
        url:SITE_URL+'is_bankExist',
        data:{bank_name:bank_name,bank_id:bank_id},
        cache:false,
        success:function(html){ 
        $("#banknameValidating").addClass("hidden");
            if(html==1)
            {
                $('#bankName').val('');
                $('#bankName').prev('i').removeClass('fa-check').addClass('fa-warning');
                $('#bankName').closest('div.form-group').removeClass('has-success').addClass('has-error');
                $('#bankError').html('Sorry <b>'+bank_name+'</b> has already been taken');
                $("#bankError").removeClass("hidden");
                return false;
            }
            else
            {   
                $('#bankError').html('');
                $("#bankError").addClass("hidden");
                return false;
            }
        }
        });
        
    }
});