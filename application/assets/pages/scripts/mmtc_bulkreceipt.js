var mmtc_bulkreceiptForm = function() {

    var handlemmtc_bulkreceiptForm = function() {

        $('#mmtc_bulkreceipt').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                    oil_name: {
                        required: 'Name is required'
                    },
                    received_date: {
                        required: ' Received Date is required'
                    },
                    received_quantity: {
                        required: 'Received Quantity is required'
                    },
                    vessel_number: {
                        required: 'Vessel Number  is required'
                    }
                },
                rules: {
                    oil_name: {
                                                
                        required: true
                    },
                    received_date: {
                        required: true
                    },
                    received_quantity: {
                        required: true
                    },
                    vessel_number: {
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

        $('#mmtc_bulkreceipt_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#mmtc_bulkreceipt_form').validate().form()) {
                    $('#mmtc_bulkreceipt_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handlemmtc_bulkreceiptForm();
        }

    };

}();

jQuery(document).ready(function() {
    mmtc_bulkreceiptForm.init();
});


