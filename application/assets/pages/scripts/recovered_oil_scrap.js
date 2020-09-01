var recovered_oil_scrapForm = function() {

    var handlerecoveredoilscrapForm = function() {

        $('#recovered_oil_scarp_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            
                rules: {
                    loose_oil:{
                        required:true
                    },
                 on_date:
                    {
                     required: true
                    },
                    oil_weight:{
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

        $('#recovered_oil_scarp_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#recovered_oil_scarp_form').validate().form()) {
                    $('#recovered_oil_scarp_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }
    return {
        //main function to initiate the module
        init: function() {
            handlerecoveredoilscrapForm();
        }

    };

}();

jQuery(document).ready(function() {
    recovered_oil_scrapForm.init();
});
$('.loose_oil_id').change(function(){
    var loose_oil_id = $(this).val();

    if(loose_oil_id!='')
    {
        $.ajax({
            type:"POST",
            url:SITE_URL+'get_oil_weight',
            data:{loose_oil_id:loose_oil_id},
            cache:false,
            success:function(html){
                $('.previous_oil_weight').html(html);
                $('.available_qty').val(html);
                $('.oil_weight').attr('max',html);
                $('.oil_weight').val('');
                $('.oil_weight').prev('i').removeClass('fa-check fa-warning').addClass('fa');
                $('.oil_weight').closest('div form-group').removeClass('has-error has-success');

            }
        });
    }
    else
    {
        $('.previous_oil_weight').html('--');
        $('.available_qty').val('');
        $('.oil_weight').val('');
    }
});
$(document).on('blur','.oil_weight',function(){
    var available_qty = $('.available_qty').val();
    var oil_weight = $(this).val();
    if(available_qty!='' && oil_weight != '')
    {
        if(oil_weight > available_qty)
        {
            $('.oil_weight').closest('div form-group').addClass('has-error');
            return false;
        }

    }
});