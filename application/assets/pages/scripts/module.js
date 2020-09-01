var module = function() {

    var handlemodule = function() {

        $('#module_frm').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                project_id: {
                    required: 'Project cannot be empty'
                },
                'module_name[]':{
                    required: 'Module cannot be empty'
                },
                'stage_id[]':{
                    required: 'Stage cannot be empty'
                },
                'start_date[]':{
                    required: 'Start Date cannot be empty'
                },
                'estimated_hours[]':{
                    required: 'Estimated Hours cannot be empty'
                },
                module_name:{
                    required: 'Module cannot be empty'
                },
                stage_id:{
                    required: 'Stage cannot be empty'
                },
                start_date:{
                    required: 'Start Date cannot be empty'
                },
                estimated_hours:{
                    required: 'Estimated Hours cannot be empty'
                }
            },
            rules: 
            {
                project_id: {
                     required: true
                },
                'stage_id[]': {
                     required: true
                },
                'module_name[]': {
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
                },
                stage_id: {
                     required: true
                },
                module_name: {
                       required: true
                },
                estimated_hours: {
                        required: true,
                        number:true, 
                },
                start_date: {
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

        $('#module_frm input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#module_frm').validate().form()) {
                    $('#module_frm').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handlemodule();
        }

    };

}();

jQuery(document).ready(function() {
    module.init();
});
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
    ele_clone.find('input, textarea').val('');
    ele_clone.find('td div.form-group').removeClass('has-success has-error');
    ele_clone.find('td div.form-group div.input-icon i').removeClass('fa-check fa-warning');
    ele_clone.find(".removerow").show();
    ele_clone.find(".removerow").click(function () 
    {        
        $(this).closest('tr').remove();
    });
    validateDateRange(ele_clone.find('.start_date'), ele_clone.find('.end_date'));
    ele.after(ele_clone);
})
validateDateRange($('.start_date'), $('.end_date'));

$('#moduleName').blur(function(){
    var modulename = $(this).val();
    var projectid = $('#project_id').val();
    var stageid = $('#stage_id').val();
    var tasklevelid = 1;
    var task_id = $('#task_id').val();
    if(task_id=='')
    {
        task_id = 0;
    }
    if(modulename!='')
    {
        $("#modulenameValidating").removeClass("hidden");
        $("#moduleError").addClass("hidden");
        
        $.ajax({
        type:"POST",
        url:SITE_URL+'is_moduleExist',
        data:{module_name:modulename, project_id:projectid, stage_id:stageid,task_level_id:tasklevelid,task_id:task_id},
        cache:false,
        success:function(html){ 
        $("#modulenameValidating").addClass("hidden");
            if(html==1)
            {
                $('#moduleName').val('');
                $('#moduleName').prev('i').removeClass('fa-check').addClass('fa-warning');
                $('#moduleName').closest('div.form-group').removeClass('has-success').addClass('has-error');
                $('#moduleError').html('Sorry <b>'+modulename+'</b> has already been taken');
                $("#moduleError").removeClass("hidden");
                return false;
            }
            else
            {   
                $('#moduleError').html('');
                $("#moduleError").addClass("hidden");
                return false;
            }
        }
        });
        
    }
});