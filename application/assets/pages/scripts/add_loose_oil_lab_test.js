var add_loose_oil_lab_test_form = function() {

    var handleadd_loose_oil_lab_test_form= function() {

        $('#add_loose_oil_lab_test_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                    loose_oil: {
                        required: 'Name is required'
                    },
                    test_group: {
                        required: 'Echelon ID is required'
                    }
                },
                rules: {                    
                    loose_oil: {
                        required: true
                    },
                    test_group: {
                        required: true
                    }/*,
                    'range_type[]': {
                        required: true
                    }*//*,
                    'lower_limit[]': {
                        required: true
                    },
                    'upper_limit[]': {
                        required: true
                    },
                    'specification[]': {
                        required: true
                    },
                    'key[][]': {
                        required: true
                    },
                    'value[][]': {
                        required: true
                    },
                    'exact_value[]': {
                        required: true
                    },
                    lower_limit: {
                        required: true
                    },
                    lower_check: {
                        required: true
                    },
                    upper_limit: {
                        required: true
                    },
                    upper_check: {
                        required: true
                    },
                    specification: {
                        required: true
                    },
                    
                    exact_value: {
                        required: true
                    }*/
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

        $('#add_loose_oil_lab_test_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#add_loose_oil_lab_test_form').validate().form()) {
                    $('#add_loose_oil_lab_test_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handleadd_loose_oil_lab_test_form();
        }

    };

}();

jQuery(document).ready(function() {
    add_loose_oil_lab_test_form.init();
});

var test_counter = 2;
var option_counter=2;

$(document).on('click','.addtest',function(){
   // alert('hiii');
    ele_clone = $('.testdiv:first').clone();
    ele_clone.find('.delete_test_div').removeClass('hidden');
    var sno= $('.test_sno').length+1;
    ele_clone.find('.test_sno').html(sno+')');
    ele_clone.find('.up_limit').html('');
    ele_clone.find('.radio_dropdown').find('.key_value_div').not('.key_value_div:first').remove();

    ele_clone.find('.radio_dropdown').addClass('hidden');
    //ele_clone.find('.radio_dropdown').find('.key_value_div').not('.key_value_div:first').remove();
    ele_clone.find('.textbox').addClass('hidden');
    ele_clone.find('.exactvalue').addClass('hidden');

   // ele_clone.find('.form-group').find('.form-group').addClass('has-success');
   // ele_clone.addClass('has-success');
    //ele_clone.find('div.form-group .form-group div.input-icon i').addClass('fa-check ');
    /*ele_clone.find('div.testname').find('div.form-group');    
    ele_clone.removeClass('has-error has-success');
    ele_clone.find('div.input-icon i').removeClass('fa-check fa-warning');*/
    ele_clone.html(function(i, oldHTML) {
        return oldHTML.replace(/\[1\]\[1\]/g, '['+test_counter+']['+option_counter+']');
    });

    ele_clone.html(function(i, oldHTML) {
        return oldHTML.replace(/\[1\]/g, '['+test_counter+']');
    });
    ele_clone.find('.t_counter').val(test_counter);
    ele_clone.find('.op_counter').val(option_counter);
   // alert(ele_clone.html());
    $('.testdiv:last').after(ele_clone);
    test_counter++;
    option_counter++;
});

$(document).on('click','.delete_test',function() {
    $(this).parents('.testdiv').remove(); 
    var sno=1; 
    $('.test_sno').each(function(){
        $(this).html(sno+')');
        sno++;
    });                    
});

