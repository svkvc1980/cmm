var leakageForm = function() {

    var handleleakageForm = function() {

        $('#leakage_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                    
                     no_of_pouches: {
                        required: 'leaked pouches are required'
                    },
                     no_of_cartons: {
                        required: 'leaked cartons are required'
                    },
                     product_id: {
                        required: 'Product is required'
                    },
                     recovered_oil: {
                        required: 'Recovered oil is required'
                    },
                    cartons: {
                        required: 'recovered cartons are required'
                    },
                    pouches :{
                         required: 'recovered pouches are required'
                    }
                },
                rules: {
                    
                    no_of_pouches: {
                        required: true
                    },
                    no_of_cartons: {
                        required: true
                    },
                    product_id: {
                                                
                        required: true
                    },
                    recovered_oil: {                                                
                        required: true
                    },
                    pouches: {
                        required: true
                    },
                    cartons: {
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

        $('#branch_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#branch_form').validate().form()) {
                    $('#branch_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handleleakageForm();
        }

    };

}();

jQuery(document).ready(function() {
    leakageForm.init();
});


