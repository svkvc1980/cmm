$(document).ready(function() 
{ 
  $('.it_sub_type').hide();
  $('.it_sub_sub_type').hide();
  $('.it_remarks').hide();
  $('.btnDeclare').click(function() 
  {
    var ele_panel_body = $(this).closest('.section'); 
    var row_count=ele_panel_body.find('.table_count').length;       
    var type = ele_panel_body.find('.type:first option:selected');
    var remarks=ele_panel_body.find('.remarks:first').val();    
    var amount = ele_panel_body.find('.amount:first').val();
    var sno = ele_panel_body.find('.s_no:last').val(); 
    var subtype_id= ele_panel_body.find('.sub_type:first option:selected');
    var years= ele_panel_body.find('.years:first option:selected');
    var image=ele_panel_body.find('.image:first').clone().attr('name','proof[]');
    var sub_subtype_id= ele_panel_body.find('.sub_sub_type:first option:selected');
    row_count=row_count+1;
    if(type.val() == ''||amount==''||years.val()=='') 
      {
          //ele_panel_body.find("tr:last").remove();
          if(type.val() == '')
          {
            ele_panel_body.find('.type:first').css("border-color","red");
            ele_panel_body.find('.type_err').html('please select type');
          }
          else
          {
             html='';
             ele_panel_body.find('.type_err').html(html);
             ele_panel_body.find('.type:first').css("border-color","inherit");
          }

        
        /* if(subtype_id.val() == '')
          {
             ele_panel_body.find('.sub_type:first').css("border-color","red");
            ele_panel_body.find('.sub_type_err ').html('please select sub type');
         }
         else
         {
             html='';
             ele_panel_body.find('.sub_type_err').html(html);
             ele_panel_body.find('.sub_type:first').css("border-color","inherit");
         }*/
         if(years.val() == '')
          {
           ele_panel_body.find('.years:first').css("border-color","red");
           ele_panel_body.find('.year_err').html('please select Financial year');
          }
          else
         {
             html='';
             ele_panel_body.find('.year_err').html(html);
             ele_panel_body.find('.years:first').css("border-color","inherit");
         }
          if(amount == '')
          {
            ele_panel_body.find('.amount:first').css("border-color","red");
             ele_panel_body.find('.amount_err').html('please enter amount');
          }
          else
         {
             html='';
             ele_panel_body.find('.amount_err').html(html);
             ele_panel_body.find('.amount:first').css("border-color","inherit");
         }
      } 
     else
     {  
        var category=type.text();
        if(subtype_id.val()!='')
        {
        category+=' '+" <i class='fa fa-angle-right'></i> ";
        category+=' '+subtype_id.text(); 
        }
        if(sub_subtype_id.val()!='')
        {
        category+=' '+" <i class='fa fa-angle-right'></i> ";
        category+=' '+sub_subtype_id.text();  
        }    
        var ele_append = "<tr class='table_count'><td width='4%'>"+row_count+"</td><td width='40%'>"+category+"</td><td width='20%'>"+remarks+"</td><td width='10%'><input type='text' class='form-control  sum'  name='amount_sum["+counter+"]' value='"+amount+"'></td><td width='15%'> <a class='btn btn-danger btn-circle btn-sm delete_row'  onclick='return confirm('Are you sure you want to Delete?')'><i class='fa fa-trash-o'></i></a></td><input type='hidden' name='yearss["+counter+"]' value='"+years.val()+"'><input type='hidden' name='subtypes_id["+counter+"]' value='"+subtype_id.val()+"'><input type='hidden' name='types_id["+counter+"]' value='"+type.val()+"'><input type='hidden' name='remark["+counter+"]' value='"+remarks+"'><input type='hidden' name='sub_subtypes_id["+counter+"]' value='"+sub_subtype_id.val()+"'><input type='hidden'name='emp_dec_id["+counter+"]' value=''></tr>";
        ele_panel_body.find('table tbody').append(ele_append).find('.delete_row:last').closest('td').before(image);
        counter++;
        $('.delete_row').click(function()
        {
          $(this).parents("tr").remove();
          return false;
        });
     }
  ele_panel_body.find('.years:first option:selected').prop("selected", false);
  ele_panel_body.find('.amount:first').val('');
  ele_panel_body.find('.remarks').val(''); 
  return false; 
  }); 

  //getting values based on dropdown selection
  $(".type").change(function () 
  { 
     // $('.sub_sub_type').hide(); 
      var ele_panel_body = $(this).closest('.section');        //closest panel body
      var type_id = ele_panel_body.find('.type option:selected');    //select dropdown closest to the panel body
      var sub_type_class= ele_panel_body.find('.sub_type');
      
      ele_panel_body.find('.it_sub_sub_type').hide();
      ele_panel_body.find('.sub_sub_type').html('<option value=""></option>');
      if(type_id.val()=='')
      { 
          sub_type_class.html('<option value="">-Select Sub declaration Type-</option');
          $(this).focus();
      }
      else
      {
         $.ajax
         ({
            type:"POST",
            url:'get_subtypes',
            data:{type_id:type_id.val()},
            cache:false,
            success:function(html)
            {  
              if(html!='')
              { 
                ele_panel_body.find('.it_remarks').hide();
                ele_panel_body.find('.it_sub_type').show();
                sub_type_class.html(html);
              }
              else
              {
                ele_panel_body.find('.it_remarks').show();
                ele_panel_body.find('.it_sub_type').hide();
                sub_type_class.html('<option value=""></option>');
              }
            }
        });
     }
  });

     //getting values based on subtype dropdown selection
    $(".sub_type").change(function () { 
        var ele_panel_body = $(this).closest('.section');        //closest panel body
        var subtype_id = ele_panel_body.find('.sub_type option:selected');
        var sub_type_class= ele_panel_body.find('.sub_sub_type');    //select dropdown closest to the panel body
        if(subtype_id.val()=='')
        { //alert('hi');
             sub_type_class.html('<option value="">-Select Sub declaration Type-</option');
             $(this).focus();
             //sub_type_class.hide();
        }
        else
        {
          $.ajax
          ({
                type:"POST",
                url:'get_sub_subtypes',
                data:{subtype_id:subtype_id.val()},
                cache:false,
                success:function(html)
                {   
                    if(html=='')
                    { 
                      ele_panel_body.find('.it_remarks').hide();
                      ele_panel_body.find('.it_sub_sub_type').hide();
                      sub_type_class.html('<option value=""></option>');
                    } 
                    else
                    { 
                      ele_panel_body.find('.it_remarks').hide();
                      ele_panel_body.find('.it_sub_sub_type').show(); 
                      sub_type_class.html(html);
                      
                    }
               } 
            });
        }
    });
 });
   
    

