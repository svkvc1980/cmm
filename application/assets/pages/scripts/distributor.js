var distributorForm = function() {

    var handledistributorForm = function() {

        $('#distributor_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: 
            {
                 distributor_code: {                       
                    required: 'Distributor is required'
                },
                user_name: {
                    required: 'UserName is required'
                },
                
                concerned_person: {
                    required: 'concerned person is required'
                },
                agency_name:{
                    required:'agency name is required'
                }
                
                /* vat_no: {
                    required: 'vat no. is required'
                },
                pan_no: {
                    required: 'pan no. is required'
                },
                tan_no: {
                    required: 'tan no. is required'
                },
                aadhar_no: {
                    required: ' aadhar no. is required'
                },
                location_id: {
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
                },
                
                sd_amount: {
                    required: 'sd amount is required'
                },
                mobile: {
                    required: 'mobile No. is required'
                },
                agreement_end_date: {
                    required: 'agreement end date is required'
                },
                agreement_start_date: {
                    required: 'agreement start date is required'
                },
                email:{
                    required:'email is required'
                },
                agent_id:{
                    required:'agency name is required'
                },
                'bank_id[]':{
                    required:'bank is required'
                },
                'ifsc_code[]':{
                    required:'ifsc code is required'
                },
                'bg_amount[]':{
                    required:'bg amount is required'
                },
                'start_date[]':{
                    required:'start date is required'
                },
                'end_date[]':{
                    required:'end date is required'
                },
                
                'account_no[]':{
                    required:'Account No. is required'
                } */

            },
            rules: {
                /* 'account_no[]':{
                    required:true
                }, */
                agency_name:{
                    required:true
                },
                distributor_code: {                       
                    required: true
                },
                user_name: {
                    required: true
                },
                
                concerned_person: {
                    required: true
                }
                
                /* vat_no: {
                    required: true
                },
                pan_no: {
                    required: true
                },
                tan_no: {
                    required: true
                },
                aadhar_no: {
                    required: true
                },
                location_id: {
                    required: true
                },
                district: {
                    required: true
                },
                region: {
                    required: true
                },
                mobile: {
                    required: true
                },
                agreement_end_date: {
                    required: true
                },
                agreement_start_date: {
                    required: true
                },
                sd_amount: {
                    required: true
                },
                state: {
                    required: true
                },
                email:{
                    required:true
                },
                agent_id:{
                    required:true
                },
                'bank_id[]':{
                    required:true
                },
                'ifsc_code[]':{
                    required:true
                },
                'bg_amount[]':{
                    required:true
                },
                'start_date[]':{
                    required:true
                },
                'end_date[]':{
                    required:true
                } */

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

        $('#distributor_form input').on('keypress',function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#distributor_form').validate().form()) {
                    $('#distributor_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handledistributorForm();
        }

    };

}();
jQuery(document).ready(function() {
    distributorForm.init();
});
$('.remove_bank_row').on('click',function(){
    if(confirm('are you sure to delete bank details?'))
    {
        $(this).closest('tr').remove();
    }
});

$('#add_bank_info').click(function()
{
    
    var ele = $('.bank_table').find('tbody').find('tr:last');  
    var ele_clone = ele.clone();
    ele_clone.find('.start_date').datepicker();  
    ele_clone.find('.end_date').datepicker();    
    ele_clone.find('input, select').attr("disabled", false).val('');
    ele_clone.find('td div.dummy').removeClass('has-error has-success');
    ele_clone.find('td div.input-icon i').removeClass('fa-check fa-warning');
    ele_clone.find('td:last').show();
    ele_clone.find('.remove_bank_row').click(function() {      
        $(this).closest('tr').remove();
    });
    ele.after(ele_clone);
    ele_clone.show();
});

$('.state').change(function(){
    $('.region_id').prev('i').removeClass('fa-check').removeClass('fa-warning').addClass('fa');
    $('.region_id').closest('div.form-group').removeClass('has-success').removeClass('has-error');
    $('.district').prev('i').removeClass('fa-check').removeClass('fa-warning').addClass('fa');
    $('.district').closest('div.form-group').removeClass('has-success').removeClass('has-error');
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
               // alert(html);
                $('.area').html(html);
            }
        });
    }
});
//validate Uniqueness for product name
$('#userName').blur(function(){
    var username = $(this).val();
    //var blockid = $('.blockid').val();
    //var plantid = $('.plantid').val();
    //var designationid = $('.desigid').val();
    var userid = $('#uid').val();

    if(userid=='')
    {
        userid = 0;
    }
   
    if(username!='')
    {
        $("#usernameValidating").removeClass("hidden");
        $("#userError").addClass("hidden");
        //,blockid:blockid,plantid:plantid,designationid:designationid
        $.ajax({
        type:"POST",
        url:SITE_URL+'is_userExist',
        data:{usname:username,userid:userid},
        cache:false,
        success:function(html){ 
        $("#usernameValidating").addClass("hidden");
            if(html==1)
            {
                $('#userName').val('');
                $('#userName').prev('i').removeClass('fa-check').addClass('fa-warning');
                $('#userName').closest('div.form-group').removeClass('has-success').addClass('has-error');
                $('#userError').html('Sorry <b>'+username+'</b> has already been taken');
                $("#userError").removeClass("hidden");
                return false;
            }
            else
            {   
                $('#userError').html('');
                $("#userError").addClass("hidden");
                return false;
            }
        }
        });
        
    }
});