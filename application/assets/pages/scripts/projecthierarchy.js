var projecthierarchy = function() {

    var handleprojecthierarchy = function() {

        $('#projecthierarchy_frm').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                employee_id: {
                    required: 'Employee cannot be empty'
                },
                project_id: {
                    required: 'Project cannot be empty'
                },
                reporting_manager_id:{
                    required: 'Reporting Manager cannot be empty'
                },
                start_date:{
                    required: 'Start Date cannot be empty'
                }
            },
            rules: 
            {
                employee_id: {
                     required: true
                },
                project_id: {
                     required: true
                },
                reporting_manager_id: {
                        required: true,
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

        $('#projecthierarchy_frm input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#projecthierarchy_frm').validate().form()) {
                    $('#projecthierarchy_frm').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handleprojecthierarchy();
        }

    };

}();

jQuery(document).ready(function() {
    projecthierarchy.init();
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