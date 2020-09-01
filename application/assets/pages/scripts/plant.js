var plantForm = function() {

    var handleplantForm = function() {

        $('#plant_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: 
            {
                plant_name:
                {
                    required: 'Plant Name is required'
                },
                short_name:
                {
                    required: 'Short Name is required'
                }
            },
            rules: {
                plant_name: {
                    required: true
                },
                city: {
                    required: true
                },
                district: {
                    required: true
                },
                region: {
                    required: true
                },
                state: {
                    required: true
                },
                short_name:{
                    required:true
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   
                //$('.alert-danger', $('.reset-form')).show();
            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("fa-warning").addClass("fa-check");
            },

            errorPlacement: function(error, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    icon.removeClass('fa-check').addClass("fa-warning");  
                    icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
            },


            submitHandler: function(form) {
                form.submit(); // form validation success, call ajax form submit
            }
        });

        $('#plant_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#plant_form').validate().form()) {
                    $('#plant_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handleplantForm();
        }

    };

}();


jQuery(document).ready(function() {

    plantForm.init();
});

$('.state').change(function(){
    
    $('.region_id').prev('i').removeClass('fa-check').removeClass('fa-warning').addClass('fa');
    $('.region_id').closest('div.form-group').removeClass('has-success').removeClass('has-error');
    $('.district').prev('i').removeClass('fa-check').removeClass('fa-warning').addClass('fa');
    $('.district').closest('div.form-group').removeClass('has-success').removeClass('has-error');
    $('.mandal').prev('i').removeClass('fa-check').removeClass('fa-warning').addClass('fa');
    $('.mandal').closest('div.form-group').removeClass('has-success').removeClass('has-error');
    $('.area').prev('i').removeClass('fa-check').removeClass('fa-warning').addClass('fa');
    $('.area').closest('div.form-group').removeClass('has-success').removeClass('has-error');
    var state_id = $(this).val();
    
    if(state_id=='')
    {
        $('.region_id').html('<option value="">-Select Region-</option');
        $('.region_id').change();
        $('.district').change();
    }
    else
    {
        $.ajax({
            type:"POST",
            url:SITE_URL+'getregionList',
            data:{state_id:state_id},
            cache:false,
            success:function(html){
                $('.region_id').html(html);
                $('.region_id').change();
                $('.district').change();
            }
        });
    }
});

$('.region_id').change(function(){
    $('.district').prev('i').removeClass('fa-check').removeClass('fa-warning').addClass('fa');
    $('.district').closest('div.form-group').removeClass('has-success').removeClass('has-error');
    $('.mandal').prev('i').removeClass('fa-check').removeClass('fa-warning').addClass('fa');
    $('.mandal').closest('div.form-group').removeClass('has-success').removeClass('has-error');
    $('.area').prev('i').removeClass('fa-check').removeClass('fa-warning').addClass('fa');
    $('.area').closest('div.form-group').removeClass('has-success').removeClass('has-error');
    var region_id = $(this).val();
    if(region_id=='')
    {
        $('.district').html('<option value="">-Select District-</option');
        $('.district').change(); 
    }
    else
    {
        $.ajax({
            type:"POST",
            url:SITE_URL+'getdistrictList',
            data:{region_id:region_id},
            cache:false,
            success:function(html){
                $('.district').html(html);
                $('.district').change();
            }
        });
    }
});

$('.district').change(function(){
    $('.mandal').prev('i').removeClass('fa-check').removeClass('fa-warning').addClass('fa');
    $('.mandal').closest('div.form-group').removeClass('has-success').removeClass('has-error');
    $('.area').prev('i').removeClass('fa-check').removeClass('fa-warning').addClass('fa');
    $('.area').closest('div.form-group').removeClass('has-success').removeClass('has-error');
    var district_id = $(this).val();
    if(district_id=='')
    {
        $('.mandal').html('<option value="">-Select Mandal-</option');
        $('.mandal').change();
        
    }
    else
    {
        $.ajax({
            type:"POST",
            url:SITE_URL+'getmandalList',
            data:{district_id:district_id},
            cache:false,
            success:function(html){
                $('.mandal').html(html);
                $('.mandal').change();
            }
        });
    }
});

$('.mandal').change(function(){
    var mandal_id = $(this).val();
    if(mandal_id=='')
    {
        $('.area').html('<option value="">-Select City/Town-</option');
        
    }
    else
    {
        $.ajax({
            type:"POST",
            url:SITE_URL+'getareaList',
            data:{mandal_id:mandal_id},
            cache:false,
            success:function(html){
                $('.area').html(html);
            }
        });
    }
});
