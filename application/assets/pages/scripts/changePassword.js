var changePassword = function() {

    var handlechangePassowrd = function() {

        $('.changePassword-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                oldPassword: {
                    required: true,
                    maxlength: 20
                },
                newPassword: {
                    required: true,
                    minlength: 6,
                    maxlength: 20
                },
                cnewPassword: {
                    required: true,
                    equalTo: "#newPassword",
                    minlength: 6,
                    maxlength: 20
                },
            },

            messages: {
                oldPassword: {
                    required: "Old Password cannot be empty."
                },
                newPassword: {
                    required: "New Password cannot be empty."
                },
                cnewPassword: {
                    required: "Confirm Password cannot be empty."
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

        $('.changePassword-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.changePassword-form').validate().form()) {
                    $('.changePassword-form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handlechangePassowrd();
        }

    };

}();

jQuery(document).ready(function() {
    changePassword.init();
});