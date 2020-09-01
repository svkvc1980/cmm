var stock_updationForm = function() {

    var handlestock_updationForm = function() {

        $('.stock_updation').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: 
            {
                product_id:
                {
                    required: 'Product Name is required'
                },
                new_quantity:
                {
                    required: 'New Qty is required'
                },
                plant_id:
                {
                    required: 'Unit Name is required'
                },
                remarks:
                {
                    required: 'Remarks is required'
                }
            },
            rules: {
                product_id:{
                  required:true
                },
                new_quantity: {             
                    required: true
                },                
                plant_id: {
                    required: true,
                },
                remarks:
                {
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

        $('.stock_updation input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('.stock_updation').validate().form()) {
                    $('.stock_updation').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }
    return {
        //main function to initiate the module
        init: function() {
            handlestock_updationForm();
        }
    };

}();

jQuery(document).ready(function() {
    stock_updationForm.init();
});
$('.plant_id').change(function()
{
    $('.old_quantity').html('--');
    $('.product_id').val('');
    $('.product_id').prev('i').removeClass('fa-check fa-warning');
    $('.product_id').closest('div.form-group').removeClass('has-success has-error');
});

$('.product_id').change(function()
{
    var product_id=$(this).val();
    var plant_id = $('.plant_id').val();
    if(product_id!='' || plant_id!='')
    {
         $.ajax({
            type:"POST",
            url:SITE_URL+'get_product_stock_details',
            data:{plant_id:plant_id,product_id:product_id},
            cache:false,
            success:function(html)
            {
                $('.old_quantity').html(html);
            }
        });

    }
    else
    {
     $('.old_quantity').html('--');
     $('.plant_id').val('');
   }
});