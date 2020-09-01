<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="row">
        <?php if(@$flag == 1) { ?>
        <div class="col-md-12">
            <div class="portlet light portlet-fit">
               <div class="portlet-body">
                <div class="row">
                    <div class="col-md-offset-3 col-md-6 well">
                        <div class="row">                       
                            <div class="col-md-12"> 
                                <form class="form-horizontal" action="<?php echo SITE_URL;?>plant_do_products" method="post">                                                            
                                    <div class="form-group">
                                        <label class="col-xs-5 control-label">Order For</label>
                                        <div class="col-xs-7">
                                            <select name="ordered_plant_id" class="form-control ordered_plant">
                                                <option value="">Select Plant</option>
                                                <?php foreach ($plant_block as  $block_id=>$value) {?>
                                                    <optgroup label="<?php echo $value['block_name'];?>">
                                                    <?php foreach ($value['plants'] as $key=>$row) {?>
                                                        <option value="<?php echo $row['plant_id'];?>"><?php echo $row['plant_name'];?></option>
                                                    <?php } 
                                                        ?></optgroup><?php
                                                    }?>
                                            
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-5 control-label">Lifting Point</label>
                                        <div class="col-xs-7">
                                            <select name="lifting_point_id" class="form-control lifting_point_id">
                                                <option value="">Select Lifting Point</option>
                                                <?php foreach ($lifting_points as  $block_id=>$value) {?>
                                                    <optgroup label="<?php echo $value['block_name'];?>">
                                                    <?php foreach ($value['plants'] as $key=>$row) {?>
                                                        <option value="<?php echo $row['plant_id'];?>"><?php echo $row['plant_name'];?></option>
                                                    <?php } 
                                                        ?></optgroup><?php
                                                    }?>
                                            
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-offset-5 col-md-6">
                                        <button type="submit" class="btn btn-info">Submit</button>
                                        <a href="<?php echo SITE_URL;?>" class="btn btn-default">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- loading Ajax Data(Pending Products Details)-->
                    <div class="col-md-12 divtable" style="display:none">                           
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <!-- Product Price Details-->
        <?php if(@$flag == 2) { ?>   
        <form class="form-horizontal" action="<?php echo SITE_URL;?>confirm_plant_do" method="post">
            <input type="hidden" name="lifting_point_id" value="<?php echo $lifting_point_id; ?>">
            <input type="hidden" name="ordered_plant_id" value="<?php echo $ordered_plant_id; ?>">
            <div class="col-md-12">               
                <div class="col-md-12">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                               <!--  <i class="fa fa-gift"></i> --> Ordered Products</div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse"> </a>
                            </div>
                        </div>
                        <div class="portlet-body">  
                            <?php
                            if(count($order_results)>0)
                            {
                            ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-xs-6 control-label">Delivery Order Number</label>
                                        <div class="col-xs-5">
                                            <p class="form-control-static"><b><?php 
                                                $do_number = get_current_serial_number(array('value'=>'do_number','table'=>'do','where'=>'created_time'));
                                            echo $do_number; ?></b></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-xs-6 control-label">Delivery Order Date</label>
                                        <div class="col-xs-5">
                                            <p class="form-control-static"><b><?php echo date('d-m-Y'); ?></b></p>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-xs-5 control-label">Stock Lifting Point</label>
                                        <div class="col-xs-7">
                                            <p class="form-control-static"><b><?php echo $lifting_point_name    ; ?></b></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-scrollable">
                                        <table class="table"> 
                                        <?php
                                        foreach($order_results as $key => $value) 
                                        { 
                                            $sno = 1; 
                                        ?>
                                            <thead>
                                                <th colspan="10"><?php echo "Order Booking No : " .$value['ob_lifting_point']. " / " .$value['order_number']. " / " .date('d-m-Y',strtotime($value['order_date']))?></th>
                                            </thead>
                                           
                                            <tr style="background-color:#cccfff">
                                                <td>S No</td>
                                                <td></td>
                                                <td>Product Name</td>                                                
                                                <td>Price</td>
                                                <td>Items Per Carton</td>
                                                <td>Ordered Qty</td>
                                                <td>Pending Qty</td> 
                                                <td>Lifting Qty</td>                                                
                                                <td>Total Amount</td>
                                            </tr>
                                            <tbody>
                                            <?php 
                                            foreach($value['ordered_products'] as $keys =>$values)
                                            { 
                                                if($values != '') 
                                                { ?>
                                                    <tr class="do_row">

                                                        <td><?php echo $sno++?></td>
                                                        <td><input class="ob_product" name="order_product[]" value="<?php echo $value['order_id']."_" . $values['product_id']?>" type="checkbox"></td>
                                                        <td>
                                                            <input type="hidden" name="product_name[<?php echo $value['order_id']?>][<?php echo $values['product_id']?>]" value="<?php echo $values['product_name']; ?>">
                                                            <?php echo $values['product_name']; ?>
                                                        </td>
                                                        <td>
                                                            <?php $price = $values['product_price'];
                                                            echo $price; ?>
                                                            <input type="hidden" class="price" name="price[<?php echo $value['order_id']?>][<?php echo $values['product_id']?>]" value="<?php echo $price;?>">
                                                        </td>
                                                        <td><input type="hidden" class="items_per_carton" name="items_per_carton[<?php echo $value['order_id']?>][<?php echo $values['product_id']?>]" value="<?php echo $values['items_per_carton']?>"> <?php echo intval($values['items_per_carton']); ?></td>
                                                        <td>
                                                            <input type="hidden" class="pending_qty" name="pending_qty[<?php echo $value['order_id']?>][<?php echo $values['product_id']?>]" value="<?php echo @$values['pending_qty']?>">
                                                            <input type="hidden" class="ordered_qty" name="ordered_qty[<?php echo $value['order_id']?>][<?php echo $values['product_id']?>]" value="<?php echo @$values['ordered_quantity']?>">
                                                            <?php echo  intval($values['ordered_quantity']);  ?>
                                                        </td>
                                                        <td><?php echo intval($values['pending_qty']); ?></td>
                                                        <td><input disabled="" class="lifting_qty" style="width:60px" type="text" name="lifting_qty[<?php echo $value['order_id']?>][<?php echo $values['product_id']?>]" value="<?php echo intval($values['pending_qty']); ?>" ></td>

                                                        
                                                        <td>

                                                            <span class="total_price">0</span>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                            </tbody>
                                           
                                        <?php
                                         }  // end foreach order_results
                                        
                                        
                                        ?>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-offset-5 col-md-3">
                                    <button type="submit" name="generate_plant_do" onclick="return confirm('Are you sure you want to Proceed?')" class="btn btn-success proceed_do" value="1">Proceed DO</button>
                                    <a href="<?php echo SITE_URL.'plant_do';?>" class="btn default">Cancel</a>
                                </div>
                                <div class="col-md-2">
                                    <p >Total Lifting Qty &nbsp;: &nbsp;<b class="total_lifting_qty">0</b></p>
                                </div>
                                 <div class="col-md-2">
                                    <input type="hidden" id="grand_total" name="grand_total"><p >Grand Total &nbsp;: &nbsp;<b class="grand_total">0</b></p>
                                 </div>
                            </div> 
                            <?php
                            } // end if
                            else{
                                ?>
                                <h4 align="center"> No Orders Found<h/4>
                                <?php
                            }
                            ?> 
                        </div>
                    </div>
                </div>
            </div>  
        </div>
        </form>
        <?php } ?>
    </div>
</div>

<?php $this->load->view('commons/main_footer', $nestedView); ?>
<script type="text/javascript">   
     $('.distributor_type').change(function(){
    var distributor_type_id = $(this).val();
   // alert(distributor_type_id);
    if(distributor_type_id=='')
    {
        $('.distributor').html('<option value="">-Select Distributor</option');
        
    }
    else
    {
        //alert(distributor_type_id);
        $.ajax({
            type:"POST",
            url:SITE_URL+'getDistributors',
            data:{distributor_type_id:distributor_type_id},
            cache:false,
            success:function(html){
                $('.distributor').html(html);
            }
        });
    }
});
$('.distributor').change(function(){
    var distributor_id=$(this).val();
    //alert(distributor);
    if(distributor_id!='')
    {
        //alert(distributor_id);
        $.ajax({
        type:"POST",
        url:SITE_URL+'getStockLiftingUnit',
        data:{distributor_id:distributor_id},
        cache:false,
        success:function(html){
            $('.stockLiftingUnit').html(html);
        }
    });
       
    }
    else
    {
         $('.stockLiftingUnit').html('<option value="">-Select Stock Lifting Unit</option');
    }

});

// select all checkboxes
    $("#select_all").change(function(){  //"select all" change
    var status = this.checked; // "select all" checked status
    $('.checkbox').each(function(){ //iterate all listed checkbox items
        this.checked = status; //change ".checkbox" checked status
        });
    });

    $('.checkbox').change(function(){ //".checkbox" change
        //uncheck "select all", if one of the listed checkbox item is unchecked
        if(this.checked == false){ //if this item is unchecked
            $("#select_all")[0].checked = false; //change "select all" checked status to false
        }
       
        //check "select all" if all checkbox items are checked
        if ($('.checkbox:checked').length == $('.checkbox').length ){
            $("#select_all")[0].checked = true; //change "select all" checked status to true
        }
    });

    $(document).on('change','.ob_product',function(){
         var do_row = $(this).closest('.do_row');
        if(this.checked)
        {
            do_row.find('.lifting_qty').prop('disabled',false);
            var price = parseFloat(do_row.find('.price').val());
            var items_per_carton = parseInt(do_row.find('.items_per_carton').val());
            var lifting_qty = parseFloat(do_row.find('.lifting_qty').val());
            //alert(price+'--'+items_per_carton+'--'+lifting_qty);
            var tot_price = (price*items_per_carton*lifting_qty).toFixed(2);
            do_row.find('.total_price').html(tot_price);
        }
        else
        {
            var pending_qty = parseInt(do_row.find('.pending_qty').val());
            do_row.find('.lifting_qty').prop('disabled',true).val(pending_qty);
            do_row.find('.total_price').html(0);
        }
        calculate_grand_total();

    });
  $(document).on('blur','.lifting_qty',function(){
     var qty = parseInt($(this).val());
     var do_row = $(this).closest('.do_row');
     var pending_qty = parseInt(do_row.find('.pending_qty').val());
     if(qty>pending_qty)
     {
        alert('Lifting Qty Should be less than Pending Qty');
        $(this).val(0);

     }
     var qty = parseInt($(this).val());
     var price = parseFloat(do_row.find('.price').val());
     var per_carton = parseInt(do_row.find('.items_per_carton').val());
     //alert(qty+'--'+price+'--'+per_carton);
     var total_price = (price*qty*per_carton).toFixed(2);
     do_row.find('.total_price').html(total_price);
     calculate_grand_total();
  });

  function calculate_grand_total()
  {
    var grand_total = 0;
     $('.total_price').each(function(){
         var total_price = $(this).html();
         
         if(total_price!='')
            grand_total += parseFloat(total_price);

     });
     $('.grand_total').html(grand_total.toFixed(2));

     var total_lifting_qty = 0;
     $('.lifting_qty:not(:disabled)').each(function(){
        var l_qty = parseInt($(this).val());
        if(l_qty!='')
            total_lifting_qty += l_qty;
     });
     $('.total_lifting_qty').html(total_lifting_qty);
  }

    $(document).on('change','.ordered_plant',function(){ 
    //alert("ok");
    $('.divtable').show();  
    var ordered_plant_id      =   $('.ordered_plant').val();
    //var lifting_point_id      =   $('.lifting_point_id').val();
    //alert(lifting_point_id);
    if(ordered_plant_id != '')
    {
        //alert(ob_type_id);
        $.ajax({
        type:"POST",
        url:SITE_URL+'get_plant_pending_dos',
        data:{ordered_plant_id:ordered_plant_id},
        cache:false,
        success:function(html){
            $('.divtable').html(html);
           if(html =='')
            {
                $('.divtable').hide();
            }
        }
    });
    }
    else
    {
        $('.divtable').hide();
    }
});

</script>