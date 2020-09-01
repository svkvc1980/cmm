var customer = function() {

    var handlecustomer = function() {

        $('.customer_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                company_id: {
                    required: true
                },
                customer_name: {
                    required:true,
                    maxlength: 255
                },
                address: {
                    maxlength: 255
                },
                email: {
                    email: true
                }
            },

            messages: {
                company_id: {
                    required: "Company can not be empty."
                },
                customer_name:{
                    required: "Customer Name can not be empty."
                },
                address: {
                    maxlength: "Cannot exceed 255 characters."
                },
                email: {
                    email: "Please enter valid email address."
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

        $('.customer_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('.customer_form').validate().form()) {
                    $('.customer_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handlecustomer();
        }

    };

}();

jQuery(document).ready(function() {
    customer.init();
});


//validate Uniqueness for customer name
$('#company_id').change(function(){
    $('#customerName').prev('i').removeClass('fa-warning');
    $('#customerName').closest('div.form-group').removeClass('has-error');
    $('#customerError').html('');
    $("#customerError").addClass("hidden");
});
$('#customerName').blur(function(){
    var customer_name = $(this).val();
    var company_id = $('#company_id').val();
    var customer_id = $('#customer_id').val();
    if(customer_id=='')
    {
        customer_id = 0;
    }
    if(customer_name!='')
    {
        $("#customernameValidating").removeClass("hidden");
        $("#customerError").addClass("hidden");
        
        $.ajax({
        type:"POST",
        url:SITE_URL+'is_customerExist',
        data:{customer_name:customer_name,company_id:company_id,customer_id:customer_id},
        cache:false,
        success:function(html){ 
        $("#customernameValidating").addClass("hidden");
            if(html==1)
            {
                $('#customerName').val('');
                $('#customerName').prev('i').removeClass('fa-check').addClass('fa-warning');
                $('#customerName').closest('div.form-group').removeClass('has-success').addClass('has-error');
                $('#customerError').html('Sorry <b>'+customer_name+'</b> has already been taken');
                $("#customerError").removeClass("hidden");
                return false;
            }
            else
            {   
                $('#customerError').html('');
                $("#customerError").addClass("hidden");
                return false;
            }
        }
        });
        
    }
});