var welfare_schemeForm = function() {

    var handlewelfareschemeForm = function() {

        $('#welfare_scheme_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            
                rules: {
                 name:
                    {
                        required: true
                    },                    
                    start_date: {                                          
                        required: true
                    },
                    end_date:{
                      required: true
                    },
                     discount_percentage: {
                           required: true,
                                 range: [0, 100]
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

        $('#welfare_scheme_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#welfare_scheme_form').validate().form()) {
                    $('#welfare_scheme_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }
    return {
        //main function to initiate the module
        init: function() {
            handlewelfareschemeForm();
        }

    };

}();

jQuery(document).ready(function() {
    welfare_schemeForm.init();
});
