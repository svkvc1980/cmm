$(document).ready(function(){
	
});
var counter=2; var i = 1;
$('#add').click(function(){
	var ele = $('#insurance').find('tbody').find('tr:first');  
    	var ele_clone = ele.clone();
    	var pcount = ele_clone.find('.product_count').val();
    	if(i < pcount)
    	{
    		i++;
    		ele_clone.find('input, select').attr("disabled", false).val('');
		    ele_clone.find('td div.ip').removeClass('has-error has-success');
		    ele_clone.find('td div.input-icon i').removeClass('fa-check fa-warning');
		    ele_clone.find('.span').hide();
		    ele_clone.find('.add').hide();
		    ele_clone.find('.remove').show();
	        ele_clone.find('.product').change('');
		    // replaces [1] with new counter value [counter] at all name occurances
		    ele_clone.html(function(i, oldHTML) {
		        return oldHTML.replace(/\[1\]/g, '['+counter+']');
		    });

		    $(document).on('click','#remove',function() {      
			    $(this).closest('tr').remove();
			    i--;
			});

		    $('.ins_row:last').after(ele_clone)
		    ele_clone.show();
		    counter++;
		    return false;
    	}
    	else
    	{
    		return false;
    	}
})

$(document).on('change','.product',function(){
   	var ele_clone = $(this).closest('table tbody .ins_row');
	var product = ele_clone.find('.product').val();

    if(product != '')
	{
		$.ajax({
            type:"POST",
            url:SITE_URL+'get_oil_weight',
            data:{product:product},
            cache:false,
            success:function(html){
            	var arr = jQuery.parseJSON(html);
                ele_clone.find('.oil_weight').val(arr['oil_weight']);
                ele_clone.find('.leaked_pouches').val('');
		        ele_clone.find('.recovered_oil').val('');
				ele_clone.find('.net_loss').val('');
				ele_clone.find('.net_loss_amount').val('');
            }
        });
	} 
	else
	{
		ele_clone.find('.leaked_pouches').val('');
		ele_clone.find('.recovered_oil').val('');
		ele_clone.find('.net_loss').val('');
		ele_clone.find('.net_loss_amount').val('');
	}
});

$(document).on('keyup','.leaked_pouches,.recovered_oil',function() {
	var ele_clone = $(this).closest('table tbody .ins_row');
	ele_clone.find('.net_loss').val('');
    ele_clone.find('.net_loss_amount').val('');
	var oil_weight = ele_clone.find('.oil_weight').val();
	var leaked_pouches = ele_clone.find('.leaked_pouches').val();
	var leaked_weight = oil_weight*leaked_pouches;
	var recovered_oil = ele_clone.find('.recovered_oil').val();
	var price = ele_clone.find('.price').val();
	var net_loss = (leaked_pouches*oil_weight)-recovered_oil;
	var net_amount = (price/oil_weight)*net_loss;

	if(recovered_oil != '' && leaked_weight != '')
	{ 
		if(parseInt(recovered_oil) > parseInt(leaked_weight))
		{
			ele_clone.find('.recovered_oil').closest('div.ip').addClass('has-error');
			ele_clone.find('.span').show();
			ele_clone.find('.net_loss').val('');
		    ele_clone.find('.net_loss_amount').val('');
		    return false;
		}
		else
		{
			ele_clone.find('.recovered_oil').closest('div.ip').removeClass('has-error');
			ele_clone.find('.span').hide();
			ele_clone.find('.net_loss').val(net_loss.toFixed(2)); ele_clone.find('.net_loss_amount').val(net_amount.toFixed(2));
		}
	}
	//return false;
});

$(document).on('change','.product',function(){
	var ele_clone = $(this).closest('table tbody .ins_row');
	var leaked_pouches = ele_clone.find('.leaked_pouches').val();
	var rec_oil = ele_clone.find('.recovered_oil').val();
	var product = ele_clone.find('.product').val();
	var invoice_id = $('.invoice_id').val();
   
	$.ajax({
        type:"POST",
        url:SITE_URL+'get_product_price',
        data:{product:product, invoice_id:invoice_id},
        cache:false,
        success:function(html){
        	 alert(html);
        	 var arr = jQuery.parseJSON(html);
        	ele_clone.find('.price').val(arr['product_price']);
        	ele_clone.find('.invoice_product').val(arr['invoice_do_product_id']);
        }
    });
});

$(document).on('click','.submit',function(){
	var ele_clone = $(this).closest('table tbody .ins_row');
	var oil_weight = ele_clone.find('.oil_weight').val();
	var leaked_pouches = ele_clone.find('.leaked_pouches').val();
	var leaked_weight = oil_weight*leaked_pouches;
	var recovered_oil = ele_clone.find('.recovered_oil').val();

	if(parseInt(recovered_oil) > parseInt(leaked_weight))
		{
			ele_clone.find('.recovered_oil').closest('div.ip').addClass('has-error');
			ele_clone.find('.span').show();
			ele_clone.find('.net_loss').val('');
		    ele_clone.find('.net_loss_amount').val('');
		    return false;
		}
		else
		{
			return true;
		}
});
