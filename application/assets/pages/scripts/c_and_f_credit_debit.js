var c_and_f_credit_debitForm = function() {

    var handlec_and_f_credit_debitForm = function() {
        
        $('#c_and_f_credit_debit_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: 
            {
                plant_id:
                {
                    required: 'ploant is required'
                }
            },
            rules: {
                plant_id: {
                    required: true
                },
                amount: {
                    required: true
                },
                on_date: {
                    required: true
                },
                note_type: {
                    required: true
                },
                purpose_id: {
                    required: true
                },
                reason: {
                          required: function(element) {
                            return $("#purpose_rq").val() == 9999;
                        }   
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
        


        $('#c_and_f_credit_debit_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#c_and_f_credit_debit_form').validate().form()) {
                    
                    $('#c_and_f_credit_debit_form').submit(); //form validation success, call ajax form submit
                }
               
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handlec_and_f_credit_debitForm();
        }

    };

}();


jQuery(document).ready(function() {

    c_and_f_credit_debitForm.init();
});

$('.type_id').change(function(){
    
    $('.purpose_id').prev('i').removeClass('fa-check').removeClass('fa-warning').addClass('fa');
    $('.purpose_id').closest('div.form-group').removeClass('has-success').removeClass('has-error');
    $('.reason').prev('i').removeClass('fa-check fa-warning').addClass('fa');
    $('.reason').closest('div.form-group').removeClass('has-success has-error');
   
    var type_id = $(this).val();
    
    if(type_id=='')
    {
        $('.purpose_id').html('<option value="">-Select Purpose-</option');
    }
    else
    {
        $.ajax({
            type:"POST",
            url:SITE_URL+'getpurpose',
            data:{type_id:type_id},
            cache:false,
            success:function(html){
                $('.purpose_id').html(html);
            }
        });
    }
});
$('.purpose_id').change(function(){
    $('.reason').prev('i').removeClass('fa-check fa-warning').addClass('fa');
    $('.reason').closest('div.form-group').removeClass('has-success has-error');
});



