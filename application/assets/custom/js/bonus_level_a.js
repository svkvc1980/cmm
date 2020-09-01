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

$('.bonus_submit').click(function(){
    var error = false;
	$('.checkSingle').each(function(){
    	if($(this).is(':checked'))
    	{
            var ele_parent = $(this).closest('tr');
            var ele_bonus_amount = ele_parent.find('.bonus_amount');
            var ele_bonus_reason = ele_parent.find('.reason');
            var ele_array = [ele_bonus_amount, ele_bonus_reason];
            $.each(ele_array, function( index, value ) 
            {
                value.next().remove();
                value.css('border-color','');
                if(value.val()=="")
                {
                    value.css('border-color','red');
                    value.after('<span class="bonus_error" style="color:red;">* Required</span>');
                    error = true;
                }
            });
    	}

	});
	if(error)
	{
        return false;
	}	
});