var news = function() {

    var handlenews = function() {

        $('#news_frm').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                title: {
                    required: true
                },
                event_date: {
                    required:true
                },
                event_time: {
                   maxlength: 100
                },
                event_location: {
                   maxlength: 255
                },
                description:{
                    required: true
                }
            },

            messages: {
                title: {
                    required: "Title can not be empty."
                },
                event_date:{
                    required: "Event Date can not be empty."
                },
                event_time: {
                   maxlength: "Cannot exceed 100 characters."
                },
                event_location: {
                    maxlength: "Cannot exceed 255 characters."
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
                    //$(window).scrollTop(0);
            },


            submitHandler: function(form) {
                form.submit(); // form validation success, call ajax form submit
            }
        });

        $('#news_frm input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#news_frm').validate().form()) {
                    $('#news_frm').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handlenews();
        }

    };

}();

jQuery(document).ready(function() {
    news.init();
});