var gate_pass_form = function() {

    var handlegate_pass_form = function() {

        $('#gate_pass_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                "invoice_number[]":{
                    required: 'Invoice No. is Required'
                },
                "waybill_number[]":{
                    required: 'Waybill number is Required'
                }
            },
            rules: 
            {
                "invoice_number[]":{
                    required:true
                },
                "waybill_number[]":{
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

        $('#gate_pass_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#gate_pass_form').validate().form()) {
                    $('#gate_pass_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handlegate_pass_form();
        }

    };

}();

jQuery(document).ready(function() {
    gate_pass_form.init();
});

$('.add_invoice_info').click(function()
{   var counter = 2;
    var ele = $('.invoice_number:eq(0)');  
    var ele_clone = ele.clone();
    ele_clone.find('.value').val('');
    ele_clone.find('.mybutton').remove();
    ele_clone.find('.deletebutton').addClass('show');
    ele_clone.find('div.form-group').removeClass('has-error has-success');
    ele_clone.find('div.input-icon i').removeClass('fa-check fa-warning').addClass('fa');
    // replaces [1] with new counter value [counter] at all name occurances
    ele_clone.html(function(i, oldHTML) {
        return oldHTML.replace(/\[1\]/g, '['+counter+']');
    });

    ele_clone.find('.deletebutton').click(function() {      
        $(this).closest('.invoice_number').remove();
      
    });
    ele.after(ele_clone);
    
});