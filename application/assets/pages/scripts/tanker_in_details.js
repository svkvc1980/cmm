var tankerin = function() {

    var handletankerin = function() {

        $('.tanker_in_details').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                    vehicle_no: {
                    required: true
                },
                loose_oil_id:{
                    required:true
                },
                invoice_no:{
                    required:true
                },
                invoice_qty:{
                    required:true
                },
                gross:{
                    required:true
                },
                tier:{
                    required:true
                },
                free_gift_id:{
                    required:true
                },
                party_name:{
                    required:true
                },
                pm_id:{
                    required:true
                },
                broker_name:{
                    required:true
                }
            },

            messages: {
                    vehicle_no: {
                    required: "Vehicle Number is required"
                },
                loose_oil_id:{
                    required:"Oil is required"
                },
                invoice_no:{
                    required:"invoice no. is required"
                },
                invoice_qty:{
                    required:"invoice quantity is required"
                },
                gross:{
                    required:"Invoice gross is required"
                },
                tier:{
                    required:"Invoice tier is required"
                },
                free_gift_id:{
                    required:"Free Gift is required"
                },
                party_name:{
                    required:"Party Name is required"
                },
                pm_id:{
                    required:"Packing Material is required"
                },
                broker_name:{
                    required:"Broker Name is required"
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

        $('.tanker_in_details input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('.tanker_in_details').validate().form()) {
                    $('.tanker_in_details').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handletankerin();
        }

    };

}();

jQuery(document).ready(function() {
    tankerin.init();
    $('.gross_tare').hide();
});

$(document).on('change','.pm_id',function(){
    var pm_category = $(this).find('option:selected').data('pm-category');
    if(pm_category == 1)
    {
        $('.invoice_qty').html('Invoice Qty(Kgs) <span class="font-red required_fld">*</span>');
        $('.gross_tare').show();
    }
    else
    {
        $('.invoice_qty').html('Invoice Qty <span class="font-red required_fld">*</span>');
        $('.gross_tare').hide();
    }
})