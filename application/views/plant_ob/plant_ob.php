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
                                <form class="form-horizontal" action="<?php echo SITE_URL;?>plant_ob_products" method="post">                         
                                    <div class="form-group">
                                        <label class="col-xs-5 control-label">Order For</label>
                                        <div class="col-xs-7">
                                            <select name="order_plant" class="form-control ordered_plant">
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
                                            <select name="lifting_point" class="form-control lifting_point_id">
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
        <?php if(@$flag == 2) { 
                $c_and_f_id = c_and_f_id();
                if(@$block_id == $c_and_f_id){ ?>
                <div class="col-xs-12">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-bank"></i> Bank Guarantee </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                            </div>
                        </div>
                        <div class="portlet-body">                           
                              <table class="table table-striped table-bordered table-hover order-column table-fixed" id="sample_1">
                                <thead style="display:table;table-layout:fixed;width:100%">
                                    <tr>
                                        <th> S.No</th>
                                        <th> Start Date </th>
                                        <th> Expire Date </th> 
                                        <th> Bank </th>
                                        <th> BG Amount </th>             
                                    </tr>
                                </thead>
                                <tbody style="display:block;height:80px;table-layout:fixed;overflow:auto">
                                <?php $sn = 1;
                                    foreach($bank_gurantee_details as $row) { ?>
                                    <tr style="display:table;width:100%;table-layout:fixed">
                                        <td><?php echo $sn++?></td>
                                        <td><?php echo date('d-m-Y',strtotime($row['start_date'])); ?></td>
                                        <td><?php echo date('d-m-Y',strtotime($row['end_date'])); ?></td>
                                        <td><?php echo $row['bank_name']; ?></td>
                                        <td><?php echo indian_format_price($row['bg_amount']); ?></td>
                                    </tr>                                   
                                <?php } ?>
                                <tr style="display:table;width:100%;table-layout:fixed">
                                        <td colspan="5" align="right"><b>Total BG Amount:</b> &nbsp; <?php echo indian_format_price($total_bg_amount) ?></td></tr>
                                </tbody>
                                <tfoot>
                                    <tr style="display:table;width:100%;table-layout:fixed">
                                       
                                        <td colspan="6" align="right">SD Amount: &nbsp;<?php echo indian_format_price(@$bank_gurantee_amount_details[0]['sd_amount'])?></td>
                                        <td colspan="2" align="right"><b>Available Amount:</b> &nbsp; <?php  echo indian_format_price($total_bg_amount+@$bank_gurantee_amount_details[0]['sd_amount']) ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                           <!--  <p align="right"><b>Available Amount:</b> &nbsp; <?php echo indian_format_price($available_amount) ?></p> -->
                        </div> 
                    </div>
                </div>
                
               <?php }
            ?>
        <form class="form-horizontal" action="<?php echo SITE_URL;?>confirm_plant_ob_products" method="post">                         
        <div class="col-xs-12">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                       <!--  <i class="fa fa-gift"></i> --> Product Details</div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"> </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="panel-group accordion" id="accordion3">
                    <input type="hidden" name="order_plant_id" value="<?php echo @$order_plant_id?>">
                     <input type="hidden" name="lifting_point_id" value="<?php echo @$lifting_point_id?>">
                    <?php 
                    //echo '<pre>'; print_r($product_results);
                    if(count($product_results)>0) { 
                        foreach ($product_results as $key =>$value)
                        { 
                            if(count(@$value['sub_products'])>0)
                            { 
                                $sno=1; 
                            ?>
                            
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <input type="hidden" name="loose_oil_id[<?php echo $key; ?>]" value="<?php echo $key; ?>">
                                        <input type="hidden" name="loose_oil_name[<?php echo $key; ?>]" value="<?php echo $value['loose_oil_name'];; ?>">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_<?php echo $key; ?>"> <b><?php echo $value['loose_oil_name']; ?></b> </a>
                                        </h4>
                                    </div>
                                    <div id="collapse_3_<?php echo $key; ?>" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <table class="table table-bordered" cellspacing="0" cellpadding="5" border="0" style="padding-left:50px;">
                                                <tr style="background-color:#ccc">
                                                    <td><b>SNO</b></td>                             
                                                    <th>Product Name</th>
                                                    <th>
                                                        <span style="margin-left:20px">Price</span>
                                                        <span class="<?php echo ($_SESSION['block_id']==1)?'':'hidden';?>">
                                                            <span style="margin-left:36px">+</span>
                                                            <span style="margin-left:5px">Added Price</span>
                                                            <span style="margin-left:2px">=</span>
                                                            <span style="margin-left:10px">Total</span>
                                                        </span>
                                                        <span style="margin-left:60px">MRP</span>
                                                    </th>                                                    
                                                    <th>Ordered Qty <span style="margin-left:10px">*</span> <span style="margin-left:10px">No of Items</span></th>
                                                    <th>Ordered Value</th>
                                                </tr>
                                                <tbody>
                                                <?php 
                                                foreach(@$value['sub_products'] as $keys =>$values)
                                                { 
                                                    if($values != '') { 
                                                        $regular_type_id    = get_regular_type_id();
                                                        $mrp_type_id        = get_mrp_type_id();
                                                        $unit_price = get_unit_mrp_price($lifting_point_id,$values['product_id'],$regular_type_id);
                                                        $mrp_price = get_unit_mrp_price($lifting_point_id,$values['product_id'],$mrp_type_id);
                                                        ?>
                                                    <tr class="trow">
                                                        <!-- <input type="hidden" name="ob_type_id" value="<?php //echo @$order_type_id?>">
                                                        <input type="hidden" name="ob_type" value="<?php //echo @$order_type?>"> -->
                                                        <input type="hidden" name="lifting_point_name" value="<?php echo @$lifting_point_name?>">
                                                        <input type="hidden" name="items_per_carton[<?php echo $values['product_id'];?>]" id="items_per_carton" value="<?php echo $values['items_per_carton']?>">
                                                        <input type="hidden" name="product_name[<?php echo $values['product_id'];?>]" value="<?php echo $values['name']?>">
                                                        <input type="hidden" name="product_id[<?php echo $values['product_id'];?>]" value="<?php echo $values['product_id']?>">
                                                        
                                                        <input class="total_amountt" name="total_amount[<?php echo @$values['product_id'];?>]" style="width:100px"  type="hidden" >
                                                        
                                                        <input class="total_valuee" name="total_value[<?php echo $values['product_id'];?>]" style="width:80px"  type="hidden" >
                                                        
                                                        <td><?php echo  $sno++; ?></td>
                                                        <td><?php echo $values['name']; ?></td>
                                                        <td>                                                   
                                                            <input type="text" name="unit_price[<?php echo @$values['product_id'];?>]" style="width:90px" class="unit_price" value="<?php echo @$unit_price; ?>" readonly>
                                                            <span class="<?php echo ($_SESSION['block_id']==1)?'':'hidden';?>">
                                                             + 
                                                            <input id="" name="added_price[<?php echo $values['product_id'];?>]"  value="0" class="added_price" style="width:90px" type="text"> = 
                                                            <input id=""  class="total_amount" style="width:100px" value="<?php echo (@$unit_price != '')?$unit_price:0.00; ?>"  type="text" disabled="">
                                                            </span>
                                                             &nbsp; <?php  echo @$mrp_price; ?>
                                                        </td>
                                                        <td>    <input class="numeric quantity" name="quantity[<?php echo $values['product_id'];?>]"  onkeyup="javascript:this.value=Comma(this.value);" id=""  style="width:90px" type="text"> &nbsp;  <span> * &nbsp; <?php echo $values['items_per_carton'];?></span>
                                                        </td>
                                                        <td>    <input class="numeric total_value" style="width:80px"  type="text" disabled="">
                                                                
                                                        </td>

                                                    </tr>
                                                <?php } 
                                                    else{ 
                                                    ?>
                                                    <tr><td colspan="4">No Products Available</td></tr>
                                                <?php }
                                                 } // end of products loop
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                    <?php 
                            } // end of if sub products >0 check
                        }  // end of loose oil loop

                    } // end of if product_resutls>o check
                    ?>
                    </div>
                    <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <button class="btn green submitPlantOB" type="submit" name="submitPlantOB" onclick="return confirm('Are you sure you want to Proceed?')" value="button">Proceed OB</button>
                        <a href="<?php echo SITE_URL.'plant_ob';?>" class="btn default">Cancel</a>
                    </div>
                    <div class="col-md-2"><p class="total_qty"> </p></div>
                    <div class="col-md-2"><input type="hidden" id="grand_total" name="grand_total"><p class="grand_total"> </p></div>
                </div>
                </div>
            </div>
        </div>
        </form>
        <?php } ?>
    </div>
