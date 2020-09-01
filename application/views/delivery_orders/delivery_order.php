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
                    <div class="col-md-offset-2 col-md-8 well">
                        <div class="row">                       
                            <div class="col-md-12"> 
                                <form class="form-horizontal" action="<?php echo SITE_URL;?>delivery_order_details" method="post">                         
                                    <div class="form-group">
                                        <label class="col-xs-3 control-label">Delivery Order Type</label>
                                        <div class="col-xs-9">
                                           <select class="form-control distributor_type" name="order_type" required>
                                                <option value="">- Select Type -</option>
                                                <?php foreach($distributor_type as $row) { ?>
                                                <option value="<?php echo $row['ob_type_id']?>"><?php echo $row['name']?></option>
                                                <?php } ?>
                                           </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-3 control-label">Distributor</label>
                                        <div class="col-xs-9">
                                           <select class="form-control distributor select2" name="distributor_id" required>
                                                <option value="">- Select Distributor -</option>
                                           </select>
                                        </div>
                                    </div>
                                    <div class="form-group hidden institutional">
                                        <label class="col-xs-3 control-label">DO in the name of</label>
                                        <div class="col-xs-9">
                                           <select class="form-control do_for select2" name="do_for">
                                                <option value="">- Select Agency -</option>
                                           </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-3 control-label">Stock Lifting Unit</label>
                                        <div class="col-xs-9">
                                           <select class="form-control stockLiftingUnit" name="stock_lifting_unit_id" required>
                                                <option>Select Stock Lifting Unit</option>
                                           </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-offset-5 col-md-6">
                                        <button class="btn btn-info">Submit</button>
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
        <!-- Distributor Details,Bank Guarantee and Product Price Details-->
        <?php if(@$flag == 2) { ?>   
        <form class="form-horizontal" action="<?php echo SITE_URL;?>confirm_delivery_order" method="post">
            <input type="hidden" name="ob_type_id" value="<?php echo $ob_type_id;?>">
            <input type="hidden" name="distributor_id" value="<?php echo $distributor_id;?>">
            <input type="hidden" name="stock_lifting_unit_id" value="<?php echo $stock_lifting_unit_id;?>">
            <input type="hidden" name="do_for" value="<?php echo @$do_for;?>">
            <div class="col-md-12">
                <div class="col-xs-6">
                    <div class="portlet box green distributor_address">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-map-marker"></i> Distributor Address </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                            </div>
                        </div>
                        <div class="portlet-body" style="display: block; height:248px;"> 
                            <div class="col-md-12">
                                <p><b>Agency Name</b> &nbsp; <?php echo $distributor_details[0]['agency_name'].' ('.$distributor_details[0]['distributor_code'].')'?></p>    
                            </div> 
                            <div class="col-sm-6">                              
                                <p><b>Mobile</b> &nbsp; 91+<?php echo $distributor_details[0]['mobile']?></p>   
                                <p><b>SD Amount</b> &nbsp; <?php echo (intval($distributor_details[0]['sd_amount']))?></p>
                                <p><b>Agreement Start</b> &nbsp; <?php echo date('d-m-Y',strtotime($distributor_details[0]['agreement_start_date']))?></p>   </div>
                            <div class="col-sm-6">                              
                                <p><b>Phone</b> &nbsp;  <?php echo $distributor_details[0]['landline']?></p>
                                <p><b>Total Outstanding</b> &nbsp; <?php echo (intval($distributor_details[0]['outstanding_amount']))?></p>
                                <p><b>Agreement Expire</b> &nbsp; <?php echo date('d-m-Y',strtotime($distributor_details[0]['agreement_end_date']))?></p>
                            </div>
                            <div class="col-md-12">
                                <b>Address </b>
                                <?php
                                $location = array();
                                if($distributor_details[0]['address']!='')
                                    $location[] = trim($distributor_details[0]['address'],', ');
                                if($distributor_details[0]['distributor_place']!='')
                                    $location[] = $distributor_details[0]['distributor_place'];
                                echo implode(', ',$location);
                                ?>
                            </div>
                            <?php
                            if($do_for>0)
                            {
                            ?>
                            <div class="col-md-12" style="margin-top:10px;">
                                <b>DO in the name of: </b>
                                <?php
                                $do_distributor = get_distributor_details_by_id($do_for);
                                echo $do_distributor['agency_name'].' ['.$do_distributor['distributor_code'].'] ['.$do_distributor['distributor_place'].']';
                                ?>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="portlet box green distributor_bg_list">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-bank"></i> Bank Guarantee </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                            </div>
                        </div>
                        <div class="portlet-body" style="display: block; height:248px;">                           
                              <table class="table table-striped table-bordered table-hover order-column table-fixed" id="sample_1">
                                <thead style="display:table;table-layout:fixed;width:100%">
                                    <tr>
                                        <th width="30"> S.No</th>
                                        <th width="65"> Start Date </th>
                                        <th width="65"> Expire Date </th> 
                                        <th width="160"> Bank </th>
                                        <th width="65"> BG Amount </th>             
                                    </tr>
                                </thead>
                                <tbody style="display:block;height:140px;table-layout:fixed;overflow:auto">
                                <?php 
                                $sn=1;
                                foreach($bank_guarantee_details as $row) { 
                                    $cur_date = date('Y-m-d');
                                    $days_diff = get_no_of_days_between_two_dates($row['end_date'],$cur_date);
                                    $going_to_expire_days = get_going_to_expire_days();
                                    ?>
                                    <tr style="display:table;width:100%;table-layout:fixed">
                                        <td width="30"><?php echo $sn++;?></td>
                                        <td width="65"><?php echo date('d-m-Y',strtotime($row['start_date'])); ?></td>
                                        <td width="65"><?php echo date('d-m-Y',strtotime($row['end_date'])); ?></td>
                                        <td width="160"><?php echo $row['bank_name'];

                                        // IF bank guarantee going to expire
                                        if($days_diff>=0&&$days_diff<=$going_to_expire_days)
                                        {
                                            $exp_str = ($days_diff==0)?'Today':'in '.$days_diff.' days';
                                            echo '<p class="font-yellow-gold bold">Going to Expire '.$exp_str.'</p>';
                                        }
                                         ?></td>
                                        <td width="65" align="right"><?php echo ($row['bg_amount']); 

                                        // IF bank guarantee expired
                                        if($days_diff<0)
                                        {
                                            echo '<p class="font-red-thunderbird bold">Expired</p>';
                                        }
                                        ?></td>
                                    </tr>                                   
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr style="display:table;width:100%;table-layout:fixed">
                                        <td colspan="5" align="right"><b>Total Amount:</b> &nbsp; <?php echo ($total_bg_amount) ?></td>
                                    </tr></tfoot>
                            </table>
                            <input type="hidden" name="available_amt" value="<?php echo $available_amount;?>">
                            <p align="right"><b>Available Amount:</b> &nbsp; <?php echo ($available_amount) ?></p>
                        </div> 
                    </div>
                </div>
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
                                            <p class="form-control-static"><b><?php echo $lifting_point_name; ?></b></p>
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
                                                        <td><input class="ob_product product<?php echo $values['product_id'];?>" name="order_product[]" data-productId="<?php echo $values['product_id'];?>" value="<?php echo $value['order_id']."_" . $values['product_id']?>" type="checkbox"></td>
                                                        <td>
                                                            <input type="hidden" name="product_name[<?php echo $value['order_id']?>][<?php echo $values['product_id']?>]" value="<?php echo $values['product_name']; ?>">
                                                            <?php echo $values['product_name']; ?>
                                                        </td>
                                                        <td>
                                                            <?php $price = $values['product_price']+$values['add_price'];
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
                                                        <td><input disabled="" class="lifting_qty" style="width:60px" type="text" name="lifting_qty[<?php echo $value['order_id']?>][<?php echo $values['product_id']?>]" value="<?php echo round(@$values['pending_qty']);?>" ></td>

                                                        
                                                        <td><span class="total_price">0</span></td>
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
                                    <button type="submit" name="generate_do" onclick="return confirm('Are you sure you want to Proceed?')" class="btn btn-success" value="1">Proceed DO</button>
                                    <a href="<?php echo SITE_URL.'delivery_order';?>" class="btn default">Cancel</a>
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
    if(distributor_type_id=='2'||distributor_type_id=='4')
    {
        $('.institutional').removeClass('hidden');
    }
    else{
        $('.institutional').addClass('hidden');
    }
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
            data:{ob_type_id:distributor_type_id},
            cache:false,
            success:function(html){
                $('.distributor').html(html);
                $('.distributor').change();
                $('.stockLiftingUnit').change();
            }
        });
    }
});
$('.distributor').change(function(){
    var distributor_id=$(this).val();
    var order_type =   $('.distributor_type').val();
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

        //alert(order_type);
        if(order_type=='2'||order_type=='4')
        {
            //alert('hi');
            // Get Institutions
            $.ajax({
                type:"POST",
                url:SITE_URL+'get_institutions',
                data:{distributor_id:distributor_id},
                cache:false,
                success:function(html){
                    $('.do_for').html(html);           

                }
            });
        }
       
    }
    else
    {
         $('.stockLiftingUnit').html('<option value="">-Select Stock Lifting Unit</option');
         $('.stockLiftingUnit').change();
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
         var ob_product = $(this);
         var flag = false;
         var productId = $(this).attr('data-productId');
         var all_ob_products = $('.product'+productId);
         var cur_index = all_ob_products.index(ob_product);
         //alert(cur_index);
        if(this.checked)
        {
            
            //alert(productId);
            /*** CHECKING IF SAME PRODUCT SELECTED IN PREVIOUS ORDERS**/
            $('.product'+productId).each(function( index ) {

                //alert(index);
                if(index>=cur_index)
                {
                    return false;
                }
                    
                if(!this.checked)
                {
                    alert('Clear the Previous Order for this Product');
                    ob_product.prop('checked',false);
                    flag = true;
                    return false;
                }
            });
            if(flag){
                //alert('exiting');
                return false;
                
            }
            do_row.find('.lifting_qty').prop('disabled',false);
            var price = parseFloat(do_row.find('.price').val());
            var items_per_carton = parseInt(do_row.find('.items_per_carton').val());
            var lifting_qty = parseFloat(do_row.find('.lifting_qty').val());
            //alert(price+'--'+items_per_carton+'--'+lifting_qty);
            var tot_price = price*items_per_carton*lifting_qty;
            tot_price = tot_price.toFixed(2);
            do_row.find('.total_price').html(tot_price);
        }
        else
        {
            /*** CHECKING IF SAME PRODUCT SELECTED IN PREVIOUS ORDERS**/
            $('.product'+productId).each(function( index ) {

                //alert(index);
                if(index>cur_index)
                {
                    if(this.checked)
                    {
                        alert('Wrong Operation');
                        ob_product.prop('checked',true);
                        flag = true;
                        return false;
                    }
                }
            });
            if(flag){
                //alert('exiting');
                return false;
                
            }
            do_row.find('.lifting_qty').prop('disabled',true);
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
        $(this).val(pending_qty);

     }
     var qty = parseInt($(this).val());
     var price = do_row.find('.price').val();
     var per_carton = do_row.find('.items_per_carton').val();
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
     grand_total = grand_total.toFixed(2);
     $('.grand_total').html(grand_total);
     $('#grand_total').val(grand_total);

     var total_lifting_qty = 0;
     $('.lifting_qty:not(:disabled)').each(function(){
        var l_qty = parseInt($(this).val());
        if(l_qty!='')
            total_lifting_qty += l_qty;
     });
     $('.total_lifting_qty').html(total_lifting_qty);
  }

  $(document).on('change','.distributor_type,.distributor',function(){ 
    //alert("ok");
    $('.divtable').show();  
    var ob_type_id          =   $('.distributor_type').val();
    var distributor_id      =   $('.distributor').val();
    if(distributor_id != '' && ob_type_id != '')
    {
        $.ajax({
        type:"POST",
        url:SITE_URL+'get_dist_pending_dos',
        data:{ob_type_id:ob_type_id,distributor_id:distributor_id},
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