

$('#tab2_id').click(function()
{                
    $('#tab1').removeClass('active');   
    $('#tab2').addClass('active');      
});
$('#add').click(function()
{
    var ele = $('#mytable').find('tbody').find('tr:last');  
    var ele_clone = ele.clone();    
    ele_clone.find('input, select').attr("disabled", false).val('');
    ele_clone.find('td div.form-group').removeClass('has-error has-success');
    ele_clone.find('td div.form-group div.input-icon i').removeClass('fa-check fa-warning');
    ele_clone.find('td:last').show();
    ele_clone.find('#remove_family_row').click(function() {      
        $(this).closest('tr').remove();
    });
    ele_clone.find("#relation").change(function()
    { 
        var gender_id = $(this).find('option:selected').data('gender-id');
        if(gender_id == 0)
        {          
            gender_id = "";
        }          
        ele_clone.find("#gender").val(gender_id);
    });
    ele.after(ele_clone);
    ele_clone.show();
});
$("#relation").change(function(){ 
    var gender_id = $(this).find('option:selected').data('gender-id');
    
    if(gender_id == 0)
    {          
        gender_id = "";
    }
    $("#gender").val(gender_id);
});

$('#mytable tbody tr #edit_family_row').click(function(){           
    $(this).closest('tr').find('input').attr("disabled", false);
    $(this).closest('tr').find('select').attr("disabled", false);
});
/*$('.remove_family_row').click(function(){         
    $(this).closest('tr').remove();
});*/

$('#mytable tbody tr #remove_family_row').click(function(){ 
    var ele = $(this);
    var res = confirm('Are you sure you want to delete this proof?');   
    if(res===true)
    {   
        var family_id=$(this).closest('tr').find('input[type=hidden]').val();
        var table_col='family_id';
        var table_name='family_info';
         $.ajax({
            type: "POST",
            url: SITE_URL+"HR/delete_table_details",
            data:'table_val='+family_id+'&table_col='+table_col+'&table_name='+table_name,
            success: function(response){
                if(response==1)
                {
                    ele.closest('tr').remove();
                    alert('Success! Record removed successfully.');
                }
                else
                {
                    alert('Error! Some error occurred while deleting the record, please try again.');
                }
            },
            error: function(){
                alert('Error! Some error occurred, please try again.');
            }
        });
    }
});
$('#add_bank_info').click(function()
{
    var ele = $('#bank_info').find('tbody').find('tr:last');  
    var ele_clone = ele.clone();    
    ele_clone.find('input, select').attr("disabled", false).val('');
    ele_clone.find('td div.form-group').removeClass('has-error has-success');
    ele_clone.find('td div.form-group div.input-icon i').removeClass('fa-check fa-warning');
    ele_clone.find('td:last').show();
    ele_clone.find('#remove_bank_row').click(function() {      
        $(this).closest('tr').remove();
    });
    
    ele.after(ele_clone);
    ele_clone.show();
});

$('#bank_info tbody tr #edit_bank_row').click(function(){           
    $(this).closest('tr').find('input').attr("disabled", false);
    $(this).closest('tr').find('select').attr("disabled", false);
});
/*$('.remove_family_row').click(function(){         
    $(this).closest('tr').remove();
});*/

$('#bank_info tbody tr #remove_bank_row').click(function(){ 
    var ele = $(this);
    var res = confirm('Are you sure you want to delete this proof?'); 
    if(res===true)
    {
        var bank_info_id=$(this).closest('tr').find('input[type=hidden]').val();
        
        var table_name='bank_info';
        var table_col='bank_info_id';
         $.ajax({
            type: "POST",
            url: SITE_URL+"HR/delete_table_details",
            data:'table_val='+bank_info_id+'&table_col='+table_col+'&table_name='+table_name,
            success: function(response){

                if(response==1)
                {
                    ele.closest('tr').remove();
                    alert('Success! Record removed successfully.');
                }
                else
                {
                    alert('Error! Some error occurred while deleting the record, please try again.');
                }
            },
            error: function(){
                alert('Error! Some error occurred, please try again.');
            }
        });
    }
});


$('#add_pre_org').click(function()
{
    var ele = $('#pre_org').find('tbody').find('tr:last');  
    var ele_clone = ele.clone();    
    ele_clone.find('input, select, textarea').attr("disabled", false).val('');
    ele_clone.find('td div.form-group').removeClass('has-error has-success');
    ele_clone.find('td div.form-group div.input-icon i').removeClass('fa-check fa-warning');
    ele_clone.find('td:last').show();
    ele_clone.find('#remove_pre_org_row').click(function() {      
        $(this).closest('tr').remove();
    });
    
    ele.after(ele_clone);
    ele_clone.show();
});

$('#pre_org tbody tr #edit_pre_org_row').click(function(){           
    $(this).closest('tr').find('input').attr("disabled", false);
    $(this).closest('tr').find('select').attr("disabled", false);
    $(this).closest('tr').find('textarea').attr("disabled", false);
});
/*$('.remove_family_row').click(function(){         
    $(this).closest('tr').remove();
});*/

