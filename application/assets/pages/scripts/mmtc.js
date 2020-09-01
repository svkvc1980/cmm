var max_limit =3;
var x =1;
$('#add_order_info').click(function()
{
    
    if(x < max_limit)
    {
        x++;
        var ele = $('.order_number:eq(0)');  
        var ele_clone = ele.clone();
        ele_clone.find('.mylabel').text('');
        ele_clone.find('.value').val('');
        ele_clone.find('.mybutton').remove();
        ele_clone.find('.deletebutton').addClass('show');
        
        ele_clone.find('.deletebutton').click(function() {      
            $(this).closest('.order_number').remove();
            x--;
        });
        ele.after(ele_clone);
    }
});