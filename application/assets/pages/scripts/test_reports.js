var test_reports = function() {

    var handletest_reports = function() {

        $('.test_reports').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages:
            {
                po_no: 
                {
                    required: 'This Field is Required'
                },
                tank_reg_no: 
                {
                    required: 'This Field is Required'
                }
            },
            rules: 
            {
                po_no: 
                {
                    maxlength:9,                        
                    required: true
                },
                tank_reg_no: 
                {
                    maxlength:9,                        
                    required: true
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   
                //$('.alert-danger', $('.login-form')).show();
            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },


            errorPlacement: function(error, element) {
                //error.insertAfter(element);
                //error.insertAfter(element.closest('.input-icon'));
                    var icon = $(element).parent('.input-icon').children('i');
                    icon.removeClass('fa-check').addClass("fa-warning");  
                    icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});

            },
            success: function(label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("fa-warning").addClass("fa-check");
            },

            submitHandler: function(form) {
                form.submit(); // form validation success, call ajax form submit
            }
        });

        $('.test_reports input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.test_reports').validate().form()) {
                    $('.test_reports').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }

    /*var handleinsert_test_reports = function() {

        $('.insert_test_reports').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages:
            {
                test_result: 
                {
                    required: 'This Field is Required'
                }
            },
            rules: 
            {
                test_result: 
                {
                    maxlength:9,                        
                    required: true
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   
                //$('.alert-danger', $('.login-form')).show();
            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },


            errorPlacement: function(error, element) {
                //error.insertAfter(element);
                //error.insertAfter(element.closest('.input-icon'));
                    var icon = $(element).parent('.input-icon').children('i');
                    icon.removeClass('fa-check').addClass("fa-warning");  
                    icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});

            },
            success: function(label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("fa-warning").addClass("fa-check");
            },

            submitHandler: function(form) {
                form.submit(); // form validation success, call ajax form submit
            }
        });

        $('.insert_test_reports input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.insert_test_reports').validate().form()) {
                    $('.insert_test_reports').submit(); //form validation success, call ajax form submit
                }
                return false;                  
            }
        });
    }*/
   
    return {
        //main function to initiate the module
        init: function() {

            handletest_reports();
            //handleinsert_test_reports();
        }

    };

}();

jQuery(document).ready(function() {
    test_reports.init();
});

$(document).ready(function() {
    $i = 0; 
    $(document).on('blur','.test_value',function(){
        $i++;

        var lower_limit = $(this).data('l-limit');
        var upper_limit = $(this).data('u-limit');
        var lower_check = $(this).data('l-check');
        var upper_check = $(this).data('u-check');
        var type_id = $(this).data('range-type');
        var result = $(this).val();
        
        if(type_id == '1')
        {

            if(lower_limit != '' && upper_limit != '' )
            { 

                if(lower_check == 1)
                {
                    if(upper_check == 1)
                    {

                        if(result >= lower_limit && result <= upper_limit)
                        {
                            
                            $(this).closest("td").find(".form-group").removeClass("has-error");
                        }
                        else
                        {
                            $(this).closest("td").find(".form-group").addClass("has-error");   
                        }
                    }
                    else
                    { 
                        if(result >= lower_limit && result < upper_limit)
                        {
                            $(this).closest("td").find(".form-group").removeClass("has-error");
                        }
                        else
                        {
                            $(this).closest("td").find(".form-group").addClass("has-error");   
                        }
                    }
                }
                else
                { 
                    if(lower_limit == '')
                    { 
                        if(upper_check == 1)
                        {
                            if(lower_limit == result)
                            {
                                $(this).closest("td").find(".form-group").removeClass("has-error");
                            }
                            else
                            {
                                $(this).closest("td").find(".form-group").addClass("has-error");   
                            }
                        }
                        else
                        { 
                            if(lower_limit == result)
                            {
                                $(this).closest("td").find(".form-group").removeClass("has-error");
                            }
                            else
                            {
                                $(this).closest("td").find(".form-group").addClass("has-error");   
                            }
                        }
                    }
                    else
                    { 
                        if(lower_check == 1)
                        { 
                            if(lower_limit == result)
                            {
                                $(this).closest("td").find(".form-group").removeClass("has-error");
                            }
                            else
                            {
                                $(this).closest("td").find(".form-group").addClass("has-error");   
                            }
                        }
                        else
                        {
                            
                            if(lower_check == '' && upper_check =='')
                            {
                                if(result > lower_limit && result < upper_limit)//solved
                                {

                                    $(this).closest("td").find(".form-group").removeClass("has-error");
                                }
                                else
                                {
                                    $(this).closest("td").find(".form-group").addClass("has-error");   
                                }

                            }
                            else
                            {
                                if(result > lower_limit && result <= upper_limit)//solved
                                {
                                    $(this).closest("td").find(".form-group").removeClass("has-error");
                                }
                                else
                                {
                                    $(this).closest("td").find(".form-group").addClass("has-error");   
                                }

                            }
                        }
                    }
                }
            }
            else if(lower_limit == '' || upper_limit == '')
            {
                
                if(lower_limit == '')
                {

                    if(upper_check == 1)
                    {
                        if(result <= upper_limit) //solved
                        {
                            
                            $(this).closest("td").find(".form-group").removeClass("has-error");
                        }
                        else
                        {
                            $(this).closest("td").find(".form-group").addClass("has-error");   
                        }
                    }
                    else 
                    {
                        if(lower_limit != '')
                        {
                            if(result < lower_limit) //solved
                            {
                                $(this).closest("td").find(".form-group").removeClass("has-error");
                            }
                            else
                            {
                                $(this).closest("td").find(".form-group").addClass("has-error");   
                            }

                        }
                        else
                        {
                            if(upper_limit != '')
                            {
                               
                                if(result < upper_limit) //solved
                                {
                                    $(this).closest("td").find(".form-group").removeClass("has-error");
                                }
                                else
                                {
                                    $(this).closest("td").find(".form-group").addClass("has-error");   
                                }
                            }
                        }
                        
                    }
                }
                else if(lower_limit != '')
                {
                     
                    if(lower_check == 1)
                    {
                        

                        if(result >= lower_limit) //solved
                        {
                            $(this).closest("td").find(".form-group").removeClass("has-error");
                        }
                        else
                        {
                            
                            $(this).closest("td").find(".form-group").addClass("has-error");   
                        }
                    }
                    else
                    {
                        if(lower_limit < result)
                        {
                            $(this).closest("td").find(".form-group").removeClass("has-error");
                        }
                        else
                        {
                            $(this).closest("td").find(".form-group").addClass("has-error");   
                        }
                    }
                }
            }
        }
        else
        {
            if(lower_limit == result)
            {
                $(this).closest("td").find(".form-group").removeClass("has-error");
            }
            else
            {
                $(this).closest("td").find(".form-group").addClass("has-error");   
            }
        }

    });

    $(document).on('change','.test_value1',function(){

        var allowed = $(this).find('option:selected').data('allowed');
        if(allowed == '1') 
        {
            $(this).closest("td").find(".form-group").removeClass("has-error");
        }
        else
        {
            $(this).closest("td").find(".form-group").addClass("has-error");   
        }      
        return false;
    });

    $(document).on('change','.test_value2',function(){

        var allowed = $(this).data('allowed');
        if(allowed == '1') 
        {
            $(this).closest("tr").find(".test_radio").addClass("hidden");
        }
        else
        {
            $(this).closest("tr").find(".test_radio").removeClass("hidden");
        }      
        return false;
    });


});

