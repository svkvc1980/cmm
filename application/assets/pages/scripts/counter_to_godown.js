var counter = function() {

    var handlecounter = function() {

        $('#counter_to_godown').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                'product[]':{
                    required: 'Product is required'
                },
                'trans_qty[]':{
                    required: 'Transfer Quantity is required'
                }
            },
            rules: 
            {
                'product[]': {
                     required: true
                },
                'trans_qty[]': {
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

        $('#counter_to_godown input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#counter_to_godown').validate().form()) {
                    $('#counter_to_godown').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handlecounter();
        }

    };

}();
jQuery(document).ready(function() {
    counter.init();
});

$(document).ready(function(){
	$(document).on('click','#add',function() {
		var ele = $("#godown").find('div.stock_row:last');
		var ele_clone = ele.clone();
		ele_clone.find('input').val('');
		ele_clone.find('div.form-group').removeClass('has-error has-success');
		ele_clone.find('div.input-icon i').removeClass('fa-check fa-warning').addClass('fa');
		ele_button = ele_clone.find('button');
		ele_button.removeClass('blue').addClass('red');
		ele_button.attr('id','remove');
		ele_button.attr('value','REMOVE');
		ele_button.find('i').removeClass('fa-plus').addClass('fa-trash-o');
		ele_button.find('.stock').remove();
		
		ele_button.click(function(){
			$(this).closest('div.stock_row').remove();
		});

		ele.after(ele_clone);
	});
});

$(document).on('change','.product',function(){
   	var ele_clone = $(this).closest('div.stock_row');
	var product = ele_clone.find('.product').val();
	if(product != '')
	{
		$.ajax({
            type:"POST",
            url:SITE_URL+'get_counter_stock',
            data:{product:product},
            cache:false,
            success:function(html){
                ele_clone.find('.stock').val(html);
                ele_clone.find('.trans_qty').attr('max', html);
                ele_clone.find('.trans_qty').val('');
                ele_clone.find('.trans_qty').prev('i').removeClass('fa-check');
                ele_clone.find('.trans_qty').closest('div.form-group').removeClass('has-error has-success');
            }
        });
	}
	else
	{
		ele_clone.find('.stock').val('');
		ele_clone.find('.trans_qty').val('');
	}
        
});

$(document).on('blur','.trans_qty',function(){
	var ele_clone = $(this).closest('div.stock_row');
	var avail_qty = ele_clone.find('.stock').val();
	var trans_qty = ele_clone.find('.trans_qty').val();
	if(avail_qty != '' && trans_qty != '')
	{
		if(trans_qty > avail_qty)
		{
			ele_clone.find('.trans_qty').closest('div.form-group').addClass('has-error');
			return false;
		}
	}
});