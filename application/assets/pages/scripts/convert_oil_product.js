var counter = function() {

    var handlecounter = function() {

        $('#form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                loose_oil:{
                    required: 'Loose Oil is required'
                }
            },
            rules: 
            {
                loose_oil: {
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

        $('#form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#form').validate().form()) {
                    $('#form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }
    var handleoil_product = function() {

        $('#oil_recover').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                'product[]':{
                    required: 'Product is required'
                },
                'loose_type[]':{
                    required: 'Loose Items is required'
                }
            },
            rules: 
            {
                'product[]': {
                     required: true
                },
                'loose_type[]': {
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

        $('#oil_recover input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#oil_recover').validate().form()) {
                    $('#oil_recover').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handlecounter();
            handleoil_product();
        }

    };

}();
jQuery(document).ready(function() {
    counter.init();
});

$('.add_invoice_info').click(function()
{   var counter = 2;
    var ele = $('.invoice_number:eq(0)');
    var ele_clone = ele.clone();
    ele_clone.find('.mylabel').text('');
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
$('.validate_weight').click(function(){
    var product=$('.product').val();
    var quantity=$('.quantity').val();
    var oil_weight=$('.oil_wt_cls').val();
    var type=$('.type').val();
    var total=0;
    $('.type').each(function(){
    
    var multiply=type*oil_weight;
    total +=multiply;
    });
    if(total>quantity)
    {
        alert("Oil Weight Is Exceeded");
    }

});
$(document).on('change','.product_id',function(){
    var ele = $(this).parents('.invoice_number');
    var oil_weight = $(this).find('option:selected').data('oil-weight');
    $('.oil_wt_cls').val(oil_weight);

});
