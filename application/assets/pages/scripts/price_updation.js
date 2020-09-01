var price_updation = function() {

    var handleprice_updation = function() {

        $('.price_view').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                price_type: {
                    required: true
                },
                mrp_plant: {
                    required:true
                },
                plant_name: {
                    required:true
                }
            },

            messages: {
                price_type: {
                    required: "Price Type is required"
                },
                mrp_plant:{
                    required: "Unit type is required"
                },
                plant_name: {
                    required:'Unit name is required'
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

        $('.price_view input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('.price_view').validate().form()) {
                    $('.price_view').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handleprice_updation();
        }

    };

}();

jQuery(document).ready(function() {
    price_updation.init();
});

$(document).ready(function(){
    $('.pb,.distributor').val('');
    $('.plant').hide();
    //$('.plant_block').hide();
    $('.distributor').change(function(){
        var type_id=$(this).val();
        var mrp_id=$('.mrp').val();
      var raitu_bazar_id=$('.raitu_bazar').val();
        if(parseInt(type_id)==parseInt(mrp_id))
        {
            $('.plant').show();
            $('.plant_block').hide();
        }
      else if(parseInt(type_id)==parseInt(raitu_bazar_id))
      {
        $('.plant').hide();
        $('.plant_block').hide();  
      }
        else
        {
            $('.plant').hide();
            $('.plant_block').show();

        }
    });
    $('.plant_value').click(function(){
        var value=$(this).val();
        if(value==2)
        {
            $('.plant_block').hide();
        }
        else
        {
            $('.plant_block').show();
            $('.pb').prev('i').removeClass('fa-check fa-warning').addClass('fa');
            $('.pb').closest('div.form-group').removeClass('has-success has-error');
            $('.pb').val('');
        }
        
    });
    
});