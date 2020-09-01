var pm_tenders_form = function() {

    var handlepm_tenders_form = function() {

        $('#pm_tenders_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                'broker_name[1]':{
                    required: 'Broker cannot be empty'
                },
                'supplier_name[1]':{
                    required: 'Supplier cannot be empty'
                },
                'quoted_rate[1]':{
                    required: 'Quoted Rate cannot be empty'
                }
            },
            rules: 
            {
               'broker_name[1]': {
                     required: true
                },
                'supplier_name[1]': {
                     required: true
                },
                'quoted_rate[1]': {
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

        $('#pm_tenders_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#pm_tenders_form').validate().form()) {
                    $('#pm_tenders_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handlepm_tenders_form();
            
        }

    };

}();

jQuery(document).ready(function() {
    pm_tenders_form.init();
});

var counter = 2;
$("#add").click(function(){
    var ele = $('#tender').find('tbody').find('tr.srow:first');  
    var ele_clone = ele.clone();
    ele_clone.find('input, select').attr("disabled", false).val('');
    ele_clone.find('td div.form-group').removeClass('has-error has-success');
    ele_clone.find('td div.form-group div.input-icon i').removeClass('fa-check fa-warning');
    ele_clone.find('td:last').show();
    // replaces [1] with new counter value [counter] at all name occurances
    ele_clone.html(function(i, oldHTML) {
        return oldHTML.replace(/\[1\]/g, '['+counter+']');
    });

    ele_clone.html(function(i, oldHTML) {
        return oldHTML.replace(/support\_document\_1/g,'support\_document\_'+counter);
    });
    //alert(ele_clone.html());
    $('.srow:last').after(ele_clone);
    ele_clone.show();   
    counter++;
    return false;
});
$(document).on('click','.remove_tender',function(){      
    $(this).closest('tr').remove();
});