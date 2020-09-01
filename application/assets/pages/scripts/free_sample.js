var freesample_form = function() {

    var handlefreesample_form = function() {

        $('#freesample_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
               on_date:{
                    required: 'Date cannot be empty'
                },
                product_id: {
                    required: 'product cannot be empty'
                },
                quantity: {
                    required: 'Quantity cannot be empty'
                },
                description: {
                    required: 'description cannot be empty'
                }
            },
            rules: 
            {
                on_date:{
                    required: true
                },
                product_id:{
                    required: true
                },
                quantity:{
                    required: true
                },
                description: {
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

        $('#freesample_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#freesample_form').validate().form()) {
                    $('#freesample_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handlefreesample_form();
        }

    };

}();

jQuery(document).ready(function() {
   
    freesample_form.init();
});
    
$('.product').change(function(){ 
    
    var product_id = $(this).val();
      if(product_id != '')
      {
        $.ajax({
            type:"POST",
            url:SITE_URL+'getitemsList',
            data:{product_id:product_id},
            cache:false,
            success:function(html){

                $('.item').val(html);
            }
        });
       
      }
      else
      {
        $('.product').prev('i').removeClass('fa-check fa-warning').addClass('fa');
        $('.product').closest('div.form-group').removeClass('has-success has-error');
        $('.item').val('');
      }
      if(plant_id !=''&& product_id !='')
      {
        $.ajax({
            type:"POST",
            url:SITE_URL+'getquantityList',
            data:{product_id:product_id,plant_id:plant_id},
            cache:false,
            success:function(html){
                /*var qty=$('.quantity').val();*/
                $('.quantity').val(html);
            }
        });
      }
      else
      {
        $('.product').prev('i').removeClass('fa-check fa-warning').addClass('fa');
        $('.product').closest('div.form-group').removeClass('has-success has-error');
        $('.quantity').val('');
      }
    });

