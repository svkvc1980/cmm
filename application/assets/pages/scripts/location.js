var locationForm = function() {

    var handlestateForm = function() {

        $('#state_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                    name: {
                        required: 'Name is required'
                    }
                },
                rules: {
                    name: {
                        maxlength:20,                        
                        required: true
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

        $('#state_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#state_form').validate().form()) {
                    $('#state_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }

    var handlelocationForm = function() {

        $('#location_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                    name: {
                        required: 'Name is required'
                    },
                    parent: {
                        required: 'Name is required'
                    }
                },
                rules: {
                    name: {
                        maxlength:20,                        
                        required: true
                    },
                    parent: {                                               
                        required: true
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

        $('#country_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#country_form').validate().form()) {
                    $('#country_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }





    return {
        //main function to initiate the module
        init: function() {
            handlestateForm();
            handlelocationForm();
            
        }

    };

}();

jQuery(document).ready(function() {
    locationForm.init();
});
$('#state_name').change(function(){   
    var location_id = $('input[type="hidden"][name="location_id"]').val();

    if(location_id=='')
    {
        location_id=0;
    }

    var state_name = $(this).val();
    
    if(state_name!='')
    {
        $("#statenameValidating").removeClass("hidden");
        $("#stateError").addClass("hidden");        
        $.ajax({
        type:"POST",
        url:SITE_URL+'Location/check_state',
        data:{state_name:state_name,location_id:location_id},
        cache:false,
        success:function(html){ 
        $("#statenameValidating").addClass("hidden");
            if(html==1)
            {
                $('#state_name').val('');
                $('#state_name').prev('i').removeClass('fa-check').addClass('fa-warning');
                $('#state_name').closest('div.form-group').removeClass('has-success').addClass('has-error');
                $('#stateError').html('Sorry <b>'+state_name+'</b> has already exist');
                $("#stateError").removeClass("hidden");
                return false;
            }
            else
            {   
                $('#stateError').html('');
                $("#stateError").addClass("hidden");
                return false;
            }
        }
        });
        
    }
});
$('#parent_id').change(function(){
    
    var parent_id=$('#parent_id').val();
    if(parent_id!='')
    {        
        $('#name').removeAttr("readonly");
    }
    else
    {
        $('#name').attr("readonly", "readonly");
    }


});

$('#name').change(function(){
    var location_id = $('input[type="hidden"][name="location_id"]').val();
    if(location_id=='')
    {
        location_id=0;
    }

    var name = $(this).val();
    var parent_id = $('#parent_id').val();    
    
    if(name!='' && parent_id!='')
    {
        $("#locationnameValidating").removeClass("hidden");
        $("#locationError").addClass("hidden");        
        $.ajax({
        type:"POST",
        url:SITE_URL+'Location/is_locationExist',
        data:{name:name,parent_id:parent_id,location_id:location_id},
        cache:false,
        success:function(html){ 
        $("#locationnameValidating").addClass("hidden");
            if(html==1)
            {
                $('#name').val('');
                $('#name').prev('i').removeClass('fa-check').addClass('fa-warning');
                $('#name').closest('div.form-group').removeClass('has-success').addClass('has-error');
                $('#locationError').html('Sorry <b>'+name+'</b> has already been taken');
                $("#locationError").removeClass("hidden");
                return false;
            }
            else
            {   
                $('#locationError').html('');
                $("#locationError").addClass("hidden");
                return false;
            }
        }
        });
        
    }
});



