var mtp_pm_form = function() {

    var handlemtp_pm_form = function() {

        $('#mtp_pm_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                packing_name:{
                    required: 'Packing Material  cannot be empty'
                },
                plant_name:{
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
                packing_name: {
                     required: true
                },
                plant_name: {
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

        $('#mtp_pm_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#mtp_pm_form').validate().form()) {
                    $('#mtp_pm_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handlemtp_pm_form();
        }

    };

}();

jQuery(document).ready(function() {
    mtp_pm_form.init();
});
