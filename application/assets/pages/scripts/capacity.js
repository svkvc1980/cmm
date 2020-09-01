var capacityForm = function() {

    var handlecapacityForm = function() {

        $('#capacity_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input           
                rules: {                    
                  name: {                                         
                        required: true
                    },
                    unit:{
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

        $('#capacity_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#capacity_form').validate().form()) {
                    $('#capacity_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }
    return {
        //main function to initiate the module
        init: function() {
            handlecapacityForm();
        }

    };

}();

jQuery(document).ready(function() {
    capacityForm.init();
});
$('.unit_id').change(function(){
    $('#capacityName').prev('i').removeClass('fa-check fa-warning').addClass('fa');
    $('#capacityName').closest('div.form-group').removeClass('has-success has-error');
    $("#capacityError").addClass("hidden");
})
//validate Uniqueness for capacity name
$('#capacityName').blur(function(){
    var capacity_name = $(this).val();
    var capacity_id = $('#capacity_id').val();
    var unit_id =$('.unit_id').val();
    if(capacity_id=='')
    {
        capacity_id = 0;
    }   
    if(capacity_name!='')
    {
        $("#capacitynameValidating").removeClass("hidden");
        
        $("#capacityError").addClass("hidden");
        
        $.ajax({
        type:"POST",
        url:SITE_URL+'is_capacityExist',
        data:{capacity_name:capacity_name,identity:capacity_id,unit_id:unit_id},
        cache:false,
        success:function(html){ 
        $("#capacitynameValidating").addClass("hidden");
            if(html==1)
            {
                $('#capacityName').val('');
                $('#capacityName').prev('i').removeClass('fa-check').addClass('fa-warning');
                $('#capacityName').closest('div.form-group').removeClass('has-success').addClass('has-error');
                $('#capacityError').html('Sorry <b>'+capacity_name+'</b> has already been taken');
                $("#capacityError").removeClass("hidden");
                return false;
            }
            else
            {   
                $('#capacityError').html('');
                $("#capacityError").addClass("hidden");
                return false;
            }
        }
        });        
    }
});
