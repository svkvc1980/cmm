var supplierForm = function() {

    var handlesupplierForm = function() {

        $('#supplier_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: 
            {
                type_id:
                {
                    required: 'Type id is required'
                },
                "bank_id[]":
                {
                    required: 'Bank is required'
                },
                "account_no[]":
                {
                    required: 'Account No is required'
                },
                "ifsc_code[]":
                {
                    required: 'IFSC Code is required'
                }
            },
            rules: {
                type:{
                  required:true
                },
                "bank_id[]":{
                  required:true
                },
                "account_no[]":{
                  required:true
                },
                "ifsc_code[]":{
                  required:true
                },
                supplier_code: {
                    number:true,                        
                    required: true
                },                
                agency_name: {
                    required: true
                } /* ,
                concerned_person: {
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
                state: {
                    required: true
                },                
                mobile: {
                    required: true
                },
                aadhar_no: {
                    required: true
                },
                pincode: {
                    required: true
                },
                pan_no: {
                    required: true
                },                
                tan_no: {
                    required: true
                } */
                
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

        $('#supplier_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#supplier_form').validate().form()) {
                    $('#supplier_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handlesupplierForm();
        }

    };

}();

jQuery(document).ready(function() {
    supplierForm.init();
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
    $('.mandal').prev('i').removeClass('fa-check').removeClass('fa-warning').addClass('fa');
    $('.mandal').closest('div.form-group').removeClass('has-success').removeClass('has-error');
    $('.area').prev('i').removeClass('fa-check').removeClass('fa-warning').addClass('fa');
    $('.area').closest('div.form-group').removeClass('has-success').removeClass('has-error');
    var state_id = $(this).val();
    if(state_id=='')
    {
        $('.region_id').html('<option value="">-Select Region-</option>');
        $('.region_id').change();
        $('.district').change();
    }
    else
    {
        $.ajax({
            type:"POST",
            url:SITE_URL+'ajax_get_regions_by_state_id',
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
            url:SITE_URL+'ajax_get_districts_by_region_id',
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
            url:SITE_URL+'ajax_get_mandals_by_district_id',
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
            url:SITE_URL+'ajax_get_areas_by_mandal_id',
            data:{mandal_id:mandal_id},
            cache:false,
            success:function(html){
                $('.area').html(html);
            }
        });
    }
});


