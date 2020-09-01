

$(document).on('change','.range_type',function() {
    var range_type_id=$(this).val();
    //alert(range_type_id);


    var ele=$(this).parents('.testdiv');

    var tbele=ele.find('.textbox');

    if(range_type_id==1)
    {        
        tbele.removeClass('hidden');
        tbele.find('.lower_limit').val('');
        tbele.find('.upper_limit').val('');
        tbele.find('.lower_check_val').removeAttr('checked',false);  
        tbele.find('.upper_check_val').removeAttr('checked',false);  
        ele.find('.radio_dropdown').addClass('hidden');
        ele.find('.exactvalue').addClass('hidden');

        // Remove values in radio or dropdown
        ele.find('.radio_dropdown').find('.key_value_div').not('.key_value_div:first').remove();
        ele.find('.radio_dropdown').find('.specification_val').val('');
        ele.find('.radio_dropdown').find('.key_value_div').find('.key').val('');            
        ele.find('.radio_dropdown').find('.key_value_div').find('.value').val('');     
    }
    else
    {
        if(range_type_id==4)
        {
            ele.find('.exactvalue').removeClass('hidden');
            ele.find('.textbox').addClass('hidden');            
            ele.find('.radio_dropdown').addClass('hidden'); 
            ele.find('.exactvalue').find('.exact_val').val('');
            

            // removing values in text box
            tbele.find('.lower_limit').val('');
            tbele.find('.upper_limit').val('');
            tbele.find('.lower_check_val').removeAttr('checked',false);  
            tbele.find('.upper_check_val').removeAttr('checked',false); 

            // Remove values in radio or dropdown
            ele.find('.radio_dropdown').find('.key_value_div').not('.key_value_div:first').remove();
            ele.find('.radio_dropdown').find('.specification_val').val('');
            ele.find('.radio_dropdown').find('.key_value_div').find('.key').val('');            
            ele.find('.radio_dropdown').find('.key_value_div').find('.value').val('');   

             
        }
        else
        {
            //ele.find('.deletebutton_div').removeClass('hidden');
            var tbele=ele.find('.textbox');            
            // removing values in text box
            tbele.find('.lower_limit').val('');
            tbele.find('.upper_limit').val('');
            tbele.find('.lower_check_val').removeAttr('checked',false);  
            tbele.find('.upper_check_val').removeAttr('checked',false); 

            ele.find('.radio_dropdown').removeClass('hidden');
            ele.find('.textbox').addClass('hidden');
            ele.find('.exactvalue').addClass('hidden');
            ele.find('.radio_dropdown').find('.key_value_div').not('.key_value_div:first').remove();

            /*var first_option_id = ele.find('.radio_dropdown').find('.key_value_div:first').find('.edit_option_id:first').val();
            ele_clone.find('.edit_option_id').attr('name','new_options['+option_counter+']').val(option_counter);*/

            
            var first_option_id = $('.edit_option_id:first').val();

            //alert(first_option_id);
            option_counter=1;
            var ele_opt = ele.find('.radio_dropdown');
            ele_opt.find('.edit_option_id').attr('name','new_options['+option_counter+']').val(option_counter);

            pattern = new RegExp('\\\['+first_option_id+'\\\]', 'g');
            //alert(pattern);

            ele_opt.html(function(i, oldHTML) {
                return oldHTML.replace(pattern, '['+option_counter+']');
            }); 
            //alert($('.range_type').val());

            ele.find('.radio_dropdown').find('.specification_val').val('');
            ele.find('.radio_dropdown').find('.key_value_div').find('.key').val('');            
            ele.find('.radio_dropdown').find('.key_value_div').find('.value').val('');
            ele.find('.allowed').removeAttr('checked',false);  
            option_counter++; 

        }
    } 
    //alert($('.range_type').val());   
});

//var option_counter = 12;

$(document).on('click','.mybutton',function() { 
    var ele=$(this).parents('.radio_dropdown');
    var ele_clone = ele.find('.key_value_div:first').clone();
    var first_option_id = $('.edit_option_id:first').val();
    //alert(first_option_id);
              
    ele_clone.find('.mybutton_div').remove();
    ele_clone.find('.deletebutton_div').removeClass('hidden');
    ele_clone.find('.edit_option_id').attr('name','new_options['+option_counter+']').val(option_counter);
    pattern = new RegExp('\\\['+first_option_id+'\\\]', 'g');
    //alert(option_counter);
    ele_clone.html(function(i, oldHTML) {
        return oldHTML.replace(pattern, '['+option_counter+']');
    });
    ele_clone.find('.key').val(''); 
    ele_clone.find('.value').val('');                
    ele_clone.find('.allowed').prop('checked',false);   
    //alert(ele_clone.html());
    ele.find('.key_value_div:last').after(ele_clone); 
    option_counter++;   

}); 

$(document).on('click','.deletebutton',function() {  
    var ele=$(this).parents('.testdiv');
    ele.find(this).closest('.key_value_div').remove();                       
});

$(document).on('change','.upper_limit,.lower_limit',function(){
    var ele=$(this).parents('.textbox');
    var lower_limit=ele.find('.lower_limit').val();
    var upper_limit=ele.find('.upper_limit').val();
    if(upper_limit!='' && lower_limit!='')
    {
        if(upper_limit < lower_limit)
        {
            ele.find('.upper_limit').val('');
            ele.find(".up_limit").html("Upper limit  greater than lower limit");
        }
        else
        {
            ele.find(".up_limit").html(''); 
        }
    }
});

$(document).on('click','.allowed',function() { 
    
    var ele_div=$(this).parents('.testdiv');
    var range_type_id=ele_div.find('.rangetype').find('.range_type').val();
    if(range_type_id==2)
    {
        var ele=$(this).parents('.radio_dropdown');
        var ele_final = ele.find('.key_value_div'); 
        ele_final.find('.allowed').not($(this)).removeAttr('checked',true);   
    }
    
   // ele.find('.radio_dropdown').not('.radio_dropdown:first').remove();
    //ele_final.not(this).removaAttr('checked',true);                  
   /* ele_final.notfind('.allowed').removeAttr('checked',true);
    ele_final.find(this).closest('.allowed').attr('checked');                       */
   // $(this).attr('checked'); //This line
       

});

