<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="row">
    <form class="form-horizontal" action="<?php echo SITE_URL;?>submit_plant_do" method="post">
        <div class="col-md-12">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                       <!--  <i class="fa fa-gift"></i> --> DO Products</div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"> </a>
                    </div>
                </div>
                <div class="portlet-body">                          
                 <input type="hidden" name="lifting_point_id" value="<?php echo @$lifting_point_id?>">
                 <input type="hidden" name="ordered_plant_id" value="<?php echo @$ordered_plant_id?>">
                 <input type="hidden" name="lifting_point_name" value="<?php echo @$lifting_point_name?>">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-xs-6 control-label">DO Number</label>
                                <div class="col-xs-5">
                                    <p class="form-control-static"><b><?php echo @$do_number; ?></b></p>
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
                                <label class="col-xs-5 control-label">Lifting Point</label>
                                <div class="col-xs-7">
                                    <p class="form-control-static"><b><?php echo @$lifting_point_name; ?></b></p>
                                </div>
                            </div>
                        </div>
                    </div>                
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-scrollable">
                                <table class="table table-bordered"> 
                                    <tr style="background-color:#cccfff">
                                        <td>S No</td>
                                        <td>Product Name</td>                                                
                                        <td>Price</td>
                                        <td>No of Cartons</td>
                                        <td>No of Packets</td>
                                        <td>Qty in Kgs</td>                                               
                                        <td>Amount</td>
                                    </tr>
                                    <tbody>
                                    <?php 
                                    $sno = 1;$total_amount = 0;
                                    foreach($do_products as $op_key => $dp_row)
                                    { 
                                         ?>

                                         <input class="ob_product" name="order_product[]" value="<?php echo $dp_row['order_id']."_" . $dp_row['product_id']?>" type="hidden">
                                                <input type="hidden" class="price" name="price[<?php echo $dp_row['order_id']?>][<?php echo $dp_row['product_id']?>]" value="<?php echo $dp_row['price'];?>">
                                                <input type="hidden" class="items_per_carton" name="items_per_carton[<?php echo $dp_row['order_id']?>][<?php echo $dp_row['product_id']?>]" value="<?php echo $dp_row['items_per_carton']?>">
                                                <input type="hidden" name="ordered_qty[<?php echo $dp_row['order_id']?>][<?php echo $dp_row['product_id']?>]" value="<?php echo @$dp_row['ordered_qty']?>">
                                                <input type="hidden" name="pending_qty[<?php echo $dp_row['order_id']?>][<?php echo $dp_row['product_id']?>]" value="<?php echo @$dp_row['pending_qty']?>">
                                                <input type="hidden" name="lifting_qty[<?php echo $dp_row['order_id']?>][<?php echo $dp_row['product_id']?>]" value="<?php echo @$dp_row['lifting_qty']?>">
                                            <tr class="do_row">                                         
                                            <td>
                                                <?php echo $sno++?>
                                            </td>
                                            <td><?php echo $dp_row['product_name']; ?></td>
                                            <td align="right"><?php echo price_format($dp_row['price']); ?></td>
                                            <td align="right"><?php echo ($dp_row['lifting_qty']); ?></td>
                                            <td align="right">
                                                <?php 
                                                $total_items = $dp_row['lifting_qty']*$dp_row['items_per_carton']; 
                                                echo $total_items;
                                                ?>
                                            </td>
                                            <td align="right"><?php echo $total_items*$dp_row['oil_weight']; ?></td>
                                            <td align="right">
                                                <?php 
                                                $amount = $total_items*$dp_row['price'];
                                                echo price_format($amount); 
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                        $total_amount += $amount;
                                    }
                                    ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6" align="right"><strong>Total Amount:</strong></td>
                                            <td><?php echo price_format($total_amount);?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-offset-5 col-md-5">
                            <button type="submit" name="proceed_plant_do" onclick="return confirm('Are you sure you want to Place D.O?')" class="btn btn-success" value="1">Place DO</button>
                            <a href="<?php echo SITE_URL.'plant_do';?>" class="btn default">Cancel</a>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </form>
    </div>
</div>

<?php $this->load->view('commons/main_footer', $nestedView); ?>