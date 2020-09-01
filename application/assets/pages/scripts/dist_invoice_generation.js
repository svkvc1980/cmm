/*$(document).ready(function(){
    var value = 1;
    $("input[name=invoice_type][value=" + value + "]").prop('checked', true);
    $('#scheme_id').val('');
});
*/
$(document).on('click','.invoice_type',function(){
    if($(this).val() == 1)
    {
        $('.schemes_dropdown').addClass('hidden');
        $('#scheme_id').val('');
         $('#scheme_id').prop('required',false);

    }
    else
    {   $('#scheme_id').prop('required',true);
        $('.schemes_dropdown').removeClass('hidden');
    }
});

    $(document).on('change','.do_product',function(){


         var do_row = $(this).closest('.i_row');
         var stock_qty = parseInt(do_row.find('.stock_qty').val());
         var pending_qty = parseInt(do_row.find('.pending_qty').val());
         var lifting_qty = (pending_qty<stock_qty)?pending_qty:stock_qty;
        if(this.checked)
        {
            //alert(stock_qty);
           if(stock_qty == 0)
           {
                alert('you can\'t genetate invoice for this product')
                do_row.find('.lifting_qty').prop('disabled',true).val(0);
                
                do_row.find('.do_product').attr("checked",false);
                do_row.find('.total_price').html(0);
                /*event.preventDefault();
                return false;*/
            
            }
            else
            {

                do_row.find('.lifting_qty').prop('disabled',false);
                var items_per_carton = parseInt(do_row.find('.items_per_carton').val());
                var price = parseFloat(do_row.find('.price').val());
                var total_price = lifting_qty*items_per_carton*price;
                //alert(pending_qty+'--'+items_per_carton+'--'+price);
                do_row.find('.total_price').html(total_price.toFixed(2));
                do_row.find('.total_price_val').html(total_price.toFixed(2));
            }
        }
        else
        {
            do_row.find('.lifting_qty').prop('disabled',true).val(lifting_qty);
            do_row.find('.total_price').html(0);

        }
        calculate_grand_total();
        calculate_total_lifting_qty();

    });

  $(document).on('blur','.lifting_qty',function(){

     var qty = parseInt($(this).val());

     var do_row = $(this).closest('.i_row');
     var stock_qty = parseInt(do_row.find('.stock_qty').val());
     var pending_qty = parseInt(do_row.find('.pending_qty').val());
     if(qty > stock_qty)
     {
        alert('Invoice Qty Should be less than Stock Qty');
        $(this).val(0);
     }
     if( qty > pending_qty)
     {
        alert('Invoice Qty Should be less than Pending Qty');
        $(this).val(0);
     }
     // checking total lifting quantity to perticular product
    var product_id = $(this).data('product-id');
    var t_qty = 0;
    var product_stock = $('.inv_stock_qty'+product_id).val();
    $('.inv_qty'+product_id).each(function(index){
        var lifting_qty = $(this).val();
        if(lifting_qty!='')
        {
            t_qty += parseFloat(lifting_qty);   
            if(t_qty > product_stock)
            {
                alert('invoice quantity exceeds stock quantity');
                $(this).val('');        
            }
        }
    });

     var qty = parseInt($(this).val());
     var price = do_row.find('.price').val();
     var per_carton = do_row.find('.items_per_carton').val();
     //alert(qty+'--'+price+'--'+per_carton);

     var total_price = (price*qty*per_carton).toFixed(2);
     do_row.find('.total_price').html(total_price);
     do_row.find('.total_price_val').val(total_price);


     calculate_grand_total();
     calculate_total_lifting_qty();

  });


function calculate_total_lifting_qty()
  {
    var total_lif_qty = 0;
     $('.lifting_qty:not(:disabled)').each(function(){
         var lifting_qty = $(this).val();
           if(lifting_qty!='')
            total_lif_qty += parseFloat(lifting_qty);
     });
     $('.total_lifting_qty').html(total_lif_qty);
     $('.total_lifting_qty_val').val(total_lif_qty);
  }
  function calculate_grand_total()
  {
    var grand_total = 0;
     $('.total_price').each(function(){
         var total_price = $(this).html();
           if(total_price!='')
            grand_total += parseFloat(total_price);
     });
     $('.grand_total').html(grand_total.toFixed(2));
     $('.grand_total_val').val(grand_total.toFixed(2));
  }

$('#incl_pm').click(function(){

    if($(this).is(':checked')){
        $('.radio_dropdown').removeClass('hidden');
    }
    else
    {
        $('.radio_dropdown').addClass('hidden');
        $('.radio_dropdown').not('.radio_dropdown:first').remove();
        $('.radio_dropdown:first').find('input, select').val('');
        
    }

});

$('.mybutton').click(function(){                      
    var ele_clone = $('.radio_dropdown:last').clone();
    ele_clone.find('input, select').val('');                  
    ele_clone.find('.mybutton').remove();
    ele_clone.find('.deletebutton').addClass('show');    
    $('.radio_dropdown:last').after(ele_clone);
}); 

$(document).on('click','.deletebutton',function() {      
    $(this).closest('.radio_dropdown').remove();                       
});