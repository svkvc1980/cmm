$('#document').change(function(){                
    var ext = $(this).val().split('.').pop().toLowerCase();
    if($.inArray(ext, ['doc','pdf','docx']) == -1) {
        alert('invalid extension! allowed .doc, .docx, .pdf only');
        $(this).val('');
        $('#doc').removeClass('hidden');
        return false;
    }
    else{
        $('#doc').addClass('hidden');
    }
    
});
$('#image').change(function(){                
    var ext = $(this).val().split('.').pop().toLowerCase();
    if($.inArray(ext, ['jpg','jpeg']) == -1) {
        alert('invalid extension! allowed .jpg, .jpeg only');
        $(this).val('');
        return false;
    }
});
$(document).on("change","#company_id",function() {
    
    $.ajax({
        type: "POST",
        url: SITE_URL+"HR/get_branches_and_units",
        data:'company_id='+$(this).val(),
        dataType: 'json',
        success: function(data){
        $("#branch_id").html(data.branches);
        $("#unit_id").html(data.units);
        $("#department_id").html('<option value="">-Select Department-</option');
        $(this).focus();        
    }
    });
    
});

$(document).on("change","#unit_id",function() {    
   // var frequency = $('#equipment_id').val();
    var unit_id = $('#unit_id').val();
    if(unit_id!=''){
        $.ajax({
            type: "POST",
            url: SITE_URL+"HR/get_departments",
            data:'unit_id='+unit_id,
            success: function(data){      
            $("#department_id").html(data);        

        }
        });
    }
    
});

$(document).on("change","#echelon_id",function() {    
   // var frequency = $('#equipment_id').val();
    var echelon_id = $('#echelon_id').val();
    if(echelon_id!=''){
        $.ajax({
            type: "POST",
            url: SITE_URL+"HR/get_designation_by_echelon",
            data:'echelon_id='+echelon_id,
            success: function(data){             
            $("#designation_id").html(data);
        }
        });
    }
     
});





