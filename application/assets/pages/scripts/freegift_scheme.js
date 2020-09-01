$(document).on('click','#add_new',function(){
    var ele = $('.well:last');
    var ele_clone = ele.clone();
    ele_clone.find('.div_remove').show();
    ele_clone.find('.test_sno').text($('.well').length+1+' )');
    ele_clone.find('input').val('');
    ele_clone.find('div.form-group').removeClass('has-success has-error');
    ele_clone.find('div.input-icon i ').removeClass('fa-check fa-warning').addClass('fa');
    ele.after(ele_clone);
    ele_clone.find('.gift_type').change();
});

$(document).on('click','.deletebutton',function() {
    $(this).parents('.well').remove(); 
    var sno=1; 
    $('.test_sno').each(function(){
        $(this).html(sno+')');
        sno++;
    });                    
});
$(document).on('change','.gift_type',function(){
    var get_id = $(this).val();
    var ele_parent = $(this).closest('.well');
    var horizontal = ele_parent.find('.horizontal');
    var packedproduct = ele_parent.find('.packedproduct');
    var freegift = ele_parent.find('.freegift');

    if(get_id==1)
    {
        horizontal.show();
        packedproduct.show();
        freegift.hide();
    }
    else if(get_id==2)
    {
        horizontal.show();
        freegift.show();
        packedproduct.hide();
    }
    else
    {
        horizontal.hide();
        freegift.hide();
        packedproduct.hide();   
    }
});
