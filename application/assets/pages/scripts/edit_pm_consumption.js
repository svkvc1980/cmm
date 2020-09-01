
$(document).ready(function(){
   $('.test_sno1').html(sno1+')');
   $('.test_sno2').html(sno2+')');
});
$(document).on('change','.pm_id1_cls',function(){
    ele = $(this).parents('.testdiv1');
    var u_type = ele.find($(this)).find('option:selected').data('p-type1');
    //var c_id = ele.find($(this)).find('option:selected').data('c-type1');
    //alert(c_id);   
    //ele.find(".capacity1_cls").val(c_id);     
    ele.find(".u_type1").html(u_type);    
});

$(document).on('change','.pm_id2_cls',function(){
    ele = $(this).parents('.testdiv2');
    var u_type = ele.find($(this)).find('option:selected').data('p-type2');
    //var c_id = ele.find($(this)).find('option:selected').data('c-type2');
    //alert(c_id);   
    //ele.find(".capacity2_cls").val(c_id);     
    ele.find(".u_type2").html(u_type);    
});


$(document).on('click','.mybutton1',function(){
   // alert('hiii');
    ele_clone = $(this).parents('.testdiv1:first').clone();
    ele_clone.find('.deletebutton_div1').removeClass('hidden');
    ele_clone.find('.mybutton_div1').remove();

    var sno= $('.test_sno1').length+sno1;
    ele_clone.find('.test_sno1').html(sno+')');
    ele_clone.find('input,select').val('');    
    ele_clone.find('.u_type1').html('');    
    $('.testdiv1:last').after(ele_clone);
});
$(document).on('click','.deletebutton1',function() {  
    var ele=$(this).parents('.testdiv1');
    ele.find(this).closest('.testdiv1').remove();
     
    $('.test_sno1').each(function(){
        $(this).html(sno1+')');
        sno1++;
    });                        
});


$(document).on('click','.mybutton2',function(){
   // alert('hiii');
    ele_clone = $(this).parents('.testdiv2:first').clone();
    ele_clone.find('.deletebutton_div2').removeClass('hidden');
    ele_clone.find('.mybutton_div2').remove();
    var sno= $('.test_sno2').length+sno2;
    ele_clone.find('.test_sno2').html(sno+')');
    ele_clone.find('input,select').val('');
    ele_clone.find('.u_type2').html('');     
    $('.testdiv2:last').after(ele_clone);
});
$(document).on('click','.deletebutton2',function() {  
    var ele=$(this).parents('.testdiv2');
    ele.find(this).closest('.testdiv2').remove();
    //var sno=; 
    $('.test_sno2').each(function(){
        $(this).html(sno2+')');
        sno2++;
    });                        
});


