var user = function() {

    var handleuser = function() {

        $('#user').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                n_password: {
                    required: true,
                    maxlength: 20
                },
                c_password: {
                    equalTo: "#n_password",
                    required: true,
                    maxlength: 20
                },
                plant_id: {
                    required: true
                },
                desig_id: {
                    required: true
                },
                user_name: {
                    required: true
                },
                full_name: {
                    required: true
                }
               
            },

            messages: {
                n_password: {
                    required: "New Password cannot be empty."
                },
                c_password: {
                    required: "Confirm Password cannot be empty."
                },
                plant_id: {
                    required: "Plant cannot be empty."
                },
                desig_id: {
                    required: "Designation cannot be empty."
                },
                full_name: {
                    required: "Full Name cannot be empty."
                },
                
                user_name: {
                    required: "User Name cannot be empty."
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

        $('#user input').keypress(function(e) {
            if (e.which == 13) {
                if ($('#user').validate().form()) {
                    $('#user').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handleuser();
        }

    };

}();

jQuery(document).ready(function() {
    user.init();
});

$(document).ready(function(){
    var blockid = $('.blockid').val();
    if(blockid!='')
    {
        $.ajax({
            type:"POST",
            url:SITE_URL+'getplantList',
            data:{blockid:blockid},
            cache:false,
            success:function(html){
                $('.plantid').html(html);
            }
        });
        $.ajax({
            type:"POST",
            url:SITE_URL+'getdisignationList',
            data:{blockid:blockid},
            cache:false,
            success:function(html){
                $('.desigid').html(html);
            }
        });
    }

});
$('.bloid').change(function(){
    var blockid = $(this).val();
    if(blockid!='')
    {
        $.ajax({
            type:"POST",
            url:SITE_URL+'getplantList',
            data:{blockid:blockid},
            cache:false,
            success:function(html){
                $('.plantid').html(html);
            }
        });
        $.ajax({
            type:"POST",
            url:SITE_URL+'getdisignationList',
            data:{blockid:blockid},
            cache:false,
            success:function(html){
                $('.desigid').html(html);
            }
        });
    }

});
$('.plantid').change(function(){
    $('#userName').val('');
    $('#userName').prev('i').removeClass('fa-check fa-warning').addClass('fa');
    $('#userName').closest('div.form-group').removeClass('has-error has-success');
    $('#userError').html('');
    $("#userError").addClass("hidden");
})
$('.desigid').change(function(){
    $('#userName').val('');
    $('#userName').prev('i').removeClass('fa-check fa-warning').addClass('fa');
    $('#userName').closest('div.form-group').removeClass('has-error has-success');
    $('#userError').html('');
    $("#userError").addClass("hidden");
})
//validate Uniqueness for product name
$('#userName').blur(function(){
    var username = $(this).val();
    //var blockid = $('.blockid').val();
    //var plantid = $('.plantid').val();
    //var designationid = $('.desigid').val();
    var userid = $('.user_id').val();

    if(userid=='')
    {
        userid = 0;
    }
   
    if(username!='')
    {
        $("#usernameValidating").removeClass("hidden");
        $("#userError").addClass("hidden");
        //,blockid:blockid,plantid:plantid,designationid:designationid
        $.ajax({
        type:"POST",
        url:SITE_URL+'is_userExist',
        data:{usname:username,userid:userid},
        cache:false,
        success:function(html){ 
        $("#usernameValidating").addClass("hidden");
            if(html==1)
            {
                $('#userName').val('');
                $('#userName').prev('i').removeClass('fa-check').addClass('fa-warning');
                $('#userName').closest('div.form-group').removeClass('has-success').addClass('has-error');
                $('#userError').html('Sorry <b>'+username+'</b> has already been taken');
                $("#userError").removeClass("hidden");
                return false;
            }
            else
            {   
                $('#userError').html('');
                $("#userError").addClass("hidden");
                return false;
            }
        }
        });
        
    }
});