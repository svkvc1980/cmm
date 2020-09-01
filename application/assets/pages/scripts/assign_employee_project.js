var assign_employee_project = function() {

    var handleassign_employee_project = function() {

        $('#assign_employee_project_frm').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                project_id: {
                    required: 'Project cannot be empty'
                },
                module_id: {
                    required: 'Module cannot be empty'
                },
                task_id: {
                    required: 'Task cannot be empty'
                },
                employee_id: {
                    required: 'Employee cannot be empty'
                },
                assigned_hours:{
                    required: 'Assigned Hours cannot be empty'
                },
                start_date:{
                    required: 'Start Date cannot be empty'
                }
                ,
                end_date:{
                    required: 'End Date cannot be empty'
                }
            },
            rules: 
            {
                project_id: {
                     required: true
                },
                module_id: {
                     required: true
                },
                task_id: {
                     required: true
                },
                employee_id: {
                     required: true
                },
                assigned_hours: {
                        required: true,
                        number:true, 
                },   
                start_date: {
                     required: true
                },   
                end_date: {
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

        $('#assign_employee_project_frm input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#assign_employee_project_frm').validate().form()) {
                    $('#assign_employee_project_frm').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handleassign_employee_project();
        }

    };

}();

jQuery(document).ready(function() {
    assign_employee_project.init();
});

$(".project_id").change(function () { 
    $('.employee_id').prev('i').removeClass('fa-check').addClass('fa');
    $('.employee_id').closest('div.form-group').removeClass('has-success').removeClass('has-error');
    $('.module_id').prev('i').removeClass('fa-check').addClass('fa');
    $('.module_id').closest('div.form-group').removeClass('has-success').removeClass('has-error');
    $('.task_id').prev('i').removeClass('fa-check').addClass('fa');
    $('.task_id').closest('div.form-group').removeClass('has-success').removeClass('has-error');
    
    var project_id=$(this).val();
    if(project_id=='')
    {
        $(".employee_id").html('<option value="">-Select Employee-</option');
        $(this).focus();

        $(".module_id").html('<option value="">-Select Module-</option');
        $(this).focus();
    }
    else
    {
        $.ajax({
            type:"POST",
            url:SITE_URL+'ajax_project_employee',
            data:{project_id:project_id},
            cache:false,
            success:function(html)
            {
                $(".employee_id").html(html);
            }
        });

        $.ajax({
            type:"POST",
            url:SITE_URL+'ajax_project_module',
            data:{project_id:project_id},
            cache:false,
            success:function(html)
            {
                $(".module_id").html(html);
                $('.module_id').val('');
                $('.module_id').change();
            }
        });
    }
});

$(".module_id").change(function() { 


    $('.task_id').prev('i').removeClass('fa-check').addClass('fa');
    $('.task_id').closest('div.form-group').removeClass('has-success').removeClass('has-error');
    
    var module_id=$(this).val();
    var project_id = $('.project_id').val();
    if(module_id=='')
    {
       $(".task_id").html('<option value="">-Select Task-</option');
       $(this).focus();
    }
    else
    {
        $.ajax({
        type:"POST",
            url:SITE_URL+'ajax_module_task',
            data:{module_id:module_id,project_id:project_id},
            cache:false,
            success:function(html)
            {
                $(".task_id").html(html);
            }
        });
    }
});