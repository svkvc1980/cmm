var leakageForm = function() {

    var handleleakageForm = function() {

        $('.leakage_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                    
                     no_of_pouches: {
                        required: 'leaked pouches are required'
                    },
                     no_of_cartons: {
                        required: 'leaked cartons are required'
                    },
                     product_id: {
                        required: 'Product is required'
                    },
                     recovered_oil: {
                        required: 'Recovered oil is required'
                    },
                    cartons: {
                        required: 'recovered cartons are required'
                    },
                    pouches :{
                         required: 'recovered pouches are required'
                    }
                },
                rules: {
                    
                    no_of_pouches: {
                        required: true
                    },
                    no_of_cartons: {
                        required: true
                    },
                    product_id: {
                                                
                        required: true
                    },
                    recovered_oil: {                                                
                        required: true
                    },
                    pouches: {
                        required: true
                    },
                    cartons: {
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

        $('.leakage_form input').keypress(function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('.leakage_form').validate().form()) {
                    $('.leakage_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }
    return {
        //main function to initiate the module
        init: function() {
            handleleakageForm();
        }

    };

}();

jQuery(document).ready(function() {
    leakageForm.init();
});

$(document).on('change','.product',function(){
 var product_id= $(this).val();
  $.ajax({
        type:"POST",
        url:SITE_URL+'get_carton_per_product',
        data:{product_id:product_id},
        cache:false,
        success:function(html)
        { 
            $('.items_per_carton').val(html);
            $('.pouches').val('');
             $('.no_of_pouches').val('');
            $('.no_of_cartons').val('');
            $('.cartons').val('');
            $('.recovered_oil').val('');
        }
    });
});
$(document).on('change','.type,.no_of_pouches,.no_of_cartons',function(){
   var no_of_cartons=parseInt($('.no_of_cartons').val());
   var type=$('input[name="type"]:checked').val();
   var no_of_pouches=parseInt($('.no_of_pouches').val());
   var items_per_carton=parseInt($('.items_per_carton').val());
   var arr_carton=(no_of_cartons*items_per_carton)-(no_of_pouches);
   var cartons=(arr_carton)/(items_per_carton);
   var pouches=arr_carton-(parseInt(cartons)*items_per_carton);
   var pouch_size = no_of_cartons*items_per_carton;
   $('.no_of_pouches').attr('max',pouch_size);
  // alert(no_of_pouches+'hi'+no_of_cartons+'hi'+items_per_carton);
  if(isNaN(pouches)) {
     var pouches = 0;
    }
 if(isNaN(cartons)) {
     var cartons = 0;
    }
   if(type==1)
   {
       $('.pouches').val(pouches).attr('readonly','readonly');
       $('.cartons').val(parseInt(cartons)).attr('readonly','readonly');
   }
   else if(type ==2)
   {

     $('.pouches').val(pouches);
     $('.cartons').val(parseInt(cartons)).removeAttr('readonly');
   }
});
$(document).on('blur','.pouches,.cartons',function(){

   var no_of_cartons=parseInt($('.no_of_cartons').val());
   var type=$('input[name="type"]:checked').val();
   var no_of_pouches=parseInt($('.no_of_pouches').val());
   var items_per_carton=parseInt($('.items_per_carton').val());
   var arr_carton=(no_of_cartons*items_per_carton)-(no_of_pouches);
   var cartons=(arr_carton)/(items_per_carton);
   var pouches=arr_carton-(parseInt(cartons)*items_per_carton);
   var re_cartons=$('.cartons').val();
   var re_pouches=$('.pouches').val();
   var re_arr_cartons=(re_cartons*items_per_carton);
   $('.cartons').attr('max',no_of_cartons-1);
   if(type ==2)
   {
    // if(re_arr_cartons<=arr_carton)
     //{
        var cartons1=(re_arr_cartons)/(items_per_carton);
        var pouches1=arr_carton-re_arr_cartons;
        $('.pouches').val(pouches1);
        $('.cartons').val(parseInt(cartons1)).removeAttr('readonly');
    /* }
     else
     {
         $('.pouches').val(pouches).removeAttr('readonly');
        $('.cartons').val(parseInt(cartons)).removeAttr('readonly');
     }*/
   }
});