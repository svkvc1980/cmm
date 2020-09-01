var tender_form = function() {

    var handletender_form = function() {

        $('#tender_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                loose_oil_name:{
                    required: 'Loose Oil cannot be empty'
                },
                plant_id:{
                    required: 'Plant cannot be empty'
                },
                quantity:{
                    required: 'Quantity cannot be empty'
                },
                tender_date:{
                    required: 'Tender Date cannot be empty'
                }
            },
            rules: 
            {
                loose_oil_name: {
                     required: true
                },
                plant_id: {
                       required: true
                },
                quantity: {
                        required: true 
                },
                tender_date: {
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

        $('#tender_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#tender_form').validate().form()) {
                    $('#tender_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handletender_form();
        }

    };

}();

jQuery(document).ready(function() {
    tender_form.init();
});
