var leakages_form = function() {

    var handleleakages_form = function() {

        $('#leakages_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                    
                    product_code: {
                        required: 'product code code is required'
                    },
                    leakage_date: {
                        required: 'leakage date is required'
                    },
                    leakage_qunatity: {
                        required: 'leakage qunatity is required'
                    },
                    unit_name: {
                        required: 'unit name is required'
                    }
                },
                rules: {
                    
                    product_code: {
                        required: true
                    },
                    leakage_date: {
                                                
                        required: true
                    },
                    leakage_qunatity: {
                        required: true
                    },
                    unit_name: {                                                
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

        $('#leakages_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#leakages_form').validate().form()) {
                    $('#leakages_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handleleakages_form();
        }

    };

}();

jQuery(document).ready(function() {
    leakages_form.init();
});