$('#pre_org tbody tr #remove_pre_org_row').click(function(){ 
    var ele = $(this);
    var res = confirm('Are you sure you want to delete this proof?'); 
    if(res===true)
    {
        var pre_org_id=$(this).closest('tr').find('input[type=hidden]').val();
        var table_col='pre_org_id';
        var table_name='previous_organisation';
         $.ajax({
            type: "POST",
            url: SITE_URL+"HR/delete_table_details",
            data:'table_val='+pre_org_id+'&table_col='+table_col+'&table_name='+table_name,
            success: function(response){
                if(response==1)
                {
                    ele.closest('tr').remove();
                    alert('Success! Record removed successfully.');
                }
                else
                {
                    alert('Error! Some error occurred while deleting the record, please try again.');
                }
            },
            error: function(){
                alert('Error! Some error occurred, please try again.');
            }
        });
    }
});


$('#add_certification').click(function()
{
    var ele = $('#certification').find('tbody').find('tr:last');  
    var ele_clone = ele.clone();    
    ele_clone.find('input, select').attr("disabled", false).val('');
    ele_clone.find('td div.form-group').removeClass('has-error has-success');
    ele_clone.find('td div.form-group div.input-icon i').removeClass('fa-check fa-warning');
    ele_clone.find('td:last').show();
    ele_clone.find('#remove_certification_row').click(function() {      
        $(this).closest('tr').remove();
    });
    
    ele.after(ele_clone);
    ele_clone.show();
});

$('#certification tbody tr #edit_certification_row').click(function(){           
    $(this).closest('tr').find('input').attr("disabled", false);
    $(this).closest('tr').find('select').attr("disabled", false);
});
/*$('.remove_family_row').click(function(){         
    $(this).closest('tr').remove();
});*/

$('#certification tbody tr #remove_certification_row').click(function(){ 
    var ele = $(this);
    var res = confirm('Are you sure you want to delete this proof?'); 
    if(res===true)
    {
        var certification_id=$(this).closest('tr').find('input[type=hidden]').val();
        var table_col='certification_id';
        var table_name='certification';
         $.ajax({
            type: "POST",
            url: SITE_URL+"HR/delete_table_details",
            data:'table_val='+certification_id+'&table_col='+table_col+'&table_name='+table_name,
            success: function(response){
                if(response==1)
                {
                    ele.closest('tr').remove();
                    alert('Success! Record removed successfully.');
                }
                else
                {
                    alert('Error! Some error occurred while deleting the record, please try again.');
                }
            },
            error: function(){
                alert('Error! Some error occurred, please try again.');
            }
        });
    }
});




$('#add_education_info').click(function()
{
    var ele = $('#education_info').find('tbody').find('tr:last');  
    var ele_clone = ele.clone();    
    ele_clone.find('input, select').attr("disabled", false).val('');
    ele_clone.find('td div.form-group').removeClass('has-error has-success');
    ele_clone.find('td div.form-group div.input-icon i').removeClass('fa-check fa-warning');
    ele_clone.find('td:last').show();
    ele_clone.find('#remove_education_info_row').click(function() {      
        $(this).closest('tr').remove();
    });
    
    ele.after(ele_clone);
    ele_clone.show();
});

$('#education_info tbody tr #edit_education_info_row').click(function(){           
    $(this).closest('tr').find('input').attr("disabled", false);
    $(this).closest('tr').find('select').attr("disabled", false);
});
/*$('.remove_family_row').click(function(){         
    $(this).closest('tr').remove();
});*/

$('#education_info tbody tr #remove_education_info_row').click(function(){ 
    var ele = $(this);
    var res = confirm('Are you sure you want to delete this proof?'); 
    if(res===true)
    {
        var education_id=$(this).closest('tr').find('input[type=hidden]').val();
        var table_col='education_id';
        var table_name='education_info';
         $.ajax({
            type: "POST",
            url: SITE_URL+"HR/delete_table_details",
            data:'table_val='+education_id+'&table_col='+table_col+'&table_name='+table_name,
            success: function(response){
                if(response==1)
                {
                    ele.closest('tr').remove();
                    alert('Success! Record removed successfully.');
                }
                else
                {
                    alert('Error! Some error occurred while deleting the record, please try again.');
                }
            },
            error: function(){
                alert('Error! Some error occurred, please try again.');
            }
        });
    }
});


$(document).on("change","#additional_gender_id",function()
{
    var additional_gender_id = $('#additional_gender_id').val();    
    if(additional_gender_id==1)
    {       
        $('#div_marrital_status').removeClass('hidden');  
        $('#div_marrital_status').addClass('active'); 
    }
    else
    {
        $('#date_of_wedding').val('');
        $('#div_marrital_status').addClass('hidden');
    }    
});
