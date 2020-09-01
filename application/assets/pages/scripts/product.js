var product_form = function() {

    var handleproduct_form = function() {

        $('#product_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                    capacity: {
                        required: 'Capacity Name is required'
                    },
                    loose_oil: {
                        required: 'Loose Oil Name is required'
                    },
                    product: {
                        required: 'Product Name is required'
                    },
                     short_name: {
                        required:'Short Name is required'
                    },
                    items_per_carton:{
                        required:'Item per carton is required'
                    },
                    oil_weight:{
                        required:'Oil Weight is required'
                    },
                    product_packing_type:{
                        required:'Packing Type is required'
                    }
                },
                rules: {
                    capacity: {
                        required: true
                    },
                    loose_oil: {
                        required: true
                    },
                    product: {
                        required: true
                    },
                    short_name: {
                        required: true
                    },
                    items_per_carton:{
                        required:true
                    },
                    oil_weight:{
                        required:true
                    },
                    product_packing_type:{
                        required:true
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

        $('#product_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#product_form').validate().form()) {
                    $('#product_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handleproduct_form();
        }

    };

}();

jQuery(document).ready(function() {
    product_form.init();
});
//name unique...
$('.capacity_id').change(function(){
    $('#productName').prev('i').removeClass('fa-check fa-warning').addClass('fa');
    $('#productName').closest('div.form-group').removeClass('has-success has-error');
    $("#ProductError").addClass("hidden");
})
//validate Uniqueness for capacity name
$('#productName').blur(function(){
    var product_name = $(this).val();
    var product_id = $('.product_id').val();
    var capacity_id =$('.capacity_id').val();
    if(product_id=='')
    {
        product_id = 0;
    }   
    if(product_name!='')
    {
        $("#productnameValidating").removeClass("hidden");
        
        $("#ProductError").addClass("hidden");
        
        $.ajax({
        type:"POST",
        url:SITE_URL+'is_product_name_Exist',
        data:{product_name:product_name,product_id:product_id,capacity_id:capacity_id},
        cache:false,
        success:function(html){ 
        $("#productnameValidating").addClass("hidden");
            if(html==1)
            {
                $('#productName').val('');
                $('#productName').prev('i').removeClass('fa-check').addClass('fa-warning');
                $('#productName').closest('div.form-group').removeClass('has-success').addClass('has-error');
                $('#ProductError').html('Sorry <b>'+product_name+'</b> has already been taken');
                $("#ProductError").removeClass("hidden");
                return false;
            }
            else
            {   
                $('#ProductError').html('');
                $("#ProductError").addClass("hidden");
                return false;
            }
        }
        });        
    }
});

