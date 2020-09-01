var FormValidation = function () {

    // basic validation
    var handleValidation1 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form1 = $('#add_employee_form');
            var error1 = $('.alert-danger', form1);
            var success1 = $('.alert-success', form1);

            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                messages: {
                    first_name: {
                        required: 'pllease fill First Name'
                    }
                },
                rules: {
                    first_name: {
                        lettersandspacesonly: true,
                        required: true,
                        minlength:2
                    },
                    father_name: {
                        lettersandspacesonly: true,
                        required: true,
                        minlength:2
                    },
                    last_name: {
                        lettersandspacesonly: true,
                        required: true
                    },
                    middle_name: {
                        lettersandspacesonly: true,
                    },
                    company_email: {
                         email: true,
                         required:true
                    },
                    date_of_joining: {
                        required: true

                    },
                    role_id: {
                        required: true
                    },
                    company_id: {
                        required: true
                    },
                    unit_id: {
                          required: function(element) {
                            return $("#role_id").val() == 7;
                        }   
                    },
                    branch_id: {
                          required: function(element) {
                            return $("#role_id").val() == 7;
                        }   
                    },
                    department_id: {
                          required: function(element) {
                            return $("#role_id").val() == 7;
                        }   
                    },
                    designation_id: {
                          required: function(element) {
                            return $("#role_id").val() == 7;
                        }   
                    },
                    employement_type_id: {
                          required: function(element) {
                            return $("#role_id").val() == 7;
                        }   
                    },                                       
                    ctc: {                        
                        required:true,                        
                    },
                    offer_leter: {
                        required: true
                    },
                    profile_image: {
                        required: true
                    },
                    date_of_birth: {
                        required: true
                    },
                    gender: {
                        required: true
                    },
                    personal_email: {
                        email: true,
                        required:true
                    },
                    mobile_number:{
                        number:true,
                        maxlength:10,
                        minlength:10,
                        required:true
                    },
                    alternate_mobile_number:{
                        digits:true,
                        maxlength:10,
                        minlength:10
                    },
                    blood_group:{
                        required:true
                    },
                     nationality:{
                        required:true
                    },
                    emergency_contact_number:{
                        digits:true,
                        maxlength:10,
                        minlength:10,
                        required:true
                    },
                    aadhar_number:{
                        digits:true,
                        minlength:12,
                        maxlength:12,
                        required:true

                    },
                    pan_card_number:{
                        alphanumeric:true,
                        
                        required:true


                    },
                    present_address:{
                        minlength:20,
                        maxlength:200,
                        required:true
                    },
                    permanent_address:{
                        minlength:20,
                        maxlength:200,
                        required:true
                    },
                    passport_number:{
                        alphanumeric:true
                    },
                     emcont_name:{
                        lettersandspacesonly: true,
                        required: true,
                        minlength:2
                    },
                     emcont_relation:{
                        required:true
                    },
                     passport_expiry_date: {
                          required: function(element) {
                            return $("#passport_number").val() !='';
                        }   
                    },

                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success1.hide();
                    error1.show();
                    App.scrollTo(error1, -200);
                },

                /*errorPlacement: function (error, element) { // render error placement for each input type
                    var cont = $(element).parent('.input-group');
                    if (cont) {
                        cont.after(error);
                    } else {
                        element.after(error);
                    }
                },*/
                errorPlacement: function(error, element) {
                        var icon = $(element).parent('.input-icon').children('i');
                        icon.removeClass('fa-check').addClass("fa-warning");  
                        icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
                },

                highlight: function (element) { // hightlight error inputs

                    $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function(label, element) {
                        var icon = $(element).parent('.input-icon').children('i');
                        $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                        icon.removeClass("fa-warning").addClass("fa-check");
                },

                submitHandler: function (form) {
                    //success1.show();
                    error1.hide();
                    form[0].submit(); // submit the form
                }
            });


    }

    return {
        //main function to initiate the module
        init: function () {

            handleValidation1();

        }

    };

}();

jQuery(document).ready(function() {
    FormValidation.init();
});




