$("#checkAll").change(function(){ 
    $(".checkSingle").prop('checked', $(this).prop("checked"));
});

$('.checkSingle').change(function(){ 

    if(false == $(this).prop("checked"))
    {
        $("#checkAll").prop('checked', false);
    }
   
    if ($('.checkSingle:checked').length == $('.checkSingle').length)
    {
        $("#checkAll").prop('checked', true);
    }
});

$('.adv_sal_submit').click(function(){
    var error = false;
	$('.checkSingle').each(function(){
    	if($(this).is(':checked'))
    	{
            var ele_parent = $(this).closest('tr');
            var amount_limit = ele_parent.find('#amount_limit');
            var amount = ele_parent.find('.amount');
            amount.next().remove();
            if(amount.val()=="")
            {
                amount.after('<span class="limit_error" style="color:red;">Required</span>');
                error = true;  
            }
            if(parseInt(amount.val()) > parseInt(amount_limit.val()))
            {
                amount.after('<span class="limit_error" style="color:red;">Limit exceeds</span>');
                error = true;  
            }
    	}  
	});
	if(error)
	{
        return false;
	}	
});