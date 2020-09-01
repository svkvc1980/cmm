var task = function() {

    var handletask = function() {

        $('#task_frm').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                stage_id: {
                    required: 'Stage cannot be empty'
                },
                'stage_id[]': {
                    required: 'Stage cannot be empty'
                },

                project_id: {
                    required: 'Project cannot be empty'
                },
                module_id:{
                    required: 'Module cannot be empty'
                },
                estimated_hours:{
                    required: 'Estimated Hours cannot be empty'
                },
                start_date:{
                    required: 'Start Date cannot be empty'
                }
                ,
                'module_id[]':{
                    required: 'Module cannot be empty'
                },
                'estimated_hours[]':{
                    required: 'Estimated Hours cannot be empty'
                },
                'start_date[]':{
                    required: 'Start Date cannot be empty'
                },
                'task_name[]':{
                    required: 'task name cannot be empty'
                }
            },
            rules: 
            {
                stage_id: {
                     required: true
                },
                'stage_id[]': {
                     required: true
                },
                project_id: {
                     required: true
                },
                module_id: {
                       required: true,
                       maxlength: 100
                },
                task_name: {
                     required: true
                },
                estimated_hours: {
                        required: true,
                        number:true, 
                },   
                start_date: {
                     required: true
                },
                description: {
                      maxlength: 255
                },
                'module_id[]': {
                       required: true,
                       maxlength: 100
                },
                'task_name[]': {
                     required: true
                },
                'estimated_hours[]': {
                        required: true,
                        number:true, 
                },   
                'start_date[]': {
                     required: true
                },
                'description[]': {
                      maxlength: 255
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

        $('#task_frm input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#task_frm').validate().form()) {
                    $('#task_frm').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the task
        init: function() {
            handletask();
        }

    };

}();


jQuery(document).ready(function() {
    task.init();
});

//to get module based on project and stageid
$(document).on('change','.stage_id',function(){
    var ele_this = $(this);
    var project_id = $('.project_id').val();
    var stage_id = ele_this.val();
    if(project_id=='' || stage_id=='')
    {
        ele_this.closest('tr').find('.module_id').html('<option value="">-Select Module-</option');
        ele_this.focus(); 
    }
    else
    {
        $.ajax({
            type:"POST",
            url:SITE_URL+'getModuleList',
            data:{project_id:project_id,stage_id:stage_id},
            cache:false,
            success:function(html){
                ele_this.closest('tr').find('.module_id').html(html);
            }
        });
    }

})
$('#taskName').blur(function(){
    var ele_this = $(this);
    var task_name = ele_this.val();
    var project_id = $('.project_id').val();
    var stage_id = $('.stage_id').val();
    var task_level_id = 2;
    var module_id = $('.module_id').val();
    var task_id = $('#task_id').val();
    if(task_id=='')
    {
        task_id = 0;
    }
    if(task_name!='')
    {
        $("#tasknameValidating").removeClass("hidden");
        $("#taskError").addClass("hidden");
        
        $.ajax({
        type:"POST",
        url:SITE_URL+'is_taskExist',
        data:{task_name:task_name, project_id:project_id, stage_id:stage_id,task_level_id:task_level_id,task_id:task_id,module_id:module_id},
        cache:false,
        success:function(html){ 
        $("#tasknameValidating").addClass("hidden");
            if(html==1)
            {
                ele_this.closest('tr').find('#taskName').val('');
                $('#taskName').prev('i').removeClass('fa-check').addClass('fa-warning');
                $('#taskName').closest('div.form-group').removeClass('has-success').addClass('has-error');
                $('#taskError').html('Sorry <b>'+task_name+'</b> has already been taken');
                $("#taskError").removeClass("hidden");
                return false;
            }
            else
            {   
                $('#taskError').html('');
                $("#taskError").addClass("hidden");
                return false;
            }
        }
        });
        
    }
})
function validateDateRange(start_date, end_date)
{
    start_date.datepicker().on('change', function(e) {
        if(end_date.val()=="")
            end_date.datepicker('setStartDate', $(this).val());
        else
            if($(this).val() > end_date.val())
                end_date.datepicker('setDate', $(this).val());
    });
    end_date.datepicker().on('change', function(e) {
        if(start_date.val()=="")
            start_date.datepicker('setEndDate', $(this).val());
        else
            if($(this).val()!="" && $(this).val() < start_date.val())
                start_date.datepicker('setDate', $(this).val());
    });
}
$('.removerow:first').hide();
$('#add').click(function()
{
    var ele = $('#mytable').find('tbody tr:last'); 
    var ele_clone = ele.clone();
    ele_clone.find('input').val('');
    ele_clone.find('td div.form-group').removeClass('has-success has-error');
    ele_clone.find('td div.form-group div.input-icon i').removeClass('fa-check fa-warning');
    ele_clone.find(".removerow").show();
    ele_clone.find(".removerow").click(function () 
    {        
        $(this).closest('tr').remove();
    });
    validateDateRange(ele_clone.find('.start_date'), ele_clone.find('.end_date'));
    ele_clone.find('.module_id').html('<option selected="" value="">-Module-</option>');
    ele.after(ele_clone);
})
validateDateRange($('.start_date'), $('.end_date'));