var wasteoilsaleForm = function() {

    var handlewasteoilsaleForm = function() {

        $('#waste_oil_sale_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: 
            {
                buyer_name:
                {
                    required: 'Buyer Name is required'
                }
            },
            rules: {
                buyer_name:{
                  required:true
                },
                on_date: {             
                    required: true
                },                
                mobile: {
                    required: true,
                    number:true,
                    maxlength: 10
                },
                address: {
                    required: true
                },
                loose_oil_id: {
                    required: true
                },
                quantity: {
                    required: true
                },
                cost: {
                    required: true,
                    number:true,
                    maxlength: 8
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

        $('#waste_oil_sale_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#waste_oil_sale_form').validate().form()) {
                    $('#waste_oil_sale_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }
    return {
        //main function to initiate the module
        init: function() {
            handlewasteoilsaleForm();
        }
    };

}();

jQuery(document).ready(function() {
    wasteoilsaleForm.init();
});

$('.loose_oil_id').change(function()
{
    var loose_oil_id=$(this).val();
    if(loose_oil_id!='')
    {
         $.ajax({
            type:"POST",
            url:SITE_URL+'get_loose_oil_details',
            data:{loose_oil_id:loose_oil_id},
            cache:false,
            success:function(html)
            {
                $('.old_quantity').html(html);
                $('.available_qty').val(html);
                $('.oil_weight').attr('max',html);
                $('.oil_weight').val('');
                $('.oil_weight').prev('i').removeClass('fa-check').addClass('fa-warning');
                $('.oil_weight').closest('div.form-group').removeClass('has-success').addClass('has-error');
            }
        });

    }
    else
    {
     $('.old_quantity').html('--');
     $('.available_qty').val('');
     $('.oil_weight').val('');
   }
});
$(document).on('blur','.oil_weight',function()
{
    var available_qty =$('.available_qty').val();
    var oil_weight =$(this).val();
    if(available_qty!=''&& oil_weight!='')
    {
        if(oil_weight > available_qty)
        {
            $('.oil_weight').closest('div form-group').addClass('has-error');
            return false;
        }
    }
});



