var executiveForm = function() {

    var handleexecutiveForm = function() {

        $('#exe_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: 
            {
                 exe_code: {                       
                    required: 'Executive Code is required'
                },
                exe_name: {
                    required: 'Executive Name is required'
                },
                
                mobile: {
                    required: 'Mobile number is required'
                },
                
                city: {
                    required: 'City is required'
                },
                district: {
                    required: 'district is required'
                },
                region: {
                    required: 'region is required'
                },
                state: {
                    required: 'state is required'
                }
            },
            rules: {
                
                exe_name:{
                    required:true
                },
                exe_code: {
                                            
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
                mobile: {
                    required: true,
                    number: true
                },
                
                state:{
                    required:true
                }

            },

            invalidHandler: function(event, validator) { //display error alert on form submit   
                //$('.alert-danger', $('.reset-form')).show();
            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group,.dummy').addClass('has-error'); // set error class to the control group
            },

            success: function(label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group,.dummy').removeClass('has-error').addClass('has-success'); // set success class to the control group
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

        $('#exe_form input').on('keypress',function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#exe_form').validate().form()) {
                    $('#exe_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handleexecutiveForm();
        }

    };

}();
jQuery(document).ready(function() {
    executiveForm.init();
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
        $('.state').prev('i').removeClass('fa-check fa-warning').addClass('fa');
        $('.state').closest('div.form-group').removeClass('has-success has-error');
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
//validate Uniqueness for product name
$('#exe_code').blur(function(){
    var exe_code = $(this).val();
    var exe_id = $('#eid').val();

    if(exe_id=='')
    {
        exe_id = 0;
    }
   
    if(exe_code!='')
    {
        $("#codeValidating").removeClass("hidden");
        $("#codeError").addClass("hidden");
        //,blockid:blockid,plantid:plantid,designationid:designationid
        $.ajax({
        type:"POST",
        url:SITE_URL+'is_executiveExist',
        data:{exe_code:exe_code,exe_id:exe_id},
        cache:false,
        success:function(html){ 
        $("#codeValidating").addClass("hidden");
            if(html==1)
            {
                $('#exe_code').val('');
                $('#exe_code').prev('i').removeClass('fa-check').addClass('fa-warning');
                $('#exe_code').closest('div.form-group').removeClass('has-success').addClass('has-error');
                $('#codeError').html('Sorry <b>'+exe_code+'</b> has already been taken');
                $("#codeError").removeClass("hidden");
                return false;
            }
            else
            {   
                $('#codeError').html('');
                $("#codeError").addClass("hidden");
                return false;
            }
        }
        });
        
    }
});