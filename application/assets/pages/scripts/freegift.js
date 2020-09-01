var freegift = function() {

    var handlefreegift = function() {

        $('.freegift_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                    name: {
                    required: true
                }
            },

            messages: {
                    name: {
                    required: "Freegift Name can not be empty."
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

        $('.freegift_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('.freegift_form').validate().form()) {
                    $('.freegift_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handlefreegift();
        }

    };

}();

jQuery(document).ready(function() {
    freegift.init();
});


//validate Uniqueness for Freegift name

$('#freegift').blur(function(){
    var name = $(this).val();
    var freegift_id = $('#freegift_id').val();
    if(freegift_id=='')
    {
        freegift_id = 0;
    }
    if(name!='')
    {
        $("#freegiftnameValidating").removeClass("hidden");
        $("#freegiftError").addClass("hidden");
        
        $.ajax({
        type:"POST",
        url:SITE_URL+'is_freegiftExist',
        data:{name:name,freegift_id:freegift_id},
        cache:false,
        success:function(html){ 
        $("#freegiftnameValidating").addClass("hidden");
            if(html==1)
            {
                $('#freegift').val('');
                $('#freegift').prev('i').removeClass('fa-check').addClass('fa-warning');
                $('#freegift').closest('div.form-group').removeClass('has-success').addClass('has-error');
                $('#freegiftError').html('Sorry <b>'+name+'</b> has already been taken');
                $("#freegiftError").removeClass("hidden");
                return false;
            }
            else
            {   
                $('#freegiftError').html('');
                $("#freegiftError").addClass("hidden");
                return false;
            }
        }
        });
        
    }
});