var designation = function() {

    var handledesignation = function() {

        $('#designation_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                designation_name: {
                    required: true
                },
                'block_type[]':{
                    required:true
                }
            },

            messages: {
                designation_name: {
                    required: "Designation is required"
                },
                'block_type[]':{
                    required:"Type is required"
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

        $('#designation_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#designation_form').validate().form()) {
                    $('#designation_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handledesignation();
        }

    };

}();

jQuery(document).ready(function() {
    designation.init();
});


//validate Uniqueness for Tank name


$('#designation_name').blur(function(){
    var designation_name = $(this).val();
    var designation_id = $('#designation_id').val();
    if(designation_id=='')
    {
        designation_id = 0;
    }
    if(designation_name!='')
    {
        $("#designation_nameValidating").removeClass("hidden");
        $("#designationError").addClass("hidden");
        
        $.ajax({
        type:"POST",
        url:SITE_URL+'is_designationExist',
        data:{designation_name:designation_name,designation_id:designation_id},
        cache:false,
        success:function(html){ 
        $("#designation_nameValidating").addClass("hidden");
            if(html==1)
            {
                $('#designation_name').val('');
                $('#designation_name').prev('i').removeClass('fa-check').addClass('fa-warning');
                $('#designation_name').closest('div.form-group').removeClass('has-success').addClass('has-error');
                $('#designationError').html('Sorry <b>'+designation_name+'</b> has already been taken');
                $("#designationError").removeClass("hidden");
                return false;
            }
            else
            {   
                $('#designationError').html('');
                $("#designationError").addClass("hidden");
                return false;
            }
        }
        });
        
    }
});