$(document).on('change','.range_type',function() {
   // alert('hiii');    
    var range_type_id=$(this).val();
    var ele=$(this).parents('.testdiv');

    if(range_type_id==1)
    {
        ele.find('.textbox').removeClass('hidden');  
        ele.find('.radio_dropdown').addClass('hidden');
        ele.find('.exactvalue').addClass('hidden');        
        ele.find('div.radio_dropdown').not('div.radio_dropdown:first').remove();        
        /*var ele2=ele.find('div.textbox').find('div.form-group');
        ele2.removeClass('has-error has-success');
        ele2.find('div.input-icon i').removeClass('fa-check fa-warning'); */      

    }
    else
    {
        if(range_type_id==4)
        {
            ele.find('.exactvalue').removeClass('hidden');
            ele.find('.textbox').addClass('hidden');
            ele.find('div.radio_dropdown').not('div.radio_dropdown:first').remove();
            ele.find('.radio_dropdown').addClass('hidden');
            /*var ele4=ele.find('div.exactvalue').find('div.form-group');
            ele4.removeClass('has-error has-success');
            ele4.find('div.input-icon i').removeClass('fa-check fa-warning');*/

        }
        else
        {

            ele.find('.radio_dropdown').removeClass('hidden');
            ele.find('.textbox').addClass('hidden');
            ele.find('.exactvalue').addClass('hidden');
            ele.find('.radio_dropdown').not('.radio_dropdown:first').remove();
            /*var ele2=ele.find('div.radio_dropdown').find('div.form-group');
            ele2.removeClass('has-error has-success');
            ele2.find('div.input-icon i').removeClass('fa-check fa-warning');*/
        }
    }     
    
});


$(document).on('click','.mybutton',function() { 
    var ele=$(this).parents('.radio_dropdown');
    var ele_clone = ele.find('.key_value_div:first').clone();
    //alert($('.radio_dropdown:last').length);
   /* ele_clone.find('div.form-group').removeClass('has-error has-success');
    ele_clone.find('div.form-group div.input-icon i').removeClass('fa-check fa-warning');
    ele_clone.find('.spcls').text(''); */
    ele_clone.find('.key').val(''); 
    ele_clone.find('.value').val('');                
    ele_clone.find('.allowed').removeAttr('checked',false);

    
    var t_counter = $(this).closest('.testdiv').find('.t_counter').val();
    var op_counter = $(this).closest('.radio_dropdown').find('.op_counter:first').val();
    pattern = new RegExp('\\\['+t_counter+'\\\]\\\['+op_counter+'\\\]', 'g');
    //alert(pattern);
    //alert('['+t_counter+']['+option_counter+']');
    ele_clone.html(function(i, oldHTML) {
        return oldHTML.replace(pattern, '['+t_counter+']['+option_counter+']');
    });
    ele_clone.find('.op_counter').val(option_counter);
    option_counter++;

     //ele_clone.find('input[type=checkbox]').removeAttr('checked');
              
    ele_clone.find('.mybutton_div').remove();
    ele_clone.find('.deletebutton_div').addClass('show');
    ele.find('.key_value_div:last').after(ele_clone);    

}); 

$(document).on('click','.deletebutton',function() {  
    var ele=$(this).parents('.testdiv');
    ele.find(this).closest('.key_value_div').remove();                       
});

$(document).on('change','.upper_limit,.lower_limit',function(){
    
    var ele=$(this).parents('.textbox');
    var lower_limit=ele.find('.lower_limit').val();
    var upper_limit=ele.find('.upper_limit').val();
    if(upper_limit!='' && lower_limit!='')
    {

        if(upper_limit < lower_limit)
        {
            ele.find('.upper_limit').val('');
            ele.find(".up_limit").html("Upper limit  greater than lower limit");
        }
        else
        {
            ele.find(".up_limit").html(''); 

        }
    }
});

$(document).on('click','.allowed',function() { 
    
    var ele_div=$(this).parents('.testdiv');
    var range_type_id=ele_div.find('.rangetype').find('.range_type').val();
    if(range_type_id==2)
    {
        var ele=$(this).parents('.radio_dropdown');
        var ele_final = ele.find('.key_value_div'); 
        ele_final.find('.allowed').not($(this)).removeAttr('checked',true);   
    }     

});