var weigh_bridge_form = function() {

    var handleweigh_bridge_form = function() {

        $('.weighbridge_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                    
                     freegift_tanker_id: {
                        required: 'Name is required'
                    },
                     freegift_gross: {
                        required: 'gross weight is required'
                    },
                     freegift_tier: {
                        required: 'tier weight is required'
                    }
                },
                rules: {
                    
                    freegift_tanker_id: {
                     required: true
                    },
                    freegift_gross: {                        
                        required: true
                    },
                    freegift_tier: {                        
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

        $('.weighbridge_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('.weighbridge_form').validate().form()) {
                    $('.weighbridge_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handleweigh_bridge_form();
        }

    };

}();

jQuery(document).ready(function() {
    weigh_bridge_form.init();
});


