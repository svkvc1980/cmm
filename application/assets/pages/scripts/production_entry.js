var production_entryForm = function() {

    var handleproduction_entryForm = function() {

        $('#production_entry_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: 
            {
                'product_id[]':{
                    required:'please fill product'
                },
                'quantity[]':{
                    required:'please fill quantity'
                }

            },
            rules: {
                'product_id[]':{
                    required:true
                },
                'quantity[]':{
                    required:true
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   
                //$('.alert-danger', $('.reset-form')).show();
            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group,.dummy').addClass('has-error'); // set error class to the control group
            },

            success: function(label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group,.dummy').removeClass('has-error').addClass('has-success'); // set success class to the control group
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

        $('#production_entry_form input').on('keypress',function(e) {
            //alert('1213');
            if (e.which == 13) {
                if ($('#production_entry_form').validate().form()) {
                    $('#production_entry_form').submit(); //form validation success, call ajax form submit
                }
                return false;                    
            }
        });
    }




    return {
        //main function to initiate the module
        init: function() {
            handleproduction_entryForm();
        }

    };

}();
jQuery(document).ready(function() {
    production_entryForm.init();
});
/*$('.remove_product_row').on('click',function(){
    if(confirm('are you sure to delete bank details?'))
    {
        $(this).closest('tr').remove();
    }
});*/

$(document).on('click','#add_product',function()
{    
    var ele = $('.product_table').find('tbody').find('tr:last');  
    var ele_clone = ele.clone();
    ele_clone.find('input, select').val('');
    //ele_clone.find('.pm_id,.micron_id').html('');
    ele_clone.find('.pm_id_cls,.micron_id_cls').addClass('hidden');
    ele_clone.find('.sachets').html('');
    ele_clone.find('.cal_oil_wt').html('');
    ele_clone.find('.previous_lp').html('');
    ele_clone.find('td div.dummy').removeClass('has-error has-success');
    ele_clone.find('td div.input-icon i').removeClass('fa-check fa-warning');
    ele_clone.find('td:last').show();
    ele_clone.find('.remove_product_row').click(function() {      
        $(this).closest('tr').remove();
    });
    ele.after(ele_clone);
    ele_clone.show();
});

$('.remove_product_row').click(function() {      
        $(this).closest('tr').remove();
    });

$(document).on('change','.product_id',function(){    
    var ele = $(this).closest('tr');
    ele.find('input').val('');
    ele.find('.sachets').html('');
    ele.find('.cal_oil_wt').html('');
    var product_id=ele.find('.product_id').val();    
    if(product_id!='')
    {
        $.ajax({
            type: "POST",
            url: SITE_URL+"Ajax_ci/get_product_stock",
            data:'product_id='+product_id,
            datatype:'json',
            success: function(data){
                var arr1 = jQuery.parseJSON(data);
                //alert(arr['film_pm_data']);
                
                var arr = arr1['stock_data'];
                //alert(data);
                ele.find('.per_carton').val(arr['items_per_carton']);
                ele.find('.oil_weight').val(arr['oil_weight']);
                //alert(arr['loose_pouches']);
                if(arr['loose_pouches'] !='')
                {
                    var lp = arr['loose_pouches'];
                }
                else
                {
                    var lp = 0;
                }
                if(arr1['film_pm_data'] ==0)
                {
                    ele.find('.pm_id_cls,.micron_id_cls').addClass('hidden');
                    ele.find('.pm_id').html('<option value=""></option');
                    ele.find('.micron_id').html('<option value=""></option');
                    /*ele.find(".pm_id").html('<option value="">-No Films-</option');
                    ele.find(".micron_id").html('<option value="">-No Micron Type-</option');*/
                }
                else
                {
                    ele.find('.pm_id_cls,.micron_id_cls').removeClass('hidden');
                    ele.find('.pm_id').html(arr1['film_pm_data']);
                    ele.find('.micron_id').html(arr1['micron_data']); 
                }
                //alert(lp);
                ele.find('.previous_lp').html(lp);
                ele.find('.hidden_previous_lp').val(lp);
                //alert(ele.find('.oil_weight').val());
               // ele.find('.per_carton').val(data.per_carton);
            }
        });
    }
    else
    {
         ele.find('.per_carton').val('');
    }

});

$(document).on('change','.qty,.current_lp',function(){    
    var ele = $(this).closest('tr');
    var qty=ele.find('.qty').val();  
    var product_id=ele.find('.product_id').val(); 
    var per_carton=ele.find('.per_carton').val(); 
    var oil_weight=ele.find('.oil_weight').val();
    var previous_lp=ele.find('.previous_lp').html();
    var current_lp=ele.find('.current_lp').val();     
      
    if(product_id!='' && qty!='')
    {   
        /*alert(qty);
        alert(per_carton);
            alert(previous_lp);*/
        
        if(current_lp == '')
            current_lp =0; 
        //alert(current_lp); 
        var ex_lp = parseInt(qty*per_carton) + parseInt(current_lp);
        //alert(ex_lp);
        var sachets = ex_lp-previous_lp;
       //alert(sachets);
        var cal_oil_wt = (oil_weight*sachets);
        ele.find('.sachets').html(sachets);
        ele.find('.cal_oil_wt').html(cal_oil_wt.toFixed(2));
        ele.find('.hidden_sachets').val(sachets);
        //ele.find('.hidden_previous_lp').val(sachets);
        ele.find('.hidden_cal_oil_wt').val(cal_oil_wt.toFixed(2));

         
    }
    else
    {
         alert('please select product');
    }


    /*if(product_id!=''){
        $.ajax({
            type: "POST",
            url: SITE_URL+"Ajax_ci/get_packing_material_and_micron",
            data:'product_id='+product_id,
            datatype:'json',            
            success: function(data){           
            
            if(data.film_pm_data == 0) 
            {
                
                ele.find(".pm_id").html('<option value="">-No Packing Material-</option');
                ele.find(".micron_id").html('<option value="">-No Micron-</option');
            }
            else
            {
                ele.find('.pm_id').html(data.film_pm_data); 
                ele.find('.micron_id').html(data.micron_data);        
            }
        }
        });
    }*/




});




