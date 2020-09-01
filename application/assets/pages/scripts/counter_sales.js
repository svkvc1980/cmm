var counter_sale = function() {

    var handlecounter_sale = function() {

        $('.counter_sale_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                customer_name: {
                    required: true
                },
                denomination:{
                    required:true
                },
                dd_number:{
                    required: true
                },
                bank:{
                    required:true
                }
            },

            messages: {
                customer_name: {
                    required: "Customer Name is required"
                },
                denomination:{
                    required: "denomination is required"
                },
                dd_number:{
                    required: "DD Number is required"
                },
                bank:{
                    required:"Bank is required"
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   
                //$('.alert-danger', $('.reset-form')).show();
            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group,.dummy').addClass('has-error'); // set error class to the control group
            },

            success: function(label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group,.dummy').removeClass('has-error').addClass('has-success'); // set success class to the control group
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

        $('.counter_sale_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('.counter_sale_form').validate().form()) {
                    $('.counter_sale_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handlecounter_sale();
        }

    };

}();

jQuery(document).ready(function() {
    counter_sale.init();
});

$(document).ready(function(){
	var counter=2;
	$(document).on('click','#add',function() {
		
		var ele = $('#sales').find('tbody').find('tr:first');  
    	var ele_clone = ele.clone();
    	ele_clone.find('input, select').attr("disabled", false).val('');
	    ele_clone.find('td div.form-group').removeClass('has-error has-success');
	    ele_clone.find('td div.input-icon i').removeClass('fa-check fa-warning');
	    ele_clone.find(".amount").html('');
	    ele_clone.find('.add').hide();
	    ele_clone.find('.remove').show();
        ele_clone.find('.product').change('');
        ele_clone.find('td div.sale_qty').removeClass('has-error has-success');
        ele_clone.find('td div.dummy').removeClass('has-error has-success');
	    // replaces [1] with new counter value [counter] at all name occurances
	    ele_clone.html(function(i, oldHTML) {
	        return oldHTML.replace(/\[1\]/g, '['+counter+']');
	    });

	    $('.sales_row:last').after(ele_clone)
	    ele_clone.show();
	    counter++;
	    return false;  		
	});
});

$(document).on('click','#remove',function() {      
    $(this).closest('tr').remove();
    calculate();
    den();
});

$(document).on("blur",".price,.qty",function(){

	var price = $(this).closest("tr").find(".price").val().replace(/\,/g, "");
	price = parseFloat(price);

	var qty = $(this).closest("tr").find(".qty").val().replace(/\,/g, "");
	qty = parseFloat(qty);

	var amount = price * qty;
	$(this).closest("tr").find(".amount").html(amount);
	$(this).closest("tr").find(".amount1").val(amount);
	calculate();

	var denomination = $('#den').val();
	if(denomination!='')
	{
		den();
	}
	
});

function den()
{
	var denomination = $('#den').val().replace(/\,/g, "");
	denomination = parseFloat(denomination);

	var total=parseFloat($('#total').html());
	var pay_customer = denomination - total;	
	$('#pay_customer').html(pay_customer);
	$('#pay_customer1').val(pay_customer);
}

$('#den').change(function(){

	den();
});

function calculate()
{
	var total = 0;
    $('.amount').each(function(){
    	
    	var amount = $(this).html();
    	if(amount != "")
    	{
    		amount = parseFloat(amount);
    		total+=amount;
    	}
    });
    $("#total").html(total);
    $("#total1").val(total)			
}

$(document).on("change","#paymode",function()
{
	if ($(this).val() == 1) 
	{
		$('.dd').hide();
        $('.denom').show();
    }
    else
    {
    	$('.denom').hide();
    	$('.dd').show();
    }
});

$(document).on('change','.product',function(){
    var ele_clone = $(this).closest('tbody tr');
    var product = ele_clone.find('.product').val();

    if(product != '')
    {
        $.ajax({
            type:"POST",
            url:SITE_URL+'get_counter_stock_in_counter_sale',
            data:{product:product},
            cache:false,
            success:function(html){
                ele_clone.find('.available_qty').val(html);
                ele_clone.find('.qty').attr('max', html);
                ele_clone.find('.qty').val('');
                ele_clone.find('.qty').prev('i').removeClass('fa-check');
                ele_clone.find('.qty').closest('td div.sale_qty').removeClass('has-error has-success');
            }
        });
         $.ajax({
            type:"POST",
            url:SITE_URL+'get_raithu_bazar_price',
            data:{product:product},
            cache:false,
            success:function(html){
                
                ele_clone.find('.price').val(html);
                ele_clone.find('.price').attr(html);
                ele_clone.find('.price').prev('i').removeClass('fa-check');
                ele_clone.find('.price').closest('td div.dummy').removeClass('has-error has-success');
            }
        });
    }
    else
    {
        ele_clone.find('.available_qty').val('');
        ele_clone.find('.qty').val('');

        ele_clone.find('.price').val('');
        ele_clone.find('.price').val('');
    }

    
        
});

$(document).on('blur','.qty',function(){
    var ele_clone = $('#sales').find('tbody').find('tr:first');
    var avail_qty = ele_clone.find('.available_qty').val();
    var qty = ele_clone.find('.qty').val();
    if(avail_qty != '' && qty != '')
    {
        if(qty > avail_qty)
        {
            ele_clone.find('.qty').closest('td div.sale_qty').addClass('has-error');
            return false;
        }
    }
});