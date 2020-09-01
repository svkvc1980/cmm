var add_secondary_infoForm = function() {

    var handlefamily_detailsForm = function() {

        $('#family_details_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                    'age[]': {
                        required: 'required'
                    },
                    'name[]': {
                        required: 'required'
                    },
                    'gender[]': {
                        required: 'required'
                    },
                    'relation[]': {
                        required: 'required'
                    },
                    'occupation[]': {
                        required: 'required'
                    },
                    'contact_number[]': {
                        required: 'required'
                    }
                },
                rules: {
                    'age[]': {                        
                        required: true,
                        maxlength:3
                    },
                    'name[]': {                        
                        required: true,
                        lettersandspacesonly:true,
                        minlength:2
                    },
                    'gender[]': {                        
                        required: true
                        
                    },
                    'relation[]': {                        
                        required: true
                        
                    },
                    'occupation[]': {                        
                        required: true,
                        minlength:3
                    },
                    'contact_number[]': {                        
                        required: true,
                        number:true,
                        minlength:10,
                        maxlength:10
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

        $('#family_details_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#family_details_form').validate().form()) {
                    $('#family_details_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }

    var handlebank_infoForm = function() {

        $('#bank_info_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                    'bank_name[]': {
                        required: 'required'
                    },
                    'name_on_account[]': {
                        required: 'required'
                    },
                    'account_number[]': {
                        required: 'required'
                    },
                    'ifsc_code[]': {
                        required: 'required'
                    },
                    'account_type[]': {
                        required: 'required'
                    }
                },
                rules: {
                    'bank_name[]': {                        
                        required: true,
                        lettersandspacesonly:true
                    },
                    'name_on_account[]': {                        
                        required: true,
                        lettersandspacesonly:true
                    },
                    'account_number[]': {                        
                        required: true,
                        number:true                       
                    },
                    'ifsc_code[]': {                        
                        required: true                        
                    },
                    'account_type[]': {                        
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

        $('#bank_info_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#bank_info_form').validate().form()) {
                    $('#bank_info_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }

    var handlepre_orgForm = function() {

        $('#pre_org_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                    'pre_org_name[]': {
                        required: 'required'
                    },
                    'from_date[]': {
                        required: 'required'
                    },
                    'to_date[]': {
                        required: 'required'
                    },
                    'designation[]': {
                        required: 'required'
                    },
                    'reporting_manager_details[]': {
                        required: 'required'
                    },
                    'emp_references[]': {
                        required: 'required'
                    },
                    'reason_for_leaving[]': {
                        required: 'required'
                    },
                    'ctc[]': {
                        required: 'required'
                    }
                },
                rules: {
                    'pre_org_name[]': {                        
                        required: true
                    },
                    'from_date[]': {                        
                        required: true
                    },
                    'to_date[]': {                        
                        required: true                        
                    },
                    'designation[]': {                        
                        required: true                        
                    },
                    'reporting_manager_details[]': {                        
                        required: true
                    },
                    'emp_references[]': {                        
                        required: true
                    },
                    'reason_for_leaving[]': {                        
                        required: true
                    },
                    'ctc[]': {                        
                        required: true,
                        number:true
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

        $('#pre_org_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#pre_org_form').validate().form()) {
                    $('#pre_org_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }

    var handlecertificationForm = function() {

        $('#certification_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                    'certification_name[]': {
                        required: 'required'
                    },
                    'institute_name[]': {
                        required: 'required'
                    },
                    'grade[]': {
                        required: 'required'
                    },
                    'from_date[]': {
                        required: 'required'
                    },
                    'to_date[]': {
                        required: 'required'
                    }
                },
                rules: {
                    'certification_name[]': {                        
                        required: true,
                        lettersonly:true
                    },
                    'institute_name[]': {                        
                        required: true,
                        lettersonly:true                        
                    },
                    'grade[]': {                        
                        required: true
                        
                    },
                    'from_date[]': {                        
                        required: true
                        
                    },
                    'to_date[]': {                        
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

        $('#certification_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#certification_form').validate().form()) {
                    $('#certification_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }

    var handleeducationForm = function() {

        $('#education_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                    'qualification[]': {
                        required: 'required'
                    },
                    'institute_name[]': {
                        required: 'required'
                    },
                    'board_of_education[]': {
                        required: 'required'
                    },
                    'year_of_passing[]': {
                        required: 'required'

                    },
                    'percentage[]': {
                        required: 'required'
                    }
                },
                rules: {
                    'qualification[]': {                        
                        required: true
                    },
                    'institute_name[]': {                        
                        required: true
                    },
                    'board_of_education[]': {                        
                        required: true                        
                    },
                    'year_of_passing[]': {                
                        required: true,
                        number:true,
                        minlength:4,
                        maxlength:4                        
                    },
                    'percentage[]': {                        
                        required: true,
                        min:0,
                        max:100
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

        $('#education_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#education_form').validate().form()) {
                    $('#education_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }

    var handleadditionalForm = function() {

        $('#additional_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                    
                    
                    'voter_id': {
                        required: 'numbers only'
                    }
                },
                rules: {
                    
                    
                    'voter_id': {                        
                        number: true                        
                    },
                    'alternate_mobile_number': {                        
                        number: true,
                        minlength:10,
                        maxlength:10                        
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

        $('#additional_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#additional_form').validate().form()) {
                    $('#additional_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }
    return {
        //main function to initiate the module
        init: function() {
            handlefamily_detailsForm();
            handlebank_infoForm();
            handlepre_orgForm();
            handlecertificationForm();
            handleeducationForm();
            handleadditionalForm();
        }

    };

}();

jQuery(document).ready(function() {
    add_secondary_infoForm.init();
});


