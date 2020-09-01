var project = function() {
    var handleproject = function() {
        $('.project_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                customer_id: {
                    required: true
                },
                department_id: {
                    required: true
                },
                project_name: {
                    required:true,
                    maxlength: 255
                },
                start_date: {
                    required: true
                },
                start_date1: {
                    required: true
                },
                reason: {
                    required:true,
                    maxlength: 255
                },
                estimated_hours: {
                    required: true,
                    maxlength: 8 
                },
                project_manager_id: {
                    required: true
                }
            },

            messages: {
                customer_id:{
                    required: "Customer cannot be empty."
                },
                department_id:{
                    required: "Department cannot be empty."
                },
                project_name:{
                    required: "Project Name cannot be empty."
                },
                start_date:{
                    required: "Start Date cannot be empty."
                },

                start_date1:{
                    required: "Start Date cannot be empty."
                },
                reason:{
                    required: "Reason cannot be empty."
                },
                estimated_hours: {
                    required: "Estimated Hours cannot be empty."
                },
                project_manager_id:{
                    required: "Project Manager cannot be empty."
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   
                //$('.alert-danger', $('.reset-form')).show()
            },

            highlight: function(element) { // hightlight error inputs
                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
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
                    //$(window).scrollTop(0);
            },

            submitHandler: function(form) {
                form.submit(); // form validation success, call ajax form submit
            }
        });

        $('.project_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('.project_form').validate().form()) {
                    $('.project_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }

     return {
        //main function to initiate the module
        init: function() {
            handleproject();
        }

    };

}();

jQuery(document).ready(function() {
    project.init();
});

//to find uniqueness to project name
$('#customer_id').change(function(){
    $('#department_id').val('');
    $('#department_id').prev('i').removeClass('fa-check').addClass('fa');
    $('#department_id').closest('div.form-group').removeClass('has-success');
     $('#projectName').val('');
    $('#projectName').prev('i').removeClass('fa-warning fa-check');
    $('#projectName').closest('div.form-group').removeClass('has-error has-success');
    $('#projectError').html('');
    $("#projectError").addClass("hidden");
});
$('#department_id').change(function(){
    $('#projectName').prev('i').removeClass('fa-warning');
    $('#projectName').closest('div.form-group').removeClass('has-error');
    $('#projectError').html('');
    $("#projectError").addClass("hidden");
});
$('#projectName').blur(function(){
    var project_name = $(this).val();
    var project_id = $('#project_id').val();
    var customer_id = $('#customer_id').val();
    var department_id = $('#department_id').val();
    if(project_id=='')
    {
        project_id = 0;
    }
    if(project_name!='')
    {
        $("#projectnameValidating").removeClass("hidden");
        $("#projectError").addClass("hidden");
        
        $.ajax({
        type:"POST",
        url:SITE_URL+'is_projectExist',
        data:{project_name:project_name, project_id:project_id,customer_id:customer_id,department_id:department_id},
        cache:false,
        success:function(html){ 
        $("#projectnameValidating").addClass("hidden");
            if(html==1)
            {
                $('#projectName').val('');
                $('#projectName').prev('i').removeClass('fa-check').addClass('fa-warning');
                $('#projectName').closest('div.form-group').removeClass('has-success').addClass('has-error');
                $('#projectError').html('Sorry <b>'+project_name+'</b> has already been taken');
                $("#projectError").removeClass("hidden");
                return false;
            }
            else
            {   
                $('#projectError').html('');
                $("#projectError").addClass("hidden");
                return false;
            }
        }
        });
    }
});
var count =0;
$('#start_date').change(function(){
    var start_date = $(this).val();
    count++;
    if(count == 1)
    {
        $('#start_date').prev('i').removeClass('fa-success').addClass('fa');
        $('#start_date').closest('div.form-group').removeClass('has-success'); 
    }
    else if(start_date=='')
    {
        $('#start_date').prev('i').removeClass('fa-success').addClass('fa-warning');
        $('#start_date').closest('div.form-group').removeClass('has-success').addClass('has-error'); 
    }
    
    if(start_date!='' && count>1)
    {
        $('#end_date').val('');
        $('#start_date').prev('i').removeClass('fa-warning').addClass('fa-check');
        $('#start_date').closest('div.form-group').removeClass('has-error').addClass('has-success');
    }  
});
$('#start_date1').change(function(){
    var start_date = $(this).val();
    count++;
    if(count == 2)
    {
        $('#start_date1').prev('i').removeClass('fa-success').addClass('fa');
        $('#start_date1').closest('div.form-group').removeClass('has-success'); 
    }
    else if(start_date=='')
    {
        $('#start_date1').prev('i').removeClass('fa-success').addClass('fa-warning');
        $('#start_date1').closest('div.form-group').removeClass('has-success').addClass('has-error'); 
    }
    
    if(start_date!='' && count>2)
    {
        $('#end_date1').val('');
        $('#start_date1').prev('i').removeClass('fa-warning').addClass('fa-check');
        $('#start_date1').closest('div.form-group').removeClass('has-error').addClass('has-success');
    }  
});