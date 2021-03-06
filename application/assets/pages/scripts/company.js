var companyForm = function() {

    var handlecompanyForm = function() {

        $('#company_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                    company_name: {
                        required: 'Name is required'
                    },
                    start_date: {
                        required: 'Date is required'
                    },
                     branch_name: {
                        required: 'Name is required'
                    },
                     branch_code: {
                        required: 'Branch Code is required'
                    },
                     branch_address: {
                        required: 'Address is required'
                    },
                     region_id: {
                        required: 'Region is required'
                    },
                     country_id: {
                        required: 'Country is required'
                    },
                     state_id: {
                        required: 'State is required'
                    },
                     city_id: {
                        required: 'City is required'
                    }
                },
                rules: {
                    company_name: {
                        maxlength:50,                        
                        required: true
                    },
                    start_date: {
                        required:true
                    },
                    branch_name: {
                        maxlength:50,                        
                        required: true
                    },
                    branch_code: {
                        maxlength:20,                        
                        required: true
                    },
                    branch_address: {
                        maxlength:255,
                        minlength:10,                        
                        required: true
                    },
                    region_id: {                                                
                        required: true
                    },
                    country_id: {                                                
                        required: true
                    },
                    state_id: {                                                
                        required: true
                    },
                    city_id: {                                                
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

        $('#company_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#company_form').validate().form()) {
                    $('#company_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handlecompanyForm();
        }

    };

}();

jQuery(document).ready(function() {
    companyForm.init();
});


