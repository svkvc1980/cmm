var oil_form = function() {

    var handleoil_form = function() {

        $('#oil_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
               loose_oil_name:{
                    required: 'Loose Oil cannot be empty'
                },
                po_type:{
                    required: 'PO Type cannot be empty'
                },
                broker_name:{
                    required: 'Broker cannot be empty'
                },
                supplier_name:{
                    required: 'Supplier cannot be empty'
                },
                plant_id:{
                    required: 'Plant cannot be empty'
                },
                qty:{
                    required: 'Quantity cannot be empty'
                },
                rate:{
                    required: 'Rate cannot be empty'
                },
                quantity1:{
                    required: 'Quantity cannot be empty'
                }
            },
            rules: 
            {
               loose_oil_name: {
                     required: true
                },
                po_type: {
                     required: true
                },
                broker_name: {
                     required: true
                },
                supplier_name: {
                     required: true
                },
                plant_id: {
                       required: true
                },
                qty: {
                        required: true
                },
                rate: {
                        required: true
                },
                quantity1:{
                    required:true
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

        $('#oil_form input').keypress(function(e) {
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
            handleoil_form();
        }

    };

}();

jQuery(document).ready(function() {
    oil_form.init();
});