</div>

<?php $this->load->view('commons/main_footer', $nestedView); ?>

<!-- Get Distributors Based on Selected Distributer Type -->
<script type="text/javascript">
    
    $(document).on('blur','.quantity,.added_price',function(){ 
        var ele_panel_body=$(this).closest('.trow'); 
        var unit_price=ele_panel_body.find('.unit_price').val(); 
        var added_price=parseFloat(ele_panel_body.find('.added_price').val());  
        //var total_price_quantity=$('.total_value').val();
        if(isNaN(unit_price)) {
        var unit_price = 0;
        }
        if(isNaN(added_price)) {
        var added_price = 0;
        }
        var total_amount=parseFloat(unit_price) + parseFloat(added_price);
        total_amount = total_amount.toFixed(2);     
        var items_per_carton=ele_panel_body.find('#items_per_carton').val(); 
        var view_quantity=ele_panel_body.find('.quantity').val();
        if(isNaN(view_quantity)) {
        var view_quantity = 0;
        } 
        var actual_quantity = view_quantity * items_per_carton;
        //var total_amount=ele_panel_body.find('.total_amount').val(); 
        var total_price_quantity = (actual_quantity * total_amount).toFixed(2);
        ele_panel_body.find('.total_amount').val(total_amount);
        ele_panel_body.find('.total_amountt').val(total_amount);
        ele_panel_body.find('.total_value').val(total_price_quantity);
        ele_panel_body.find('.total_valuee').val(total_price_quantity);
        //alert(total_price_quantity
        var grand_total=0;
          $('.total_value').each(function(){
            if($(this).val()!='')
            grand_total += parseFloat($(this).val());

          });
          grand_total = grand_total.toFixed(2);
        var total_ordered_qty = 0;
        $('.quantity').each(function(){
            if($(this).val()!='')
            total_ordered_qty += parseFloat($(this).val());

          });
        $('.total_qty').html( '<b>Total Ordered Qty:</b> '+total_ordered_qty);
        $('#grand_total').val(grand_total);
        $('.grand_total').html( '<b>Grand Total:</b> '+grand_total);
    });
    
    $('.distributor_type').change(function(){
    var ob_type_id = $(this).val();
   // alert(distributor_type_id);
    if(ob_type_id=='')
    {
        $('.distributor').html('<option value="">-Select Distributor</option');
        
    }
    else
    {
        // display commission textbox if ob type is Institutional/CST Institutional
        switch(ob_type_id)
        {
            case '2': case '4':
                $('#commission_block').removeClass('hidden');
            break;
            default:
                $('#commission_block').addClass('hidden');
                $('#commission').val('');
            break;
        }
        //if welfare scheme ob
        if(ob_type_id=='5')
        {
            $('#welfare_block').removeClass('hidden');
        }
        else
        {
            $('#welfare_block').addClass('hidden');
            $('#welfare_scheme option').prop('selected',false); 
        }
        //alert(ob_type_id);
        $.ajax({
            type:"POST",
            url:SITE_URL+'getDistributors',
            data:{ob_type_id:ob_type_id},
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

$(document).on('change','.ordered_plant',function(){ 
    $('.divtable').show();
    var ordered_plant      =   $('.ordered_plant').val();
    //var lifting_point_id    =   $('.lifting_point_id').val();
    //alert(lifting_point_id);
    if(ordered_plant != '')
    {
        $.ajax({
        type:"POST",
        url:SITE_URL+'get_plant_pending_obs',
        data:{ordered_plant_id:ordered_plant},
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