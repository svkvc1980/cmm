var orderbooking_form = function() {

    var handleorderbooking_form = function() {

        $('#orderbooking_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                    
                    agency_name: {
                        required: 'Agency Name is required'
                    },
                    unit_code: {
                        required: 'unit code is required'
                    },
                    
                },
                rules: {
                    
                    agency_name: {
                        required: true
                    },
                    unit_code: {
                                                
                        required: true
                    },
                    
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

        $('#orderbooking_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#orderbooking_form').validate().form()) {
                    $('#orderbooking_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handleorderbooking_form();
        }

    };

}();

jQuery(document).ready(function() {
    orderbooking_form.init();
});


