var test_unit = function() {
    var handletest_unit = function() {
        $('.test_unit_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                name: {
                    required: true
                }
            },

            messages: {
                name:{
                    required: "Name cannot be empty."
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

        $('.test_unit_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('.test_unit_form').validate().form()) {
                    $('.test_unit_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }

     return {
        //main function to initiate the module
        init: function() {
            handletest_unit();
        }

    };

}();

jQuery(document).ready(function() {
    test_unit.init();
});

//validate Uniqueness for test unit name

$('#Name').blur(function(){
    var name = $(this).val();
    var test_unit_id = $('#test_unit_id').val();
    if(test_unit_id=='')
    {
        test_unit_id = 0;
    }
    if(test_unit!='')
    {
        $("#nameValidating").removeClass("hidden");
        $("#test_unitError").addClass("hidden");
        
        $.ajax({
        type:"POST",
        url:SITE_URL+'is_test_unitExist',
        data:{name:name,test_unit_id:test_unit_id},
        cache:false,
        success:function(html){ 
        $("#nameValidating").addClass("hidden");
            if(html==1)
            {
                $('#Name').val('');
                $('#Name').prev('i').removeClass('fa-check').addClass('fa-warning');
                $('#Name').closest('div.form-group').removeClass('has-success').addClass('has-error');
                $('#test_unitError').html('Sorry <b>'+name+'</b> has already been taken');
                $("#test_unitError").removeClass("hidden");
                return false;
            }
            else
            {   
                $('#test_unitError').html('');
                $("#test_unitError").addClass("hidden");
                return false;
            }
        }
        });
        
    }
});