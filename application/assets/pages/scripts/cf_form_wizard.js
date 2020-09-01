var FormWizard = function () {


    return {
        //main function to initiate the module
        init: function () {
            if (!jQuery().bootstrapWizard) {
                return;
            }

            function format(state) {
                if (!state.id) return state.text; // optgroup
                return "<img class='flag' src='../../assets/global/img/flags/" + state.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
            }

            var form = $('#submit_form');
            var error = $('.alert-danger', form);
            var success = $('.alert-success', form);

            form.validate({
                doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                rules: {
                    //account
                    cf_name: {
                        
                        required: true
                    },
                    region_cf:{
                        required:true
                    },
                    
                    state: {
                        required: true
                    },
                    
                    city: {
                        required: true
                    },
                    region: {
                        required: true
                    },
                    district: {
                        required: true
                    },
                    concerned_person: {
                        required: true
                    },
                    mobile_number: {
                        required: true,
                        number:true,
                        maxlength:10
                    },
                    alternate_mobile_no : {
                        number:true,
                        maxlength:10
                    },
                    vat_no:{
                        required:true
                    },
                    adhar_no :{
                        required:true
                    },
                    pan_no :{
                        required: true
                    },
                    tan_no : {
                        required: true
                    },
                    sd_amount : {
                        required: true
                    },
                    agr_start_date : {
                        required : true
                    },
                    agr_exp_date : {
                        required : true
                    },
                    'bank_type[]' :{
                        required:true
                    },
                    'ifsc_code[]' : {
                        required:true
                    },
                    'account_no[]' : {
                        required:true
                    },
                    'bg_amount[]' : {
                        required:true
                    },
                    'start_date[]' : {
                        required:true
                    },
                    'end_date[]' : {
                        required:true
                    }
                },

                messages: { // custom messages for radio buttons and checkboxes
                    'payment[]': {
                        required: "Please select at least one option",
                        minlength: jQuery.validator.format("Please select at least one option")
                    }
                },

                

                invalidHandler: function (event, validator) { //display error alert on form submit   
                    success.hide();
                    error.show();
                    App.scrollTo(error, -200);
                },

                highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('div.form-group ,.dummy').addClass('has-error'); // set error class to the control group
            },

            success: function(label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('div.form-group ,.dummy').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("fa-warning").addClass("fa-check");
            },

            errorPlacement: function(error, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    icon.removeClass('fa-check').addClass("fa-warning");  
                    icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
            },


            submitHandler: function(form) {
                form[0].submit(); // form validation success, call ajax form submit
            }

            });

            var displayConfirm = function() {
                $('#tab4 .form-control-static', form).each(function(){
                    var input = $('[name="'+$(this).attr("data-display")+'"]', form);
                    if (input.is(":radio")) {
                        input = $('[name="'+$(this).attr("data-display")+'"]:checked', form);
                    }
                    if (input.is(":text") || input.is("textarea")) {
                        $(this).html(input.val());
                    } else if (input.is("select")) {
                        $(this).html(input.find('option:selected').text());
                    } else if (input.is(":radio") && input.is(":checked")) {
                        $(this).html(input.attr("data-title"));
                    } else if ($(this).attr("data-display") == 'payment[]') {
                        var payment = [];
                        $('[name="payment[]"]:checked', form).each(function(){ 
                            payment.push($(this).attr('data-title'));
                        });
                        $(this).html(payment.join("<br>"));
                    }
                });
            }

            var handleTitle = function(tab, navigation, index) {
                var total = navigation.find('li').length;
                var current = index + 1;
                // set wizard title
                $('.step-title', $('#form_wizard_1')).text('Step ' + (index + 1) + ' of ' + total);
                // set done steps
                jQuery('li', $('#form_wizard_1')).removeClass("done");
                var li_list = navigation.find('li');
                for (var i = 0; i < index; i++) {
                    jQuery(li_list[i]).addClass("done");
                }

                if (current == 1) {
                    $('#form_wizard_1').find('.button-previous').hide();
                } else {
                    $('#form_wizard_1').find('.button-previous').show();
                }

                if (current >= total) {
                    $('#form_wizard_1').find('.button-next').hide();
                    $('#form_wizard_1').find('.button-submit').show();
                    displayConfirm();
                } else {
                    $('#form_wizard_1').find('.button-next').show();
                    $('#form_wizard_1').find('.button-submit').hide();
                }
                App.scrollTo($('.page-title'));
            }

            // default form wizard
            $('#form_wizard_1').bootstrapWizard({
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
                onTabClick: function (tab, navigation, index, clickedIndex) {
                    return false;
                    
                    success.hide();
                    error.hide();
                    if (form.valid() == false) {
                        return false;
                    }
                    
                    handleTitle(tab, navigation, clickedIndex);
                },
                onNext: function (tab, navigation, index) {
                    success.hide();
                    error.hide();

                    if (form.valid() == false) {
                        return false;
                    }

                    handleTitle(tab, navigation, index);
                },
                onPrevious: function (tab, navigation, index) {
                    success.hide();
                    error.hide();

                    handleTitle(tab, navigation, index);
                },
                onTabShow: function (tab, navigation, index) {
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    var $percent = (current / total) * 100;
                    $('#form_wizard_1').find('.progress-bar').css({
                        width: $percent + '%'
                    });
                }
            });

            $('#form_wizard_1').find('.button-previous').hide();
            $('#form_wizard_1 .button-submit').click(function () {
                
            }).hide();

            //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
            $('#country_list', form).change(function () {
                form.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
        }

    };

}();
jQuery(document).ready(function() {
    FormWizard.init();
});
$('#add_bank_info').click(function()
{
    
    var ele = $('#bank_table').find('tbody').find('tr:last');  
    var ele_clone = ele.clone();
    ele_clone.find('.start_date').datepicker();  
    ele_clone.find('.end_date').datepicker();    
    ele_clone.find('input, select').attr("disabled", false).val('');
    ele_clone.find('td div.dummy').removeClass('has-error has-success');
    ele_clone.find('td div.dummy div.input-icon i').removeClass('fa-check fa-warning');
    ele_clone.find('td:last').show();
    ele_clone.find('#remove_bank_row').click(function() {      
        $(this).closest('tr').remove();
    });
    ele.after(ele_clone);
    ele_clone.show();
});



$('.state_cf').change(function(){
    
    $('.region_cf').prev('i').removeClass('fa-check').removeClass('fa-warning').addClass('fa');
    $('.region_cf').closest('div.form-group').removeClass('has-success').removeClass('has-error');
    $('.district_id').prev('i').removeClass('fa-check').removeClass('fa-warning').addClass('fa');
    $('.district_id').closest('div.form-group').removeClass('has-success').removeClass('has-error');
    $('.area').prev('i').removeClass('fa-check').removeClass('fa-warning').addClass('fa');
    $('.area').closest('div.form-group').removeClass('has-success').removeClass('has-error');
    var state_id = $(this).val();
    
    if(state_id=='')
    {
        $('.region_cf').html('<option value="">-Select Region-</option');
        $('.region_cf').change();
        $('.region_cf').closest('div.form-group').addClass('hidden');
        $('.district_id').closest('div.form-group').addClass('hidden');
        $('.district_id').change();
    }
    else
    {
        $.ajax({
            type:"POST",
            url:SITE_URL+'getregionListcf',
            data:{state_id:state_id},
            cache:false,
            success:function(html){
                $('.region_cf').html(html);
                $('.region_cf').closest('div.form-group').removeClass('hidden');
                $('.district_id').closest('div.form-group').addClass('hidden');
                $('.region_cf').change();
                $('.district_id').change();
            }
        });
    }
});

$('.region_cf').change(function(){
    $('.district_id').prev('i').removeClass('fa-check').removeClass('fa-warning').addClass('fa');
    $('.district_id').closest('div.form-group').removeClass('has-success').removeClass('has-error');
    var region_id = $(this).val();
    if(region_id=='')
    {
        $('.district_id').html('');
        $('.district_id').change();
        $('.district_id').closest('div.form-group').addClass('hidden'); 
    }
    else
    {
        $.ajax({
            type:"POST",
            url:SITE_URL+'getdistrictListcf',
            data:{region_id:region_id},
            cache:false,
            success:function(html){
                $('.district_id').html(html);
                $('.district_id').closest('div.form-group').removeClass('hidden');
            }
        });
    }
});