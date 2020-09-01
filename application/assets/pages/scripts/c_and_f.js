var ddForm = function() {

    var handleddForm = function() {

        $('#c_and_f_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: 
            {
                plant:
                {
                    required: 'C&F Unit is required'
                },
                dd_number:
                {
                    required:'DD number is required'
                },
                payment_mode:
                {
                    required:'DD type is required'
                },
                payment_date:
                {
                    required:'date is required'
                },
                bank:
                {
                    required:'Bank name is required'
                },
                amount:
                {
                    required:'amount is required'
                }
            },
            rules: {
                plant: {
                    required: true
                },
                dd_number:{
                    required:true
                },
                payment_mode:{
                    required:true
                },
                payment_date:{
                    required:true
                },
                bank:{
                    required: true
                },
                amount:{
                    required:true
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

        $('#c_and_f_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#c_and_f_form').validate().form()) {
                    
                    $('#c_and_f_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handleddForm();
        }

    };

}();


jQuery(document).ready(function() {

    ddForm.init();
});

jQuery(document).ready(function() {
    ddForm.init();
});
//validate Uniqueness for loose oil name
$('#dd_num').blur(function(){
    var dd_number = $(this).val();

    if(dd_number!='')
    {
        $("#ddnumberValidating").removeClass("hidden");
        $("#ddnumberError").addClass("hidden");
          
        $.ajax({
        type:"POST",
        url:SITE_URL+'is_numberExist',
        data:{dd_number:dd_number},
        cache:false,
        success:function(html){ 
        $("#ddnumberValidating").addClass("hidden");
            if(html==1)
            {
                $('#dd_num').val('');
                $('#dd_num').prev('i').removeClass('fa-check').addClass('fa-warning');
                $('#dd_num').closest('div.form-group').removeClass('has-success').addClass('has-error');
                $('#ddnumberError').html('Sorry <b>'+dd_number+'</b> has already been taken');
                $("#ddnumberError").removeClass("hidden");
                return false;
            }
            else
            {   
                $('#ddnumberError').html('');
                $("#ddnumberError").addClass("hidden");
                return false;
            }
        }
        });
        
    }
});

