var packing_material_form = function() {

    var handlepacking_material_form = function() {

        $('#packing_material_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                    capacity: 
                    {
                        required: 'Capacity is required'
                    },
                    category: 
                    {
                        required: 'Category is required'
                    },
                    pm_group: 
                    {
                        required: 'Packing Material Group is required'
                    },
                    packing_material: 
                    {
                        required: 'Packing Material Name is required'
                    }
                    ,
                    pm_code: 
                    {
                        required: 'PM Code is required'
                    }
                },
                rules: {                    
                    capacity:
                    {
                        required: true
                    },
                    category:
                    {
                        required: true
                    },
                    pm_group:
                    {
                        required: true
                    },
                    packing_material:
                    {
                        required: true
                    },
                    pm_code:
                    {
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

        $('#packing_material_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#packing_material_form').validate().form()) {
                    $('#packing_material_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handlepacking_material_form();
        }

    };

}();

jQuery(document).ready(function() {
    packing_material_form.init();
});
//name unique...
$('.capacity_id').change(function(){
    $('#packingmaterialName').prev('i').removeClass('fa-check fa-warning').addClass('fa');
    $('#packingmaterialName').closest('div.form-group').removeClass('has-success has-error');
    $("#packingmaterialError").addClass("hidden");
})
//validate Uniqueness for capacity name
$('#packingmaterialName').blur(function(){
    var pm_name = $(this).val();
    var pm_id = $('.pm_id').val();
    var capacity_id =$('.capacity_id').val();
    if(pm_id=='')
    {
        pm_id = 0;
    }   
    if(pm_id!='')
    {
        $("#packingmaterialnameValidating").removeClass("hidden");
        
        $("#packingmaterialError").addClass("hidden");
        
        $.ajax({
        type:"POST",
        url:SITE_URL+'is_pm_name_Exist',
        data:{pm_name:pm_name,pm_id:pm_id,capacity_id:capacity_id},
        cache:false,
        success:function(html){ 
        $("#packingmaterialnameValidating").addClass("hidden");
            if(html==1)
            {
                $('#packingmaterialName').val('');
                $('#packingmaterialName').prev('i').removeClass('fa-check').addClass('fa-warning');
                $('#packingmaterialName').closest('div.form-group').removeClass('has-success').addClass('has-error');
                $('#packingmaterialError').html('Sorry <b>'+pm_name+'</b> has already been taken');
                $("#packingmaterialError").removeClass("hidden");
                return false;
            }
            else
            {   
                $('#packingmaterialError').html('');
                $("#packingmaterialError").addClass("hidden");
                return false;
            }
        }
        });        
    }
});





