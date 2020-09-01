var freegift_form = function() {

    var handlefreegift_form = function() {

        $('#freegift_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
               freegift_type:{
                    required: 'Free Gift cannot be empty'
                }
            },
            rules: 
            {
                freegift_type:{
                    required: true
                },
                supplier:{
                    required: true
                },
                quantity:{
                    required: true
                },
                rate:{
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

        $('#freegift_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#oil_form').validate().form()) {
                    $('#oil_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handlefreegift_form();
        }

    };

}();

jQuery(document).ready(function() {
    freegift_form.init();
/*
     var quantity=$('.quantity').val();
    var rate1=$('.rate').val();
    var t_amount=quantity*rate1;
    $('.t_amount').val(t_amount);*/


    $(document).on('blur','.rate',function(){ 
      var ele_panel_body=$(this).closest('.srow');
      var quantity=$('.quantity').val();
      var rate=$('.rate').val();
      var total_amount=quantity*rate;
      ele_panel_body.find('.t_amount').val(total_amount);
    });
});
$('.quantity').blur(function(){
      var ele_panel_body=$(this).closest('.srow');
      var quantity=$('.quantity').val();
      var rate=$('.rate').val();
      if(rate!='')
      {
        var total_amount=quantity*rate;
        ele_panel_body.find('.t_amount').val(total_amount);
      }
      
})
