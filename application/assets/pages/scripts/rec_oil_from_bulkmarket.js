var received_oil_Form = function() {

    var handlereceivedoilForm = function() {

        $('#received_oil_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                    loose_oil_product_name: {
                        required: 'prodcut name is required'
                    }
                },
                rules:{                    
                    loose_oil_product:{                                                              
                        required: true
                    },
                    received_date:{
                        required: true
                    },
                    quantity:{
                        required: true
                    },
                     dc_no:{
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

        $('#received_oil_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#received_oil_form').validate().form()) {
                    $('#received_oil_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handlereceivedoilForm();
        }

    };

}();

jQuery(document).ready(function() {
    received_oil_Form.init();
});


