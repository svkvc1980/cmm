var po_pm_form = function() {

    var handlepo_pm_form = function() {

        $('#po_pm_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                broker_name:{
                    required: 'Broker cannot be empty'
                },
                supplier_name:{
                    required: 'Supplier cannot be empty'
                },
                quantity:{
                    required: 'Quantity cannot be empty'
                },
                rate:{
                    required: 'Rate cannot be empty'
                },
            },
            rules: 
            {
                broker_name: {
                     required: true
                },
                supplier_name: {
                     required: true
                },
                quantity: {
                        required: true
                },
                rate: {
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

        $('#po_pm_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#po_pm_form').validate().form()) {
                    $('#po_pm_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handlepo_pm_form();
        }

    };

}();

jQuery(document).ready(function() {
    po_pm_form.init();
});
