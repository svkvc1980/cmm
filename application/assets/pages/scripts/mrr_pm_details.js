var mrr_loose_oil = function() {

    var handlemrr_loose_oil = function() {

        $('.mrr_loose_oil').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                 tanker_number: {
                    required: "Tanker number is required"
                },
                po_number: {
                    required: "PO number is required"
                },
                folio_number: {
                    required: "Folio number is required"
                },
                 ledger_number: {
                    required: "Ledger number is required"
                },
                received_qty: {
                    required: "Received qty is required"
                },
                micron: {
                    required: "micron is required"
                },
                core_weight: {
                    required: "core weight is required"
                },
               carton_weight: {
                    required: "carton weight is required"
                },
                rolls: {
                    required: "Roll weight is required"
                }
            },
            rules: 
            {
                tanker_number: {
                    required: true
                },
                 folio_number: {
                    required: true
                }, 
                ledger_number: {
                    required: true
                },
                po_number: {
                    required: true
                }, 
               received_qty: {
                    required: true
                } ,
              micron : {
                required : true
              },
             core_weight : {
                required : true
              },
              rolls : {
                required : true
              },
              carton_weight : {
                required : true
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

        /*$('.mrr_loose_oil input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('.mrr_loose_oil').validate().form()) {
                    $('.mrr_loose_oil').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });*/
    }




    return {
        //main function to initiate the module
        init: function() {
            handlemrr_loose_oil();
        }

    };

}();

jQuery(document).ready(function() {
    mrr_loose_oil.init();
});