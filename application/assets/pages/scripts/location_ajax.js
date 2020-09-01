
$(document).on("change","#region_id",function() {    
   // var frequency = $('#equipment_id').val();
    var region_id = $('#region_id').val();
    if(region_id!=''){
        $.ajax({
            type: "POST",
            url: SITE_URL+"Company/get_country_by_region",
            data:'region_id='+region_id,
            success: function(data){ 
            $('#div_country').removeClass('hidden');  
            $('#div_state').addClass('hidden');    
            $('#div_city').addClass('hidden');              
            $("#country_id").html(data);
        }
        });
    }
    else
    {
        $('#div_country').addClass('hidden');  
        $('#div_state').addClass('hidden');    
        $('#div_city').addClass('hidden');           
             
   
    }
    
});
$(document).on("change","#country_id",function() {    
   // var frequency = $('#equipment_id').val();
    var country_id = $('#country_id').val();
    if(country_id!=''){
        $.ajax({
            type: "POST",
            url: SITE_URL+"Company/get_state_by_country",
            data:'country_id='+country_id,
            success: function(data){ 
            $('#div_state').removeClass('hidden');
            $('#div_city').addClass('hidden');                
            $("#state_id").html(data);
        }
        });
    }
    else
    {
        $('#div_state').addClass('hidden'); 
        $('#div_city').addClass('hidden');              
   
    }
    
});

$(document).on("change","#state_id",function() {    
   // var frequency = $('#equipment_id').val();
    var state_id = $('#state_id').val();
    if(state_id!=''){
        $.ajax({
            type: "POST",
            url: SITE_URL+"Company/get_city_by_state",
            data:'state_id='+state_id,
            success: function(data){ 
            $('#div_city').removeClass('hidden');                
            $("#city_id").html(data);
        }
        });
    }
    else
    {
        $('#div_city').addClass('hidden');               
   
    }
    
});

