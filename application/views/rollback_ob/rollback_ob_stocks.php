<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <?php
                    if($flag==1)
                    {
                      ?>
                      <form id="dd_date_form" method="post" action="<?php echo SITE_URL.'rollback_ob_stocks';?>" class="form-horizontal">
                        <div class="row ">  
                            <div class="col-md-offset-3 col-md-5"> 
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Enter OB Number</label>
                                    <div class="col-md-7">
                                        <input type="text" name="order_number" class="form-control numeric"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-5"></div>
                                        <div class="col-md-6">
                                            <input type="submit" class="btn blue tooltips"  value="Proceed" name="submit">
                                            <a href="<?php echo SITE_URL;?>" class="btn default">Cancel</a>
                                        </div>                                 
                                </div>
                            </div>
                        </div>
                    </form><?php  
                    } 
                    if($flag==2)
                    { 
                      //echo "<pre>"; print_r($dd_list); exit;
                       ?>
                       <form id="dd_date_form" method="post" action="<?php echo SITE_URL.'insert_rollback_ob_stocks';?>" class="form-horizontal">
                            <input type="hidden" name="order_id" value="<?php echo $results[0]['order_id']; ?>">
                            <input type="hidden" name="order_number" value="<?php echo $results[0]['order_number']; ?>">
                            <input type="hidden" name="distributor_code" value="<?php echo $results[0]['distributor_code'] ?>">
                            <input type="hidden" name="old_distributor_id" value="<?php echo $results[0]['distributor_id']; ?>"> 
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">OB Number :</label>
                                        <div class="col-md-6">
                                            <b class="form-control-static"><?php echo  $results[0]['order_number'] ;?></b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Order Booking Date :</label>
                                        <div class="col-md-6">
                                            <b class="form-control-static"><?php echo  date('d-m-Y', strtotime($results[0]['order_date']));?></b>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Distributor Name :</label>
                                        <div class="col-md-6">
                                            <b class="form-control-static"><?php echo  $results[0]['agency_name'].'['.$results[0]['distributor_code'].']' ;?></b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Stock Lifting Point :</label>
                                        <div class="col-md-6">
                                            <b class="form-control-static"><?php echo  $results[0]['plant_name'] ;?></b>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                               <div class="row">
                                 <div class="col-md-7">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Remarks</label>
                                        <div class="col-md-7">
                                            <textarea name="remarks" class="form-control" required></textarea>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-scrollable">
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <th> S.No</th>
                                                <th> Product </th>
                                                <th> Ordered Qty </th>
                                                <th> Pending Qty </th>
                                                <th> Price </th>
                                                <th> Amount </th>
                                            </thead>
                                            <tbody>
                                            <?php
                                                $sn=1;
                                                $total=0;
                                                if(@$results)
                                                {

                                                foreach(@$results as $row)
                                                    {  
                                                    $amount= $row['pending_qty']*($row['unit_price']+$row['add_price'])*$row['items_per_carton']; 
                                                    $total+=$amount;                                 
                                                ?>
                                                <tr>
                                                    <td><?php echo $sn++;?></td>
                                                    <td><?php echo $row['product_name'];?> </td>
                                                    <td><?php echo $row['quantity'];?> </td>
                                                    <td><?php echo $row['pending_qty'];?> </td>
                                                    <td><?php echo $row['add_price']+$row['unit_price'] ?></td>
                                                    <td><?php echo $amount; ?></td>
                                                    
                                                </tr>
                                                <?php
                                                    } ?>
                                                <tr>
                                                    <td colspan="6" align="right"><b>Total Amount: <?php echo $total; ?></b></td>
                                                </tr>
                                                <?php
                                                }
                                                else
                                                {
                                                    ?> <tr><td colspan="6" align="center"> No Records Found</td></tr>      
                                        <?php   }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Select Product </label>
                                        <div class="col-md-5">
                                            <select  class="form-control select2 product_cls" name="product_id" >
                                                <option selected value="">-Select Product Code-</option>
                                                <?php 
                                                    foreach($results as $row)
                                                    {
                                                        echo '<option value="'.$row['product_id'].'" data-qty="'.@$row['quantity'].'" >'.$row['short_name'].'</option>';
                                                        
                                                    }
                                                ?>
                                            </select> 
                                            <input type="hidden" class="qty_cls" name ="old_stock" value="">
                                        </div>
                                    </div>    
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Enter New Stock </label>
                                        <div class="col-md-3">
                                            <input type="text" name="new_stock" class="form-control numeric">
                                        </div>
                                    </div>
                                </div>    
                            </div>
                                <div class="row">
                                    <div class="col-md-offset-5 col-md-6">
                                        <button type="submit" class="btn blue"  name="submit">Submit</button>
                                        <a href="<?php echo SITE_URL.'ob_stocks';?>" class="btn default">Cancel</a>
                                    </div>
                                </div>
                        </form><?php
                    }?>
                    
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer', $nestedView); ?>    
<script type="text/javascript">
    $(document).on('change','.product_cls',function(){
    
    var qty = parseInt($('.product_cls option:selected').data('qty'));
    //var c_id = ele.find($(this)).find('option:selected').data('c-type1');
    //alert(c_id);   
    //ele.find(".capacity1_cls").val(c_id); 
    //alert(qty);
    $(".qty_cls").val(qty);    
});
</script>            